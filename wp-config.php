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


// ** MySQL settings - You can get this info from your web host ** //
$url = parse_url(getenv('DATABASE_URL') ? getenv('DATABASE_URL') : getenv('CLEARDB_DATABASE_URL'));

/** The name of the database for WordPress */
define('DB_NAME', trim($url['path'], '/'));

/** MySQL database username */
define('DB_USER', $url['user']);

/** MySQL database password */
define('DB_PASSWORD', $url['pass']);

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
define('AUTH_KEY',         'm1F1+u1Rf*E&mW^S%iCCq#w|`I3ar%/;q1$$cCumwsNWtq5fK`NQ/iaVf:3IHl|O');
define('SECURE_AUTH_KEY',  'D@b>93`/o7B}4b[ykxM9=zm;!S$/lCr3C-(pkiUfm&Wy90B>u>S*Alv?[(w(kuy;');
define('LOGGED_IN_KEY',    'DS+T>!LO<OV],X2X?d-GY+B/W[PNd::~Ad4.%llmSRHPQu6WG`,9iXt{P0jOL})N');
define('NONCE_KEY',        'er0z^Tmo~<u%O/hW>M+sQ) V50$VHn PU|MpHY{8 35OxgQl6cLI,CIYC H<;z]e');
define('AUTH_SALT',        'pp8ubw5).R8_rc&SG.fuXCy[h;OMsIaBDtZI[caKy ,x4!;yW/S)URd;KMAI9q+=');
define('SECURE_AUTH_SALT', 'ogIxvp!rbf;F>i|s<ui|.4EQP+51U@?*8Y>}}?{8jw,CCBa(J82c&So/*(DTW:86');
define('LOGGED_IN_SALT',   '@Vfv,U-m&BbEjRsy;wA*QETBrm`&>ux*QINPn.B<8g;b2OE(y*;0;h7*~jDR`}v?');
define('NONCE_SALT',       'bHUAR.fCVg-l|UP/$j>CpGecfRsyim((HX7r(%2GsU?::M^ix(aF5x*t(d$9qqfJ');
define('WP_ALLOW_REPAIR', true);
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
