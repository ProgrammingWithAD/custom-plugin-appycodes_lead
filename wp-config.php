<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'appy' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

if ( !defined('WP_CLI') ) {
    define( 'WP_SITEURL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
    define( 'WP_HOME',    $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
}



/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'fWRTDELBGdVSJxv8Nt8TtGttpxZKtu185RynZPYDXeNQFxIqVKx7lrs1w8YvQrpn' );
define( 'SECURE_AUTH_KEY',  '2Hylw8RNWZkDLOrSylkBOnsLNoAlUMwXtf5m4MQAzQYw1d19spnUsneSnlCt6Keb' );
define( 'LOGGED_IN_KEY',    'TWhZBwtClJVa7K5uFrcpAIdCGEwGHF3Y97cTiyiTbxIUBcVdNB00jn5OYS8OnceS' );
define( 'NONCE_KEY',        'UvnVhwthY666wzCBzahGWxjTetAkjmeSrT0u96wHNExzRemMTcwiOQFay97jpyL7' );
define( 'AUTH_SALT',        'KVLwYhfTkah37h2BeRB9zZuTXBJ6E36aGg5vYVLSpYKo4qpJiyF4KvOKUeZR2ima' );
define( 'SECURE_AUTH_SALT', 'HV2OmovBheNThF4p5NYl1Z6eQScDmjF3A0E7kHXabeRt0S0IwOfEMr74HinmCtRk' );
define( 'LOGGED_IN_SALT',   'cLASqJZCK7el2Ymvb2UxHMCd5SKydfxyvIRXtggTQ52h50BbB1ZoRII6dtgvEozB' );
define( 'NONCE_SALT',       'VqwqgCn9BzqYaPiYs7IkqIgasPLwfC50iFuqpoVsxoP7VMavg9hslw9ArFvbtnZg' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
