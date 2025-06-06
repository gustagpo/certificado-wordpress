<?php

//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL cookie settings
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
define( 'DB_NAME', 'i8548532_wp3' );
/** MySQL database username */
define( 'DB_USER', 'i8548532_wp3' );
/** MySQL database password */
define( 'DB_PASSWORD', 'B.dcGBc5GLP0eKCXzbW08' );
/** MySQL hostname */
define( 'DB_HOST', "localhost" );
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
define( 'AUTH_KEY',          'Ob=fxDDBv+7F=MYx6ClLm#%f3%Tb!byJHh,6V]AM=2Wl>y%D2Eq{UI6pGH=z&ij[' );
define( 'SECURE_AUTH_KEY',   ' Bp zkHXnV&M`K,(0m*s JqCfj]8&U-Rj[KvmN)gW#9x:#%L7/l!7{O(Sk!tGO1g' );
define( 'LOGGED_IN_KEY',     'I(#ECj-q2hv;V<.=P#nc!YIQvdappkp,IbY~cK$:kRcvcU0Q*ANw=2b]@$&1Vb6s' );
define( 'NONCE_KEY',         '-OUn#[]BvY$|}|I UiD1vK<QL@]vJ*,;o.Sqkx$vI@JD4:(YdY~]t$:UeKvM*kMy' );
define( 'AUTH_SALT',         '2ON.v3%Xn6%Or;N~R=>}ut=5hUXrA`>ItFYlOB~!8?efeqB,dFkm;lBfA{_;RAs1' );
define( 'SECURE_AUTH_SALT',  't7NBBbOtf9;%@rHI|RGEh4KID%f#|a@`{;S$.5Mq%R KhI{8f/-iNz{:v1$/FR;/' );
define( 'LOGGED_IN_SALT',    '77rPV^KWC|1Rdl817p2B$$py4iNeowf0m|-{QFx4BmQT_hi[o`-yLVk}Aoj)Hxm2' );
define( 'NONCE_SALT',        'DLV(<IUw0-%)_tAjK[_`FAx>_:6piEHO=G/)%YDl7![ummw@y*KA,3!DRnO#E5un' );
define( 'WP_CACHE_KEY_SALT', ':661l=6e5Ju0H?Jcp@,.Zd}.;lZ*6/n=UL(m4hsy)Oq3DfTD/79wOt_B9=-sJ%<S' );
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';
define('WP_SITEURL','https://jornadaeduc.com.br' );
define( 'WP_CONTENT_URL', 'https://jornadaeduc.com.br/wp-content' );
define( 'WP_PLUGIN_URL', 'https://jornadaeduc.com.br/wp-content/plugins' );
define( 'WPMU_PLUGIN_URL', 'https://jornadaeduc.com.br/wp-content/mu-plugins' );

// Ativa a depuração
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';