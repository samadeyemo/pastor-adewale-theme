<?php
/**
 * Footer, modals and wp_footer.
 *
 * @package pastor-adewale
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</main>

<footer class="footer"><div class="wrap">
	<?php pa_form_open( 'subscriber', 'newsl', 'pa-form-footer' ); ?>
		<div>
			<h3><?php esc_html_e( 'New teachings and free resources, by email', 'pastor-adewale' ); ?></h3>
			<p><?php esc_html_e( 'One short email when a new teaching or free download is ready. Unsubscribe any time.', 'pastor-adewale' ); ?></p>
			<?php
			if ( ! is_page_template( 'templates/ebook.php' ) ) {
				pa_form_notice( 'subscriber' );
			}
			?>
		</div>
		<div class="row">
			<label class="screen-reader-text" for="pa-footer-email"><?php esc_html_e( 'Email address', 'pastor-adewale' ); ?></label>
			<input id="pa-footer-email" type="email" name="pa_email" required placeholder="<?php esc_attr_e( 'Your email address', 'pastor-adewale' ); ?>" autocomplete="email">
			<button class="btn btn-gold" type="submit"><?php esc_html_e( 'Subscribe', 'pastor-adewale' ); ?></button>
		</div>
	</form>

	<div class="f-top">
		<div>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand"><img class="brand-logo" src="<?php echo esc_url( PA_URI . '/assets/images/logo.svg' ); ?>" width="44" height="44" alt=""><span class="brand-name"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span></a>
			<p><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
			<?php if ( pa_social() ) : ?><div class="social"><?php echo pa_social_html(); // phpcs:ignore WordPress.Security.EscapeOutput ?></div><?php endif; ?>
		</div>
		<div><h4><?php esc_html_e( 'Explore', 'pastor-adewale' ); ?></h4><?php wp_nav_menu( array( 'theme_location' => 'menu_explore', 'container' => false, 'menu_class' => 'f-links', 'fallback_cb' => false, 'depth' => 1 ) ); ?></div>
		<div><h4><?php esc_html_e( 'Get involved', 'pastor-adewale' ); ?></h4><?php wp_nav_menu( array( 'theme_location' => 'menu_involved', 'container' => false, 'menu_class' => 'f-links', 'fallback_cb' => false, 'depth' => 1 ) ); ?></div>
		<div><h4><?php esc_html_e( 'Contact', 'pastor-adewale' ); ?></h4><?php wp_nav_menu( array( 'theme_location' => 'menu_contact', 'container' => false, 'menu_class' => 'f-links', 'fallback_cb' => false, 'depth' => 1 ) ); ?></div>
	</div>

	<div class="f-legal">
		<?php if ( pa_opt( 'registration' ) ) : ?><div class="row"><span><?php echo esc_html( get_bloginfo( 'name' ) . ' · ' . pa_opt( 'registration' ) ); ?></span></div><?php endif; ?>
		<div class="row">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'All rights reserved.', 'pastor-adewale' ); ?></span>
			<span><?php wp_nav_menu( array( 'theme_location' => 'footer_legal', 'container' => false, 'menu_class' => 'f-legal-menu', 'fallback_cb' => false, 'depth' => 1, 'items_wrap' => '%3$s', 'link_before' => '', 'before' => '', 'after' => ' · ' ) ); ?></span>
		</div>
	</div>
</div></footer>

<div class="modal" id="shareModal" role="dialog" aria-modal="true" aria-labelledby="shareT" hidden><div class="sheet">
	<button class="x" type="button" data-close aria-label="<?php esc_attr_e( 'Close', 'pastor-adewale' ); ?>"><?php echo pa_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
	<h3 id="shareT"><?php esc_html_e( 'Share this page', 'pastor-adewale' ); ?></h3>
	<p><?php esc_html_e( 'Send it to someone who would be encouraged.', 'pastor-adewale' ); ?></p>
	<div class="sharegrid"><a id="sFb" target="_blank" rel="noopener">Facebook</a><a id="sX" target="_blank" rel="noopener">X</a><a id="sTg" target="_blank" rel="noopener">Telegram</a><a id="sWa" target="_blank" rel="noopener">WhatsApp</a></div>
	<div class="copyrow"><input id="shareLink" readonly aria-label="<?php esc_attr_e( 'Page link', 'pastor-adewale' ); ?>"><button class="btn btn-primary" id="copyBtn" type="button"><?php esc_html_e( 'Copy link', 'pastor-adewale' ); ?></button></div>
</div></div>

<div class="modal" id="searchModal" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Search', 'pastor-adewale' ); ?>" hidden><div class="sheet" style="width:min(640px,100%)">
	<button class="x" type="button" data-close aria-label="<?php esc_attr_e( 'Close', 'pastor-adewale' ); ?>"><?php echo pa_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
	<h3><?php esc_html_e( 'Search', 'pastor-adewale' ); ?></h3>
	<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-box" style="display:block;margin-top:10px">
		<?php echo pa_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		<label class="screen-reader-text" for="gSearch"><?php esc_html_e( 'Search the site', 'pastor-adewale' ); ?></label>
		<input id="gSearch" type="search" name="s" placeholder="<?php esc_attr_e( 'Search teachings, series, books and news', 'pastor-adewale' ); ?>" autocomplete="off">
	</form>
	<div class="sresults" id="gResults" aria-live="polite"></div>
</div></div>

<div class="toast" id="toast" role="status" aria-live="polite"></div>
<?php wp_footer(); ?>
</body>
</html>
