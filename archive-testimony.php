<?php
/**
 * Testimonies, filterable by topic.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$base   = get_post_type_archive_link( 'testimony' );
$topic  = pa_get( 'pa_topic' );
$ids    = get_posts( array( 'post_type' => 'testimony', 'posts_per_page' => -1, 'fields' => 'ids' ) );
$topics = $ids ? wp_get_object_terms( $ids, 'topic' ) : array();
get_template_part(
	'template-parts/pagehead',
	null,
	array(
		'title'  => __( 'Testimonies', 'pastor-adewale' ),
		'desc'   => __( 'Stories of what God is doing in the lives of people who study His Word with us.', 'pastor-adewale' ),
		'crumbs' => array( array( __( 'About', 'pastor-adewale' ), pa_url( 'about' ) ), array( __( 'Testimonies', 'pastor-adewale' ), '' ) ),
	)
);
?>
<div class="wrap section" style="padding-bottom:30px">
	<?php if ( $topics && ! is_wp_error( $topics ) ) : ?>
		<div class="toolbar"><div class="filters">
			<a class="filter<?php echo $topic ? '' : ' active'; ?>" href="<?php echo esc_url( $base ); ?>"><?php esc_html_e( 'All stories', 'pastor-adewale' ); ?></a>
			<?php foreach ( $topics as $t ) : ?><a class="filter<?php echo $topic === $t->slug ? ' active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'pa_topic', $t->slug, $base ) ); ?>"><?php echo esc_html( $t->name ); ?></a><?php endforeach; ?>
		</div></div>
	<?php endif; ?>
	<?php if ( have_posts() ) : ?>
		<div class="grid3" style="margin-bottom:40px"><?php while ( have_posts() ) { the_post(); get_template_part( 'template-parts/card-testimony' ); } ?></div>
		<?php the_posts_pagination( array( 'prev_text' => '‹', 'next_text' => '›' ) ); ?>
	<?php else : ?><p><?php esc_html_e( 'No stories yet. Be the first to share what God has done.', 'pastor-adewale' ); ?></p><?php endif; ?>
</div>
<div class="wrap" style="margin-bottom:70px"><div class="study"><div><h2><?php esc_html_e( 'Has God done something in your life?', 'pastor-adewale' ); ?></h2><p><?php esc_html_e( 'Your story may encourage someone else. The ministry team reviews every submission before it appears.', 'pastor-adewale' ); ?></p></div><span style="display:flex;gap:10px;flex-wrap:wrap"><a class="btn" href="<?php echo esc_url( pa_url( 'story' ) ); ?>"><?php esc_html_e( 'Share your story', 'pastor-adewale' ); ?></a><a class="btn" style="background:transparent;border:1px solid currentColor;color:inherit" href="<?php echo esc_url( pa_url( 'prayer' ) ); ?>"><?php esc_html_e( 'Request prayer', 'pastor-adewale' ); ?></a></span></div></div>
<?php get_footer(); ?>
