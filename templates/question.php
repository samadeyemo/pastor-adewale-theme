<?php
/**
 * Template Name: Ask a Bible Question
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$qas = new WP_Query( array( 'post_type' => 'qa', 'posts_per_page' => 12, 'no_found_rows' => true ) );
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/pagehead', null, array( 'title' => get_the_title(), 'desc' => __( 'Send a question about a teaching, a passage or your study. The team may reply privately or choose it for a public Q&A.', 'pastor-adewale' ), 'crumbs' => array( array( __( 'Contact', 'pastor-adewale' ), pa_url( 'contact' ) ), array( get_the_title(), '' ) ) ) );
	?>
	<div class="wrap section"><div class="box" style="margin-bottom:50px">
		<div><h2><?php esc_html_e( 'There is room for your question.', 'pastor-adewale' ); ?></h2><p><?php esc_html_e( 'Be as clear as you can.', 'pastor-adewale' ); ?></p><p><b><?php esc_html_e( 'What happens next', 'pastor-adewale' ); ?></b><br>1. <?php esc_html_e( 'We receive your question.', 'pastor-adewale' ); ?><br>2. <?php esc_html_e( 'The team reviews it.', 'pastor-adewale' ); ?><br>3. <?php esc_html_e( 'You may get a reply, or it may feature in a future Q&A.', 'pastor-adewale' ); ?></p></div>
		<div>
			<?php pa_form_notice( 'question' ); pa_form_open( 'question' ); ?>
				<div class="frow"><input name="pa_name" placeholder="<?php esc_attr_e( 'Your name', 'pastor-adewale' ); ?>" aria-label="<?php esc_attr_e( 'Your name', 'pastor-adewale' ); ?>" autocomplete="name"><input type="email" name="pa_email" placeholder="<?php esc_attr_e( 'Email (optional, for a reply)', 'pastor-adewale' ); ?>" aria-label="<?php esc_attr_e( 'Email', 'pastor-adewale' ); ?>" autocomplete="email"></div>
				<select name="pa_topic" aria-label="<?php esc_attr_e( 'Topic', 'pastor-adewale' ); ?>"><option value=""><?php esc_html_e( 'Choose a topic (optional)', 'pastor-adewale' ); ?></option><option><?php esc_html_e( 'Understanding Scripture', 'pastor-adewale' ); ?></option><option><?php esc_html_e( 'Prayer and faith', 'pastor-adewale' ); ?></option><option><?php esc_html_e( 'Christian living', 'pastor-adewale' ); ?></option><option><?php esc_html_e( 'About a teaching', 'pastor-adewale' ); ?></option><option><?php esc_html_e( 'Other', 'pastor-adewale' ); ?></option></select>
				<textarea name="pa_message" required maxlength="5000" placeholder="<?php esc_attr_e( 'Write your question here', 'pastor-adewale' ); ?>" aria-label="<?php esc_attr_e( 'Your question', 'pastor-adewale' ); ?>"></textarea>
				<label class="fnote"><input type="checkbox" name="pa_public" value="1"> <?php esc_html_e( 'The ministry may consider my question for a public Q&A, without my contact details.', 'pastor-adewale' ); ?></label>
				<button class="btn btn-primary" type="submit"><?php esc_html_e( 'Send my question', 'pastor-adewale' ); ?></button>
			</form>
		</div>
	</div>
	<?php if ( $qas->have_posts() ) : ?>
		<div class="entry-content wide" style="max-width:820px;margin-bottom:70px"><h2 style="margin-top:0"><?php esc_html_e( 'Recently answered questions', 'pastor-adewale' ); ?></h2>
			<?php while ( $qas->have_posts() ) : $qas->the_post(); ?>
				<details><summary><?php the_title(); ?></summary><div><?php the_content(); ?></div></details>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	<?php endif; ?>
	</div>
	<?php
endwhile;
get_footer();
