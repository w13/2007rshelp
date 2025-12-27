<?php
require( 'backend.php' );
require( 'edit_class.php' );
//if($_SERVER['REMOTE_ADDR'] != '58.173.200.144') die('Back in a minute fellas, sorry');
start_page( 5, 'Shop Database' );

$edit = new edit( 'shops', $db );
$edit_item = new edit( 'shops_items', $db );

echo '<div class="boxtop">Shop Database</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;

?>
<div style="float: right;"><a href=""><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="?act=new"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; Shop Database</font></b>
</div>
<hr class="main" noshade="noshade" align="left" />
<?php


if( isset( $_POST['act'] ) AND $_POST['act'] == 'edit' AND isset( $_POST['id'] ) ) {

	$id = intval( $_POST['id'] );
	
	$use_stock = $edit->add_update( $id, 'use_stock', $_POST['use_stock'], '', false );
	$image = $edit->add_update( $id, 'image', $_POST['image'], 'You must enter an image.' );
	$name = $edit->add_update( $id, 'name', $_POST['name'], 'You must enter a shop name.' );
	$location = $edit->add_update( $id, 'location', $_POST['location'], 'You must specify location' );
	$member = $edit->add_update( $id, 'member', $_POST['member'], 'You must specify if shop is members only.' );
	$shopkeeper = $edit->add_update( $id, 'shopkeeper', $_POST['shopkeeper'], 'You must enter a shopkeeper.' );
	$notes = $edit->add_update( $id, 'notes', $_POST['notes'], 'You must enter some notes.' );
	$credits = $edit->add_update( $id, 'credits', $_POST['credits'], 'You must enter some credits.' );
	$complete = $edit->add_update( $id, 'complete', isset($_POST['complete']) ? 1 : 0, '', false );	
	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		$ses->record_act( 'Shops', 'Edit', $name, $ip );
		echo '<p align="center">Entry successfully edited on OSRS RuneScape Help.</p>' . NL;
		header( 'refresh: 2; url=' );
	}
	
}
elseif( isset( $_POST['act'] ) AND $_POST['act'] == 'new' ) {

	$use_stock = $edit->add_new( 1, 'use_stock', $_POST['use_stock'], '', false );
	$image = $edit->add_new( 1, 'image', $_POST['image'], 'You must enter an image.' );
	$name = $edit->add_new( 1, 'name', $_POST['name'], 'You must enter a shop name.' );
	$location = $edit->add_new( 1, 'location', $_POST['location'], 'You must specify location' );
	$member = $edit->add_new( 1, 'member', $_POST['member'], 'You must specify if shop is members only.' );
	$shopkeeper = $edit->add_new( 1, 'shopkeeper', $_POST['shopkeeper'], 'You must enter a shopkeeper.' );
	$notes = $edit->add_new( 1, 'notes', $_POST['notes'], 'You must enter some notes.' );
	$credits = $edit->add_new( 1, 'credits', $_POST['credits'], 'You must enter some credits.' );
	$complete = $edit->add_new( 1, 'complete', isset($_POST['complete']) ? 1 : 0, '', false );
		
	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		$ses->record_act( 'Shops', 'New', $name, $ip );
		echo '<p align="center">New entry was successfully added to OSRS RuneScape Help.</p>' . NL;
		header( 'refresh: 2; url=' );
	}
	
}
elseif( isset( $_POST['act'] ) AND $_POST['act'] == 'editm' AND isset( $_POST['item_id'] ) ) {

	$item_id = intval( $_POST['item_id'] );

	$item_currency = $edit_item->add_update( $item_id, 'item_currency', $_POST['item_currency'], 'You must enter an item currency.' );
	$item_name = $edit_item->add_update( $item_id, 'item_name', $_POST['item_name'], 'You must enter an item name.' );
	$item_price = $edit_item->add_update( $item_id, 'item_price', $_POST['item_price'], 'You must enter an item price.');
	$item_stock = $edit_item->add_update( $item_id, 'item_stock', $_POST['item_stock'], '', false );
	$shop_id = $edit_item->add_update( $item_id, 'shop_id', $_POST['shop_id'], 'Shop identification number is not set.' );

	$execution = $edit_item->run_all( false, false );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit_item->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		$ses->record_act( 'Shop Items', 'Edit', $item_name, $ip );
		echo '<p align="center">Entry successfully edited on OSRS RuneScape Help.</p>' . NL;
		header( 'refresh: 1; url=?act=edit&id=' . $shop_id );
	}
	
}
elseif( isset( $_POST['act'] ) AND $_POST['act'] == 'nwitm' ) {

	$item_currency = $edit_item->add_new( 1, 'item_currency', $_POST['item_currency'], 'You must enter an item currency.' );
	$item_name = $edit_item->add_new( 1, 'item_name', $_POST['item_name'], 'You must enter an item name.' );
	$item_price = $edit_item->add_new( 1, 'item_price', $_POST['item_price'], 'You must enter an item price.' );
	$item_stock = $edit_item->add_new( 1, 'item_stock', $_POST['item_stock'], '', false );
	$shop_id = $edit_item->add_new( 1, 'shop_id', $_POST['shop_id'], 'Shop identification number is not set.' );

	$execution = $edit_item->run_all( false, false );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit_item->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;- Go Back</b></a></p>' . NL;
	}
	else {
		$ses->record_act( 'Shop Items', 'New', $item_name, $ip );
		echo '<p align="center">New entry was successfully added to OSRS RuneScape Help.</p>' . NL;
		header( 'refresh: 1; url=?act=edit&id=' . $shop_id );
	}
	
}

elseif( isset( $_GET['act'] ) AND ( ( $_GET['act'] == 'editm' AND isset( $_GET['item_id'] ) ) OR $_GET['act'] == 'nwitm' ) AND isset( $_GET['shop_id'] ) ) {

	$shop_id = intval( $_GET['shop_id'] );
	$info = $db->fetch_row( "SELECT name FROM shops WHERE id = " . $shop_id );
	$name = $info['name'];
	
	if( $_GET['act'] == 'editm' ) {
		$item_id = intval( $_GET['item_id'] );
		$item = $db->fetch_row( "SELECT * FROM shops_items WHERE id = " . $item_id );

		if( $item AND $shop_id == $item['shop_id'] ) {
			$item_id = $item['id'];
			$item_currency = $item['item_currency'];
			$item_name = $item['item_name'];
			$item_price = $item['item_price'];
			$item_stock = $item['item_stock'];
		}
		else {
			$_GET['act'] = 'nwitm';
			$item_currency = 'gp';
			$item_name = '';
			$item_price = '';
			$item_stock = '';
		}
	}
	else {
		$item_currency = 'gp';
		$item_name = '';
		$item_price = '';
		$item_stock = '';
	}

	if( $_GET['act'] == 'editm' ) {
		echo '<p align="center">Editing \'' . $item_name . '\' in \'<a href="?act=edit&id=' . $shop_id . '" title="Edit Store Window"><i>' . $name . '</i></a>\'.</p>';
	}
	else {
		echo '<p align="center">Adding a new item to \'<a href="?act=edit&id=' . $shop_id . '" title="Edit Store Window"><i>' . $name . '</i></a>\'.</p>';
	}
	
	echo '<form method="post" action="">' . NL;
	echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />' . NL;
	
	if( $_GET['act'] == 'editm' ) {
		echo '<input type="hidden" name="item_id" value="' . $item_id . '" />' . NL;
	}
	echo '<input type="hidden" name="shop_id" value="' . $shop_id . '" />' . NL;

	echo '<table width="90%" align="center" style="border-left: 1px solid #000000" cellspacing="0">' . NL;
	echo '<tr>' . NL;
	echo '<td class="tabletop" width="50%">Field</td>' . NL;
	echo '<td class="tabletop">Input</td>' . NL;
	echo '</td>' . NL;
	echo '<tr><td class="tablebottom">Item Name:</td><td class="tablebottom"><input type="text" size="30" name="item_name" value="' . $item_name . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Item Price:</td><td class="tablebottom"><input type="text" size="30" name="item_price" value="' . $item_price . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Item Currency:</td><td class="tablebottom"><input type="text" size="30" name="item_currency" value="' . $item_currency . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Item Stock:</td><td class="tablebottom"><input type="text" size="30" name="item_stock" value="' . $item_stock . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom" colspan="2"><input type="submit" value="Submit All" /></td></tr>' . NL;
	echo '</table>' . NL;
	echo '<p align="center">Commas should not be used in the Price and Currency fields.<br /><strong>USE -1 AS STOCK TO REPRESENT INFINITY</strong></p>' . NL;
}
		
elseif( isset( $_GET['act'] ) AND ( ( $_GET['act'] == 'edit' AND isset( $_GET['id'] ) ) OR $_GET['act'] == 'new' ) ) {

	if( isset( $_POST['del_id'] ) AND $ses->permit( 15 ) ) {
		$edit_item->add_delete( $_POST['del_id'] );
		$execution = $edit_item->run_all( false, false );
		if( !$execution ) {
			echo '<p align="center">' . $edit_item->error_mess . '</p>';
		}
		else {
			$ses->record_act( 'Shop Items', 'Delete', $_POST['del_name'], $ip );
		}
	}

	$items = array();
	
	if( $_GET['act'] == 'edit' ) {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM shops WHERE id = " . $id );
		$query = $db->query( "SELECT * FROM shops_items WHERE shop_id = " . $id . " ORDER BY item_price DESC" );
		
		if( $info AND $query ) {

			$use_stock = $info['use_stock'];
			$image = $info['image'];
			$name = $info['name'];
			$location = $info['location'];
			$member = $info['member'];
			$shopkeeper = $info['shopkeeper'];
			$notes = $info['notes'];
			$credits = $info['credits'];
			$complete = $info['complete'];			
			$num = 0;
			while( $item = $db->fetch_array( $query ) ) {
				$items[$num] = $item;
				$num++;
			}
		}
		else {
			$_GET['act'] = 'new';
			$use_stock = 1;
			$image = '_nomap.png';
			$name = '';
			$location = '';
			$member = 'Yes';
			$shopkeeper = '';
			$notes = '';
			$credits = '';
			$complete = 0;
		}
	}
	else {
		$use_stock = 1;
		$image = '_nomap.png';
		$name = '';
		$location = '';
		$member = 'Yes';
		$shopkeeper = '';
		$notes = '';
		$credits = '';
		$complete = 0;
	}

	echo '<form method="post" action="">' . NL;
	echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />';
	
	if( $_GET['act'] == 'edit' ) {
		enum_correct( 'shops', $id );
		$selcomp = $info['complete'] == 1 ? ' checked="checked"' : '';
		echo '<input type="hidden" name="id" value="' . $id . '" />';
	}
	
	echo '<table width="90%" align="center" style="border-left: 1px solid #000000" cellspacing="0">' . NL;
	echo '<tr>' . NL;
	echo '<td class="tabletop" colspan="4">General</td>' . NL;
	echo '</td>' . NL;
	echo '<tr><td class="tablebottom" width="50%" colspan="2">Image File:</td><td class="tablebottom" colspan="2"><input type="text" size="40" name="image" value="' . $image . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom" colspan="2">Shop Name:</td><td class="tablebottom" colspan="2"><input type="text" size="40" name="name" value="' . $name . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom" colspan="2">Location:</td><td class="tablebottom" colspan="2"><input type="text" size="40" name="location" value="' . $location . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom" colspan="2">Shopkeeper:</td><td class="tablebottom" colspan="2"><input type="text" size="40" name="shopkeeper" value="' . $shopkeeper . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom" colspan="2">Credits:</td><td class="tablebottom" colspan="2"><input type="text" size="40" name="credits" value="' . $credits . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom" colspan="2">This shop been reviewed and completed (stock+prices)?</td><td class="tablebottom" colspan="2"><input type="checkbox" name="complete" value"1"'.$selcomp.' /></td></tr>' . NL;

	if( $member == 'Yes' ) {
		echo '<tr><td class="tablebottom" colspan="2">Members:</td><td class="tablebottom" colspan="2"><select name="member"><option value="Yes" selected="selected">Yes</option><option value="No">No</option></select></td></tr>' . NL;
	}
	else {
		echo '<tr><td class="tablebottom" colspan="2">Members:</td><td class="tablebottom" colspan="2"><select name="member"><option value="Yes">Yes</option><option value="No" selected="selected">No</option></select></td></tr>' . NL;
	}
	
	if( $use_stock == 1 ) {
		echo '<tr><td class="tablebottom" colspan="2">Use Stock:</td><td class="tablebottom" colspan="2"><select name="use_stock"><option value="1" selected="selected">Yes</option><option value="0">No</option></select></td></tr>' . NL;
	}
	else {
		echo '<tr><td class="tablebottom" colspan="2">Use Stock:</td><td class="tablebottom" colspan="2"><select name="use_stock"><option value="1">Yes</option><option value="0" selected="selected">No</option></select></td></tr>' . NL;
	}

	echo '<tr><td class="tabletop" colspan="4" style="border-top: none;">Notes</td></tr>' . NL;
	echo '<tr><td class="tablebottom" colspan="4"><textarea name="notes" rows="2" style="width: 95%;">' . $notes . '</textarea></td></tr>' . NL;
	echo '<tr><td class="tablebottom" colspan="4"><input type="submit" value="Submit General" /></td></tr>' . NL;
	echo '</table>' . NL;
	echo '</form>' . NL;
	
	echo '<table width="90%" align="center" style="border-left: 1px solid #000;" cellspacing="0">' . NL;
	if( $_GET['act'] == 'edit' ) {
		echo '<tr>' . NL;
		echo '<td class="tabletop">Item Name:</td>' . NL;
		echo '<td class="tabletop">Item Price:</td>' . NL;
		echo '<td class="tabletop">Item Stock:</td>' . NL;
		echo '<td class="tabletop">Action:</td>' . NL;
		echo '</tr>' . NL;
		echo '<tr><td colspan="4" class="tabletop" style="border-top:none;"><a href="shop.php?act=edit&amp;id='.$id.'&amp;setall_infinite">Click here to set all stock in this shop as infinite.</a></td></tr>';
		if(isset($_GET['setall_infinite'])) {
		$db->query("UPDATE shops_items SET item_stock = -1 WHERE shop_id = ".$id);
		header( 'refresh: 1; url=?act=edit&id=' . $id );
		}
		foreach( $items AS $item ) {
			echo '<tr>' . NL;
			echo '<td class="tablebottom">' . $item['item_name'] . '</td>' . NL;
			echo '<td class="tablebottom">' . $item['item_price'] . $item['item_currency'] . '</td>' . NL;
			
			if( $use_stock == 1 ) {
				echo '<td class="tablebottom">' . $item['item_stock'] . '</td>' . NL;
			}
			else {
				echo '<td class="tablebottom">N/A</td>' . NL;
			}
			echo '<td class="tablebottom">';
			echo '<a href="?act=editm&item_id=' . $item['id'] . '&shop_id=' . $id . '" title="Edit \'' . $item['item_name'] . '\'">Edit</a>';

			if( $ses->permit( 15 ) ) {
				echo ' / <a href="?act=delitm&item_id=' . $item['id'] . '" title="Delete \'' . $item['item_name'] . '\'">Delete</a>' . NL;
			}
			echo '</td>';

			echo '</tr>' . NL;
		}
	}

	echo '</table>' . NL;

	if( $_GET['act'] == 'edit' ) {
		echo '<p align="center"><a href="?act=nwitm&shop_id=' . $id . '" title="Add New Item"><img src="images/new_item.gif" border="0"/></a></p>' . NL;
	}
	
}
elseif( isset( $_GET['act'] ) AND $_GET['act'] == 'delitm' AND isset( $_GET['item_id'] ) AND $ses->permit( 15 ) ) {

	$item_id = intval( $_GET['item_id'] );
	$info = $db->fetch_row( "SELECT * FROM shops_items WHERE id = " . $item_id );

	if( $info ) {
	
		$name = $info['item_name'];
		echo '<p align="center">Are you sure you want to delete the item, \'' . $name . '\'?</p>';
		echo '<form method="post" action="?act=edit&id=' . $info['shop_id'] . '"><center><input type="hidden" name="del_id" value="' . $item_id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>' . NL;
		echo '<form method="post" action="?act=edit&id=' . $info['shop_id'] . '"><center><input type="submit" value="No" /></center></form>' . NL;
	}
	else {
		echo '<p align="center">That identification number does not exist.</p>' . NL;
	}
}
elseif( isset( $_GET['act'] ) AND $_GET['act'] == 'delete' AND $ses->permit( 15 ) ) {

	if( isset( $_POST['del_id'] ) ) {
		$edit->add_delete( $_POST['del_id'] );
		$execution = $edit->run_all();
		$execution_item = $edit_item->run_all();
		
		if( !$execution  ) {
			echo '<p align="center">' . $edit->error_mess . $edit_item->error_mess . '</p>';
		}
		else {
			$db->query("DELETE FROM shops_items WHERE shop_id = " . $_POST['del_id'] );
			$ses->record_act( 'Shops', 'Delete', $_POST['del_name'], $ip );
			header( 'refresh: 2; url=' );
			echo '<p align="center">Entry successfully deleted from OSRS RuneScape Help.</p>' . NL;
		}
	}
	else {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM shops WHERE id = " . $id );
	
		if( $info ) {
		
			$name = $info['name'];
			echo '<p align="center">Are you sure you want to delete the shop, \'' . $name . '\'?</p>';
			echo '<form method="post" action="?act=delete"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>' . NL;
			echo '<form method="post" action=""><center><input type="submit" value="No" /></center></form>' . NL;
		}
		else {
			
			echo '<p align="center">That identification number does not exist.</p>' . NL;
		}
	}
}
else {

	if( isset( $_GET['category'] ) and isset( $_GET['search_area'] ) and ( $_GET['category'] == 'location' or $_GET['category'] == 'name' or $_GET['category'] == 'member' or $_GET['category'] == 'shopkeeper' or $_GET['search_area'] == 'notes' or $_GET['category'] == 'image' ) ) {
		$category = $_GET['category'];
	}
	else {
		$category = 'name';
	}
	
	if( isset( $_GET['search_area'] ) and ( $_GET['search_area'] != 'itemsearch' and $_GET['search_area'] == 'location' or $_GET['search_area'] == 'name' or $_GET['search_area'] == 'location' or $_GET['search_area'] == 'shopkeeper' or $_GET['search_area'] == 'notes' or $_GET['search_area'] == 'image' ) ) {
		$search_term = strip_tags($_GET['search_term']);
		$search_area = $_GET['search_area'];
		$search = "SELECT * FROM `shops` WHERE " . $search_area . " LIKE '%" . addslashes( $search_term ) . "%' ORDER BY `name`";
	}
	 elseif( $_GET['search_area'] == 'itemsearch' ) {
		$search_term = $_GET['search_term'];
		$search_area = $_GET['search_area'];
		$search = "SELECT * FROM `shops_items`, `shops` WHERE `item_name` LIKE '%".addslashes($search_term)."%' AND shops . `id` = `shop_id` ORDER BY `".$category."` ".$order.", `item_price` ASC, `item_stock` DESC, `item_name` ASC";
	}
	else {
		$search_term = '';
		$search_area = '';
		$search = "SELECT * FROM shops ORDER BY `name`";
	}
	
	$query = $db->query( $search );

	echo '<center><form action="" method="get">' . NL;
	echo 'Search <select name="search_area">' . NL;
	
	if( $search_area == 'name' ) {
		echo '<option value="name" selected="selected">Shop Names</option>' . NL;
	}
	else {
		echo '<option value="name">Shop Names</option>' . NL;
	}
	if( $search_area == 'location' ) {
		echo '<option value="location" selected="selected">Locations</option>' . NL;
	}
	else {
		echo '<option value="location">Locations</option>' . NL;
	}
	if( $search_area == 'shopkeeper' ) {
		echo '<option value="shopkeeper" selected="selected">Shopkeepers</option>' . NL;
	}
	else {
		echo '<option value="shopkeeper">Shopkeepers</option>' . NL;
	}
	if( $search_area == 'notes' ) {
		echo '<option value="notes" selected="selected">Notes</option>' . NL;
	}
	else {
		echo '<option value="notes">Notes</option>' . NL;
	}
	if( $search_area == 'image' ) {
		echo '<option value="image" selected="selected">Image</option>' . NL;
	}
	else {
		echo '<option value="image">Image</option>' . NL;
	}
	echo '</select> for ' . NL;

	echo '<input type="text" name="search_term" value="' . $search_term . '" maxlength="40" />' . NL;
	echo '<input type="submit" value="Go" />' . NL;
	echo '</form></center>' . NL;
	
	?>
	<table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="1" cellspacing="0">
	<tr class="boxtop">
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Name:</th>
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Actions:</th>
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Last Edited (GMT):</th>
	</tr>
	<?php

	while($info = $db->fetch_array( $query ) ) {
	if($info['complete'] == 1) {
		echo '<tr align="center">' . NL;
		echo '<td id="complete"><a href="/shops.php?id=' . $info['id'] . '" title="View Shop" target="shop_view">' . $info['name'] . '</a></td>' . NL;
		echo '<td id="complete"><a href="?act=edit&id=' . $info['id'] . '" title="Edit ' . $info['name'] . '">Edit</a>';

		if( $ses->permit( 15 ) ) {
			echo ' / <a href="?act=delete&id=' . $info['id'] . '" title="Delete \'' . $info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td id="complete">' . format_time( $info['time'] ) . '</td>' . NL;
		
		} else {
		echo '<td class="tablebottom"><a href="/shops.php?id=' . $info['id'] . '" title="View Shop" target="shop_view">' . $info['name'] . '</a></td>' . NL;
		echo '<td class="tablebottom"><a href="?act=edit&id=' . $info['id'] . '" title="Edit ' . $info['name'] . '">Edit</a>';

		if( $ses->permit( 15 ) ) {
			echo ' / <a href="?act=delete&id=' . $info['id'] . '" title="Delete \'' . $info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td class="tablebottom">' . format_time( $info['time'] ) . '</td>' . NL;
}
		
		echo '</tr>' . NL;
	}
	if( $db->num_rows( $search ) == 0 ) {
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="3">Sorry, no entries match your search criteria.</td>' . NL;
		echo '</tr>' . NL;
	}
	
	?>
	</table>
	<?php

}

echo '<br /></div>'. NL;

end_page($name);
?>