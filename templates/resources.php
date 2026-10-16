<?php
/**
 * Template Name: Resources Hub
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$series = get_terms( array( 'taxonomy' => 'series', 'hide_empty' => true, 'orderby' => 'term_id' ) );
$books  = new WP_Query( array( 'post_type' => 'resource', 'posts_per_page' => 6, 'no_found_rows' => true ) );
$tiles  = array(
	array( __( 'Video library', 'pastor-adewale' ), __( 'Short and extended messages on a wide range of Bible topics.', 'pastor-adewale' ), get_post_type_archive_link( 'teaching' ), 'play' ),
	array( __( 'Teaching series', 'pastor-adewale' ), __( 'Follow a topic from start to finish, with ordered lessons and notes.', 'pastor-adewale' ), pa_url( 'series' ), 'book' ),
	array( __( 'Bible School', 'pastor-adewale' ), __( 'Flexible self-study courses that bring the classroom to you.', 'pastor-adewale' ), get_post_type_archive_link( 'course' ), 'cap' ),
	array( __( 'Books & downloads', 'pastor-adewale' ), __( 'Books, study guides and teaching notes to deepen your understanding.', 'pastor-adewale' ), get_post_type_archive_link( 'resource' ), 'book' ),
	array( __( 'Testimonies', 'pastor-adewale' ), __( 'Stories of what God is doing in the lives of people who study with us.', 'pastor-adewale' ), get_post_type_archive_link( 'testimony' ), 'chat' ),
	array( __( 'Ask a Bible question', 'pastor-adewale' ), __( 'Send a question and read answers to common questions about Scripture.', 'pastor-adewale' ), pa_url( 'question' ), 'pray' ),
);
get_template_part(
	'template-parts/pagehead',
	null,
	array(
		'title'  => get_the_title(),
		'desc'   => __( 'Read, listen and watch. Search the whole library, or follow a series from start to finish.', 'pastor-adewale' ),
		'crumbs' => array( array( __( 'Resources', 'pastor-adewale' ), '' ) ),
		'extra'  => '<form role="search" method="get" action="' . esc_url( home_url( '/' ) ) . '" class="bigsearch" style="margin-top:26px">' . pa_icon( 'search' ) . '<label class="screen-reader-text" for="resSearch">' . esc_html__( 'Search resources', 'pastor-adewale' ) . '</label><input id="resSearch" type="search" name="s" placeholder="' . esc_attr__( 'Search teachings, series, courses and books', 'pastor-adewale' ) . '"></form>',
	)
);
?>
<div class="section" style="padding-bottom:0"><div class="wrap"><div class="startband"><div><h2><?php esc_html_e( 'Not sure where to begin?', 'pastor-adewale' ); ?></h2><p><?php esc_html_e( 'Take the four-step Start Here pathway. It points you to the right series for where you are.', 'pastor-adewale' ); ?></p></div><a class="btn btn-gold" href="<?php echo esc_url( pa_url( 'start' ) ); ?>"><?php esc_html_e( 'Start here', 'pastor-adewale' ); ?></a></div></div></div>

<?php if ( $series && ! is_wp_error( $series ) ) : ?>
<div class="section"><div class="wrap">
	<div class="s-head"><div><h2><?php esc_html_e( 'Browse by series', 'pastor-adewale' ); ?></h2><p><?php esc_html_e( 'Ordered lessons, with study notes and a free eBook for each series.', 'pastor-adewale' ); ?></p></div><a class="link" href="<?php echo esc_url( pa_url( 'series' ) ); ?>"><?php esc_html_e( 'All series', 'pastor-adewale' ); ?> <?php echo pa_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></div>
	<div class="grid3"><?php foreach ( $series as $term ) { get_template_part( 'template-parts/card-series', null, array( 'term' => $term ) ); } ?></div>
</div></div>
<?php endif; ?>

<?php if ( $books->have_posts() ) : ?>
<div class="section band"><div class="wrap">
	<div class="s-head"><div><h2><?php esc_html_e( 'Free downloads', 'pastor-adewale' ); ?></h2></div><a class="link" href="<?php echo esc_url( get_post_type_archive_link( 'resource' ) ); ?>"><?php esc_html_e( 'Browse all', 'pastor-adewale' ); ?> <?php echo pa_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></div>
	<div class="scroller"><?php while ( $books->have_posts() ) { $books->the_post(); get_template_part( 'template-parts/card-resource', null, array( 'variant' => 'book' ) ); } wp_reset_postdata(); ?></div>
</div></div>
<?php endif; ?>

<div class="section"><div class="wrap">
	<div class="s-head"><div><h2><?php esc_html_e( 'Study the Bible', 'pastor-adewale' ); ?></h2></div></div>
	<div class="grid3">
		<?php foreach ( $tiles as $t ) : ?>
			<a class="fcard" href="<?php echo esc_url( $t[2] ); ?>"><?php echo pa_icon( $t[3] ); // phpcs:ignore WordPress.Security.EscapeOutput ?><h3><?php echo esc_html( $t[0] ); ?></h3><p><?php echo esc_html( $t[1] ); ?></p><span class="link"><?php esc_html_e( 'Explore', 'pastor-adewale' ); ?> <?php echo pa_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></a>
		<?php endforeach; ?>
	</div>
</div></div>
<?php get_footer(); ?>
