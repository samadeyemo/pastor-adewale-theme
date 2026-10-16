<?php
/**
 * Template Name: Pastor Profile
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/pagehead', null, array( 'title' => pa_pastor_name(), 'desc' => has_excerpt() ? get_the_excerpt() : __( 'Bible teacher and pastor.', 'pastor-adewale' ), 'crumbs' => array( array( __( 'About', 'pastor-adewale' ), pa_url( 'about' ) ), array( pa_pastor_name(), '' ) ) ) );
	?>
	<div class="wrap section"><div class="two">
		<div class="portrait photo" role="img" aria-label="<?php echo esc_attr( pa_pastor_name() ); ?>" style="background-image:url('<?php echo esc_url( pa_photo_url() ); ?>')"></div>
		<div>
			<div class="entry-content"><h2 style="margin-top:0"><?php esc_html_e( 'Life & ministry', 'pastor-adewale' ); ?></h2><?php the_content(); ?></div>
			<p style="margin-top:26px"><a class="btn btn-primary" href="<?php echo esc_url( get_post_type_archive_link( 'teaching' ) ); ?>"><?php esc_html_e( 'Watch his teachings', 'pastor-adewale' ); ?></a> &nbsp; <a class="btn btn-line" href="<?php echo esc_url( get_post_type_archive_link( 'resource' ) ); ?>"><?php esc_html_e( 'Read his books', 'pastor-adewale' ); ?></a></p>
		</div>
	</div></div>
	<?php
endwhile;
get_footer();
