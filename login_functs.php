<?php
// Integrated IPB authentication script [functions]
// (c) 2007 Ryan Hoerr

function valid_session($mid, $sess) {
	global $db, $tst, $INFO;
	if(strlen(htmlentities($sess, ENT_QUOTES)) != 32) return 0;
	$mname = $db->fetch_row('SELECT `member_name` FROM '.$INFO['sql_database'].'.`'.$tst.'sessions` WHERE `id` = "'.$sess.'" AND `member_id` = "'.$mid.'"');
	if(isset($mname['member_name'])) return 1;
	else return 0;
}

function valid_passhash($hash, $mlk) {
	if($mlk == $hash) return 1;
	else return 0;
}

function valid_stronghold($hash, $mlk, $mid) {
	if($hash == generate_stronghold($mlk, $mid)) return 1;
	else return 0;
}

function generate_stronghold($mlk, $mid) {
	global $INFO;
	$ipval = explode('.', $_SERVER['REMOTE_ADDR']);
	$shold = md5( md5($mid.'-'.$ipval[0].'-'.$ipval[1].'-'.$mlk ) . md5($INFO['sql_pass'].$INFO['sql_user']) );
	return $shold;
}

function generate_session($mid) {
	global $db, $tst, $cst, $INFO;
	$db->query('DELETE FROM '.$INFO['sql_database'].'.`'.$tst.'sessions` WHERE `member_id` = '.$mid);
	
	$sess = md5(uniqid(microtime()));
	
	$mem = $db->fetch_row('SELECT `members_display_name`, `mgroup`, `login_anonymous`, `member_login_key` FROM '.$INFO['sql_database'].'.`'.$tst.'members` WHERE `id` = '.$mid);
	$anon = intval(substr($mem['login_anonymous'], 0, 1));
	$agent = mysql_escape_string( substr( $_SERVER['HTTP_USER_AGENT'], 0, 200 ) );
	
	$db->query('INSERT INTO '.$INFO['sql_database'].'.`'.$tst.'sessions` (`id`, `member_name`, `member_id`, `member_group`, `login_type`, `running_time`, `ip_address`, `browser`) VALUES ("'.$sess.'", "'.$mem['member_display_name'].'", "'.$mid.'", "'.$mem['mgroup'].'", "'.$anon.'", "'.time().'", "'.$_SERVER['REMOTE_ADDR'].'", "'.$agent.'")');
	$db->query('UPDATE '.$INFO['sql_database'].'.`'.$tst.'members` SET `last_visit` = `last_activity`, `last_activity` = "'.time().'" WHERE `id` = '.$mid);
	
	setcookie($cst.'member_id', $mid, time()+31536000, '/');
	setcookie($cst.'pass_hash', $mem['member_login_key'], time()+31536000, '/');
	setcookie($cst.'session_id', $sess, time()+31536000, '/');
	setcookie($cst.'ipb_stronghold', generate_stronghold($mem['member_login_key'], $mid), time()+31536000, '/');
}

function destroy_session($mid) {
	global $db, $INFO, $tst, $cst;
	$db->query('DELETE FROM '.$INFO['sql_database'].'.`'.$tst.'sessions` WHERE `member_id` = '.$mid);
	
	setcookie($cst.'member_id', false, time()-20, '/');
	setcookie($cst.'pass_hash', false, time()-20, '/');
	setcookie($cst.'session_id', false, time()-20, '/');
}

function clean_data($data) {
	$data	= str_replace( "&#8238;"		, ''			  , $data );
	$data	= str_replace( "&"				, "&amp;"         , $data );
	$data	= str_replace( "<!--"			, "&#60;&#33;--"  , $data );
	$data	= str_replace( "-->"			, "--&#62;"       , $data );
	$data	= preg_replace( "/<script/i"	, "&#60;script"   , $data );
	$data	= str_replace( ">"				, "&gt;"          , $data );
	$data	= str_replace( "<"				, "&lt;"          , $data );
	$data	= str_replace( '"'				, "&quot;"        , $data );
	$data	= str_replace( "\n"				, "<br />"        , $data );
	$data	= str_replace( "$"				, "&#036;"        , $data );
	$data	= str_replace( "\r"				, ""              , $data );
	$data	= str_replace( "!"				, "&#33;"         , $data );
	$data	= str_replace( "'"				, "&#39;"         , $data );
return $data;
}

?>