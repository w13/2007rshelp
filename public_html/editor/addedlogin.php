<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

if( isset($_GET['user']) ) {
 $referrer = $_SERVER['HTTP_REFERER'];
 $find = 'corporate.2007rshelp.com';
 $pos = strpos($referrer, $find);
 //echo '<script type="text/javascript">alert(\'Level 1: User is set.\')</script>';
  
 //if(empty($referrer)) echo 'You have referrers disabled.';
 if( $pos != '7' ){
 //echo '<script type="text/javascript">alert(\'Level 2: User is set, but didnt come from corporate.2007rshelp.com, they came from: ' . $referer . '.\')</script>';
 //die();
  header('Location: http://www.runescapecommunity.com');
 }else{
  setcookie("addedlogin", "Alex Porter", time()+7200); /* set 2 hour cookie */
  //echo 'Logging in, one second'; echo '<script type="text/javascript">alert(\'I SET THE COOKIE\')</script>';
  header('Location: http://www.runescapecommunity.com/editor/index.php');
 }
}
else {
//echo 'USER IS NOT SET';
 header('refresh: 10; url=http://www.runescapecommunity.com');
}
?>