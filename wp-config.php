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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpress' );

/** MySQL database password */
define( 'DB_PASSWORD', 'f0d2336dbd0bc17f9709847ffb04737e171115ef7b2253c9' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         'e+;N)[zZ`$MeIq1yr}GGyXY1awvpcP);asp:</y5Gs4)~!z2! D(sUMeFRn.8,1<' );
define( 'SECURE_AUTH_KEY',  '67sq$]J9R;P>}BGAc|J<Hz0WE &m~fK2{hsk]kQ:9J@&2 CK<8,>m#BF6LI:8Up@' );
define( 'LOGGED_IN_KEY',    '?EwWp94Jo-/3.47eGtDw[D>7Y@k)0IX,J%boMpjfbtB^6KAUS5LiRV8Ky%aWz?>?' );
define( 'NONCE_KEY',        'B0+=X3X~m$THR} ~lXf]Q?Eu %JTO4b6/]I$:utCy rT~J>QrZUG7hT=jtW1BR!Z' );
define( 'AUTH_SALT',        'D8njxw2vVHnVt(H}ays$.]pW7e :9zw)Y;QB;423L.-NL}-w:|;kc>`3V7VA~jux' );
define( 'SECURE_AUTH_SALT', 'Gyf6f3{,IbI]^0%&hWiWMip5b90+Q:mxR@:}n[@1gRj8zyE65 ()>8W&irvw9goK' );
define( 'LOGGED_IN_SALT',   '4$OScF&%r_$nTC+5^($Dy%bd&hcxz hR&O@lV#[(aMeV1xBpCo,4.Z](M_y0<iAM' );
define( 'NONCE_SALT',       '45uw2O+aWF(}G_G) j&>l/k/f`<c6M3$+7~eKTF/4DxEj@|`jZY<iXPh Qt:5@Z9' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */


define( 'WP_ENVIRONMENT_TYPE', 'production' );
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG_LOG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
