<?php
require( 'backend.php' );
start_page( 1, 'Inventory & Equipment iMap Generator' );
?>
<script type="text/javascript">
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
<!-- Begin
function displayHTML(form) {
var inf = form.textarea1.value;
win = window.open(", ", 'popup', 'toolbar = no, status = no');
win.document.write("" + inf + "");
}
//  End -->

var formChanged = false;

window.onbeforeunload = function() {
    if (formChanged) return "You have unsaved changes.";
}
</script>

<div class="boxtop">Inventory & Equipment iMap Generator</div>
<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">

<table style="margin:0 12%;border-left: 1px solid #000;" width="75%" cellpadding="1" cellspacing="0">
<tr>
<td class="tabletop" colspan="2">Getting Started</td></tr>
<tr>
<td class="tablebottom" style="text-align:left;">Steps:
<ol>
<li><a href="#null" onmousedown="chk(1)" onClick="insert('<img name=&quot;inveq&quot; src=&quot;/img/[#CHANGE_ME#]&quot; width=&quot;412&quot; height=&quot;300&quot; border=&quot;0&quot; id=&quot;inveq&quot; usemap=&quot;#m_inveq&quot; alt=&quot;&quot; />\n<map name=&quot;m_inveq&quot; id=&quot;m_inveq&quot;>\n<area shape=&quot;poly&quot; coords=&quot;297,50,337,50,337,85,297,85,297,50&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;Helm&quot; alt=&quot;Helm&quot; />\n<area shape=&quot;poly&quot; coords=&quot;297,100,337,100,337,135,297,135,297,100&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;Amulet&quot; alt=&quot;Amulet&quot; />\n<area shape=&quot;poly&quot; coords=&quot;247,100,287,100,287,135,247,135,247,100&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;Cape&quot; alt=&quot;Cape&quot; />\n<area shape=&quot;poly&quot; coords=&quot;347,100,387,100,387,135,347,135,347,100&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;Ammo&quot; alt=&quot;Ammo&quot; />\n<area shape=&quot;poly&quot; coords=&quot;247,150,287,150,287,185,247,185,247,150&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;Weapon&quot; alt=&quot;Weapon&quot; />\n<area shape=&quot;poly&quot; coords=&quot;297,150,337,150,337,185,297,185,297,150&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;Chest&quot; alt=&quot;Chest&quot; />\n<area shape=&quot;poly&quot; coords=&quot;347,150,387,150,387,185,347,185,347,150&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;Shield&quot; alt=&quot;Shield&quot; />\n<area shape=&quot;poly&quot; coords=&quot;297,200,337,200,337,235,297,235,297,200&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;Legs&quot; alt=&quot;Legs&quot; />\n<area shape=&quot;poly&quot; coords=&quot;247,250,287,250,287,285,247,285,247,250&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;Gloves&quot; alt=&quot;Gloves&quot; />\n<area shape=&quot;poly&quot; coords=&quot;297,250,337,250,337,285,297,285,297,250&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;Boots&quot; alt=&quot;Boots&quot; />\n<area shape=&quot;poly&quot; coords=&quot;347,250,387,250,387,285,347,285,347,250&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;Ring&quot; alt=&quot;Ring&quot; />\n\n')">Click here for the equipment</a>.</li>
<li>Click on the appropriate rows/row type you want.</li>
<li><a href="#null" onClick="insert('</map>')">Click here to close the map</a>.</li>
<li>Replace all [#R-PHOLDERS#]</li>
</ol></td>
<td class="tablebottom" style="text-align:left;">What to replace:
<ol>
<li>[#CHANGE_ME#] - Item DB id.</li>
<li>[#ID_ME#] - Item DB id.</li>
</ol></td></tr>
</table><br /><br />

<form name="form1" onsubmit="javascript:return false;" action="">
<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">
<tr>
<td class="tabletop">Guide Area</td>
<td class="tabletop">Row Type</td>
</tr>
<tr>
<td class="tablebottom"><textarea name="textarea1" style="font:11px Verdana" cols="100" rows="30" onchange="formChanged = true;"></textarea></td>
<td class="tablebottom"><button onclick="chk(1)" onmousedown="insert('<area shape=&quot;poly&quot; coords=&quot;25,44,65,44,65,79,25,79,25,44&quot; href=&quot;/items.php?id=1&quot; target=&quot;_blank&quot; title=&quot;11&quot; alt=&quot;11&quot; />\n<area shape=&quot;poly&quot; coords=&quot;67,44,107,44,107,79,67,79,67,44&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;12&quot; alt=&quot;12&quot; />\n<area shape=&quot;poly&quot; coords=&quot;109,44,149,44,149,79,109,79,109,44&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;13&quot; alt=&quot;13&quot; />\n<area shape=&quot;poly&quot; coords=&quot;151,44,191,44,191,79,151,79,151,44&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;14&quot; alt=&quot;14&quot; />\n\n<area shape=&quot;poly&quot; coords=&quot;25,80,65,80,65,115,25,115,25,80&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;21&quot; alt=&quot;21&quot; />\n<area shape=&quot;poly&quot; coords=&quot;67,80,107,80,107,115,67,115,67,80&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;22&quot; alt=&quot;22&quot; />\n<area shape=&quot;poly&quot; coords=&quot;109,80,149,80,149,115,109,115,109,80&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;23&quot; alt=&quot;23&quot; />\n<area shape=&quot;poly&quot; coords=&quot;151,80,191,80,191,115,151,115,151,80&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;24&quot; alt=&quot;24&quot; />\n\n<area shape=&quot;poly&quot; coords=&quot;25,116,65,116,65,151,25,151,25,116&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;31&quot; alt=&quot;31&quot; />\n<area shape=&quot;poly&quot; coords=&quot;67,116,107,116,107,151,67,151,67,116&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;32&quot; alt=&quot;32&quot; />\n<area shape=&quot;poly&quot; coords=&quot;109,116,149,116,149,151,109,151,109,116&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;33&quot; alt=&quot;33&quot; />\n<area shape=&quot;poly&quot; coords=&quot;151,116,191,116,191,151,151,151,151,116&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;34&quot; alt=&quot;34&quot; />\n\n<area shape=&quot;poly&quot; coords=&quot;25,152,65,152,65,187,25,187,25,152&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;41&quot; alt=&quot;41&quot; />\n<area shape=&quot;poly&quot; coords=&quot;67,152,107,152,107,187,67,187,67,152&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;42&quot; alt=&quot;42&quot; />\n<area shape=&quot;poly&quot; coords=&quot;109,152,149,152,149,187,109,187,109,152&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;43&quot; alt=&quot;43&quot; />\n<area shape=&quot;poly&quot; coords=&quot;151,152,191,152,191,187,151,187,151,152&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;44&quot; alt=&quot;44&quot; />\n\n<area shape=&quot;poly&quot; coords=&quot;25,188,65,188,65,223,25,223,25,188&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;51&quot; alt=&quot;51&quot; />\n<area shape=&quot;poly&quot; coords=&quot;67,188,107,188,107,223,67,223,67,188&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;52&quot; alt=&quot;52&quot; />\n<area shape=&quot;poly&quot; coords=&quot;109,188,149,188,149,223,109,223,109,188&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;53&quot; alt=&quot;53&quot; />\n<area shape=&quot;poly&quot; coords=&quot;151,188,191,188,191,223,151,223,151,188&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;54&quot; alt=&quot;54&quot; />\n\n<area shape=&quot;poly&quot; coords=&quot;25,224,65,224,65,259,25,259,25,224&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;61&quot; alt=&quot;61&quot; />\n<area shape=&quot;poly&quot; coords=&quot;67,224,107,224,107,259,67,259,67,224&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;62&quot; alt=&quot;62&quot; />\n<area shape=&quot;poly&quot; coords=&quot;109,224,149,224,149,259,109,259,109,224&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;63&quot; alt=&quot;63&quot; />\n<area shape=&quot;poly&quot; coords=&quot;151,224,191,224,191,259,151,259,151,224&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;64&quot; alt=&quot;64&quot; />\n\n<area shape=&quot;poly&quot; coords=&quot;25,260,65,260,65,295,25,295,25,260&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;71&quot; alt=&quot;71&quot; />\n<area shape=&quot;poly&quot; coords=&quot;67,260,107,260,107,295,67,295,67,260&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;72&quot; alt=&quot;72&quot; />\n<area shape=&quot;poly&quot; coords=&quot;109,260,149,260,149,295,109,295,109,260&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;73&quot; alt=&quot;73&quot; />\n<area shape=&quot;poly&quot; coords=&quot;151,260,191,260,191,295,151,295,151,260&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;74&quot; alt=&quot;74&quot; />')">Full Grid (all different items)</button>
<button onclick="chk(1)" onmousedown="insert('<area shape=&quot;poly&quot; coords=&quot;25,44,191,44,191,79,25,79,25,44&quot; href=&quot;/items.php?id=1&quot; target=&quot;_blank&quot; title=&quot;11&quot; alt=&quot;11&quot; />\n<area shape=&quot;poly&quot; coords=&quot;25,80,191,80,191,115,25,115,25,80&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;21&quot; alt=&quot;21&quot; />\n<area shape=&quot;poly&quot; coords=&quot;25,116,191,116,191,151,25,151,25,116&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;31&quot; alt=&quot;31&quot; />\n<area shape=&quot;poly&quot; coords=&quot;25,152,191,152,191,187,25,187,25,152&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;41&quot; alt=&quot;41&quot; />\n<area shape=&quot;poly&quot; coords=&quot;25,188,191,188,191,223,25,223,25,188&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;51&quot; alt=&quot;51&quot; />\n<area shape=&quot;poly&quot; coords=&quot;25,224,191,224,191,259,25,259,25,224&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;61&quot; alt=&quot;61&quot; />\n<area shape=&quot;poly&quot; coords=&quot;25,260,191,260,191,295,25,295,25,260&quot; href=&quot;/items.php?id=[#ID_ME#]&quot; target=&quot;_blank&quot; title=&quot;71&quot; alt=&quot;71&quot; />')">Full Rows (4 items same on each row)</button>
</td>
</tr>
</table>
</form>
<br /></div>
<?php
end_page();
?>
