<?php
/**
 * Dark page title band. Args: title, desc, crumbs (array of array(label,url)), extra (html).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$crumbs = isset( $args['crumbs'] ) ? $args['crumbs'] : array();
?>
<div class="ptitle dark"><div class="wrap">
	<div class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'pastor-adewale' ); ?></a><?php
	foreach ( $crumbs as $c ) {
		echo ' / ';
		if ( ! empty( $c[1] ) ) {
			echo '<a href="' . esc_url( $c[1] ) . '">' . esc_html( $c[0] ) . '</a>';
		} else {
			echo esc_html( $c[0] );
		}
	}
	?></div>
	<h1><?php echo esc_html( $args['title'] ); ?></h1>
	<?php if ( ! empty( $args['desc'] ) ) : ?><p><?php echo esc_html( $args['desc'] ); ?></p><?php endif; ?>
	<?php
	if ( ! empty( $args['extra'] ) ) {
		echo wp_kses_post( $args['extra'] );
	}
	?>
</div></div>
