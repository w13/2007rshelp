<?php

function display_tree($root_id) {
	global $db;
	
	// Create the tree array
	$tree = array();
	$root_id = intval($root_id);
	
	// Retrieve the left and right value of the ROOT node
	$query = $db->query("SELECT lft, rgt FROM price_groups WHERE id = " . $root_id);
	$root = $db->fetch_array($query);

	// Start with an empty PARENT array - Used to monitor each parent of the current category.
	$parents = array();

	// Now, retrieve all descendants of the $root node
	$result = $db->query("SELECT * FROM price_groups WHERE lft BETWEEN " . intval($root['lft']) . " AND " . intval($root['rgt']) . " ORDER BY lft ASC");

	// Display Each Category Row
	while($row = $db->fetch_array($result)) {
		
		if(count($parents) > 0) {								// If the PARENT array is populated,
			while ( $parents[count($parents)-1] < $row['rgt']) {	// ...While the last entry is not a parent of current category.
				array_pop($parents);									// ...Get rid of the last entry.
			}
		}
		$extra = array( 'ind' => count($parents) );
		$tree[] = array_merge($row, $extra);

		// Add this category to the PARENT stack.
		$parents[] = $row['rgt'];
	}
	return $tree;
}

function rebuild_tree($parent_id, $left) {
	global $db;
   // The right value of this category is the left value + 1
   $left = intval($left);
   $parent_id = intval($parent_id);
   $right = $left + 1;

   // For each child of this category.
   $query = $db->query("SELECT id FROM price_groups WHERE parent = " . $parent_id . " ORDER BY lft ASC");
   while ($info = $db->fetch_array($query)) {
       // Rebuild descendants of this category.
       $right = rebuild_tree($info['id'], $right);
   }

   // All children and descendants (If any) of this category have been rebuilt.
   
   // Update category with left and right values.
   $db->query("UPDATE price_groups SET lft=" . $left . ", rgt=" . $right . " WHERE id=" . $parent_id );

   // Return the next value to be assigned.
   $next_val = $right + 1;
   return $next_val;
} 

function delete_category($id, $left, $right) {
	global $db;
	
	$id = intval($id);
	$left = intval($left);
	$right = intval($right);

	$db->query("DELETE FROM price_groups WHERE lft BETWEEN " . $left . " AND " . $right );
	
	$change = $right - $left + 1;
	$db->query("UPDATE price_groups SET rgt = rgt-" . $change . " WHERE rgt >= " . $left );
	$db->query("UPDATE price_groups SET lft = lft-" . $change . " WHERE lft >= " . $left );
}

function edit_category($after, $oleft, $oright, $id, $title, $items, $text) {
	global $db;

	$after = intval($after);
	$oleft = intval($oleft);
	$oright = intval($oright);
	$id = intval($id);
	$title = $db->escape_string($title);
	$text = $db->escape_string($text);

	$change = $oright - $oleft + 1;
	if($after >= $oleft) $after = $after - $change;

	$db->query("UPDATE price_groups SET rgt = rgt-" . $change . " WHERE rgt >= " . $oleft );
	$db->query("UPDATE price_groups SET lft = lft-" . $change . " WHERE lft >= " . $oleft );
	
	$left = $after + 1;

	$db->query("UPDATE price_groups SET rgt = rgt+" . $change . " WHERE rgt >= " . $left );
	$db->query("UPDATE price_groups SET lft = lft+" . $change . " WHERE lft >= " . $left );

	rebuild_tree($id, $left);
	
	$info = $db->fetch_row("SELECT * FROM price_groups WHERE rgt = " . $after . " OR lft = " . $after);
	if( ($info['lft'] ?? 0) == $after ) {
		$parent = $info['id'] ?? 0;
	}
	else {
		$parent = $info['parent'] ?? 0;
	}
	
	$items = intval( $items );
	$db->query("UPDATE price_groups SET items = " . $items . ", parent = " . intval($parent) . ", title='" . $title . "', text = '" . $text . "' WHERE id = " . $id);

	return;
}

function add_category($after, $title, $items, $text) {
	global $db;

	$after = intval($after);
	$title = $db->escape_string($title);
	$text = $db->escape_string($text);

	$info = $db->fetch_row("SELECT * FROM price_groups WHERE rgt = " . $after . " OR lft = " . $after);
	if( ($info['lft'] ?? 0) == $after ) {
		$parent = $info['id'] ?? 0;
	}
	else {
		$parent = $info['parent'] ?? 0;
	}
	$left = $after + 1;
	$right = $left + 1;

	$db->query("UPDATE price_groups SET rgt = rgt+2 WHERE rgt >= " . $left );
	$db->query("UPDATE price_groups SET lft = lft+2 WHERE lft >= " . $left );

	$items = intval( $items );
	$db->query("INSERT INTO price_groups SET lft = " . $left . ", rgt = " . $right . ", items = " . $items . ", parent = " . intval($parent) . ", title='" . $title . "', text = '" . $text . "'");

	return;
}

function count_descendants($left = 1, $right = 2) {
	$num = $right - $left;
	$num = $num - 1;
	$num = $num / 2 ;
	return $num;
}

?>