<?php
/**
 * Template Name: Share Your Story
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$recent = new WP_Query( array( 'post_type' => 'testimony', 'posts_per_page' => 2, 'no_found_rows' => true ) );
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/pagehead', null, array( 'title' => __( 'Share what God has done', 'pastor-adewale' ), 'desc' => __( 'Your story may encourage someone else. The ministry team reviews every submission before anything appears publicly.', 'pastor-adewale' ), 'crumbs' => array( array( __( 'Get involved', 'pastor-adewale' ), '' ), array( get_the_title(), '' ) ) ) );
	?>
	<div class="wrap section">
		<?php if ( $recent->have_posts() ) : ?><div class="grid3" style="grid-template-columns:repeat(2,1fr);margin-bottom:34px"><?php while ( $recent->have_posts() ) { $recent->the_post(); get_template_part( 'template-parts/card-testimony' ); } wp_reset_postdata(); ?></div><?php endif; ?>
		<div class="box" style="margin-bottom:30px">
			<div><h2><?php esc_html_e( 'Share your testimony', 'pastor-adewale' ); ?></h2><p><?php esc_html_e( 'Only share what you are comfortable making public. It takes about a minute.', 'pastor-adewale' ); ?></p><p><a class="link" href="<?php echo esc_url( get_post_type_archive_link( 'testimony' ) ); ?>"><?php esc_html_e( 'Read all testimonies', 'pastor-adewale' ); ?></a></p></div>
			<div>
				<?php pa_form_notice( 'story' ); pa_form_open( 'story' ); ?>
					<input name="pa_name" placeholder="<?php esc_attr_e( 'Your first name (optional)', 'pastor-adewale' ); ?>" aria-label="<?php esc_attr_e( 'Your first name', 'pastor-adewale' ); ?>" autocomplete="given-name">
					<textarea name="pa_message" required maxlength="5000" placeholder="<?php esc_attr_e( 'What has God done? A few sentences is enough.', 'pastor-adewale' ); ?>" aria-label="<?php esc_attr_e( 'Your story', 'pastor-adewale' ); ?>"></textarea>
					<label class="fnote"><input type="checkbox" name="pa_consent" value="1" required> <?php esc_html_e( 'I am happy for this to be published after the team has reviewed it.', 'pastor-adewale' ); ?></label>
					<button class="btn btn-primary" type="submit"><?php esc_html_e( 'Send my story', 'pastor-adewale' ); ?></button>
					<span class="fnote"><?php esc_html_e( 'Every story is moderated. Nothing is published automatically.', 'pastor-adewale' ); ?></span>
				</form>
			</div>
		</div>
	</div>
	<?php
endwhile;
get_footer();
