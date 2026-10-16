<?php
/**
 * Site header, full-screen menu and quick-action rail.
 *
 * @package pastor-adewale
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip" href="#main"><?php esc_html_e( 'Skip to content', 'pastor-adewale' ); ?></a>
<?php get_template_part( 'template-parts/sprite' ); ?>

<header class="header" id="siteHeader"><div class="wrap">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
		<?php
		if ( has_custom_logo() ) {
			echo wp_get_attachment_image( (int) get_theme_mod( 'custom_logo' ), 'thumbnail', false, array( 'class' => 'brand-logo', 'alt' => '' ) );
		} else {
			echo '<span class="brand-mark">' . esc_html( pa_opt( 'brand_initials', 'AO' ) ) . '</span>';
		}
		?>
		<span class="brand-name"><?php echo esc_html( get_bloginfo( 'name' ) ); ?><?php if ( get_bloginfo( 'description' ) ) : ?><small><?php echo esc_html( get_bloginfo( 'description' ) ); ?></small><?php endif; ?></span>
	</a>

	<?php
	wp_nav_menu(
		array(
			'theme_location'       => 'primary',
			'container'            => 'nav',
			'container_class'      => 'nav',
			'container_aria_label' => __( 'Main', 'pastor-adewale' ),
			'fallback_cb'          => false,
			'depth'                => 1,
		)
	);
	?>

	<div class="h-actions">
		<?php if ( function_exists( 'pll_the_languages' ) ) : ?>
			<div class="pa-lang"><ul><?php pll_the_languages( array( 'show_flags' => 0, 'show_names' => 1, 'display_names_as' => 'slug' ) ); ?></ul></div>
		<?php endif; ?>
		<button class="h-btn icon" type="button" data-open="searchModal" aria-label="<?php esc_attr_e( 'Search', 'pastor-adewale' ); ?>"><?php echo pa_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
		<button class="h-btn" type="button" id="menuBtn" aria-expanded="false" aria-controls="menu" aria-label="<?php esc_attr_e( 'Open menu', 'pastor-adewale' ); ?>"><?php echo pa_icon( 'menu' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php esc_html_e( 'Menu', 'pastor-adewale' ); ?></span></button>
		<a class="h-btn btn-give donate-b" href="<?php echo esc_url( pa_url( 'donate' ) ); ?>"><?php echo pa_icon( 'heart' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php esc_html_e( 'Donate', 'pastor-adewale' ); ?></span></a>
	</div>
</div></header>

<div class="sitemenu" id="menu" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Site menu', 'pastor-adewale' ); ?>" hidden>
	<div class="wrap">
		<div class="menu-top">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand"><span class="brand-mark"><?php echo esc_html( pa_opt( 'brand_initials', 'AO' ) ); ?></span><span class="brand-name"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span></a>
			<div class="h-actions">
				<a class="h-btn btn-give" href="<?php echo esc_url( pa_url( 'donate' ) ); ?>"><?php echo pa_icon( 'heart' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Donate', 'pastor-adewale' ); ?></a>
				<button class="h-btn icon" type="button" id="menuClose" aria-label="<?php esc_attr_e( 'Close menu', 'pastor-adewale' ); ?>"><?php echo pa_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
			</div>
		</div>
		<div class="menu-grid">
			<?php
			$cols = array(
				'menu_explore'  => __( 'Explore', 'pastor-adewale' ),
				'menu_about'    => __( 'About', 'pastor-adewale' ),
				'menu_involved' => __( 'Get involved', 'pastor-adewale' ),
				'menu_contact'  => __( 'Contact', 'pastor-adewale' ),
			);
			foreach ( $cols as $loc => $label ) {
				echo '<div class="menu-col"><h4>' . esc_html( $label ) . '</h4>';
				wp_nav_menu( array( 'theme_location' => $loc, 'container' => false, 'fallback_cb' => false, 'depth' => 1 ) );
				echo '</div>';
			}
			?>
		</div>
		<div class="menu-foot">
			<div class="social" style="margin:0"><?php echo pa_social_html(); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
			<a class="btn btn-gold" href="<?php echo esc_url( pa_url( 'free-ebook' ) ); ?>"><?php echo pa_icon( 'gift' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Get a free eBook', 'pastor-adewale' ); ?></a>
		</div>
	</div>
</div>

<div class="rail" aria-label="<?php esc_attr_e( 'Quick actions', 'pastor-adewale' ); ?>">
	<button type="button" data-open="shareModal"><?php echo pa_icon( 'share' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Share', 'pastor-adewale' ); ?></button>
	<a href="<?php echo esc_url( pa_url( 'free-ebook' ) ); ?>"><?php echo pa_icon( 'gift' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Offer', 'pastor-adewale' ); ?></a>
	<a href="<?php echo esc_url( pa_url( 'donate' ) ); ?>" class="give"><?php echo pa_icon( 'heart' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Give', 'pastor-adewale' ); ?></a>
</div>

<main id="main">
