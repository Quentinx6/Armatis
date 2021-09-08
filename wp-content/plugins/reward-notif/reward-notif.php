<?php

/**
 * Plugin Name:       Reward Notif
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Le plugin de notif ultime !
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Lecompte Quentin
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       Le plugin de notif ultime !
 * Domain Path:       /languages
 */


function notice(){
    if(!function_exists('mycred_add_new_notice')){
        echo 'mycred not installed!';
    }else{
        wp_enqueue_script( 'custom-js', plugin_dir_url( __FILE__ ) . '../mycred/assets/js/my-custom-mycred.js', array(), '1.0.0', true );
        wp_enqueue_style( 'style', plugin_dir_url( __FILE__ ) . 'assets/style.css', array(), '1.1', 'all');
        $message = "<div class='notif'>
                    <p class='texte-points'>Ton total de point(s) est de :</p>
                    <p class='points-total'> "   . do_shortcode('[mycred_total_points]');  " </p>
                    </div>";
        mycred_add_new_notice(array('user_id' => wp_get_current_user()->ID, 'message' => $message));
    }
}
add_action('buddyboss_theme_begin_content', 'notice', 2);

add_filter( 'mycred_setup_hooks', 'mycredpro_adjust_hooks', 10, 2 );
function mycredpro_adjust_hooks( $installed, $point_type ) {

    // Remove a specific hook
    unset( $installed['site_visit'] );

    // Add a custom hook’’
    $installed['mycustomhook'] = array(
        'title'        => 'Hook Armatis',
        'description'  => 'Une description inutile.',
        'callback'     => array( 'my_Custom_Hook_Class' )
    );

    // Replace an existing hook with our own
    $installed['site_visit'] = array(
        'title'        => 'Le Hook Custom',
        'description'  => 'Une description inutile.',
        'callback'     => array( 'my_Custom_Version_Hook_Class' )
    );

    return $installed;

}

?>





