<?php
/**
 * Certificate: Content
 *
 * @package LifterLMS/Templates
 *
 * @since 1.0.0
 * @version 3.18.0
 */

defined( 'ABSPATH' ) || exit;

$cert = new LLMS_User_Certificate( get_the_ID() );
$uid  = get_current_user_id();

if ( $uid != $cert->get_user_id() && ! llms_can_user_bypass_restrictions( $uid ) ) {
	return _e( 'Certificate not found.', 'buddyboss-theme' );
}

$image = llms_get_certificate_image();
?>
<div class="llms-certificate-container" style="width:<?php echo $image['width']; ?>px; height:<?php echo $image['height']; ?>px;">
    <img src="<?php echo $image['src']; ?>" style="margin-bottom:-<?php echo $image['height']; ?>px;" alt="Cetrificate Background" class="certificate-background">
    <div id="certificate-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="llms-summary">

			<?php llms_print_notices(); ?>

			<?php do_action( 'before_lifterlms_certificate_main_content' ); ?>

            <h1><?php echo llms_get_certificate_title(); ?></h1>
			<?php echo llms_get_certificate_content(); ?>

			<?php do_action( 'after_lifterlms_certificate_main_content' ); ?>

        </div>
    </div>
</div>

<div class="llms-print-certificate no-print" id="llms-print-certificate">

    <div class="print_and_save_holder">

        <button class="llms-button-secondary button" onClick="window.print()" type="button">
			<?php echo _e( 'Print', 'buddyboss-theme' ); ?>
            <i class="bb-icon-print" aria-hidden="true"></i>
        </button>

        <form action="" method="POST">
            <button class="llms-button-secondary button" type="submit" name="llms_generate_cert">
				<?php echo _e( 'Save', 'buddyboss-theme' ); ?>
                <i class="bb-icon-download" aria-hidden="true"></i>
            </button>

            <input type="hidden" name="certificate_id" value="<?php echo get_the_ID(); ?>">
			<?php wp_nonce_field( 'llms-cert-actions', '_llms_cert_actions_nonce' ); ?>
        </form>
    </div>

    <div class="back_to_home_page">
        <i class="bb-icons bb-icon-chevron-left"></i>
        <a href="<?php echo home_url() . '/dashboard/my-certificates/'; ?>">
			<?php
			esc_html_e( 'Back to My Certificates', 'buddyboss-theme' );
			?>
        </a>
    </div>

</div>
