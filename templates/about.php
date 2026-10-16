<?php
/**
 * Template Name: About (with contents bar)
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/pagehead', null, array( 'title' => get_the_title(), 'desc' => has_excerpt() ? get_the_excerpt() : __( 'Teaching the Bible and sharing the life-changing power of God\'s Word with people who need biblical truth.', 'pastor-adewale' ), 'crumbs' => array( array( __( 'About', 'pastor-adewale' ), '' ) ) ) );
	?>
	<div class="toc" id="pageToc" hidden><div class="wrap"></div></div>
	<div class="wrap" style="padding:40px 0 80px"><div class="entry-content"><?php the_content(); ?></div></div>
	<?php
endwhile;
get_footer();
