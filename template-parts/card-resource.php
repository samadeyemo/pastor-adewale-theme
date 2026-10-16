<?php
/** Book / download card. Args: variant = grid | book, rank. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$variant = isset( $args['variant'] ) ? $args['variant'] : 'grid';
$id      = get_the_ID();
$file    = get_post_meta( $id, '_pa_file', true );
$label   = get_post_meta( $id, '_pa_label', true );
$terms   = get_the_terms( $id, 'resource_type' );
$type    = ( $terms && ! is_wp_error( $terms ) ) ? reset( $terms )->name : __( 'Download', 'pastor-adewale' );
$tone    = pa_tone( $id );
$cover   = has_post_thumbnail()
	? get_the_post_thumbnail( $id, 'medium_large', array( 'loading' => 'lazy', 'alt' => '' ) )
	: '<div class="book-cover"><b>' . esc_html( get_the_title() ) . '</b><small>' . esc_html( strtoupper( pa_pastor_name() ) ) . '</small></div>';
if ( 'book' === $variant ) :
	?>
	<article class="bk">
		<a href="<?php the_permalink(); ?>" class="bcv b<?php echo esc_attr( $tone ); ?>" aria-label="<?php the_title_attribute(); ?>"><?php echo $cover; // phpcs:ignore WordPress.Security.EscapeOutput ?><span class="freepdf"><?php esc_html_e( 'Free PDF', 'pastor-adewale' ); ?></span></a>
		<div class="meta"><b><?php the_title(); ?></b><small><?php echo esc_html( trim( $type . ( $label ? ' · ' . $label : '' ), ' ·' ) ); ?></small></div>
		<div class="acts">
			<?php if ( $file ) : ?><a class="btn btn-primary sm" href="<?php echo esc_url( $file ); ?>" download><?php esc_html_e( 'Download', 'pastor-adewale' ); ?></a><?php endif; ?>
			<a class="btn btn-line sm" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Details', 'pastor-adewale' ); ?></a>
		</div>
	</article>
<?php else : ?>
	<article class="rcard">
		<a class="thumb t<?php echo esc_attr( $tone ); ?><?php echo has_post_thumbnail() ? ' has-img' : ''; ?>" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php echo $cover; // phpcs:ignore WordPress.Security.EscapeOutput ?><span class="chip"><?php echo esc_html( $type ); ?></span></a>
		<div class="rbody">
			<span class="rmeta"><?php echo esc_html( $type ); ?></span>
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<p><?php echo esc_html( get_the_excerpt() ); ?></p>
			<div class="rfoot"><span><?php echo esc_html( $label ); ?></span>
				<?php if ( $file ) : ?><a class="rlink" href="<?php echo esc_url( $file ); ?>" download><?php esc_html_e( 'Download PDF ›', 'pastor-adewale' ); ?></a><?php else : ?><a class="rlink" href="<?php the_permalink(); ?>"><?php esc_html_e( 'View details ›', 'pastor-adewale' ); ?></a><?php endif; ?>
			</div>
		</div>
	</article>
<?php endif; ?>
