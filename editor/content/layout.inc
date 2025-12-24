<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>[#SITE_NAME#]</title>
<link href="[#CSS#].css" rel="stylesheet" type="text/css" id="ourstylesheet" />
<link href="/css/global_new.css" rel="stylesheet" type="text/css" />
<link href="/css/editor.css" rel="stylesheet" type="text/css" />
<script src="/editor/scripts.js" type="text/javascript"></script>
<style type="text/css">body {font:10px Verdana !important;}</style>
<script type="text/javascript" src="/editor/extras/resize.js"></script>
<script>window.onload = function() { textareaResizer.addToAll(); };</script>
</head>
<body>
<div id="wrapper">
<div class="topbar">[#TOPBAR#]</div>
<div id="ebanner" style="border-bottom:none;"><a href="/editor" title="RsH Editor - Index"><span>RuneScape Help Editor</span></a></div>
<div class="bottombar">[#BOTTOMBAR#]</div>
<div id="body">
<div id="sidebar">
[#LINKS#]
</div>

<div id="content">
[#CONTENT#]
</div></div>
<div style="clear: both"></div>

<a name="sbox"></a>
<div class="boxtop">Message Box (Note: The whole page will be reloaded when you post a message) <a href="javascript: void(0)" onclick="javascript:window.open( '/editor/history.php', 'history', 'width=620,height=700,scrollbars=yes,location=yes' )">View History</a></div>
<div class="boxbottom">
<form action="[#SBOXACTION#]" method="post">
<table cellpadding="0" cellspacing="0" style="width:95%;">
[#SBOXMESS#]
<tr><td colspan="3"><hr />
<table cellpadding="0" cellspacing="0" style="width: 95%;"><tr>
<td style="width: 70px;"><input type="submit" value="Submit" /></td>
<td><input type="text" name="shout" style="width: 100%;" value="" autocomplete="off" maxlength="245" /></td>
</tr>
</table>
</td></tr></table>
</form>
</div>

</div>
<div id="footer">
[ Queries: <span style="color: orange">[#QUERIES#]</span> ] -
[ Exec. Time: <span style="color: orange">[#TIME#]</span> ] -
[Current Time: <span style="color: orange">[#CTIME#] GMT</span> ]
<br />
</div>
</div>
</body>
</html>