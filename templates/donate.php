<?php
/**
 * Template Name: Donate
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$tiers     = pa_gift_tiers();
$has_card  = (bool) ( pa_opt( 'paystack_public' ) && pa_paystack_secret() );
$bank_num  = pa_opt( 'bank_account_number' );
$has_bank  = (bool) $bank_num;
$presets   = array_slice( $tiers, 0, 3 );
$default   = $presets ? (int) $presets[ min( 1, count( $presets ) - 1 ) ]['amount'] : 5000;
while ( have_posts() ) :
	the_post();
	?>
	<div class="donate-hero"><div class="wrap">
		<div class="crumbs" style="color:#d9b9c6;padding:0 0 18px"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'pastor-adewale' ); ?></a> / <?php the_title(); ?></div>
		<h1><?php the_title(); ?></h1>
		<p><?php esc_html_e( 'Thank you for your support. Everything we do is made possible by the generous giving and prayer of people like you.', 'pastor-adewale' ); ?></p>
		<a class="btn btn-gold" href="#give"><?php esc_html_e( 'Donate now', 'pastor-adewale' ); ?></a>
	</div></div>

	<?php if ( $tiers ) : ?>
	<div class="section"><div class="wrap">
		<div class="s-head"><div><h2><?php esc_html_e( 'What your gift can do', 'pastor-adewale' ); ?></h2></div></div>
		<div class="gift-grid">
			<?php foreach ( array_slice( $tiers, 0, 3 ) as $t ) : ?>
				<div class="gift"><div class="amt"><?php echo esc_html( pa_money( $t['amount'] ) ); ?></div><p><?php echo esc_html( $t['text'] ); ?></p></div>
			<?php endforeach; ?>
		</div>
	</div></div>
	<?php endif; ?>

	<div class="section band" id="give"><div class="wrap">
		<div class="give-box">
			<div class="give-info"><h2><?php esc_html_e( 'Partner with us', 'pastor-adewale' ); ?></h2><p><?php esc_html_e( 'Your gift, big or small, helps us teach the Bible and make disciples through sound education and the power of God\'s Word.', 'pastor-adewale' ); ?></p>
				<ul><?php if ( $has_card ) : ?><li><?php esc_html_e( 'Pay securely by card, bank or USSD through Paystack', 'pastor-adewale' ); ?></li><?php endif; ?><?php if ( $has_bank ) : ?><li><?php esc_html_e( 'Or give by bank transfer', 'pastor-adewale' ); ?></li><?php endif; ?><li><?php esc_html_e( 'Every gift is recorded and acknowledged', 'pastor-adewale' ); ?></li></ul></div>
			<form class="give-form" id="giveForm" novalidate>
				<?php if ( ! $has_card && ! $has_bank ) : ?>
					<div class="pa-notice"><?php esc_html_e( 'Giving is not set up yet.', 'pastor-adewale' ); ?><?php if ( current_user_can( 'manage_options' ) ) : ?> <a href="<?php echo esc_url( admin_url( 'options-general.php?page=pa-settings' ) ); ?>"><?php esc_html_e( 'Add the Paystack keys or bank details in Ministry Settings.', 'pastor-adewale' ); ?></a><?php endif; ?></div>
				<?php endif; ?>
				<div>
					<span class="lbl"><?php esc_html_e( 'Amount (₦)', 'pastor-adewale' ); ?></span>
					<div class="amts" id="amts">
						<?php foreach ( $presets as $t ) : ?>
							<button type="button" data-v="<?php echo esc_attr( (int) $t['amount'] ); ?>" aria-pressed="<?php echo (int) $t['amount'] === $default ? 'true' : 'false'; ?>"><?php echo esc_html( pa_money( $t['amount'] ) ); ?></button>
						<?php endforeach; ?>
					</div>
					<label class="screen-reader-text" for="customAmt"><?php esc_html_e( 'Other amount', 'pastor-adewale' ); ?></label>
					<input class="field" id="customAmt" type="number" min="100" inputmode="numeric" placeholder="<?php esc_attr_e( 'Or enter another amount', 'pastor-adewale' ); ?>" style="margin-top:8px">
				</div>
				<div>
					<label class="screen-reader-text" for="giveName"><?php esc_html_e( 'Your name', 'pastor-adewale' ); ?></label>
					<input class="field" id="giveName" type="text" autocomplete="name" placeholder="<?php esc_attr_e( 'Your name', 'pastor-adewale' ); ?>" required>
				</div>
				<div>
					<label class="screen-reader-text" for="giveEmail"><?php esc_html_e( 'Email for your receipt', 'pastor-adewale' ); ?></label>
					<input class="field" id="giveEmail" type="email" autocomplete="email" placeholder="<?php esc_attr_e( 'Email for your receipt', 'pastor-adewale' ); ?>" required>
				</div>
				<?php if ( $has_card && $has_bank ) : ?>
					<div><span class="lbl"><?php esc_html_e( 'Payment method', 'pastor-adewale' ); ?></span><div class="seg" id="pay"><button type="button" aria-pressed="true" data-v="card"><?php esc_html_e( 'Card / Paystack', 'pastor-adewale' ); ?></button><button type="button" aria-pressed="false" data-v="bank"><?php esc_html_e( 'Bank transfer', 'pastor-adewale' ); ?></button></div></div>
				<?php endif; ?>
				<?php if ( $has_card ) : ?><div class="method show" id="m-card"><?php esc_html_e( 'A secure Paystack window opens. Your card details never touch this website.', 'pastor-adewale' ); ?></div><?php endif; ?>
				<?php if ( $has_bank ) : ?>
					<div class="method<?php echo $has_card ? '' : ' show'; ?>" id="m-bank"><?php esc_html_e( 'Transfer to the ministry account, then contact us with your name so we can acknowledge your gift.', 'pastor-adewale' ); ?>
						<dl><dt><?php esc_html_e( 'Account name', 'pastor-adewale' ); ?></dt><dd><?php echo esc_html( pa_opt( 'bank_account_name' ) ); ?></dd><dt><?php esc_html_e( 'Bank', 'pastor-adewale' ); ?></dt><dd><?php echo esc_html( pa_opt( 'bank_name' ) ); ?></dd><dt><?php esc_html_e( 'Account number', 'pastor-adewale' ); ?></dt><dd><?php echo esc_html( $bank_num ); ?></dd></dl></div>
				<?php endif; ?>
				<?php if ( $has_card ) : ?><button class="btn btn-primary" type="submit" id="giveCta" data-default="<?php echo esc_attr( $default ); ?>"><?php echo pa_icon( 'heart' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php esc_html_e( 'Give', 'pastor-adewale' ); ?></span></button><?php endif; ?>
				<p id="giveMsg" class="fnote" role="status" aria-live="polite"></p>
			</form>
		</div>
	</div></div>

	<div class="wrap" style="padding:60px 0 80px"><div class="entry-content"><?php the_content(); ?></div>
		<p style="margin-top:22px"><a class="btn btn-line" href="<?php echo esc_url( pa_url( 'contact' ) ); ?>"><?php esc_html_e( 'Talk to us about giving', 'pastor-adewale' ); ?></a></p></div>
	<?php
endwhile;
get_footer();
