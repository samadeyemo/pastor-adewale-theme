<?php
/** Teaching card. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$id     = get_the_ID();
$has    = has_post_thumbnail();
$dur    = get_post_meta( $id, '_pa_duration', true );
$video  = pa_youtube_id( get_post_meta( $id, '_pa_video', true ) );
$series = pa_post_series( $id );
$topic  = pa_topic_name( $id );
?>
<article class="rcard">
	<a class="thumb t<?php echo esc_attr( pa_tone( $id ) ); ?><?php echo $has ? ' has-img' : ''; ?>" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php
		if ( $has ) {
			the_post_thumbnail( 'pa-card', array( 'loading' => 'lazy', 'alt' => '' ) );
		} else {
			echo '<span class="sym">▶</span>';
		}
		?>
		<span class="chip"><?php echo $video ? esc_html__( 'Video', 'pastor-adewale' ) : esc_html__( 'Teaching', 'pastor-adewale' ); ?></span>
		<?php if ( $dur ) : ?><span class="dur"><?php echo esc_html( $dur ); ?></span><?php endif; ?>
	</a>
	<div class="rbody">
		<span class="rmeta"><?php echo esc_html( trim( $topic . ( $series ? ' · ' . $series->name : '' ), ' ·' ) ); ?></span>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p><?php echo esc_html( get_the_excerpt() ); ?></p>
		<div class="rfoot"><span><?php echo esc_html( pa_speaker_name( $id ) . ' · ' . get_the_date( 'Y' ) ); ?></span><a class="rlink" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Watch teaching ›', 'pastor-adewale' ); ?></a></div>
	</div>
</article>
