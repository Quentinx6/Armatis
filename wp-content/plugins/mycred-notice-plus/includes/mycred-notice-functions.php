<?php
if ( ! defined( 'MYCRED_NOTICE_VERSION' ) ) exit;

/**
 * Get Notice Table
 * @since 1.3
 * @version 1.0
 */
if ( ! function_exists( 'mycred_notice_db_table' ) ) :
	function mycred_notice_db_table() {

		if ( defined( 'MYCRED_NOTICE_TABLE' ) )
			return MYCRED_NOTICE_TABLE;

		global $wpdb;

		if ( is_multisite() && mycred_centralize_log() )
			$table = $wpdb->base_prefix . 'myCRED_notices';
		else
			$table = $wpdb->prefix . 'myCRED_notices';

		return $table;

	}
endif;

/**
 * Get Notices
 * @since 1.3
 * @version 1.0
 */
if ( ! function_exists( 'mycred_get_pending_notices' ) ) :
	function mycred_get_pending_notices( $user_id = NULL, $type = NULL ) {

		if ( $user_id === NULL ) return false;

		global $wpdb;

		$table = mycred_notice_db_table();

		if ( $type !== NULL && sanitize_text_field( $type ) != '' )
			$query = $wpdb->prepare( "SELECT * FROM {$table} WHERE user_id = %d AND type = %s ORDER BY time DESC;", $user_id, $type );

		else
			$query = $wpdb->prepare( "SELECT * FROM {$table} WHERE user_id = %d ORDER BY time DESC;", $user_id );

		return $wpdb->get_results( $query );

	}
endif;

/**
 * Get Notices JS
 * @since 1.3.6
 * @version 1.0
 */
if ( ! function_exists( 'mycred_get_pending_notices_js' ) ) :
	function mycred_get_pending_notices_js( $user_id = NULL, $type = NULL ) {

		$results       = array();
		if ( $user_id === NULL ) return $results;

		$notifications = mycred_get_pending_notices( $user_id, $type );

		if ( ! empty( $notifications ) ) {
			foreach ( $notifications as $notice ) {

				$mycred  = mycred( $notice->type );

				// Parse The actual message
				$entry   = $mycred->template_tags_general( $notice->entry );
				$entry   = str_replace( array( "\r", "\n", "\t" ), '', $entry );
				$entry   = str_replace( '"', "'", $entry );

				$classes = 'notice-item';
				if ( $notice->data != '' )
					$classes .= ' ' . $notice->data;

				$row          = new StdClass();
				$row->id      = $notice->id;
				$row->text    = $entry;
				$row->type    = esc_js( $notice->type );
				$row->classes = esc_js( $classes );

				$results[]    = $row;

			}
		}

		return $results;

	}
endif;

/**
 * Add Notice
 * @since 1.3
 * @version 1.0
 */
if ( ! function_exists( 'mycred_add_pending_notice' ) ) :
	function mycred_add_pending_notice( $user_id = NULL, $entry = array() ) {

		if ( $user_id === NULL ) return false;

		$entry = shortcode_atts( array(
			'status'  => 0,
			'type'    => '',
			'time'    => current_time( 'timestamp' ),
			'entry'   => '',
			'data'    => ''
		), $entry );

		if ( $entry['entry'] == '' ) return false;

		$entry['data']    = maybe_serialize( $entry['data'] );
		$entry['user_id'] = absint( $user_id );

		global $wpdb;

		$table = mycred_notice_db_table();

		$wpdb->insert(
			$table,
			$entry,
			array( '%d', '%s', '%d', '%s', '%s', '%d' )
		);

		return true;

	}
endif;

/**
 * Delete Notices
 * @since 1.3
 * @version 1.0
 */
if ( ! function_exists( 'mycred_delete_pending_notices' ) ) :
	function mycred_delete_pending_notices( $user_id = NULL ) {

		if ( $user_id === NULL ) return false;

		global $wpdb;

		$table = mycred_notice_db_table();

		$wpdb->delete(
			$table,
			array( 'user_id' => $user_id, 'status' => 0 ),
			array( '%d', '%d' )
		);

	}
endif;

/**
 * Count Notices
 * @since 1.3
 * @version 1.0
 */
if ( ! function_exists( 'mycred_count_pending_notices' ) ) :
	function mycred_count_pending_notices( $user_id = NULL, $type = NULL ) {

		if ( $user_id === NULL ) return 0;

		global $wpdb;

		$table = mycred_notice_db_table();

		if ( $type !== NULL && sanitize_text_field( $type ) != '' )
			$query = $wpdb->prepare( "SELECT COUNT(*) FROM {$table} WHERE user_id = %d AND type = %s ORDER BY time DESC;", $user_id, $type );

		else
			$query = $wpdb->prepare( "SELECT COUNT(*) FROM {$table} WHERE user_id = %d ORDER BY time DESC;", $user_id );

		$count = $wpdb->get_var( $query );
		if ( $count === NULL )
			$count = 0;

		return $count;

	}
endif;

/**
 * Add Notice
 * @since 1.0.3
 * @version 1.1
 */
if ( ! function_exists( 'mycred_add_new_notice' ) ) :
	function mycred_add_new_notice( $notice = array(), $life = 1 ) {

		if ( ! isset( $notice['user_id'] ) || ! isset( $notice['message'] ) ) return false;

		return mycred_add_pending_notice( $notice['user_id'], array(
			'entry' => $notice['message'],
			'type'  => 'oldversion'
		) );

	}
endif;

/**
 * Plugin Activation
 * @since 1.3.2
 * @version 1.0.1
 */
if ( ! function_exists( 'mycred_note_plus_plugin_activation' ) ) :
	function mycred_note_plus_plugin_activation() {

		global $wpdb;

		$message = array();

		// WordPress check
		$wp_version = $GLOBALS['wp_version'];
		if ( version_compare( $wp_version, '4.0', '<' ) )
			$message[] = __( 'This myCRED Add-on requires WordPress 4.0 or higher. Version detected:', 'mycred_notice' ) . ' ' . $wp_version;

		// PHP check
		$php_version = phpversion();
		if ( version_compare( $php_version, '5.3', '<' ) )
			$message[] = __( 'This myCRED Add-on requires PHP 5.3 or higher. Version detected: ', 'mycred_notice' ) . ' ' . $php_version;

		// SQL check
		$sql_version = $wpdb->db_version();
		if ( version_compare( $sql_version, '5.0', '<' ) )
			$message[] = __( 'This myCRED Add-on requires SQL 5.0 or higher. Version detected: ', 'mycred_notice' ) . ' ' . $sql_version;

		// myCRED Check
		if ( defined( 'myCRED_VERSION' ) && version_compare( myCRED_VERSION, '1.6', '<' ) )
			$message[] = __( 'This add-on requires myCRED 1.6 or higher. Version detected:', 'mycred_notice' ) . ' ' . myCRED_VERSION;

		// Not empty $message means there are issues
		if ( ! empty( $message ) ) {

			$error_message = implode( "\n", $message );
			die( __( 'Sorry but your WordPress installation does not reach the minimum requirements for running this add-on. The following errors were given:', 'mycred_notice' ) . "\n" . $error_message );

		}

		mycred_notice_core_addon_deactivate();

		mycred_notice_plus_install_db();

	}
endif;

/**
 * Install Database
 * @since 1.2
 * @version 1.0.1
 */
if ( ! function_exists( 'mycred_notice_plus_install_db' ) ) :
	function mycred_notice_plus_install_db() {

		if ( mycred_get_option( 'mycred_notice_plus_db', false ) === '1.0.1' ) return;

		global $wpdb;

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$table = mycred_notice_db_table();

		$wpdb->hide_errors();

		$collate = '';
		if ( $wpdb->has_cap( 'collation' ) ) {
			if ( ! empty( $wpdb->charset ) )
				$collate .= "DEFAULT CHARACTER SET {$wpdb->charset}";
			if ( ! empty( $wpdb->collate ) )
				$collate .= " COLLATE {$wpdb->collate}";
		}

		// Log structure
		$sql = "
			id               INT(11) NOT NULL AUTO_INCREMENT, 
			status           INT(11) DEFAULT 0, 
			user_id          INT(11) DEFAULT 0, 
			type             LONGTEXT DEFAULT '', 
			time             BIGINT(20) DEFAULT NULL, 
			entry            LONGTEXT DEFAULT '', 
			data             LONGTEXT DEFAULT '', 
			PRIMARY KEY  (id), 
			UNIQUE KEY id (id)"; 

		// Insert table
		dbDelta( "CREATE TABLE IF NOT EXISTS {$table} ( " . $sql . " ) $collate;" );

		if ( function_exists( 'mycred_update_option' ) )
			mycred_update_option( 'mycred_notice_plus_db', '1.0.1' );
		else
			update_option( 'mycred_notice_plus_db', '1.0.1' );

	}
endif;

/**
 * Uninstaller
 * @since 1.3.1
 * @version 1.0.1
 */
if ( ! function_exists( 'mycred_note_plus_plugin_uninstall' ) ) :
	function mycred_note_plus_plugin_uninstall() {

		global $wpdb;

		$table_name = mycred_notice_db_table();
		$wpdb->query( "DROP TABLE IF EXISTS {$table_name};" );

		if ( function_exists( 'mycred_delete_option' ) )
			mycred_delete_option( 'mycred_notice_plus_db' );
		else
			delete_option( 'mycred_notice_plus_db' );

	}
endif;

/**
 * Deactivate Built-in Notification Addon
 * @since 1.6
 * @version 1.0
 */
if ( ! function_exists( 'mycred_notice_core_addon_deactivate' ) ) :
	function mycred_notice_core_addon_deactivate() {

		if ( class_exists( 'myCRED_Addons_Module' ) ) {

			$mycred_modules = new myCRED_Addons_Module();
        	
        	if ( $mycred_modules->is_active( 'notifications' ) ) {

        		$addons = mycred_get_option( 'mycred_pref_addons' );

				$index = array_search( 'notifications', $addons['active'] );
				
				if ( $index !== false ) {

					unset( $addons['active'][ $index ] );
					mycred_update_option( 'mycred_pref_addons', $addons );

				}

        	}
		}

	}
endif;
