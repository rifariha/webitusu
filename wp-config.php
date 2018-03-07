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
define('DB_NAME', 'webit');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'LyM|DbV;fQlCoT=GZo8+t`ou.!Y>_MxcIc5A3N5EZwCQ(}I@620klPNuO bK5!45');
define('SECURE_AUTH_KEY',  'RL_On~fkT*xfA*lAc:7_K[{&?`N.8k1q/zt&LS,ThRRen8W*K6.i)j$)I~P[*~YG');
define('LOGGED_IN_KEY',    '1{=!.R71w2]KDs.;>y~S04fzZ}JpY*%k&i@9;b~X3sk9(f.pv-96%E{|IL@<???R');
define('NONCE_KEY',        ',^Y4S3PW^,:(XRD,`pe>Z*uKJ.pp>#SN[*7]2voth8?B}&F/=[fk>JkCv>v-9T~o');
define('AUTH_SALT',        '6/nTk7U8DzM[(=Ilyj+dT1E<CSIEjpV$_b{4,@Pz~/=o.N@t9yux+$3Fk}>Vt pS');
define('SECURE_AUTH_SALT', '2^_Xp;>! rDsnV-xbE^m:XpIIEE7y?A1=4OD-*f1q`}&CNAJ2qeEzv{G}qB 1][+');
define('LOGGED_IN_SALT',   '>YRt~>1F&T5fa&P+}Dm35A1f(QRp 7gW/ZdGB19j7WNmw^6EM_.#sQZJS8;Q2L1Z');
define('NONCE_SALT',       'Dp;MSLP[]=zh!by[KW Et27bZiy~]Sy0|d))f=T#rz;ATGWuA@2>oG#0 ggbgMPe');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'webit_';

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
