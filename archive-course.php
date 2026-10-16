<?php
/**
 * Bible School courses.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
?>
<div class="wrap">
	<div class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'pastor-adewale' ); ?></a> / <a href="<?php echo esc_url( pa_url( 'resources' ) ); ?>"><?php esc_html_e( 'Resources', 'pastor-adewale' ); ?></a> / <?php esc_html_e( 'Bible School', 'pastor-adewale' ); ?></div>
	<div class="ptitle"><h1><?php esc_html_e( 'Bible School', 'pastor-adewale' ); ?></h1><p><?php esc_html_e( 'Follow organised lessons with Scripture references, study notes and reflection questions. Study at your own pace.', 'pastor-adewale' ); ?></p></div>
	<?php if ( have_posts() ) : ?>
		<div class="grid3"><?php while ( have_posts() ) { the_post(); get_template_part( 'template-parts/card', 'course' ); } ?></div>
		<?php the_posts_pagination( array( 'prev_text' => '‹', 'next_text' => '›' ) ); ?>
	<?php else : ?><p><?php esc_html_e( 'Courses will appear here.', 'pastor-adewale' ); ?></p><?php endif; ?>
	<div class="study" style="margin:40px 0 70px"><div><h2><?php esc_html_e( 'Make space for deeper study.', 'pastor-adewale' ); ?></h2><p><?php esc_html_e( 'Not sure which course to begin with? Ask, and we will point you to the right one.', 'pastor-adewale' ); ?></p></div><a class="btn" href="<?php echo esc_url( pa_url( 'question' ) ); ?>"><?php esc_html_e( 'Ask about a course', 'pastor-adewale' ); ?></a></div>
</div>
<?php get_footer(); ?>
