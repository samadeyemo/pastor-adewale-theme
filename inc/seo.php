<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** True when a dedicated SEO plugin is handling meta tags. */
function pa_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' );
}

function pa_meta_description() {
	if ( is_singular() ) {
		$p    = get_queried_object();
		$text = has_excerpt( $p ) ? get_the_excerpt( $p ) : wp_trim_words( wp_strip_all_tags( strip_shortcodes( $p->post_content ) ), 28, '' );
		if ( $text ) {
			return $text;
		}
	}
	if ( is_tax() || is_category() || is_tag() ) {
		$d = term_description();
		if ( $d ) {
			return wp_strip_all_tags( $d );
		}
	}
	if ( is_post_type_archive( 'teaching' ) ) {
		return __( 'Watch Bible teaching videos by topic, series, speaker and year: faith, prayer, Christian living and Bible study.', 'pastor-adewale' );
	}
	if ( is_post_type_archive( 'resource' ) ) {
		return __( 'Download free Christian books, study guides and teaching notes for personal study or your small group.', 'pastor-adewale' );
	}
	if ( is_post_type_archive( 'course' ) ) {
		return __( 'Study Scripture in context with self-paced Bible School lessons, study notes and reflection questions.', 'pastor-adewale' );
	}
	if ( is_post_type_archive( 'testimony' ) ) {
		return __( 'Real stories of faith, answered prayer and changed lives from people who study the Bible with us.', 'pastor-adewale' );
	}
	return get_bloginfo( 'description' );
}

function pa_seo_head() {
	if ( pa_seo_plugin_active() ) {
		return;
	}
	$desc = trim( preg_replace( '/\s+/', ' ', pa_meta_description() ) );
	if ( $desc ) {
		echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	$title = wp_get_document_title();
	$url   = is_singular() ? get_permalink() : home_url( add_query_arg( null, null ) );
	if ( is_singular() && has_post_thumbnail() ) {
		$img = get_the_post_thumbnail_url( null, 'large' );
	} else {
		$img = pa_photo_url();
	}
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	if ( $desc ) {
		echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	echo '<meta property="og:type" content="' . ( is_singular( array( 'post', 'teaching' ) ) ? 'article' : 'website' ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $img ) . '">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
}
add_action( 'wp_head', 'pa_seo_head', 5 );

/** Structured data: Person + WebSite on the home page, VideoObject on a teaching with a video. */
function pa_schema() {
	$graph = array();
	if ( is_front_page() ) {
		$graph[] = array(
			'@type'       => 'Person',
			'name'        => pa_pastor_name(),
			'jobTitle'    => 'Pastor and Bible teacher',
			'image'       => pa_photo_url(),
			'url'         => home_url( '/' ),
			'description' => get_bloginfo( 'description' ),
		);
		$graph[] = array(
			'@type'           => 'WebSite',
			'name'            => get_bloginfo( 'name' ),
			'url'             => home_url( '/' ),
			'potentialAction' => array(
				'@type'       => 'SearchAction',
				'target'      => home_url( '/?s={search_term_string}' ),
				'query-input' => 'required name=search_term_string',
			),
		);
	}
	if ( is_singular( 'teaching' ) ) {
		$vid = pa_youtube_id( get_post_meta( get_the_ID(), '_pa_video', true ) );
		if ( $vid ) {
			$graph[] = array(
				'@type'        => 'VideoObject',
				'name'         => get_the_title(),
				'description'  => pa_meta_description() ? pa_meta_description() : get_the_title(),
				'thumbnailUrl' => array( 'https://i.ytimg.com/vi/' . $vid . '/hqdefault.jpg' ),
				'uploadDate'   => get_the_date( 'c' ),
				'embedUrl'     => 'https://www.youtube-nocookie.com/embed/' . $vid,
			);
		}
	}
	if ( is_singular( 'post' ) ) {
		$graph[] = array(
			'@type'         => 'Article',
			'headline'      => get_the_title(),
			'datePublished' => get_the_date( 'c' ),
			'dateModified'  => get_the_modified_date( 'c' ),
			'author'        => array( '@type' => 'Organization', 'name' => get_bloginfo( 'name' ) ),
			'image'         => has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'large' ) : pa_photo_url(),
		);
	}
	if ( $graph ) {
		echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput
	}
}
add_action( 'wp_head', 'pa_schema', 20 );

add_filter( 'document_title_separator', function () {
	return '|';
} );
