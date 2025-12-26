<?php
require( 'backend.php' );
require( 'edit_class.php' );
start_page( 6, 'Item Database' );
$edit = new edit( 'items', $db );

echo '<div class="boxtop">Item Database</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">';

?>

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

<script language="JavaScript" type="text/javascript">
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
    if (formChanged) return "Do you really want to duplicate this entry?";
}
</script>

<div style="float: right;">
<?php
if(isset($_GET['act']) && isset($_GET['copy']) || $_GET['act'] == 'edit') {
$id = intval($_GET['id']);
echo '<a href="?copy&amp;id='.$id.'"><img src="images/copy.gif" onclick="formChanged = true;" hspace="5" title="Copy" border="0" /></a>';
}
?>
<a href="items.php"><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="?act=new"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; Item Database</font></b>
</div>
<hr class="main" noshade="noshade" align="left" />

<?php

if(isset($_GET['copy']) || $_POST['copy']) {
$id = intval($_GET['id']);
$db->query("INSERT INTO items (name, image, type, member, trade, equip, weight, speed, stack, examine, quest, obtain, highalch, lowalch, sellgen, buygen, keepdrop, retrieve, questuse, att, def, otherb, notes, credits, pricelink, keyword, time,) (SELECT name, image, type, member, trade, equip, weight, speed, stack, examine, quest, obtain, highalch, lowalch, sellgen, buygen, keepdrop, retrieve, questuse, att, def, otherb, notes, credits, pricelink, keyword, (UNIX_TIMESTAMP()+21600) FROM items WHERE id = ". $id.")");
$names = reset($db->fetch_row('SELECT name FROM items WHERE id = '.$id));
$ses->record_act( 'Item Database', 'Duplicate', $names, $ip );
header( 'refresh: 2; url=items.php');
}
?>
<b>Instructions:</b> <a href="#" onclick=hide('tohide')>Show/Hide</a><br />
<div id="tohide" style="display:none"><p><strong>Item Database:</strong> Make SURE that the item is legit, and that it is not already in the database when you go to insert one.<br />Note that incomplete items have an image, but no notes. The incomplete items pages isn't working properly yet.

<ol>
<li>Complete: ONLY mark items as complete if they are FULLY completed. If notes are "None.", make sure you can't think of any notes!</li>
<li>Name: Make sure its exactly the same as it is ingame. Only first word can be capitalised, Eg: Amulet of glory.</li>
<li>Image: Just the file name of the image in the idbimg.zip folder.</li>
<li>Type: is Miscellaneous by default, so before you edit information for an item, change its type FIRST, then go back in and edit the information for it (only the information required for that type is shown in the editor).</li>
<li>Member/Stack/Equip/Trade: CHECK it for Yes, UNcheck it for No.</li>
<li>Weight: 0kg for stackables, or ? for unknown.</li>
<li>Examine: Leave blank if you don't know it.</li>
<li>Quest: 'None' or the name of the quest.</li>
<li>Obtained from: EG: Smithing; Crafting; Players; Betty's Magic Emporium, Port Sarim; General Stores; Hill Giant drop.</li>
<li>Keep or drop: Either 'Keep' or 'Drop' or 'Not Applicable' if you give the item away during the quest.</li>
<li>Retrieve: How to retrieve it after or during the quest.</li>
<li>Quest use: EG: Give this to _____________. or Used to _________________.</li>
<li>Attack/Defence/Other: New format, see item edit page for info.</li>
<li>Notes: Be very descriptive; this page should detail everything you know about an item. Use full sentences, proper grammar and spelling. Ask Ben if you need to know how to write notes properly. Type "None." without quotations if there are none.</li>
<li>Keywords: Common misspellings</li>
<li>Credits: Always separate names with a semi-colon (;). Eg: Ben_Goten78; TheExtremist; Damea etc. ONLY add yourself if you do a) the entire item, b) the entire top section of an item, c) the entire bottom section of an item, or d) take the picture.</li>
</ol></p></div>

<?php

if( isset( $_POST['act'] ) AND $_POST['act'] == 'edit' AND isset( $_POST['id'] ) ) {

	$id = intval( $_POST['id'] );
	
	$_POST['weight'] = $_POST['weight'] == '?' ? -21.0 : floatval($_POST['weight']);
	$equip_id = $edit->add_update( $id, 'equip_id', $_POST['equip_id'], '', false );
	$pid = $edit->add_update( $id, 'pid', $_POST['pid'], '', false );
	$name = $edit->add_update( $id, 'name', $_POST['name'], '', false );
	$image = $edit->add_update( $id, 'image', $_POST['image'], '', false );
	$type = $edit->add_update( $id, 'type', $_POST['type'], '', false );
	$equip_type = $edit->add_update( $id, 'equip_type', $_POST['equip_type'], '', false );
	$member = $edit->add_update( $id, 'member', isset($_POST['member']) ? 1 : 0, '', false );
	$trade = $edit->add_update( $id, 'trade', isset($_POST['trade']) ? 1 : 0, '', false );
	$equip = $edit->add_update( $id, 'equip', isset($_POST['equip']) ? 1 : 0, '', false );
	$weight = $edit->add_update( $id, 'weight', $_POST['weight'], '', false );
	$speed = $edit->add_update( $id, 'speed', $_POST['speed'], '', false );	
	$stack = $edit->add_update( $id, 'stack', isset($_POST['stack']) ? 1 : 0, '', false );
	$complete = $edit->add_update( $id, 'complete', isset($_POST['complete']) ? 1 : 0, '', false );
	$examine = $edit->add_update( $id, 'examine', $_POST['examine'], '', false );
	$quest = $edit->add_update( $id, 'quest', $_POST['quest'], '', false );
	$obtain = $edit->add_update( $id, 'obtain', $_POST['obtain'], '', false );
	$highalch = $edit->add_update( $id, 'highalch', $_POST['highalch'], '', false );
	$lowalch = $edit->add_update( $id, 'lowalch', $_POST['lowalch'], '', false );
	$sellgen = $edit->add_update( $id, 'sellgen', $_POST['sellgen'], '', false );
	$buygen = $edit->add_update( $id, 'buygen', $_POST['buygen'], '', false );
	$keepdrop = $edit->add_update( $id, 'keepdrop', $_POST['keepdrop'], '', false );
	$retrieve = $edit->add_update( $id, 'retrieve', $_POST['retrieve'], '', false );
	$questuse = $edit->add_update( $id, 'questuse', $_POST['questuse'], '', false );
	$att = $edit->add_update( $id, 'att', $_POST['att'], '', false );
	$def = $edit->add_update( $id, 'def', $_POST['def'], '', false );
	$otherb = $edit->add_update( $id, 'otherb', $_POST['otherb'], '', false );
	$notes = $edit->add_update( $id, 'notes', $_POST['notes'], '', false );
	$keyword = $edit->add_update( $id, 'keyword', $_POST['keyword'], '', false );
    $pricelink = $edit->add_update( $id, 'pricelink', $_POST['pricelink'], '', false );	
	$credits = $edit->add_update( $id, 'credits', $_POST['credits'], '', false );

	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p style="text-align:center;">' . $edit->error_mess . '</p>';
		echo '<p style="text-align:center;"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>';
	}
	else {
		$ses->record_act( 'Item Database', 'Edit', $name, $ip );
		echo '<p style="text-align:center;">Entry successfully edited on Zybez.</p>';
	}
	
}
elseif( isset( $_POST['act'] ) AND $_POST['act'] == 'new' ) {


	$_POST['weight'] = $_POST['weight'] == '?' ? -21.0 : floatval($_POST['weight']);
	$equip_id = $edit->add_new( 1, 'equip_id', $_POST['equip_id'], '', false );
	$pid = $edit->add_new( 1, 'pid', $_POST['pid'], '', false );
	$name = $edit->add_new( 1, 'name', $_POST['name'], '', false );
	$image = $edit->add_new( 1, 'image', $_POST['image'], '', false );
	$type = $edit->add_new( 1, 'type', $_POST['type'], '', false );
	$equip_type = $edit->add_new( 1, 'equip_type', $_POST['equip_type'], '', false );
	$member = $edit->add_new( 1, 'member', isset($_POST['member']) ? 1 : 0, '', false );
	$trade = $edit->add_new( 1, 'trade', isset($_POST['trade']) ? 1 : 0, '', false );
	$equip = $edit->add_new( 1, 'equip', isset($_POST['equip']) ? 1 : 0, '', false );
	$weight = $edit->add_new( 1, 'weight', $_POST['weight'], '', false );
	$speed = $edit->add_new( 1, 'speed', $_POST['speed'], '', false );
	$stack = $edit->add_new( 1, 'stack', isset($_POST['stack']) ? 1 : 0, '', false );
	$complete = $edit->add_new( 1, 'complete', isset($_POST['complete']) ? 1 : 0, '', false );
	$examine = $edit->add_new( 1, 'examine', $_POST['examine'], '', false );
	$quest = $edit->add_new( 1, 'quest', $_POST['quest'], '', false );
	$obtain = $edit->add_new( 1, 'obtain', $_POST['obtain'], '', false );
	$highalch = $edit->add_new( 1, 'highalch', $_POST['highalch'], '', false );
	$lowalch = $edit->add_new( 1, 'lowalch', $_POST['lowalch'], '', false );
	$sellgen = $edit->add_new( 1, 'sellgen', $_POST['sellgen'], '', false );
	$buygen = $edit->add_new( 1, 'buygen', $_POST['buygen'], '', false );
	$keepdrop = $edit->add_new( 1, 'keepdrop', $_POST['keepdrop'], '', false );
	$retrieve = $edit->add_new( 1, 'retrieve', $_POST['retrieve'], '', false );
	$questuse = $edit->add_new( 1, 'questuse', $_POST['questuse'], '', false );
	$att = $edit->add_new( 1, 'att', $_POST['att'], '', false );
	$def = $edit->add_new( 1, 'def', $_POST['def'], '', false );
	$otherb = $edit->add_new( 1, 'otherb', $_POST['otherb'], '', false );
	$notes = $edit->add_new( 1, 'notes', $_POST['notes'], '', false );
	$keyword = $edit->add_new( 1, 'keyword', $_POST['keyword'], '', false );
	$pricelink = $edit->add_new( 1, 'pricelink', $_POST['pricelink'], '', false );
	$credits = $edit->add_new( 1, 'credits', $_POST['credits'], '', false );
	
	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p style="text-align:center;">' . $edit->error_mess . '</p>';
		echo '<p style="text-align:center;"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>';
	}
	else {
		$ses->record_act( 'Item Database', 'New', $name, $ip );
		echo '<p style="text-align:center;">New entry was successfully added to Zybez.</p>';
	}
	
}		
elseif( isset( $_GET['act'] ) AND ( ( $_GET['act'] == 'edit' AND isset( $_GET['id'] ) ) OR $_GET['act'] == 'new' ) ) {

	if( isset( $_POST['del_id'] ) AND $ses->permit( 15 ) ) {
		$edit_item->add_delete( $_POST['del_id'] );
		$execution = $edit_item->run_all( false, false );
		if( !$execution ) {
			echo '<p style="text-align:center;">' . $edit_item->error_mess . '</p>';
		}
	}
	
	if( $_GET['act'] == 'edit' ) {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM `items` WHERE id = " . $id );
		
		if( $info ) {
			$equip_id = $info['equip_id'];
			$pid = $info['pid'];
			$name = $info['name'];
			$image = $info['image'];
			$equip_type = $info['equip_type'];
			$type = $info['type'];
			$member = $info['member'];
			$trade = $info['trade'];
			$equip = $info['equip'];
			$weight = $info['weight'];
			$speed = $info['speed'];
			$stack = $info['stack'];
			$complete = $info['complete'];
			$examine = $info['examine'];
			$quest = $info['quest'];
			$obtain = $info['obtain'];
			$highalch = $info['highalch'];
			$lowalch = $info['lowalch'];
			$sellgen = $info['sellgen'];
			$buygen = $info['buygen'];
			$keepdrop = $info['keepdrop'];
			$retrieve = $info['retrieve'];
			$questuse = $info['questuse'];
			$att = $info['att'];
			$def = $info['def'];
			$otherb = $info['otherb'];
			$notes = $info['notes'];
			$keyword = $info['keyword'];
			$pricelink = $info['pricelink'];
			$credits = $info['credits'];
			
		}
		else {			
			$_GET['act'] = 'new';	
			$equip_id = '';
			$pid = '';
			$name = '';
			$image = 'nopic.gif';
			$type = '3';
			$equip_type = '';
			$member = 1;
			$trade = 1;
			$equip = 1;
			$complete = 1;
			$weight = -21.0;
			$speed = 0;
			$examine = '';
			$quest = 'No';
			$obtain = '';
			$highalch = '0';
			$lowalch = '0';
			$sellgen = '0';
			$buygen = '0';
			$keepdrop = '';
			$retrieve = '';
			$questuse = '';
			$att = '0|0|0|0|0';
			$def = '0|0|0|0|0';
			$otherb = '0|0|0';
			$notes = '';
			$keyword = '';
			$pricelink = '';
			$credits = '-';
	
		}
	}
	else {
			$equip_id = '';
			$pid = '';	
			$name = '';
			$image = 'nopic.gif';
			$type = '3';
			$member = 1;
			$trade = 1;
			$equip_type = '';
			$equip = 1;
			$complete = 1;
			$weight = -21.0;
			$speed = 0;
			$examine = '-';
			$quest = 'No';
			$obtain = '-';
			$highalch = '1';
			$lowalch = '1';
			$sellgen = '1';
			$buygen = '1';
			$keepdrop = '';
			$retrieve = '';
			$questuse = '';
			$att = '|0|0|0|0';
			$def = '|0|0|0|0';
			$otherb = '0|0|0';
			$notes = 'None';
			$keyword = '';
			$pricelink = '';
			$credits = '-';
	}

	$weight = $weight == -21.0 ? '?' : $weight;

	echo '<form method="post" action="">';
	echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />';

		$price = $db->fetch_row("SELECT name AS pricename, id AS priceid FROM price_items WHERE phold_id = 0 AND name='".addslashes($info['name'])."' LIMIT 1");


	if( $_GET['act'] == 'edit') {
		enum_correct( 'items', $id );	
		echo '<input type="hidden" name="id" value="' . $id . '" />';
$sel = $info['member'] == 1 ? ' checked="checked"' : '';
$selsta = $info['stack'] == 1 ? ' checked="checked"' : '';
$seltra = $info['trade'] == 1 ? ' checked="checked"' : '';
$selequ = $info['equip'] == 1 ? ' checked="checked"' : '';
$selcomp = $info['complete'] == 1 ? ' checked="checked"' : '';
$armweap = $info['type'] == 1 ? ' selected="selected"' : '';
$qitem = $info['type'] == 2 ? ' selected="selected"' : '';
$mitem = $info['type'] == 3 ? ' selected="selected"' : '';
$armset = $info['type'] == 4 ? ' selected="selected"' : '';

$noexist = $info['type'] == 0 ? ' selected="selected"' : '';
$armweap = $info['type'] == 1 ? ' selected="selected"' : '';
$qitem = $info['type'] == 2 ? ' selected="selected"' : '';
$mitem = $info['type'] == 3 ? ' selected="selected"' : '';
$armset = $info['type'] == 4 ? ' selected="selected"' : '';

$unset = $info['equip_type'] == -1 ? ' selected="selected"': '';  
$helm = $info['equip_type'] == 0 ? ' selected="selected"': ''; 
$amulet = $info['equip_type'] == 1 ? ' selected="selected"': ''; 
$cape = $info['equip_type'] == 2 ? ' selected="selected"': ''; 
$ammo = $info['equip_type'] == 3 ? ' selected="selected"': ''; 
$weapon = $info['equip_type'] == 4 ? ' selected="selected"': ''; 
$shield = $info['equip_type'] == 5 ? ' selected="selected"': ''; 
$chest = $info['equip_type'] == 6 ? ' selected="selected"': ''; 
$legs = $info['equip_type'] == 7 ? ' selected="selected"': ''; 
$boots = $info['equip_type'] == 8 ? ' selected="selected"': ''; 
$gloves = $info['equip_type'] == 9 ? ' selected="selected"': ''; 
$ring = $info['equip_type'] == 10 ? ' selected="selected"': ''; 
$other = $info['equip_type'] == 11 ? ' selected="selected"': ''; 
		}
	if( $type == 1)		{
	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000; border-top: none;" cellpadding="4" align="center">';
	echo '<tr>';
	echo '<td colspan="3" class="tabletop">Name: <input type="text" size="35" maxlength="35" name="name" autocomplete="off" value="' . $name . '" /></td></tr>';
	echo '<tr>';
    echo '<td rowspan="16" class="tablebottom" style="border-bottom: none;">Image: <input type="text" size="30" name="image" autocomplete="off" value="' . $image . '" /></td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Type:</b></td><td><select name="type"><option value="1" '.$armweap.'>1-Armour/Weap</option><option value="2" '.$qitem.'>2-Quest item</option><option value="3" '.$mitem.'>3-Misc item</option><option value="4" '.$armset.'>4-Armour set</option><option value="0" '.$noexist.'>0-Doesn\'t exist</option></select></td></tr>';
	echo '<tr><td width="15%"><b>Equipment Type:</b></td><td><select name="equip_type"><option value="-1" '.$unset.'>Unset</option><option value="0" '.$helm.'>Helmet</option><option value="1" '.$amulet.'>Amulet</option><option value="2" '.$cape.'>Cape</option><option value="3" '.$ammo.'>Ammo</option><option value="4" '.$weapon.'>Weapon</option><option value="5" '.$shield.'>Shield</option><option value="6" '.$chest.'>Chest</option><option value="7" '.$legs.'>Legs</option><option value="8" '.$boots.'>Boots</option><option value="9" '.$gloves.'>Gloves</option><option value="10" '.$ring.'>Ring</option><option value="11" '.$other.'>Other</option></select></td></tr>';

	echo '<tr>';
	echo '<td><b>Forum Price ID:</b></td><td><input type="text" size="5" name="pricelink" value="' . $pricelink . '" /></td></tr>';

	echo '<tr>';
	echo '<td width="15%"><b>Member:</b></td><td><input type="checkbox" name="member" value"1"'.$sel.' /></td></tr>';
	echo '<tr>';
	echo '<td><b>Tradable:</b></td><td><input type="checkbox" name="trade" value"1"'.$seltra.' /></td></tr>';
	echo '<tr>';
	echo '<td><b>Equipable:</b></td><td><input type="checkbox" name="equip" value"1"'.$selequ.' /></td></tr>';
	echo '<tr>';
	echo '<td><b>Stackable:</b></td><td><input type="checkbox" name="stack" value"1"'.$selsta.' /></td></tr>';
	echo '<tr>';
	echo '<td><b>Weight:</b></td><td><input type="text" size="5" name="weight" value="' . $weight . '" />kg</td></tr>';
	echo '<tr>';
	echo '<td width="20%" valign="top"><b>High Alchemy:</b></td><td><input type="text" size="20" name="highalch" value="' .$info['highalch'] . '" /></td></tr>';
	echo '<tr>';
	echo '<td valign="top"><b>Low Alchemy:</b></td><td><input type="text" size="20" name="lowalch" value="' . $info['lowalch'] . '" /></td></tr>';	
	echo '<tr>';
	echo '<td valign="top"><b>Sell to Gen:</b></td><td><input type="text" size="20" name="sellgen" value="' . $info['sellgen'] . '" /></td></tr>';
       echo '<tr>';
	echo '<td valign="top"><b>Buy from Gen:</b></td><td><input type="text" size="20" name="buygen" value="' . $info['buygen'] . '" /></td></tr>';
	echo '<tr>';
	echo '<td><b>Quest:</b></td><td><input type="text" size="60" maxlength="100" name="quest" value="' . $quest . '" /></td></tr>';
	echo '<tr>';
	echo '<td><b>Examine:</b></td><td><input type="text" size="60" maxlength="100" name="examine" value="' . $examine . '" /></td></tr>';
	echo '</table><br />';
	echo '<center>Complete? <input type="checkbox" name="complete" value"1"'.$selcomp.' /><br /><input type="submit" value="Submit All" /></center><br />';

	echo '<table cellspacing="0" width="80%" style="border: 1px solid #000;" cellpadding="4" align="center">';
	echo '<tr>';
	echo '<td><b>Speed:</b></td><td><input type="text" size="5" name="speed" value="' . $speed . '" /> out of 10</td></tr>';
	echo '<tr>';
	echo '<td width="20%" valign="top"><b>Attack bonus:</b></td><td><input type="text" size="30" name="att" value="' . $att . '" /> (<strong>stab|slash|crush|magic|range</strong>)</td></tr>';
	echo '<tr>';
	echo '<td width="20%" valign="top"><b>Defence bonus:</b></td><td><input type="text" size="30" name="def" value="' . $def . '" /> (<strong>stab|slash|crush|magic|range</strong>)</td></tr>';
	echo '<tr>';
	echo '<td width="20%" valign="top"><b>Other Stat:</b></td><td><input type="text" size="20" name="otherb" value="' . $otherb . '" /> (<strong>strength|prayer|range str</strong>)</td></tr>';
	echo '</table><br />';
	echo '<table cellspacing="0" width="80%" style="border: 1px solid #000;" cellpadding="4" align="center">';
	
	echo '<tr>';
	echo '<td width="20%" valign="top"><b>Obtained from:</b></td><td><input type="text" size="80" name="obtain" value="' . $obtain . '" /></td></tr>';
	echo '<tr>';
	echo '<td valign="top"><b>Notes:</b></td><td><textarea style="font: 10px Verdana, Arial, Helvetica, sans, sans serif;" name="notes" cols="76" rows="5">' .  $info['notes'] . '</textarea></td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Keywords:</b></td><td align="left"><input type="text" size="80" name="keyword" maxlength="150" value="' . $keyword . '" /><br />If the word is in the items name, it does NOT need to be in the keywords. This is mostly for aliases players give to items, e.g. baxe, and common misspellings.</td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Credits:</b></td><td align="left"><input type="text" size="80" name="credits" value="' . $credits . '" /> (use ; not , to separate)</td></tr>';
	echo '</table><br />';
		}
	elseif($type == 2)		{
	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000; border-top: none;" cellpadding="4" align="center">';
	echo '<tr>';
	echo '<td colspan="3" class="tabletop">Name: <input type="text" size="35" maxlength="35" name="name" autocomplete="off" value="' . $name . '" /></td></tr>';
	echo '<tr>';
    echo '<td rowspan="12" class="tablebottom" style="border-bottom: none;">Image: <input type="text" size="30" name="image" autocomplete="off" value="' . $image . '" /></td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Type:</b></td><td><select name="type"><option value="1" '.$armweap.'>1-Armour/Weap</option><option value="2" '.$qitem.'>2-Quest item</option><option value="3" '.$mitem.'>3-Misc item</option><option value="4" '.$armset.'>4-Armour set</option><option value="0" '.$noexist.'>0-Doesn\'t exist</option></select></td></tr>';
	echo '<tr><td width="15%"><b>Equipment Type:</b></td><td><select name="equip_type"><option value="-1" '.$unset.'>Unset</option><option value="0" '.$helm.'>Helmet</option><option value="1" '.$amulet.'>Amulet</option><option value="2" '.$cape.'>Cape</option><option value="3" '.$ammo.'>Ammo</option><option value="4" '.$weapon.'>Weapon</option><option value="5" '.$shield.'>Shield</option><option value="6" '.$chest.'>Chest</option><option value="7" '.$legs.'>Legs</option><option value="8" '.$boots.'>Boots</option><option value="9" '.$gloves.'>Gloves</option><option value="10" '.$ring.'>Ring</option><option value="11" '.$other.'>Other</option></select></td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Member:</b></td><td><input type="checkbox" name="member" value"1"'.$sel.' /></td></tr>';
	echo '<tr>';
	echo '<td><b>Tradable:</b></td><td><input type="checkbox" name="trade" value"1"'.$seltra.' /></td></tr>';
	echo '<tr>';
	echo '<td><b>Equipable:</b></td><td><input type="checkbox" name="equip" value"1"'.$selequ.' /></td></tr>';
	echo '<tr>';
	echo '<td><b>Stackable:</b></td><td><input type="checkbox" name="stack" value"1"'.$selsta.' /></td></tr>';
	echo '<tr>';
	echo '<td><b>Weight:</b></td><td><input type="text" size="5" name="weight" value="' . $weight . '" />kg</td></tr>';
	echo '<tr>';
	echo '<td><b>Quest:</b></td><td><input type="text" size="60" maxlength="100" name="quest" value="' . $quest . '" /></td></tr>';
	echo '<tr>';
	echo '<td><b>Examine:</b></td><td><input type="text" size="60" name="examine" value="' . $examine . '" /></td></tr>';
	echo '</table><br />';
	
	echo '<center>Complete? <input type="checkbox" name="complete" value"1"'.$selcomp.' /><br /><input type="submit" value="Submit All" /></center><br />';

	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000;" cellpadding="4" align="center">';
	echo '<tr>';
	echo '<td width="20%" valign="top"><b>Obtained from:</b></td><td><input type="text" size="80" name="obtain" value="' . $obtain . '" /></td></tr>';
	echo '<tr>';
	echo '<td width="20%" valign="top"><b>Attack bonus:</b></td><td><input type="text" size="20" name="att" value="' . $att . '" /> (<strong>NEW FORMAT: stab|slash|crush|magic|range</strong>)</td></tr>';
	echo '<tr>';
	echo '<td width="20%" valign="top"><b>Defence bonus:</b></td><td><input type="text" size="20" name="def" value="' . $def . '" /> (<strong>NEW FORMAT: stab|slash|crush|magic|range</strong>)</td></tr>';
	echo '<tr>';
	echo '<td width="20%" valign="top"><b>Other Stat:</b></td><td><input type="text" size="20" name="otherb" value="' . $otherb . '" /> (<strong>NEW FORMAT: strength|prayer|range str</strong>)</td></tr>';
	echo '<tr>';
	echo '<td width="20%" valign="top"><b>Keep or Drop:</b></td><td><input type="text" size="80" name="keepdrop" value="' . $keepdrop . '" /></td></tr>';
	echo '<tr>';
	echo '<td width="20%" valign="top"><b>Retrieval:</b></td><td><input type="text" size="80" name="retrieve" value="' . $retrieve . '" /></td></tr>';
	echo '<tr>';
	echo '<td width="20%" valign="top"><b>Uses:</b></td><td><input type="text" size="80" name="questuse" value="' . $questuse . '" /></td></tr>';
	echo '<tr>';
	echo '<td valign="top"><b>Notes:</b></td><td><textarea style="font: 10px Verdana, Arial, Helvetica, sans, sans serif;" name="notes" cols="76" rows="5">' .  $info['notes'] . '</textarea></td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Keywords:</b></td><td align="left"><input type="text" size="80" maxlength="150" name="keyword" value="' . $keyword . '" /><br />If the word is in the items name, it does NOT need to be in the keywords. This is mostly for aliases players give to items, e.g. baxe, and common misspellings.</td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Credits:</b></td><td align="left"><input type="text" size="80" name="credits" value="' . $credits . '" /> (use ; not , to separate)</td></tr>';
	echo '</table><br />';
			}
							
	elseif($type == 3)		{
	
	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000; border-top: none;" cellpadding="4" align="center">';
	echo '<tr>';
	echo '<td colspan="3" class="tabletop">Name: <input type="text" size="35" maxlength="35" name="name" autocomplete="off" value="' . $name . '" /></td></tr>';
	echo '<tr>';
    echo '<td rowspan="15 class="tablebottom" style="border-bottom: none;">Image: <input type="text" size="30" name="image" autocomplete="off" value="' . $image . '" /></td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Type:</b></td><td><select name="type"><option value="1" '.$armweap.'>1-Armour/Weap</option><option value="2" '.$qitem.'>2-Quest item</option><option value="3" '.$mitem.'>3-Misc item</option><option value="4" '.$armset.'>4-Armour set</option><option value="0" '.$noexist.'>0-Doesn\'t exist</option></select></td></tr>';
	echo '<tr><td width="15%"><b>Equipment Type:</b></td><td><select name="equip_type"><option value="-1" '.$unset.'>Unset</option><option value="0" '.$helm.'>Helmet</option><option value="1" '.$amulet.'>Amulet</option><option value="2" '.$cape.'>Cape</option><option value="3" '.$ammo.'>Ammo</option><option value="4" '.$weapon.'>Weapon</option><option value="5" '.$shield.'>Shield</option><option value="6" '.$chest.'>Chest</option><option value="7" '.$legs.'>Legs</option><option value="8" '.$boots.'>Boots</option><option value="9" '.$gloves.'>Gloves</option><option value="10" '.$ring.'>Ring</option><option value="11" '.$other.'>Other</option></select></td></tr>';
	
	echo '<tr>';
	echo '<td><b>Forum Price ID:</b></td><td><input type="text" size="5" name="pricelink" value="' . $pricelink . '" /></td></tr>';
	
	echo '<tr>';
	echo '<td width="15%"><b>Member:</b></td><td><input type="checkbox" name="member" value"1"'.$sel.' /></td></tr>';
	echo '<tr>';
	echo '<td><b>Tradable:</b></td><td><input type="checkbox" name="trade" value"1"'.$seltra.' /></td></tr>';
	echo '<tr>';
	echo '<td><b>Equipable:</b></td><td><input type="checkbox" name="equip" value"1"'.$selequ.' /></td></tr>';
	echo '<tr>';
	echo '<td><b>Stackable:</b></td><td><input type="checkbox" name="stack" value"1"'.$selsta.' /></td></tr>';
	echo '<tr>';
	echo '<td><b>Weight:</b></td><td><input type="text" size="5" name="weight" value="' . $weight . '" />kg</td></tr>';
	echo '<tr>';
	echo '<td width="20%" valign="top"><b>High Alchemy:</b></td><td><input type="text" size="20" name="highalch" value="' .$info['highalch'] . '" /></td></tr>';
	echo '<tr>';
	echo '<td valign="top"><b>Low Alchemy:</b></td><td><input type="text" size="20" name="lowalch" value="' . $info['lowalch'] . '" /></td></tr>';	
	echo '<tr>';
	echo '<td valign="top"><b>Sell to Gen:</b></td><td><input type="text" size="20" name="sellgen" value="' . $info['sellgen'] . '" /></td></tr>';
       echo '<tr>';
	echo '<td valign="top"><b>Buy from Gen:</b></td><td><input type="text" size="20" name="buygen" value="' . $info['buygen'] . '" /></td></tr>';
	echo '<tr>';
	echo '<td><b>Quest:</b></td><td><input type="text" size="60" name="quest" value="' . $quest . '" /></td></tr>';
	echo '<tr>';
	echo '<td><b>Examine:</b></td><td><input type="text" size="60" name="examine" value="' . $examine . '" /></td></tr>';
	echo '</table><br />';
	
	echo '<center>Complete? <input type="checkbox" name="complete" value"1"'.$selcomp.' /><br /><input type="submit" value="Submit All" /></center><br />';

	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000;" cellpadding="4" align="center">';
	echo '<tr>';
	echo '<td width="20%" valign="top"><b>Obtained from:</b></td><td><input type="text" size="80" name="obtain" value="' . $obtain . '" /></td></tr>';
	echo '<tr>';
	echo '<td valign="top"><b>Notes:</b></td><td><textarea style="font: 10px Verdana, Arial, Helvetica, sans, sans serif;" name="notes" cols="76" rows="5">' .  $info['notes'] . '</textarea></td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Keywords:</b></td><td align="left"><input type="text" size="80" maxlength="150" name="keyword" value="' . $keyword . '" /><br />If the word is in the items name, it does NOT need to be in the keywords. This is mostly for aliases players give to items, e.g. baxe, and common misspellings.</td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Credits:</b></td><td align="left"><input type="text" size="80" name="credits" value="' . $credits . '" /> (use ; not , to separate)</td></tr>';
	echo '</table><br />';
}
	elseif($type == 4)		{
	
	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000; border-top: none;" cellpadding="4" align="center">';
	echo '<tr>';
	echo '<td colspan="3" class="tabletop">Name: <input type="text" size="35" maxlength="35" name="name" autocomplete="off" value="' . $name . '" /></td></tr>';
	echo '<tr>';
    echo '<td rowspan="14" class="tablebottom" style="border-bottom: none;width:40%;">Image: <input type="text" size="30" name="image" autocomplete="off" value="' . $image . '" /></td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Set ID:</b></td><td><input type="text" size="10" name="equip_id" value="' .$info['equip_id'] . '" /></td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Type:</b></td><td><select name="type"><option value="1" '.$armweap.'>1-Armour/Weap</option><option value="2" '.$qitem.'>2-Quest item</option><option value="3" '.$mitem.'>3-Misc item</option><option value="4" '.$armset.'>4-Armour set</option><option value="0" '.$noexist.'>0-Doesn\'t exist</option></select></td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Member:</b></td><td><input type="checkbox" name="member" value"1"'.$sel.' /></td></tr>';
	echo '<tr>';
	echo '<td><b>Tradable:</b></td><td><input type="checkbox" name="trade" value"1"'.$seltra.' /></td></tr>';
	echo '<tr>';
	echo '<td><b>Weight:</b></td><td><input type="text" size="5" name="weight" value="' . $weight . '" />kg</td></tr>';
	echo '<tr>';
	echo '<td width="20%" valign="top"><b>High Alchemy:</b></td><td><input type="text" size="20" name="highalch" value="' .$info['highalch'] . '" /></td></tr>';
	echo '<tr>';
	echo '<td valign="top"><b>Low Alchemy:</b></td><td><input type="text" size="20" name="lowalch" value="' . $info['lowalch'] . '" /></td></tr>';	
	echo '<tr>';
	echo '<td><b>Quest:</b></td><td><input type="text" size="20" name="quest" value="' . $quest . '" /></td></tr>';
	echo '</table><br />';
	
	echo '<center>Complete? <input type="checkbox" name="complete" value"1"'.$selcomp.' /><br /><input type="submit" value="Submit All" /></center><br />';

	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000;" cellpadding="4" align="center">';
	echo '<tr>';
	echo '<td valign="top"><b>Notes:</b></td><td><textarea style="font: 10px Verdana, Arial, Helvetica, sans, sans serif;" name="notes" cols="76" rows="5">' .  $info['notes'] . '</textarea></td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Keywords:</b></td><td align="left"><input type="text" size="80" maxlength="150" name="keyword" value="' . $keyword . '" /><br />If the word is in the items name, it does NOT need to be in the keywords. This is mostly for aliases players give to items, e.g. baxe, and common misspellings.</td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Credits:</b></td><td align="left"><input type="text" size="80" name="credits" value="' . $credits . '" /> (use ; not , to separate)</td></tr>';
	echo '</table><br />';
}

	else		{
	
	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000; border-top: none;" cellpadding="4" align="center">';
	echo '<tr>';
	echo '<td colspan="3" class="tabletop">Name: <input type="text" size="35" maxlength="35" name="name" autocomplete="off" value="' . $name . '" /></td></tr>';
	echo '<tr>';
  echo '<td rowspan="11" class="tablebottom" style="border-bottom: none;">Image: <input type="text" size="30" name="image" autocomplete="off" value="' . $image . '" /></td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Type:</b></td><td><select name="type"><option value="1" '.$armweap.'>1-Armour/Weap</option><option value="2" '.$qitem.'>2-Quest item</option><option value="3" '.$mitem.'>3-Misc item</option><option value="4" '.$armset.'>4-Armour set</option><option value="0" '.$noexist.'>0-Doesn\'t exist</option></select></td></tr>';
	echo '<tr><td width="15%"><b>Equipment Type:</b></td><td><select name="equip_type"><option value="-1" '.$unset.'>Unset</option><option value="0" '.$helm.'>Helmet</option><option value="1" '.$amulet.'>Amulet</option><option value="2" '.$cape.'>Cape</option><option value="3" '.$ammo.'>Ammo</option><option value="4" '.$weapon.'>Weapon</option><option value="5" '.$shield.'>Shield</option><option value="6" '.$chest.'>Chest</option><option value="7" '.$legs.'>Legs</option><option value="8" '.$boots.'>Boots</option><option value="9" '.$gloves.'>Gloves</option><option value="10" '.$ring.'>Ring</option><option value="11" '.$other.'>Other</option></select></td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Member:</b></td><td><input type="checkbox" name="member" value"1"'.$sel.' /></td></tr>';
	echo '<tr>';
	echo '<td><b>Tradable:</b></td><td><input type="checkbox" name="trade" value"1"'.$seltra.' /></td></tr>';
	echo '<tr>';
	echo '<td><b>Equipable:</b></td><td><input type="checkbox" name="equip" value"1"'.$selequ.' /></td></tr>';
	echo '<tr>';
	echo '<td><b>Stackable:</b></td><td><input type="checkbox" name="stack" value"1"'.$selsta.' /></td></tr>';
	echo '<tr>';
	echo '<td><b>Weight:</b></td><td><input type="text" size="5" name="weight" value="' . $weight . '" />kg</td></tr>';
	echo '<tr>';
	echo '<td width="20%" valign="top"><b>High Alchemy:</b></td><td><input type="text" size="20" name="highalch" value="' .$info['highalch'] . '" /></td></tr>';
	echo '<tr>';
	echo '<td><b>Examine:</b></td><td><input type="text" size="60" name="examine" value="' . $examine . '" /></td></tr>';
	echo '</table><br />';

	echo '<center>Complete? <input type="checkbox" name="complete" value"1"'.$selcomp.' /><br /><input type="submit" value="Submit All" /></center><br />';

	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000;" cellpadding="4" align="center">';
	echo '<tr>';
	echo '<td width="20%" valign="top"><b>Obtained from:</b></td><td><input type="text" size="80" name="obtain" value="' . $obtain . '" /></td></tr>';
	echo '<tr>';
	echo '<td valign="top"><b>Notes:</b></td><td><textarea style="font: 10px Verdana, Arial, Helvetica, sans, sans serif;" name="notes" cols="76" rows="5">' .  $info['notes'] . '</textarea></td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Keywords:</b></td><td align="left"><input type="text" size="80" maxlength="150" name="keyword" value="' . $keyword . '" /><br />If the word is in the items name, it does NOT need to be in the keywords. This is mostly for aliases players give to items, e.g. baxe, and common misspellings.</td></tr>';
	echo '<tr>';
	echo '<td width="15%"><b>Credits:</b></td><td align="left"><input type="text" size="80" name="credits" value="' . $credits . '" /></td></tr>';
	echo '</table><br />';
}
	echo '</form>';
}
elseif( isset( $_GET['act'] ) AND $_GET['act'] == 'delete' AND $ses->permit( 15 ) ) {

	if( isset( $_POST['del_id'] ) ) {
		$edit->add_delete( $_POST['del_id'] );
		$execution = $edit->run_all();
		
		if( !$execution  ) {
			echo '<p style="text-align:center;">' . $edit->error_mess . '</p>';
		}
		else {
			$db->query("DELETE FROM `items` WHERE id = " . $_POST['del_id'] );
			$ses->record_act( 'Item Database', 'Delete', $_POST['del_name'], $ip );
			header( 'refresh: 2; url=items.php');
			echo '<p style="text-align:center;">Entry successfully deleted from Zybez.</p>';
		}
	}
	else {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM `items` WHERE id = " . $id );
	
		if( $info ) {
		
			$name = $info['name'];
			echo '<p style="text-align:center;">Are you sure you want to delete the item, \'' . $name . '\'?</p>';
			echo '<form method="post" action="?act=delete"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>';
			echo '<form method="post" action=""><center><input type="submit" value="No" /></center></form>';
		}
		else {
			
			echo '<p style="text-align:center;">That identification number does not exist.</p>';
		}
	}
}
else {

	if( isset( $_GET['category'] ) and isset( $_GET['search_area'] ) and ( $_GET['category'] == 'name' or $_GET['category'] == 'image' or $_GET['category'] == 'quest' or $_GET['category'] == 'obtain' or $_GET['category'] == 'type' or $_GET['category'] == 'notes' or $_GET['category'] == 'examine' or $_GET['category'] == 'credits' ) ) {
		$category = $_GET['category'];
	}
	else {
		$category = 'name';
	}
	if( isset( $_GET['search_area'] ) and ( $_GET['search_area'] != 'itemsearch' and $_GET['search_area'] == 'name' or $_GET['search_area'] == 'image' or $_GET['search_area'] == 'quest' or $_GET['search_area'] == 'obtain' or $_GET['search_area'] == 'type' or $_GET['search_area'] == 'pid' or $_GET['search_area'] == 'equip_type' or $_GET['search_area'] == 'notes' or $_GET['search_area'] == 'examine' or $_GET['search_area'] == 'credits' ) ) {
	   $search_area = addslashes($_GET['search_area']);
	   $search_term = strip_tags($_GET['search_term']);
		if($search_area == 'name' && $search_term != '') { // Keyword search
			$search_terms_q = str_replace(',', '', addslashes($search_term));
			$search_terms_q = explode(' ', $search_terms_q);
			$search_terms_q[0] = "(items.name = '".$search_terms_q[0]."' OR items.name LIKE '%".$search_terms_q[0]."%' OR items.name LIKE '".$search_terms_q[0]."%' OR items.name LIKE '%".$search_terms_q[0]."' OR ((items.keyword = '".$search_terms_q[0]."' OR items.keyword LIKE '%".$search_terms_q[0]."%' OR items.keyword LIKE '".$search_terms_q[0]."%' OR items.keyword LIKE '%".$search_terms_q[0]."') AND items.keyword != ''))";
			for($num = 1; array_key_exists($num, $search_terms_q); $num++) {
				$search_terms_q[$num] = "AND (items.name = '".$search_terms_q[$num]."' OR items.name LIKE '%".$search_terms_q[$num]."%' OR items.name LIKE '".$search_terms_q[$num]."%' OR items.name LIKE '%".$search_terms_q[$num]."' OR items.keyword = '".$search_terms_q[$num]."' OR items.keyword LIKE '%".$search_terms_q[$num]."%' OR items.keyword LIKE '".$search_terms_q[$num]."%' OR items.keyword LIKE '%".$search_terms_q[$num]."') ";
			}
			$search_terms_q = implode('', $search_terms_q);
			$search = "SELECT * FROM `items` WHERE ".$search_terms_q." ORDER BY `".$category."` ".$order;
		}
		elseif($search_area == 'pid') {
		$search = "SELECT * FROM `items` WHERE ".$search_area." = '".addslashes($search_term)."' AND type IN (1,3) AND trade = 1 ORDER BY `".$category."` ".$order;
		}
		else { // Standard search
			$search = "SELECT * FROM `items` WHERE ".$search_area." LIKE '%".addslashes($search_term)."%' ORDER BY `".$category."` ".$order;
		}
	}
	else {
		$search_term = '';
		$search_area = '';
		$search = "SELECT * FROM `items` WHERE type != 4 ORDER BY `time` DESC";
	}
	
	if( isset( $_GET['page'] ) ) {
		$page = intval( $_GET['page'] );
	}
	 else {
		$page = '1';
	}
		
	$search_term = stripslashes( $search_term );

	$entries_per_page = 50;
	$db->query( $search );
	$entry_count = $db->num_rows( $search );
	$page_count = ceil( $entry_count / $entries_per_page );
	$page_links = '';
	$current_page = 0;
		while( $current_page < $page_count ) {
		$current_page++;
		if( $current_page == $page ) {
			$page_links = '' . $page_links . '<b>['. $current_page . ']</b> ';
		}
		else {
			$page_links = $page_links . '<a href="?page=' . $current_page . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '">'. $current_page . '</a> ';
			}
	}

	if( $page_count > 1 AND $page > 1 )
	{
		  $page_before = $page - 1;
		  $page_links = '<a href="?page=' . $page_before . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '">< Previous</a> ' . $page_links;
	}

  	if( $page_count > 1 AND $page != $page_count ) {
		  $page_after = $page + 1;
		  $page_links = $page_links . '<a href="?page=' . $page_after . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '">Next ></a> ';
	}

	$start_from = $page - 1;
	$start_from = $start_from * $entries_per_page;
	$qual = $search . " LIMIT " . $start_from . ", " . $entries_per_page;
	$query = $db->query( $qual );

  echo '<br /><div class="notice">Do not edit in image file names.  Whenever the manager moves the file, he/she will put in the image.</div>';
	echo '<p style="text-align:center;"><b><a href="items_queries.php">Click here to find things that need doing/checking</a></b><br /><b>Only insert newly released items and always check to see if it\'s in the database first.</b></p>';
	echo '<center><form action="" method="get">';
	echo 'Search <select name="search_area">';
	
	if( $search_area == 'name' ) {
		echo '<option value="name" selected="selected">Name</option>';
	}
	else {
		echo '<option value="name">Name</option>';
	}
	if( $search_area == 'image' ) {
		echo '<option value="image" selected="selected">Image</option>';
	}
	else {
		echo '<option value="image">Image</option>';
	}
	if( $search_area == 'quest' ) {
		echo '<option value="quest" selected="selected">Quest</option>';
	}	
	else {
		echo '<option value="quest">Quest</option>';
	}
	if( $search_area == 'obtain' ) {
		echo '<option value="obtain" selected="selected">Obtain</option>';
	}	
	else {
		echo '<option value="obtain">Obtain</option>';
	}
	if( $search_area == 'type' ) {
		echo '<option value="type" selected="selected">Type</option>';
	}
	else {
		echo '<option value="type">Type</option>';
	}
	if( $search_area == 'equip_type' ) {
		echo '<option value="equip_type" selected="selected">Equip Type</option>';
	}
	else {
		echo '<option value="equip_type">Equip Type</option>';
	}
	if( $search_area == 'pid' ) {
		echo '<option value="pid" selected="selected">Price ID</option>';
	}
	else {
		echo '<option value="pid">Price ID</option>';
	}
	if( $search_area == 'notes' ) {
		echo '<option value="notes" selected="selected">Notes</option>';
	}
	else {
		echo '<option value="notes">Notes</option>';
	}
	if( $search_area == 'examine' ) {
		echo '<option value="examine" selected="selected">Examine</option>';
	}
	else {
		echo '<option value="examine">Examine</option>';
	}
	if( $search_area == 'credits' ) {
		echo '<option value="credits" selected="selected">Credits</option>';
	}
	else {
		echo '<option value="credits">Credits</option>';
	}
	echo '</select> for ';

	echo '<input type="text" name="search_term" value="' . $search_term . '" maxlength="40" />';
	echo '<input type="submit" value="Go" />';
	echo '</form></center><br />';
	

	$totq = "SELECT * FROM `items` WHERE `type`!= 0 AND type !=4";
$total = $db->query($totq);
$num_total = $db->num_rows( $totq );

$num_complete = 0;
$num_started = 0;
while( $info = $db->fetch_array( $total ) ) {
	if( $info['complete'] == 1) {
		$num_complete++;
	}
	elseif( $info['type'] != 0 && ( $info['image'] !='nopic.gif' && $info['notes'] == '' OR $info['complete'] == 0) ) {
		$num_started++;
	}
}

$num_need = $num_total - $num_complete;

if ($num_total > 0) {
    $percent_complete = $num_complete / $num_total;
    $percent_complete = $percent_complete * 100;
    $percent_complete = round( $percent_complete , 2 );

    $percent_started = $num_started / $num_total;
    $percent_started = $percent_started * 100;
    $percent_started = round( $percent_started , 2 );

    $percent_needed = 100 - $percent_complete - $percent_started;
    $percent_needed = round ( $percent_needed , 3 );
} else {
    $percent_complete = 0;
    $percent_started = 0;
    $percent_needed = 0;
}
?>
	
<table class="boxtop" border="0" cellpadding="1" cellspacing="2" width="100%" style="border: 1px solid black; margin: auto;">
<tr>
<td align="center" colspan="3">To Complete: <?php echo $num_need; ?></td>
</tr>
<tr>
<td valign="top" align="center" width="110">Completed: <?php echo $num_complete; ?></td>
<td>
<table width="100%" cellpadding="1" cellspacing="0" style="border: 1px solid black;"><tr>
<td bgcolor="#009E00" width="<?php echo $percent_complete; ?>%" align="center"><?php echo $percent_complete; ?>%</td>
<?php

 if( $percent_started > 0 ) { ?><td bgcolor="#D4D400" width="<?php echo $percent_started; ?>%" style="border-left: 1px solid black;" align="center"><?php echo $percent_started; ?>%</td>
<?php
 } else { 
echo '<td bgcolor="#D4D400" align="center" style="border-left: 1px solid black;"></td>';
 }
 echo '<!--<td bgcolor="#D4D400" width="' . $percent_started . '%" align="center" style="border-left: 1px solid black; text-color: black;">' . $percent_started . '%</td>-->';
}
?>

<td bgcolor="#B80000" style="border-left: 1px solid black;"><?php echo $percent_needed; ?>%</td>
</tr></table>
</td>
<td valign="top" align="center" width="110">Total: <?php echo $num_total; ?></td>
</tr>
<tr>
<td align="center" colspan="3">Incomplete/Started: <?php echo $num_started; ?> ( <a href="?act=incomplete">View</a> )</td>
</tr>

</table><br />

	<table style="border-left: 1px solid #000;" width="100%" cellpadding="1" cellspacing="0">
	<tr>
	<th class="tabletop">Image:</th>
	<th class="tabletop">Name:</th>
	<th class="tabletop">Actions:</th>
	<th class="tabletop">Last Edited (GMT):</th>
	</tr>
	<?php
	
if(isset( $_GET['act'] ) AND $_GET['act'] == 'incomplete') {

	$id = intval( $_POST['id'] );
	$sql = $db->query("SELECT * FROM items WHERE type !=0 AND type !=4 AND ( image !='nopic.gif' AND notes = '' OR complete = 0 ) ORDER BY `id` DESC");
	$srch = 'Incomplete/Started Items';
			echo '<p><b>Searching for</b>: '.$srch.'</p>';
      while($info = $db->fetch_array( $sql ) ) {
		
        echo '<tr align="center">';
        echo '<td class="tablebottom"><img src="/img/idbimg/' . $info['image'] . '" alt="Item Image" /></td>';
        echo '<td class="tablebottom"><a href="/items.php?id=' . $info['id'] . '" title="View Item" target="item_view">' . $info['name'] . '</a></td>';
        echo '<td class="tablebottom"><a href="?act=edit&amp;id=' . $info['id'] . '">Edit</a>';
        if( $ses->permit( 15 ) ) {
          echo ' / <a href="?act=delete&amp;id=' . $info['id'] . '">Delete</a></td>';
            }
        echo '<td class="tablebottom">' . format_time( $info['time'] ) . '</td>';
        echo '</tr>';
    }
}
else {
	if(isset($query) && $query) {
	while($info = $db->fetch_array( $query ) ) {
	
		echo '<tr align="center">';
		echo '<td class="tablebottom"><img src="/img/idbimg/' . $info['image'] . '" alt="Item Image" /></td>';
		echo '<td class="tablebottom"><a href="/items.php?id=' . $info['id'] . '" title="View Item" target="item_view">' . $info['name'] . '</a></td>';
		echo '<td class="tablebottom"><a href="?act=edit&amp;id=' . $info['id'] . '">Edit</a>';
		if( $ses->permit( 15 ) ) {
			echo ' / <a href="?act=delete&amp;id=' . $info['id'] . '">Delete</a></td>';
		}
		echo '<td class="tablebottom">' . format_time( $info['time'] ) . '</td>';
		echo '</tr>';
	}
	if( $db->num_rows( $qual ) == 0 ) {
		echo '<tr>';
		echo '<td class="tablebottom" colspan="4">Sorry, no entries match your search criteria.</td>';
		echo '</tr>'; 
  }
}
?>
</table><br />
<?php
if (isset( $_GET['act'] ) AND $_GET['act'] == 'incomplete') {
	echo '<p style="text-align:center;">Incomplete items</p>';
	}
	elseif ( $page_count > 1 ) {
	echo '<p style="text-align:center;">' . $page_links . '</p>';
}
/* } */

echo '<br /></div>';
if(!isset($name)) $name = '';
end_page($name);
?>
