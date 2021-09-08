<?php
$path = preg_replace('/wp-content(?!.*wp-content).*/','',__DIR__);
include($path.'wp-load.php');


if(isset($_POST['form_mo']) || true) {
    global $wpdb;
    global $bp;
    if ( is_user_logged_in() ) {
        $user_info = get_userdata(get_current_user_id());

        $date_mo = date('Y-m-d');      
        $monid_mo = bp_loggedin_user_id();
        $argsrp = array(
            'field'     => 'RP',                
            'user_id'   => $monid_mo
        );
        $argssite = array(
            'field'     => 'Site',                
            'user_id'   => $monid_mo
        );
        $argsspv = array(
            'field'     => 'Superviseur',                
            'user_id'   => $monid_mo
        );        
        $nom_mo = $bp->loggedin_user->userdata->user_login;       
        $rp_mo = bp_get_profile_field_data( $argsrp );
        $site_mo = bp_get_profile_field_data( $argssite );
        $spv_mo = bp_get_profile_field_data( $argsspv );

        $rc_mo = $_POST['rc_mo'];   
        $mob_mo = $_POST['mob_mo'];
        $adress_mo = $_POST['adress_mo'];
                
$wpdb->insert("declaratif_mo", array(
   "date_mo" => $date_mo,
   "monid_mo" => $monid_mo,
   "nom_mo" => $nom_mo,
   "spv_mo" => $spv_mo,
   "rp_mo" => $rp_mo,
   "site_mo" => $site_mo,
   "rc_mo" => $rc_mo,
   "mob_mo" => $mob_mo,
   "adress_mo" => $adress_mo,    
        ));
    }
}
wp_redirect( home_url());
exit;
?>