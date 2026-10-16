<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form role="search" method="get" class="bigsearch" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="margin-top:22px">
	<?php echo pa_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	<label class="screen-reader-text" for="s-<?php echo esc_attr( wp_unique_id() ); ?>"><?php esc_html_e( 'Search', 'pastor-adewale' ); ?></label>
	<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search teachings, series, courses and books', 'pastor-adewale' ); ?>">
</form>
