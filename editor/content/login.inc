<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Login - Zybez Editor</title>
<link href="[#CSS#].css" rel="stylesheet" type="text/css" id="ourstylesheet" />
<link href="/css/global_new.css" rel="stylesheet" type="text/css" />
<link href="/css/editor.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
<div class="topbar"></div>
<div id="ebanner" style="border-bottom:1px solid #000;"><a href="#" title="Zybez Editor - Index"><span>Welcome</span></a></div>
<div class="bottombar"></div>
<div id="body">

<div class="boxtop">Please Login</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<p align="center">[#ERROR#] Please login using the form below.</p>
<?
$id = array('1182');
$hash = array('1499de747228d2755582c7d48b0c7f3c');
$autocomplete = ' autocomplete="off"';
if(($_COOKIE['member_id'] == $id[0] && $_COOKIE['pass_hash'] == $hash[0]) || ($_COOKIE['ridiculous'] == '34f4g34f3cghyjh6')) { $autocomplete = ''; }
?>
<form action="[#ACTION#]" method="post">
<table align="center" width="200" cellspacing="1" cellpadding="0">
<tr><td align="center">Username:</td><td align="center"><input type="text" name="user" maxlength="15"<?=$autocomplete?> /></td></tr>
<tr><td align="center">Password:</td><td align="center"><input type="password" name="pass" maxlength="15"<?=$autocomplete?> /></td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="Login" /></td></tr>
</table>
</form>
<p align="center">If you have forgotten your password or think your account may have been locked for inactivity, contact the head of content.</p>

[#POSTTXT#]

</div>

</div>
<div style="clear: both"></div>
</div>
</body>
</html>