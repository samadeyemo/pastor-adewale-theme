<?php
/**
 * A single teaching series: ordered lessons, notes and eBook.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$term  = get_queried_object();
$posts = $GLOBALS['wp_query']->posts;
$first = $posts ? get_permalink( $posts[0] ) : '';
$notes = get_term_meta( $term->term_id, 'pa_notes_url', true );
$ntit  = get_term_meta( $term->term_id, 'pa_notes_title', true );
$ebook = get_term_meta( $term->term_id, 'pa_ebook_url', true );
$etit  = get_term_meta( $term->term_id, 'pa_ebook_title', true );
$others = get_terms( array( 'taxonomy' => 'series', 'hide_empty' => true, 'exclude' => array( $term->term_id ), 'number' => 3 ) );
$extra  = '<div class="hero-actions" style="margin-top:24px">';
if ( $first ) {
	$extra .= '<a class="btn btn-gold" href="' . esc_url( $first ) . '">' . esc_html__( 'Start the series', 'pastor-adewale' ) . '</a>';
}
if ( $notes ) {
	$extra .= '<a class="btn btn-ghost" href="' . esc_url( $notes ) . '" download>' . esc_html__( 'Download study notes', 'pastor-adewale' ) . '</a>';
}
$extra .= '</div>';
get_template_part( 'template-parts/pagehead', null, array( 'title' => $term->name, 'desc' => wp_strip_all_tags( $term->description ), 'crumbs' => array( array( __( 'Resources', 'pastor-adewale' ), pa_url( 'resources' ) ), array( __( 'Series', 'pastor-adewale' ), pa_url( 'series' ) ), array( $term->name, '' ) ), 'extra' => $extra ) );
?>
<div class="wrap section"><div class="two uneven">
	<div>
		<h2 style="font-size:32px;margin-bottom:18px"><?php echo esc_html( sprintf( /* translators: %d: lessons */ _n( '%d lesson, in order', '%d lessons, in order', count( $posts ), 'pastor-adewale' ), count( $posts ) ) ); ?></h2>
		<?php foreach ( $posts as $i => $p ) : ?>
			<a class="srow" href="<?php echo esc_url( get_permalink( $p ) ); ?>"><span class="n"><?php echo esc_html( $i + 1 ); ?></span><span><b><?php echo esc_html( get_the_title( $p ) ); ?></b><small><?php echo esc_html( trim( get_post_meta( $p->ID, '_pa_duration', true ) . ' · ' . pa_speaker_name( $p->ID ), ' ·' ) ); ?></small></span><span class="link"><?php esc_html_e( 'Watch', 'pastor-adewale' ); ?></span></a>
		<?php endforeach; ?>
		<?php if ( ! $posts ) : ?><p><?php esc_html_e( 'Lessons will appear here.', 'pastor-adewale' ); ?></p><?php endif; ?>
	</div>
	<aside class="legacy">
		<h3><?php esc_html_e( 'Free with this series', 'pastor-adewale' ); ?></h3>
		<?php if ( $notes ) : ?><div class="dl-row"><div><b><?php echo esc_html( $ntit ? $ntit : __( 'Study notes', 'pastor-adewale' ) ); ?></b><small><?php esc_html_e( 'PDF · for personal or group study', 'pastor-adewale' ); ?></small></div><a class="btn btn-primary sm" href="<?php echo esc_url( $notes ); ?>" download><?php esc_html_e( 'Download', 'pastor-adewale' ); ?></a></div><?php endif; ?>
		<?php if ( $ebook ) : ?><div class="dl-row"><div><b><?php echo esc_html( 'eBook: ' . ( $etit ? $etit : $term->name ) ); ?></b><small><?php esc_html_e( 'Free PDF', 'pastor-adewale' ); ?></small></div><a class="btn btn-primary sm" href="<?php echo esc_url( $ebook ); ?>" download><?php esc_html_e( 'Download', 'pastor-adewale' ); ?></a></div><?php endif; ?>
		<?php if ( ! $notes && ! $ebook ) : ?><p style="color:var(--muted);font-size:14px"><?php esc_html_e( 'Study notes and an eBook for this series will be added soon.', 'pastor-adewale' ); ?></p><?php endif; ?>
		<p style="margin:18px 0 8px;color:var(--muted);font-size:14px"><?php esc_html_e( 'Questions about this series?', 'pastor-adewale' ); ?></p><a class="link" href="<?php echo esc_url( pa_url( 'question' ) ); ?>"><?php esc_html_e( 'Ask a Bible question', 'pastor-adewale' ); ?></a>
	</aside>
</div>
<?php if ( $others && ! is_wp_error( $others ) ) : ?>
	<div class="s-head" style="margin-top:56px"><div><h2><?php esc_html_e( 'Other series', 'pastor-adewale' ); ?></h2></div></div>
	<div class="grid3" style="margin-bottom:60px"><?php foreach ( $others as $o ) { get_template_part( 'template-parts/card-series', null, array( 'term' => $o ) ); } ?></div>
<?php endif; ?>
</div>
<?php get_footer(); ?>
