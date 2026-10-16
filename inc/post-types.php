<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function pa_register_content() {
	$common = array( 'show_in_rest' => true, 'show_in_nav_menus' => true );

	register_post_type(
		'teaching',
		array_merge(
			$common,
			array(
				'labels'       => array(
					'name'          => __( 'Teachings', 'pastor-adewale' ),
					'singular_name' => __( 'Teaching', 'pastor-adewale' ),
					'add_new_item'  => __( 'Add New Teaching', 'pastor-adewale' ),
					'edit_item'     => __( 'Edit Teaching', 'pastor-adewale' ),
					'all_items'     => __( 'All Teachings', 'pastor-adewale' ),
				),
				'public'       => true,
				'has_archive'  => 'teachings',
				'rewrite'      => array( 'slug' => 'teaching', 'with_front' => false ),
				'menu_icon'    => 'dashicons-video-alt3',
				'menu_position' => 5,
				'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			)
		)
	);

	register_post_type(
		'resource',
		array_merge(
			$common,
			array(
				'labels'      => array(
					'name'          => __( 'Books & Downloads', 'pastor-adewale' ),
					'singular_name' => __( 'Book / Download', 'pastor-adewale' ),
					'add_new_item'  => __( 'Add New Book or Download', 'pastor-adewale' ),
				),
				'public'      => true,
				'has_archive' => 'books',
				'rewrite'     => array( 'slug' => 'book', 'with_front' => false ),
				'menu_icon'   => 'dashicons-book-alt',
				'menu_position' => 6,
				'supports'    => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			)
		)
	);

	register_post_type(
		'course',
		array_merge(
			$common,
			array(
				'labels'      => array(
					'name'          => __( 'Bible School', 'pastor-adewale' ),
					'singular_name' => __( 'Course', 'pastor-adewale' ),
					'add_new_item'  => __( 'Add New Course', 'pastor-adewale' ),
				),
				'public'      => true,
				'has_archive' => 'bible-school',
				'rewrite'     => array( 'slug' => 'course', 'with_front' => false ),
				'menu_icon'   => 'dashicons-welcome-learn-more',
				'menu_position' => 7,
				'supports'    => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			)
		)
	);

	register_post_type(
		'testimony',
		array_merge(
			$common,
			array(
				'labels'      => array(
					'name'          => __( 'Testimonies', 'pastor-adewale' ),
					'singular_name' => __( 'Testimony', 'pastor-adewale' ),
					'add_new_item'  => __( 'Add New Testimony', 'pastor-adewale' ),
				),
				'public'      => true,
				'has_archive' => 'testimonies',
				'rewrite'     => array( 'slug' => 'testimony', 'with_front' => false ),
				'menu_icon'   => 'dashicons-format-quote',
				'menu_position' => 8,
				'supports'    => array( 'title', 'editor' ),
			)
		)
	);

	register_post_type(
		'outreach',
		array_merge(
			$common,
			array(
				'labels'      => array(
					'name'          => __( 'Outreach Stories', 'pastor-adewale' ),
					'singular_name' => __( 'Outreach Story', 'pastor-adewale' ),
					'add_new_item'  => __( 'Add New Outreach Story', 'pastor-adewale' ),
				),
				'public'      => true,
				'has_archive' => 'outreach-stories',
				'rewrite'     => array( 'slug' => 'outreach-story', 'with_front' => false ),
				'menu_icon'   => 'dashicons-megaphone',
				'menu_position' => 9,
				'supports'    => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			)
		)
	);

	register_post_type(
		'qa',
		array(
			'labels'             => array(
				'name'          => __( 'Answered Questions', 'pastor-adewale' ),
				'singular_name' => __( 'Answered Question', 'pastor-adewale' ),
				'add_new_item'  => __( 'Add Answered Question', 'pastor-adewale' ),
			),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-editor-help',
			'menu_position'      => 10,
			'supports'           => array( 'title', 'editor' ),
		)
	);

	register_post_type(
		'hero_slide',
		array(
			'labels'             => array(
				'name'          => __( 'Home Slides', 'pastor-adewale' ),
				'singular_name' => __( 'Home Slide', 'pastor-adewale' ),
				'add_new_item'  => __( 'Add Home Slide', 'pastor-adewale' ),
			),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-images-alt2',
			'menu_position'      => 11,
			'supports'           => array( 'title', 'excerpt', 'thumbnail', 'page-attributes' ),
		)
	);

	// Private inbox for forms, subscribers and donations. Never public.
	register_post_type(
		'submission',
		array(
			'labels'              => array(
				'name'          => __( 'Inbox', 'pastor-adewale' ),
				'singular_name' => __( 'Submission', 'pastor-adewale' ),
				'all_items'     => __( 'All submissions', 'pastor-adewale' ),
				'edit_item'     => __( 'View submission', 'pastor-adewale' ),
			),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_rest'        => false,
			'menu_icon'           => 'dashicons-email-alt',
			'menu_position'       => 12,
			'supports'            => array( 'title', 'editor' ),
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'capabilities'        => array( 'create_posts' => 'do_not_allow' ),
		)
	);

	// Taxonomies.
	register_taxonomy(
		'series',
		'teaching',
		array(
			'labels'            => array( 'name' => __( 'Series', 'pastor-adewale' ), 'singular_name' => __( 'Series', 'pastor-adewale' ), 'add_new_item' => __( 'Add New Series', 'pastor-adewale' ) ),
			'public'            => true,
			'hierarchical'      => false,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'series', 'with_front' => false ),
		)
	);
	register_taxonomy(
		'topic',
		array( 'teaching', 'testimony', 'resource' ),
		array(
			'labels'            => array( 'name' => __( 'Topics', 'pastor-adewale' ), 'singular_name' => __( 'Topic', 'pastor-adewale' ), 'add_new_item' => __( 'Add New Topic', 'pastor-adewale' ) ),
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'topic', 'with_front' => false ),
		)
	);
	register_taxonomy(
		'speaker',
		'teaching',
		array(
			'labels'            => array( 'name' => __( 'Speakers', 'pastor-adewale' ), 'singular_name' => __( 'Speaker', 'pastor-adewale' ), 'add_new_item' => __( 'Add New Speaker', 'pastor-adewale' ) ),
			'public'            => true,
			'hierarchical'      => false,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'speaker', 'with_front' => false ),
		)
	);
	register_taxonomy(
		'resource_type',
		'resource',
		array(
			'labels'            => array( 'name' => __( 'Resource Types', 'pastor-adewale' ), 'singular_name' => __( 'Resource Type', 'pastor-adewale' ) ),
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'resource-type', 'with_front' => false ),
		)
	);
}
add_action( 'init', 'pa_register_content' );

/** Library filters from the query string (own query vars avoid template clashes). */
function pa_query_vars( $vars ) {
	return array_merge( $vars, array( 'pa_q', 'pa_topic', 'pa_series', 'pa_speaker', 'pa_year', 'pa_type' ) );
}
add_filter( 'query_vars', 'pa_query_vars' );

function pa_library_query( $q ) {
	if ( is_admin() || ! $q->is_main_query() ) {
		return;
	}

	if ( $q->is_post_type_archive( 'teaching' ) ) {
		$q->set( 'posts_per_page', 12 );
		$tax = array();
		foreach ( array( 'topic' => 'pa_topic', 'series' => 'pa_series', 'speaker' => 'pa_speaker' ) as $taxonomy => $var ) {
			$val = $q->get( $var );
			if ( $val ) {
				$tax[] = array( 'taxonomy' => $taxonomy, 'field' => 'slug', 'terms' => sanitize_title( $val ) );
			}
		}
		if ( $tax ) {
			$q->set( 'tax_query', $tax );
		}
		$year = (int) $q->get( 'pa_year' );
		if ( $year > 1900 && $year < 2200 ) {
			$q->set( 'date_query', array( array( 'year' => $year ) ) );
		}
		$s = $q->get( 'pa_q' );
		if ( $s ) {
			$q->set( 's', sanitize_text_field( $s ) );
		}
	}

	if ( $q->is_post_type_archive( 'resource' ) ) {
		$q->set( 'posts_per_page', 12 );
		$type = $q->get( 'pa_type' );
		if ( $type ) {
			$q->set( 'tax_query', array( array( 'taxonomy' => 'resource_type', 'field' => 'slug', 'terms' => sanitize_title( $type ) ) ) );
		}
		$s = $q->get( 'pa_q' );
		if ( $s ) {
			$q->set( 's', sanitize_text_field( $s ) );
		}
	}

	if ( $q->is_post_type_archive( 'testimony' ) ) {
		$q->set( 'posts_per_page', 12 );
		$topic = $q->get( 'pa_topic' );
		if ( $topic ) {
			$q->set( 'tax_query', array( array( 'taxonomy' => 'topic', 'field' => 'slug', 'terms' => sanitize_title( $topic ) ) ) );
		}
	}

	if ( $q->is_post_type_archive( 'course' ) ) {
		$q->set( 'posts_per_page', 12 );
		$q->set( 'orderby', array( 'menu_order' => 'ASC', 'date' => 'DESC' ) );
	}

	// A series page lists every lesson, in lesson order.
	if ( $q->is_tax( 'series' ) ) {
		$q->set( 'posts_per_page', -1 );
		$q->set( 'meta_key', '_pa_order' );
		$q->set( 'orderby', array( 'meta_value_num' => 'ASC', 'date' => 'ASC' ) );
	}

	// Site search should stay on public content.
	if ( $q->is_search() ) {
		$q->set( 'post_type', array( 'post', 'teaching', 'resource', 'course', 'testimony', 'outreach', 'page' ) );
	}
}
add_action( 'pre_get_posts', 'pa_library_query' );

/** Flush rewrites when the theme is activated (needs the types registered first). */
function pa_after_switch() {
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'pa_after_switch', 5 );
