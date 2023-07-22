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
define( 'DB_NAME', 'ecommerce' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'Z@1c&L1ZEgFR&m,7j>J2`Uc D|tDfSph]7$o39>i[#@,l(Z<$6?qOEo|kUx;y([b' );
define( 'SECURE_AUTH_KEY',  '~[]T%j`i]AVueO[PPU:T%t-(JJ@H[ c-Q]FM-sQKrR^l$k(OG!d((H7fh[cYscfI' );
define( 'LOGGED_IN_KEY',    'sGvHKLM#OM*&}#&ms^aTr1(et,%&3l@![SMB-ruJi_gV*N$BEjc;cB#LAcoyXw.M' );
define( 'NONCE_KEY',        '_=p$Tbi=;~*AGB][*p*rog{RSww&xu),?u>IhHuPJ!+>X-$O-WJk:o^.]nLPew_4' );
define( 'AUTH_SALT',        'xJ9jehqG}w8z?SMvMP&`a!rl~NkS3i6YqD&(DK((Xlv,IAs`C9$9(L4*4oP7]104' );
define( 'SECURE_AUTH_SALT', '?XhQc$6M%};{~t.X=KHX+(4vuLJi0`qn/&j,[^2hc_C2P/y@7K,d@*4O[]c<yk!_' );
define( 'LOGGED_IN_SALT',   '^oNcx@Rx3f@_=o2B6ZO&6^AHPT*e$7i{M@x2>jPGU`kL8nIED2g#=n G,<uB.oO!' );
define( 'NONCE_SALT',       '#>!J>)_u:@1Q}@Vs6Cv1N?%R`@$Z!;^r,`|R*pE$Pq93TsW~Yi>Lzve~NV27hs%3' );

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
