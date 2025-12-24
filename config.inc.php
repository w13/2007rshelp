<?php
/*** Configuration ***/

/* Security Check - Prevent direct access */
$security = "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\n".
"<html><head>\n".
"<title>404 Not Found</title>\n".
"</head><body>\n".
"<h1>Not Found</h1>\n".
"<p>The requested URL " . htmlspecialchars($_SERVER['REQUEST_URI'] ?? '', ENT_QUOTES, 'UTF-8') . " was not found on this server.</p>\n".
"</body></html>";

if(!defined( 'IN_ZYBEZ' )) die( $security );
if(!isset($DEBUG)) $DEBUG = 0;

/*
 * SECURITY RECOMMENDATION:
 * Store sensitive credentials in environment variables instead of hardcoding them.
 *
 * Option 1: Set in your web server configuration (Apache/nginx)
 * Option 2: Use a .env file (outside public_html) with a library like vlucas/phpdotenv
 * Option 3: Use config file outside the web root
 *
 * For production: Ensure this file is not accessible via web browser
 * Add to .htaccess in public_html root:
 *   <Files "config.inc.php">
 *       Require all denied
 *   </Files>
 */

/* Site Configuration */
$Configuration['site_name']  = 'Old School RuneScape Help';
$Configuration['site_url']   = 'https://2007rshelp.com';

/* Database Configuration - Environment variables take precedence */
$Configuration['mysql_host'] = getenv('DB_HOST') ?: 'localhost';
$Configuration['mysql_user'] = getenv('DB_USER') ?: 'rsc';
$Configuration['mysql_pass'] = getenv('DB_PASS') ?: 'heyplants#44#';  // TODO: Move to environment variable
$Configuration['mysql_db']   = getenv('DB_NAME') ?: 'rsc_site';

// Validate database configuration is set
if (empty($Configuration['mysql_host']) || empty($Configuration['mysql_user']) ||
    empty($Configuration['mysql_pass']) || empty($Configuration['mysql_db'])) {
    error_log('Database configuration is incomplete');
    die('Configuration error. Please contact the administrator.');
}

// Online / Offline Mode
$Configuration['offline'] = FALSE;


/* Define Global Constants */
define( 'MYSQL_HOST'	, $Configuration['mysql_host']	);
define( 'MYSQL_USER'	, $Configuration['mysql_user']	);
define( 'MYSQL_PASS'	, $Configuration['mysql_pass']	);
define( 'MYSQL_DB'		, $Configuration['mysql_db']	);
define( 'SITE_NAME'		, $Configuration['site_name']	);
define( 'SITE_URL'		, $Configuration['site_url']	);
define( 'OFFLINE'		, $Configuration['offline']		);

/* Unset configuration array to prevent access */
unset($Configuration);

?>

