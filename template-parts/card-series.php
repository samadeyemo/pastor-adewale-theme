<?php
/** Series card. Args: term. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$term = $args['term'];
$link = get_term_link( $term );
if ( is_wp_error( $link ) ) {
	return;
}
?>
<a class="fcard" href="<?php echo esc_url( $link ); ?>">
	<span class="tag"><?php echo esc_html( sprintf( /* translators: %d: number of lessons */ _n( '%d lesson', '%d lessons', $term->count, 'pastor-adewale' ), $term->count ) ); ?></span>
	<h3><?php echo esc_html( $term->name ); ?></h3>
	<p><?php echo esc_html( wp_strip_all_tags( $term->description ) ); ?></p>
	<span class="link"><?php esc_html_e( 'View series', 'pastor-adewale' ); ?> <?php echo pa_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
</a>
