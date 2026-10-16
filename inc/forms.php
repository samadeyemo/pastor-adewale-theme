<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Open a form: nonce, honeypot, time token, redirect. Echoes the opening tags. */
function pa_current_url() {
	global $wp;
	$url = home_url( add_query_arg( array(), $wp->request ? $wp->request . '/' : '' ) );
	return remove_query_arg( array( 'pa_sent', 'pa_error', 'pa_for' ), $url );
}

function pa_form_open( $type, $class = '', $id = '' ) {
	$ts  = time();
	$sig = wp_hash( $ts . '|' . $type );
	$id  = $id ? $id : 'pa-form-' . $type;
	echo '<form class="form ' . esc_attr( $class ) . '" id="' . esc_attr( $id ) . '" method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	echo '<input type="hidden" name="action" value="pa_submit">';
	echo '<input type="hidden" name="pa_type" value="' . esc_attr( $type ) . '">';
	wp_nonce_field( 'pa_form_' . $type, 'pa_nonce' );
	echo '<input type="hidden" name="pa_ts" value="' . esc_attr( $ts ) . '"><input type="hidden" name="pa_sig" value="' . esc_attr( $sig ) . '">';
	echo '<input type="hidden" name="pa_redirect" value="' . esc_url( pa_current_url() ) . '">';
	echo '<div class="pa-hp" aria-hidden="true"><label>Website <input type="text" name="pa_website" tabindex="-1" autocomplete="off"></label></div>';
}

function pa_form_notice( $type ) {
	$sent = pa_get( 'pa_sent' );
	$err  = pa_get( 'pa_error' );
	$for  = pa_get( 'pa_for' );
	if ( $for && $for !== $type ) {
		return;
	}
	$ok = array(
		'contact'    => __( 'Thank you. Your message has been sent. We will reply soon.', 'pastor-adewale' ),
		'prayer'     => __( 'We have received your request and will pray with you.', 'pastor-adewale' ),
		'question'   => __( 'Thank you. Your question has been received. We may reply by email or answer it publicly.', 'pastor-adewale' ),
		'story'      => __( 'Thank you for sharing. Your story will appear once the team has reviewed it.', 'pastor-adewale' ),
		'subscriber' => __( 'You are subscribed. Thank you.', 'pastor-adewale' ),
	);
	$errors = array(
		'missing' => __( 'Please fill in the required fields.', 'pastor-adewale' ),
		'email'   => __( 'Please enter a valid email address.', 'pastor-adewale' ),
		'nonce'   => __( 'This page has expired. Please reload it and try again.', 'pastor-adewale' ),
		'time'    => __( 'That was too fast. Please wait a moment and try again.', 'pastor-adewale' ),
		'rate'    => __( 'Too many messages from this connection. Please try again later.', 'pastor-adewale' ),
		'send'    => __( 'Something went wrong while saving. Please try again.', 'pastor-adewale' ),
	);
	if ( $sent === $type && isset( $ok[ $type ] ) ) {
		echo '<div class="pa-notice ok" id="pa-notice" role="status">' . esc_html( $ok[ $type ] ) . '</div>';
	} elseif ( $err && isset( $errors[ $err ] ) ) {
		echo '<div class="pa-notice err" id="pa-notice" role="alert">' . esc_html( $errors[ $err ] ) . '</div>';
	}
}

function pa_redirect_back( $args ) {
	$to = isset( $_POST['pa_redirect'] ) ? esc_url_raw( wp_unslash( $_POST['pa_redirect'] ) ) : home_url( '/' ); // phpcs:ignore WordPress.Security.NonceVerification
	$to = wp_validate_redirect( $to, home_url( '/' ) );
	wp_safe_redirect( add_query_arg( $args, $to ) . '#pa-notice' );
	exit;
}

function pa_client_ip() {
	return isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
}

function pa_notify( $subject, $body, $reply_to = '' ) {
	$to      = pa_opt( 'notify_email', get_option( 'admin_email' ) );
	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( $reply_to && is_email( $reply_to ) ) {
		$headers[] = 'Reply-To: ' . $reply_to;
	}
	$subject = '[' . wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) . '] ' . preg_replace( '/[\r\n]+/', ' ', $subject );
	wp_mail( $to, $subject, $body, $headers );
}

function pa_handle_form() {
	$type    = isset( $_POST['pa_type'] ) ? sanitize_key( wp_unslash( $_POST['pa_type'] ) ) : '';
	$allowed = array( 'contact', 'prayer', 'question', 'story', 'subscriber' );
	if ( ! in_array( $type, $allowed, true ) ) {
		wp_die( esc_html__( 'Invalid form.', 'pastor-adewale' ), 400 );
	}
	$fail = function ( $code ) use ( $type ) {
		pa_redirect_back( array( 'pa_error' => $code, 'pa_for' => $type ) );
	};

	if ( ! isset( $_POST['pa_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pa_nonce'] ) ), 'pa_form_' . $type ) ) {
		$fail( 'nonce' );
	}
	// Honeypot: bots fill the hidden field. Pretend success, store nothing.
	if ( ! empty( $_POST['pa_website'] ) ) {
		pa_redirect_back( array( 'pa_sent' => $type ) );
	}
	$ts  = isset( $_POST['pa_ts'] ) ? absint( $_POST['pa_ts'] ) : 0;
	$sig = isset( $_POST['pa_sig'] ) ? sanitize_text_field( wp_unslash( $_POST['pa_sig'] ) ) : '';
	if ( ! $ts || ! hash_equals( wp_hash( $ts . '|' . $type ), $sig ) ) {
		$fail( 'nonce' );
	}
	$age = time() - $ts;
	if ( $age < 3 ) {
		$fail( 'time' );
	}
	if ( $age > 2 * DAY_IN_SECONDS ) {
		$fail( 'nonce' );
	}
	// Simple rate limit: 5 per hour per visitor and form.
	$rl_key = 'pa_rl_' . md5( pa_client_ip() . $type );
	$count  = (int) get_transient( $rl_key );
	if ( $count >= 5 ) {
		$fail( 'rate' );
	}
	set_transient( $rl_key, $count + 1, HOUR_IN_SECONDS );

	$name    = isset( $_POST['pa_name'] ) ? sanitize_text_field( wp_unslash( $_POST['pa_name'] ) ) : '';
	$email   = isset( $_POST['pa_email'] ) ? sanitize_email( wp_unslash( $_POST['pa_email'] ) ) : '';
	$phone   = isset( $_POST['pa_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['pa_phone'] ) ) : '';
	$topic   = isset( $_POST['pa_topic'] ) ? sanitize_text_field( wp_unslash( $_POST['pa_topic'] ) ) : '';
	$message = isset( $_POST['pa_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['pa_message'] ) ) : '';
	$public  = ! empty( $_POST['pa_public'] ) ? 'yes' : 'no';
	$consent = ! empty( $_POST['pa_consent'] );
	$name    = mb_substr( $name, 0, 120 );
	$message = mb_substr( $message, 0, 5000 );

	if ( $email && ! is_email( $email ) ) {
		$fail( 'email' );
	}

	switch ( $type ) {
		case 'contact':
			if ( '' === $name || '' === $email || '' === $message ) {
				$fail( 'missing' );
			}
			break;
		case 'prayer':
		case 'question':
			if ( '' === $message ) {
				$fail( 'missing' );
			}
			break;
		case 'story':
			if ( '' === $message || ! $consent ) {
				$fail( 'missing' );
			}
			break;
		case 'subscriber':
			if ( '' === $email ) {
				$fail( 'email' );
			}
			$dupe = get_posts( array( 'post_type' => 'submission', 'post_status' => 'any', 'posts_per_page' => 1, 'fields' => 'ids', 'meta_query' => array( array( 'key' => '_pa_type', 'value' => 'subscriber' ), array( 'key' => '_pa_email', 'value' => $email ) ) ) );
			if ( $dupe ) {
				pa_redirect_back( array( 'pa_sent' => 'subscriber', 'pa_for' => 'subscriber' ) );
			}
			break;
	}

	if ( 'story' === $type ) {
		// Stories wait in Pending until the team publishes them.
		$id = wp_insert_post(
			array(
				'post_type'    => 'testimony',
				'post_status'  => 'pending',
				'post_title'   => sprintf( /* translators: %s: name */ __( 'Story from %s', 'pastor-adewale' ), $name ? $name : __( 'a visitor', 'pastor-adewale' ) ),
				'post_content' => $message,
			),
			true
		);
		if ( is_wp_error( $id ) ) {
			$fail( 'send' );
		}
		update_post_meta( $id, '_pa_who', $name ? $name : __( 'A visitor', 'pastor-adewale' ) );
		pa_notify( __( 'New story to review', 'pastor-adewale' ), "A new story is waiting in Testimonies (Pending).\n\nReview it: " . admin_url( 'post.php?post=' . $id . '&action=edit' ) );
		pa_redirect_back( array( 'pa_sent' => 'story', 'pa_for' => 'story' ) );
	}

	$titles = array(
		'contact'    => __( 'Message from', 'pastor-adewale' ),
		'prayer'     => __( 'Prayer request from', 'pastor-adewale' ),
		'question'   => __( 'Question from', 'pastor-adewale' ),
		'subscriber' => __( 'Subscriber', 'pastor-adewale' ),
	);
	$who = $name ? $name : ( $email ? $email : __( 'a visitor', 'pastor-adewale' ) );
	$id  = wp_insert_post(
		array(
			'post_type'    => 'submission',
			'post_status'  => 'publish',
			'post_title'   => $titles[ $type ] . ' ' . $who,
			'post_content' => $message,
		),
		true
	);
	if ( is_wp_error( $id ) ) {
		$fail( 'send' );
	}
	update_post_meta( $id, '_pa_type', $type );
	foreach ( array( '_pa_name' => $name, '_pa_email' => $email, '_pa_phone' => $phone, '_pa_topic' => $topic ) as $k => $v ) {
		if ( '' !== $v ) {
			update_post_meta( $id, $k, $v );
		}
	}
	if ( 'question' === $type || 'prayer' === $type ) {
		update_post_meta( $id, '_pa_public', $public );
	}

	if ( 'subscriber' !== $type ) {
		$body = "From: {$who}\nEmail: {$email}\nPhone: {$phone}\nTopic: {$topic}\nOK to share publicly: {$public}\n\n{$message}\n\nOpen in the Inbox: " . admin_url( 'post.php?post=' . $id . '&action=edit' );
		pa_notify( ucfirst( $type ) . ' · ' . $who, $body, $email );
	}
	pa_redirect_back( array( 'pa_sent' => $type, 'pa_for' => $type ) );
}
add_action( 'admin_post_nopriv_pa_submit', 'pa_handle_form' );
add_action( 'admin_post_pa_submit', 'pa_handle_form' );
