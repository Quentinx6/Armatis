<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'gLu+KZCOO5yile0l841jJ2HwhjatUUgOyp9ACIRGxB/NUS/aejE56UiEM2PLgmdPCYXBIdmx3DuMpJV42nWAcA==');
define('SECURE_AUTH_KEY',  'NpUpYmBDNFGzH2xOvltRGlfSJ0PRg1WHLlDrRAyhSMlsqQ7ji45OzOH/WKOwdZBu+N1OTUk9Q+sfeBPdGe5szA==');
define('LOGGED_IN_KEY',    'qMDIeetRNInaSIMCFS0chcKhl+z4zHZRzepxjEJukhiA7zFa3USclWnxEDpaH3E7UP1nbzNkEzUiKxBEYSioeQ==');
define('NONCE_KEY',        '5MnhlU9L9q0l1kk/sbKdX5S2dI54aBnELxLMM3ZmV35BVCTJqYTKq393rArv0UFmm7FWKCAXzrA6Q+j0M/qJig==');
define('AUTH_SALT',        'a3xnaolUHsfxbKKi76oE1SWSfQh2xuS/IKs4ywZF6965IpFSwLqlhVJstieOZY5HMJ/nm2c4f6m0ngqYGSCNPQ==');
define('SECURE_AUTH_SALT', 'XfJvDxT7uYjuRsGvjNQEtNBwwdHSOPhTJExheNjd9+Fa1Z2LiM5nGyfnxuYImU4ZNJsW9H9TKjcXd6sOeBZkTg==');
define('LOGGED_IN_SALT',   'CMguwezuhmxu8TAWwcH1vbIk0FcLPHBSd7rRrO13S1ltfNDAck/Q6pL34uIsHQWX1XAYvoub7ciEuu5s7mbhVw==');
define('NONCE_SALT',       'MdZ2DMfnItMSQoHK0goW9PXZ8Soz+XVoTAOtSVTDs0FqIcc+t34NaHYLsSKlba2Xb2Hc6N54meDRA9L5YMmqjA==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'soda_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
