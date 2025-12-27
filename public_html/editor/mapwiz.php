<?php
require( 'backend.php' );
start_page( 1, 'Map Guide Generator' );
?><head><script type="text/javascript">
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
document.forms["form1"]["textarea1"].value+=str
}

}
//-->
</script>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function displayHTML(form) {
var inf = form.textarea1.value;
win = window.open(", ", 'popup', 'toolbar = no, status = no');
win.document.write("" + inf + "");
}
//  End -->
</script>
<script language="JavaScript">
function hide(i)
{
   var el = document.getElementById(i)
   if (el.style.display=="none")
   {
      el.style.display="block";
   }
   else
   {
      el.style.display="none";
   }
}
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
</script></head>

<div class="boxtop">Map Guide Generator</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">

<center><table style="border-left: 1px solid #000000;" width="75%" cellpadding="1" cellspacing="0">
<tr>
<td class="tabletop" colspan="2">Getting Started</td></tr>
<tr>
<td class="tablebottom">Steps:
<ol>
<li>Click in the textbox.</li>
<li><a href="#null" onClick="insert('<p>[Description]</p><table align=&quot;center&quot; cellpadding=&quot;10&quot;><tr><td><img src=&quot;[/img/directory/file.png]&quot; alt=&quot;OSRS RuneScape Help\'s [NAME] Dungeon Map&quot; /></td><td>')">Click here</a>.</li>
<li>Click on the dots or ores you want to use.</li>
<li><a href="#null" onClick="insert('</td></tr></table>')">Click here</a>.</li>
<li>Replace all the [Brackets] (see right).</li>
</ol></td>
<td class="tablebottom">What to replace:
<ol>
<li>[Description] - This is the written part of the map's guide.</li>
<li>[Address] - This the the URL of the map image.</li>
<li>[Name] - This is the object/monster that the dot accords to.</li></ol></td></tr>
<tr>
<td colspan="2" class="tablebottom"><b>The order of npc's is ALPHABETICAL.<br />
If there are 2 npc's with the same name but different levels, the lower level goes first.</b></td>
</tr>
<tr>
<td colspan="2" class="tablebottom" style="text-align:left;"><a href="#" onclick=hide('tohide')>Show/Hide: Dotting/Watermarking Instructions</a><br />
<div id="tohide" style="display:none">Download <a href="/img/other/keys.psd" title="Mine/Dungeon map keys">this PSD file for the dots</a>.
You will need to cut them out of their layer - make sure they retain their 60% opacity.<br />
Download <a href="/img/other/fonts.rar">this .RAR folder</a> containing Argonaut and Celtic Garamond the second font.<br />
Watermark OSRS RuneScape Help ("Strong" Anti Alias) across the map at 3-8% opacity, depending on the background colour.<br />
Other text on map: Bold Verdana 10px for enter/exit et al, 12px for anything that's <i>important</i> (with 1px black border, if over landmass on map).<br />
{Mapped By: name} Argonaut "Strong" Anti-Alias.<br />
Put the northpoint, facing the CORRECT direction (sometimes the map was not mapped with north pointing up.</div>
</td>
</tr>
</table></center><br /><br />

<center><form name="form1" action=""><table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">
<tr>
<td class="tabletop">Guide Area</td>
<td class="tabletop">Dungeon Map Keys</td><tr>
<td class="tablebottom"><textarea name="textarea1" cols="80" rows="20" onchange="formChanged = true;" onClick="chk(1)"></textarea></td>
<td class="tablebottom">
<a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dblack.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dblack.gif" border="0" alt="Monster key"></a> &raquo; <a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dblue.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dblue.gif" border="0" alt="Monster key"></a><br />
<a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dbrown.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dbrown.gif" border="0" alt="Monster key"></a> &raquo; <a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/ddblue.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/ddblue.gif" border="0" alt="Monster key"></a><br />
<a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/ddgrey.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/ddgrey.gif" border="0" alt="Monster key"></a> &raquo; <a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/ddoran.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/ddoran.gif" border="0" alt="Monster key"></a><br />
<a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dgreen.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dgreen.gif" border="0" alt="Monster key"></a> &raquo; <a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dgreen1.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dgreen1.gif" border="0" alt="Monster key"></a><br />
<a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dgreenchest.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dgreenchest.gif" border="0" alt="Monster key"></a> &raquo; <a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dgrey.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dgrey.gif" border="0" alt="Monster key"></a><br />
<a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dlgreen.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dlgreen.gif" border="0" alt="Monster key"></a> &raquo; <a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dloran.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dloran.gif" border="0" alt="Monster key"></a><br />
<a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dlpink.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dlpink.gif" border="0" alt="Monster key"></a> &raquo; <a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dlpurp.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dlpurp.gif" border="0" alt="Monster key"></a><br />
<a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dmag.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dmag.gif" border="0" alt="Monster key"></a> &raquo; <a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dmaroon.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dmaroon.gif" border="0" alt="Monster key"></a><br />
<a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/doran.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/doran.gif" border="0" alt="Monster key"></a> &raquo; <a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dorblight.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dorblight.gif" border="0" alt="Monster key"></a><br />
<a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dpaladin.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dpaladin.gif" border="0" alt="Monster key"></a> &raquo; <a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dred.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dred.gif" border="0" alt="Monster key"></a><br />
<a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dteal.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dteal.gif" border="0" alt="Monster key"></a> &raquo; <a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dteal1.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dteal1.gif" border="0" alt="Monster key"></a><br />
<a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dvlblue.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dvlblue.gif" border="0" alt="Monster key"></a> &raquo; <a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dwhite.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dwhite.gif" border="0" alt="Monster key"></a><br />
<a href="#null" onClick="insert('<img src=&quot;/img/dungimg/dot/dyell.gif&quot; alt=&quot;OSRS RuneScape Help\'s [NPCNAME] Key&quot; />&nbsp;NPC (Level ##)<br />')"><img src="/img/dungimg/dot/dyell.gif" border="0" alt="Monster key"></a><br />
</td></tr>
<tr>
<td class="tablebottom" colspan="2">
<a href="#null" onClick="insert('<img src=&quot;/img/minmapimg/key/adamant.gif&quot; alt=&quot;OSRS RuneScape Help\'s Adamant Ore key&quot; /><br />')"><img src="/img/minmapimg/key/adamant.gif" border="0" alt="Mine key"></a>
<a href="#null" onClick="insert('<img src=&quot;/img/minmapimg/key/blurite.gif&quot; alt=&quot;OSRS RuneScape Help\'s Blurite Ore key&quot; /><br />')"><img src="/img/minmapimg/key/blurite.gif" border="0" alt="Mine key"></a>
<a href="#null" onClick="insert('<img src=&quot;/img/minmapimg/key/clay.gif&quot; alt=&quot;OSRS RuneScape Help\'s Clay Ore key&quot; /><br />')"><img src="/img/minmapimg/key/clay.gif" border="0" alt="Mine key"></a>
<a href="#null" onClick="insert('<img src=&quot;/img/minmapimg/key/coal.gif&quot; alt=&quot;OSRS RuneScape Help\'s Coal Ore key&quot; /><br />')"><img src="/img/minmapimg/key/coal.gif" border="0" alt="Mine key"></a>
<a href="#null" onClick="insert('<img src=&quot;/img/minmapimg/key/copper.gif&quot; alt=&quot;OSRS RuneScape Help\'s Copper Ore key&quot; /><br />')"><img src="/img/minmapimg/key/copper.gif" border="0" alt="Mine key"></a><br />
<a href="#null" onClick="insert('<img src=&quot;/img/minmapimg/key/elemental.gif&quot; alt=&quot;OSRS RuneScape Help\'s Elemental Ore key&quot; /><br />')"><img src="/img/minmapimg/key/elemental.gif" border="0" alt="Mine key"></a>
<a href="#null" onClick="insert('<img src=&quot;/img/minmapimg/key/gem.gif&quot; alt=&quot;OSRS RuneScape Help\'s Gem Rocks key&quot; /><br />')"><img src="/img/minmapimg/key/gem.gif" border="0" alt="Mine key"></a>
<a href="#null" onClick="insert('<img src=&quot;/img/minmapimg/key/gold.gif&quot; alt=&quot;OSRS RuneScape Help\'s Gold Ore key&quot; /><br />')"><img src="/img/minmapimg/key/gold.gif" border="0" alt="Mine key"></a>
<a href="#null" onClick="insert('<img src=&quot;/img/minmapimg/key/iron.gif&quot; alt=&quot;OSRS RuneScape Help\'s Iron Ore key&quot; /><br />')"><img src="/img/minmapimg/key/iron.gif" border="0" alt="Mine key"></a>
<a href="#null" onClick="insert('<img src=&quot;/img/minmapimg/key/lunar.gif&quot; alt=&quot;OSRS RuneScape Help\'s Lunar Ore key&quot; /><br />')"><img src="/img/minmapimg/key/lunar.gif" border="0" alt="Mine key"></a>
<a href="#null" onClick="insert('<img src=&quot;/img/minmapimg/key/limestone.gif&quot; alt=&quot;OSRS RuneScape Help\'s Limestone Ore key&quot; /><br />')"><img src="/img/minmapimg/key/limestone.gif" border="0" alt="Mine key"></a><br />
<a href="#null" onClick="insert('<img src=&quot;/img/minmapimg/key/mithril.gif&quot; alt=&quot;OSRS RuneScape Help\'s Mithril Ore key&quot; /><br />')"><img src="/img/minmapimg/key/mithril.gif" border="0" alt="Mine key"></a>
<a href="#null" onClick="insert('<img src=&quot;/img/minmapimg/key/runite.gif&quot; alt=&quot;OSRS RuneScape Help\'s Runite Ore key&quot; /><br />')"><img src="/img/minmapimg/key/runite.gif" border="0" alt="Mine key"></a>
<a href="#null" onClick="insert('<img src=&quot;/img/minmapimg/key/silver.gif&quot; alt=&quot;OSRS RuneScape Help\'s Silver Ore key&quot; /><br />')"><img src="/img/minmapimg/key/silver.gif" border="0" alt="Mine key"></a>
<a href="#null" onClick="insert('<img src=&quot;/img/minmapimg/key/tin.gif&quot; alt=&quot;OSRS RuneScape Help\'s Tin Ore key&quot; /><br />')"><img src="/img/minmapimg/key/tin.gif" border="0" alt="Mine key"></a>
<a href="#null" onClick="insert('<img src=&quot;/img/minmapimg/key/granite.gif&quot; alt=&quot;OSRS RuneScape Help\'s Granite Ore key&quot; /><br />')"><img src="/img/minmapimg/key/granite.gif" border="0" alt="Mine key"></a>
<a href="#null" onClick="insert('<img src=&quot;/img/minmapimg/key/sandstone.gif&quot; alt=&quot;OSRS RuneScape Help\'s Sandstone Ore key&quot; /><br />')"><img src="/img/minmapimg/key/sandstone.gif" border="0" alt="Mine key"></a>
<a href="#null" onClick="insert('<img src=&quot;/img/minmapimg/key/daeyalt.gif&quot; alt=&quot;OSRS RuneScape Help\'s Daeyalt Ore key&quot; /><br />')"><img src="/img/minmapimg/key/daeyalt.gif" border="0" alt="Mine key"></a></td></tr>
</table></form></center>
<br /></div>
<?php
end_page();
?>
