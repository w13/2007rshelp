<?php
require( 'backend.php' );
require( 'edit_class.php' );
start_page( 6, 'Item Database' );

$edit = new edit( 'items', $db );

echo '<div class="boxtop">Item Database</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;

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

<div style="float: right;"><a href="<?=$_SERVER['PHP_SELF']?>"><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="<?=$_SERVER['PHP_SELF']?>?act=new"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; Item Database</font></b>
</div>
<hr class="main" noshade="noshade" align="left" />
<b>Instructions:</b> <a href="#" onclick=hide('tohide')>Show/Hide</a><br />
<div id="tohide" style="display:none"><p><strong>Item Database:</strong> Make SURE that the item is legit, and that it is not already in the database when you go to insert one.<br />Note that incomplete items have an image, but no notes. The incomplete items pages isn't working properly yet.

<ol>
<li>Name: Make sure its exactly the same as it is ingame. Only first word can be capitalised, Eg: Amulet of glory.</li>
<li>Image: Just the file name of the image in the idbimg.zip folder.</li>
<li>Type: 1 = Armour/Weapon; 2 = Quest item; 3 = Miscellaneous.<br />-- They're 3 by default, so before you edit information for an item, change its type FIRST, then go back in and edit the information for it (only the information required for that type is shown in the editor).</li>
<li>Weight: 0kg for stackables, or ? for unknown. Learn how to find weights <a href="http://corporate.zybez.net/forums/index.php?showtopic=1648">here</a>.</li>
<li>Examine: Leave blank if you don't know it.</li>
<li>Quest: 'None' or the name of the quest.</li>
<li>Obtained from: EG: Smithing; Crafting; Players; Betty's Magic Emporium, Port Sarim; General Stores; Hill Giant drop.</li>
<li>Keep or drop: Either 'Keep' or 'Drop' or 'Not Applicable' if you give the item away during the quest.</li>
<li>Retrieve: How to retrieve it after or during the quest.</li>
<li>Quest use: EG: Give this to _____________. or Used to _________________.</li>
<li>Attack/Defence/Other: Keep them in the same format, info can be found in the information package.</li>
<li>Notes: Be very descriptive; this page should detail everything you know about an item. Use full sentences, proper grammar and spelling. Ask Ben if you need to know how to write notes properly. Type "None." without quotations if there are none.</li>
<li>Keywords: Talk to Ben before you do any of these - do not give keywords to items that are in the price guide.</li>
<li>Credits: Always separate names with a semi-colon (;). Eg: Ben_Goten78; TheExtremist; Damea etc.</li>
</ol></p></div>

<?
if( isset( $_POST['act'] ) AND $_POST['act'] == 'edit' AND isset( $_POST['id'] ) ) {

	$id = intval( $_POST['id'] );
	
	$_POST['weight'] = $_POST['weight'] == '?' ? -21.0 : floatval($_POST['weight']);

	$name = $edit->add_update( $id, 'name', $_POST['name'], '', false );
	$image = $edit->add_update( $id, 'image', $_POST['image'], '', false );
	$type = $edit->add_update( $id, 'type', $_POST['type'], '', false );
	$member = $edit->add_update( $id, 'member', $_POST['member'], '', false );
	$trade = $edit->add_update( $id, 'trade', $_POST['trade'], '', false );
	$equip = $edit->add_update( $id, 'equip', $_POST['equip'], '', false );
	$weight = $edit->add_update( $id, 'weight', $_POST['weight'], '', false );
	$examine = $edit->add_update( $id, 'examine', $_POST['examine'], '', false );
	$quest = $edit->add_update( $id, 'quest', $_POST['quest'], '', false );
	$obtain = $edit->add_update( $id, 'obtain', $_POST['obtain'], '', false );
	//$market = $edit->add_update( $id, 'market', $_POST['market'], '', false );
	$highalch = $edit->add_update( $id, 'highalch', $_POST['highalch'], '', false );
	$lowalch = $edit->add_update( $id, 'lowalch', $_POST['lowalch'], '', false );
	$sellgen = $edit->add_update( $id, 'sellgen', $_POST['sellgen'], '', false );
	$buygen = $edit->add_update( $id, 'buygen', $_POST['buygen'], '', false );
	$keepdrop = $edit->add_update( $id, 'keepdrop', $_POST['keepdrop'], '', false );
	$retrieve = $edit->add_update( $id, 'retrieve', $_POST['retrieve'], '', false );
	$questuse = $edit->add_update( $id, 'questuse', $_POST['questuse'], '', false );
	$attack = $edit->add_update( $id, 'attack', $_POST['attack'], '', false );
	$defense = $edit->add_update( $id, 'defense', $_POST['defense'], '', false );
	$otherstat = $edit->add_update( $id, 'otherstat', $_POST['otherstat'], '', false );
	$notes = $edit->add_update( $id, 'notes', $_POST['notes'], '', false );
	$keyword = $edit->add_update( $id, 'keyword', $_POST['keyword'], '', false );
	$credits = $edit->add_update( $id, 'credits', $_POST['credits'], '', false );
	
	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p style="text-align:center;">' . $edit->error_mess . '</p>' . NL;
		echo '<p style="text-align:center;"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		$ses->record_act( 'Item Database', 'Edit', $name );
		echo '<p style="text-align:center;">Entry successfully edited on Zybez.</p>' . NL;
		header( 'refresh: 2; url=' . $_SERVER['PHP_SELF'] );
	}
	
}
elseif( isset( $_POST['act'] ) AND $_POST['act'] == 'new' ) {


	$_POST['weight'] = $_POST['weight'] == '?' ? -21.0 : floatval($_POST['weight']);

	$name = $edit->add_new( 1, 'name', $_POST['name'], '', false );
	$image = $edit->add_new( 1, 'image', $_POST['image'], '', false );
	$type = $edit->add_new( 1, 'type', $_POST['type'], '', false );
	$member = $edit->add_new( 1, 'member', $_POST['member'], '', false );
	$trade = $edit->add_new( 1, 'trade', $_POST['trade'], '', false );
	$equip = $edit->add_new( 1, 'equip', $_POST['equip'], '', false );
	$weight = $edit->add_new( 1, 'weight', $_POST['weight'], '', false );
	$examine = $edit->add_new( 1, 'examine', $_POST['examine'], '', false );
	$quest = $edit->add_new( 1, 'quest', $_POST['quest'], '', false );
	$obtain = $edit->add_new( 1, 'obtain', $_POST['obtain'], '', false );
	//$market = $edit->add_new( 1, 'market', $_POST['market'], '', false );
	$highalch = $edit->add_new( 1, 'highalch', $_POST['highalch'], '', false );
	$lowalch = $edit->add_new( 1, 'lowalch', $_POST['lowalch'], '', false );
	$sellgen = $edit->add_new( 1, 'sellgen', $_POST['sellgen'], '', false );
	$buygen = $edit->add_new( 1, 'buygen', $_POST['buygen'], '', false );
	$keepdrop = $edit->add_new( 1, 'keepdrop', $_POST['keepdrop'], '', false );
	$retrieve = $edit->add_new( 1, 'retrieve', $_POST['retrieve'], '', false );
	$questuse = $edit->add_new( 1, 'questuse', $_POST['questuse'], '', false );
	$attack = $edit->add_new( 1, 'attack', $_POST['attack'], '', false );
	$defense = $edit->add_new( 1, 'defense', $_POST['defense'], '', false );
	$otherstat = $edit->add_new( 1, 'otherstat', $_POST['otherstat'], '', false );
	$notes = $edit->add_new( 1, 'notes', $_POST['notes'], '', false );
	$keyword = $edit->add_new( 1, 'keyword', $_POST['keyword'], '', false );
	$credits = $edit->add_new( 1, 'credits', $_POST['credits'], '', false );
	
	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p style="text-align:center;">' . $edit->error_mess . '</p>' . NL;
		echo '<p style="text-align:center;"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		$ses->record_act( 'Item Database', 'New', $name );
		echo '<p style="text-align:center;">New entry was successfully added to Zybez.</p>' . NL;
		header( 'refresh: 2; url=' . $_SERVER['PHP_SELF'] );
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
	 
			$name = $info['name'];
			$image = $info['image'];
			$type = $info['type'];
			$member = $info['member'];
			$trade = $info['trade'];
			$equip = $info['equip'];
			$weight = $info['weight'];
			$examine = $info['examine'];
			$quest = $info['quest'];
			$obtain = $info['obtain'];
			//$market = $info['market'];
			$highalch = $info['highalch'];
			$lowalch = $info['lowalch'];
			$sellgen = $info['sellgen'];
			$buygen = $info['buygen'];
			$keepdrop = $info['keepdrop'];
			$retrieve = $info['retrieve'];
			$questuse = $info['questuse'];
			$attack = $info['attack'];
			$defense = $info['defense'];
			$otherstat = $info['otherstat'];
			$notes = $info['notes'];
			$keyword = $info['keyword'];
			$credits = $info['credits'];
			
		}
		else {			
			$_GET['act'] = 'new';			
			$name = '';
			$image = 'nopic.gif';
			$type = '3';
			$member = 'Yes';
			$trade = 'Yes';
			$equip = 'Yes';
			$weight = -21.0;
			$examine = '';
			$quest = 'No';
			$obtain = '';
			//$market = '0';
			$highalch = '0';
			$lowalch = '0';
			$sellgen = '0';
			$buygen = '0';
			$keepdrop = '';
			$retrieve = '';
			$questuse = '';
			$attack = 'Stab: +0<br />Slash: +0<br />Crush: +0<br />Magic: +0<br />Ranged: +0';
			$defense = 'Stab: +0<br />Slash: +0<br />Crush: +0<br />Magic: +0<br />Ranged: +0';
			$otherstat = 'Strength: +0<br />Prayer: +0';
			$notes = '';
			$keyword = '';
			$credits = '-';
	
		}
	}
	else {
			$name = '';
			$image = 'nopic.gif';
			$type = '3';
			$member = 'Yes';
			$trade = 'Yes';
			$equip = 'Yes';
			$weight = -21.0;
			$examine = '-';
			$quest = 'No';
			$obtain = '-';
			//$market = '1';
			$highalch = '1';
			$lowalch = '1';
			$sellgen = '1';
			$buygen = '1';
			$keepdrop = '';
			$retrieve = '';
			$questuse = '';
			$attack = 'Stab: +0<br />Slash: +0<br />Crush: +0<br />Magic: +0<br />Ranged: +0';
			$defense = 'Stab: +0<br />Slash: +0<br />Crush: +0<br />Magic: +0<br />Ranged: +0';
			$otherstat = 'Strength: +0<br />Prayer: +0';
			$notes = 'None';
			$keyword = '';
			$credits = '-';
	}

	$weight = $weight == -21.0 ? '?' : $weight;

	echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">' . NL;
	echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />';

	if( $_GET['act'] == 'edit') {
		enum_correct( 'items', $id );	
		echo '<input type="hidden" name="id" value="' . $id . '" />';
		}
		
	if( $type == 1)		{
	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000000; border-top: none;" cellpadding="4" align="center">' . NL;
	echo '<tr>' . NL ;
	echo '<td colspan="3" class="tabletop">Name: <input type="text" size="35" name="name" autocomplete="off" value="' . $name . '" /></td></tr>' . NL;
	echo '<tr>' . NL ;
    echo '<td rowspan="13" class="tablebottom" style="border-bottom: none;">Image: <input type="text" size="30" name="image" autocomplete="off" value="' . $image . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="15%"><b>Type:</b></td><td><input type="text" size="5" name="type" value="' . $type . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td width="15%"><b>Member:</b></td><td><input type="checkbox" name="member" value="' . $member . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Tradable:</b></td><td><input type="checkbox" name="trade" value="' . $trade . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Equipable:</b></td><td><input type="checkbox" name="equip" value="' . $equip . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td><b>Weight:</b></td><td><input type="text" size="5" name="weight" value="' . $weight . '" />kg</td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td width="20%" valign="top"><b>High Alchemy:</b></td><td><input type="text" size="20" name="highalch" value="' .$info['highalch'] . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td valign="top"><b>Low Alchemy:</b></td><td><input type="text" size="20" name="lowalch" value="' . $info['lowalch'] . '" /></td></tr>' . NL;	
	//echo '<tr>' . NL;
	//echo '<td valign="top"><b>Market Price:</b></td><td><input type="text" size="60" name="market" value="' . $info['market'] . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td valign="top"><b>Sell Gen:</b></td><td><input type="text" size="20" name="sellgen" value="' . $info['sellgen'] . '" /></td></tr>' . NL;
       echo '<tr>' . NL;
	echo '<td valign="top"><b>Buy Gen:</b></td><td><input type="text" size="20" name="buygen" value="' . $info['buygen'] . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td><b>Quest:</b></td><td><input type="text" size="60" name="quest" value="' . $quest . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Examine:</b></td><td><input type="text" size="60" name="examine" value="' . $examine . '" /></td></tr>'. NL;
	echo '</table><br />' . NL;
	
		echo '<center><input type="submit" value="Submit All" /></center><br />' . NL;

	echo '<table cellspacing="0" width="80%" style="border: 1px solid #000000;" cellpadding="4" align="center">' . NL;
	echo '<tr>' . NL;
	echo '<td width="20%" valign="top"><b>Attack bonus:</b></td><td><input type="text" size="90" name="attack" value="' . $attack . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="20%" valign="top"><b>Defence bonus:</b></td><td><input type="text" size="90" name="defense" value="' . $defense . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="20%" valign="top"><b>Other Stat:</b></td><td><input type="text" size="50" name="otherstat" value="' . $otherstat . '" /></td></tr>' . NL;
	echo '</table><br />' . NL;
	echo '<table cellspacing="0" width="80%" style="border: 1px solid #000000;" cellpadding="4" align="center">' . NL;
	
	echo '<tr>' . NL;
	echo '<td width="20%" valign="top"><b>Obtained from:</b></td><td><input type="text" size="80" name="obtain" value="' . $obtain . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td valign="top"><b>Notes:</b></td><td><textarea style="font: 10px Verdana, Arial, Helvetica, sans, sans serif;" name="notes" cols="76" rows="5">' .  $info['notes'] . '</textarea></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="15%"><b>Keywords:</b></td><td align="left"><input type="text" size="80" name="keyword" value="' . $keyword . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="15%"><b>Credits:</b></td><td align="left"><input type="text" size="80" name="credits" value="' . $credits . '" /></td></tr>' . NL;
	echo '</table><br />' . NL;
		}
	elseif($type == 2)		{
	
	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000000; border-top: none;" cellpadding="4" align="center">' . NL;
	echo '<tr>' . NL ;
	echo '<td colspan="3" class="tabletop">Name: <input type="text" size="35" name="name" autocomplete="off" value="' . $name . '" /></td></tr>' . NL;
	echo '<tr>' . NL ;
    echo '<td rowspan="11" class="tablebottom" style="border-bottom: none;">Image: <input type="text" size="30" name="image" autocomplete="off" value="' . $image . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="15%"><b>Type:</b></td><td><input type="text" size="5" name="type" autocomplete="off" value="' . $type . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td width="15%"><b>Member:</b></td><td><input type="text" size="5" name="member" autocomplete="off" value="' . $member . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Tradable:</b></td><td><input type="text" size="5" name="trade" autocomplete="off" value="' . $trade . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Equipable:</b></td><td><input type="text" size="5" name="equip" value="' . $equip . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td><b>Weight:</b></td><td><input type="text" size="5" name="weight" value="' . $weight . '" />kg</td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Quest:</b></td><td><input type="text" size="60" name="quest" value="' . $quest . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Examine:</b></td><td><input type="text" size="60" name="examine" value="' . $examine . '" /></td></tr>'. NL;
	echo '</table><br />' . NL;
	
	echo '<center><input type="submit" value="Submit All" /></center><br />' . NL;

	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000000;" cellpadding="4" align="center">' . NL;
	echo '<tr>' . NL;
	echo '<td width="20%" valign="top"><b>Obtained from:</b></td><td><input type="text" size="80" name="obtain" value="' . $obtain . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="20%" valign="top"><b>Attack bonus:</b></td><td><input type="text" size="80" name="attack" value="' . $attack . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="20%" valign="top"><b>Defence bonus:</b></td><td><input type="text" size="80" name="defense" value="' . $defense . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="20%" valign="top"><b>Other Stat:</b></td><td><input type="text" size="50" name="otherstat" value="' . $otherstat . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="20%" valign="top"><b>Keep or Drop:</b></td><td><input type="text" size="80" name="keepdrop" value="' . $keepdrop . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="20%" valign="top"><b>Retrieval:</b></td><td><input type="text" size="80" name="retrieve" value="' . $retrieve . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="20%" valign="top"><b>Uses:</b></td><td><input type="text" size="80" name="questuse" value="' . $questuse . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td valign="top"><b>Notes:</b></td><td><textarea style="font: 10px Verdana, Arial, Helvetica, sans, sans serif;" name="notes" cols="76" rows="5">' .  $info['notes'] . '</textarea></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="15%"><b>Keywords:</b></td><td align="left"><input type="text" size="80" name="keyword" value="' . $keyword . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="15%"><b>Credits:</b></td><td align="left"><input type="text" size="80" name="credits" value="' . $credits . '" /></td></tr>' . NL;
	echo '</table><br />' . NL;
							}
							
	elseif($type == 3)		{
	
	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000000; border-top: none;" cellpadding="4" align="center">' . NL;
	echo '<tr>' . NL ;
	echo '<td colspan="3" class="tabletop">Name: <input type="text" size="35" name="name" autocomplete="off" value="' . $name . '" /></td></tr>' . NL;
	echo '<tr>' . NL ;
    echo '<td rowspan="13" class="tablebottom" style="border-bottom: none;">Image: <input type="text" size="30" name="image" autocomplete="off" value="' . $image . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="15%"><b>Type:</b></td><td><input type="text" size="5" name="type" autocomplete="off" value="' . $type . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td width="15%"><b>Member:</b></td><td><input type="text" size="5" name="member" autocomplete="off" value="' . $member . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Tradable:</b></td><td><input type="text" size="5" name="trade" autocomplete="off" value="' . $trade . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Equipable:</b></td><td><input type="text" size="5" name="equip" value="' . $equip . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td><b>Weight:</b></td><td><input type="text" size="5" name="weight" value="' . $weight . '" />kg</td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td width="20%" valign="top"><b>High Alchemy:</b></td><td><input type="text" size="20" name="highalch" value="' .$info['highalch'] . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td valign="top"><b>Low Alchemy:</b></td><td><input type="text" size="20" name="lowalch" value="' . $info['lowalch'] . '" /></td></tr>' . NL;	
	//echo '<tr>' . NL;
	//echo '<td valign="top"><b>Market Price:</b></td><td><input type="text" size="40" name="market" value="' . $info['market'] . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td valign="top"><b>Sell Gen:</b></td><td><input type="text" size="20" name="sellgen" value="' . $info['sellgen'] . '" /></td></tr>' . NL;
       echo '<tr>' . NL;
	echo '<td valign="top"><b>Buy Gen:</b></td><td><input type="text" size="20" name="buygen" value="' . $info['buygen'] . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td><b>Quest:</b></td><td><input type="text" size="60" name="quest" value="' . $quest . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Examine:</b></td><td><input type="text" size="60" name="examine" value="' . $examine . '" /></td></tr>'. NL;
	echo '</table><br />' . NL;
	
	echo '<center><input type="submit" value="Submit All" /></center><br />' . NL;

	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000000;" cellpadding="4" align="center">' . NL;
	echo '<tr>' . NL;
	echo '<td width="20%" valign="top"><b>Obtained from:</b></td><td><input type="text" size="80" name="obtain" value="' . $obtain . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td valign="top"><b>Notes:</b></td><td><textarea style="font: 10px Verdana, Arial, Helvetica, sans, sans serif;" name="notes" cols="76" rows="5">' .  $info['notes'] . '</textarea></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="15%"><b>Keywords:</b></td><td align="left"><input type="text" size="80" name="keyword" value="' . $keyword . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="15%"><b>Credits:</b></td><td align="left"><input type="text" size="80" name="credits" value="' . $credits . '" /></td></tr>' . NL;
	echo '</table><br />' . NL;
}
	else		{
	
	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000000; border-top: none;" cellpadding="4" align="center">' . NL;
	echo '<tr>' . NL ;
	echo '<td colspan="3" class="tabletop">Name: <input type="text" size="35" name="name" autocomplete="off" value="' . $name . '" /></td></tr>' . NL;
	echo '<tr>' . NL ;
    echo '<td rowspan="11" class="tablebottom" style="border-bottom: none;">Image: <input type="text" size="30" name="image" autocomplete="off" value="' . $image . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="15%"><b>Type:</b></td><td><input type="text" size="5" name="type" autocomplete="off" value="' . $type . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td width="15%"><b>Member:</b></td><td><input type="text" size="5" name="member" autocomplete="off" value="' . $member . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Tradable:</b></td><td><input type="text" size="5" name="trade" autocomplete="off" value="' . $trade . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Equipable:</b></td><td><input type="text" size="5" name="equip" value="' . $equip . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td><b>Weight:</b></td><td><input type="text" size="5" name="weight" value="' . $weight . '" />kg</td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td width="20%" valign="top"><b>High Alchemy:</b></td><td><input type="text" size="20" name="highalch" value="' .$info['highalch'] . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td valign="top"><b>Low Alchemy:</b></td><td><input type="text" size="20" name="lowalch" value="' . $info['lowalch'] . '" /></td></tr>' . NL;	
	//echo '<tr>' . NL;
	//echo '<td valign="top"><b>Market Price:</b></td><td><input type="text" size="40" name="market" value="' . $info['market'] . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td><b>Quest:</b></td><td><input type="text" size="60" name="quest" value="' . $quest . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Examine:</b></td><td><input type="text" size="60" name="examine" value="' . $examine . '" /></td></tr>'. NL;
	echo '</table><br />' . NL;
	
	echo '<center><input type="submit" value="Submit All" /></center><br />' . NL;

	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000000;" cellpadding="4" align="center">' . NL;
	echo '<tr>' . NL;
	echo '<td width="20%" valign="top"><b>Obtained from:</b></td><td><input type="text" size="80" name="obtain" value="' . $obtain . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td valign="top"><b>Notes:</b></td><td><textarea style="font: 10px Verdana, Arial, Helvetica, sans, sans serif;" name="notes" cols="76" rows="5">' .  $info['notes'] . '</textarea></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="15%"><b>Keywords:</b></td><td align="left"><input type="text" size="80" name="keyword" value="' . $keyword . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td width="15%"><b>Credits:</b></td><td align="left"><input type="text" size="80" name="credits" value="' . $credits . '" /></td></tr>' . NL;
	echo '</table><br />' . NL;
}
	echo '</form>' . NL;
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
			$ses->record_act( 'Item Database', 'Delete', $_POST['del_name'] );
			header( 'refresh: 2; url=' . $_SERVER['PHP_SELF'] );
			echo '<p style="text-align:center;">Entry successfully deleted from Zybez.</p>' . NL;
		}
	}
	else {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM `items` WHERE id = " . $id );
	
		if( $info ) {
		
			$name = $info['name'];
			echo '<p style="text-align:center;">Are you sure you want to delete the item, \'' . $name . '\'?</p>';
			echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?act=delete"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>' . NL;
			echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '"><center><input type="submit" value="No" /></center></form>' . NL;
		}
		else {
			
			echo '<p style="text-align:center;">That identification number does not exist.</p>' . NL;
		}
	}
}
else {

	if( isset( $_GET['category'] ) and isset( $_GET['search_area'] ) and ( $_GET['category'] == 'name' or $_GET['category'] == 'image' or $_GET['category'] == 'obtain' or $_GET['category'] == 'type' or $_GET['category'] == 'notes' or $_GET['category'] == 'examine' ) ) {
		$category = $_GET['category'];
	}
	else {
		$category = 'name';
	}
		if( isset( $_GET['search_area'] ) and ( $_GET['search_area'] != 'itemsearch' and $_GET['search_area'] == 'name' or $_GET['search_area'] == 'image' or $_GET['search_area'] == 'obtain' or $_GET['search_area'] == 'type' or $_GET['search_area'] == 'notes' or $_GET['search_area'] == 'examine' ) ) {
		$search_term = $_GET['search_term'];
		$search_area = $_GET['search_area'];
		$search = "SELECT * FROM `items` WHERE " . $search_area . " LIKE '%" . $search_term . "%' ORDER BY `name`";
	}
	else {
		$search_term = '';
		$search_area = '';
		$search = "SELECT * FROM `items` WHERE type in (1,2,3) ORDER BY `time` DESC";
	}
	
	if( isset( $_GET['page'] ) ) {
		$page = intval( $_GET['page'] );
	}
	 else {
		$page = '1';
	}
		
	$search_term = stripslashes( $search_term );

	$entries_per_page = 50;
	$entry_count = mysql_num_rows( $db->query( $search ) );
	$page_count = ceil( $entry_count / $entries_per_page );
	$page_links = '';
	$current_page = 0;
		while( $current_page < $page_count ) {
		$current_page++;
		if( $current_page == $page ) {
			$page_links = '' . $page_links . '<b>['. $current_page . ']</b> ';
		}
		else {
			$page_links = $page_links . '<a href="' . $_SERVER['PHP_SELF'] . '?page=' . $current_page . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '">'. $current_page . '</a> ';
			}
	}

	if( $page_count > 1 AND $page > 1 )
	{
		  $page_before = $page - 1;
		  $page_links = '<a href="' . $_SERVER['PHP_SELF']. '?page=' . $page_before . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '">< Previous</a> ' . $page_links;
	}

  	if( $page_count > 1 AND $page != $page_count ) {
		  $page_after = $page + 1;
		  $page_links = $page_links . '<a href="' . $_SERVER['PHP_SELF']. '?page=' . $page_after . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '">Next ></a> ';
	}

	$start_from = $page - 1;
	$start_from = $start_from * $entries_per_page;
	$query = $db->query( $search . " LIMIT " . $start_from . ", " . $entries_per_page );

	echo '<p style="text-align:center;"><a href="data/idbinfo.zip">Download Information Pack</a> (and <a href="data/idbimg.zip"><b>item images</b></a> for file names)<br /><b>Only insert newly released items and always check to see if it\'s in the database first.</b><br />You can use <a href="http://tehfreak.net/itemsearch/"><b>this</b></a> website to obtain certain data pertaining to the older items.</p>' . NL;
	echo '<center><form action="' . $_SERVER['PHP_SELF'] . '" method="get">' . NL;
	echo 'Search <select name="search_area">' . NL;
	
	if( $search_area == 'name' ) {
		echo '<option value="name" selected="selected">Name</option>' . NL;
	}
	else {
		echo '<option value="name">Name</option>' . NL;
	}
	if( $search_area == 'image' ) {
		echo '<option value="image" selected="selected">Image</option>' . NL;
	}
	else {
		echo '<option value="image">Image</option>' . NL;
	}
	if( $search_area == 'obtain' ) {
		echo '<option value="obtain" selected="selected">Obtain</option>' . NL;
	}	
	else {
		echo '<option value="obtain">Obtain</option>' . NL;
	}
	if( $search_area == 'type' ) {
		echo '<option value="type" selected="selected">Type</option>' . NL;
	}
	else {
		echo '<option value="type">Type</option>' . NL;
	}
	if( $search_area == 'notes' ) {
		echo '<option value="notes" selected="selected">Notes</option>' . NL;
	}
	else {
		echo '<option value="notes">Notes</option>' . NL;
	}
	if( $search_area == 'examine' ) {
		echo '<option value="examine" selected="selected">Examine</option>' . NL;
	}
	else {
		echo '<option value="examine">Examine</option>' . NL;
	}
	echo '</select> for ' . NL;

	echo '<input type="text" name="search_term" value="' . $search_term . '" maxlength="40" />' . NL;
	echo '<input type="submit" value="Go" />' . NL;
	echo '</form></center><br />' . NL;
	

$total = $db->query("SELECT * FROM `items` where type != 0 ");
$num_total = mysql_num_rows( $total );

$num_complete = 0;
while( $info = $db->fetch_array( $total ) ) {
	if( $info['type'] != 0 && $info['notes'] != '' && $info['image'] != 'nopic.gif' &&  $info['quest'] != '' &&  $info['obtain'] != '' ) {
		$num_complete++;
	}
	elseif( $info['type'] != 0 && $info['image'] !='nopic.gif' && $info['notes'] == '' ) {
		$num_started++;
	}
}

$num_need = $num_total - $num_complete;

$percent_complete = $num_complete / $num_total;
$percent_complete = $percent_complete * 100;
$percent_complete = round( $percent_complete , 2 );

$percent_started = $num_started / $num_total;
$percent_started = $percent_started * 100;
$percent_started = round( $percent_started , 2 );

$percent_needed = 100 - $percent_complete - $percent_started;

?>
	
<table class="boxtop" border="0" cellpadding="1" cellspacing="2" width="100%" style="border: 1px solid black; margin: auto;">
<tr>
<td align="center" colspan="3">To Complete: <?=$num_need?></td>
</tr>
<tr>
<td valign="top" align="center" width="110">Completed: <?=$num_complete?></td>
<td>
<table width="100%" cellpadding="1" cellspacing="0" style="border: 1px solid black;"><tr>
<td bgcolor="#009E00" width="<?=$percent_complete?>%" align="center"><?=$percent_complete?>%</td>
<?

if( $percent_started > 1 ) {
	echo '<td bgcolor="#D4D400" width="' . $percent_started . '" align="center" style="border-left: 1px solid black;">' . $percent_started . '%</td>';
}
else {
	echo '<td bgcolor="#D4D400" align="center" style="border-left: 1px solid black;"></td>';
	//echo '<td bgcolor="#D4D400" width="' . $percent_started . '%" align="center" style="border-left: 1px solid black; text-color: black;">' . $percent_started . '%</td>';
}
?>
<td bgcolor="#B80000" style="border-left: 1px solid black;"><?=$percent_needed?>%</td>
</tr></table>
</td>
<td valign="top" align="center" width="110">Total: <?=$num_total?></td>
</tr>
<tr>
<td align="center" colspan="3">Incomplete/Started: <?=$num_started?> ( <a href="<?=$_SERVER['PHP_SELF']?>?act=incomplete">View</a> )</td>
</tr>

</table><br />

	<table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="1" cellspacing="0">
	<tr class="boxtop">
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Image:</th>
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Name:</th>
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Actions:</th>
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Last Edited (GMT):</th>
	</tr>
	<?
	
if (isset( $_GET['act'] ) AND $_GET['act'] == 'incomplete') {

	$id = intval( $_POST['id'] );
	$sql = $db->query("SELECT * FROM items WHERE type !=0 AND image !='nopic.gif' AND notes = '' ORDER BY `id` DESC");
	$srch = 'Incomplete/Started Items';
	$num = mysql_num_rows( $sql );
	if( $num > 0 ) {
			echo '<p><b>Searching for</b>: '.$srch.'</p>' . NL;
while($info = $db->fetch_array( $sql ) ) {
		
		echo '<tr align="center">';
		echo '<td class="tablebottom"><img src="/img/idbimg/' . $info['image'] . '" alt="Item Image" /></td>';
		echo '<td class="tablebottom"><a href="/beta_items.php?id=' . $info['id'] . '" title="View Item" target="item_view">' . $info['name'] . '</a></td>';
		echo '<td class="tablebottom"><a href="' . $_SERVER['PHP_SELF'] . '?act=edit&amp;id=' . $info['id'] . '" title="Edit ' . $info['name'] . '">Edit</a>';

		if( $ses->permit( 15 ) ) {
			echo ' / <a href="' . $_SERVER['PHP_SELF'] . '?act=delete&amp;id=' . $info['id'] . '" title="Delete \'' . $info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td class="tablebottom">' . format_time( $info['time'] ) . '</td>' . NL;
		echo '</tr>' . NL;
}}}

elseif (isset( $_GET['act'] ) AND $_GET['act'] == 'nystarted') {

	$id = intval( $_POST['id'] );
	$sql2 = $db->query("SELECT * FROM items WHERE type !=0 AND image ='nopic.gif' AND notes = '' ORDER BY `id` DESC");
	$srch2 = 'Not yet started items';
	$num2 = mysql_num_rows( $sql2 );
	if( $num2 > 0 ) {
			echo '<p><b>Searching for</b>: '.$srch2.'</p>' . NL;
while($info = $db->fetch_array( $sql2 ) ) {
		
		echo '<tr align="center">';
		echo '<td class="tablebottom"><img src="/img/idbimg/' . $info['image'] . '" alt="Item Image" /></td>';
		echo '<td class="tablebottom"><a href="/beta_items.php?id=' . $info['id'] . '" title="View Item" target="item_view">' . $info['name'] . '</a></td>';
		echo '<td class="tablebottom"><a href="' . $_SERVER['PHP_SELF'] . '?act=edit&amp;id=' . $info['id'] . '" title="Edit ' . $info['name'] . '">Edit</a>';

		if( $ses->permit( 15 ) ) {
			echo ' / <a href="' . $_SERVER['PHP_SELF'] . '?act=delete&amp;id=' . $info['id'] . '" title="Delete \'' . $info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td class="tablebottom">' . format_time( $info['time'] ) . '</td>' . NL;
		echo '</tr>' . NL;
}}}

else  {
	while($info = $db->fetch_array( $query ) ) {
	
		echo '<tr align="center">' . NL;
		echo '<td class="tablebottom"><img src="/img/idbimg/' . $info['image'] . '" alt="Item Image" /></td>';
		echo '<td class="tablebottom"><a href="/beta_items.php?id=' . $info['id'] . '" title="View Item" target="item_view">' . $info['name'] . '</a></td>' . NL;
		echo '<td class="tablebottom"><a href="' . $_SERVER['PHP_SELF'] . '?act=edit&amp;id=' . $info['id'] . '" title="Edit ' . $info['name'] . '">Edit</a>';

		if( $ses->permit( 15 ) ) {
			echo ' / <a href="' . $_SERVER['PHP_SELF'] . '?act=delete&amp;id=' . $info['id'] . '" title="Delete \'' . $info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td class="tablebottom">' . format_time( $info['time'] ) . '</td>' . NL;
		echo '</tr>' . NL;
	}
	if( mysql_num_rows( $query ) == 0 ) {
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="4">Sorry, no entries match your search criteria.</td>' . NL;
		echo '</tr>' . NL; 
}}
?>
</table><br />
<?
if (isset( $_GET['act'] ) AND $_GET['act'] == 'incomplete') {
	echo '<p align="center">Incomplete items</p>';
	}
elseif (isset( $_GET['act'] ) AND $_GET['act'] == 'nystarted') {
	echo '<p align="center">Un-started items</p>';
	}
	elseif ( $page_count > 1 ) {
	echo '<p align="center">' . $page_links . '</p>';
}
}

echo '<br /></div>'. NL;

end_page();
?>