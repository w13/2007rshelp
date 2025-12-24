
<?php
require( 'backend.php' );
require( 'price_cat_functions.inc.php' );
start_page(10, 'New Category', 'popup.inc');

require( 'edit_class.php' );
$edit = new edit( 'price_groups', $db );

echo '<div class="boxtop" style="width:476px;">Price Editor</div>' . NL . '<div class="boxbottom" style="width:430px;padding:6px 24px 0 24px;">' . NL;

if( isset( $_POST['act'] ) AND $_POST['act'] == 'edit' )  {

	// Changing the Title
	$TITLE = 'Processing';

	$id = intval( $_POST['id'] );
	$par = base64_decode( $_POST['par'] );
	
	$title = $edit->add_update( $id, 'title', $_POST['title'], 'You must enter a title.' );
	$after = $edit->add_update( $id, 'after', $_POST['after'], 'That\'s not a valid placement selection.' );
	$items = $edit->add_update( $id, 'items', $_POST['items'], '', false );
	$text = $edit->add_update( $id, 'text', $_POST['text'], '', false );
	$oleft = $edit->add_update( $id, 'lft', $_POST['lft'], 'No old left given.' );
	$oright = $edit->add_update( $id, 'rgt', $_POST['rgt'], 'No old right given.' );

	if( !$edit->no_errors ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		edit_category($after, $oleft, $oright, $id, addslashes($title), $items, addslashes($text));
		echo '<p align="center">Entry has been updated...</p>' . NL;
		?>
		<SCRIPT LANGUAGE="JavaScript"><!--
		go_parent('price.php?<?php echo $par; ?>')
		delay_close()
		//---></SCRIPT>
		<?php
	}
}
elseif( isset( $_POST['act'] ) AND $_POST['act'] == 'new' )  {

	// Changing the Title
	$TITLE = 'Processing';

	$title = $edit->add_new( 1, 'title', $_POST['title'], 'You must enter a title.' );
	$after = $edit->add_new( 1, 'after', $_POST['after'], 'That\'s not a valid placement selection.' );
	$text = $edit->add_new( 1, 'text', $_POST['text'], '', false );
	$items = $edit->add_new( 1, 'items', $_POST['items'], '', false );

	if( !$edit->no_errors ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		add_category($after, addslashes($title), $items, addslashes($text));

		$par = base64_decode( $_POST['par'] );
		echo '<p align="center">Entry has been added...</p>' . NL;
		?>
		<SCRIPT LANGUAGE="JavaScript"><!--
		go_parent('price.php?<?php echo $par; ?>')
		delay_close()
		//---></SCRIPT>
		<?php
	}
}
elseif( isset( $_GET['act'] ) AND ( ( $_GET['act'] =='new' AND isset( $_GET['after'] ) ) OR ( $_GET['act'] =='edit' AND isset( $_GET['id'] ) ) ) ) {
	
	if( $_GET['act'] =='edit' ) {

		$id = $_GET['id'];
		$info = $db->fetch_row("SELECT * FROM price_groups WHERE id = " . $id );
	
		if( $info ) {
			$title = $info['title'];
			$after = $info['lft'] - 1;
			$items = $info['items'];
			$lft = $info['lft'];
			$rgt = $info['rgt'];
			$text = $info['text'];
			
			// Changing the Title
			$TITLE = $title;
		}
		else {
			$_GET['act'] = 'new';
			$title = '';
			$after = 0;
			$items = 1;
			$text = '';
		}
	}
	else {
		$title = '';
		$after = $_GET['after'];
		$items = 1;
		$text = '';
	}
	echo '<script src="/editor/extras/disable.js" type="text/javascript"></script>'.NL;
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post" name="form">' . NL;
	echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />' . NL;
	
	if( $_GET['act'] =='edit' ) {
		$count_des = count_descendants($lft, $rgt);
		echo '<input type="hidden" name="id" value="' . $id . '" />' . NL;
		echo '<input type="hidden" name="lft" value="' . $lft . '" />' . NL;
		echo '<input type="hidden" name="rgt" value="' . $rgt . '" />' . NL;
		echo '<input type="hidden" name="par" value="' . base64_encode( base64_decode( $_GET['par'] ) . '&anchor=' . $id ) . '" />' . NL;
	}
	else {
		$count_des = 0;
		echo '<input type="hidden" name="par" value="' . $_GET['par'] . '" />' . NL;
	}
	
	echo '<table width="100%">' . NL;
	echo '<tr><td>Title:</td><td><input type="text" name="title" value="' . htmlentities($title) . '" size="30" /></td></tr>' . NL;
	echo '<tr><td>Placement:</td><td><select name="after">';
    echo '<option value="1" style="font-weight: bold; font-size: 11px;">Top of Category Listing</option>' . NL;
	$tree = display_tree(1);
	for($num = 1; array_key_exists($num, $tree); $num++) {
		$ind = str_repeat('--', $tree[$num]['ind']-1);
		if($tree[$num]['ind'] == 1 AND $tree[$num]['id'] != $id AND ($tree[$num]['lft'] > $rgt OR $tree[$num]['lft'] < $lft)) {
			echo '<option value="0">&nbsp;</option>' . NL;
			if($tree[$num]['lft'] == $after) {
                echo '<option value="' . $tree[$num]['rgt'] . '" style="font-weight: bold; font-size: 11px;">After ' . $tree[$num]['title'] . '</option>' . NL;
				echo '<option value="' . $tree[$num]['lft'] . '" selected="selected">' . $ind . '-- Inside \'' . $tree[$num]['title'] . '\'</option>' . NL;
			}
			elseif($tree[$num]['rgt'] == $after) {
                echo '<option value="' . $tree[$num]['rgt'] . '" style="font-weight: bold; font-size: 11px;" selected="selected">After ' . $tree[$num]['title'] . '</option>' . NL;
				echo '<option value="' . $tree[$num]['lft'] . '">' . $ind . '-- Inside \'' . $tree[$num]['title'] . '\'</option>' . NL;
			}
			else {
                echo '<option value="' . $tree[$num]['rgt'] . '" style="font-weight: bold; font-size: 11px;">After ' . $tree[$num]['title'] . '</option>' . NL;
				echo '<option value="' . $tree[$num]['lft'] . '">' . $ind . '-- Inside \'' . $tree[$num]['title'] . '\'</option>' . NL;
			}		
		}
		elseif($tree[$num]['id'] != $id AND ($tree[$num]['lft'] > $rgt OR $tree[$num]['lft'] < $lft)) {
			if($tree[$num]['lft'] == $after) {
				echo '<option value="' . $tree[$num]['rgt'] . '">' . $ind . ' After \'' . $tree[$num]['title'] . '\'</option>' . NL;
				echo '<option value="' . $tree[$num]['lft'] . '" selected="selected">' . $ind . '-- Inside \'' . $tree[$num]['title'] . '\'</option>' . NL;
			}
			elseif($tree[$num]['rgt'] == $after) {
				echo '<option value="' . $tree[$num]['rgt'] . '" selected="selected">' . $ind . ' After \'' . $tree[$num]['title'] . '\'</option>' . NL;
				echo '<option value="' . $tree[$num]['lft'] . '">' . $ind . '-- Inside \'' . $tree[$num]['title'] . '\'</option>' . NL;
			}
			else {
				echo '<option value="' . $tree[$num]['rgt'] . '">' . $ind . ' After \'' . $tree[$num]['title'] . '\'</option>' . NL;
				echo '<option value="' . $tree[$num]['lft'] . '">' . $ind . '-- Inside \'' . $tree[$num]['title'] . '\'</option>' . NL;
			}
		}
	}
	echo '</select></td></tr>' . NL;
	if($items) {
		echo '<tr><td>Allow Items:</td><td><input type="checkbox" name="items" value="1" checked="checked" onchange="changefield();" /></td></tr>' . NL;
	}
	else {
		echo '<tr><td>Allow Items:</td><td><input type="checkbox" name="items" value="1" onchange="changefield();" /></td></tr>' . NL;
	}
	echo '<tr><td colspan="2">Category Notes:</td></tr>' . NL;
	if($items) {
        echo '<tr><td colspan="2"><textarea name="text" rows="8" style="width: 100%;">'.$text.'</textarea></td></tr>' . NL;
    }
    else {
        echo '<tr><td colspan="2"><textarea name="text" rows="8" style="width: 100%;" disabled="disabled">'.$text.'</textarea></td></tr>' . NL;
    }
	echo '</table>' . NL;
	echo '<p align="center"><input type="submit" value="Submit" /></p>' . NL;
	echo '</form>' . NL;

}
else {
	echo '<p align="center">Error</p>' . NL;
}

echo '</div>';

end_page();
?>