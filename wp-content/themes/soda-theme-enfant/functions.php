<?php
    //SECURISATION TIAI
    //blocage de l'enumeration
        if (!is_admin()) {
    //format URL par defaut
        if (preg_match('/author=([0-9]*)/i', $_SERVER['QUERY_STRING'])) die();
            add_filter('redirect_canonical', 'shapeSpace_check_enum', 10, 2);
            }
        function shapeSpace_check_enum($redirect, $request) {
    // format permalien
        if (preg_match('/\?author=([0-9]*)(\/*)/i', $request)) die();
            else return $redirect;
        }
    //X-XSS-Protection and X-Content-Type-Options */
        header('X-XSS-Protection: 1; mode=block');
        header('X-Content-Type-Options: nosniff');
        header("X-Frame-Options: SAMEORIGIN");
        //header("Content-Security-Policy: default-src 'self';");
    //add no-cache option -- TIAI-03
        add_filter( 'nocache_headers', function() {
        return array(
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma'        => 'no-cache',
            'Expires'       => gmdate( 'D, d M Y H:i:s \G\M\T', 0 )
            );
                 } );
    //redirect if not weezpowertest -- TIAI25
        function my_page_template_redirect() {
         if ( is_page( 'weez-power' ) && !current_user_can('weezpower') ) {
               wp_redirect( home_url( '' ));
              exit();
          }
           }
        add_action( 'template_redirect', 'my_page_template_redirect' );
    //block file upload if svg or svgz -- TIAI05 + add a random string to filename -- TIAI04
        function svgFilter($file){
    //block file upload if svg or svgz -- TIAI05
        $filename = $file['name'];
        $ext = substr( $filename, strrpos( $filename, '.' ) + 1 ); // get extension
        $upload_error_handler = 'wp_handle_upload_error';
       
        if ($ext == "svg" || $ext == "svgz" || $file['type'] == "image/svg+xml"){
           
           return call_user_func_array( $upload_error_handler, array( &$file, __( 'Sorry, this file type is not permitted for security reasons.' ) ) );     
        }
    //add a random string to name -- TIAI04
        $char = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $rdmStr = '';
        for($i=0;$i<10;$i++){
            $rdmStr .= $char[rand(0,strlen($char))];
        }
    
        $file['name'] = $rdmStr . '-' . $file['name'];
        return $file;
        }
        add_filter('wp_handle_upload_prefilter', 'svgFilter' );
 
//shortcode getuserrole
        function ss_get_current_userrole(){
            $user = wp_get_current_user();
            return $user->roles;
} 
add_shortcode( 'monsite' , 'ss_get_current_userrole' );
 
//affiche le lien vers tous les badges après les badges
function add_content_after_mycred_users_badges( $user_id, $users_badges ) {
    echo "<div><a href='https://edf.soda.armatis-lc.com/badges/'> Voir tous les badges</a></div>";
}
add_action( 'mycred_after_users_badges', 'add_content_after_mycred_users_badges', 10, 2 );
 
//customisations backoffice//
        function change_admin_footer(){
             echo '<span id="footer-note">Team Soda by Armatis</span>';
}
add_filter('admin_footer_text', 'change_admin_footer'); 
 
//*masquage du bienvenue en backoffice/
add_action('wp_dashboard_setup', 'remove_dashboard_widgets');
        function remove_dashboard_widgets () {
remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );      
remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );      
}
 
//masquage des notifs update sauf admin //
        function hide_update_notice_to_all_but_admin_users() {
             if (!current_user_can('update_core')) {
remove_action( 'admin_notices', 'update_nag', 3 );
    }
}
add_action( 'admin_head', 'hide_update_notice_to_all_but_admin_users', 1 );
 
//masquage des notices admin sauf admin //
        function hide_update_noticee_to_all_but_admin_users() {
             if (!current_user_can('update_core')) {
remove_all_actions( 'admin_notices' );
    }
}
add_action( 'admin_head', 'hide_update_noticee_to_all_but_admin_users', 1 );
 
 
//fix missing password reset link in emails
add_filter("retrieve_password_message", "custom_password_reset", 99, 4);
        function custom_password_reset($message, $key, $user_login, $user_data )    {
            $message = __('Someone has requested a password reset for the following account:') . "<br><br>";
            $message .= network_home_url( '/' ) . "<br><br>";
            $message .= sprintf(__('%s'), $user_data->user_email) . "<br><br>";
            $message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "<br><br>";
            $message .= __('To reset your password use the link below:') . "<br><br>";
            $message .= "<a href=".network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') .">Click here to reset your password</a><br><br>";
            $message .= "Or copy and paste this link into your browser:<br><br>".network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login')."<br><br>";
        return $message;
}
 
//block backend
        function block_wp_admin() {
           if (! current_user_can( 'publish_posts' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
wp_safe_redirect( home_url() );
           exit;
    }
}
add_action( 'admin_init', 'block_wp_admin' );
 
// Function to change email address
 
function wpb_sender_email( $original_email_address ) {
    return 'soda@armatis-lc.com';
}
 
// Function to change sender name
function wpb_sender_name( $original_email_from ) {
    return 'WeezMeUp-EDF';
}
// Hooking up our functions to WordPress filters 
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );
 
//custom shortcodes ajout de champs de profils de granularité //
 
function meta_rp ($atts) {
                  if ( is_user_logged_in() ) {
                 $user_id = bp_loggedin_user_id();
                 $Name = xprofile_get_field_data( 'RP' ,$user_id);
                 return $Name;
           } 
        }
 
        add_shortcode( 'RP', 'meta_rp' ); 
 
function meta_spv ($atts) {
                  if ( is_user_logged_in() ) {
                 $user_id = bp_loggedin_user_id();
                 $Name = xprofile_get_field_data( 'Superviseur' ,$user_id);
                 return $Name;
           } 
        }
 
        add_shortcode( 'Superviseur', 'meta_spv' ); 
 
 function meta_site ($atts) {
                  if ( is_user_logged_in() ) {
                 $user_id = bp_loggedin_user_id();
                 $Name = xprofile_get_field_data( 'Site' ,$user_id);
                 return $Name;
           } 
        }
 
        add_shortcode( 'Site', 'meta_site' ); 
 
 
 function meta_userid ($atts) {
                  if ( is_user_logged_in() ) {
                 $user_id = bp_loggedin_user_id();
                 return $user_id;
           } 
        }
 
        add_shortcode( 'userid', 'meta_userid' ); 
 
 
function ss_get_current_username(){
            $user = wp_get_current_user();
            return $user->user_login;
} 
        add_shortcode( 'username' , 'ss_get_current_username' );
 
 
function displaydate(){
     return date('y/m/d');
}
add_shortcode( 'date', 'displaydate' );
 
add_filter( 'send_password_change_email', '__return_false');
add_filter( 'send_email_change_email', '__return_false');
add_filter( 'wpmu_signup_user_notification', '__return_false' );
 
/*shortcodes quizz*/ 
add_shortcode( 'qm_display_last_quiz', 'qm_display_last_quiz');
add_shortcode( 'qm_display_quiz_menu', 'qm_display_quiz_menu' );
add_shortcode( 'qm_quiz_creation_1', 'qm_quiz_creation_1');
add_shortcode( 'qm_quiz_creation_2', 'qm_quiz_creation_2');
add_shortcode( 'qm_quiz_creation_3', 'qm_quiz_creation_3');
    
add_shortcode( 'qm_display_module_menu', 'qm_display_module_menu' );
add_shortcode( 'qm_module_creation_1', 'qm_module_creation_1');
add_shortcode( 'qm_module_creation_2', 'qm_module_creation_2');
add_shortcode( 'qm_module_creation_3', 'qm_module_creation_3');
 
add_shortcode( 'qm_display_module_list', 'qm_display_module_list' );
 
add_shortcode( 'qm_display_quiz_list', 'qm_display_quiz_list' );
add_shortcode( 'qm_display_tag_list', 'qm_display_tag_list' );
 
add_shortcode( 'qm_display_classement_admin', 'qm_display_classement_admin' );
 
add_shortcode( 'qm_display_stats_admin', 'qm_display_stats_admin' );
 
add_shortcode( 'qm_display_creation_campagne', 'qm_display_creation_campagne' );
 
add_shortcode( 'qm_display_campagne_stats', 'qm_display_campagne_stats' );
 
add_shortcode( 'qm_display_classement_acceuil', 'qm_display_classement_acceuil' );
add_shortcode( 'qm_display_stats_acceuil', 'qm_display_stats_acceuil');
 
/* Remove Woocommerce User Fields */
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
add_filter( 'woocommerce_billing_fields' , 'custom_override_billing_fields' );
add_filter( 'woocommerce_shipping_fields' , 'custom_override_shipping_fields' );
function custom_override_checkout_fields( $fields ) {
unset($fields['billing']['billing_state']);
unset($fields['billing']['billing_country']);
unset($fields['billing']['billing_company']);
unset($fields['billing']['billing_address_1']);
unset($fields['billing']['billing_address_2']);
unset($fields['billing']['billing_phone']);
unset($fields['billing']['billing_postcode']);
unset($fields['billing']['billing_city']);
unset($fields['shipping']['shipping_state']);
unset($fields['shipping']['shipping_country']);
unset($fields['shipping']['shipping_company']);
unset($fields['shipping']['shipping_address_1']);
unset($fields['shipping']['shipping_address_2']);
unset($fields['shipping']['shipping_phone']);
unset($fields['shipping']['shipping_postcode']);
unset($fields['shipping']['shipping_city']); 
return $fields;
}
function custom_override_billing_fields( $fields ) {
unset($fields['billing_state']);
unset($fields['billing_country']);
unset($fields['billing_company']);
unset($fields['billing_address_1']);
unset($fields['billing_address_2']);
unset($fields['billing_phone']);
unset($fields['billing_postcode']);
unset($fields['billing_city']);
return $fields;
}
function custom_override_shipping_fields( $fields ) {
unset($fields['shipping_state']);
unset($fields['shipping_country']);
unset($fields['shipping_company']);
unset($fields['shipping_address_1']);
unset($fields['shipping_address_2']);
unset($fields['shipping_phone']);
unset($fields['shipping_postcode']);
unset($fields['shipping_city']);
return $fields;
}
 
//reglage hook cf7 
add_filter( 'wpcf7_verify_nonce', '__return_true' );

//verrouillage de l'edition de profil par utilisateur lambda //

function masquage_champs_profil( $retval ) {

    if( current_user_can('modification_de_profil')) // remplacer ou ajouter ,rôle désiré ou    $capabilities //
       return $retval;
    
    if(  bp_is_user_profile_edit()  )
            $retval['exclude_fields'] = '5,7,3'; // ID des champs //
        // Affichage sur la page de profil //
    if ( $data = bp_get_profile_field_data( 'field=5' ) ) : 
        $retval['include_fields'] = '5,7,3'; // 5 7 et 3 dans le cadre d’EDF sont les champs SPV/RP et SITE //
        endif;	
    return $retval;
    }
    add_filter( 'bp_after_has_profile_parse_args', 'masquage_champs_profil' );
    
           
    
    //redirectloop login//
    /*
    add_action('wp_logout','auto_redirect_external_after_logout');
    function auto_redirect_external_after_logout(){
      wp_redirect( 'https://edf.soda.armatis-lc.com/login/' );
      exit();
    }
    */

    
//dequeue scripts&styles
add_action( 'wp_print_scripts', 'deregistration_scripts' );
//scripts
function deregistration_scripts() {
   wp_dequeue_script( 'userpro_sc-js-extra' );
   wp_deregister_script( 'userpro_sc-js-extra' );
   wp_dequeue_script( 'userpro_encrypt_js' );
   wp_deregister_script( 'userpro_encrypt_js' );
   wp_dequeue_script( 'up-custom-script-js' );
   wp_deregister_script( 'up-custom-script' );
   wp_dequeue_script( 'up_timeline_js' );
   wp_deregister_script( 'up_timeline_js' );
   wp_dequeue_script( 'up_timeline_js' );
   wp_deregister_script( 'up_timeline_js' );
   wp_dequeue_script( 'userpro_sc' );
   wp_deregister_script( 'userpro_sc' );
   wp_dequeue_script( 'mycred-video-points' );
   wp_deregister_script( 'mycred-video-points' );
   wp_dequeue_script( 'fontawesome' );
   wp_deregister_script( 'fontawesome' );
} 
   add_action( 'wp_print_styles', 'deregistration_scripts' );

//Styles
add_action( 'wp_print_styles', 'deregistration_styles' );
function deregistration_styles() {
      wp_deregister_style( 'fontawesome' );
       wp_dequeue_style( 'fontawesome' );
       wp_deregister_style( 'up_fontawesome' );
       wp_dequeue_style( 'up_fontawesome' );
       wp_deregister_style( 'userpro_skin_min' );
       wp_dequeue_style( 'userpro_skin_min' );
       wp_deregister_style( 'up_timeline_css' );
       wp_dequeue_style( 'up_timeline_css' );
       wp_deregister_style( 'userpro-fa-icons-local' );
       wp_dequeue_style( 'userpro-fa-icons-local' );
       wp_deregister_style( 'userpro_latest_css' );
       wp_dequeue_style( 'userpro_latest_css' );
       wp_deregister_style( 'Roboto_font' );
       wp_dequeue_style( 'Roboto_font' );
       wp_deregister_style( 'contact-form-7' );
       wp_dequeue_style( 'contact-form-7' );
   } 
       add_action( 'wp_print_styles', 'deregistration_styles' );
 
?>

