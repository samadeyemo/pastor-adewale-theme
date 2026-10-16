<?php
/** Bible School course card. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$id     = get_the_ID();
$size   = get_post_meta( $id, '_pa_lessons', true );
$enrol  = get_post_meta( $id, '_pa_enrol', true );
$has    = has_post_thumbnail();
?>
<article class="rcard">
	<a class="thumb t<?php echo esc_attr( pa_tone( $id ) ); ?><?php echo $has ? ' has-img' : ''; ?>" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php
		if ( $has ) {
			the_post_thumbnail( 'pa-card', array( 'loading' => 'lazy', 'alt' => '' ) );
		} else {
			echo '<span class="sym">✦</span>';
		}
		?>
		<span class="chip"><?php esc_html_e( 'Bible School', 'pastor-adewale' ); ?></span>
	</a>
	<div class="rbody">
		<span class="rmeta"><?php echo esc_html( $size ); ?></span>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p><?php echo esc_html( get_the_excerpt() ); ?></p>
		<div class="rfoot"><span><?php esc_html_e( 'Study at your own pace', 'pastor-adewale' ); ?></span><a class="rlink" href="<?php echo esc_url( $enrol ? $enrol : get_permalink() ); ?>"><?php esc_html_e( 'Start course ›', 'pastor-adewale' ); ?></a></div>
	</div>
</article>
