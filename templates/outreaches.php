<?php
/**
 * Template Name: Outreaches
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$stories = new WP_Query( array( 'post_type' => 'outreach', 'posts_per_page' => 6, 'no_found_rows' => true ) );
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/pagehead', null, array( 'title' => get_the_title(), 'desc' => __( 'Reaching people with the Word and equipping them to make disciples, through practical initiatives that make a real difference.', 'pastor-adewale' ), 'crumbs' => array( array( __( 'Outreaches', 'pastor-adewale' ), '' ) ) ) );
	?>
	<div class="toc" id="pageToc" hidden><div class="wrap"></div></div>
	<div class="wrap" style="padding:40px 0 20px"><div class="entry-content"><?php the_content(); ?></div></div>
	<?php if ( $stories->have_posts() ) : ?>
		<div class="wrap" style="padding:20px 0 20px" id="stories"><h2 style="font-size:clamp(28px,3.4vw,40px);margin-bottom:22px"><?php esc_html_e( 'Outreach stories', 'pastor-adewale' ); ?></h2>
			<div class="grid3"><?php while ( $stories->have_posts() ) { $stories->the_post(); get_template_part( 'template-parts/card' ); } wp_reset_postdata(); ?></div></div>
	<?php endif; ?>
	<div class="wrap" style="padding:40px 0 80px"><div class="study"><div><h2><?php esc_html_e( 'Help carry the Word further.', 'pastor-adewale' ); ?></h2><p><?php esc_html_e( 'Your gift supports teaching, training and translation.', 'pastor-adewale' ); ?></p></div><a class="btn" href="<?php echo esc_url( pa_url( 'donate' ) ); ?>"><?php esc_html_e( 'Donate', 'pastor-adewale' ); ?></a></div></div>
	<?php
endwhile;
get_footer();
