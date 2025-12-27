<?
require('backend.php');
start_page(1, 'IRC');
?>
<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px; padding-bottom:10px;">
<div style="margin:1pt; font-size:large; font-weight:bold;">
&raquo; <u>OSRS RuneScape Help Staff IRC</u></div>
<hr class="main" noshade="noshade" />

<script type="text/javascript">
<!--
function EnterIRC() {
	var Pass = document.getElementById('pass');
	var Nick = document.getElementById('nick');
	var Appl = document.getElementById('Applet');
	
	Pass = Pass.value != '' ? '<param name="command1" value="/nickserv identify '+Pass.value+'">' : '';
	Nick = Nick.value != '' ? Nick.value : 'OSRS RuneScape Help_Guest????';
	
	Appl.innerHTML = '<applet codeBase="/tiko/toolkit/extras/irc0/" code="IRCApplet.class" archive="irc.jar,sbox.jar" style="width: 100%; height: 370px;"> <param name="CABINETS" value="irc.cab,securedirc.cab,sbox.cab"> <param name="name" value="OSRS RuneScape Help.Net"> <param name="nick" value="'+Nick+'"> <param name="alternatenick" value="OSRS RuneScape Help_Guest????"> <param name="fullname" value="OSRS RuneScape Help Content Team Member"> <param name="host" value="irc.swiftirc.net"> <param name="gui" value="sbox"> <param name="port" value="6667"> '+Pass+' <param name="command2" value="/join #osrs_helpteam mash4077"> <param name="quitmessage" value="http://2007rshelp.com/"> <param name="sbox:language" value="sbox-english"> <param name="sbox:highlight" value="true"> <param name="sbox:highlightnick" value="true"> <param name="sbox:taskbarwest" value="false"> <param name="sbox:showmenubar" value="false"> <param name="sbox:timestamp" value="true"> <param name="sbox:styleselector" value="true"> <param name="sbox:color5" value="363636"> <param name="sbox:color6" value="4F4F4F"> <param name="sbox:color7" value="161616"> <param name="sbox:color8" value="990000"> <param name="sbox:color11" value="990000"> <param name="sbox:color12" value="880000"> <param name="sbox:color13" value="363636"> <param name="sbox:color14" value="363636"> <param name="sbox:color15" value="363636"> <param name="style:bitmapsmileys" value="false"> <param name="style:floatingasl" value="true"><//applet>';
	Appl.style.border = '1px solid #000;';
}
//-->
</script>
<p class="info">If you don't currently have a registered IRC nick that's close to your OSRS RuneScape Help name, take the following steps to get one.
<br /><br />Click the button without entering a username or password.<br />
Type "/nick [DesiredNick]", then "/ns register [DesiredPassword] [ValidEmail]".<br />
Check your email and paste the specified line into IRC.<br />
You're now registered and can log in here any time.</p>
<br /><br />
<div id="Applet">
	<fieldset style="border: 2px solid #6c6f70; width: 50%; margin: 0 auto;"><legend align="left"><strong>IRC Login</strong></legend>
	<form action="javascript:EnterIRC();"><table style="border: 0; margin: auto;">

	<tr><td>Username:</td><td><input type="text" id="nick" size="22" /></td></tr>
	<tr><td>Password:</td><td><input type="password" id="pass" size="22" /></td></tr>
	<tr><td colspan="2" align="center"><input type="submit" value="Enter OSRS RuneScape Help IRC" /></td></tr></table></form>
	
</div>
</div>
<?
end_page();
?>
