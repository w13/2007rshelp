<?php
require( 'backend.php' );
require( 'edit_class.php' );

  $ptitle = 'Equipment Profiles Database';
  $ptable = 'equipment';
  $constraint = '1';
  $categories = in_array($_GET['category'], array('name'));
  $search_areas = in_array($_GET['search_area'], array('name','description'));
  $search_value = array('name','description');
  $search_name = array('Name','Description');

start_page( 23, $ptitle );

$edit = new edit( $ptable, $db );

echo '<div class="boxtop">'.$ptitle.'</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;
?>
<style type="text/css">.item {width:50px;cursor:pointer;}</style>
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

<div style="float: right;">
<a href="<?php echo $_SERVER['PHP_SELF']; ?>"><img src="images/browse.gif" title="Browse" border="0" /></a></div>
<div style="margin:1pt; font-size:large; font-weight:bold;">&raquo; <?php echo $ptitle; ?></div>


<hr class="main" noshade="noshade" align="left" />
<br />

<b>Instructions:</b> <a href="#" onclick=hide('tohide')>Show/Hide</a><br />
<div id="tohide" style="display:none"><p>Introduction text</p>
<ol>
<li>Instruction Listing</li>
</ol></div>

<?php
if( isset( $_POST['act'] ) AND $_POST['act'] == 'edit' AND isset( $_POST['id'] ) ) {

	$id = intval( $_POST['id'] );
	
	$name = $edit->add_update( $id, 'name', $_POST['name'], '', false );
	$itemids = $edit->add_update( $id, 'itemids', $_POST['itemids'], '', false );
	$type = $edit->add_update( $id, 'type', $_POST['type'], '', false );
	$themed = $edit->add_update( $id, 'themed', $_POST['themed'], '', false );
	$cost = $edit->add_update( $id, 'cost', $_POST['cost'], '', false );
	$approved = $edit->add_update( $id, 'approved', $_POST['approved'], '', false );
	$author = $edit->add_update( $id, 'author', $_POST['author'], '', false );
	$description = $edit->add_update( $id, 'description', $_POST['description'], '', false );
	$keyword = $edit->add_update( $id, 'keyword', $_POST['keyword'], '', false );

	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p style="text-align:center;">' . $edit->error_mess . '</p>' . NL;
		echo '<p style="text-align:center;"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		$ses->record_act( $ptitle, 'Edit', $name, $ip );
		echo '<p style="text-align:center;">Entry successfully edited on Zybez.</p>' . NL;
	}
	
}
elseif( isset( $_GET['act'] ) AND ( $_GET['act'] == 'edit' AND isset( $_GET['id'] ) ) ) {

	if( isset( $_POST['del_id'] ) AND $ses->permit( 15 ) ) {
		$edit_item->add_delete( $_POST['del_id'] );
		$execution = $edit_item->run_all( false, false );
		if( !$execution ) {
			echo '<p style="text-align:center;">' . $edit_item->error_mess . '</p>';
		}
	}
	
	if( $_GET['act'] == 'edit' ) {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM ".$ptable." WHERE id = " . $id );
		
		if( $info ) { 
			$name = $info['name'];
			$itemids = $info['itemids'];
			$type = $info['type'];
      $themed = $info['themed'];
      $cost = $info['cost'];			
			$approved = $info['approved'];
			$author = $info['author'];
			$description = $info['description'];
			$keyword = $info['keyword'];
		}
	}

	echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">' . NL;
	echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />';

	if( $_GET['act'] == 'edit') {
		enum_correct( $ptable, $id );	
		echo '<input type="hidden" name="id" value="' . $id . '" />';
    $sel = $info['approved'] == 1 ? ' checked="checked"' : ''; ## Checkboxes
		}

  
   $stuff = $db->fetch_row("SELECT * FROM equipment WHERE id = " . $id);
   $q1 = $db->query("SELECT * FROM items WHERE id IN (".$stuff['itemids'].") ORDER BY equip_type ASC");

$total_stab_att   = 0;
$total_slash_att  = 0;
$total_crush_att  = 0;
$total_mage_att   = 0;
$total_range_att  = 0;
$total_stab_def   = 0;
$total_slash_def  = 0;
$total_crush_def  = 0;
$total_mage_def   = 0;
$total_range_def  = 0;
$total_str_other  = 0;
$total_pray_oth   = 0;

    while($iinfo = $db->fetch_array($q1)) {
    /*** ID ***/
        $iid[]           =    $iinfo['id'];
    /*** NAME ***/
        $names[]           =    $iinfo['name'];
    /*** CREATE TABLE CELL ***/
        $td[]          =    '<td class="item" onclick="window.location=\'items.php?act=edit&amp;id=' . $iinfo['id'] . '\'" style="background:url(\'/img/idbimg/'.$iinfo['image'].'\') no-repeat">';
    /*** WEIGHT ***/
        $weight           +=    $iinfo['weight'];
    /*** MEMBER WATERMARK ***/
        $mstring           =    $iinfo['member'] == 1 ? '<img src="/img/equip-mem.png" alt="" />' : '';
        $table_members    += $iinfo['member'];
        $member[]          =    $mstring;
    /*** CALCULATE STATS ***/
        $attArr            =    explode('|',$iinfo['att']);
        $defArr            =    explode('|',$iinfo['def']);
        $otherArr          =    explode('|',$iinfo['otherb']);
        $total_stab_att   +=    $attArr[0];
        $total_slash_att  +=    $attArr[1];
        $total_crush_att  +=    $attArr[2];
        $total_mage_att   +=    $attArr[3];
        $total_range_att  +=    $attArr[4];
        $total_stab_def   +=    $defArr[0];
        $total_slash_def  +=    $defArr[1];
        $total_crush_def  +=    $defArr[2];
        $total_mage_def   +=    $defArr[3];
        $total_range_def  +=    $defArr[4];
        $total_summo_def  +=    $defArr[5];
        $total_str_other  +=    $otherArr[0];
        $total_pray_oth   +=    $otherArr[1];
    }
    /*** ADD + ***/
        $total_stab_att   =    $total_stab_att >=0 ? '+' . $total_stab_att : $total_stab_att;
        $total_slash_att  =    $total_slash_att >=0 ? '+' . $total_slash_att : $total_slash_att;
        $total_crush_att  =    $total_crush_att >=0 ? '+' . $total_crush_att : $total_crush_att;
        $total_mage_att   =    $total_mage_att >=0 ? '+' . $total_mage_att : $total_mage_att;
        $total_range_att  =    $total_range_att >=0 ? '+' . $total_range_att : $total_range_att;
        $total_stab_def   =    $total_stab_def >=0 ? '+' . $total_stab_def : $total_stab_def;
        $total_slash_def  =    $total_slash_def >=0 ? '+' . $total_slash_def : $total_slash_def;
        $total_crush_def  =    $total_crush_def >=0 ? '+' . $total_crush_def : $total_crush_def;
        $total_mage_def   =    $total_mage_def >=0 ? '+' . $total_mage_def : $total_mage_def;
        $total_range_def  =    $total_range_def >=0 ? '+' . $total_range_def : $total_range_def;
        $total_summo_def  =    $total_summo_def >=0 ? '+' . $total_summo_def : $total_summo_def;
        $total_str_other  =    $total_str_other >=0 ? '+' . $total_str_other : $total_str_other;
        $total_pray_oth   =    $total_pray_oth >=0 ? '+' . $total_pray_oth : $total_pray_oth;
        
        if($table_members >= 8) $table_members = 'Most of this set is members only.';
        elseif($table_members >= 4) $table_members = 'Some of this set is members only.';
        elseif($table_members > 0) $table_members = 'A few of these items are members only.';
        elseif($table_members == 0) $table_members = 'All of this set is available to free players.';

/*** GRAB PRICES -- ONLY GRABS PRICES WITH A PID ***/
        $prices = $db->query("SELECT price_low, price_high FROM price_items WHERE id IN (SELECT pid FROM items WHERE id IN (".$stuff['itemids']."))");    
        while($pinfo = $db->fetch_array($prices)) { ## Calculate total cost of items in set
            $low += $pinfo['price_low'];
            $high += $pinfo['price_high'];
            }
        $price = number_format($low) . ' - ' . number_format($high) . 'gp';
        
/*** SUBMITTER ***/
$staff = $info['submit_type'] == 0 ? ' selected="selected"' : '';
$user  = $info['submit_type'] == 1 ? ' selected="selected"' : '';

	$submit_type_select = '<select name="submit_type">'
                       .'<option value="0" '.$staff.'>Staff</option>'
                       .'<option value="1" '.$user.'>User</option>'
                       .'</select>'. NL;
                  
/*** GROUPS ***/
$unsorted        = $info['themed'] == -1 ? ' selected="selected"': '';
$barrows         = $info['themed'] == 0 ? ' selected="selected"': '';  
$barrows_mg      = $info['themed'] == 1 ? ' selected="selected"': ''; 
$lvl40_70_train  = $info['themed'] == 2 ? ' selected="selected"': ''; 
$lvl70_100_train = $info['themed'] == 3 ? ' selected="selected"': ''; 
$lvl100p_train   = $info['themed'] == 4 ? ' selected="selected"': '';
$best_of_cat     = $info['themed'] == 5 ? ' selected="selected"': ''; //Best Mage, Best Melee..?
$wild_training   = $info['themed'] == 6 ? ' selected="selected"': '';
$pking           = $info['themed'] == 7 ? ' selected="selected"': '';
$pure            = $info['themed'] == 8 ? ' selected="selected"': '';
$clan_warring    = $info['themed'] == 9 ? ' selected="selected"': '';
$boss_killing    = $info['themed'] == 10 ? ' selected="selected"': '';
$skiller         = $info['themed'] == 11 ? ' selected="selected"': '';
$holiday         = $info['themed'] == 12 ? ' selected="selected"': '';
$quest           = $info['themed'] == 13 ? ' selected="selected"': '';
$treasure_trail  = $info['themed'] == 14 ? ' selected="selected"': '';


	$themed_select = '<select name="themed">'
                  .'<option value="-1" '.$unsorted.'>Unsorted</option>'
                  .'<option value="0" '.$barrows.'>Barrows</option>'
                  .'<option value="1" '.$barrows_mg.'>Barrows Mini Game</option>'
                  .'<option value="2" '.$lvl40_70_train.'>40-70 training</option>'
                  .'<option value="3" '.$lvl70_100_train.'>70-100 training</option>'
                  .'<option value="4" '.$lvl100p_train.'>100+ training</option>'
                  .'<option value="5" '.$best_of_cat.'>Best of category</option>'
                  .'<option value="6" '.$wild_training.'>Wilderness training</option>'
                  .'<option value="7" '.$pking.'>PKing</option>'
                  .'<option value="8" '.$pure.'>Combat Pure</option>'
                  .'<option value="9" '.$clan_warring.'>Clan Warring</option>'
                  .'<option value="10" '.$boss_killing.'>Boss Killing</option>'
                  .'<option value="11" '.$skiller.'>Skiller</option>'
                  .'<option value="12" '.$holiday.'>Holiday</option>'
                  .'<option value="13" '.$quest.'>Questing</option>'
                  .'<option value="14" '.$treasure_trail.'>Treasure Trails</option>'
                  .'</select>'. NL;

/*** SUB-GROUPS ***/
    $melee  = $info['type'] == 0 ? ' selected="selected"': '';  
    $range  = $info['type'] == 1 ? ' selected="selected"': ''; 
    $magic  = $info['type'] == 2 ? ' selected="selected"': ''; 
    $multi  = $info['type'] == 3 ? ' selected="selected"': '';
    
	$type_select = '<select name="type">'
                  .'<option value="0" '.$melee.'>Melee</option>'
                  .'<option value="1" '.$range.'>Range</option>'
                  .'<option value="2" '.$magic.'>Magic</option>'
                  .'<option value="3" '.$multi.'>Multiple</option>'
                  .'</select>'. NL;
    
/*** ORDERED-BY ***/
      $cheap  = $info['cost'] == 0 ? ' selected="selected"': '';  
      $mid    = $info['cost'] == 1 ? ' selected="selected"': ''; 
      $expen  = $info['cost'] == 2 ? ' selected="selected"': '';
      
	$cost_select = '<select name="cost">'
                  .'<option value="0" '.$cheap.'>Cheap(< 300k)</option>'
                  .'<option value="1" '.$mid.'>Mid-Range (300K-1M)</option>'
                  .'<option value="2" '.$expen.'>Expensive (1M+)</option>'
                  .'</select>'. NL;

echo '<table width="90%" align="center" style="border-left:1px solid #000;border-top:none;" cellspacing="0" cellpadding="0">'
    .NL.'<tr>'
    .NL.'<td colspan="2" class="tabletop">Name: <input type="text" name="name" value="' . $name . '" maxlength="40" /></td>'
    .NL.'<td rowspan="15" style="padding-left:5px;vertical-align:top;width:20%;">'
      .NL.'<table cellspacing="0" cellpadding="0" width="100%" style="border: none;">'
      .NL.'<tr>'
      .NL.'<td class="boxtop"><b>Attack Bonuses</b></td></tr>'
      .NL.'<tr>'
      .NL.'<td class="boxbottom">Stab: ' . $total_stab_att . '<br />Slash: ' . $total_slash_att . '<br />Crush: ' . $total_crush_att . '<br />Magic: ' . $total_mage_att . '<br />Range: ' . $total_range_att . '</td></tr>'
      .NL.'<tr>'
      .NL.'<td>&nbsp;</td></tr>'
      .NL.'<tr>'
      .NL.'<td class="boxtop"><b>Defence Bonuses</b></td></tr>'
      .NL.'<tr>'
      .NL.'<td class="boxbottom">Stab: ' . $total_stab_def . '<br />Slash: ' . $total_slash_def . '<br />Crush: ' . $total_crush_def . '<br />Magic: ' . $total_mage_def . '<br />Range: ' . $total_range_def . '<br />Summoning: ' . $total_summo_def . '</td></tr>'
      .NL.'<tr>'
      .NL.'<td>&nbsp;</td></tr>'
      .NL.'<tr>'
      .NL.'<td class="boxtop"><b>Other Bonuses</b></td></tr><tr><td class="boxbottom">Strength: ' . $total_str_other .'<br />Prayer: ' . $total_pray_oth . '</td></tr></table>'
      .NL.'</td>'
    .NL.'</tr>'
    .NL.'<tr>'
    .NL.'<td class="tablebottom" style="vertical-align:top;background-image:url(/img/bg.png);width:20%;">'
      .NL.'<table style="width:150px;" align="center" border="0" cellspacing="0" cellpadding="5">'
      
      .NL.'<tr style="height:50px;">'
      .NL.'<td style="width:50px;"></td>'
      .NL.'<td class="item"><input type="text" name="item0" size="4" value="' . $iid[0] . '" /></td>' ## Helmet
      .NL.'<td style="width:50px;"></td>'
      .NL.'</tr>'
      .NL.'<tr style="height:50px;">'
      .NL.'<td class="item"><input type="text" name="item2" size="4" value="' . $iid[2] . '" /></td>' ## Cape
      .NL.'<td class="item"><input type="text" name="item1" size="4" value="' . $iid[1] . '" /></td>' ## Neck
      .NL.'<td class="item"><input type="text" name="item3" size="4" value="' . $iid[3] . '" /></td>' ## Ammo
      .NL.'</tr>'
      .NL.'<tr style="height:50px;">'
      .NL.'<td class="item"><input type="text" name="item4" size="4" value="' . $iid[4] . '" /></td>' ## Weapon
      .NL.'<td class="item"><input type="text" name="item6" size="4" value="' . $iid[6] . '" /></td>' ## Chest
      .NL.'<td class="item"><input type="text" name="item5" size="4" value="' . $iid[5] . '" /></td>' ## Shield
      .NL.'</tr>'
      .NL.'<tr style="height:50px;">'
      .NL.'<td style="width:50px;"></td>'
      .NL.'<td class="item"><input type="text" name="item7" size="4" value="' . $iid[7] . '" /></td>' ## Legs
      .NL.'<td style="width:50px;"></td>'
      .NL.'</tr>'
      .NL.'<tr style="height:50px;">'
      .NL.'<td class="item"><input type="text" name="item9" size="4" value="' . $iid[9] . '" /></td>' ## Gloves
      .NL.'<td class="item"><input type="text" name="item8" size="4" value="' . $iid[8] . '" /></td>' ## Boots
      .NL.'<td class="item"><input type="text" name="item10" size="4" value="' . $iid[10] . '" /></td>' ## Finger
      .NL.'</tr>';
$itemids = '';
for($m=0;$m<11;$m++) {
    $itemids = $itemids . $iid[$m] . ',';
}
$itemids = substr($itemids,-1) == ',' ? substr($itemids,0,-1) : $itemids;

  echo '<tr style="height:50px;">'
      .NL.'<td style="width:50px;"></td>'
      .NL.$td[0] . $member[0] . '</td>' ## Helmet
      .NL.'<td style="width:50px;"></td>'
      .NL.'</tr>'
      .NL.'<tr style="height:50px;">'
      .NL.$td[2] . $member[2] . '</td>' ## Cape
      .NL.$td[1] . $member[1] . '</td>' ## Neck
      .NL.$td[3] . $member[3] . '</td>' ## Ammo
      .NL.'</tr>'
      .NL.'<tr style="height:50px;">'
      .NL.$td[4] . $member[4] . '</td>' ## Weapon
      .NL.$td[6] . $member[6] . '</td>' ## Chest
      .NL.$td[5] . $member[5] . '</td>' ## Shield
      .NL.'</tr>'
      .NL.'<tr style="height:50px;">'
      .NL.'<td style="width:50px;"></td>'
      .NL.$td[7] . $member[7] . '</td>' ## Legs
      .NL.'<td style="width:50px;"></td>'
      .NL.'</tr>'
      .NL.'<tr style="height:50px;">'
      .NL.$td[9] . $member[9] . '</td>' ## Gloves
      .NL.$td[8] . $member[8] . '</td>' ## Boots
      .NL.$td[10] . $member[10] . '</td>' ## Finger
      .NL.'</tr>'
      .NL.'</table>'
    .NL.'</td>'
    .NL.'<td style="border-right:1px solid #000;border-bottom:1px solid #000;vertical-align:top;" width="50%">'
    .NL.'<table width="100%" cellspacing="0" cellpadding="5">'
    .NL.'<tr>'
    .NL.'<td style="vertical-align:top;">Approved?</td>'
    .NL.'<td><input type="checkbox" name="approved" value="1" '.$sel.' /></td>'
    .NL.'</tr>'
    .NL.'<tr>'
    .NL.'<td style="vertical-align:top;">Submitter?</td>'
    .NL.'<td>' . $submit_type_select . '</td>'
    .NL.'</tr>'
    .NL.'<tr>'
    .NL.'<td style="vertical-align:top;">Theme (Main Grouping)</td>'
    .NL.'<td>' . $themed_select .'</td>'
    .NL.'</tr>'
    .NL.'<tr>'
    .NL.'<td style="vertical-align:top;">Type (Sub-Grouping)</td>'
    .NL.'<td>' . $type_select . '</td>'
    .NL.'</tr>'
    .NL.'<tr>'
    .NL.'<td style="vertical-align:top;">Cost (Order-By)</td>'
    .NL.'<td>' . $cost_select . '</td>'
    .NL.'</tr>'  
    .NL.'<tr>'
    .NL.'<td style="vertical-align:top;width:20%;">Set consists of:</td>'
    .NL.'<td>' . $names[0] . ', ' . $names[1] . ', ' . $names[2] . ', ' . $names[3] . ', ' . $names[4] . ', ' . $names[5] . ', ' . $names[6] . ', ' . $names[7] . ', ' . $names[8] . ', ' . $names[9] . ', ' . $names[10] . '</td>'
    .NL.'</tr>'
    .NL.'<tr>'
    .NL.'<td style="vertical-align:top;">Members:</td>'
    .NL.'<td>' . $table_members . '</td>'
    .NL.'</tr>'
    .NL.'<tr>'
    .NL.'<td>Market Price:</td>'
    .NL.'<td>'.$price.'</td>'
    .NL.'</tr>'
    .NL.'<tr>'
    .NL.'<td>Total Weight:</td>'
    .NL.'<td>' . $weight . 'kg</td>'
    .NL.'</tr>'
    .NL.'<tr>'
    .NL.'<td style="vertical-align:top;">Strengths:</td>'
    .NL.'<td>&nbsp;</td>'
    .NL.'</tr>'
    .NL.'<tr>'
    .NL.'<td style="vertical-align:top;">Good against:</td>'
    .NL.'<td></td>'
    .NL.'</tr>'
    .NL.'<tr>'
    .NL.'<td style="vertical-align:top;">Weaknesses:</td>'
    .NL.'<td>&nbsp;</td>'
    .NL.'</tr>'
    .NL.'<tr>'
    .NL.'<td style="vertical-align:top;">Weak against:</td>'
    .NL.'<td>&nbsp;</td>'
    .NL.'</tr>'
    .NL.'<tr>'
    .NL.'<td style="vertical-align:top;">Submitter\'s Description</td>'
    .NL.'<td><textarea name="description" cols="60" rows="5" style="font:10px Verdana;">' . htmlentities($description) . '</textarea></td>'
    .NL.'</tr>'
    .NL.'</table></td>'
       .'</tr></table>';
       
echo '<input type="hidden" name="itemids" value="' . $itemids . '" /></td>';
echo '<div style="text-align:center;padding:1em 0;"><input type="submit" value="Submit" /></div>';
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
			$db->query("DELETE FROM ".$ptable." WHERE id = " . $_POST['del_id'] );
			$ses->record_act( $ptitle, 'Delete', $_POST['del_name'], $ip );
			header( 'refresh: 2; url=' . $_SERVER['PHP_SELF'] );
			echo '<p style="text-align:center;">Entry successfully deleted from Zybez.</p>' . NL;
		}
	}
	else {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM ".$ptable." WHERE id = " . $id );
	
		if( $info ) {
		
			$name = $info['name'];
			echo '<p style="text-align:center;">Are you sure you want to delete \'' . $name . '\'?</p>';
			echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?act=delete"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>' . NL;
			echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '"><center><input type="submit" value="No" /></center></form>' . NL;
		}
		else {
			
			echo '<p style="text-align:center;">That identification number does not exist.</p>' . NL;
		}
	}
}
else { ## Index Page

  $order = $_GET['order'] == 'DESC' ? 'DESC' : 'ASC';
  $category = $categories == TRUE ? $_GET['category'] : 'name';
  $page = intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;
  
if(isset($_GET['search_area']) AND $search_areas == TRUE) {
    $search_area = addslashes($_GET['search_area']);
    $search_term = strip_tags($_GET['search_term']);
    $search = "WHERE ".$constraint[0]." AND ".$search_area." LIKE '%".addslashes($search_term)."%' ORDER BY `".$category."` ".$order;
	}
	else {
		$search_term = '';
		$search_area = '';
		$search = "ORDER BY `time` DESC";
	}

/*===========  Page Control  ============*/

$rows_per_page     = 10;
$row_count         = $db->query("SELECT * FROM ".$ptable." " . $search);
$row_count         = mysqli_num_rows($row_count);
$page_count        = ceil($row_count / $rows_per_page) > 1 ? ceil($row_count / $rows_per_page) : 1;
$page_links        = ($page > 1 AND $page < $page_count) ? '|' : '';
$start_from        = $page - 1;
$start_from        = $start_from * $rows_per_page;
$end_at            = $start_from + $rows_per_page;

$query = $db->query("SELECT * FROM ".$ptable." " . $search . " LIMIT " . $start_from . ", " . $rows_per_page);

if($page > 1) {
    $page_before = $page - 1;
    $page_links = '<a href="' . $_SERVER['PHP_SELF']. '?page=' . $page_before . '&amp;order=' . $order . '&amp;category=' . $category . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '">< Previous</a> ' . $page_links;
}
if($page < $page_count) {
    $page_after = $page + 1;
    $page_links = $page_links . ' <a href="' . $_SERVER['PHP_SELF']. '?page=' . $page_after . '&amp;order=' . $order . '&amp;category=' . $category . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '">Next ></a> ';
}
if($page > 2) {
    $page_links = '<a href="' . $_SERVER['PHP_SELF']. '?page=1&amp;order=' . $order . '&amp;category=' . $category . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '">&laquo; First</a> '. $page_links;
}
if($page < ($page_count - 1)) {
    $page_links = $page_links . ' <a href="' . $_SERVER['PHP_SELF']. '?page=' . $page_count . '&amp;order=' . $order . '&amp;category=' . $category . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '">Last &raquo;</a> ';
}


/*============  SEARCH FORM  ============*/

echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="get"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>'.NL
.'<td align="left" width="150">Browsing ' . $row_count . ' ' . ucfirst($table) . '(s)</td>'.NL
.'<td align="center">'.NL
.'Search <select name="search_area">';

for($num = 0; array_key_exists($num, $search_value) && array_key_exists($num, $search_name); $num++) {
    echo $search_area == $search_value[$num] ? '<option value="'.$search_value[$num].'" selected="selected">'.$search_name[$num].'</option>' : '<option value="'.$search_value[$num].'">'.$search_name[$num].'</option>';
}

echo '</select> for'.NL
.' <input type="text" name="search_term" value="' . $search_term . '" maxlength="40" />'.NL
.' <input type="submit" value="Go" /></td>'.NL
.'<td align="right" width="140">Page ' . $page . ' of ' . $page_count . '</td>'.NL
.'</tr></table></form>';
?>
	<table style="border-left: 1px solid #000;" width="100%" cellpadding="1" cellspacing="0">
	<tr>
	<th class="tabletop">Image:</th>
	<th class="tabletop">Name:</th>
	<th class="tabletop">Actions:</th>
	<th class="tabletop">Last Edited (GMT):</th>
	</tr>
	<?php
	

	while($info = $db->fetch_array( $query ) ) {
	
		echo '<tr align="center">' . NL;
		echo '<td class="tablebottom"><img src="/img/idbimg/' . $info['image'] . '" alt="Item Image" /></td>';
		echo '<td class="tablebottom"><a href="/equipmentprofile.php?id=' . $info['id'] . '" title="View Item" target="item_view">' . $info['name'] . '</a></td>' . NL;
		echo '<td class="tablebottom"><a href="' . $_SERVER['PHP_SELF'] . '?act=edit&amp;id=' . $info['id'] . '" title="Edit ' . $info['name'] . '">Edit</a>';

		if( $ses->permit( 15 ) ) {
			echo ' / <a href="' . $_SERVER['PHP_SELF'] . '?act=delete&amp;id=' . $info['id'] . '" title="Delete \'' . $info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td class="tablebottom">' . format_time( $info['time'] ) . '</td>' . NL;
		echo '</tr>' . NL;
	}
	if( mysqli_num_rows($query ) == 0 ) {
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="4">Sorry, no entries match your search criteria.</td>' . NL;
		echo '</tr>' . NL; 
  }
?>
</table><br />

<?php
}
echo '<br /></div>'. NL;
end_page();
?>