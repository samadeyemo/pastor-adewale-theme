<?php
/**
 * Articles, books, courses, testimonies and outreach stories.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
while ( have_posts() ) :
	the_post();
	$pt   = get_post_type();
	$obj  = get_post_type_object( $pt );
	$arch = get_post_type_archive_link( $pt );
	if ( 'post' === $pt ) {
		$arch = pa_url( 'news' );
	}
	$label = 'post' === $pt ? __( 'News', 'pastor-adewale' ) : $obj->labels->name;
	get_template_part( 'template-parts/pagehead', null, array( 'title' => get_the_title(), 'desc' => has_excerpt() ? get_the_excerpt() : '', 'crumbs' => array( array( $label, $arch ), array( get_the_title(), '' ) ) ) );
	?>
	<div class="wrap" style="padding:40px 0 70px">
		<div class="article-meta"><?php echo esc_html( get_the_date() ); ?></div>
		<?php if ( has_post_thumbnail() ) : ?><div class="article-hero"><?php the_post_thumbnail( 'large' ); ?></div><?php endif; ?>
		<div class="entry-content"><?php the_content(); ?></div>
		<?php if ( 'resource' === $pt && get_post_meta( get_the_ID(), '_pa_file', true ) ) : ?>
			<p style="margin-top:28px"><a class="btn btn-primary" href="<?php echo esc_url( get_post_meta( get_the_ID(), '_pa_file', true ) ); ?>" download><?php esc_html_e( 'Download PDF', 'pastor-adewale' ); ?></a></p>
		<?php endif; ?>
		<?php if ( 'course' === $pt && get_post_meta( get_the_ID(), '_pa_enrol', true ) ) : ?>
			<p style="margin-top:28px"><a class="btn btn-primary" href="<?php echo esc_url( get_post_meta( get_the_ID(), '_pa_enrol', true ) ); ?>"><?php esc_html_e( 'Start course', 'pastor-adewale' ); ?></a></p>
		<?php endif; ?>
		<p style="margin-top:28px"><a class="link" href="<?php echo esc_url( $arch ); ?>">‹ <?php echo esc_html( sprintf( /* translators: %s: section name */ __( 'Back to %s', 'pastor-adewale' ), $label ) ); ?></a></p>
	</div>
	<?php
endwhile;
get_footer();
