<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Load Paystack only on the Donate template. */
function pa_paystack_assets() {
	if ( ! is_page_template( 'templates/donate.php' ) ) {
		return;
	}
	$key = pa_opt( 'paystack_public' );
	if ( $key && pa_paystack_secret() ) {
		wp_enqueue_script( 'paystack-inline', 'https://js.paystack.co/v1/inline.js', array(), null, array( 'in_footer' => true ) );
	}
	wp_add_inline_script(
		'pa-main',
		'window.PA_GIVE=' . wp_json_encode(
			array(
				'ajax'     => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'pa_give' ),
				'key'      => $key && pa_paystack_secret() ? $key : '',
				'currency' => 'NGN',
				'thanks'   => __( 'Thank you for your gift. A receipt is on its way from Paystack.', 'pastor-adewale' ),
				'failed'   => __( 'We could not confirm the payment. If you were charged, please contact us with your Paystack reference.', 'pastor-adewale' ),
				'pending'  => __( 'Confirming your payment…', 'pastor-adewale' ),
				'closed'   => __( 'Payment window closed. No charge was made.', 'pastor-adewale' ),
				'invalid'  => __( 'Please enter your name, a valid email and an amount of at least ₦100.', 'pastor-adewale' ),
			)
		) . ';',
		'before'
	);
}
add_action( 'wp_enqueue_scripts', 'pa_paystack_assets', 20 );

/**
 * Confirm a Paystack payment on the server. The amount comes from Paystack's reply,
 * never from the browser, so it cannot be faked from the page.
 */
function pa_verify_donation() {
	check_ajax_referer( 'pa_give', 'nonce' );

	$secret = pa_paystack_secret();
	$ref    = isset( $_POST['reference'] ) ? preg_replace( '/[^A-Za-z0-9._=-]/', '', wp_unslash( $_POST['reference'] ) ) : '';
	$name   = isset( $_POST['name'] ) ? mb_substr( sanitize_text_field( wp_unslash( $_POST['name'] ) ), 0, 120 ) : '';
	if ( ! $secret || ! $ref ) {
		wp_send_json_error( array( 'message' => __( 'Payments are not set up yet.', 'pastor-adewale' ) ), 400 );
	}

	$dupe = get_posts( array( 'post_type' => 'submission', 'post_status' => 'any', 'posts_per_page' => 1, 'fields' => 'ids', 'meta_query' => array( array( 'key' => '_pa_ref', 'value' => $ref ) ) ) );
	if ( $dupe ) {
		wp_send_json_success( array( 'message' => __( 'This payment was already recorded. Thank you.', 'pastor-adewale' ) ) );
	}

	$res = wp_remote_get(
		'https://api.paystack.co/transaction/verify/' . rawurlencode( $ref ),
		array( 'timeout' => 20, 'headers' => array( 'Authorization' => 'Bearer ' . $secret ) )
	);
	if ( is_wp_error( $res ) || 200 !== wp_remote_retrieve_response_code( $res ) ) {
		wp_send_json_error( array( 'message' => __( 'Could not reach Paystack to confirm the payment.', 'pastor-adewale' ) ), 502 );
	}
	$body = json_decode( wp_remote_retrieve_body( $res ), true );
	$data = isset( $body['data'] ) ? $body['data'] : array();
	if ( empty( $body['status'] ) || ! isset( $data['status'] ) || 'success' !== $data['status'] || ( isset( $data['currency'] ) && 'NGN' !== $data['currency'] ) || empty( $data['amount'] ) || (int) $data['amount'] < 10000 ) {
		wp_send_json_error( array( 'message' => __( 'The payment was not completed.', 'pastor-adewale' ) ), 402 );
	}

	$amount = (float) $data['amount'] / 100;
	$email  = isset( $data['customer']['email'] ) ? sanitize_email( $data['customer']['email'] ) : '';
	$id     = wp_insert_post(
		array(
			'post_type'   => 'submission',
			'post_status' => 'publish',
			'post_title'  => sprintf( /* translators: 1: amount 2: name */ __( 'Gift of %1$s from %2$s', 'pastor-adewale' ), pa_money( $amount ), $name ? $name : $email ),
		)
	);
	if ( $id && ! is_wp_error( $id ) ) {
		update_post_meta( $id, '_pa_type', 'donation' );
		update_post_meta( $id, '_pa_amount', $amount );
		update_post_meta( $id, '_pa_ref', $ref );
		update_post_meta( $id, '_pa_status', 'success' );
		update_post_meta( $id, '_pa_name', $name );
		update_post_meta( $id, '_pa_email', $email );
		pa_notify( sprintf( __( 'Gift received: %s', 'pastor-adewale' ), pa_money( $amount ) ), "Name: {$name}\nEmail: {$email}\nAmount: " . pa_money( $amount ) . "\nReference: {$ref}", $email );
	}
	wp_send_json_success( array( 'message' => __( 'Thank you for your gift.', 'pastor-adewale' ) ) );
}
add_action( 'wp_ajax_pa_verify_donation', 'pa_verify_donation' );
add_action( 'wp_ajax_nopriv_pa_verify_donation', 'pa_verify_donation' );
