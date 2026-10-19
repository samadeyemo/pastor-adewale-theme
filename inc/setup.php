<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function pa_faq_block( $q, $a ) {
	return '<!-- wp:details --><details class="wp-block-details"><summary>' . esc_html( $q ) . '</summary><!-- wp:paragraph --><p>' . esc_html( $a ) . '</p><!-- /wp:paragraph --></details><!-- /wp:details -->' . "\n";
}

/** Starter pages: slug => array( title, template, content ). */
function pa_starter_pages() {
	$faq  = pa_faq_block( 'Are your resources free?', 'Most teachings and study notes are free to read, watch or download. Some printed books may have a cost to cover production.' );
	$faq .= pa_faq_block( 'How do I join Bible School?', 'Open the Bible School page, choose a course and follow the steps. If you need help, send us a message.' );
	$faq .= pa_faq_block( 'How can I give to the ministry?', 'Use the Donate page to give by card or bank transfer.' );
	$faq .= pa_faq_block( 'Can Pastor Dr Adewale ABC speak at my church or event?', 'Send an invitation through the contact form with the date, place and audience.' );
	$faq .= pa_faq_block( 'Can I share your teachings?', 'Yes. Please share the link, and keep the teaching and its source intact.' );
	$faq .= pa_faq_block( 'How do I request prayer?', 'Use the Request Prayer page. Your request goes to the prayer team only.' );

	return array(
		'start'       => array( 'Start Here', 'templates/start.php', '' ),
		'resources'   => array( 'Resources', 'templates/resources.php', '' ),
		'series'      => array( 'Teaching Series', 'templates/series.php', '' ),
		'news'        => array( 'News', '', '' ),
		'outreaches'  => array( 'Outreaches', 'templates/outreaches.php', '<h2 id="heart">The heart behind the mission</h2><p>Our outreaches turn faith into action. We focus on specific needs and places, and give believers the resources to grow: Bible teaching, digital media and discipleship training.</p><p>They rest on one conviction: the Word of God changes lives, and every believer should be able to hear it clearly in their own language.</p><h2 id="action">Our mission in action</h2><h3>Discipleship and leadership training</h3><p>Equipping pastors and church leaders with sound teaching so local churches can grow strong from the inside.</p><h3>Media and digital outreach</h3><p>Taking teaching to where people already are: video, social media and online study.</p><h3>Local-language teaching</h3><p>Making key teachings available in the languages people think and pray in.</p><h3>Bible teaching and education</h3><p>Courses, study groups and printed resources that help believers understand Scripture for themselves.</p><h2 id="regions">Where we serve</h2><p>[List the states, cities and countries where the ministry is active.]</p>' ),
		'about'       => array( 'Our Vision & Beliefs', 'templates/about.php', '<h2>Who we are</h2>
<p><strong>Simple God As ABC Ministry</strong> is a Bible teaching ministry founded by Pastor Dr Adewale A.B.C. Oluranti. Our passion is to demystify God and make Him as simple as ABC to the common man.</p>
<p>We believe lives change when people meet Jesus, and we help people grow through clear, Scripture-based teaching and discipleship.</p>

<h2>Our vision</h2>
<p>To make God simple and bring His Word to every home in Nigeria and beyond.</p>

<h2>Our mission</h2>
<p><strong>Teach · Train · Equip · Send</strong></p>
<ul>
<li><strong>Teach</strong> — Messages and series built on Scripture</li>
<li><strong>Train</strong> — Bible School lessons you can take at your pace</li>
<li><strong>Equip</strong> — Books, notes and guides to take with you</li>
<li><strong>Send</strong> — Outreach that carries the Word to new places</li>
</ul>

<h2>What we believe</h2>
<ul>
<li>The Holy Bible as the Word of God</li>
<li>Salvation through Jesus Christ alone</li>
<li>The person and work of the Holy Spirit</li>
<li>Faith, prayer and divine preservation</li>
</ul>

<h2>Our motto</h2>
<p><em>2026 IS THE BEST — My God is as Simple as ABC — SHALOM</em></p>' ),
		'pastor'      => array( 'Pastor Dr Adewale A.B.C. Oluranti: Life & Ministry', 'templates/pastor.php', '<blockquote>Faith is not complicated. Prayer is not hard. The Word works.</blockquote>
<p>Olusoagutan Omowe Adewale A.B.C is the Founder and Lead Pastor of <strong>Simple God As ABC Ministry</strong>. Called in a season of silent battles and unseen tears, God preserved him to become a voice of hope.</p>
<p>His passion is to demystify God and make Him as simple as ABC to the common man. He is a teacher of the Word, author of several books on faith and prayer, and host of the weekly ABC Bible School.</p>
<p>His message is simple: Faith is not complicated, Prayer is not hard, The Word works.</p>
<p><strong>Motto:</strong> 2026 IS THE BEST — My God is as Simple as ABC — SHALOM</p>' ),
		'donate'      => array( 'Donate', 'templates/donate.php', '<h2>Why your donation matters</h2><p>We rely on donations to teach the Bible and reach people who have not heard it clearly. It is a service of love and part of fulfilling the Great Commission.</p><h3>Other ways to give</h3><p>You can give by bank transfer, in person at a service, or through a partner church. Please contact us and we will guide you.</p><h3>Legacy giving</h3><p>Invest in the Kingdom with a gift in your will. Contact us to talk about it.</p>' ),
		'contact'     => array( 'Contact Us', 'templates/contact.php', '' ),
		'prayer'      => array( 'Request Prayer', 'templates/prayer.php', '' ),
		'question'    => array( 'Ask a Bible Question', 'templates/question.php', '' ),
		'story'       => array( 'Share Your Story', 'templates/story.php', '' ),
		'free-ebook'  => array( 'Get a Free eBook', 'templates/ebook.php', '' ),
		'connect'     => array( 'Connect With Us', '', '<p>Find the way to stay close that suits you.</p><ul><li>Subscribe for new teachings and a free eBook.</li><li>Ask about joining a study group near you or online.</li><li>Offer to volunteer with media, translation, events or prayer.</li></ul>' ),
		'pray-for-us' => array( 'Pray For Us', '', '<p>Join us in seeking God\'s wisdom, protection and breakthrough as we serve.</p><h2>This week\'s prayer points</h2><ul><li>[Add this week\'s prayer points here.]</li></ul><p>Need prayer yourself? You can send a request on the Request Prayer page.</p>' ),
		'faqs'        => array( 'Frequently Asked Questions', '', $faq ),
	);
}

/** Create missing pages, menus and the static front page. Never overwrites existing pages. */
function pa_create_starter() {
	$ids = array();
	foreach ( pa_starter_pages() as $slug => $def ) {
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			$ids[ $slug ] = (int) $existing->ID;
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $def[0],
				'post_name'    => $slug,
				'post_content' => $def[2],
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			if ( $def[1] ) {
				update_post_meta( $id, '_wp_page_template', $def[1] );
			}
			$ids[ $slug ] = (int) $id;
		}
	}

	// Home page.
	$home = get_page_by_path( 'home' );
	$hid  = $home ? (int) $home->ID : (int) wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Home', 'post_name' => 'home' ) );
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $hid );
	if ( ! empty( $ids['news'] ) ) {
		update_option( 'page_for_posts', $ids['news'] );
	}

	if ( '' === get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}
	if ( 'Just another WordPress site' === get_option( 'blogdescription' ) ) {
		update_option( 'blogdescription', 'My God is as Simple as ABC — Bible teaching for everyday faith' );
	update_option( 'blogname', 'Simple God As ABC Ministry' );
	}
	update_option( 'default_comment_status', 'closed' );

	$page = function ( $title, $slug, $hash = '' ) use ( $ids ) {
		return isset( $ids[ $slug ] ) ? array( 'title' => $title, 'id' => $ids[ $slug ], 'hash' => $hash ) : null;
	};
	$link = function ( $title, $url ) {
		return array( 'title' => $title, 'url' => $url );
	};

	pa_build_menu( 'Primary', 'primary', array_filter( array( $page( 'Resources', 'resources' ), $page( 'News', 'news' ), $page( 'Outreaches', 'outreaches' ), $page( 'About', 'about' ) ) ) );
	pa_build_menu( 'Menu: Explore', 'menu_explore', array_filter( array( $link( 'Home', home_url( '/' ) ), $page( 'Start Here', 'start' ), $page( 'Resources', 'resources' ), $page( 'Teaching Series', 'series' ), $page( 'News', 'news' ), $page( 'Outreaches', 'outreaches' ) ) ) );
	pa_build_menu( 'Menu: About', 'menu_about', array_filter( array( $page( 'Our Vision & Beliefs', 'about' ), $page( 'Pastor Adewale: Life & Ministry', 'pastor' ), $link( 'Testimonies', get_post_type_archive_link( 'testimony' ) ), isset( $ids['outreaches'] ) ? $link( 'Where We Serve', get_permalink( $ids['outreaches'] ) . '#regions' ) : null ) ) );
	pa_build_menu( 'Menu: Get involved', 'menu_involved', array_filter( array( $page( 'Partner With Us', 'donate' ), $page( 'Connect With Us', 'connect' ), $page( 'Pray For Us', 'pray-for-us' ), $page( 'Share Your Story', 'story' ) ) ) );
	pa_build_menu( 'Menu: Contact', 'menu_contact', array_filter( array( $page( 'Contact Us', 'contact' ), $page( 'Request Prayer', 'prayer' ), $page( 'Ask a Bible Question', 'question' ), $page( 'Frequently Asked Questions', 'faqs' ) ) ) );
	$legal = array_filter( array( $page( 'Contact', 'contact' ) ) );
	$priv  = (int) get_option( 'wp_page_for_privacy_policy' );
	if ( $priv && 'publish' === get_post_status( $priv ) ) {
		$legal[] = array( 'title' => 'Privacy', 'id' => $priv, 'hash' => '' );
	}
	pa_build_menu( 'Footer: legal', 'footer_legal', $legal );


	// Seed ministry settings with client details (only if empty).
	$existing = get_option( 'pa_settings', array() );
	if ( ! is_array( $existing ) ) { $existing = array(); }
	$defaults = array(
		'pastor_name'     => 'Pastor Dr Adewale A.B.C. Oluranti',
		'brand_initials'  => 'ABC',
		'notify_email'    => 'adewaleabc@gmail.com',
		'phone'           => '08122777279 / 08038017766',
		'whatsapp'        => 'https://wa.me/2348072507272',
		'address'         => "12, Oyetaiwo Street, off former de Castle Hotel,\nopposite Ajorosun Club House, Alagbafo Area,\nKube Total Garden, Ibadan, Oyo State, Nigeria",
		'social_facebook' => 'https://facebook.com/simplegodasabcministry',
		'quote_text'      => 'Faith is not complicated. Prayer is not hard. The Word works.',
		'quote_cite'      => 'Pastor Dr Adewale A.B.C. Oluranti',
	);
	foreach ( $defaults as $k => $v ) {
		if ( empty( $existing[ $k ] ) ) {
			$existing[ $k ] = $v;
		}
	}
	update_option( 'pa_settings', $existing );

	flush_rewrite_rules();
	update_option( 'pa_setup_done', 1 );
}

function pa_build_menu( $name, $location, $items ) {
	$menu = wp_get_nav_menu_object( $name );
	$id   = $menu ? (int) $menu->term_id : wp_create_nav_menu( $name );
	if ( is_wp_error( $id ) ) {
		return;
	}
	$existing = wp_get_nav_menu_items( $id );
	if ( empty( $existing ) ) {
		foreach ( $items as $it ) {
			if ( isset( $it['id'] ) ) {
				$data = array( 'menu-item-title' => $it['title'], 'menu-item-object' => 'page', 'menu-item-object-id' => $it['id'], 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' );
			} else {
				$data = array( 'menu-item-title' => $it['title'], 'menu-item-url' => $it['url'], 'menu-item-type' => 'custom', 'menu-item-status' => 'publish' );
			}
			wp_update_nav_menu_item( $id, 0, $data );
		}
	}
	$locs              = get_theme_mod( 'nav_menu_locations', array() );
	$locs[ $location ] = $id;
	set_theme_mod( 'nav_menu_locations', $locs );
}

/** Run the starter once, when the theme is first activated. */
function pa_first_activation() {
	if ( ! get_option( 'pa_setup_done' ) ) {
		pa_create_starter();
	}
}
add_action( 'after_switch_theme', 'pa_first_activation', 20 );

/* ---------- Admin buttons ---------- */
function pa_admin_action( $action, $callback, $done ) {
	add_action(
		'admin_post_' . $action,
		function () use ( $action, $callback, $done ) {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have permission to do this.', 'pastor-adewale' ), 403 );
			}
			check_admin_referer( $action );
			call_user_func( $callback );
			wp_safe_redirect( admin_url( 'options-general.php?page=pa-settings&pa_done=' . $done ) );
			exit;
		}
	);
}
pa_admin_action( 'pa_run_setup', 'pa_create_starter', 'setup' );
pa_admin_action( 'pa_load_sample', 'pa_load_sample', 'sample' );
pa_admin_action( 'pa_remove_sample', 'pa_remove_sample', 'clean' );

/* ---------- Sample content (clearly marked, fully removable) ---------- */
function pa_load_sample() {
	$created = (array) get_option( 'pa_sample_terms', array() );
	$term    = function ( $name, $tax, $args = array() ) use ( &$created ) {
		$t = term_exists( $name, $tax );
		if ( ! $t ) {
			$t = wp_insert_term( $name, $tax, $args );
			if ( is_wp_error( $t ) ) {
				return 0;
			}
			$created[] = array( (int) $t['term_id'], $tax );
		}
		return is_array( $t ) ? (int) $t['term_id'] : (int) $t;
	};
	$post = function ( $args, $meta = array() ) {
		$id = wp_insert_post( array_merge( array( 'post_status' => 'publish' ), $args ), true );
		if ( is_wp_error( $id ) ) {
			return 0;
		}
		update_post_meta( $id, '_pa_sample', 1 );
		foreach ( $meta as $k => $v ) {
			update_post_meta( $id, $k, $v );
		}
		return $id;
	};
	$note = 'Sample content. Replace this with the real text.';

	$topics = array();
	foreach ( array( 'Faith', 'Prayer', 'Christian Living', 'Bible Study', 'Family' ) as $n ) {
		$topics[ $n ] = $term( $n, 'topic' );
	}
	$types = array();
	foreach ( array( 'Book', 'Study Guide', 'Teaching Notes' ) as $n ) {
		$types[ $n ] = $term( $n, 'resource_type' );
	}
	$series = array(
		'foundations'    => $term( 'Foundations for a Life of Faith', 'series', array( 'description' => 'Core truths of the Christian life, taught step by step with study notes for every lesson.' ) ),
		'prayer'         => $term( 'Growing in Prayer', 'series', array( 'description' => 'Practical teaching to build a steady, Scripture-shaped prayer life.' ) ),
		'everyday-faith' => $term( 'Faith in Everyday Life', 'series', array( 'description' => 'Bring biblical wisdom into your work, family and everyday decisions.' ) ),
	);
	$pastor   = pa_pastor_name();
	$speakers = array( $pastor => $term( $pastor, 'speaker' ), 'Teaching team' => $term( 'Teaching team', 'speaker' ) );

	$teachings = array(
		array( 'Building a Faith That Stands', 'foundations', 1, 'Faith', $pastor, '28 min', '2026-09-06', 'Practical foundations for trusting God through changing seasons.' ),
		array( 'Understanding the Word in Context', 'foundations', 2, 'Bible Study', 'Teaching team', '22 min', '2025-11-09', 'Simple principles for reading Scripture carefully and faithfully.' ),
		array( 'Growing Through Every Season', 'foundations', 3, 'Faith', 'Teaching team', '31 min', '2025-06-15', 'A message about perseverance, hope and spiritual maturity.' ),
		array( 'A Life Rooted in Prayer', 'prayer', 1, 'Prayer', $pastor, '34 min', '2026-08-02', 'Discover a more consistent and Scripture-shaped prayer life.' ),
		array( 'Praying with Scripture', 'prayer', 2, 'Prayer', $pastor, '26 min', '2025-09-21', 'Turn the words of the Bible into your own prayers.' ),
		array( 'The Practice of Gratitude', 'prayer', 3, 'Christian Living', $pastor, '16 min', '2026-07-12', 'A short teaching with reflection prompts for the week ahead.' ),
		array( 'Faith in Everyday Decisions', 'everyday-faith', 1, 'Christian Living', $pastor, '30 min', '2026-05-24', 'Bring biblical wisdom into your relationships, work and choices.' ),
		array( 'Hearing God in the Everyday', 'everyday-faith', 2, 'Christian Living', 'Teaching team', '24 min', '2024-10-13', 'Learn to recognise God\'s guidance in ordinary moments.' ),
		array( 'Integrity at Work', 'everyday-faith', 3, 'Christian Living', $pastor, '27 min', '2024-04-07', 'Living out your faith on the job, when no one is watching.' ),
	);
	foreach ( $teachings as $t ) {
		$id = $post( array( 'post_type' => 'teaching', 'post_title' => $t[0], 'post_excerpt' => $t[7], 'post_content' => '<p>' . $note . '</p>', 'post_date' => $t[6] . ' 09:00:00' ), array( '_pa_order' => $t[2], '_pa_duration' => $t[5] ) );
		if ( $id ) {
			wp_set_object_terms( $id, array( $series[ $t[1] ] ), 'series' );
			wp_set_object_terms( $id, array( $topics[ $t[3] ] ), 'topic' );
			wp_set_object_terms( $id, array( $speakers[ $t[4] ] ), 'speaker' );
		}
	}

	$resources = array(
		array( 'A Guide to Personal Bible Study', 'Study Guide', 'A practical guide with reading prompts and questions for individual or group study.', 'PDF · 18 pages' ),
		array( 'Notes for a Life of Prayer', 'Teaching Notes', 'A concise companion with key Scriptures and reflection points.', 'PDF · 8 pages' ),
		array( 'Foundations of Faith', 'Book', 'A sample digital book for foundational Christian teaching.', 'PDF · 42 pages' ),
		array( 'Weekly Reflection Journal', 'Study Guide', 'Prompts to reflect on a teaching and apply it through the week.', 'PDF · 12 pages' ),
		array( 'Understanding the Teaching', 'Teaching Notes', 'Key points and Scripture references to revisit after a message.', 'PDF · 6 pages' ),
		array( 'Walking in Wisdom', 'Book', 'A sample resource on practical biblical principles and Christian living.', 'PDF · 36 pages' ),
	);
	foreach ( $resources as $r ) {
		$id = $post( array( 'post_type' => 'resource', 'post_title' => $r[0], 'post_excerpt' => $r[2], 'post_content' => '<p>' . $note . '</p>' ), array( '_pa_label' => $r[3] ) );
		if ( $id ) {
			wp_set_object_terms( $id, array( $types[ $r[1] ] ), 'resource_type' );
		}
	}

	$courses = array(
		array( 'Foundations of the Christian Faith', 'Explore essential biblical themes through guided lessons and reflection questions.', '6 lessons · Self-paced' ),
		array( 'Growing a Life of Prayer', 'Build a steady prayer practice with Scripture, practical prompts and reflection.', '4 lessons · Study notes' ),
		array( 'Understanding Scripture', 'Learn simple approaches to context, interpretation and applying biblical truth.', '5 lessons · Self-paced' ),
	);
	foreach ( $courses as $i => $c ) {
		$post( array( 'post_type' => 'course', 'post_title' => $c[0], 'post_excerpt' => $c[1], 'post_content' => '<p>' . $note . '</p>', 'menu_order' => $i ), array( '_pa_lessons' => $c[2] ) );
	}

	$testimonies = array(
		array( 'This teaching helped me return to Scripture with fresh understanding and apply it to my daily decisions.', 'A community member', 'Bible Study' ),
		array( 'I found a lesson I could revisit, take notes from, and share with my family during the week.', 'A regular visitor', 'Family' ),
		array( 'Learning to pray with Scripture changed how I start every morning. I no longer rush through it.', 'A Bible School student', 'Prayer' ),
		array( 'In a hard season, the message on perseverance reminded me that God had not left me.', 'A listener', 'Faith' ),
		array( 'We now study the weekly notes together as a family on Sunday evenings.', 'A parent', 'Family' ),
		array( 'The course made the Bible make sense to me for the first time.', 'A new believer', 'Bible Study' ),
	);
	foreach ( $testimonies as $t ) {
		$id = $post( array( 'post_type' => 'testimony', 'post_title' => wp_trim_words( $t[0], 6, '' ), 'post_content' => $t[0] ), array( '_pa_who' => $t[1] ) );
		if ( $id ) {
			wp_set_object_terms( $id, array( $topics[ $t[2] ] ), 'topic' );
		}
	}

	$stories = array(
		array( 'A new Bible study group opens in Ibadan', 'Twelve neighbours now meet weekly to study a lesson together and pray for one another.', 'Ibadan' ),
		array( 'Teaching booklets reach a rural church', 'Printed study notes helped a small congregation start a regular midweek class.', 'Oyo State' ),
		array( 'First Yorùbá lesson recorded', 'The first teaching in Yorùbá is ready, so more believers can study in their own language.', 'Translation' ),
	);
	foreach ( $stories as $s ) {
		$post( array( 'post_type' => 'outreach', 'post_title' => $s[0], 'post_excerpt' => $s[1], 'post_content' => '<p>' . $s[1] . '</p>' ), array( '_pa_place' => $s[2] ) );
	}

	$qas = array(
		array( 'How do I read the Bible when I don\'t understand it?', 'Start with one of the Gospels, read a short passage slowly, and ask three questions: What does it say? What did it mean then? What does it mean for me now?' ),
		array( 'Why does it feel like my prayers are not answered?', 'Scripture shows God hears every prayer, but His answer may be yes, no or wait. Keep praying, keep reading His Word, and pray with others.' ),
		array( 'How can I know God\'s will for a decision?', 'Pray, study what Scripture already says, seek wise counsel from mature believers, and look at how God is opening and closing doors.' ),
	);
	foreach ( $qas as $q ) {
		$post( array( 'post_type' => 'qa', 'post_title' => $q[0], 'post_content' => '<p>' . $q[1] . '</p>' ) );
	}

	foreach ( array( 'Bible School enrolment opens', 'A week of prayer and fasting', 'New teaching released: Building a Faith That Stands' ) as $i => $title ) {
		$post( array( 'post_type' => 'post', 'post_title' => $title, 'post_excerpt' => $note, 'post_content' => '<p>' . $note . '</p>', 'post_date' => gmdate( 'Y-m-d H:i:s', strtotime( '-' . ( $i * 9 + 2 ) . ' days' ) ) ) );
	}

	$slides = array(
		array( $pastor, '🙏 Welcome. Bible teaching for everyday faith.', 'Watch full-length messages on faith, prayer and Christian living, taught clearly from Scripture.', 'Watch now', get_post_type_archive_link( 'teaching' ), '1' ),
		array( 'Bible School', '🌱 Learn more about the Bible and grow your faith.', 'Follow guided lessons with Scripture references, study notes and reflection questions at your own pace.', 'Study God\'s Word', get_post_type_archive_link( 'course' ), '' ),
		array( 'Books & downloads', '📖 Books and guides to take with you.', 'Study guides, teaching notes and books for your personal study or small group.', 'Browse resources', get_post_type_archive_link( 'resource' ), '' ),
		array( 'Get a free eBook', '🎁 Start your library for free.', 'Subscribe to our community updates and we will send your free eBook, plus new teachings as they are released.', 'Free download', pa_url( 'free-ebook' ), '' ),
	);
	foreach ( $slides as $i => $s ) {
		$post( array( 'post_type' => 'hero_slide', 'post_title' => $s[0], 'post_excerpt' => $s[2], 'menu_order' => $i + 1 ), array( '_pa_eyebrow' => $s[1], '_pa_btn_label' => $s[3], '_pa_btn_url' => $s[4], '_pa_use_photo' => $s[5] ) );
	}

	update_option( 'pa_sample_terms', $created );
}

function pa_remove_sample() {
	$ids = get_posts( array( 'post_type' => 'any', 'post_status' => 'any', 'posts_per_page' => -1, 'fields' => 'ids', 'meta_key' => '_pa_sample', 'meta_value' => '1' ) );
	foreach ( $ids as $id ) {
		wp_delete_post( $id, true );
	}
	foreach ( (array) get_option( 'pa_sample_terms', array() ) as $t ) {
		if ( isset( $t[0], $t[1] ) ) {
			wp_delete_term( (int) $t[0], $t[1] );
		}
	}
	delete_option( 'pa_sample_terms' );
}
