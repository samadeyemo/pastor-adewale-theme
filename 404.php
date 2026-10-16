<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
get_template_part( 'template-parts/pagehead', null, array( 'title' => __( 'Page not found', 'pastor-adewale' ), 'desc' => __( 'That page may have moved. Try searching, or start from the library.', 'pastor-adewale' ), 'crumbs' => array( array( '404', '' ) ), 'extra' => get_search_form( array( 'echo' => false ) ) ) );
?>
<div class="wrap section"><p><a class="btn btn-primary" href="<?php echo esc_url( get_post_type_archive_link( 'teaching' ) ); ?>"><?php esc_html_e( 'Browse teachings', 'pastor-adewale' ); ?></a> &nbsp; <a class="btn btn-line" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Go home', 'pastor-adewale' ); ?></a></p></div>
<?php get_footer(); ?>
