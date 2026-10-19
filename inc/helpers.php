<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Read one value from the ministry settings. */
function pa_opt( $key, $default = '' ) {
	$all = get_option( 'pa_settings', array() );
	return ( is_array( $all ) && isset( $all[ $key ] ) && '' !== $all[ $key ] ) ? $all[ $key ] : $default;
}

/** Look up a page by its slug and return its ID (0 if missing). */
function pa_page_id( $slug ) {
	$p = get_page_by_path( $slug );
	return $p ? (int) $p->ID : 0;
}

/** URL for a starter page, with a sensible fallback. */
function pa_url( $slug ) {
	$id = pa_page_id( $slug );
	return $id ? get_permalink( $id ) : home_url( '/' . $slug . '/' );
}

/** Pastor photo URL (settings image first, bundled file second). */
function pa_photo_url() {
	$id = (int) pa_opt( 'photo_id', 0 );
	if ( $id ) {
		$u = wp_get_attachment_image_url( $id, 'large' );
		if ( $u ) {
			return $u;
		}
	}
	return PA_URI . '/assets/images/pastor.jpg';
}

function pa_pastor_name() {
	return pa_opt( 'pastor_name', 'Pastor Dr Adewale A.B.C. Oluranti' );
}

/** Extract an 11 character YouTube ID from a URL or a bare ID. */
function pa_youtube_id( $input ) {
	$input = trim( (string) $input );
	if ( '' === $input ) {
		return '';
	}
	if ( preg_match( '~^[A-Za-z0-9_-]{11}$~', $input ) ) {
		return $input;
	}
	if ( preg_match( '~(?:youtu\.be/|youtube(?:-nocookie)?\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/))([A-Za-z0-9_-]{11})~', $input, $m ) ) {
		return $m[1];
	}
	return '';
}

/** Teachings in a series, in lesson order. */
function pa_series_posts( $term_id ) {
	return get_posts(
		array(
			'post_type'      => 'teaching',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'tax_query'      => array( array( 'taxonomy' => 'series', 'field' => 'term_id', 'terms' => (int) $term_id ) ),
			'meta_key'       => '_pa_order',
			'orderby'        => array( 'meta_value_num' => 'ASC', 'date' => 'ASC' ),
		)
	);
}

/** First series term of a teaching (or null). */
function pa_post_series( $post_id ) {
	$terms = get_the_terms( $post_id, 'series' );
	return ( $terms && ! is_wp_error( $terms ) ) ? reset( $terms ) : null;
}

function pa_topic_name( $post_id ) {
	$terms = get_the_terms( $post_id, 'topic' );
	return ( $terms && ! is_wp_error( $terms ) ) ? reset( $terms )->name : '';
}

function pa_speaker_name( $post_id ) {
	$terms = get_the_terms( $post_id, 'speaker' );
	return ( $terms && ! is_wp_error( $terms ) ) ? reset( $terms )->name : pa_pastor_name();
}

/** Years that have published teachings, newest first. */
function pa_teaching_years() {
	global $wpdb;
	$rows = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT YEAR(post_date) FROM {$wpdb->posts} WHERE post_type = %s AND post_status = 'publish' ORDER BY 1 DESC", 'teaching' ) );
	return array_map( 'intval', (array) $rows );
}

/** Social links that have been filled in. */
function pa_social() {
	$map   = array(
		'facebook'  => 'Facebook',
		'youtube'   => 'YouTube',
		'instagram' => 'Instagram',
		'x'         => 'X',
		'pinterest' => 'Pinterest',
	);
	$icons = array( 'facebook' => 'fb', 'youtube' => 'yt', 'instagram' => 'ig', 'x' => 'x', 'pinterest' => 'pin2' );
	$out   = array();
	foreach ( $map as $key => $label ) {
		$url = pa_opt( 'social_' . $key );
		if ( $url ) {
			$out[] = array( 'label' => $label, 'url' => $url, 'icon' => $icons[ $key ] );
		}
	}
	return $out;
}

function pa_social_html() {
	$items = pa_social();
	if ( ! $items ) {
		return '';
	}
	$html = '';
	foreach ( $items as $s ) {
		$html .= '<a href="' . esc_url( $s['url'] ) . '" target="_blank" rel="noopener" aria-label="' . esc_attr( $s['label'] ) . '"><svg class="ico"><use href="#i-' . esc_attr( $s['icon'] ) . '"/></svg></a>';
	}
	return $html;
}

function pa_icon( $name, $extra = '' ) {
	return '<svg class="ico ' . esc_attr( $extra ) . '" aria-hidden="true"><use href="#i-' . esc_attr( $name ) . '"/></svg>';
}

/** Tone class 1-6 for a card without an image. */
function pa_tone( $post_id ) {
	return ( (int) $post_id % 6 ) + 1;
}

function pa_money( $amount ) {
	return '₦' . number_format_i18n( (float) $amount );
}

/** Parse the "amount|description" gift tier lines from settings. */
function pa_gift_tiers() {
	$raw   = pa_opt( 'gift_tiers', "5000|Places a Bible study book in the hands of a new believer.\n25000|Records and edits a short teaching video for the library.\n100000|Translates a teaching booklet into a local language." );
	$tiers = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) $raw ) as $line ) {
		$parts = array_map( 'trim', explode( '|', $line, 2 ) );
		if ( ! empty( $parts[0] ) && is_numeric( $parts[0] ) && (float) $parts[0] > 0 ) {
			$tiers[] = array( 'amount' => (float) $parts[0], 'text' => isset( $parts[1] ) ? $parts[1] : '' );
		}
	}
	return array_slice( $tiers, 0, 6 );
}

/** Paystack secret: wp-config constant wins over the settings screen. */
function pa_paystack_secret() {
	return defined( 'PA_PAYSTACK_SECRET' ) && PA_PAYSTACK_SECRET ? PA_PAYSTACK_SECRET : pa_opt( 'paystack_secret' );
}

/** Build a filter URL for the teaching library, keeping other filters. */
function pa_filter_url( $base, $args ) {
	$keep = array( 'pa_q', 'pa_topic', 'pa_series', 'pa_speaker', 'pa_year' );
	$cur  = array();
	foreach ( $keep as $k ) {
		if ( isset( $_GET[ $k ] ) && '' !== $_GET[ $k ] ) { // phpcs:ignore WordPress.Security.NonceVerification
			$cur[ $k ] = sanitize_text_field( wp_unslash( $_GET[ $k ] ) ); // phpcs:ignore WordPress.Security.NonceVerification
		}
	}
	$cur = array_merge( $cur, $args );
	$cur = array_filter( $cur, function ( $v ) {
		return '' !== $v && null !== $v;
	} );
	return esc_url( add_query_arg( $cur, $base ) );
}

function pa_get( $key ) {
	return isset( $_GET[ $key ] ) ? sanitize_text_field( wp_unslash( $_GET[ $key ] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
}

/** Lesson position inside a series: array( index (1-based), total, prev, next ). */
function pa_lesson_nav( $post_id ) {
	$term = pa_post_series( $post_id );
	if ( ! $term ) {
		return null;
	}
	$list = pa_series_posts( $term->term_id );
	$ids  = wp_list_pluck( $list, 'ID' );
	$pos  = array_search( (int) $post_id, array_map( 'intval', $ids ), true );
	if ( false === $pos ) {
		return null;
	}
	return array(
		'term'  => $term,
		'list'  => $list,
		'index' => $pos + 1,
		'total' => count( $list ),
		'prev'  => $pos > 0 ? $list[ $pos - 1 ] : null,
		'next'  => isset( $list[ $pos + 1 ] ) ? $list[ $pos + 1 ] : null,
	);
}

/** Slides for the home hero: editable "Home Slides", or sensible defaults. */
function pa_get_slides() {
	$posts = get_posts( array( 'post_type' => 'hero_slide', 'post_status' => 'publish', 'posts_per_page' => 6, 'orderby' => array( 'menu_order' => 'ASC', 'date' => 'ASC' ) ) );
	$out   = array();
	foreach ( $posts as $p ) {
		$out[] = array(
			'title'     => get_the_title( $p ),
			'eyebrow'   => get_post_meta( $p->ID, '_pa_eyebrow', true ),
			'text'      => has_excerpt( $p ) ? $p->post_excerpt : '',
			'btn_label' => get_post_meta( $p->ID, '_pa_btn_label', true ),
			'btn_url'   => get_post_meta( $p->ID, '_pa_btn_url', true ),
			'use_photo' => (bool) get_post_meta( $p->ID, '_pa_use_photo', true ),
			'image'     => has_post_thumbnail( $p ) ? get_the_post_thumbnail_url( $p, 'large' ) : '',
		);
	}
	if ( $out ) {
		return $out;
	}
	return array(
		array( 'title' => pa_pastor_name(), 'eyebrow' => '🙏 Welcome. Bible teaching for everyday faith.', 'text' => 'Watch full-length messages on faith, prayer and Christian living, taught clearly from Scripture.', 'btn_label' => 'Watch now', 'btn_url' => get_post_type_archive_link( 'teaching' ), 'use_photo' => true, 'image' => '' ),
		array( 'title' => 'Bible School', 'eyebrow' => '🌱 Learn more about the Bible and grow your faith.', 'text' => 'Follow guided lessons with Scripture references, study notes and reflection questions at your own pace.', 'btn_label' => 'Study God\'s Word', 'btn_url' => get_post_type_archive_link( 'course' ), 'use_photo' => false, 'image' => '' ),
		array( 'title' => 'Books & downloads', 'eyebrow' => '📖 Books and guides to take with you.', 'text' => 'Study guides, teaching notes and books for your personal study or small group.', 'btn_label' => 'Browse resources', 'btn_url' => get_post_type_archive_link( 'resource' ), 'use_photo' => false, 'image' => '' ),
		array( 'title' => 'Get a free eBook', 'eyebrow' => '🎁 Start your library for free.', 'text' => 'Subscribe for new teachings and we will send your free eBook.', 'btn_label' => 'Free download', 'btn_url' => pa_url( 'free-ebook' ), 'use_photo' => false, 'image' => '' ),
	);
}
