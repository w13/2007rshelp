<?php
$DEBUG = 0;
$cleanArr = array(  array('id', $_GET['id'] ?? null, 'int', 's' => '1,9999'),
					array('order', $_GET['order'] ?? null, 'enum', 'e' => array('DESC', 'ASC'), 'd' => 'ASC' ),
					array('page', $_GET['page'] ?? null, 'int', 's' => '1,400', 'd' => 1),
					array('g_cat', $_GET['category'] ?? null, 'enum', 'e' => array('location', 'shopkeeper', 'member', 'name', 'item_name', 'item_price', 'item_stock') ),
					array('search_area', $_GET['search_area'] ?? null, 'enum', 'e' => array('itemsearch','name','location','shopkeeper','notes') ),
					array('search_term', $_GET['search_term'] ?? null, 'sql', 'l' => 40)
				  );

/****** SHOP DATABASE ******/
require(  dirname( __FILE__ ) . '/' . 'backend.php' );
start_page( 'OSRS RuneScape Shops Database' );
if($disp->errlevel > 0) {
	$id = null;
	unset($search_area);
}
?>
<div class="boxtop">OSRS RuneScape Shops Database</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<script src="/jquery.tablesorter.min.js"></script>
<style>
/* Maintain visual language for sortable headers */
.sortable thead th {
    background-image: url('/img/gradient_bg.png');
    background-position: left;
    padding-top: 3px;
    padding-bottom: 3px;
    font-size: 12px;
    font-weight: bold;
    color: #fff;
    background-color: #005474;
    border: 1px solid #000;
    text-align: center;
    cursor: pointer;
}
.sortable thead th a img {
    display: none; /* Hide old sorting arrows as we use CSS indicators */
}
.sortable thead th:after {
    content: ' \2195'; /* Up/down arrow for sortability indicator */
    font-size: 0.8em;
    opacity: 0.5;
}
</style>
<script>
$(document).ready(function() { 
    var table = $(".sortable");
    table.tablesorter(); 
    
    // Pagination Logic
    var rows = table.find("tbody tr");
    var perPage = 50;
    var numPages = Math.ceil(rows.length / perPage);
    var currentPage = 1;
    
    function showPage(page) {
        if (page < 1) page = 1;
        if (page > numPages) page = numPages;
        currentPage = page;
        
        var start = (page - 1) * perPage;
        var end = start + perPage;
        
        rows.hide().slice(start, end).show();
        updateControls();
    }
    
    function updateControls() {
        var controls = $("#pagination-controls");
        if (numPages <= 1) {
            controls.empty();
            return;
        }
        
        var html = '';
        if (currentPage > 1) {
            html += '<a href="#" class="page-link" data-page="' + (currentPage - 1) + '">&lt; Previous</a> ';
        }
        
        var startPage = Math.max(1, currentPage - 2);
        var endPage = Math.min(numPages, currentPage + 2);
        
        if (startPage > 1) {
             html += '<a href="#" class="page-link" data-page="1">1</a> ... ';
        }
        
        for (var i = startPage; i <= endPage; i++) {
            if (i === currentPage) {
                html += '<b>[' + i + ']</b> ';
            } else {
                html += '<a href="#" class="page-link" data-page="' + i + '">' + i + '</a> ';
            }
        }
        
        if (endPage < numPages) {
            html += ' ... <a href="#" class="page-link" data-page="' + numPages + '">' + numPages + '</a> ';
        }
        
        if (currentPage < numPages) {
            html += '<a href="#" class="page-link" data-page="' + (currentPage + 1) + '">Next &gt;</a>';
        }
        
        controls.html(html);
        
        $(".page-link").click(function(e) {
            e.preventDefault();
            showPage($(this).data("page"));
        });
    }
    
    // Initialize
    showPage(1);
    
    // Re-paginate after sorting
    table.bind("sortEnd", function() {
        // Tablesorter re-orders DOM elements, so we need to re-fetch rows
        rows = table.find("tbody tr");
        showPage(currentPage);
    });
}); 
</script>
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

    // Load all entries for JS pagination
	$entry_count = $db->query( "SELECT * " . $search );
	$entry_count = $db->num_rows( "SELECT * " . $search );
  
	/* MySQL Retrieve Information */

	$query = $db->query( "SELECT * " . $search ); 

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
	echo '<input type="text" name="search_term" value="' . htmlspecialchars(stripslashes($search_term)) . '" maxlength="40" />' . NL;

	// Print The End of the form
	echo ' <input type="submit" value="Go" />' . NL;
	echo '</td>' . NL;
	echo '<td align="right" width="125"></td>' . NL;
	echo '</tr></table></form>' . NL;

	/* Print the Table */

	echo '<table class="sortable" style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">' . NL;
    echo '<thead>';

	// Item Search Table
	if( $search_area == 'itemsearch' ) {
		echo '<tr>' . NL;
		echo '<th width="20%" class="tabletop">Item</th>' . NL;
		echo '<th width="18%" class="tabletop">Price</th>' . NL;
		echo '<th width="15%" class="tabletop">Stock</th>' . NL;
		echo '<th width="20%" class="tabletop">Location</th>' . NL;
		echo '<th width="37%" class="tabletop">Found in Shop</th>' . NL;
		echo '</tr>' . NL;
        echo '</thead><tbody>';

		while( $info = $db->fetch_array( $query ) ) {
			echo '<tr>' . NL;
			echo '<td class="tablebottom">' . htmlspecialchars($info['item_name']) . '</td>' . NL;
			echo '<td class="tablebottom">' . number_format( $info['item_price'] ) . '' . htmlspecialchars($info['item_currency']) . '</td>' . NL;

			if ( $info['use_stock'] == 0 ) {
				echo '<td class="tablebottom">-</td>' . NL;
			}
			else {
				$info['item_stock'] = $info['item_stock'] == -1 ? '&#8734;' : $info['item_stock'];
				echo '<td class="tablebottom">' . $info['item_stock'] . '</td>' . NL;
			}
				echo '<td class="tablebottom">' . htmlspecialchars($info['location']) . '</td>' . NL;
			echo '<td class="tablebottom"><a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?id=' . (int)$info['shop_id'] . '" title="View Shop">' . htmlspecialchars($info['name']) . '</a></td>' . NL;
			echo '</tr>' . NL;
		}
	}
	// Regular Table

	else {
		echo '<tr>' . NL;
		echo '<th width="34%" class="tabletop">Name</th>' . NL;
		echo '<th width="28%" class="tabletop">Location</th>' . NL;
		echo '<th width="15%" class="tabletop">Members?</th>' . NL;
		echo '<th width="23%" class="tabletop">Shopkeeper</th>' . NL;
		echo '</tr>' . NL;
        echo '</thead><tbody>';

		while( $info = $db->fetch_array( $query ) ) {
			echo '<tr>' . NL;
    
    echo '<td class="tablebottom"><a href="?id=' . (int)$info['id'] . '">' . htmlspecialchars($info['name']) . '</a></td>' . NL;
			
			echo '<td class="tablebottom"><a href="?search_area=location&amp;search_term=' . urlencode($info['location']) . '" title="Search Location">' . htmlspecialchars($info['location']) . '</a></td>' . NL;
			echo '<td class="tablebottom">' . htmlspecialchars($info['member']) . '</td>' . NL;
			echo '<td class="tablebottom">' . htmlspecialchars($info['shopkeeper']) . '</td>' . NL;
			echo '</tr>' . NL;
		} 
	}

	// If No Search Results

	if( $entry_count == 0 ) {
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="5">Sorry, no entries match your search criteria.</td>' . NL;
		echo '</tr>' . NL;
	}
    echo '</tbody>';

	echo '</table><br />' . NL;
    
    // JS Pagination Controls Container
    echo '<div id="pagination-controls" style="text-align:center;"></div>';

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
	$info = $db->fetch_row( "SELECT * FROM `shops` WHERE `id` = " . (int)$id );
	$inventory = $db->query( "SELECT * FROM `shops_items` WHERE `shop_id` = " . (int)$id . " ORDER BY `".$category."` ".$order.", `item_price` DESC, `item_name` ASC" );

?>
<div style="margin:1pt; font-size:large; font-weight:bold;">
&raquo; <a href="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>">OSRS RuneScape Shops Database</a> &raquo; <u><?php echo htmlspecialchars($info['name'] ?? ''); ?></u></div>
<hr class="main" noshade="noshade" />
<br />
<?php

	/* Print the Table */

	// General Shop Information
	echo '<table cellspacing="0" width="75%" style="border: 1px solid #000000; border-top: none" cellpadding="4" align="center">' . NL;
	echo '<tr><td colspan="4" class="tabletop">' . htmlspecialchars($info['name'] ?? '') . '&nbsp;</td></tr>' . NL;
	echo '<tr><td width="10" rowspan="4" style="border: none; border-right: 1px solid #000000"><img src="/img/shopimg/' . htmlspecialchars($info['image'] ?? '') . '" alt="Map of ' . htmlspecialchars($info['name'] ?? '') . '" /></td>' . NL;
	echo '<td width="20%">Location:</td><td><a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?search_area=location&amp;search_term=' . urlencode($info['location'] ?? '') . '" title="Find other shops at this location.">' . htmlspecialchars($info['location'] ?? '') . '</a></td></tr>' . NL;
	echo '<tr><td>Members:</td><td>' . htmlspecialchars($info['member'] ?? '') . '</td></tr>' . NL;
	echo '<tr><td>Shopkeeper:</td><td>' . htmlspecialchars($info['shopkeeper'] ?? '') . '</td></tr>' . NL;
	echo '<tr><td>Extra Notes:</td><td>' . htmlspecialchars($info['notes'] ?? '') . '</td></tr>' . NL;
	echo '</table><br />' . NL;

	// Inventory Information
	echo '<table cellspacing="0" width="75%" style="border: none; border-left: 1px solid #000000" cellpadding="4" align="center"><tr>' . NL;
	echo '<th class="tabletop">Item</th>' . NL;
	echo '<th class="tabletop">Price</th>' . NL;

	if ( ($info['use_stock'] ?? 0) == 1 ) {
		echo '<th class="tabletop">Default Stock</th>' . NL;
	}
	echo '</tr>' . NL;
	while( $item = $db->fetch_array( $inventory ) ) {
	$item['item_stock'] = $item['item_stock'] == -1 ? '&#8734;' : $item['item_stock'];
		echo '<tr align="center">' . NL;
		echo '<td class="tablebottom"><a href="/items.php?search_area=name&amp;search_term=' . urlencode($item['item_name']) . '" title="Find in Item Database">' . htmlspecialchars($item['item_name']) . '</a></td>' . NL;
		echo '<td width="30%" class="tablebottom">' . number_format( $item['item_price'] ) . '' . htmlspecialchars($item['item_currency']) . '</td>' . NL;

		if ( ($info['use_stock'] ?? 0) == 1 ) {
			echo '<td width="30%" class="tablebottom">' . $item['item_stock'] . '</td>' . NL;
		}
		echo '</tr>' . NL;
	} 
	echo '</table><br />' . NL;

	// The Credits
	echo '<table width="75%" cellspacing="0" cellpadding="4" style="border: 1px solid #000000" align="center">' . NL;
	echo '<tr><td>Credits: ' . htmlspecialchars($info['credits'] ?? '') . '</td></tr>' . NL;
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
