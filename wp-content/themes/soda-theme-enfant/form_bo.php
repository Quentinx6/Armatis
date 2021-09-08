<?php
$path = preg_replace('/wp-content(?!.*wp-content).*/','',__DIR__);
include($path.'wp-load.php');


if(isset($_POST['form_bo']) || true) {
    global $wpdb;
    global $bp;
    if ( is_user_logged_in() ) {
        $user_info = get_userdata(get_current_user_id());

        $date_bo = date('Y-m-d');      
        $monid_bo = bp_loggedin_user_id();
        $argsrp = array(
            'field'     => 'RP',                
            'user_id'   => $monid_bo
        );
        $argssite = array(
            'field'     => 'Site',                
            'user_id'   => $monid_bo
        );
        $argsspv = array(
            'field'     => 'Superviseur',                
            'user_id'   => $monid_bo
        );        
        $nom_bo = $bp->loggedin_user->userdata->user_login;       
        $rp_bo = bp_get_profile_field_data( $argsrp );
        $site_bo = bp_get_profile_field_data( $argssite );
        $spv_bo = bp_get_profile_field_data( $argsspv );

        $courrierrcclos = $_POST['courrierrcclos'];
        $rctransmis = $_POST['rctransmis'];
        $courriermobclos = $_POST['courriermobclos'];
        $mobtransmis = $_POST['mobtransmis'];
        $reclaclose = $_POST['reclaclose'];
        $reclavalidation = $_POST['reclavalidation'];
        $cpv_distri = $_POST['cpv_distri'];
        $valid_courrier = $_POST['valid_courrier'];
        $valid_mail = $_POST['valid_mail'];
        $valid_non = $_POST['valid_non'];    
        $bo_mens = $_POST['bo_mens'];    
        $bo_dom = $_POST['bo_dom'];    
        $bo_fe = $_POST['bo_fe'];    
        $bo_gaz = $_POST['bo_gaz'];  
        $bo_sdc = $_POST['bo_sdc'];  
        $bo_afe = $_POST['bo_afe']; 
                
$wpdb->insert("declaratif_bo", array(
   "date_bo" => $date_bo,
   "monid_bo" => $monid_bo,
   "nom_bo" => $nom_bo,
   "spv_bo" => $spv_bo,
   "rp_bo" => $rp_bo,
   "site_bo" => $site_bo,
   "courrierrcclos" => $courrierrcclos,
   "rctransmis" => $rctransmis,
   "courriermobclos" => $courriermobclos,
   "mobtransmis" => $mobtransmis,
   "reclaclose" => $reclaclose,
   "reclavalidation" => $reclavalidation,
   "cpv_distri" => $cpv_distri,
   "valid_courrier" => $valid_courrier,    
   "valid_mail" => $valid_mail,
   "valid_non" => $valid_non,     
   "bo_mens" => $bo_mens,     
   "bo_dom" => $bo_dom,     
   "bo_fe" => $bo_fe,     
   "bo_gaz" => $bo_gaz,     
   "bo_sdc" => $bo_sdc,     
   "bo_afe" => $bo_afe,     
        ));
    }
}
wp_redirect( home_url());
exit;
?>