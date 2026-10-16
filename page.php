<?php
/**
 * Default page.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/pagehead', null, array( 'title' => get_the_title(), 'desc' => has_excerpt() ? get_the_excerpt() : '', 'crumbs' => array( array( get_the_title(), '' ) ) ) );
	?>
	<div class="wrap" style="padding:40px 0 80px"><div class="entry-content"><?php the_content(); ?></div></div>
	<?php
endwhile;
get_footer();
