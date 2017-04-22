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
define('DB_NAME', 'hack');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

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
define('AUTH_KEY',         '#ok{@[C7-C^If<c?+/Je%2#y$:aAiIsvIk2r|{R&>%n<]3g=~jVd+v8Ve-a%bELl');
define('SECURE_AUTH_KEY',  '{O3R Dt{nk]j,RuV(/md^=Xw]rV5I1Ef4h}4yKz=(nK=YX+ @hHf*bqcI1yA#]1>');
define('LOGGED_IN_KEY',    '6[!1M6Eet,*gllFd.[J}6jkyMl42 zR,EZ}v:#zPosKKdfsBQLjLYDAPGmz8O*/q');
define('NONCE_KEY',        'F/eof+OMt6X!b=w/Xf4X~+0<K4zRZj0s?et,Mt;Hen,|vaG4Bb? 8;gg#1/J |o$');
define('AUTH_SALT',        '`<}Vtl%0{Vx9~10K~xx$&1Hpjf=?v|F|1Jj6|S~=o7IH}&XuX#lX&=tPpH/]_cLz');
define('SECURE_AUTH_SALT', ':.,sf{@o3-)|TMCQAG=.RNA>C3P`icjyM{pmpRv(Pv#%B+v;tJ`#kh6om1OcBeC>');
define('LOGGED_IN_SALT',   'Eq%SptC>PBtA35SeKK *GL4ex=0r9KJ^<#Bvp3TU*{ZB#.1<n KV-obbe{8.Hrf8');
define('NONCE_SALT',       'Ao5[jBuWpEO[8QS-ZHq?!,9.xUUB3l249UDsC7u>AnLi@sWVgs7)FNmE:OoNm~0:');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_hack';

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
