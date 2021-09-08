<?php
$path = preg_replace('/wp-content(?!.*wp-content).*/','',__DIR__);
include($path.'wp-load.php');


if(isset($_POST['form']) || true) {
    global $wpdb;
    global $bp;
    if ( is_user_logged_in() ) {
        $user_info = get_userdata(get_current_user_id());
        console.log(user_info);  
        $date = date('Y-m-d');      
        $monid = bp_loggedin_user_id();
        $argsrp = array(
            'field'     => 'RP',                
            'user_id'   => $monid
        );
        $argssite = array(
            'field'     => 'Site',                
            'user_id'   => $monid
        );
        $argsspv = array(
            'field'     => 'Superviseur',                
            'user_id'   => $monid
        );        
        $nom = $bp->loggedin_user->userdata->user_login;       
        $rp = bp_get_profile_field_data( $argsrp );
        $site = bp_get_profile_field_data( $argssite );
        $spv = bp_get_profile_field_data( $argsspv );

        $file = $_POST['file'];  
        $mens= $_POST['mens'];
        $dom= $_POST['dom'];        
        $fe= $_POST['fe'];
        $eca= $_POST['eca'];
        $sdc = $_POST['sdc']; 
        $assu= $_POST['assu'];
        $overte= $_POST['overte'];
        $gaz= $_POST['gaz'];
        $typo = $_POST['typo'];
        $no_rc= $_POST['no_rc'];
        $zen= $_POST['zen'];
        $trv= $_POST['trv'];
        $trans_ts= $_POST['trans_ts'];
        $form_ts= $_POST['form_ts'];
        $optin_samsung= $_POST['optin_samsung'];
        $optin_dem= $_POST['optin_dem'];         
        $tempo= $_POST['tempo'];
        $tempo_ref= $_POST['tempo_ref'];              
$wpdb->insert("declaratif", array(
   "date" => $date,
   "monid" => $monid,
   "nom" => $nom,
   "spv" => $spv,
   "rp" => $rp,
   "site" => $site,
   "file" => $file,
   "mens" => $mens,  
   "dom" => $dom,
   "fe" => $fe, 
   "eca" => $eca,      
   "sdc" => $sdc,
   "assu" => $assu, 
   "overte" => $overte,      
   "gaz" => $gaz,      
   "typo" => $typo,
   "no_rc" => $no_rc,
   "zen" => $zen,     
   "trv" => $trv,       
   "trans_ts" => $trans_ts,  
   "form_ts" => $form_ts, 
   "optin_samsung" => $optin_samsung,  
   "optin_dem" => $optin_dem,     
   "tempo" => $tempo, 
   "tempo_ref" => $tempo_ref, 
        ));
    }
}
wp_redirect( home_url());
exit;
?>