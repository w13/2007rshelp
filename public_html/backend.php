<?php
/*** Backend ***/

/* Redirect to primary domain */
/* 
if( $_SERVER['SERVER_NAME'] != '2007rshelp.com' ) {
	@header( 'HTTP/1.1 301 Moved Permanently' );
	@header( 'location: https://2007rshelp.com' . $_SERVER['REQUEST_URI'] );
}
*/


if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}

/* Security Headers */
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

/* Error Handling */
// Configure error reporting based on environment
// For development: enable all errors
ini_set('display_errors', 'On');
error_reporting(E_ALL);

/* Security For Our Info */
define( 'IN_ZYBEZ' , TRUE );

/* New Line Identifier */
define( 'NL' , "\n" );

/* Path to Root */
$ROOT = dirname(__FILE__);
define( 'ROOT' , $ROOT );

/* Require Configuration */
require( ROOT . '/config.inc.php' );

/* Classes */
require( ROOT . '/classes.inc.php' );

/* Functions */
require( ROOT . '/functions.inc.php' );

// MySQL Connection
$db = new db();
$time = new timer();
$disp = new display( $db, SITE_URL , ROOT );

/* Global Vars */
global $db;
global $disp;
global $time;
global $TITLE;
global $DEBUG;

$DEBUG = 0;

/* MySQL Connection Info */
$db->set_mysql_host( MYSQL_HOST );
$db->set_mysql_user( MYSQL_USER );
$db->set_mysql_pass( MYSQL_PASS );
$db->set_mysql_database ( MYSQL_DB );

/* Secure Input */
// Extract sanitized variables from cleanArr
// Note: extract() is used here but input is sanitized via cleanVars()
if(isset($cleanArr) && is_array($cleanArr)) {
	$cleaned_vars = $disp->cleanVars($cleanArr);
	if(is_array($cleaned_vars)) {
		extract($cleaned_vars);
	}
}


// Start Function
function start_page( $title = '' )
{  
	global $db, $disp, $time, $TITLE;

	$time->startTimer();
	$disp->check_status();

	$TITLE = $title;

	$db->connect();
	$db->select_db( MYSQL_DB );
	

	ob_start();
}

// End Function
function end_page( $title = '' )
{
	global $db , $disp, $time, $TITLE, $DEBUG;

	$contents = ob_get_contents();
	ob_end_clean();

	// Template
	$PAGE 		  = $disp->get_file( '/content/layout.inc' );
	$topbar		  = $disp->get_file( '/content/bar-top.inc' );
	$bottombar	= $disp->get_file( '/content/bar-bottom.inc' );
	$navigation	= $disp->get_file( '/content/links.inc' );
	$ads		    = $disp->get_file( '/content/ads.inc' );
	$copyright	= $disp->get_file( '/content/copyright.inc' );
	$metadescr	= $disp->metadesc( basename($_SERVER['SCRIPT_NAME']) );
	$extra_css	= $disp->extra_css( basename($_SERVER['SCRIPT_NAME']) );
	$TITLE		  = $disp->title( $TITLE , $title , SITE_NAME );
//	$favicon	  = IN_TIKO === true ? 'favicont' : 'favicon';
$favicon = 'favicon';


	// Replaces
	$PAGE = str_replace( '[#SITE_NAME#]' , $TITLE               , $PAGE );
	$PAGE = str_replace( '[#METADESCR#]' , $metadescr           , $PAGE );
	$PAGE = str_replace( '[#EXTRACSS#]'  , $extra_css           , $PAGE );
	$PAGE = str_replace( '[#FAVICON#]'   , $favicon             , $PAGE );
	$PAGE = str_replace( '[#LINKS#]'     , $navigation          , $PAGE );
	$PAGE = str_replace( '[#CONTENT#]'   , $contents            , $PAGE );
	$PAGE = str_replace( '[#ADS#]'       , $ads                 , $PAGE );
	$PAGE = str_replace( '[#QUERIES#]'   , $db->count_queries() , $PAGE );
	$PAGE = str_replace( '[#LOAD#]'      , $time->showLoad()    , $PAGE );
	$PAGE = str_replace( '[#TIME#]'      , $time->endTimer()    , $PAGE );
	$PAGE = str_replace( '[#TOPBAR#]'    , $topbar              , $PAGE );
	$PAGE = str_replace( '[#BOTBAR#]'    , $bottombar           , $PAGE );
	$PAGE = str_replace( '[#COPYRIGHT#]' , $copyright           , $PAGE );

	echo $PAGE;

	if($DEBUG == 1) {
		echo 'Input error level: '.$disp->errlevel;
		echo $db->cache;
	}

	$db->disconnect();
}
?>
