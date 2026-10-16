<?php
/**
 * Template Name: Request Prayer
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/pagehead', null, array( 'title' => get_the_title(), 'desc' => __( 'Tell us how we can pray with you. Your request goes to the prayer team only.', 'pastor-adewale' ), 'crumbs' => array( array( __( 'Contact', 'pastor-adewale' ), pa_url( 'contact' ) ), array( get_the_title(), '' ) ) ) );
	?>
	<div class="wrap section"><div class="box">
		<div><h2><?php esc_html_e( 'We would be glad to pray.', 'pastor-adewale' ); ?></h2><p><?php esc_html_e( 'Share as much or as little as you like. Please avoid details you would not want a small team to read.', 'pastor-adewale' ); ?></p><p><?php esc_html_e( 'Be encouraged:', 'pastor-adewale' ); ?> <a class="link" href="<?php echo esc_url( get_post_type_archive_link( 'testimony' ) ); ?>"><?php esc_html_e( 'read how God has answered prayer', 'pastor-adewale' ); ?></a>.</p></div>
		<div>
			<?php pa_form_notice( 'prayer' ); pa_form_open( 'prayer' ); ?>
				<div class="frow"><input name="pa_name" placeholder="<?php esc_attr_e( 'Your name (or first name)', 'pastor-adewale' ); ?>" aria-label="<?php esc_attr_e( 'Name', 'pastor-adewale' ); ?>" autocomplete="given-name"><input type="email" name="pa_email" placeholder="<?php esc_attr_e( 'Email (optional, for a reply)', 'pastor-adewale' ); ?>" aria-label="<?php esc_attr_e( 'Email', 'pastor-adewale' ); ?>" autocomplete="email"></div>
				<textarea name="pa_message" required maxlength="5000" placeholder="<?php esc_attr_e( 'Your prayer request', 'pastor-adewale' ); ?>" aria-label="<?php esc_attr_e( 'Prayer request', 'pastor-adewale' ); ?>"></textarea>
				<label class="fnote"><input type="checkbox" name="pa_public" value="1"> <?php esc_html_e( 'The team may add this request to the public prayer list, without my name.', 'pastor-adewale' ); ?></label>
				<button class="btn btn-primary" type="submit"><?php esc_html_e( 'Send prayer request', 'pastor-adewale' ); ?></button>
			</form>
		</div>
	</div></div>
	<?php
endwhile;
get_footer();
