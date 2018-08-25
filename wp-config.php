<?php
/**
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'rapimarket');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', 'root');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8mb4');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '^fb/B-;U{YH_Wp1V4`O2Qq~5H,duz9J35s#|lO|(1`%;Hh]ptCJkxs$J:l.#Nc>/');
define('SECURE_AUTH_KEY', '`i^2jWz2?1hq+zyf.D,1`sY*q`rX[=lrWI<RcQJ$m.^q+j7F*7E%GSaJs$PT>(`e');
define('LOGGED_IN_KEY', 'af^1wq5Y)Smh#pwY{%m H>Qug]4b6B5NkZ.>o[?MB}o<R1glD{|p%n|.$uS*|0$%');
define('NONCE_KEY', '[8k^X8FD*/07-ERtrP3~U4-t^TJ}MU~K]E#)6@_)jm 4BLTZ,9Tgl;mD:Mx0}@6p');
define('AUTH_SALT', 'ty LMn?&Kwi=E8#C)+ x89>//Vy!*<[=JF8S)4+DV#@@*j$I!zD.4_F0knvr%7%C');
define('SECURE_AUTH_SALT', 'TrtgqDp:3p8}Q5:uop5c{7j-y_UrV%5~+=x# %eb4<EW,IUsq:up[0c}>Mdq6@s<');
define('LOGGED_IN_SALT', 'eYa;6c.nHQ7Uqd,e2~-FzKDIJAqcbb*L=@|#4h+4.}K)5TkAXn^VECc_}[Y<r3^O');
define('NONCE_SALT', '>,Hx+r/dzP%~>zwp`pDorOS>8lY^%fH=l7{w4|9=YCmUfPC`gD zU42!0MO%qw&3');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
