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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_uhack_puno');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'j56%c96[>JO^L#f~gP[7K1Qvll%2ZGj1N.QVl_51PE)A_#<v_YwgHt!lo;^YI>jR');
define('SECURE_AUTH_KEY',  '>mot%Qz*:sp(tUZWhcTxy@YxR=Q!`cMOBEbU3b^XSBK c)fDt%^/6`_jakxYxC+Z');
define('LOGGED_IN_KEY',    'NVw0(?q}5Cihia.Bx|5Zw_tgW6R$,}qth_$cTnCm=;u* w#yj&mKP]kd{MmqKtc:');
define('NONCE_KEY',        'M{64K(~i~2#$ALRSlgQ7Q&^7mHJ>l=ecfMFbaTkz]t[wnz X)a(EwgG->=egb?p}');
define('AUTH_SALT',        'YX[g~?%|tz!,2eD[s0f5r>}^eu!XkF9dLQ~B$AV$62VELXz]tYHwBHDJ<fOH4PmG');
define('SECURE_AUTH_SALT', '*](k;Il#HZMa@ptvLl*d!k%{2}K/#;~#k-j;RLqpm7d5}_;L70H^USgfyRQGX^C{');
define('LOGGED_IN_SALT',   ':|)ks8`5a9^777]k83a%J|g`~rOK=-/AL@+ghL!~`*KR@a,gzs%th|h7&nG,Wn}i');
define('NONCE_SALT',       'A-tXP{o{yUTD3>>dr@gX-QlgBVoar|raC3-j06RP2|1DFA[,L-*&^wE]sze@K.`Z');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
