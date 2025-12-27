<?php
// Integrated IPB authentication script
// (c) 2007 Ryan Hoerr

require('community/conf_global.php');
require('login_functs.php');

$cst = ''; // Cookie prefix
$tst = $INFO['sql_tbl_prefix'];
$sdb = $INFO['sql_database'];
$local = '.2007rshelp.com';
$lcode = 0;

$loginform = <<<BLK
<form action="?a={$_GET['a']}" method="POST" title="Log in with your Runescape Community account details">
<table><tr><th colspan="2"><div style="font-weight: normal; float: right;">[<a href="http://2007rshelp.com/community/index.php?act=Login" title="Go to the Runescape Community login screen">RSC</a> Account Details]</div>Log In</th></tr>
<tr><td>Username:</td><td><input type="text" name="UserName" maxlength="32" /></td></tr>
<tr><td>Password:</td><td><input type="password" name="PassWord" maxlength="32" /></td></tr>
<tr><td colspan="2" style="text-align: center;"><input type="submit" value="Log in" /></td></tr></table>
</form>
BLK;


$mid = $_COOKIE[$cst.'member_id'] ? intval($_COOKIE[$cst.'member_id']) : 0;
if($mid < 1) {
	$loginstr = $loginform;
	return;
}
$mli = $db->fetch_row('SELECT `member_login_key`, `name` FROM '.$sdb.'.`'.$tst.'members` WHERE `id` = "'.$mid.'"');
if(strlen($mli['name']) < 1) {
	$loginstr = $loginform;
	return;
}
$mlk = $mli['member_login_key'];
$session		= valid_session($mid, $_COOKIE[$cst.'session_id']);
$passhash		= valid_passhash($_COOKIE[$cst.'pass_hash'], $mlk);
$stronghold		= valid_stronghold($_COOKIE[$cst.'ipb_stronghold'], $mlk, $mid);

if($session != 1 || $passhash != 1 || $stronghold != 1) { // No valid session
	if(strlen($_POST['UserName']) > 0 && strlen($_POST['PassWord']) > 2) { // Authenticate
		$user	= str_replace( '|', '&#124;', substr($_POST['UserName'], 0, 32));
		$user	= clean_data($user);
		$mid	= $db->fetch_row('SELECT `id` FROM '.$sdb.'.`'.$tst.'members` WHERE `name` = "'.$db->escape_string($user).'"');
		$mid	= $mid['id'];
		if(!isset($mid)) {
			$loginstr = $loginform.'<div style="padding: 4px; text-align: center; color: #c22; font-weight: bold;">Invalid username/password</div>';
			return;
		}
		$converge = $db->fetch_row('SELECT `converge_pass_hash`, `converge_pass_salt` FROM '.$sdb.'.`'.$tst.'members_converge` WHERE `converge_id` = "'.$mid.'"');
		$md5p	= md5( md5($converge['converge_pass_salt']) . md5( $pass ) );
		
		if($md5p == $converge['converge_pass_hash']) { // Valid login
			generate_session($mid);
			$loginstr = 'Logged in! [<a href="?d=logout">Log out</a>]';
			$lcode = 1;
		}
		else { // Invalid login
			$loginstr = $loginform.'<div style="padding: 4px; text-align: center; color: #c22; font-weight: bold;">Invalid username/password</div>';
			$lcode = 0;
		}
	}
	else { // Log in form
		$loginstr = $loginform;
		$lcode = 0;
	}
}
else { // Valid session
	if($_GET['d'] == 'logout') { // Destroy session
		destroy_session($mid);
		$loginstr = $loginform.'<div style="padding: 4px; text-align: center; font-weight: bold;">Logged out.</div>';
		$lcode = 0;
		return;
	}

	$loginstr = 'Logged in! [<a href="?d=logout">Log out</a>]';
	$lcode = 1;
}

?>
