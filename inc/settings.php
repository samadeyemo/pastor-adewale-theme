<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Settings field map: key => array( label, type, help, section ). */
function pa_settings_fields() {
	return array(
		'pastor_name'        => array( __( 'Pastor name', 'pastor-adewale' ), 'text', __( 'Shown in the hero, captions and structured data.', 'pastor-adewale' ), 'general' ),
		'brand_initials'     => array( __( 'Logo initials', 'pastor-adewale' ), 'text', __( 'Two letters shown in the round logo, e.g. AO. A Custom Logo (Appearance → Customize) replaces this.', 'pastor-adewale' ), 'general' ),
		'photo_id'           => array( __( 'Pastor photo (profile / hero)', 'pastor-adewale' ), 'media', __( 'Main photo at the top of the home hero and pastor page. Square or portrait, at least 600 px wide. You can replace this anytime.', 'pastor-adewale' ), 'general' ),
		'bible_image_id'     => array( __( 'Bible School image', 'pastor-adewale' ), 'media', __( 'Optional image for Bible School cards and sections. Leave empty to use the default style.', 'pastor-adewale' ), 'general' ),
		'hero_bg_id'         => array( __( 'Hero background image', 'pastor-adewale' ), 'media', __( 'Optional wide background behind the home hero text. Recommended 1600×900 or larger.', 'pastor-adewale' ), 'general' ),
		'quote_text'         => array( __( 'Home page quote', 'pastor-adewale' ), 'textarea', __( 'A short quote from the pastor. The quote section stays hidden until you add one.', 'pastor-adewale' ), 'general' ),
		'quote_cite'         => array( __( 'Quote credit', 'pastor-adewale' ), 'text', '', 'general' ),
		'registration'       => array( __( 'Registration details', 'pastor-adewale' ), 'text', __( 'For the footer, e.g. the CAC registration number.', 'pastor-adewale' ), 'general' ),
		'notify_email'       => array( __( 'Notification email', 'pastor-adewale' ), 'email', __( 'Form messages, prayer requests, questions and donations are emailed here. Defaults to the site admin email.', 'pastor-adewale' ), 'contact' ),
		'phone'              => array( __( 'Phone / WhatsApp number', 'pastor-adewale' ), 'text', '', 'contact' ),
		'whatsapp'           => array( __( 'WhatsApp community link', 'pastor-adewale' ), 'url', __( 'Invite link shown on the Connect page. Leave empty to hide it.', 'pastor-adewale' ), 'contact' ),
		'address'            => array( __( 'Address', 'pastor-adewale' ), 'textarea', '', 'contact' ),
		'social_facebook'    => array( 'Facebook', 'url', '', 'social' ),
		'social_youtube'     => array( 'YouTube', 'url', '', 'social' ),
		'social_instagram'   => array( 'Instagram', 'url', '', 'social' ),
		'social_x'           => array( 'X', 'url', '', 'social' ),
		'social_pinterest'   => array( 'Pinterest', 'url', '', 'social' ),
		'gift_tiers'         => array( __( 'Gift amounts', 'pastor-adewale' ), 'textarea', __( 'One per line: amount|what it does. Example: 5000|Places a Bible study book in the hands of a new believer. Edit to match your real costs.', 'pastor-adewale' ), 'giving' ),
		'paystack_public'    => array( __( 'Paystack public key', 'pastor-adewale' ), 'text', __( 'Starts with pk_live_ or pk_test_.', 'pastor-adewale' ), 'giving' ),
		'paystack_secret'    => array( __( 'Paystack secret key', 'pastor-adewale' ), 'password', __( 'Starts with sk_live_ or sk_test_. Safer: define PA_PAYSTACK_SECRET in wp-config.php instead. Leave blank to keep the saved key.', 'pastor-adewale' ), 'giving' ),
		'bank_name'          => array( __( 'Bank name', 'pastor-adewale' ), 'text', '', 'giving' ),
		'bank_account_name'  => array( __( 'Account name', 'pastor-adewale' ), 'text', '', 'giving' ),
		'bank_account_number'=> array( __( 'Account number', 'pastor-adewale' ), 'text', '', 'giving' ),
		'ebook_title'        => array( __( 'Free eBook title', 'pastor-adewale' ), 'text', '', 'ebook' ),
		'ebook_url'          => array( __( 'Free eBook PDF link', 'pastor-adewale' ), 'url', __( 'Upload the PDF in Media and paste the link. Shown after someone subscribes.', 'pastor-adewale' ), 'ebook' ),
	);
}

function pa_settings_sections() {
	return array(
		'general' => __( 'Identity', 'pastor-adewale' ),
		'contact' => __( 'Contact', 'pastor-adewale' ),
		'social'  => __( 'Social links (only filled ones are shown)', 'pastor-adewale' ),
		'giving'  => __( 'Giving', 'pastor-adewale' ),
		'ebook'   => __( 'Free eBook', 'pastor-adewale' ),
	);
}

function pa_settings_menu() {
	add_options_page( __( 'Ministry Settings', 'pastor-adewale' ), __( 'Ministry Settings', 'pastor-adewale' ), 'manage_options', 'pa-settings', 'pa_settings_page' );
}
add_action( 'admin_menu', 'pa_settings_menu' );

function pa_settings_register() {
	register_setting( 'pa_settings_group', 'pa_settings', array( 'type' => 'array', 'sanitize_callback' => 'pa_settings_sanitize', 'default' => array() ) );
}
add_action( 'admin_init', 'pa_settings_register' );

function pa_settings_sanitize( $input ) {
	$old = get_option( 'pa_settings', array() );
	$out = array();
	foreach ( pa_settings_fields() as $key => $f ) {
		$raw = isset( $input[ $key ] ) ? wp_unslash( $input[ $key ] ) : '';
		switch ( $f[1] ) {
			case 'url':
				$val = esc_url_raw( $raw );
				break;
			case 'email':
				$val = sanitize_email( $raw );
				break;
			case 'media':
				$val = absint( $raw );
				break;
			case 'textarea':
				$val = sanitize_textarea_field( $raw );
				break;
			case 'password':
				$val = '' === trim( $raw ) ? ( isset( $old[ $key ] ) ? $old[ $key ] : '' ) : sanitize_text_field( $raw );
				break;
			default:
				$val = sanitize_text_field( $raw );
		}
		$out[ $key ] = $val;
	}
	return $out;
}

function pa_settings_admin_assets( $hook ) {
	if ( 'settings_page_pa-settings' === $hook ) {
		wp_enqueue_media();
	}
}
add_action( 'admin_enqueue_scripts', 'pa_settings_admin_assets' );

function pa_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$all      = get_option( 'pa_settings', array() );
	$fields   = pa_settings_fields();
	$sections = pa_settings_sections();
	$done     = isset( $_GET['pa_done'] ) ? sanitize_key( wp_unslash( $_GET['pa_done'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	$msgs     = array(
		'setup'  => __( 'Starter pages and menus are ready. Existing pages were left untouched.', 'pastor-adewale' ),
		'sample' => __( 'Sample content added. Remove it before launch with the button below.', 'pastor-adewale' ),
		'clean'  => __( 'Sample content removed.', 'pastor-adewale' ),
	);
	echo '<div class="wrap"><h1>' . esc_html__( 'Ministry Settings', 'pastor-adewale' ) . '</h1>';
	if ( isset( $msgs[ $done ] ) ) {
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html( $msgs[ $done ] ) . '</p></div>';
	}
	echo '<form method="post" action="options.php">';
	settings_fields( 'pa_settings_group' );
	foreach ( $sections as $sid => $stitle ) {
		echo '<h2>' . esc_html( $stitle ) . '</h2><table class="form-table" role="presentation"><tbody>';
		foreach ( $fields as $key => $f ) {
			if ( $f[3] !== $sid ) {
				continue;
			}
			$val  = isset( $all[ $key ] ) ? $all[ $key ] : '';
			$name = 'pa_settings[' . $key . ']';
			echo '<tr><th scope="row"><label for="pa_' . esc_attr( $key ) . '">' . esc_html( $f[0] ) . '</label></th><td>';
			if ( 'textarea' === $f[1] ) {
				echo '<textarea class="large-text" rows="4" id="pa_' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '">' . esc_textarea( $val ) . '</textarea>';
			} elseif ( 'media' === $f[1] ) {
				$url = $val ? wp_get_attachment_image_url( (int) $val, 'thumbnail' ) : '';
				echo '<div class="pa-media-field" data-key="' . esc_attr( $key ) . '">';
				echo '<img class="pa-media-preview" src="' . esc_url( $url ) . '" alt="" style="max-width:120px;height:auto;display:' . ( $url ? 'block' : 'none' ) . ';margin-bottom:8px;border-radius:8px">';
				echo '<input type="hidden" class="pa-media-input" id="pa_' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $val ) . '">';
				echo '<button type="button" class="button pa-media-pick">' . esc_html__( 'Choose image', 'pastor-adewale' ) . '</button> ';
				echo '<button type="button" class="button-link pa-media-clear">' . esc_html__( 'Remove', 'pastor-adewale' ) . '</button>';
				echo '</div>';
			} elseif ( 'password' === $f[1] ) {
				$has = ! empty( $all[ $key ] ) ? __( 'A key is saved. Type a new one to replace it.', 'pastor-adewale' ) : '';
				echo '<input class="regular-text" type="password" autocomplete="new-password" id="pa_' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" value="" placeholder="' . esc_attr( $has ) . '">';
			} else {
				$type = in_array( $f[1], array( 'url', 'email' ), true ) ? $f[1] : 'text';
				echo '<input class="regular-text" type="' . esc_attr( $type ) . '" id="pa_' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $val ) . '">';
			}
			if ( ! empty( $f[2] ) ) {
				echo '<p class="description">' . esc_html( $f[2] ) . '</p>';
			}
			echo '</td></tr>';
		}
		echo '</tbody></table>';
	}
	submit_button();
	echo '</form>';

	// Tools.
	echo '<hr><h2>' . esc_html__( 'Tools', 'pastor-adewale' ) . '</h2><table class="form-table" role="presentation"><tbody>';
	$tools = array(
		array( 'pa_run_setup', __( 'Create starter pages and menus', 'pastor-adewale' ), __( 'Creates any missing pages (Start Here, Resources, About, Donate, Contact and so on), the five menus and the static front page. Safe to run again.', 'pastor-adewale' ) ),
		array( 'pa_load_sample', __( 'Load sample content', 'pastor-adewale' ), __( 'Adds clearly marked sample series, teachings, books, testimonies and slides so you can review the design. Remove it before launch.', 'pastor-adewale' ) ),
		array( 'pa_remove_sample', __( 'Remove sample content', 'pastor-adewale' ), __( 'Deletes everything the sample loader created, and nothing else.', 'pastor-adewale' ) ),
	);
	foreach ( $tools as $t ) {
		echo '<tr><th scope="row">' . esc_html( $t[1] ) . '</th><td><form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
		echo '<input type="hidden" name="action" value="' . esc_attr( $t[0] ) . '">';
		wp_nonce_field( $t[0] );
		submit_button( $t[1], 'secondary', 'submit', false );
		echo '<p class="description">' . esc_html( $t[2] ) . '</p></form></td></tr>';
	}
	echo '<tr><th scope="row">' . esc_html__( 'Export (CSV)', 'pastor-adewale' ) . '</th><td>';
	foreach ( array( 'subscriber' => __( 'Subscribers', 'pastor-adewale' ), 'donation' => __( 'Donations', 'pastor-adewale' ), 'all' => __( 'Everything in the Inbox', 'pastor-adewale' ) ) as $k => $label ) {
		$url = wp_nonce_url( admin_url( 'admin-post.php?action=pa_export&type=' . $k ), 'pa_export' );
		echo '<a class="button" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a> ';
	}
	echo '</td></tr></tbody></table>';
	?>
	<script>
	(function(){
		if(!window.wp||!wp.media){return}
		document.querySelectorAll('.pa-media-field').forEach(function(box){
			var pick=box.querySelector('.pa-media-pick'),clr=box.querySelector('.pa-media-clear'),inp=box.querySelector('.pa-media-input'),img=box.querySelector('.pa-media-preview'),frame;
			if(!pick||!inp){return}
			pick.addEventListener('click',function(){
				if(!frame){
					frame=wp.media({title:'Choose image',multiple:false,library:{type:'image'}});
					frame.on('select',function(){
						var a=frame.state().get('selection').first().toJSON();
						inp.value=a.id;
						if(img){img.src=(a.sizes&&a.sizes.thumbnail)?a.sizes.thumbnail.url:a.url;img.style.display='block'}
					});
				}
				frame.open();
			});
			if(clr){clr.addEventListener('click',function(){inp.value='';if(img){img.style.display='none';img.removeAttribute('src')}})}
		});
	})();
	</script>
	<p class="description" style="margin-top:24px"><strong><?php esc_html_e( 'Home hero carousel images:', 'pastor-adewale' ); ?></strong>
	<?php esc_html_e( 'To add or change the rotating images at the top of the home page, go to', 'pastor-adewale' ); ?>
	<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=hero_slide' ) ); ?>"><?php esc_html_e( 'Home slides', 'pastor-adewale' ); ?></a>.
	<?php esc_html_e( 'Add a new slide, set a Featured Image, and order them with the Order field.', 'pastor-adewale' ); ?></p>
	<?php
	echo '</div>';
}

/** CSV export of the inbox. */
function pa_export_csv() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to do this.', 'pastor-adewale' ), 403 );
	}
	check_admin_referer( 'pa_export' );
	$type  = isset( $_GET['type'] ) ? sanitize_key( wp_unslash( $_GET['type'] ) ) : 'all';
	$args  = array( 'post_type' => 'submission', 'post_status' => 'any', 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC' );
	if ( 'all' !== $type && isset( pa_submission_types()[ $type ] ) ) {
		$args['meta_key']   = '_pa_type';
		$args['meta_value'] = $type;
	}
	$posts = get_posts( $args );
	nocache_headers();
	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=ministry-' . $type . '-' . gmdate( 'Y-m-d' ) . '.csv' );
	$out = fopen( 'php://output', 'w' );
	fputcsv( $out, array( 'Date', 'Type', 'Name', 'Email', 'Phone', 'Topic', 'Amount', 'Reference', 'Message' ) );
	foreach ( $posts as $p ) {
		$row = array(
			$p->post_date,
			get_post_meta( $p->ID, '_pa_type', true ),
			get_post_meta( $p->ID, '_pa_name', true ),
			get_post_meta( $p->ID, '_pa_email', true ),
			get_post_meta( $p->ID, '_pa_phone', true ),
			get_post_meta( $p->ID, '_pa_topic', true ),
			get_post_meta( $p->ID, '_pa_amount', true ),
			get_post_meta( $p->ID, '_pa_ref', true ),
			wp_strip_all_tags( $p->post_content ),
		);
		// Stop spreadsheet formula injection from user-supplied text.
		foreach ( $row as $i => $cell ) {
			if ( is_string( $cell ) && preg_match( '/^[=+\-@\t\r]/', $cell ) ) {
				$row[ $i ] = "'" . $cell;
			}
		}
		fputcsv( $out, $row );
	}
	fclose( $out ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	exit;
}
add_action( 'admin_post_pa_export', 'pa_export_csv' );
