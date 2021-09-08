<?php
$path = preg_replace('/wp-content(?!.*wp-content).*/','',__DIR__);
include($path.'wp-load.php');


if(isset($_POST['form_cqt']) || true) {
    global $wpdb;
    global $bp;
    if ( is_user_logged_in() ) {
        $user_info = get_userdata(get_current_user_id());

        $date_cqt = date('Y-m-d');      
        $monid_cqt = bp_loggedin_user_id();
        $argsrp = array(
            'field'     => 'RP',                
            'user_id'   => $monid_cqt
        );
        $argssite = array(
            'field'     => 'Site',                
            'user_id'   => $monid_cqt
        );
        $argsspv = array(
            'field'     => 'Superviseur',                
            'user_id'   => $monid_cqt
        );        
        $nom_cqt = $bp->loggedin_user->userdata->user_login;       
        $rp_cqt = bp_get_profile_field_data( $argsrp );
        $site_cqt = bp_get_profile_field_data( $argssite );
        $spv_cqt = bp_get_profile_field_data( $argsspv );

        $file_cqt = $_POST['file_cqt'];   
        $elec_cqt = $_POST['elec_cqt'];
    $gaz_cqt = $_POST['gaz_cqt']; 
    $om_cqt = $_POST['om_cqt']; 
    $sdc1_cqt = $_POST['sdc1_cqt']; 
    $sdc2_cqt = $_POST['sdc2_cqt']; 
    $sdc3_cqt = $_POST['sdc3_cqt']; 
    $afe_cqt = $_POST['afe_cqt'];     
    $mens_cqt = $_POST['mens_cqt'];     
    $dom_cqt = $_POST['dom_cqt'];
    $fe_cqt = $_POST['fe_cqt']; 
    $typo_cqt = $_POST['typo_cqt']; 
    $bp_cqt = $_POST['bp_cqt'];     
    $pdl_cqt = $_POST['pdl_cqt'];  
                
$wpdb->insert("declaratif_cqt", array(
   "date_cqt" => $date_cqt,
   "monid_cqt" => $monid_cqt,
   "nom_cqt" => $nom_cqt,
   "spv_cqt" => $spv_cqt,
   "rp_cqt" => $rp_cqt,
   "site_cqt" => $site_cqt,
   "file_cqt" => $file_cqt,
   "elec_cqt" => $elec_cqt,  
   "gaz_cqt" => $gaz_cqt,
   "om_cqt" => $om_cqt, 
   "sdc1_cqt" => $sdc1_cqt,      
   "sdc2_cqt" => $sdc2_cqt, 
   "sdc3_cqt" => $sdc3_cqt, 
   "afe_cqt" => $afe_cqt,      
   "mens_cqt" => $mens_cqt,      
   "dom_cqt" => $dom_cqt,
   "fe_cqt" => $fe_cqt,
   "typo_cqt" => $typo_cqt,
   "bp_cqt" => $bp_cqt,         
   "pdl_cqt" => $pdl_cqt,  
        ));
    }
}
wp_redirect( home_url());
exit;
?>