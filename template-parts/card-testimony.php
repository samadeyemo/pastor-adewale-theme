<?php
/** Testimony card. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$who   = get_post_meta( get_the_ID(), '_pa_who', true );
$topic = pa_topic_name( get_the_ID() );
?>
<article class="qcard">
	<?php if ( $topic ) : ?><span class="tag-pill"><?php echo esc_html( $topic ); ?></span><?php endif; ?>
	<div class="qm" style="margin-top:14px">“</div>
	<blockquote><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_content() ), 45 ) ); ?></blockquote>
	<div class="qby"><?php echo esc_html( ( $who ? $who : __( 'A visitor', 'pastor-adewale' ) ) . ' · ' . __( 'Shared with permission', 'pastor-adewale' ) ); ?></div>
</article>
