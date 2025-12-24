<?php

require( 'backend.php' );
require( 'edit_class.php' );
start_page( 4, 'Calculator Manager' );

$edit = new edit( 'calc_info', $db );

$cat_array = array(
					'Agility',
					'Construction',
					'Cooking',
					'Crafting',
					'Farming',
					'Firemaking',
					'Fishing',
					'Fletching',
					'Herblore',
					'Hunter',
					'Magic',
					'Mining',
					'Prayer',
					'Ranged',
					'Runecrafting',
					'Smithing',
					'Slayer',
					'Thieving',
					'Warrior',
					'Woodcutting');
					
if( in_array( $_GET['cat'], $cat_array ) ) {
	$category = $_GET['cat'];
}
else {
	$category = 'Agility';
}

echo '<div class="boxtop">Calculator Manager</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;

?>
<div style="float: right;"><a href="?cat=<?php echo $category; ?>"><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="?act=new&cat=<?php echo $category; ?>"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; Calculator Manager &raquo; <?php echo $category; ?></font></b>
</div>
<hr class="main" noshade="noshade" align="left" />
<?php


if( isset( $_POST['act'] ) AND $_POST['act'] == 'edit' AND isset( $_POST['id'] ) ) {

	$id = intval( $_POST['id'] );

	$name = $edit->add_update( $id, 'name', $_POST['name'], 'You must enter an name.' );
	$image = $edit->add_update( $id, 'image', $_POST['image'], 'You must specify an image.' );
	$level = $edit->add_update( $id, 'level', $_POST['level'], 'You must specify a level.' );
	$xp = $edit->add_update( $id, 'xp', $_POST['xp'], 'You must provide an xp value.' );
	$xp_more = $edit->add_update( $id, 'xp_more', $_POST['xp_more'], '', false );
	$member = $edit->add_update( $id, 'member', $_POST['member'], '', false );
	$calc_type = $edit->add_update( $id, 'calc_type', $_POST['calc_type'], '', false );

	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		$ses->record_act( $category . ' Calculator', 'Edit', $name, $ip );
		echo '<p align="center">Entry successfully edited on Zybez.</p>' . NL;
		header( 'refresh: 2; url=?cat=' . $category );
	}
	
}
elseif( isset( $_POST['act'] ) AND $_POST['act'] == 'new' ) {

	$calc_name = $edit->add_new( 1, 'calc_name', $category, '', false );
	$name = $edit->add_new( 1, 'name', $_POST['name'], 'You must enter an name.' );
	$image = $edit->add_new( 1, 'image', $_POST['image'], 'You must specify an image.' );
	$level = $edit->add_new( 1, 'level', $_POST['level'], 'You must specify a level.' );
	$xp = $edit->add_new( 1, 'xp', $_POST['xp'], 'You must provide an xp value.' );
	$xp_more = $edit->add_new( 1, 'xp_more', $_POST['xp_more'], '', false );
	$member = $edit->add_new( 1, 'member', $_POST['member'], '', false );
	$calc_type = $edit->add_new( 1, 'calc_type', $_POST['calc_type'], '', false );

	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		$ses->record_act( $category . '  Calculator', 'New', $name, $ip );
		echo '<p align="center">New entry was successfully added to Zybez.</p>' . NL;
		header( 'refresh: 2; url=?cat=' . $category );
	}
	
}

		
elseif( isset( $_GET['act'] ) AND ( ( $_GET['act'] == 'edit' AND isset( $_GET['id'] ) ) OR $_GET['act'] == 'new' ) ) {

	if( $_GET['act'] == 'edit' ) {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM calc_info WHERE id = " . $id . " AND calc_name = '" . $category . "'");
	
		if( $info ) {

			$name = $info['name'];
			$image = $info['image'];
			$level = $info['level'];
			$xp = $info['xp'];
			$xp_more = $info['xp_more'];
			$member = $info['member'];
			$calc_type = $info['calc_type'];
		}
		else {
			$name = '';
			$image = 'calcimg/';
			$level = 1;
			$xp = 0;
			$xp_more = 0;
			$member = 0;
			$calc_type = '';
		}
	}
	else {
		$name = '';
		$image = 'calcimg/';
		$level = 1;
		$xp = 0;
		$xp_more = 0;
		$member = 0;
		$calc_type = '';
	}

	$types = array(
		'Agility' => array( 'Course', 'Obstacle' ),
		'Construction' => array( 'Cheap', 'Average', 'Expensive' ),
		'Cooking' => array( 'General', 'Fish', 'Ale', 'Gnome_Cuisine' ),
		'Crafting' => array( 'General', 'Jewelry', 'Glass', 'Leather', 'Battlestaff' ),
		'Fletching' => array( 'Bow(s)', 'Ammo', 'Thrown', 'Bow(u)' ),
		'Herblore' => array( 'Potion', 'Herb', 'Mix' ),
		'Magic' => array( 'Regular', 'Ancient', 'Lunar' ),
		'Smithing' => array( 'Bar', 'Bronze', 'Iron', 'Steel', 'Mithril', 'Adamant', 'Rune' ),
		'Summoning' => array( 'Gold', 'Green', 'Crimson', 'Blue', 'Other' ),		
		'Thieving' => array( 'Door', 'Chest', 'Stall', 'Pickpocket' ),
		'Farming' => array( 'Vegetable', 'Flower', 'Bush', 'Herb', 'Fruit', 'Tree', 'General' ),
		'Prayer' => array( 'Bone', 'Remains', 'Other' ),
		'Fishing' => array( 'Net', 'Rod', 'Cage', 'Harpoon', 'Other'),
		'Hunter' => array( 'Bird_snare', 'Butterfly', 'Box_trap', 'Pitfall', 'Tracking', 'Deadfall', 'Rabbit_snare', 'Net_trap', 'Falconry', 'Imp' ) );
	
	echo '<br /><form method="post" action="?cat=' . $category . '">' . NL;
	echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />';

	if( $_GET['act'] == 'edit' ) {
		echo '<input type="hidden" name="id" value="' . $id . '" />';
	}
	echo '<input type="hidden" name="type" value="' . $category . '" />';
	
	echo '<table width="90%" align="center" style="border-left: 1px solid #000000" cellspacing="0">' . NL;
	echo '<tr>' . NL;
	echo '<td class="tabletop" colspan="2">General</td>' . NL;
	echo '</td>' . NL;
	echo '<tr><td class="tablebottom" width="50%">Name:</td><td class="tablebottom" colspan="2"><input type="text" size="40" name="name" value="' . $name . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Image:</td><td class="tablebottom" colspan="2"><input type="text" size="40" name="image" value="' . $image . '" /></td></tr>' . NL;

	echo '<tr><td class="tablebottom">Level:</td><td class="tablebottom" colspan="2"><input type="text" size="40" maxlength="3" name="level" value="' . $level . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Base XP:</td><td class="tablebottom" colspan="2"><input type="text" size="40" name="xp" value="' . $xp . '" /></td></tr>' . NL;
	
	if( $category == 'Farming' ) {
		echo '<tr><td class="tablebottom">Harvest XP:</td><td class="tablebottom" colspan="2"><input type="text" size="40" name="xp_more" value="' . $xp_more . '" /></td></tr>' . NL;
	}

	if( array_key_exists( $category, $types ) ) {
		echo '<tr><td class="tablebottom">Type:</td><td class="tablebottom" colspan="2"><select name="calc_type">' . NL;
		
		$ctypes = $types[$category];
		foreach( $ctypes AS $type ) {
			if( $type == $calc_type ) {
				echo '<option value="' . $type . '" selected="selected">' . $type . '</option>' . NL;
			}
			else {
				echo '<option value="' . $type . '">' . $type . '</option>' . NL;
			}		
		}		
		echo '</td></tr>' . NL;
	}
	
	if( $member == 1 ) {
		echo '<tr><td class="tablebottom">Members:</td><td class="tablebottom" colspan="2"><select name="member"><option value="1" selected="selected">Yes</option><option value="0">No</option></select></td></tr>' . NL;
	}
	else {
		echo '<tr><td class="tablebottom">Members:</td><td class="tablebottom" colspan="2"><select name="member"><option value="1">Yes</option><option value="0" selected="selected">No</option></select></td></tr>' . NL;
	}

	echo '<tr><td class="tablebottom" colspan="2"><input type="submit" value="Submit All" /></td></tr>' . NL;

	echo '</table>' . NL;
	echo '</form>' . NL;
}
elseif( isset( $_GET['act'] ) AND $_GET['act'] == 'delete' AND $ses->permit( 15 ) ) {

	if( isset( $_POST['del_id'] ) ) {
		$edit->add_delete( $_POST['del_id'] );
		$execution = $edit->run_all();
		
		if( !$execution ) {
			echo '<p align="center">' . $edit->error_mess . $edit_item->error_mess . '</p>';
		}
		else {
			$ses->record_act( $category . ' Calculator', 'Delete', $_POST['del_name'], $ip );
			header( 'refresh: 2; url=?cat=' . $category );
			echo '<p align="center">Entry successfully deleted from Zybez.</p>' . NL;
		}
	}
	else {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM calc_info WHERE id = " . $id . " AND calc_name = '" . $category . "'");
	
		if( $info ) {
		
			$name = $info['name'];
			echo '<p align="center">Are you sure you want to delete the ' . $category . ' Calculator option, \'' . $name . '\'?</p>';
			echo '<form method="post" action="?act=delete&cat=' . $category . '"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>' . NL;
			echo '<form method="post" action="?cat=' . $category . '"><center><input type="submit" value="No" /></center></form>' . NL;
		}
		else {
			
			echo '<p align="center">That identification number does not exist.</p>' . NL;
		}
	}
}
else {

	echo '<center><form action="?cat=' . $category . '" method="get">' . NL;
	echo '<input type="submit" value="Go To" /> ' . NL;
	echo '<select name="cat">' . NL;
	
	foreach( $cat_array AS $value ) {
	
		if( $category == $value ) {
			echo '<option value="' . $value . '" selected="selected">' . $value . '</option>' . NL;
		}
		else {
			echo '<option value="' . $value . '">' . $value . '</option>' . NL;
		}
	}
	echo '</select>' . NL;
	echo '</form></center>' . NL;

	$quack =  "SELECT * FROM calc_info WHERE calc_name = '" . $category . "' ORDER BY `level`";
	$query = $db->query($quack );

	?>
	<table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="1" cellspacing="0">
	<tr class="boxtop">
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Level:</th>
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Name:</th>
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Actions:</th>
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Last Edited (GMT):</th>
	</tr>
	<?php

	while($info = $db->fetch_array( $query ) ) {
	
		echo '<tr align="center">' . NL;
		echo '<td class="tablebottom">' . $info['level'] . '</td>' . NL;
		echo '<td class="tablebottom">' . $info['name'] . '</td>' . NL;
		echo '<td class="tablebottom"><a href="?act=edit&cat=' . $category . '&id=' . $info['id'] . '" title="Edit ' . $info['name'] . '">Edit</a>';

		if( $ses->permit( 15 ) ) {
			echo ' / <a href="?act=delete&cat=' . $category . '&id=' . $info['id'] . '" title="Delete \'' . $info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td class="tablebottom">' . format_time( $info['time'] ) . '</td>' . NL;
		echo '</tr>' . NL;
	}
	if( $db->num_rows( $quack ) == 0 ) {
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="4">Sorry, no entries match your search criteria.</td>' . NL;
		echo '</tr>' . NL;
	}
	
	?>
	</table>
	<?php

}

echo '<br /></div>'. NL;

end_page($name);
?>