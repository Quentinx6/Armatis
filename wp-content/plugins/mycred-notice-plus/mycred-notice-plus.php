<?php
/**
 * Plugin Name: myCred Notifications Plus
 * Description: Notifications with options to style, show notifications for ranks and badges and optional instant notifications.
 * Version: 1.6
 * Author: myCred
 * Author URI: https://mycred.me
 * Requires at least: WP 4.8
 * Tested up to: WP 5.4.1
 * Text Domain: mycred_notice
 * Domain Path: /lang
 * License: Copyrighted
 *
 * Copyright © 2013 - 2020 myCred
 * 
 * Permission is hereby granted, to the licensed domain to install and run this
 * software and associated documentation files (the "Software") for an unlimited
 * time with the followning restrictions:
 *
 * - This software is only used under the domain name registered with the purchased
 *   license though the myCred website (mycred.me). Exception is given for localhost
 *   installations or test enviroments.
 *
 * - This software can not be copied and installed on a website not licensed.
 *
 * - This software is supported only if no changes are made to the software files
 *   or documentation. All support is voided as soon as any changes are made.
 *
 * - This software is not copied and re-sold under the current brand or any other
 *   branding in any medium or format.
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
if ( ! class_exists( 'myCRED_Notice_Plus_Plugin' ) ) :
	final class myCRED_Notice_Plus_Plugin {

		// Plugin Version
		public $version             = '1.6';

		// Instnace
		protected static $_instance = NULL;

		// Current session
		public $session             = NULL;

		public $slug                = '';
		public $domain              = '';
		public $plugin              = NULL;
		public $plugin_name         = '';
		protected $update_url       = 'http://mycred.me/api/plugins/';

		/**
		 * Setup Instance
		 * @since 1.3.3
		 * @version 1.0
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Not allowed
		 * @since 1.3.3
		 * @version 1.0
		 */
		public function __clone() { _doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', '1.0' ); }

		/**
		 * Not allowed
		 * @since 1.3.3
		 * @version 1.0
		 */
		public function __wakeup() { _doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', '1.0' ); }

		/**
		 * Define
		 * @since 1.3.3
		 * @version 1.0
		 */
		private function define( $name, $value, $definable = true ) {
			if ( ! defined( $name ) )
				define( $name, $value );
		}

		/**
		 * Require File
		 * @since 1.3.3
		 * @version 1.0
		 */
		public function file( $required_file ) {
			if ( file_exists( $required_file ) )
				require_once $required_file;
		}

		/**
		 * Construct
		 * @since 1.3.3
		 * @version 1.0
		 */
		public function __construct() {

			$this->slug        = 'mycred-notice-plus';
			$this->plugin      = plugin_basename( __FILE__ );
			$this->domain      = 'mycred_notice';
			$this->plugin_name = 'myCRED Notifications Plus';

			$this->define_constants();
			$this->includes();

			register_activation_hook( myCRED_NOTICE, 'mycred_note_plus_plugin_activation' );
			register_uninstall_hook(  myCRED_NOTICE, 'mycred_note_plus_plugin_uninstall' );

			add_action( 'mycred_pre_init', 				  array( $this, 'start_up' ) );
			add_action( 'mycred_init',     				  array( $this, 'load_textdomain' ) );
			add_action( 'admin_enqueue_scripts',		  array( $this, 'admin_enqueue_script' ) );
			add_filter( 'mycred_run_addon_notifications', array( $this, 'mycred_disable_built_in_addon' ) );

		}

		/**
		 * Define Constants
		 * @since 1.0
		 * @version 1.0
		 */
		public function define_constants() {

			$this->define( 'MYCRED_NOTICE_VERSION',      $this->version );
			$this->define( 'MYCRED_NOTICE_SLUG',         $this->slug );
			$this->define( 'MYCRED_NOTICE_JS_VERSION',   $this->version );
			$this->define( 'MYCRED_NOTICE_CSS_VERSION',  $this->version );
			$this->define( 'MYCRED_DEFAULT_TYPE_KEY',    'mycred_default' );
			$this->define( 'MYCRED_MIN_SCRIPTS',         false );

			$this->define( 'myCRED_NOTICE',              __FILE__ );
			$this->define( 'MYCRED_NOTICE_ROOT_DIR',     plugin_dir_path( myCRED_NOTICE ) );
			$this->define( 'MYCRED_NOTICE_ASSETS_DIR',   MYCRED_NOTICE_ROOT_DIR . 'assets/' );
			$this->define( 'MYCRED_NOTICE_INCLUDES_DIR', MYCRED_NOTICE_ROOT_DIR . 'includes/' );
			$this->define( 'MYCRED_NOTICE_MODULES_DIR',  MYCRED_NOTICE_ROOT_DIR . 'modules/' );

		}

		/**
		 * Includes
		 * @since 1.0
		 * @version 1.0
		 */
		public function includes() {

			$this->file( MYCRED_NOTICE_ROOT_DIR . 'license/license.php' );
			$this->file( MYCRED_NOTICE_INCLUDES_DIR . 'mycred-notice-functions.php' );

		}

		/**
		 * Start
		 * @since 1.0
		 * @version 1.0
		 */
		public function start_up() {

			$this->file( MYCRED_NOTICE_MODULES_DIR . 'mycred-notifications.php' );

			$notice = new myCRED_Notifications();
			$notice->load();

		}

		/**
		 * Load Textdomain
		 * @since 1.0
		 * @version 1.0
		 */
		public function load_textdomain() {

			// Load Translation
			$locale = apply_filters( 'plugin_locale', get_locale(), $this->domain );

			load_textdomain( $this->domain, WP_LANG_DIR . '/' . $this->slug . '/' . $this->domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $this->domain, false, dirname( $this->plugin ) . '/lang/' );

		}

		/**
		 * Admin Scripts
		 * @since 1.6
		 * @version 1.0
		 */
		public function admin_enqueue_script( $hook_suffix ) {

			if ( strpos( $hook_suffix, 'mycred-addons' ) !== false ) {
				wp_enqueue_script( 'mycred_notice_addon', plugin_dir_url( __FILE__ ) . '/assets/js/mycred-notice-addon.js', array('jquery'), $this->version );
			}
		    
		}

		public function mycred_disable_built_in_addon() {

			return false;
		}

	}
endif;

function mycred_notice_plus_plugin() {
	return myCRED_Notice_Plus_Plugin::instance();
}
mycred_notice_plus_plugin();