<?php
/**
 * Teaching library: search plus topic, series, speaker and year filters.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$base     = get_post_type_archive_link( 'teaching' );
$topic    = pa_get( 'pa_topic' );
$tids     = get_posts( array( 'post_type' => 'teaching', 'posts_per_page' => -1, 'fields' => 'ids', 'no_found_rows' => true ) );
$topics   = $tids ? wp_get_object_terms( $tids, 'topic' ) : array();
$series   = get_terms( array( 'taxonomy' => 'series', 'hide_empty' => true ) );
$speakers = get_terms( array( 'taxonomy' => 'speaker', 'hide_empty' => true ) );
$years    = pa_teaching_years();
$active   = (bool) ( $topic || pa_get( 'pa_series' ) || pa_get( 'pa_speaker' ) || pa_get( 'pa_year' ) || pa_get( 'pa_q' ) );
global $wp_query;
?>
<div class="wrap">
	<div class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'pastor-adewale' ); ?></a> / <a href="<?php echo esc_url( pa_url( 'resources' ) ); ?>"><?php esc_html_e( 'Resources', 'pastor-adewale' ); ?></a> / <?php esc_html_e( 'Video library', 'pastor-adewale' ); ?></div>
	<div class="ptitle"><h1><?php esc_html_e( 'Teachings for your journey', 'pastor-adewale' ); ?></h1><p><?php esc_html_e( 'Search the library, or narrow it by topic, series, speaker and year.', 'pastor-adewale' ); ?></p></div>

	<form method="get" action="<?php echo esc_url( $base ); ?>" id="libForm">
		<label class="bigsearch" style="margin-bottom:22px"><?php echo pa_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span class="screen-reader-text"><?php esc_html_e( 'Search teachings', 'pastor-adewale' ); ?></span><input type="search" name="pa_q" value="<?php echo esc_attr( pa_get( 'pa_q' ) ); ?>" placeholder="<?php esc_attr_e( 'Search by title, topic or series', 'pastor-adewale' ); ?>"></label>
		<?php if ( $topic ) : ?><input type="hidden" name="pa_topic" value="<?php echo esc_attr( $topic ); ?>"><?php endif; ?>
		<div class="toolbar">
			<div class="filters">
				<a class="filter<?php echo $topic ? '' : ' active'; ?>" href="<?php echo pa_filter_url( $base, array( 'pa_topic' => '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>"><?php esc_html_e( 'All topics', 'pastor-adewale' ); ?></a>
				<?php if ( $topics && ! is_wp_error( $topics ) ) : foreach ( $topics as $t ) : ?>
					<a class="filter<?php echo $topic === $t->slug ? ' active' : ''; ?>" href="<?php echo pa_filter_url( $base, array( 'pa_topic' => $t->slug ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>"><?php echo esc_html( $t->name ); ?></a>
				<?php endforeach; endif; ?>
			</div>
			<div class="selects">
				<select name="pa_series" data-autosubmit aria-label="<?php esc_attr_e( 'Series', 'pastor-adewale' ); ?>"><option value=""><?php esc_html_e( 'All series', 'pastor-adewale' ); ?></option><?php if ( $series && ! is_wp_error( $series ) ) : foreach ( $series as $t ) : ?><option value="<?php echo esc_attr( $t->slug ); ?>" <?php selected( pa_get( 'pa_series' ), $t->slug ); ?>><?php echo esc_html( $t->name ); ?></option><?php endforeach; endif; ?></select>
				<select name="pa_speaker" data-autosubmit aria-label="<?php esc_attr_e( 'Speaker', 'pastor-adewale' ); ?>"><option value=""><?php esc_html_e( 'All speakers', 'pastor-adewale' ); ?></option><?php if ( $speakers && ! is_wp_error( $speakers ) ) : foreach ( $speakers as $t ) : ?><option value="<?php echo esc_attr( $t->slug ); ?>" <?php selected( pa_get( 'pa_speaker' ), $t->slug ); ?>><?php echo esc_html( $t->name ); ?></option><?php endforeach; endif; ?></select>
				<select name="pa_year" data-autosubmit aria-label="<?php esc_attr_e( 'Year', 'pastor-adewale' ); ?>"><option value=""><?php esc_html_e( 'All years', 'pastor-adewale' ); ?></option><?php foreach ( $years as $y ) : ?><option value="<?php echo esc_attr( $y ); ?>" <?php selected( (int) pa_get( 'pa_year' ), $y ); ?>><?php echo esc_html( $y ); ?></option><?php endforeach; ?></select>
				<noscript><button class="btn btn-primary sm" type="submit"><?php esc_html_e( 'Apply', 'pastor-adewale' ); ?></button></noscript>
				<?php if ( $active ) : ?><a class="clear" href="<?php echo esc_url( $base ); ?>"><?php esc_html_e( 'Clear filters', 'pastor-adewale' ); ?></a><?php endif; ?>
			</div>
		</div>
	</form>

	<p class="fnote" style="margin-bottom:16px"><?php echo esc_html( sprintf( /* translators: %d: number of teachings */ _n( '%d teaching', '%d teachings', (int) $wp_query->found_posts, 'pastor-adewale' ), (int) $wp_query->found_posts ) ); ?></p>

	<?php if ( have_posts() ) : ?>
		<div class="grid3" style="margin-bottom:40px"><?php while ( have_posts() ) { the_post(); get_template_part( 'template-parts/card', 'teaching' ); } ?></div>
		<?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => '‹', 'next_text' => '›' ) ); ?>
	<?php else : ?>
		<p class="empty" style="display:block"><?php esc_html_e( 'No teachings match. Try another word, or clear the filters.', 'pastor-adewale' ); ?></p>
	<?php endif; ?>
	<div style="height:60px"></div>
</div>
<?php get_footer(); ?>
