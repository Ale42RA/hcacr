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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
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
define( 'AUTH_KEY',          '+;LDS[^Tq+)2J[)a!4hoQ&COyS`_!BU,7O~Fm#{CVr7!BI^2D]>SdHv70i}ZP*wF' );
define( 'SECURE_AUTH_KEY',   '1BF1j;hq$*]DyG0q`%D/VMVmmE)K]Gc(B?_1y<!G%=qSvJ32aAdS22DA!tt@+.>|' );
define( 'LOGGED_IN_KEY',     'G^0VR,aoW:o8#Xc*o#`q-!^tii_!tmEFQ3(j?T>}m$G(W/MhIj60D_%2~M[4h?of' );
define( 'NONCE_KEY',         'Qp0sO8a8Z<x(x<HK||lrH&q:Kg?h)tG@!J`7mq*C7yT8VYoS3u^}<bx>hDxLjlR{' );
define( 'AUTH_SALT',         'vBN=7%Y)0cgGt|1Ig<=Q$Ry`:]]zaS<W8n!O|ZuMh#3!#D@hKNGLy5Yj9*.K(]<*' );
define( 'SECURE_AUTH_SALT',  '^VB;1,.+2;dBTZX>[QEO9x2( TTHH:?:hbn/4>p02eC:JpdD)^nlD>$HEg,ER^|/' );
define( 'LOGGED_IN_SALT',    'L$3W,Z,t.oCHQt2$osfE{t;3;f?M|,y D(6c_!bvBwOoqUc)TmI{u~tkDftFXjb`' );
define( 'NONCE_SALT',        'Pmr1oVzXz3<_| ]LB*K%f[UTll[?*pG%s4:+v^^s|F_RlAmhME*0q,G #Ci@c2D]' );
define( 'WP_CACHE_KEY_SALT', 'je =A3R2qn`X^N%%[uU;3t(6tj?rC/s%^:*a1 ^PATzGkf*DQ#B;YF:-fxF*2OP4' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
