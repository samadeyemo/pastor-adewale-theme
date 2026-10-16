<?php
/**
 * A single teaching: clean player, series navigation, recommended next.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
while ( have_posts() ) :
	the_post();
	$id    = get_the_ID();
	$vid   = pa_youtube_id( get_post_meta( $id, '_pa_video', true ) );
	$nav   = pa_lesson_nav( $id );
	$term  = $nav ? $nav['term'] : null;
	$notes = get_post_meta( $id, '_pa_notes', true );
	if ( ! $notes && $term ) {
		$notes = get_term_meta( $term->term_id, 'pa_notes_url', true );
	}
	$ids   = array( $id );
	$rec   = array();
	if ( $nav && $nav['next'] ) {
		$rec[] = $nav['next']->ID;
	}
	$ids = array_merge( $ids, $rec );
	$topic_terms = get_the_terms( $id, 'topic' );
	if ( $topic_terms && ! is_wp_error( $topic_terms ) ) {
		$more = get_posts( array( 'post_type' => 'teaching', 'posts_per_page' => 3, 'post__not_in' => $ids, 'fields' => 'ids', 'tax_query' => array( array( 'taxonomy' => 'topic', 'field' => 'term_id', 'terms' => wp_list_pluck( $topic_terms, 'term_id' ) ) ) ) );
		$rec  = array_merge( $rec, $more );
	}
	if ( count( $rec ) < 3 ) {
		$more = get_posts( array( 'post_type' => 'teaching', 'posts_per_page' => 3, 'post__not_in' => array_merge( array( $id ), $rec ), 'fields' => 'ids' ) );
		$rec  = array_merge( $rec, $more );
	}
	$rec = array_slice( array_unique( $rec ), 0, 3 );
	?>
	<div class="theater"><div class="wrap">
		<div class="crumbs" style="color:#e0bfcc;padding:0 0 14px"><a href="<?php echo esc_url( pa_url( 'resources' ) ); ?>"><?php esc_html_e( 'Resources', 'pastor-adewale' ); ?></a> / <?php if ( $term ) : ?><a href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a><?php else : ?><a href="<?php echo esc_url( get_post_type_archive_link( 'teaching' ) ); ?>"><?php esc_html_e( 'Teachings', 'pastor-adewale' ); ?></a><?php endif; ?></div>
		<div class="tgrid">
			<div>
				<div class="player">
					<?php if ( $vid ) : ?>
						<iframe src="https://www.youtube-nocookie.com/embed/<?php echo esc_attr( $vid ); ?>?rel=0&amp;modestbranding=1" title="<?php the_title_attribute(); ?>" allow="accelerometer; encrypted-media; picture-in-picture; fullscreen" allowfullscreen loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
					<?php else : ?>
						<div class="thumb t<?php echo esc_attr( pa_tone( $id ) ); ?> poster"><span class="pnote" style="position:static;padding:0 20px;font-size:16px"><?php echo current_user_can( 'edit_post', $id ) ? esc_html__( 'No video yet. Add a YouTube link in the Teaching details box.', 'pastor-adewale' ) : esc_html__( 'Video coming soon.', 'pastor-adewale' ); ?></span></div>
					<?php endif; ?>
				</div>
				<div class="wmeta">
					<span class="rmeta"><?php echo esc_html( $nav ? sprintf( /* translators: 1: series 2: number 3: total */ __( '%1$s · Lesson %2$d of %3$d', 'pastor-adewale' ), $term->name, $nav['index'], $nav['total'] ) : pa_topic_name( $id ) ); ?></span>
					<h1><?php the_title(); ?></h1>
					<?php if ( has_excerpt() ) : ?><p><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
					<div class="wbtns">
						<?php if ( $nav && $nav['prev'] ) : ?><a class="btn btn-ghost sm" href="<?php echo esc_url( get_permalink( $nav['prev'] ) ); ?>">‹ <?php esc_html_e( 'Previous', 'pastor-adewale' ); ?></a><?php endif; ?>
						<?php if ( $nav && $nav['next'] ) : ?><a class="btn btn-gold sm" href="<?php echo esc_url( get_permalink( $nav['next'] ) ); ?>"><?php esc_html_e( 'Next lesson ›', 'pastor-adewale' ); ?></a><?php endif; ?>
						<?php if ( $notes ) : ?><a class="btn btn-ghost sm" href="<?php echo esc_url( $notes ); ?>" download><?php esc_html_e( 'Study notes', 'pastor-adewale' ); ?></a><?php endif; ?>
						<button class="btn btn-ghost sm" type="button" data-focus><?php esc_html_e( 'Focus mode', 'pastor-adewale' ); ?></button>
						<button class="btn btn-ghost sm" type="button" data-open="shareModal"><?php esc_html_e( 'Share', 'pastor-adewale' ); ?></button>
					</div>
					<?php if ( $nav && $nav['next'] ) : ?>
						<a class="upnext" href="<?php echo esc_url( get_permalink( $nav['next'] ) ); ?>"><span><small><?php esc_html_e( 'Up next', 'pastor-adewale' ); ?></small><b><?php echo esc_html( get_the_title( $nav['next'] ) ); ?></b></span><span class="link"><?php esc_html_e( 'Watch ›', 'pastor-adewale' ); ?></span></a>
					<?php elseif ( $term ) : ?>
						<a class="upnext" href="<?php echo esc_url( get_term_link( $term ) ); ?>"><span><small><?php esc_html_e( 'You finished this series', 'pastor-adewale' ); ?></small><b><?php esc_html_e( 'See the series notes and eBook', 'pastor-adewale' ); ?></b></span><span class="link"><?php esc_html_e( 'Open ›', 'pastor-adewale' ); ?></span></a>
					<?php endif; ?>
				</div>
			</div>
			<?php if ( $nav ) : ?>
				<aside class="plist"><h3><?php echo esc_html( $term->name ); ?></h3>
					<?php foreach ( $nav['list'] as $i => $p ) : ?>
						<a class="pitem<?php echo (int) $p->ID === (int) $id ? ' cur' : ''; ?>" href="<?php echo esc_url( get_permalink( $p ) ); ?>"<?php echo (int) $p->ID === (int) $id ? ' aria-current="page"' : ''; ?>><span class="n"><?php echo esc_html( $i + 1 ); ?></span><span><b><?php echo esc_html( get_the_title( $p ) ); ?></b><small><?php echo esc_html( get_post_meta( $p->ID, '_pa_duration', true ) ); ?></small></span></a>
					<?php endforeach; ?>
				</aside>
			<?php endif; ?>
		</div>
	</div></div>

	<div id="watchData" hidden data-id="<?php echo esc_attr( $id ); ?>" data-title="<?php echo esc_attr( get_the_title() ); ?>" data-url="<?php echo esc_url( get_permalink() ); ?>" data-series="<?php echo esc_attr( $term ? $term->name : '' ); ?>" data-lesson="<?php echo esc_attr( $nav ? $nav['index'] : 0 ); ?>" data-total="<?php echo esc_attr( $nav ? $nav['total'] : 0 ); ?>" data-tone="<?php echo esc_attr( pa_tone( $id ) ); ?>"></div>

	<?php if ( trim( wp_strip_all_tags( get_the_content() ) ) ) : ?>
		<div class="wrap section recs" style="padding-bottom:0"><div class="entry-content"><h2 style="margin-top:0"><?php esc_html_e( 'About this teaching', 'pastor-adewale' ); ?></h2><?php the_content(); ?></div></div>
	<?php endif; ?>

	<?php if ( $rec ) : ?>
		<div class="wrap section recs">
			<div class="s-head"><div><h2><?php esc_html_e( 'Recommended next', 'pastor-adewale' ); ?></h2></div><a class="link" href="<?php echo esc_url( get_post_type_archive_link( 'teaching' ) ); ?>"><?php esc_html_e( 'Browse all', 'pastor-adewale' ); ?> <?php echo pa_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></div>
			<div class="grid3">
				<?php
				$q = new WP_Query( array( 'post_type' => 'teaching', 'post__in' => $rec, 'orderby' => 'post__in', 'posts_per_page' => 3, 'no_found_rows' => true ) );
				while ( $q->have_posts() ) {
					$q->the_post();
					get_template_part( 'template-parts/card', 'teaching' );
				}
				wp_reset_postdata();
				?>
			</div>
		</div>
	<?php endif; ?>
	<?php
endwhile;
get_footer();
