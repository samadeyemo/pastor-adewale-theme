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
<script>
(function(){
	try{
		var t=localStorage.getItem('pa-theme');
		if(t==='dark'||t==='light'){document.documentElement.setAttribute('data-theme',t);}
		else if(window.matchMedia&&matchMedia('(prefers-color-scheme:dark)').matches){document.documentElement.setAttribute('data-theme','dark');}
		var c=localStorage.getItem('pa-accent');
		if(c){
			document.documentElement.style.setProperty('--goldbg',c);
			document.documentElement.style.setProperty('--green',c);
			document.documentElement.style.setProperty('--gold',c);
		}
	}catch(e){}
})();
</script>
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
			echo '<img class="brand-logo" src="' . esc_url( PA_URI . '/assets/images/logo.svg' ) . '" width="44" height="44" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
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
		<button class="h-btn icon theme-toggle-btn" type="button" id="themeToggle" aria-label="<?php esc_attr_e( 'Toggle dark mode', 'pastor-adewale' ); ?>" title="<?php esc_attr_e( 'Light / Dark mode', 'pastor-adewale' ); ?>">
			<svg class="theme-icon theme-icon-sun" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
				<circle cx="12" cy="12" r="4"/>
				<path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
			</svg>
			<svg class="theme-icon theme-icon-moon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
				<path d="M21 14.5A8.5 8.5 0 1 1 9.5 3a7 7 0 0 0 11.5 11.5z"/>
			</svg>
		</button>
		<button class="h-btn icon" type="button" id="colorPickerBtn" aria-label="<?php esc_attr_e( 'Accent color', 'pastor-adewale' ); ?>" title="<?php esc_attr_e( 'Change accent color', 'pastor-adewale' ); ?>" aria-expanded="false" aria-controls="colorPickerPanel">
			<span class="color-dot" aria-hidden="true"></span>
		</button>
		<button class="h-btn icon" type="button" data-open="searchModal" aria-label="<?php esc_attr_e( 'Search', 'pastor-adewale' ); ?>"><?php echo pa_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
		<button class="h-btn" type="button" id="menuBtn" aria-expanded="false" aria-controls="menu" aria-label="<?php esc_attr_e( 'Open menu', 'pastor-adewale' ); ?>"><?php echo pa_icon( 'menu' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php esc_html_e( 'Menu', 'pastor-adewale' ); ?></span></button>
		<a class="h-btn btn-give donate-b" href="<?php echo esc_url( pa_url( 'donate' ) ); ?>"><?php echo pa_icon( 'heart' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php esc_html_e( 'Donate', 'pastor-adewale' ); ?></span></a>
	</div>

	<div class="color-picker-panel" id="colorPickerPanel" hidden role="dialog" aria-label="<?php esc_attr_e( 'Choose accent color', 'pastor-adewale' ); ?>">
		<p class="cp-title"><?php esc_html_e( 'Accent color', 'pastor-adewale' ); ?></p>
		<div class="cp-swatches">
			<button type="button" class="cp-swatch" data-color="#D4A017" style="background:#D4A017" title="Gold" aria-label="Gold"></button>
			<button type="button" class="cp-swatch" data-color="#C9A227" style="background:#C9A227" title="Warm gold" aria-label="Warm gold"></button>
			<button type="button" class="cp-swatch" data-color="#B8860B" style="background:#B8860B" title="Dark goldenrod" aria-label="Dark goldenrod"></button>
			<button type="button" class="cp-swatch" data-color="#CD853F" style="background:#CD853F" title="Peru" aria-label="Peru"></button>
			<button type="button" class="cp-swatch" data-color="#8B4513" style="background:#8B4513" title="Saddle brown" aria-label="Saddle brown"></button>
			<button type="button" class="cp-swatch" data-color="#6E1A3D" style="background:#6E1A3D" title="Maroon" aria-label="Maroon"></button>
			<button type="button" class="cp-swatch" data-color="#2F6B6B" style="background:#2F6B6B" title="Teal" aria-label="Teal"></button>
			<button type="button" class="cp-swatch" data-color="#3B5BDB" style="background:#3B5BDB" title="Blue" aria-label="Blue"></button>
		</div>
		<label class="cp-custom">
			<span><?php esc_html_e( 'Custom', 'pastor-adewale' ); ?></span>
			<input type="color" id="accentColorInput" value="#D4A017" aria-label="<?php esc_attr_e( 'Custom accent color', 'pastor-adewale' ); ?>">
		</label>
		<button type="button" class="cp-reset" id="colorReset"><?php esc_html_e( 'Reset to gold', 'pastor-adewale' ); ?></button>
	</div>
</div></header>

<div class="sitemenu" id="menu" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Site menu', 'pastor-adewale' ); ?>" hidden>
	<div class="wrap">
		<div class="menu-top">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand"><span class="brand-mark"><?php echo esc_html( pa_opt( 'brand_initials', 'ABC' ) ); ?></span><span class="brand-name"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span></a>
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
