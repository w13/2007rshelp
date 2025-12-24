<?php
$DEBUG = 0;
$cleanArr = array(  array('id', $_GET['id'], 'int', 's' => '1,9999'),
					array('order', $_GET['order'], 'enum', 'e' => array('DESC', 'ASC'), 'd' => 'ASC' ),
					array('page', $_GET['page'], 'int', 's' => '1,400', 'd' => 1),
					array('g_cat', $_GET['category'], 'enum', 'e' => array('location', 'shopkeeper', 'member', 'name', 'item_name', 'item_price', 'item_stock') ),
					array('search_area', $_GET['search_area'], 'enum', 'e' => array('itemsearch','name','location','shopkeeper','notes') ),
					array('search_term', $_GET['search_term'], 'sql', 'l' => 40)
				  );

/****** SHOP DATABASE ******/
require(  dirname( __FILE__ ) . '/' . 'backend.php' );
start_page( 'OSRS RuneScape Shops Database' );
if($disp->errlevel > 0) {
	unset($id);
	unset($search_area);
}
?>
<div class="boxtop">OSRS RuneScape Shops Database</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<?php

/*** INDEX PAGE ***/

if( !isset( $id ) )
	{

?>
<div style="margin:1pt; font-size:large; font-weight:bold;">&raquo; <a href="">Runescape Shop Database</a></div>
<hr class="main" noshade="noshade" />
<p>This database is a collection of detailed information about every shop in RuneScape. If you every wanted to know how much an item costs at a certain shop or simply want to find out where you can buy something, this is the place to look. You can either simply browse the pages of this database using the page-numbers at the bottom or you can use the search feature below to narrow down your search.</p>
<br />
<?php

	/* Variable Checking */

	// Check Category Ording
	if( isset( $g_cat ) and $search_area != 'itemsearch' and ( $g_cat == 'location' or $g_cat == 'shopkeeper' or $g_cat == 'member' or $g_cat == 'name' ) ) {
		$category = $g_cat;
	}
	elseif( isset( $g_cat ) and $search_area == 'itemsearch' and ( $g_cat == 'item_name' or $g_cat == 'item_price' or $g_cat == 'item_stock' or $g_cat == 'name' or $g_cat == 'location' ) ) {
		$category = $g_cat;
	}
	elseif( isset( $search_area ) and $search_area == 'itemsearch' ) {
		$category = 'item_name';
	}
	else {
		$category = 'name';
	}

	// Check Searches - Assign Search Conditions
	if( isset( $search_area ) and ( $search_area != 'itemsearch' and $search_area == 'name' or $search_area == 'location' or $search_area == 'shopkeeper' or $search_area == 'notes' ) ) {
		$search = "FROM `shops` WHERE ".$search_area." LIKE '%".$search_term."%' ORDER BY `".$category."` ".$order.", `name` ASC";
	}
	 elseif( $search_area == 'itemsearch' ) {
		$search = "FROM `shops_items`, `shops` WHERE `item_name` LIKE '%".$search_term."%' AND shops . `id` = `shop_id` ORDER BY `".$category."` ".$order.", `item_price` ASC, `item_stock` DESC, `item_name` ASC";
	} 
	 else {
		$search_term = '';
		$search_area = '';
		$search = "FROM `shops` ORDER BY `".$category."` ".$order.", `name` ASC";
	}

	/* Page Configuration */

	$entries_per_page = 50;
	$entry_count = $db->query( "SELECT * " . $search );
	$entry_count = $db->num_rows( "SELECT * " . $search );
	$page_links = '';
	$page_count = ceil( $entry_count / $entries_per_page );
	$current_page = 0;
  
	// Build Page Number String
	while( $current_page < $page_count ) {
		$current_page++;
		if( $current_page == $page ) {
			$page_links = '' . $page_links . '<b>['. $current_page . ']</b> ';
		}
		else {
			$page_links = $page_links . '<a href="' . $_SERVER['SCRIPT_NAME'] . '?page=' . $current_page . '&amp;order=' . $order . '&amp;category=' . $category . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '">'. $current_page . '</a> ';
		}
	}

	// Previous Page Function
	if( $page_count > 1 AND $page > 1 )
	{
		  $page_before = $page - 1;
		  $page_links = '<a href="' . $_SERVER['SCRIPT_NAME']. '?page=' . $page_before . '&amp;order=' . $order . '&amp;category=' . $category . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '">< Previous</a> ' . $page_links;
	}

 	 // Next Page Function
  	if( $page_count > 1 AND $page != $page_count ) {
		  $page_after = $page + 1;
		  $page_links = $page_links . '<a href="' . $_SERVER['SCRIPT_NAME']. '?page=' . $page_after . '&amp;order=' . $order . '&amp;category=' . $category . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '">Next ></a> ';
	}
  
	/* MySQL Retrieve Information */

	$start_from = $page - 1;
	$start_from = $start_from * $entries_per_page;
	$end_at = $start_from + $entries_per_page;
	$query = $db->query( "SELECT * " . $search . " LIMIT " . $start_from . ", " . $entries_per_page ); 

	/* Print The Search Form */

	echo '<form action="' . $_SERVER['SCRIPT_NAME'] . '" method="get"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>' . NL;
	echo '<td align="left" width="125">Browsing ' . $entry_count . ' Entries</td>' . NL;
	echo '<td align="center">' . NL;
	echo 'Search <select name="search_area">' . NL;
	
	// Select Previous Search Field

	if( $search_area == 'itemsearch' ) {
		echo '<option value="itemsearch" selected="selected">Item Names</option>' . NL;
	}
	else {
		echo '<option value="itemsearch">Item Names</option>' . NL;
	}

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

	echo '</select> for ' . NL;

	// Print Search Term Field
	echo '<input type="text" name="search_term" value="' . stripslashes($search_term) . '" maxlength="40" />' . NL;

	// Print The End of the form
	echo ' <input type="submit" value="Go" />' . NL;
	echo '</td>' . NL;
	echo '<td align="right" width="125">Page ' . $page . ' of ' . $page_count . '</td>' . NL;
	echo '</tr></table></form>' . NL;

	/* Print the Table */

	echo '<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">' . NL;

	// Item Search Table
	if( $search_area == 'itemsearch' ) {
		echo '<tr>' . NL;
		echo '<th width="20%" class="tabletop">Item: <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=ASC&amp;category=item_name&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Item Name, Ascending"><img src="/img/up.GIF" alt="ASC" border="0" /></a> <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=DESC&amp;category=item_name&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Item Name, Descending"><img src="/img/down.GIF" alt="DESC" border="0" /></a></th>' . NL;
		echo '<th width="18%" class="tabletop">Price: <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=ASC&amp;category=item_price&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Item Price, Ascending"><img src="/img/up.GIF" alt="ASC" border="0" /></a> <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=DESC&amp;category=item_price&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Item Price, Descending"><img src="/img/down.GIF" alt="DESC" border="0" /></a></th>' . NL;
		echo '<th width="15%" class="tabletop">Stock: <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=ASC&amp;category=item_stock&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Item Stock, Ascending"><img src="/img/up.GIF" alt="ASC" border="0" /></a> <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=DESC&amp;category=item_stock&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Item Stock, Descending"><img src="/img/down.GIF" alt="DESC" border="0" /></a></th>' . NL;
		echo '<th width="20%" class="tabletop">Location: <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=ASC&amp;category=location&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Location, Ascending"><img src="/img/up.GIF" alt="ASC" border="0" /></a> <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=DESC&amp;category=location&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Location, Descending"><img src="/img/down.GIF" alt="DESC" border="0" /></a></th>' . NL;
		echo '<th width="37%" class="tabletop">Found in Shop: <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=ASC&amp;category=name&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Shop Name, Ascending"><img src="/img/up.GIF" alt="ASC" border="0" /></a> <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=DESC&amp;category=name&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Shop Name, Descending"><img src="/img/down.GIF" alt="DESC" border="0" /></a></th>' . NL;
		echo '</tr>' . NL;

		while( $info = $db->fetch_array( $query ) ) {
			echo '<tr>' . NL;
			echo '<td class="tablebottom">' . $info['item_name'] . '</td>' . NL;
			echo '<td class="tablebottom">' . number_format( $info['item_price'] ) . '' . $info['item_currency'] . '</td>' . NL;

			if ( $info['use_stock'] == 0 ) {
				echo '<td class="tablebottom">-</td>' . NL;
			}
			else {
				$info['item_stock'] = $info['item_stock'] == -1 ? '&#8734;' : $info['item_stock'];
				echo '<td class="tablebottom">' . $info['item_stock'] . '</td>' . NL;
			}
				echo '<td class="tablebottom">' . $info['location'] . '</td>' . NL;
			echo '<td class="tablebottom"><a href="' . $_SERVER['SCRIPT_NAME'] . '?id=' . $info['shop_id'] . '" title="View Shop">' . $info['name'] . '</a></td>' . NL;
			echo '</tr>' . NL;
		}
	}
	// Regular Table

	else {
		echo '<tr>' . NL;
		echo '<th width="34%" class="tabletop">Name: <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=ASC&amp;category=name&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Name, Ascending"><img src="/img/up.GIF" alt="ASC" border="0" /></a> <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=DESC&amp;category=name&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Name, Descending"><img src="/img/down.GIF" alt="DESC" border="0" /></a></th>' . NL;
		echo '<th width="28%" class="tabletop">Location: <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=ASC&amp;category=location&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '"  title="Sort by: Location, Ascending"><img src="/img/up.GIF" alt="ASC" border="0" /></a> <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=DESC&amp;category=location&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Location, Descending"><img src="/img/down.GIF" alt="DESC" border="0" /></a></th>' . NL;
		echo '<th width="15%" class="tabletop">Members? <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=ASC&amp;category=member&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Member, Ascending"><img src="/img/up.GIF" alt="ASC" border="0" /></a> <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=DESC&amp;category=member&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Member, Descending"><img src="/img/down.GIF" alt="DESC" border="0" /></a></th>' . NL;
		echo '<th width="23%" class="tabletop">Shopkeeper: <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=ASC&amp;category=shopkeeper&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Shopkeeper, Ascending"><img src="/img/up.GIF" alt="ASC" border="0" /></a> <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=DESC&amp;category=shopkeeper&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Shopkeeper, Descending"><img src="/img/down.GIF" alt="DESC" border="0" /></a></th>' . NL;
		echo '</tr>' . NL;

		while( $info = $db->fetch_array( $query ) ) {
			echo '<tr>' . NL;
    
    echo '<td class="tablebottom"><a href="?id=' . $info['id'] . '">' . $info['name'] . '</a></td>' . NL;
			
			echo '<td class="tablebottom"><a href="?search_area=location&amp;search_term=' . $info['location'] . '" title="Search Location">' . $info['location'] . '</a></td>' . NL;
			echo '<td class="tablebottom">' . $info['member'] . '</td>' . NL;
			echo '<td class="tablebottom">' . $info['shopkeeper'] . '</td>' . NL;
			echo '</tr>' . NL;
		} 
	}

	// If No Search Results

	if( $entry_count == 0 or $page <= 0 or $page > $page_count ) {
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="5">Sorry, no entries match your search criteria.</td>' . NL;
		echo '</tr>' . NL;
	}

	echo '</table><br />' . NL;

	// Echo Page Selection
	if( $page_count > 1 ) {
		echo '<p align="center">' . $page_links . '</p>' . NL;
	 }
}

/*** SHOP PAGE ***/

else {

	/* Check Shop Variables */

	/* Check Inventory Variables */

	// Check Inventory Categories
	if( isset( $g_cat ) and ( $g_cat == 'item_name' or $g_cat == 'item_price' or $g_cat == 'item_stock' ) ) {
		$category = $g_cat;
	}
	else {
		$category = 'item_stock';
	}

	/* MySQL Retrieve Information */
	$info = $db->fetch_row( "SELECT * FROM `shops` WHERE `id` = " . $id );
	$inventory = $db->query( "SELECT * FROM `shops_items` WHERE `shop_id` = " . $id . " ORDER BY `".$category."` ".$order.", `item_price` DESC, `item_name` ASC" );

?>
<div style="margin:1pt; font-size:large; font-weight:bold;">
&raquo; <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">OSRS RuneScape Shops Database</a> &raquo; <u><?php echo $info['name']; ?></u></div>
<hr class="main" noshade="noshade" />
<br />
<?php

	/* Print the Table */

	// General Shop Information
	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000000; border-top: none" cellpadding="4" align="center">' . NL;
	echo '<tr><td colspan="4" class="tabletop">' . $info['name'] . '&nbsp;</td></tr>' . NL;
	echo '<tr><td width="10" rowspan="4" style="border: none; border-right: 1px solid #000000"><img src="/img/shopimg/' . $info['image'] . '" alt="Map of ' . $info['name'] . '" /></td>' . NL;
	echo '<td width="20%">Location:</td><td><a href="' . $_SERVER['SCRIPT_NAME'] . '?search_area=location&amp;search_term=' . $info['location'] . '" title="Find other shops at this location.">' . $info['location'] . '</a></td></tr>' . NL;
	echo '<tr><td>Members:</td><td>' . $info['member'] . '</td></tr>' . NL;
	echo '<tr><td>Shopkeeper:</td><td>' . $info['shopkeeper'] . '</td></tr>' . NL;
	echo '<tr><td>Extra Notes:</td><td>' . $info['notes'] . '</td></tr>' . NL;
	echo '</table><br />' . NL;

	// Inventory Information
	echo '<table cellspacing="0" width="75%" style="border: none; border-left: 1px solid #000000" cellpadding="4" align="center"><tr>' . NL;
	echo '<th class="tabletop">Item <a href="' . $_SERVER['SCRIPT_NAME'] . '?id=' . $id . '&amp;order=ASC&amp;category=item_name" title="Sort by: Item, Ascending"><img src="/img/up.GIF" alt="ASC" border="0" /></a> <a href="' . $_SERVER['SCRIPT_NAME'] . '?id=' . $id . '&amp;order=DESC&amp;category=item_name" title="Sort by: Item, Descending"><img src="/img/down.GIF" alt="DESC" border="0" /></a></th>' . NL;
	echo '<th class="tabletop">Price <a href="' . $_SERVER['SCRIPT_NAME'] . '?id=' . $id . '&amp;order=ASC&amp;category=item_price" title="Sort by: Price, Ascending"><img src="/img/up.GIF" alt="ASC" border="0" /></a> <a href="' . $_SERVER['SCRIPT_NAME'] . '?id=' . $id . '&amp;order=DESC&amp;category=item_price" title="Sort by: Price, Descending"><img src="/img/down.GIF" alt="DESC" border="0" /></a></th>' . NL;

	if ( $info['use_stock'] == 1 ) {
		echo '<th class="tabletop">Default Stock <a href="' . $_SERVER['SCRIPT_NAME'] . '?id=' . $id . '&amp;order=ASC&amp;category=item_stock" title="Sort by: Default Stock, Ascending"><img src="/img/up.GIF" alt="ASC" border="0" /></a> <a href="' . $_SERVER['SCRIPT_NAME'] . '?id=' . $id . '&amp;order=DESC&amp;category=item_stock" title="Sort by: Default Stock, Descending"><img src="/img/down.GIF" alt="DESC" border="0" /></a></th>' . NL;
	}
	echo '</tr>' . NL;
	while( $item = $db->fetch_array( $inventory ) ) {
	$item['item_stock'] = $item['item_stock'] == -1 ? '&#8734;' : $item['item_stock'];
		echo '<tr align="center">' . NL;
		echo '<td class="tablebottom"><a href="/items.php?search_area=name&amp;search_term=' . $item['item_name'] . '" title="Find in Item Database">' . $item['item_name'] . '</a></td>' . NL;
		echo '<td width="30%" class="tablebottom">' . number_format( $item['item_price'] ) . '' . $item['item_currency'] . '</td>' . NL;

		if ( $info['use_stock'] == 1 ) {
			echo '<td width="30%" class="tablebottom">' . $item['item_stock'] . '</td>' . NL;
		}
		echo '</tr>' . NL;
	} 
	echo '</table><br />' . NL;

	// The Credits
	echo '<table width="75%" cellspacing="0" cellpadding="4" style="border: 1px solid #000000" align="center">' . NL;
	echo '<tr><td>Credits: ' . $info['credits'] . '</td></tr>' . NL;
	echo '</table>' . NL;

	if ( $info['use_stock'] == 1 ) {
		echo '<p align="center">Prices in game may vary based on item stock. Prices in this database only exist at default item stocks.</p>' . NL;
	}
	echo '<p align="center"><a href="/correction.php?area=shops&amp;id=' . $id . '" title="Submit a Correction"><img src="/img/correct.gif" alt="Submit Correction" border="0" /></a><br /><br />';
	echo '<a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
}

?>
[#COPYRIGHT#]
<br />
</div>

<?php
end_page( $info['name'] );
?>
