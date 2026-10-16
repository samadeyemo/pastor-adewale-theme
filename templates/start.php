<?php
/**
 * Template Name: Start Here
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$first_series = get_terms( array( 'taxonomy' => 'series', 'hide_empty' => true, 'number' => 2, 'orderby' => 'term_id' ) );
$s1 = ( $first_series && ! is_wp_error( $first_series ) && isset( $first_series[0] ) ) ? get_term_link( $first_series[0] ) : get_post_type_archive_link( 'teaching' );
$s2 = ( $first_series && ! is_wp_error( $first_series ) && isset( $first_series[1] ) ) ? get_term_link( $first_series[1] ) : get_post_type_archive_link( 'teaching' );
get_template_part( 'template-parts/pagehead', null, array( 'title' => get_the_title(), 'desc' => __( 'New to the Bible, or coming back after a long time? Follow these four steps in order, or jump to the one you need.', 'pastor-adewale' ), 'crumbs' => array( array( __( 'Start here', 'pastor-adewale' ), '' ) ) ) );
$arrow = pa_icon( 'arrow' );
?>
<div class="wrap section">
	<div class="steps">
		<div class="step"><span class="no">1</span><h3><?php esc_html_e( 'Know Jesus and the basics', 'pastor-adewale' ); ?></h3><p><?php esc_html_e( 'A step-by-step series on the core truths of the Christian faith, with study notes for every lesson.', 'pastor-adewale' ); ?></p><div class="links"><a class="link" href="<?php echo esc_url( $s1 ); ?>"><?php esc_html_e( 'Begin the first series', 'pastor-adewale' ); ?> <?php echo $arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></a></div></div>
		<div class="step"><span class="no">2</span><h3><?php esc_html_e( 'Learn to pray', 'pastor-adewale' ); ?></h3><p><?php esc_html_e( 'Practical teaching to build a steady, Scripture-shaped prayer life, one lesson at a time.', 'pastor-adewale' ); ?></p><div class="links"><a class="link" href="<?php echo esc_url( add_query_arg( 'pa_topic', 'prayer', get_post_type_archive_link( 'teaching' ) ) ); ?>"><?php esc_html_e( 'Teachings on prayer', 'pastor-adewale' ); ?> <?php echo $arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></a></div></div>
		<div class="step"><span class="no">3</span><h3><?php esc_html_e( 'Study the Bible for yourself', 'pastor-adewale' ); ?></h3><p><?php esc_html_e( 'Learn to read Scripture in context with guided Bible School lessons and a free study guide.', 'pastor-adewale' ); ?></p><div class="links"><a class="link" href="<?php echo esc_url( get_post_type_archive_link( 'course' ) ); ?>"><?php esc_html_e( 'Bible School', 'pastor-adewale' ); ?> <?php echo $arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></a><a class="link" href="<?php echo esc_url( get_post_type_archive_link( 'resource' ) ); ?>"><?php esc_html_e( 'Free study guides', 'pastor-adewale' ); ?> <?php echo $arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></a></div></div>
		<div class="step"><span class="no">4</span><h3><?php esc_html_e( 'Find support and community', 'pastor-adewale' ); ?></h3><p><?php esc_html_e( 'You do not have to walk alone. Ask a question, request prayer, or read what God is doing in other lives.', 'pastor-adewale' ); ?></p><div class="links"><a class="link" href="<?php echo esc_url( pa_url( 'question' ) ); ?>"><?php esc_html_e( 'Ask a question', 'pastor-adewale' ); ?> <?php echo $arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></a><a class="link" href="<?php echo esc_url( pa_url( 'prayer' ) ); ?>"><?php esc_html_e( 'Request prayer', 'pastor-adewale' ); ?> <?php echo $arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></a><a class="link" href="<?php echo esc_url( get_post_type_archive_link( 'testimony' ) ); ?>"><?php esc_html_e( 'Testimonies', 'pastor-adewale' ); ?> <?php echo $arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></a></div></div>
	</div>
	<?php while ( have_posts() ) : the_post(); if ( get_the_content() ) : ?><div class="entry-content" style="margin-bottom:34px"><?php the_content(); ?></div><?php endif; endwhile; ?>
	<div class="study" style="margin-bottom:70px"><div><h2><?php esc_html_e( 'Take a free eBook with you.', 'pastor-adewale' ); ?></h2><p><?php esc_html_e( 'Subscribe for new teachings and a free eBook to read offline.', 'pastor-adewale' ); ?></p></div><a class="btn" href="<?php echo esc_url( pa_url( 'free-ebook' ) ); ?>"><?php esc_html_e( 'Get the free eBook', 'pastor-adewale' ); ?></a></div>
</div>
<?php get_footer(); ?>
