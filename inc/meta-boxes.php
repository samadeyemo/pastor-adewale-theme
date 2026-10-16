<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Field definitions: key => array( label, type, help ). */
function pa_meta_defs() {
	return array(
		'teaching'   => array(
			'title'  => __( 'Teaching details', 'pastor-adewale' ),
			'fields' => array(
				'_pa_video'    => array( __( 'Video (YouTube link or ID)', 'pastor-adewale' ), 'text', __( 'Paste the YouTube link, e.g. https://www.youtube.com/watch?v=XXXXXXXXXXX. Leave empty if there is no video yet.', 'pastor-adewale' ) ),
				'_pa_duration' => array( __( 'Duration', 'pastor-adewale' ), 'text', __( 'For example: 28 min', 'pastor-adewale' ) ),
				'_pa_order'    => array( __( 'Lesson number in the series', 'pastor-adewale' ), 'number', __( '1 is the first lesson. Used to order the series and the Previous / Next buttons.', 'pastor-adewale' ) ),
				'_pa_notes'    => array( __( 'Study notes for this teaching (PDF link)', 'pastor-adewale' ), 'url', __( 'Optional. Upload the PDF in Media and paste its link. If empty, the series notes are used.', 'pastor-adewale' ) ),
			),
		),
		'resource'   => array(
			'title'  => __( 'Download details', 'pastor-adewale' ),
			'fields' => array(
				'_pa_file'  => array( __( 'File link (PDF)', 'pastor-adewale' ), 'url', __( 'Upload the PDF in Media and paste its link here.', 'pastor-adewale' ) ),
				'_pa_label' => array( __( 'Label', 'pastor-adewale' ), 'text', __( 'For example: PDF · 18 pages', 'pastor-adewale' ) ),
			),
		),
		'course'     => array(
			'title'  => __( 'Course details', 'pastor-adewale' ),
			'fields' => array(
				'_pa_lessons' => array( __( 'Size label', 'pastor-adewale' ), 'text', __( 'For example: 6 lessons · Self-paced', 'pastor-adewale' ) ),
				'_pa_enrol'   => array( __( 'Start / enrol link', 'pastor-adewale' ), 'url', __( 'Optional. Where the Start course button should go. If empty it opens this course page.', 'pastor-adewale' ) ),
			),
		),
		'testimony'  => array(
			'title'  => __( 'Testimony details', 'pastor-adewale' ),
			'fields' => array(
				'_pa_who' => array( __( 'Name or description', 'pastor-adewale' ), 'text', __( 'For example: A Bible School student, or Sister Ada, Ibadan. Only use a name with permission.', 'pastor-adewale' ) ),
			),
		),
		'outreach'   => array(
			'title'  => __( 'Story details', 'pastor-adewale' ),
			'fields' => array(
				'_pa_place' => array( __( 'Place', 'pastor-adewale' ), 'text', __( 'For example: Ibadan', 'pastor-adewale' ) ),
			),
		),
		'hero_slide' => array(
			'title'  => __( 'Slide details', 'pastor-adewale' ),
			'fields' => array(
				'_pa_eyebrow'   => array( __( 'Line above the title', 'pastor-adewale' ), 'text', __( 'A short welcome line. An emoji at the start is fine.', 'pastor-adewale' ) ),
				'_pa_btn_label' => array( __( 'Button text', 'pastor-adewale' ), 'text', '' ),
				'_pa_btn_url'   => array( __( 'Button link', 'pastor-adewale' ), 'url', '' ),
				'_pa_use_photo' => array( __( 'Show the pastor photo on the left', 'pastor-adewale' ), 'checkbox', __( 'Tick for the portrait slide. Otherwise the featured image is used, or a drawn design if there is none. Order slides with the Order box (Page Attributes).', 'pastor-adewale' ) ),
			),
		),
	);
}

function pa_add_meta_boxes() {
	foreach ( pa_meta_defs() as $pt => $def ) {
		add_meta_box( 'pa_' . $pt, $def['title'], 'pa_render_meta_box', $pt, 'normal', 'high', array( 'pt' => $pt ) );
	}
}
add_action( 'add_meta_boxes', 'pa_add_meta_boxes' );

function pa_render_meta_box( $post, $box ) {
	$defs = pa_meta_defs();
	$pt   = $box['args']['pt'];
	wp_nonce_field( 'pa_meta_' . $pt, 'pa_meta_nonce_' . $pt );
	echo '<table class="form-table" role="presentation"><tbody>';
	foreach ( $defs[ $pt ]['fields'] as $key => $f ) {
		$val = get_post_meta( $post->ID, $key, true );
		echo '<tr><th scope="row"><label for="' . esc_attr( $key ) . '">' . esc_html( $f[0] ) . '</label></th><td>';
		if ( 'checkbox' === $f[1] ) {
			echo '<label><input type="checkbox" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="1" ' . checked( $val, '1', false ) . '> ' . esc_html__( 'Yes', 'pastor-adewale' ) . '</label>';
		} else {
			$type = in_array( $f[1], array( 'url', 'number' ), true ) ? $f[1] : 'text';
			echo '<input class="large-text" type="' . esc_attr( $type ) . '" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '">';
		}
		if ( ! empty( $f[2] ) ) {
			echo '<p class="description">' . esc_html( $f[2] ) . '</p>';
		}
		echo '</td></tr>';
	}
	echo '</tbody></table>';
}

function pa_save_meta( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	$pt = get_post_type( $post_id );
	$defs = pa_meta_defs();
	if ( ! isset( $defs[ $pt ] ) ) {
		return;
	}
	if ( ! isset( $_POST[ 'pa_meta_nonce_' . $pt ] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ 'pa_meta_nonce_' . $pt ] ) ), 'pa_meta_' . $pt ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( $defs[ $pt ]['fields'] as $key => $f ) {
		$raw = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		switch ( $f[1] ) {
			case 'url':
				$val = esc_url_raw( $raw );
				break;
			case 'number':
				$val = '' === $raw ? '' : (string) absint( $raw );
				break;
			case 'checkbox':
				$val = $raw ? '1' : '';
				break;
			default:
				$val = sanitize_text_field( $raw );
		}
		if ( '_pa_video' === $key && $val ) {
			$id  = pa_youtube_id( $val );
			$val = $id ? $id : '';
		}
		if ( '' === $val ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $val );
		}
	}
}
add_action( 'save_post', 'pa_save_meta' );

/* ---------- Series term fields (notes PDF and eBook for each series) ---------- */
function pa_series_fields() {
	return array(
		'pa_notes_title' => array( __( 'Study notes title', 'pastor-adewale' ), 'text' ),
		'pa_notes_url'   => array( __( 'Study notes PDF link', 'pastor-adewale' ), 'url' ),
		'pa_ebook_title' => array( __( 'Free eBook title', 'pastor-adewale' ), 'text' ),
		'pa_ebook_url'   => array( __( 'Free eBook PDF link', 'pastor-adewale' ), 'url' ),
	);
}

function pa_series_add_fields() {
	wp_nonce_field( 'pa_series_meta', 'pa_series_nonce' );
	foreach ( pa_series_fields() as $k => $f ) {
		echo '<div class="form-field"><label for="' . esc_attr( $k ) . '">' . esc_html( $f[0] ) . '</label><input type="' . esc_attr( $f[1] ) . '" id="' . esc_attr( $k ) . '" name="' . esc_attr( $k ) . '"></div>';
	}
}
add_action( 'series_add_form_fields', 'pa_series_add_fields' );

function pa_series_edit_fields( $term ) {
	wp_nonce_field( 'pa_series_meta', 'pa_series_nonce' );
	foreach ( pa_series_fields() as $k => $f ) {
		$val = get_term_meta( $term->term_id, $k, true );
		echo '<tr class="form-field"><th scope="row"><label for="' . esc_attr( $k ) . '">' . esc_html( $f[0] ) . '</label></th><td><input type="' . esc_attr( $f[1] ) . '" id="' . esc_attr( $k ) . '" name="' . esc_attr( $k ) . '" value="' . esc_attr( $val ) . '" class="large-text"></td></tr>';
	}
}
add_action( 'series_edit_form_fields', 'pa_series_edit_fields' );

function pa_series_save( $term_id ) {
	if ( ! isset( $_POST['pa_series_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pa_series_nonce'] ) ), 'pa_series_meta' ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_categories' ) ) {
		return;
	}
	foreach ( pa_series_fields() as $k => $f ) {
		$raw = isset( $_POST[ $k ] ) ? wp_unslash( $_POST[ $k ] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		$val = 'url' === $f[1] ? esc_url_raw( $raw ) : sanitize_text_field( $raw );
		if ( '' === $val ) {
			delete_term_meta( $term_id, $k );
		} else {
			update_term_meta( $term_id, $k, $val );
		}
	}
}
add_action( 'created_series', 'pa_series_save' );
add_action( 'edited_series', 'pa_series_save' );

/* ---------- Inbox (submission) admin screen ---------- */
function pa_submission_types() {
	return array(
		'contact'    => __( 'Contact message', 'pastor-adewale' ),
		'prayer'     => __( 'Prayer request', 'pastor-adewale' ),
		'question'   => __( 'Bible question', 'pastor-adewale' ),
		'subscriber' => __( 'Subscriber', 'pastor-adewale' ),
		'donation'   => __( 'Donation', 'pastor-adewale' ),
	);
}

function pa_submission_columns( $cols ) {
	return array(
		'cb'        => $cols['cb'],
		'title'     => __( 'Summary', 'pastor-adewale' ),
		'pa_type'   => __( 'Type', 'pastor-adewale' ),
		'pa_from'   => __( 'From', 'pastor-adewale' ),
		'pa_amount' => __( 'Amount', 'pastor-adewale' ),
		'date'      => $cols['date'],
	);
}
add_filter( 'manage_submission_posts_columns', 'pa_submission_columns' );

function pa_submission_column( $col, $post_id ) {
	if ( 'pa_type' === $col ) {
		$types = pa_submission_types();
		$t     = get_post_meta( $post_id, '_pa_type', true );
		echo esc_html( isset( $types[ $t ] ) ? $types[ $t ] : $t );
	} elseif ( 'pa_from' === $col ) {
		echo esc_html( get_post_meta( $post_id, '_pa_name', true ) );
		$mail = get_post_meta( $post_id, '_pa_email', true );
		if ( $mail ) {
			echo '<br><a href="mailto:' . esc_attr( $mail ) . '">' . esc_html( $mail ) . '</a>';
		}
	} elseif ( 'pa_amount' === $col ) {
		$a = get_post_meta( $post_id, '_pa_amount', true );
		echo $a ? esc_html( pa_money( $a ) ) : '&mdash;';
	}
}
add_action( 'manage_submission_posts_custom_column', 'pa_submission_column', 10, 2 );

function pa_submission_filter_dropdown( $post_type ) {
	if ( 'submission' !== $post_type ) {
		return;
	}
	$cur = isset( $_GET['pa_type'] ) ? sanitize_key( wp_unslash( $_GET['pa_type'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	echo '<select name="pa_type"><option value="">' . esc_html__( 'All types', 'pastor-adewale' ) . '</option>';
	foreach ( pa_submission_types() as $k => $label ) {
		echo '<option value="' . esc_attr( $k ) . '" ' . selected( $cur, $k, false ) . '>' . esc_html( $label ) . '</option>';
	}
	echo '</select>';
}
add_action( 'restrict_manage_posts', 'pa_submission_filter_dropdown' );

function pa_submission_filter_query( $q ) {
	if ( ! is_admin() || ! $q->is_main_query() || 'submission' !== $q->get( 'post_type' ) ) {
		return;
	}
	if ( ! empty( $_GET['pa_type'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		$q->set( 'meta_key', '_pa_type' );
		$q->set( 'meta_value', sanitize_key( wp_unslash( $_GET['pa_type'] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification
	}
}
add_action( 'pre_get_posts', 'pa_submission_filter_query' );

function pa_submission_details_box() {
	add_meta_box(
		'pa_submission_details',
		__( 'Details', 'pastor-adewale' ),
		function ( $post ) {
			$rows = array(
				'_pa_type'    => __( 'Type', 'pastor-adewale' ),
				'_pa_name'    => __( 'Name', 'pastor-adewale' ),
				'_pa_email'   => __( 'Email', 'pastor-adewale' ),
				'_pa_phone'   => __( 'Phone', 'pastor-adewale' ),
				'_pa_topic'   => __( 'Topic', 'pastor-adewale' ),
				'_pa_public'  => __( 'OK to share publicly', 'pastor-adewale' ),
				'_pa_amount'  => __( 'Amount (NGN)', 'pastor-adewale' ),
				'_pa_ref'     => __( 'Paystack reference', 'pastor-adewale' ),
				'_pa_status'  => __( 'Payment status', 'pastor-adewale' ),
			);
			echo '<table class="widefat striped"><tbody>';
			foreach ( $rows as $k => $label ) {
				$v = get_post_meta( $post->ID, $k, true );
				if ( '' !== $v ) {
					echo '<tr><th style="width:200px">' . esc_html( $label ) . '</th><td>' . esc_html( $v ) . '</td></tr>';
				}
			}
			echo '</tbody></table>';
		},
		'submission',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes_submission', 'pa_submission_details_box' );
