<?php

require( 'backend.php' );
require( 'edit_class.php' );
start_page( 16, 'Monster Database' );

$edit = new edit( 'monsters', $db );

echo '<div class="boxtop">Monster Database</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;

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
## COPY CODE ##
if(isset($_GET['act']) && isset($_GET['copy']) || $_GET['act'] == 'edit') { $id = intval($_GET['id']); echo '<a href="?copy&amp;id='.$id.'"><img src="images/copy.gif" onclick="formChanged = true;" hspace="5" title="Copy" border="0" /></a>'; }
## COPY CODE ##
?><a href=""><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="?act=new"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; Monster Database</font></b>
</div>
<hr class="main" noshade="noshade" align="left" />
<?php
## COPY CODE ##
if(isset($_GET['copy']) || $_POST['copy']) {
$db->query("INSERT INTO monsters (name, img, race, member, quest, combat, hp, maxhit, nature, attstyle, examine, locations, drops, i_drops, tactic, notes, credits, keyword, time, complete, npc, training, hdimg) (SELECT name, img, race, member, quest, combat, hp, maxhit, nature, attstyle, examine, locations, drops, i_drops, tactic, notes, credits, keyword, (UNIX_TIMESTAMP()+21600), complete, npc, training, hdimg FROM monsters WHERE id = ". $_GET['id'].")");
$names = reset($db->query('SELECT name FROM monsters WHERE id = '.$_GET['id']));
$ses->record_act( 'Monster Database', 'Duplicate', $names, $ip );
header( 'Location: ');
}
## COPY CODE ##
?>
<br /><div class="notice">Do not edit in image file names. Whenever the manager moves the file, he/she will put in the image.</div>
<div align="center"><a href="/editor/monsters_queries.php"><b>Click here to find stuff that needs doing.</b></a></div><br />

<b>Instructions:</b> <a href="#" onclick=hide('tohide')>Show/Hide</a><br />
<div id="tohide" style="display:none"><p><strong>Monster Database:</strong> When editing the monsters in the database, follow a few of these steps.<br /><em>NOTE: As you go through the monsters though, put a ? or a # in the text or number cells respectively, if you do not know a value.</em>

<ol>
<li>Name capitalisation: ONLY first name if it's a  If it's an NPC unique name, capitalise both. EG: Torag the Corrupted, Pee Hat, Saradomin wizard, Dark beast, etc.</li>
<li>Race: You can choose from: Animal, Beast, Demon, Dragon, Dwarf, Giant, Goblin, Human, Bug, Gnome, Elven, Undead (need more...)</li>
<li>Members: Check the checkbox for Yes, otherwise it's not.</li>
<li>Attackable: CHECK the checkbox for Yes - this is necessary if we decide to incorporate normal NPCs into it.</li>
<li>Quest: Only if the NPC is part of a quest, ie: black knight titan (otherwise put: No). Put the EXACT name of the quest (as on OSRS RuneScape Help quest guides) - no link required.</li>
<li>Nature: By default, it is set to "Not Aggressive." Delete the `Not` if it is aggressive.</li>
<li>Image: Links will probably be given to you, or take pics and post them in images to upload.</li>
<li>Attack style: Use ONLY the following exactly as they are (WITHOUT quotations): <b>"Melee", "Magic", "Range", "Mage and Range", "Magic and Melee", "Melee and Range", "Melee, Mage and Range". If it's N/A, uncheck the "Attackable" checkbox.</b></li>
<li>Where found: All locations they are found, separated by semi-colon (;) Eg: Slayer Tower, north of Canifis; Brimhaven dungeon, southwest of Brimhaven; Lava maze, level 44 Wilderness north of Edgeville.</li>
<li><b>Drops:</b> Names must be same as item database entry names. List the drops in order of most common as possible; make bones and coins first if applicable. Always capitalise the first letter of the first word, never the second word (exception: if first word is not part of item's name, don't capitalise it). Group like items (metal-types, runes, ores, etc). Also use numbers in brackets Eg: Air runes (5), Clue scroll (level-3), Coins (1-3000) etc.</li>
<li>Tactic: What you should wear and bring to fight them (only for higher level NPCs). You can say for higher level monsters "Not good for training"</li>
<li>Notes: Examples: If they poison you, can block your path, or are slayer monsters (give levels required to kill, as well as any slayer items required), any other information about them NOT covered in other sections.</li>
<li>Keyword: Similar to the item database, add any common mis-spellings or other names given to these NPCs, do NOT put their `Name` in the keywords (search uses the name field and keywords, no need for duplication)..</li>
<li>Credits: Always separate names with a semi-colon (;). Eg: Ben_Goten78; TheExtremist; Damea etc.</li>
</ol></p></div>
<?php


if( isset( $_POST['act'] ) AND $_POST['act'] == 'edit' AND isset( $_POST['id'] ) ) {

	$id = intval( $_POST['id'] );

	$name = $edit->add_update( $id, 'name', $_POST['name'], '', false );
	$img = $edit->add_update( $id, 'img', $_POST['img'], '', false );
	$race = $edit->add_update( $id, 'race', $_POST['race'], '', false );
	$member = $edit->add_update( $id, 'member', isset($_POST['member']) ? 1 : 0, '', false );
	$quest = $edit->add_update( $id, 'quest', $_POST['quest'], '', false );
	$combat = $edit->add_update( $id, 'combat', $_POST['combat'], '', false );
	$hp = $edit->add_update( $id, 'hp', $_POST['hp'], '', false );
	$maxhit = $edit->add_update( $id, 'maxhit', $_POST['maxhit'], '', false );
	$nature = $edit->add_update( $id, 'nature', $_POST['nature'], '', false );
	$attstyle = $edit->add_update( $id, 'attstyle', $_POST['attstyle'], '', false );
	$examine = $edit->add_update( $id, 'examine', $_POST['examine'], '', false );
	$locations = $edit->add_update( $id, 'locations', $_POST['locations'], '', false );
	$drops = $edit->add_update( $id, 'drops', $_POST['drops'], '', false );
	$i_drops = $edit->add_update( $id, 'i_drops', $_POST['i_drops'], '', false );
	$tactic = $edit->add_update( $id, 'tactic', $_POST['tactic'], '', false );
	$notes = $edit->add_update( $id, 'notes', $_POST['notes'], '', false );
	$keyword = $edit->add_update( $id, 'keyword', $_POST['keyword'], '', false );
	$credits = $edit->add_update( $id, 'credits', $_POST['credits'], '', false );
	$hdimg = $edit->add_update( $id, 'hdimg', isset($_POST['hdimg']) ? 1 : 0, '', false );
//if( $ses->permit( 18 ) ) {
	$complete = $edit->add_update( $id, 'complete', isset($_POST['complete']) ? 1 : 0, '', false );
//}
	$npc = $edit->add_update( $id, 'npc', isset($_POST['npc']) ? 1 : 0, '', false );
	
	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p style="text-align:center;">' . $edit->error_mess . '</p>' . NL;
		echo '<p style="text-align:center;"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		$ses->record_act( 'Monster Database', 'Edit', $name, $ip );
		echo '<p style="text-align:center;">Entry successfully edited on OSRS RuneScape Help.</p>' . NL;
		//header( 'refresh: 2; url=' . );
	}
	
}
elseif( isset( $_POST['act'] ) AND $_POST['act'] == 'new' ) {

	$name = $edit->add_new( 1, 'name', $_POST['name'], '', false );
	$img = $edit->add_new( 1, 'img', $_POST['img'], '', false );
	$race = $edit->add_new( 1, 'race', $_POST['race'], '', false );
	$member = $edit->add_new( 1, 'member', isset($_POST['member']) ? 1 : 0, '', false );
	$quest = $edit->add_new( 1, 'quest', $_POST['quest'], '', false );
	$combat = $edit->add_new( 1, 'combat', $_POST['combat'], '', false );
	$hp = $edit->add_new( 1, 'hp', $_POST['hp'], '', false );
	$maxhit = $edit->add_new( 1, 'maxhit', $_POST['maxhit'], '', false );
	$nature = $edit->add_new( 1, 'nature', $_POST['nature'], '', false );
	$attstyle = $edit->add_new( 1, 'attstyle', $_POST['attstyle'], '', false );
	$examine = $edit->add_new( 1, 'examine', $_POST['examine'], '', false );
	$locations = $edit->add_new( 1, 'locations', $_POST['locations'], '', false );
	$drops = $edit->add_new( 1, 'drops', $_POST['drops'], '', false );
	$i_drops = $edit->add_new( 1, 'i_drops', $_POST['i_drops'], '', false );
	$tactic = $edit->add_new( 1, 'tactic', $_POST['tactic'], '', false );
	$notes = $edit->add_new( 1, 'notes', $_POST['notes'], '', false );
	$keyword = $edit->add_new( 1, 'keyword', $_POST['keyword'], '', false );
	$credits = $edit->add_new( 1, 'credits', $_POST['credits'], '', false );
	$hdimg = $edit->add_new( 1, 'hdimg', isset($_POST['hdimg']) ? 1 : 0, '', false );
//if( $ses->permit( 18 ) ) {
	$complete = $edit->add_new( 1, 'complete', isset($_POST['complete']) ? 1 : 0, '', false );
//}
	$npc = $edit->add_new( 1, 'npc', isset($_POST['npc']) ? 1 : 0, '', false );
	
	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p style="text-align:center;">' . $edit->error_mess . '</p>' . NL;
		echo '<p style="text-align:center;"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		$ses->record_act( 'Monster Database', 'New', $name, $ip );
		echo '<p style="text-align:center;">New entry was successfully added to OSRS RuneScape Help.</p>' . NL;
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
		$info = $db->fetch_row( "SELECT * FROM monsters WHERE id = " . $id );
		
		if( $info ) {

			$name = $info['name'];
			$img = $info['img'];
			$combat = $info['combat'];
			$hp = $info['hp'];
			$maxhit = $info['maxhit'];
			$race = $info['race'];
			$member = $info['member'];
			$quest = $info['quest'];
			$nature = $info['nature'];
			$attstyle = $info['attstyle'];
			$examine = $info['examine'];
			$locations = $info['locations'];
			$drops = $info['drops'];
			$i_drops = $info['i_drops'];
			$tactic = $info['tactic'];
			$notes = $info['notes'];
			$keyword = $info['keyword'];
			$credits = $info['credits'];
			//if( $ses->permit( 18 ) ) { $complete = $info['complete']; }
			$complete = $info['complete']; //to remove perms
			$npc = $info['npc'];
			$hdimg = $info['hdimg'];
			
		}
		else {
			$_GET['act'] = 'new';
			$name = '';
			$img = 'nopic.gif';
			$combat = '1';
			$hp = '1';
			$maxhit = '1';
			$race = '-';
			$member = 1;
			$quest = 'No';
			$nature = 'Not Aggressive';
			$attstyle = '-';
			$examine = '-';
			$locations = '-';
			$credits = '-';
			//if( $ses->permit( 18 ) ) { $complete = 1; }
			$complete = 1; //to remove perms
			$npc = 1;
			$hdimg = 0;
		}
	}
	else {
			$name = '';
			$img = 'nopic.gif';
			$combat = '1';
			$hp = '1';
			$maxhit = '1';
			$race = '-';
			$member = 1;
			$quest = 'No';
			$nature = 'Not Aggressive';
			$attstyle = '-';
			$examine = '-';
			$locations = '-';
			$credits = '-';
			//if( $ses->permit( 18 ) ) { $complete = 1; }
			$complete = 1; //to remove perms
			$npc = 1;
			$hdimg = 0;
	}

	echo '<form method="post" action="">' . NL;
	echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />';
	
	if( $_GET['act'] == 'edit' ) {
		enum_correct( 'monsters', $id );	
		echo '<input type="hidden" name="id" value="' . $id . '" />';
$sel = $info['member'] == 1 ? ' checked="checked"' : '';
if( $ses->permit( 18 ) ) { $selcom = $info['complete'] == 1 ? ' checked="checked"' : ''; } 
$selhdimg = $info['hdimg'] == 1 ? ' checked="checked"' : '';
$selnpc = $info['npc'] == 1 ? ' checked="checked"' : '';
	}

	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000; border-top: none;" cellpadding="4" align="center">' . NL;
	echo '<tr>' . NL ;
	echo '<td colspan="3" class="tabletop" style="border-right:none;">Name: <input type="text" size="35" name="name" autocomplete="off" value="' . $name . '" /></td></tr>' . NL;
	echo '<tr>' . NL ;
    	echo '<td rowspan="11" class="tablebottom" style="border-bottom: none;">Image: <input type="text" size="30" name="img" autocomplete="off" value="' . $img . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td><b>Attackable?</b></td><td><input type="checkbox" name="npc" value"1"'.$selnpc.' /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td width="15%"><b>Combat:</b></td><td><input type="text" size="5" name="combat" autocomplete="off" value="' . $combat . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Hitpoints:</b></td><td><input type="text" size="5" name="hp" autocomplete="off" value="' . $hp . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Max hit:</b></td><td><input type="text" size="5" name="maxhit" autocomplete="off" value="' . $maxhit . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Race:</b></td><td><input type="text" size="10" name="race" value="' . $race . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td><b>Members:</b></td><td><input type="checkbox" name="member" value"1"'.$sel.' /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Quest:</b></td><td><input type="text" size="50" name="quest" value="' . $quest . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Nature:</b></td><td><input type="text" size="30" name="nature" value="' . $nature . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Attack Style:</b></td><td><input type="text" size="30" name="attstyle" value="' . $attstyle . '" /></td></tr>'. NL;
	echo '<tr>' . NL;
	echo '<td><b>Examine:</b></td><td><input type="text" size="50" name="examine" autocomplete="off" value="' . $examine . '" /></td></tr>'. NL;
	
	echo '</table><br /><center>' . NL;
	//if( $ses->permit( 18 ) ) { echo 'Complete? <input type="checkbox" name="complete" value"1"'.$selcom.' /><br />';
//}
    echo 'Complete? <input type="checkbox" name="complete" value"1"'.$selcom.' /><br />';  //remove perms
	//echo 'Is image in HD? <input type="checkbox" name="hdimg" value="1"'.$selhdimg.' /><br />';
	echo '<input type="submit" value="Submit All" /></center><br />' . NL;

	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000;" cellpadding="4" align="center">' . NL;
	echo '<tr>' . NL;
	echo '<td width="20%" valign="top"><b>Where Found:</b></td><td><input type="text" size="74" name="locations" value="' . $locations . '" /></td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td valign="top"><b>Drops:</b></td><td><textarea style="font: 10px Verdana, Arial, Helvetica, sans, sans serif;" name="drops" cols="76" rows="5">' . $info['drops'] . '</textarea><br />LEAVE BLANK IF NO INFO.</td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td valign="top"><b>Top Drops:</b></td><td><textarea style="font: 10px Verdana, Arial, Helvetica, sans, sans serif;" name="i_drops" cols="76" rows="3">' . $info['i_drops'] . '</textarea><br />LEAVE BLANK IF NO INFO.</td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td valign="top"><b>Tactic:</b></td><td><textarea style="font: 10px Verdana, Arial, Helvetica, sans, sans serif;" name="tactic" cols="76" rows="5">' .  $info['tactic'] . '</textarea><br />LEAVE BLANK IF NO INFO.</td></tr>' . NL;
	echo '<tr>' . NL;
	echo '<td valign="top"><b>Notes:</b></td><td><textarea style="font: 10px Verdana, Arial, Helvetica, sans, sans serif;" name="notes" cols="76" rows="5">' .  $info['notes'] . '</textarea><br />LEAVE BLANK IF NO INFO.</td></tr>' . NL;
	echo '<td valign="top"><b>Keywords:</b></td><td><input type="text" size="74" name="keyword" value="' . $keyword . '" /></td></tr>' . NL;
	echo '</table><br />' . NL;

	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000" cellpadding="4" align="center">' . NL;
	echo '<tr>' . NL;
	echo '<td width="15%"><b>Credits:</b></td><td align="left"><input type="text" size="80" name="credits" value="' . $credits . '" /></td></tr>' . NL;
	
	echo '</table><br />' . NL;
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
			$db->query("DELETE FROM monsters WHERE id = " . $_POST['del_id'] );
			$ses->record_act( 'Monster Database', 'Delete', $_POST['del_name'], $ip );
			header( 'refresh: 2; url=');
			echo '<p style="text-align:center;">Entry successfully deleted from OSRS RuneScape Help.</p>' . NL;
		}
	}
	else {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM monsters WHERE id = " . $id );
	
		if( $info ) {
		
			$name = $info['name'];
			echo '<p style="text-align:center;">Are you sure you want to delete the monster, \'' . $name . '\'?</p>';
			echo '<form method="post" action="?act=delete"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>' . NL;
			echo '<form method="post" action=""><center><input type="submit" value="No" /></center></form>' . NL;
		}
		else {
			
			echo '<p style="text-align:center;">That identification number does not exist.</p>' . NL;
		}
	}
}
else {

	if( isset( $_GET['search_area'] ) and ($_GET['search_area'] == 'name' or $_GET['search_area'] == 'img' or $_GET['search_area'] == 'quest' or $_GET['search_area'] == 'locations' or $_GET['search_area'] == 'drops' or $_GET['search_area'] == 'notes' or $_GET['search_area'] == 'credits' ) )  {
   $search_area = addslashes($_GET['search_area']);
   $search_term = isset($_GET['search_term']) ? strip_tags($_GET['search_term']) : '';
	if($search_area == 'name' && $search_term != '') { // Keyword search
		$search_terms_q = str_replace(',', '', addslashes($search_term));
		$search_terms_q = explode(' ', $search_terms_q);
		$search_terms_q[0] = "(name = '".$search_terms_q[0]."' OR name LIKE '%".$search_terms_q[0]."%' OR name LIKE '".$search_terms_q[0]."%' OR name LIKE '%".$search_terms_q[0]."' OR ((keyword = '".$search_terms_q[0]."' OR keyword LIKE '%".$search_terms_q[0]."%' OR keyword LIKE '".$search_terms_q[0]."%' OR keyword LIKE '%".$search_terms_q[0]."') AND keyword != ''))";
		for($num = 1; array_key_exists($num, $search_terms_q); $num++) {
			$search_terms_q[$num] = "AND (name = '".$search_terms_q[$num]."' OR name LIKE '%".$search_terms_q[$num]."%' OR name LIKE '".$search_terms_q[$num]."%' OR name LIKE '%".$search_terms_q[$num]."' OR keyword = '".$search_terms_q[$num]."' OR keyword LIKE '%".$search_terms_q[$num]."%' OR keyword LIKE '".$search_terms_q[$num]."%' OR keyword LIKE '%".$search_terms_q[$num]."') ";
		}
		$search_terms_q = implode('', $search_terms_q);
		##ADDED FOR SEARCHING FOR NON-HD MONSTER IMAGES
		$hdimgstring = '';
		if (isset($_GET['act']) && $_GET['act'] == 'nohdimg') { $hdimgstring = ' AND `hdimg`=0'; }
		##ADDED FOR SEARCHING FOR NON-HD MONSTER IMAGES
		$search = "WHERE ".$search_terms_q.$hdimgstring." ORDER BY `name` ASC";
	}
	else { // Standard search
	  if($_GET['search_area'] == 'drops')
	  { $search = "WHERE `drops` LIKE '%".addslashes($search_term)."%' OR `i_drops` LIKE '%".addslashes($search_term)."%' ORDER BY `name` ASC"; }
	  else
	  { $search = "WHERE ".$search_area." LIKE '%".addslashes($search_term)."%' ORDER BY `name` ASC"; }
	}
}
	else {
		$search_term = '';
		$search_area = '';
		##ADDED FOR SEARCHING FOR NON-HD MONSTER IMAGES
		if (isset($_GET['act']) && $_GET['act'] == 'nohdimg') { $hdimgstring = 'WHERE `hdimg`=0 '; }
		else { $hdimgstring = ''; }
		##ADDED FOR SEARCHING FOR NON-HD MONSTER IMAGES
		$search = $hdimgstring."ORDER BY `time` DESC";
	}
	
		if( isset( $_GET['page'] ) ) {
		$page = intval( $_GET['page'] );
	}
	 else {
		$page = '1';
	}
	$quar = "SELECT * FROM `monsters` " . $search;
	$monster_count = $db->query($quar);
	$entries_per_page = 25; 
	$entry_count = $db->num_rows( $quar );
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
	$quot = "SELECT * FROM `monsters` " . $search . " LIMIT " . $start_from . "," . $entries_per_page;
	$query = $db->query( $quot);
	
	echo '<center><form action="" method="get">' . NL;
	
	##ADDED FOR SEARCHING FOR NON-HD MONSTER IMAGES
	if ($_GET['act'] == 'nohdimg') { 
		echo '<input type="hidden" name="act" value="nohdimg" />' . NL;
	}
	##ADDED FOR SEARCHING FOR NON-HD MONSTER IMAGES
	
	echo 'Search <select name="search_area">' . NL;
	
	if( $search_area == 'name' ) {
		echo '<option value="name" selected="selected">Name</option>' . NL;
	}
	else {
		echo '<option value="name">Name</option>' . NL;
	}
	if( $search_area == 'img' ) {
		echo '<option value="img" selected="selected">Image</option>' . NL;
	}
	else {
		echo '<option value="img">Image</option>' . NL;
	}
	if( $search_area == 'quest' ) {
		echo '<option value="quest" selected="selected">Quest</option>' . NL;
	}
	else {
		echo '<option value="quest">Quest</option>' . NL;
	}	
	if( $search_area == 'locations' ) {
		echo '<option value="locations" selected="selected">Location</option>' . NL;
	}
	else {
		echo '<option value="locations">Location</option>' . NL;
	}
	if( $search_area == 'drops' ) {
		echo '<option value="drops" selected="selected">Drops</option>' . NL;
	}
	else {
		echo '<option value="drops">Drops</option>' . NL;
	}
	if( $search_area == 'notes' ) {
		echo '<option value="notes" selected="selected">Notes</option>' . NL;
	}
	else {
		echo '<option value="notes">Notes</option>' . NL;
	}
	if( $search_area == 'credits' ) {
		echo '<option value="credits" selected="selected">Credits</option>' . NL;
	}
	else {
		echo '<option value="credits">Credits</option>' . NL;
	}
	echo '</select> for ' . NL;

	echo '<input type="text" name="search_term" value="' . (isset($_GET['search_terms']) ? strip_tags($_GET['search_terms']) : '') . '" maxlength="30" />' . NL;
	echo '<input type="submit" value="Go" />' . NL;
	echo '</form></center>' . NL;

$tot = "SELECT * FROM `monsters`";
$total = $db->query($tot);
$num_total = $db->num_rows( $tot );

$num_complete = 0;
$num_started = 0;
while( $info = $db->fetch_array( $total ) ) {
	if( $info['complete'] == 1) {
		$num_complete++;
	}
	elseif( ($info['time'] != 0 OR $info['img'] != 'nopic.gif') && $info['complete'] == 0) {
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
<?php if( $percent_started > 1 ) { ?><td bgcolor="#D4D400" width="<?php echo $percent_started; ?>%" style="border-left: 1px solid black;" align="center"><?php echo $percent_started; ?>%</td>
<?php } else { ?><td bgcolor="#D4D400" align="center" style="border-left: 1px solid black;"></td> <?php } ?>
<td bgcolor="#B80000" style="border-left: 1px solid black;"><?php echo $percent_needed; ?>%</td>
</tr></table>
</td>
<td valign="top" align="center" width="110">Total: <?php echo $num_total; ?></td>
</tr>
<tr>
<td align="center" colspan="3">Incomplete/Started: <?php echo $num_started; ?> ( <a href="?act=incomplete">View</a> )</td>
</tr>
<tr>
<td align="center" colspan="3"><a href="?act=nohdimg">View Monsters Without HD Images</a></td>
</tr>
</table>
<br />


	<table style="border-left: 1px solid #000;" width="100%" cellpadding="1" cellspacing="0">
	<tr>
	<th colspan="2" class="tabletop">Name:</th>
	<th class="tabletop">Combat:</th>
	<th class="tabletop">Actions:</th>
	<th class="tabletop">Last Edited (GMT):</th>
	</tr>
	<?php
if (isset( $_GET['act'] ) AND $_GET['act'] == 'incomplete') { //INCOMPLETE MONSTERS

	$id = intval( $_POST['id'] );
	$squal = "SELECT * FROM monsters WHERE complete = 0 or `time` = 0 ORDER BY name ASC";
	$sql = $db->query($squal);
	$srch = 'Incomplete/Started Monsters';
	$num = $db->num_rows( $squal );
	if( $num > 0 ) {
			echo '<p><b>Searching for</b>: '.$srch.'</p>' . NL;
while($info = $db->fetch_array( $sql ) ) {
if($info['npc'] == 0) $info['combat'] = 'N/A';
		echo '<tr align="center">';
		echo '<td class="tablebottom"><a href="/monsters.php?id=' . $info['id'] . '" title="View Monster" target="monster_view">' . $info['name'] . '</a></td>';
		echo '<td class="tablebottom"><img src="/img/calcimg/a_yellow.PNG" alt="Incomplete" /></td>';
		echo '<td class="tablebottom">' . $info['combat'] . '</a></td>' . NL;
		echo '<td class="tablebottom"><a href="?act=edit&amp;id=' . $info['id'] . '" title="Edit ' . $info['name'] . '">Edit</a>';

		if( $ses->permit( 15 ) ) {
			echo ' / <a href="?act=delete&amp;id=' . $info['id'] . '" title="Delete \'' . $info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td class="tablebottom">' . format_time( $info['time'] ) . '</td>' . NL;
		echo '</tr>' . NL;
				}
		}
}
else {
	while($info = $db->fetch_array( $query ) ) { //NORMAL
if($info['npc'] == 0) $info['combat'] = 'N/A';
		echo '<tr>'.NL;
	if ( $info['complete'] == 1 ) {
		echo '<td id="complete"><a href="/monsters.php?id=' . $info['id'] . '" title="View Monster" target="monster_view">' . $info['name'] . '</a></td>' . NL;
		echo '<td id="complete"><img src="/img/calcimg/a_green.PNG" alt="Completed" /></td>';
		echo '<td id="complete">' . $info['combat'] . '</a></td>' . NL;
		echo '<td id="complete"><a href="?act=edit&amp;id=' . $info['id'] . '" title="Edit ' . $info['name'] . '">Edit</a>';

		if( $ses->permit( 15 ) ) {
			echo ' / <a href="?act=delete&amp;id=' . $info['id'] . '" title="Delete \'' . $info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td id="complete">' . format_time( $info['time'] ) . '</td>' . NL;
		
		} else {
		echo '<td class="tablebottom"><a href="/monsters.php?id=' . $info['id'] . '" title="View Monster" target="monster_view">' . $info['name'] . '</a></td>' . NL;
		if ( $info['time'] == 0 ) {
		echo '<td class="tablebottom"><img src="/img/calcimg/a_red.PNG" alt="Not Started" /></td>';
		} else {
		echo '<td class="tablebottom"><img src="/img/calcimg/a_yellow.PNG" alt="Incomplete" /></td>';
		}
		echo '<td class="tablebottom">' . $info['combat'] . '</a></td>' . NL;
		echo '<td class="tablebottom"><a href="?act=edit&amp;id=' . $info['id'] . '" title="Edit ' . $info['name'] . '">Edit</a>';

		if( $ses->permit( 15 ) ) {
			echo ' / <a href="?act=delete&amp;id=' . $info['id'] . '" title="Delete \'' . $info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td class="tablebottom">' . format_time( $info['time'] ) . '</td>' . NL;
		}
		echo '</tr>' . NL;
	}
	if( $db->num_rows( $quot ) == 0 ) {
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="5">Sorry, no entries match your search criteria.</td>' . NL;
		echo '</tr>' . NL;
	}}
	
	?>
	</table>
	<br />
	<?php
	if(isset( $_GET['act'] ) AND $_GET['act'] == 'incomplete') {
	echo '<p align="center">Incomplete Monsters</p>';
  }
	else {
	echo '<p align="center">' . $page_links . '</p>';
}
}

echo '<br /></div>'. NL;
if(!isset($name)) $name = '';
end_page($name);
?>