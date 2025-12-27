<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>[#SITE_NAME#]</title>
<link href="[#CSS#]" rel="stylesheet" type="text/css" />
<link href="[#CSS#]darkblue.css" rel="stylesheet" type="text/css" id="ourstylesheet" />
<script type="text/javascript">precss = '[#CSS#]';</script>
<script src="/editor/scripts.js" type="text/javascript"></script>
<style type="text/css">.sb { width: 120px; vertical-align:top; } </style>
</head>
<body>
<div id="wrapper">
<div class="topbar" style="border-top-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;"><img src="images/pixel.gif" width="1" height="1" alt="" /></div>
<div class="bottombar" style="border-top-style: none; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;"><img src="images/pixel.gif" width="1" height="1" alt="" /></div>
<div id="mtop"><center><a href="/editor" title="OSRS RuneScape Help Editor - Index"><img src="/editor/images/header.gif" border="0" alt="OSRS RuneScape Help Editor" /></a></center></div>
<div class="bottombar" style="border-top-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;"><img src="images/pixel.gif" width="1" height="1" alt="" /></div>
<div class="topbar" style="border-top-style: none; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;"><img src="images/pixel.gif" width="1" height="1" alt="" /></div>
<div id="body">
<div id="nav">
[#LINKS#]
<div class="boxbottom" style="border-top: 1px solid #000000;">
<p>User: [#USER#]<br />Date: [#CDATE#]<br />Time: [#CTIME#] GMT</p>
</div>
</div>
<div id="content">
[#CONTENT#]
</div>
<div style="clear: both"></div>

<a name="sbox"></a>
<div class="boxtop">Message Box (Note: The whole page will be reloaded when you post a message) <a href="javascript: void(0)" onclick="javascript:window.open( '/editor/history.php', 'history', 'width=700,height=1000,scrollbars=yes,location=yes' )">View History</a></div>
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
[ Exec. Time: <span style="color: orange">[#TIME#]</span> ]
<br />
</div>
</div>
</body>
</html>