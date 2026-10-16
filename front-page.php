<?php
/**
 * Home page: split hero carousel, series, start band, teachings, news, books, testimonies.
 *
 * @package pastor-adewale
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

$slides  = pa_get_slides();
$name    = pa_pastor_name();
$series  = get_terms( array( 'taxonomy' => 'series', 'hide_empty' => true, 'number' => 3, 'orderby' => 'term_id', 'order' => 'ASC' ) );
$books   = new WP_Query( array( 'post_type' => 'resource', 'posts_per_page' => 6, 'no_found_rows' => true ) );
$teach   = new WP_Query( array( 'post_type' => 'teaching', 'posts_per_page' => 3, 'no_found_rows' => true ) );
$news    = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3, 'ignore_sticky_posts' => true, 'no_found_rows' => true ) );
$stories = new WP_Query( array( 'post_type' => 'testimony', 'posts_per_page' => 3, 'no_found_rows' => true ) );
?>

<section class="hero2" id="hero" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Featured', 'pastor-adewale' ); ?>">
	<div class="hv">
		<?php foreach ( $slides as $i => $s ) : ?>
			<div class="vslide v<?php echo esc_attr( ( $i % 4 ) + 1 ); ?><?php echo 0 === $i ? ' on' : ''; ?>" aria-hidden="<?php echo 0 === $i ? 'false' : 'true'; ?>">
				<?php if ( $s['use_photo'] ) : ?>
					<div class="rings" aria-hidden="true"></div>
					<figure class="pframe">
						<div class="pimg photo" role="img" aria-label="<?php echo esc_attr( $name ); ?>" style="background-image:url('<?php echo esc_url( pa_photo_url() ); ?>')"></div>
						<figcaption><?php echo esc_html( $name ); ?></figcaption>
					</figure>
				<?php elseif ( $s['image'] ) : ?>
					<img class="slide-img" src="<?php echo esc_url( $s['image'] ); ?>" alt="" <?php echo $i > 0 ? 'loading="lazy"' : ''; ?>>
				<?php else : ?>
					<?php get_template_part( 'template-parts/hero-art', null, array( 'n' => $i ) ); ?>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
		<div class="hacts">
			<button type="button" class="circ" data-open="shareModal" aria-label="<?php esc_attr_e( 'Share', 'pastor-adewale' ); ?>"><?php echo pa_icon( 'share' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
			<a class="circ" href="<?php echo esc_url( pa_url( 'free-ebook' ) ); ?>" aria-label="<?php esc_attr_e( 'Get a free eBook', 'pastor-adewale' ); ?>"><?php echo pa_icon( 'gift' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
			<a class="circ" href="<?php echo esc_url( pa_url( 'donate' ) ); ?>" aria-label="<?php esc_attr_e( 'Give', 'pastor-adewale' ); ?>"><?php echo pa_icon( 'heart' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
		</div>
		<?php if ( count( $slides ) > 1 ) : ?>
			<div class="dots" role="tablist" aria-label="<?php esc_attr_e( 'Choose slide', 'pastor-adewale' ); ?>">
				<?php foreach ( $slides as $i => $s ) : ?>
					<button type="button" role="tab" aria-label="<?php echo esc_attr( sprintf( /* translators: 1: slide number, 2: title */ __( 'Slide %1$d: %2$s', 'pastor-adewale' ), $i + 1, $s['title'] ) ); ?>" aria-current="<?php echo 0 === $i ? 'true' : 'false'; ?>"></button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	<div class="hc">
		<div class="tstack" aria-live="polite">
			<?php foreach ( $slides as $i => $s ) : ?>
				<div class="tslide<?php echo 0 === $i ? ' on' : ''; ?>">
					<?php if ( $s['eyebrow'] ) : ?><p class="hk"><?php echo esc_html( $s['eyebrow'] ); ?></p><?php endif; ?>
					<?php echo 0 === $i ? '<h1 class="t-title">' : '<h2 class="t-title">'; ?><?php echo esc_html( $s['title'] ); ?><?php echo 0 === $i ? '</h1>' : '</h2>'; ?>
					<?php if ( $s['text'] ) : ?><p class="hp"><?php echo esc_html( $s['text'] ); ?></p><?php endif; ?>
					<?php if ( $s['btn_label'] && $s['btn_url'] ) : ?><a class="btn btn-primary btn-lg" href="<?php echo esc_url( $s['btn_url'] ); ?>"><?php echo esc_html( $s['btn_label'] ); ?></a><?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<a class="startlink" href="<?php echo esc_url( pa_url( 'start' ) ); ?>"><?php esc_html_e( 'New here? Start here', 'pastor-adewale' ); ?> <?php echo pa_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
		<?php if ( $books->have_posts() ) : ?>
			<button type="button" class="down" data-scroll="#topBooks"><?php esc_html_e( 'Top books and resources', 'pastor-adewale' ); ?> <span class="dcirc"><?php echo pa_icon( 'chev' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></button>
		<?php endif; ?>
	</div>
</section>

<?php if ( $series && ! is_wp_error( $series ) ) : ?>
	<div class="wrap"><div class="feature-strip">
		<?php foreach ( $series as $term ) { get_template_part( 'template-parts/card-series', null, array( 'term' => $term ) ); } ?>
	</div></div>
<?php endif; ?>

<div class="section" id="contWatch" hidden style="padding-bottom:0"><div class="wrap"><div class="cw"></div></div></div>

<div class="section" style="padding-bottom:0"><div class="wrap"><div class="startband"><div><h2><?php esc_html_e( 'New here? Start here.', 'pastor-adewale' ); ?></h2><p><?php esc_html_e( 'Four simple steps to begin, from the basics of the faith to prayer, Bible study and community.', 'pastor-adewale' ); ?></p></div><a class="btn btn-gold" href="<?php echo esc_url( pa_url( 'start' ) ); ?>"><?php esc_html_e( 'Begin the pathway', 'pastor-adewale' ); ?></a></div></div></div>

<div class="section"><div class="wrap intro">
	<div>
		<h2><?php esc_html_e( 'Bible teaching and Christian discipling', 'pastor-adewale' ); ?></h2>
		<p><?php esc_html_e( 'Our passion is to teach the Bible and help believers live fully through Jesus and a sound understanding of God\'s Word. Use the free resources here to equip your faith and strengthen the people around you.', 'pastor-adewale' ); ?></p>
		<p><a class="link" href="<?php echo esc_url( pa_url( 'free-ebook' ) ); ?>"><?php echo pa_icon( 'gift' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Get a free eBook', 'pastor-adewale' ); ?></a></p>
	</div>
	<div class="pillars">
		<div class="pillar"><?php echo pa_icon( 'play' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><b><?php esc_html_e( 'Teach', 'pastor-adewale' ); ?></b><span><?php esc_html_e( 'Messages and series built on Scripture.', 'pastor-adewale' ); ?></span></div>
		<div class="pillar"><?php echo pa_icon( 'cap' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><b><?php esc_html_e( 'Train', 'pastor-adewale' ); ?></b><span><?php esc_html_e( 'Bible School lessons you can take at your pace.', 'pastor-adewale' ); ?></span></div>
		<div class="pillar"><?php echo pa_icon( 'book' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><b><?php esc_html_e( 'Equip', 'pastor-adewale' ); ?></b><span><?php esc_html_e( 'Books, notes and guides to take with you.', 'pastor-adewale' ); ?></span></div>
		<div class="pillar"><?php echo pa_icon( 'users' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><b><?php esc_html_e( 'Send', 'pastor-adewale' ); ?></b><span><?php esc_html_e( 'Outreach that carries the Word to new places.', 'pastor-adewale' ); ?></span></div>
	</div>
</div></div>

<?php if ( $teach->have_posts() ) : ?>
	<div class="section band"><div class="wrap">
		<div class="s-head"><div><h2><?php esc_html_e( 'Recently added teachings', 'pastor-adewale' ); ?></h2></div><a class="link" href="<?php echo esc_url( get_post_type_archive_link( 'teaching' ) ); ?>"><?php esc_html_e( 'View all teachings', 'pastor-adewale' ); ?> <?php echo pa_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></div>
		<div class="grid3"><?php while ( $teach->have_posts() ) { $teach->the_post(); get_template_part( 'template-parts/card', 'teaching' ); } wp_reset_postdata(); ?></div>
	</div></div>
<?php endif; ?>

<?php if ( $news->have_posts() ) : ?>
	<div class="section"><div class="wrap">
		<div class="s-head"><div><h2><?php esc_html_e( 'Latest news', 'pastor-adewale' ); ?></h2><p><?php esc_html_e( 'Teaching releases, ministry activity and ways to take part.', 'pastor-adewale' ); ?></p></div><a class="link" href="<?php echo esc_url( pa_url( 'news' ) ); ?>"><?php esc_html_e( 'All news', 'pastor-adewale' ); ?> <?php echo pa_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></div>
		<div class="grid3"><?php while ( $news->have_posts() ) { $news->the_post(); get_template_part( 'template-parts/card' ); } wp_reset_postdata(); ?></div>
	</div></div>
<?php endif; ?>

<?php if ( $books->have_posts() ) : ?>
	<div class="section band" id="topBooks"><div class="wrap">
		<div class="s-head"><div><h2><?php esc_html_e( 'Top books and free downloads', 'pastor-adewale' ); ?></h2><p><?php esc_html_e( 'Download a free PDF for personal study or your small group.', 'pastor-adewale' ); ?></p></div><a class="link" href="<?php echo esc_url( get_post_type_archive_link( 'resource' ) ); ?>"><?php esc_html_e( 'Browse all', 'pastor-adewale' ); ?> <?php echo pa_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></div>
		<div class="scroller"><?php while ( $books->have_posts() ) { $books->the_post(); get_template_part( 'template-parts/card-resource', null, array( 'variant' => 'book' ) ); } wp_reset_postdata(); ?></div>
	</div></div>
<?php endif; ?>

<?php if ( $stories->have_posts() ) : ?>
	<div class="section"><div class="wrap">
		<div class="s-head"><div><h2><?php esc_html_e( 'Faith is alive in real lives', 'pastor-adewale' ); ?></h2><p><?php esc_html_e( 'Stories shared by people who study God\'s Word with us.', 'pastor-adewale' ); ?></p></div><a class="link" href="<?php echo esc_url( get_post_type_archive_link( 'testimony' ) ); ?>"><?php esc_html_e( 'Read testimonies', 'pastor-adewale' ); ?> <?php echo pa_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></div>
		<div class="grid3"><?php while ( $stories->have_posts() ) { $stories->the_post(); get_template_part( 'template-parts/card-testimony' ); } wp_reset_postdata(); ?></div>
	</div></div>
<?php endif; ?>

<div class="section band"><div class="wrap trio">
	<a class="tri" href="<?php echo esc_url( pa_url( 'pastor' ) ); ?>"><h3><?php esc_html_e( 'About Pastor Adewale', 'pastor-adewale' ); ?></h3><p><?php esc_html_e( 'The life, calling and teaching ministry behind this work.', 'pastor-adewale' ); ?></p><span class="link"><?php esc_html_e( 'Read his story', 'pastor-adewale' ); ?> <?php echo pa_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></a>
	<a class="tri" href="<?php echo esc_url( pa_url( 'about' ) ); ?>"><h3><?php esc_html_e( 'Who We Are', 'pastor-adewale' ); ?></h3><p><?php esc_html_e( 'Our vision, mission and what we believe.', 'pastor-adewale' ); ?></p><span class="link"><?php esc_html_e( 'Our vision & beliefs', 'pastor-adewale' ); ?> <?php echo pa_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></a>
	<a class="tri" href="<?php echo esc_url( pa_url( 'outreaches' ) ); ?>"><h3><?php esc_html_e( 'Outreaches', 'pastor-adewale' ); ?></h3><p><?php esc_html_e( 'Practical outreach that carries the Word to people who need it.', 'pastor-adewale' ); ?></p><span class="link"><?php esc_html_e( 'See our outreaches', 'pastor-adewale' ); ?> <?php echo pa_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></a>
</div></div>

<?php if ( pa_opt( 'quote_text' ) ) : ?>
	<div class="quote"><div class="wrap">
		<div class="portrait photo" role="img" aria-label="<?php echo esc_attr( $name ); ?>" style="background-image:url('<?php echo esc_url( pa_photo_url() ); ?>')"></div>
		<div>
			<blockquote>“<?php echo esc_html( pa_opt( 'quote_text' ) ); ?>”</blockquote>
			<cite><?php echo esc_html( pa_opt( 'quote_cite', $name ) ); ?></cite>
			<p style="margin-top:22px"><a class="btn btn-ghost" href="<?php echo esc_url( pa_url( 'pastor' ) ); ?>"><?php esc_html_e( 'About Pastor Adewale', 'pastor-adewale' ); ?></a></p>
		</div>
	</div></div>
<?php endif; ?>

<div class="cta"><div class="wrap">
	<div><h2><?php esc_html_e( 'Get a free eBook', 'pastor-adewale' ); ?></h2><p><?php esc_html_e( 'Start your library with a free eBook when you subscribe to our community updates.', 'pastor-adewale' ); ?></p></div>
	<a class="btn" style="background:#3b0f24;color:#fff" href="<?php echo esc_url( pa_url( 'free-ebook' ) ); ?>"><?php esc_html_e( 'Free download', 'pastor-adewale' ); ?></a>
</div></div>

<?php get_footer(); ?>
