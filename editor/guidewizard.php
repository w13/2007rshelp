<?php
require( 'backend.php' );
start_page( 2, 'Guide Wizard' );
?>
<head><script type="text/javascript">
<!--
v=0
function chk(n){
v=n
}

function insert(str){
if(v==0){
return
}
if(v==1){
document.forms["form1"]["code"].value+=str
}

}
//-->
</script>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function displayHTML(form) {
var inf = form.code.value;
win = window.open(", ", 'popup', 'toolbar = no, status = no');
win.document.write("" + inf + "");
}
//End -->
</script>
<script type="text/javascript">
var formChanged = false;

window.onbeforeunload = function() {
    if (formChanged) return "You have unsaved changes.";
}
</script>
</head>
<?php
if(isset($_GET['quest'])) {
?>
<center><form name="form1" action="bbcode.php?act=preview" method="post" target="new"><table style="border-left: 1px solid #000;" width="100%" cellpadding="1" cellspacing="0">
<tr>
<td colspan="2" class="tabletop" align="center">Quest Guides Formatting</td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('<table width=&quot;100%&quot;>\n<tr class=&quot;top&quot;>\n<td width=&quot;30%&quot;><strong>Reward</strong><br />\n<p>- # Quest Points<br />\n- GP, XP, Items<br />\n- Ability to <br />\n- Access to </p></td>\n<td><img src=&quot;/img/qimg/questfolder/loc.png&quot; alt=&quot;Start Point&quot; style=&quot;padding:5px; float:right&quot; /><strong>Start Point</strong><p>When, where.</p><p><strong>Members Only or Available to Free Players</strong></p></td>\n<td style=&quot;vertical-align:middle; font-weight:bold;&quot;>Difficulty:<br /><img src=&quot;/img/qimg/#.gif&quot; alt=&quot;Difficulty Rating: #/5&quot; style=&quot;padding:5px 0;&quot; /><br />Length:<br /><img src=&quot;/img/qimg/#.gif&quot; alt=&quot;Length Rating: #/5&quot; style=&quot;padding:5px 0;&quot; /></td>\n</tr>\n</table>\n\n<hr />\n<h3>Requirements</h3>\n<p><strong>Skill: </strong><br />\n<strong>Quest: </strong><br />\n<strong>Item: </strong><br />\n<strong>Other: </strong> Ability to or Access to</p>\n<h3>Recommendations</h3>\n<p><strong>Skill: </strong><br />\n<strong>Item: </strong></p>\n\n<hr /><br />\n<div id=&quot;quote&quot;>Quote</div><br /><hr />\n'); return false;">Top Content</a></td>
<td rowspan="15" align="center" class="tablebottom"><textarea name="code" cols="100%" rows="35" onchange="formChanged = true;" onClick="chk(1)" style="margin: auto; font: 11px Verdana, Arial, Helvetica, sans, sans serif;"/></textarea></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n<h3 class=&quot;part&quot;>Part #:<br />Part title</h3><div style=&quot;clear:both;&quot;></div>\n'); return false;">New Part</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n<div class=&quot;step&quot;>\n<h3 class=&quot;step-title&quot;>Step #<br />\n<span>Point<br />Point<br />Point</span></h3>\n<p class=&quot;step-content&quot;>\nContent\n</p>\n<div style=&quot;clear:both;&quot;></div></div>\n'); return false;">New Step</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n\n<div class=&quot;step&quot;>\n<h3 class=&quot;step-title&quot;>Step 1<br />\n<span>Point<br />Point<br />Point</span></h3>\n<p class=&quot;step-content&quot;>\nContent\n<br /><br /><em>Items needed: text</em>\n</p>\n<div style=&quot;clear:both;&quot;></div></div>\n\n'); return false;">New step (items needed)</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n<em>Items needed: text</em>\n<br /><br />'); return false;">Items needed</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n<br /><br /><em>Note: text</em>\n<br /><br />'); return false;">Insert a note</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('(<a href=&quot;/img/qimg/folder/file.ext&quot; title=&quot;Zybez RuneScape Help\'s Screenshot of ____________ &quot;>Picture</a>)'); return false;">Picture link</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('<span style=&quot;color:#FFFFF;&quot;>NPC</span>'); return false;">NPC</a><a onClick="insert('(<a href=&quot;/img/qimg/folder/file.ext&quot; title=&quot;Zybez RuneScape Help\'s Screenshot of ____________ &quot;>Picture</a>)'); return false;"></a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n<img src=&quot;/img/qimg/folder/scroll.gif&quot; alt=&quot;Zybez RuneScape Help\'s Quest Scroll&quot; style=&quot;display:block; margin:0 auto; padding:1em; border-bottom:1px dashed #808080;&quot; /><br />'); return false;">Scroll Image</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n<div class=&quot;title1&quot;>Frequently Asked Questions</div>\n<div class=&quot;title3&quot;>Q: </div>\n<p>A: </p>'); return false;">Frequently Asked Questions</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n<div class=&quot;title3&quot;>Q: </div>\n<p>A: </p>'); return false;">New FAQ</a></td>
</tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n<img src=&quot;/img/qimg/folder/file.ext&quot; alt=&quot;&quot; style=&quot;float:right; padding:1em; width: 125px; height:125px;&quot; />'); return false;">New Image (right)</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n<img src=&quot;/img/qimg/folder/file.ext&quot; alt=&quot;&quot; style=&quot;display:block; margin:0 auto; padding:1em;&quot; />'); return false;">New Image (middle)</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n\n&lt;div class=&quot;title1&quot;&gt;Quest Map&lt;/div&gt;&lt;div class=&quot;related&quot;&gt;&lt;div class=&quot;title3&quot;&gt;&lt;img src=&quot;/img/idbimg/IMAGE.png&quot; alt=&quot;Zybez RuneScape Help\'s ITEM Image&quot; class=&quot;fright&quot; /&gt;NAME Quest sequence:&lt;/div&gt;&lt;br /&gt;&lt;div class=&quot;title3&quot;&gt;Related Quests:&lt;/div&gt;&lt;br /&gt;&lt;div class=&quot;title3&quot;&gt;Helpful Guides:&lt;/div&gt;&lt;/div&gt;\n'); return false;">Quest Map</a></td></tr>
<tr><td class="tablebottom" align="center" colspan="2"><input type="submit" value="Preview Guide" /></td></tr>
</table>
</form></center><br />


<?php
}
elseif (isset($_GET['news'])) {
?>
<center><form name="form1" action="bbcode.php?act=news" method="post" target="new"><table style="border-left: 1px solid #000;" width="100%" cellpadding="1" cellspacing="0">
<tr>
<td class="tabletop" align="center">News Formatting</td></tr>
<tr>
<td class="tablebottom" align="center"><input type="text" name="title" value="" size="50" maxlength="40" /></td></tr>
<tr>
<td class="tablebottom" ><textarea name="content" rows="25" onchange="formChanged = true;" onClick="chk(1)" style="width:98%; font: 11px Verdana, Arial, Helvetica, sans, sans serif;"/></textarea></td></tr>
<tr><td class="tablebottom" align="center"><input type="submit" value="Preview News Post" /></td></tr>
</table>
<?php
}
else {
?>
<center><form name="form1" action="bbcode.php?act=preview" method="post" target="new"><table style="border-left: 1px solid #000;" width="100%" cellpadding="1" cellspacing="0">
<tr>
<td colspan="2" class="tabletop" align="center">General Guide Wizard</td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('<img src=&quot;&quot; alt=&quot;Zybez RuneScape Help\'s _______ Image&quot; class=&quot;toc_img&quot; />\n<div class=&quot;title1&quot;>Table of Contents</div>\n<ul class=&quot;toc&quot;>\n<li><a href=&quot;#S1.0&quot;>1.0 - Title</a>\n<ul>\n<li><a href=&quot;#S1.1&quot;>1.1 - Subtitle</a></li>\n<li><a href=&quot;#S1.2&quot;>1.2 - Subtitle</a></li></ul></li>\n<li><a href=&quot;#S2.0&quot;>2.0 - Title</a>\n<ul>\n<li><a href=&quot;#S2.1&quot;>2.1 - Subtitle</a></li>\n<li><a href=&quot;#S2.2&quot;>2.2 - Subtitle</a></li></ul></li>\n</ul>'); return false;">Table of Contents</a></td>
<td rowspan="13" align="center" class="tablebottom"><textarea name="code" cols="100%" rows="35" onchange="formChanged = true;" onClick="chk(1)" style="margin: auto; font: 11px Verdana, Arial, Helvetica, sans, sans serif;"/></textarea></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n<p class=&quot;info&quot;>text here</p>'); return false;">Important Info</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n<p class=&quot;notice&quot;>text here</p>'); return false;">Important Notice</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n<div class=&quot;title1&quot;>1.0 - Title</div>'); return false;">Main Title</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n<div class=&quot;title2&quot;>1.1 - Subtitle</div>'); return false;">Subtitle</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n<div class=&quot;title3&quot;>Small title</div>'); return false;">Small Title</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n<a name=&quot;S1.0&quot;></a>'); return false;">Section Link Anchor</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('<span style=&quot;color:#FFFFF;&quot;>NPC</span>'); return false;">NPC</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('(<a href=&quot;/&quot; title=&quot;Zybez RuneScape Help\'s Screenshot of ____________ &quot;>Picture</a>)'); return false;">Image Link</a></td></tr>
<tr>
<td class="tablebottom" align="center">Images: <a onClick="insert('\n<img src=&quot;&quot; alt=&quot;Zybez RuneScape Help\'s _________ Image&quot; class=&quot;fleft&quot; />'); return false;">Left</a> | <a onClick="insert('\n<img src=&quot;&quot; alt=&quot;Zybez RuneScape Help\'s _________ Image&quot; class=&quot;fmid&quot; />'); return false;">Center</a> | <a onClick="insert('\n<img src=&quot;&quot; alt=&quot;Zybez RuneScape Help\'s _________ Image&quot; class=&quot;fright&quot; />'); return false;">Right</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n<div class=&quot;title1&quot;>?.0 - FAQ</div>\n<div class=&quot;faq&quot;>\n<span>Q: Question?</span>\n<p>A: Answer.</p>\n</div>'); return false;">Frequently Asked Questions</a></td></tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n<div class=&quot;faq&quot;>\n<span>Q: Question?</span>\n<p>A: Answer.</p>\n</div>'); return false;">New FAQ</a></td>
</tr>
<tr>
<td class="tablebottom" align="center"><a onClick="insert('\n<table cellspacing=&quot;0&quot; style=&quot;margin:0 10%;border-left: 1px solid #000000; width:80%;&quot;>\n<tr>\n<td class=&quot;tabletop&quot;>title</td>\n<td class=&quot;tabletop&quot;>title</td>\n<td class=&quot;tabletop&quot;>title</td>\n<td class=&quot;tabletop&quot;>title</td>\n</tr>\n<tr>\n<td class=&quot;tablebottom&quot;>text</td>\n<td class=&quot;tablebottom&quot;>text</td>\n<td class=&quot;tablebottom&quot;>text</td>\n<td class=&quot;tablebottom&quot;>text</td>\n</tr>\n<tr>\n<td class=&quot;tablebottom&quot;>text</td>\n<td class=&quot;tablebottom&quot;>text</td>\n<td class=&quot;tablebottom&quot;>text</td>\n<td class=&quot;tablebottom&quot;>text</td>\n</tr>\n</table>'); return false;">Table</a></td></tr>
<tr><td class="tablebottom" align="center" colspan="2"><input type="submit" value="Preview Guide" /></td></tr>
</table>
</form></center><br />
<?php
}
end_page();
?>