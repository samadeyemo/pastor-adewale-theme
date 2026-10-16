<?php
/** Generic card: news posts, outreach stories and anything else. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$tags = array();
if ( 'post' === get_post_type() ) {
	if ( ( time() - get_post_time( 'U', true ) ) < 14 * DAY_IN_SECONDS ) {
		$tags[] = array( __( 'New', 'pastor-adewale' ), true );
	}
	foreach ( (array) get_the_category() as $c ) {
		if ( 'uncategorized' !== $c->slug ) {
			$tags[] = array( $c->name, false );
		}
	}
} elseif ( 'outreach' === get_post_type() ) {
	$place = get_post_meta( get_the_ID(), '_pa_place', true );
	if ( $place ) {
		$tags[] = array( $place, false );
	}
}
?>
<article class="ncard">
	<?php if ( $tags ) : ?><div class="tags"><?php foreach ( $tags as $t ) : ?><span class="tag-pill<?php echo $t[1] ? ' tag-new' : ''; ?>"><?php echo esc_html( $t[0] ); ?></span><?php endforeach; ?></div><?php endif; ?>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<p><?php echo esc_html( get_the_excerpt() ); ?></p>
	<div class="by"><span class="avatar"><?php echo esc_html( mb_substr( get_bloginfo( 'name' ), 0, 1 ) ); ?></span><?php echo esc_html( get_the_date() ); ?></div>
</article>
