<?php
/**
 * Template Name: Contact
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/pagehead', null, array( 'title' => get_the_title(), 'desc' => __( 'Write to the ministry team. We read every message.', 'pastor-adewale' ), 'crumbs' => array( array( __( 'Contact', 'pastor-adewale' ), '' ) ) ) );
	?>
	<div class="wrap section"><div class="box">
		<div>
			<h2><?php esc_html_e( 'Get in touch', 'pastor-adewale' ); ?></h2>
			<p><?php echo nl2br( esc_html( pa_opt( 'address' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php if ( pa_opt( 'phone' ) ) : ?><br><?php echo esc_html( pa_opt( 'phone' ) ); ?><?php endif; ?></p>
			<?php if ( get_the_content() ) : ?><div class="entry-content"><?php the_content(); ?></div><?php endif; ?>
			<p><?php esc_html_e( 'Looking for something else?', 'pastor-adewale' ); ?> <a class="link" href="<?php echo esc_url( pa_url( 'prayer' ) ); ?>"><?php esc_html_e( 'Request prayer', 'pastor-adewale' ); ?></a> · <a class="link" href="<?php echo esc_url( pa_url( 'question' ) ); ?>"><?php esc_html_e( 'Ask a Bible question', 'pastor-adewale' ); ?></a> · <a class="link" href="<?php echo esc_url( pa_url( 'faqs' ) ); ?>"><?php esc_html_e( 'Read the FAQs', 'pastor-adewale' ); ?></a></p>
		</div>
		<div>
			<?php pa_form_notice( 'contact' ); pa_form_open( 'contact' ); ?>
				<div class="frow"><input name="pa_name" required placeholder="<?php esc_attr_e( 'Your name', 'pastor-adewale' ); ?>" aria-label="<?php esc_attr_e( 'Your name', 'pastor-adewale' ); ?>" autocomplete="name"><input type="email" name="pa_email" required placeholder="<?php esc_attr_e( 'Email', 'pastor-adewale' ); ?>" aria-label="<?php esc_attr_e( 'Email', 'pastor-adewale' ); ?>" autocomplete="email"></div>
				<select name="pa_topic" aria-label="<?php esc_attr_e( 'Reason', 'pastor-adewale' ); ?>"><option><?php esc_html_e( 'General enquiry', 'pastor-adewale' ); ?></option><option><?php esc_html_e( 'Partnership or giving', 'pastor-adewale' ); ?></option><option><?php esc_html_e( 'Invite Pastor Adewale to speak', 'pastor-adewale' ); ?></option><option><?php esc_html_e( 'Volunteer', 'pastor-adewale' ); ?></option><option><?php esc_html_e( 'Other', 'pastor-adewale' ); ?></option></select>
				<textarea name="pa_message" required maxlength="5000" placeholder="<?php esc_attr_e( 'Your message', 'pastor-adewale' ); ?>" aria-label="<?php esc_attr_e( 'Message', 'pastor-adewale' ); ?>"></textarea>
				<button class="btn btn-primary" type="submit"><?php esc_html_e( 'Send message', 'pastor-adewale' ); ?></button>
			</form>
		</div>
	</div></div>
	<?php
endwhile;
get_footer();
