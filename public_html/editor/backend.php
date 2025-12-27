<?php
/*** Backend ***/

/* Redirect to www.runescapecommunity.com/ */
$SERV = $_SERVER['SERVER_NAME'];

/*
if($SERV == 'www.runescapecommunity.com/' || $SERV == 'runescapecommunity.com/') {
    header('location: http://www.runescapecommunity.com/');
}
*/

/* Added Security Cookie Test 
if(!isset($_COOKIE['addedlogin'])){
    die('The cookie isnt set. You need to go back to corp and come here from there. <!--added login-->');
   header('location: http://www.runescapecommunity.com/');
}
*/

/* Error Handling */
ini_set('display_errors' , 'On');
error_reporting(E_ALL &~ E_NOTICE);


/* New Line Identifier */
define('NL' , "\n");

/* Path to Root */
$ROOT = '/home/2007rshelp/public_html';
define( 'ROOT' , $ROOT );

/* Require Admin Configuration */
require(ROOT.'/'.'editor'.'/'.'config.inc.php');


/* Classes */
require(ROOT.'/'.'editor'.'/'.'classes.inc.php');


/* Functions */
require(ROOT.'/'.'editor'.'/'.'functions.inc.php');


// Declare classes
$db = new db();
$time = new timer();
$disp = new display(SITE_URL , ROOT);
$ses = new ses($db);

/* Global Vars */
global $db;            // This must be done so we can access the MYSQL database.
global $disp;        // This must be done so we can use our skinning system
global $time;        // This is done so we can time our execution
global $TITLE;        // This is done so we can change the title
global $ses;        // So we can use the login system.
global $LAYOUT;         // So we can disable use of the layout if needed.

/* Get the CSS File */
$use_css = $disp->use_css();

/* MySQL Connection Info */
$db->set_mysql_host(MYSQL_HOST);
$db->set_mysql_user(MYSQL_USER);
$db->set_mysql_pass(MYSQL_PASS);

/* Page Funtions */

// Start Function
function start_page($perm = 0, $title = '', $use_layout = 'layout.inc') {

    // Global classes
    global $db, $disp, $time, $TITLE, $LAYOUT, $ses, $use_css;

    // Start the timer
    $time->startTimer();

    // Set the TITLE
    $TITLE = $title;

    // Set the LAYOUT
    $LAYOUT = $use_layout;

  // Check Online / Offline: Addition by ben 19 apr.
  $disp->check_status();

    // Connect & Select
    $db->connect();
    $db->select_db(MYSQL_DB);

    // Login if user and pass is given.
    if(isset($_POST['user']) AND isset($_POST['pass'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $ses->login($user, $pass);
    }

    // Check Login Information / Display Error Page
    $check = $db->fetch_row("SELECT locked FROM admin WHERE id = ".$_SESSION['userid']);
    if(!$ses->logged_in || $check['locked']) {
        die($ses->login_form($use_css));
    }

    // Check Permissions / Display Error Page
    if(!$ses->permit($perm) AND $perm != 0) {
        die($ses->nopermit($use_css, $ses));
    }

    // Start the output buffer
    ob_start();

}

// End Function
function end_page($title = '') {

    // Global Classes
    global $db , $disp, $time, $TITLE, $LAYOUT, $ses, $use_css;

    // Get buffer contents & wipe the buffer
    $contents = ob_get_clean();

    // Main Page
    ob_start();
    require(ROOT.'/editor/content/'.$LAYOUT);
    $PAGE = ob_get_clean();
    // Links
    ob_start();
    require(ROOT.'/editor/content/links.inc');
    $navigation = ob_get_clean();
    // Links
    ob_start();
    require(ROOT.'/editor/content/bar-bottom.inc');
    $botbar = ob_get_clean();

    $TITLE		  = $disp->title( $TITLE , $title , SITE_NAME );

  // Banner
  $topbar = $disp->get_file( '/editor/content/bar-top.inc' );
    // Replaces
    //$zone = $db->fetch_array($db->query("SELECT zone FROM admin WHERE id = ".$_SESSION['userid']));
    //$USRTIME = time() + ((6 + $zone['zone']) * 60 * 60);
    $GMTTIME = time() + 21600;
    //$cdate = date("F jS, Y", $GMTTIME);
    $ctime = date("g:i A", $GMTTIME);
    
    $PAGE = str_replace('[#SITE_NAME#]'   , $TITLE                  , $PAGE);
    $PAGE = str_replace('[#CSS#]'         , $use_css                , $PAGE);
    $PAGE = str_replace('[#TOPBAR#]'      , $topbar                 , $PAGE);
    $PAGE = str_replace('[#BOTTOMBAR#]'   , $botbar                 , $PAGE);
    $PAGE = str_replace('[#LINKS#]'       , $navigation             , $PAGE);
    $PAGE = str_replace('[#USER#]'        , $ses->user              , $PAGE);
    $PAGE = str_replace('[#CTIME#]'       , $ctime                  , $PAGE);
    $PAGE = str_replace('[#CORRECTION#]'  , num_correct()           , $PAGE);
    $PAGE = str_replace('[#CONTENT#]'     , $contents               , $PAGE);
    $PAGE = str_replace('[#LOAD#]'        , $time->showLoad()       , $PAGE);
    $PAGE = str_replace('[#QUERIES#]'     , $db->count_queries()    , $PAGE);
    $PAGE = str_replace('[#TIME#]'        , $time->endTimer()       , $PAGE);
    $PAGE = str_replace('[#LASTACTIVE#]'  , last_active()           , $PAGE);
  
  if($LAYOUT == 'layout.inc') {
		include(ROOT.'/'.'editor'.'/'.'extras'.'/'.'shoutbox.inc.php');
    $PAGE = str_replace('[#SBOXACTION#]' , $_SERVER['SCRIPT_NAME'].'?'.$_SERVER['QUERY_STRING'] , $PAGE);
		$PAGE = str_replace('[#SBOXMESS#]'   , $sbox                                                   , $PAGE);
		}
		
    // Print the page
    echo $PAGE;

    // Close the MySQL Connection
    $db->disconnect();
}
?>
