<?php
/**
 * Pastor Adewale theme bootstrap.
 *
 * @package pastor-adewale
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PA_VER', '1.0.0' );
define( 'PA_DIR', get_template_directory() );
define( 'PA_URI', get_template_directory_uri() );

foreach ( array( 'helpers', 'post-types', 'meta-boxes', 'settings', 'forms', 'paystack', 'seo', 'setup' ) as $pa_file ) {
	require_once PA_DIR . '/inc/' . $pa_file . '.php';
}

/** Theme supports and menus. */
function pa_setup() {
	load_theme_textdomain( 'pastor-adewale', PA_DIR . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 80, 'flex-width' => true, 'flex-height' => true ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_image_size( 'pa-card', 640, 400, true );
	register_nav_menus(
		array(
			'primary'       => __( 'Primary (header)', 'pastor-adewale' ),
			'menu_explore'  => __( 'Menu overlay: Explore', 'pastor-adewale' ),
			'menu_about'    => __( 'Menu overlay: About', 'pastor-adewale' ),
			'menu_involved' => __( 'Menu overlay: Get involved', 'pastor-adewale' ),
			'menu_contact'  => __( 'Menu overlay: Contact', 'pastor-adewale' ),
			'footer_legal'  => __( 'Footer: legal links', 'pastor-adewale' ),
		)
	);
}
add_action( 'after_setup_theme', 'pa_setup' );

/** Remove comments support on the post types this theme registers. */
function pa_disable_comments() {
	foreach ( array( 'post', 'page' ) as $pt ) {
		remove_post_type_support( $pt, 'comments' );
		remove_post_type_support( $pt, 'trackbacks' );
	}
}
add_action( 'init', 'pa_disable_comments', 20 );
add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );

/** Front-end assets. */
function pa_assets() {
	wp_enqueue_style( 'pa-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap', array(), null );
	wp_enqueue_style( 'pa-style', get_stylesheet_uri(), array( 'pa-fonts' ), filemtime( PA_DIR . '/style.css' ) );
	wp_enqueue_script( 'pa-main', PA_URI . '/assets/js/main.js', array(), filemtime( PA_DIR . '/assets/js/main.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
	wp_localize_script(
		'pa-main',
		'PA',
		array(
			'rest'   => esc_url_raw( rest_url( 'wp/v2/search' ) ),
			'home'   => esc_url_raw( home_url( '/' ) ),
			'labels' => array(
				'noResults' => __( 'No matches. Try a topic like prayer or faith.', 'pastor-adewale' ),
				'copied'    => __( 'Link copied', 'pastor-adewale' ),
				'copyHint'  => __( 'Press Ctrl+C to copy the link', 'pastor-adewale' ),
				'resume'    => __( 'Resume', 'pastor-adewale' ),
				'continue'  => __( 'Continue watching', 'pastor-adewale' ),
				'lesson'    => __( 'Lesson', 'pastor-adewale' ),
				'of'        => __( 'of', 'pastor-adewale' ),
				'focus'     => __( 'Focus mode', 'pastor-adewale' ),
				'exitFocus' => __( 'Exit focus mode', 'pastor-adewale' ),
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'pa_assets' );

/** Preconnect for Google Fonts. */
function pa_resource_hints( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'pa_resource_hints', 10, 2 );

/** Body classes used by the stylesheet. */
function pa_body_class( $classes ) {
	if ( is_singular( 'teaching' ) ) {
		$classes[] = 'watching';
	}
	return $classes;
}
add_filter( 'body_class', 'pa_body_class' );

/** Keep the Resources menu item highlighted for library pages. */
function pa_nav_active( $classes, $item ) {
	$res = pa_page_id( 'resources' );
	if ( $res && (int) $item->object_id === $res && 'page' === $item->object ) {
		if ( is_singular( array( 'teaching', 'resource', 'course' ) ) || is_post_type_archive( array( 'teaching', 'resource', 'course' ) ) || is_tax( array( 'series', 'topic', 'speaker', 'resource_type' ) ) ) {
			$classes[] = 'current-menu-ancestor';
		}
	}
	$about = pa_page_id( 'about' );
	if ( $about && (int) $item->object_id === $about && 'page' === $item->object ) {
		if ( is_singular( 'testimony' ) || is_post_type_archive( 'testimony' ) || is_page( 'pastor' ) ) {
			$classes[] = 'current-menu-ancestor';
		}
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'pa_nav_active', 10, 2 );

/** Excerpt tidy-up. */
add_filter( 'excerpt_more', '__return_empty_string' );
add_filter( 'excerpt_length', function () {
	return 28;
}, 99 );

/** Remove emoji scripts (small speed win). */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
