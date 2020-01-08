<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'basket' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '7zR_(?>ZoA`|+5q/+M6!9~&3c+#wQmu>]S I?/,=i/H^{ISDB^,LXV*VC@RcyA0w' );
define( 'SECURE_AUTH_KEY',  ':c[yFe^OlQlv8[XTP!iB>T6gVkXx~5D4[|4=c3P}O<0jC{2qzA<mK36JM_H&j)]g' );
define( 'LOGGED_IN_KEY',    '<skv|Xg+:B5he/p1$H)Ad{(`0K/)tbdG]9x.!xI@v=j-*`bHYkE2V4$5<B9*E^C3' );
define( 'NONCE_KEY',        's:5+T27[ 9T@3.:W2#L58jHUc4hcVrv[`Tl{HYkl-4%<-K}J:n<3T|6Wr]o&I^@C' );
define( 'AUTH_SALT',        'c$Z6#f%[#xKbbB*{TdcL:o%@Qj:%d&u9FSVQa%tNg;;/gZb./L:DAaEbQ$d0/pnF' );
define( 'SECURE_AUTH_SALT', 'v,+66`Eb~RImG6A//>5G`sm~S|WIe! {^@LV^?21[E|md8J4MySD1h|~#@?9#T0T' );
define( 'LOGGED_IN_SALT',   'IF#o_m=ajPs:CU92SEudqwT:6-(0HQp4/-%B ,@ohvK|dB|/v;THI[olbxX;:Eba' );
define( 'NONCE_SALT',       '3SR9%l*%h0s99j19S=O(>la&Bsmha*2|tJ}{EHpo)x1kW=a2E+|c8^]fWA3ie3R+' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
