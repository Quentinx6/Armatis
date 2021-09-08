<?php
$path = preg_replace('/wp-content(?!.*wp-content).*/','',__DIR__);
include($path.'wp-load.php');


if(isset($_POST['mood']) || true) {
    global $wpdb;
    global $bp;
    if ( is_user_logged_in() ) {
        $user_info = get_userdata(get_current_user_id());

        $date_mood = date('Y-m-d');      
        $monid_mood = bp_loggedin_user_id();
        $args_mood_rp = array(
            'field'     => 'RP',               
            'user_id'   => $monid_mood
        );
        $args_mood_site = array(
            'field'     => 'Site',            
            'user_id'   => $monid_mood
        ); 
        $args_mood_spv = array(
            'field'     => 'Superviseur',           
            'user_id'   => $monid_mood
        );
        $args_mood_fonction = array(
            'field'     => 'Fonction',              
            'user_id'   => $monid_mood
        );
        $nom_mood = $bp->loggedin_user->userdata->user_login;       
        $rp_mood = bp_get_profile_field_data( $args_mood_rp );
        $site_mood = bp_get_profile_field_data( $args_mood_site );
        $spv_mood = bp_get_profile_field_data( $args_mood_spv );       
        $fonction_mood = bp_get_profile_field_data( $args_mood_fonction );
        
        $mood= $_POST['mood'];
                
        $wpdb->insert("edf_mood", array(
            "date_mood" => $date_mood,  
            "monid_mood" => $monid_mood,   
            "nom_mood" => $nom_mood,   
            "rp_mood" => $rp_mood,
            "site_mood" => $site_mood,
            "spv_mood" => $spv_mood,
            "fonction_mood" => $fonction_mood,
            "mood" => $mood,            
        ));
    }
}
wp_redirect( home_url());
exit;
?>