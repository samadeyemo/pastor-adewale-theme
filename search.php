<?php
/**
 * Search results.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$kinds = array( 'teaching' => __( 'Teaching', 'pastor-adewale' ), 'resource' => __( 'Download', 'pastor-adewale' ), 'course' => __( 'Bible School', 'pastor-adewale' ), 'testimony' => __( 'Testimony', 'pastor-adewale' ), 'outreach' => __( 'Outreach', 'pastor-adewale' ), 'post' => __( 'News', 'pastor-adewale' ), 'page' => __( 'Page', 'pastor-adewale' ) );
get_template_part( 'template-parts/pagehead', null, array( 'title' => sprintf( /* translators: %s: search term */ __( 'Search: %s', 'pastor-adewale' ), get_search_query() ), 'desc' => '', 'crumbs' => array( array( __( 'Search', 'pastor-adewale' ), '' ) ), 'extra' => get_search_form( array( 'echo' => false ) ) ) );
?>
<div class="wrap section">
	<?php if ( have_posts() ) : ?>
		<div class="rsults" style="margin-bottom:40px">
			<?php while ( have_posts() ) : the_post(); $pt = get_post_type(); ?>
				<a class="rres" href="<?php the_permalink(); ?>"><span><b><?php the_title(); ?></b><small><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></small></span><span class="kind"><?php echo esc_html( isset( $kinds[ $pt ] ) ? $kinds[ $pt ] : $pt ); ?></span></a>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination( array( 'prev_text' => '‹', 'next_text' => '›' ) ); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Nothing matches that. Try a topic such as prayer, faith or Bible study.', 'pastor-adewale' ); ?></p>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
