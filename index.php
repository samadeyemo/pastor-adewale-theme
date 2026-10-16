<?php
/**
 * Fallback and News (posts page) template.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$is_news = is_home();
?>
<div class="wrap">
	<div class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'pastor-adewale' ); ?></a> / <?php echo esc_html( $is_news ? __( 'News', 'pastor-adewale' ) : wp_strip_all_tags( get_the_archive_title() ) ); ?></div>
	<div class="ptitle"><h1><?php echo esc_html( $is_news ? __( 'News', 'pastor-adewale' ) : wp_strip_all_tags( get_the_archive_title() ) ); ?></h1><p><?php echo esc_html( $is_news ? __( 'Ministry updates, teaching releases, courses and prayer needs.', 'pastor-adewale' ) : wp_strip_all_tags( get_the_archive_description() ) ); ?></p></div>
	<?php
	$cats = get_categories( array( 'hide_empty' => true, 'exclude' => array( (int) get_option( 'default_category' ) ) ) );
	if ( $is_news && $cats ) :
		?>
		<div class="toolbar"><div class="filters"><a class="filter active" href="<?php echo esc_url( pa_url( 'news' ) ); ?>"><?php esc_html_e( 'All news', 'pastor-adewale' ); ?></a><?php foreach ( $cats as $c ) : ?><a class="filter" href="<?php echo esc_url( get_category_link( $c ) ); ?>"><?php echo esc_html( $c->name ); ?></a><?php endforeach; ?></div></div>
	<?php endif; ?>
	<?php if ( have_posts() ) : ?>
		<div class="grid3" style="margin-bottom:40px">
			<?php
			while ( have_posts() ) {
				the_post();
				$pt = get_post_type();
				get_template_part( 'template-parts/card', in_array( $pt, array( 'teaching', 'resource', 'course', 'testimony' ), true ) ? $pt : null );
			}
			?>
		</div>
		<?php the_posts_pagination( array( 'prev_text' => '‹', 'next_text' => '›' ) ); ?>
	<?php else : ?><p><?php esc_html_e( 'Nothing here yet.', 'pastor-adewale' ); ?></p><?php endif; ?>
	<div style="height:60px"></div>
</div>
<?php get_footer(); ?>
