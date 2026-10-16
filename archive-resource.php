<?php
/**
 * Books and downloads.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$base  = get_post_type_archive_link( 'resource' );
$type  = pa_get( 'pa_type' );
$types = get_terms( array( 'taxonomy' => 'resource_type', 'hide_empty' => true ) );
?>
<div class="wrap">
	<div class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'pastor-adewale' ); ?></a> / <a href="<?php echo esc_url( pa_url( 'resources' ) ); ?>"><?php esc_html_e( 'Resources', 'pastor-adewale' ); ?></a> / <?php esc_html_e( 'Books & downloads', 'pastor-adewale' ); ?></div>
	<div class="ptitle"><h1><?php esc_html_e( 'Books & downloads', 'pastor-adewale' ); ?></h1><p><?php esc_html_e( 'Books, study guides and lesson notes for personal study or your small group.', 'pastor-adewale' ); ?></p></div>
	<form method="get" action="<?php echo esc_url( $base ); ?>">
		<div class="toolbar">
			<div class="filters">
				<a class="filter<?php echo $type ? '' : ' active'; ?>" href="<?php echo esc_url( $base ); ?>"><?php esc_html_e( 'All resources', 'pastor-adewale' ); ?></a>
				<?php if ( $types && ! is_wp_error( $types ) ) : foreach ( $types as $t ) : ?><a class="filter<?php echo $type === $t->slug ? ' active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'pa_type', $t->slug, $base ) ); ?>"><?php echo esc_html( $t->name ); ?></a><?php endforeach; endif; ?>
			</div>
			<label class="search-box"><?php echo pa_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span class="screen-reader-text"><?php esc_html_e( 'Search resources', 'pastor-adewale' ); ?></span><input type="search" name="pa_q" value="<?php echo esc_attr( pa_get( 'pa_q' ) ); ?>" placeholder="<?php esc_attr_e( 'Search resources', 'pastor-adewale' ); ?>"><?php if ( $type ) : ?><input type="hidden" name="pa_type" value="<?php echo esc_attr( $type ); ?>"><?php endif; ?></label>
		</div>
	</form>
	<?php if ( have_posts() ) : ?>
		<div class="grid3" style="margin-bottom:40px"><?php while ( have_posts() ) { the_post(); get_template_part( 'template-parts/card-resource', null, array( 'variant' => 'grid' ) ); } ?></div>
		<?php the_posts_pagination( array( 'prev_text' => '‹', 'next_text' => '›' ) ); ?>
	<?php else : ?><p class="empty" style="display:block"><?php esc_html_e( 'No resources match that search.', 'pastor-adewale' ); ?></p><?php endif; ?>
	<div style="height:60px"></div>
</div>
<?php get_footer(); ?>
