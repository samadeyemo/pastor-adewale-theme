<?php
/**
 * Template Name: All Series
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$series = get_terms( array( 'taxonomy' => 'series', 'hide_empty' => false, 'orderby' => 'term_id' ) );
?>
<div class="wrap">
	<div class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'pastor-adewale' ); ?></a> / <a href="<?php echo esc_url( pa_url( 'resources' ) ); ?>"><?php esc_html_e( 'Resources', 'pastor-adewale' ); ?></a> / <?php esc_html_e( 'Series', 'pastor-adewale' ); ?></div>
	<div class="ptitle"><h1><?php esc_html_e( 'Teaching series', 'pastor-adewale' ); ?></h1><p><?php esc_html_e( 'Follow a topic from start to finish. Every series has ordered lessons, study notes and a free eBook.', 'pastor-adewale' ); ?></p></div>
	<?php if ( $series && ! is_wp_error( $series ) ) : ?>
		<div class="grid3" style="margin-bottom:70px"><?php foreach ( $series as $term ) { get_template_part( 'template-parts/card-series', null, array( 'term' => $term ) ); } ?></div>
	<?php else : ?>
		<p style="margin-bottom:70px"><?php esc_html_e( 'No series yet.', 'pastor-adewale' ); ?><?php if ( current_user_can( 'edit_posts' ) ) : ?> <a href="<?php echo esc_url( admin_url( 'edit-tags.php?taxonomy=series&post_type=teaching' ) ); ?>"><?php esc_html_e( 'Add the first series', 'pastor-adewale' ); ?></a><?php endif; ?></p>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
