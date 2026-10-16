<?php
/**
 * Template Name: Free eBook
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$done  = 'subscriber' === pa_get( 'pa_sent' );
$ebook = pa_opt( 'ebook_url' );
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/pagehead', null, array( 'title' => get_the_title(), 'desc' => __( 'Subscribe to our community updates and start your library with a free eBook.', 'pastor-adewale' ), 'crumbs' => array( array( __( 'Free eBook', 'pastor-adewale' ), '' ) ) ) );
	?>
	<div class="wrap section"><div class="box" style="max-width:900px">
		<div><h2><?php esc_html_e( 'Start your collection', 'pastor-adewale' ); ?></h2><p><?php esc_html_e( 'Enter your email to subscribe. You will also get new teachings and resources. Unsubscribe any time.', 'pastor-adewale' ); ?></p></div>
		<div>
			<?php if ( $done ) : pa_form_notice( 'subscriber' ); ?>
				<?php if ( $ebook ) : ?>
					<p><a class="btn btn-primary" href="<?php echo esc_url( $ebook ); ?>" download><?php echo esc_html( pa_opt( 'ebook_title' ) ? sprintf( /* translators: %s: eBook title */ __( 'Download: %s', 'pastor-adewale' ), pa_opt( 'ebook_title' ) ) : __( 'Download your free eBook', 'pastor-adewale' ) ); ?></a></p>
				<?php else : ?>
					<p><?php esc_html_e( 'We will send you the eBook link shortly.', 'pastor-adewale' ); ?></p>
				<?php endif; ?>
			<?php else : pa_form_notice( 'subscriber' ); pa_form_open( 'subscriber' ); ?>
				<input name="pa_name" placeholder="<?php esc_attr_e( 'Your name', 'pastor-adewale' ); ?>" aria-label="<?php esc_attr_e( 'Your name', 'pastor-adewale' ); ?>" autocomplete="name">
				<input type="email" name="pa_email" required placeholder="<?php esc_attr_e( 'Email address', 'pastor-adewale' ); ?>" aria-label="<?php esc_attr_e( 'Email', 'pastor-adewale' ); ?>" autocomplete="email">
				<button class="btn btn-primary" type="submit"><?php esc_html_e( 'Send my free eBook', 'pastor-adewale' ); ?></button>
			</form><?php endif; ?>
		</div>
	</div></div>
	<?php
endwhile;
get_footer();
