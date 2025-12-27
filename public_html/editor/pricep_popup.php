<?php
require('backend.php');
start_page(10, 'Placeholder', 'popup.inc');
echo '<div class="boxtop" style="width:396px;">Placeholder Editor</div>'.NL.'<div class="boxbottom" style="width:350px;padding:6px 24px 0 24px;">'.NL;

require('price_cat_functions.inc.php');
require('edit_class.php');
$edit = new edit('price_items', $db);

if(isset($_POST['act']) AND $_POST['act'] == 'edit')  {

	// Changing the Title
	$TITLE = 'Processing';
		
	$id = intval($_POST['id']);
	$par = base64_decode($_POST['par']);
	
	if(isset($_POST['refresh'])) {
		$par = $par.'&anchor='.$id;
		setcookie('price_refresh', 'yes', time() + 1800);
	}
	else {
		unset($par);
		setcookie('price_refresh', 'no', time() + 1800);
	}

	$category = $edit->add_update($id, 'category', $_POST['category'], 'You may not add a placeholder to that category.');
	$phold_id = $edit->add_update($id, 'phold_id', $_POST['phold_id'], 'You must enter an item ID.');
	
	if(intval($_POST['phold_id']) == 0) {
        $edit->do_error('Item ID must be an integer.');
	}
	else {
		$query = $db->query("SELECT * FROM price_items WHERE id = ".intval($_POST['phold_id']));
		if(mysqli_num_rows($query) == 0) {
			$edit->do_error('That item ID does not exist.');
		}
		else {
			$info = $db->fetch_array($query);
			$name = $edit->add_update($id, 'name', $info['name'], '', false);
			$phold_cat = $edit->add_update($id, 'phold_cat', $info['category'], '', false);
		}
	}	
    $execution = $edit->run_all(false, false);
	
	if(!$execution) {
		echo '<p align="center">'.$edit->error_mess.'</p>'.NL;
		echo '<p align="center"><a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>'.NL;
	}
	else {
		echo '<p align="center">Entry has been updated...</p>'.NL;

		echo '<SCRIPT LANGUAGE="JavaScript"><!-- '.NL;
		if(isset($par)) echo 'go_parent(\'price.php?'.$par.'\')'.NL;
		echo 'delay_close()'.NL;
		echo '//---></SCRIPT>'.NL;

	}
}

elseif(isset($_POST['act']) AND $_POST['act'] == 'new')  {

	// Changing the Title
	$TITLE = 'Processing';

	$par = base64_decode($_POST['par']);

	if(isset($_POST['refresh'])) {
		$par = $par.'&anchor=ilist';
		setcookie('price_refresh', 'yes', time() + 1800);
	}
	else {
		unset($par);
		setcookie('price_refresh', 'no', time() + 1800);
	}

	
	$category = $edit->add_new(1, 'category', $_POST['category'], 'You may not add a placeholder to that category.');
	$phold_id = $edit->add_new(1, 'phold_id', $_POST['phold_id'], 'You must enter an item ID.');
	$iorder = $edit->add_new(1, 'iorder', $_POST['iorder'], '', false);


	if(intval($_POST['phold_id']) == 0) {
        $edit->do_error('Item ID must be an integer.');
	}
	else {
		$query = $db->query("SELECT * FROM price_items WHERE id = ".intval($_POST['phold_id']));
		if(mysqli_num_rows($query) == 0) {
			$edit->do_error('That item ID does not exist.');
		}
		else {
			$info = $db->fetch_array($query);
			$name = $edit->add_new(1, 'name', $info['name'], '', false);
			$phold_cat = $edit->add_new(1, 'phold_cat', $info['category'], '', false);
		}
	}	
	$execution = $edit->run_all(false, false);
	
	if(!$execution) {
		echo '<p align="center">'.$edit->error_mess.'</p>'.NL;
		echo '<p align="center"><a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>'.NL;
	}
	else {
		
		$db->query("UPDATE price_items SET iorder = iorder + 1 WHERE category = '".addslashes($category)."' AND iorder >= ".$iorder." AND name != '".addslashes($name)."'");
		echo '<p align="center">Entry has been added...</p>'.NL;
		echo '<SCRIPT LANGUAGE="JavaScript"><!-- '.NL;
		if(isset($par)) echo 'go_parent(\'price.php?'.$par.'\')'.NL;
		echo 'delay_close()'.NL;
		echo '//---></SCRIPT>'.NL;
	}
}
elseif(isset($_GET['act']) AND (($_GET['act'] =='new' AND isset($_GET['category'])) OR ($_GET['act'] =='edit' AND isset($_GET['id'])))) {

	if($_GET['act'] =='edit') {

		$id = $_GET['id'];
		$info = $db->fetch_row("SELECT * FROM price_items WHERE id = ".$id);
	
		if($info) {
			$category = $info['category'];
			$phold_id = $info['phold_id'];
		}
		else {
			$_GET['act'] = 'new';
			$category = 1;
			$phold_id = '';
		}
	}
	else {
		$category = $_GET['category'];
		$phold_id = '';
	}

	$cat = $db->fetch_row("SELECT title, id FROM price_groups WHERE id = ".$category." AND items = 1");
	
	if($cat) {
	
		echo '<form name="form" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="post">'.NL;
		echo '<input type="hidden" name="act" value="'.$_GET['act'].'" />'.NL;
		
		if($_GET['act'] =='edit') {
			echo '<input type="hidden" name="id" value="'.$id.'" />'.NL;
			echo '<input type="hidden" name="par" value="'.$_GET['par'].'" />'.NL;
		}
		else {
			echo '<input type="hidden" name="par" value="'.$_GET['par'].'" />'.NL;
		}
		
		echo '<table style="width:100%;">'.NL;
		echo '<tr><td>Item ID:</td><td><input type="text" name="phold_id" value="'.$phold_id.'" size="5" /></td></tr>'.NL;
		
		if($_GET['act'] == 'new') {
			echo '<tr><td>Category:</td><td><input type="hidden" name="category" value="'.$cat['id'].'" />'.$cat['title'].'</td></tr>'.NL;

			echo '<tr><td>Placement:</td><td><select name="iorder">';
			$query = $db->query("SELECT * FROM price_items WHERE category = ".$category." ORDER BY price_items.iorder ASC");
			$num = mysqli_num_rows($query);
			echo '<option value="1">Beginning of List</option>'.NL;
			while($info = $db->fetch_array($query)) {
				$option = $info['iorder'] + 1;
				if($info['iorder'] == $num) {
					echo '<option value="'.$option.'" selected="selected">After '.$info['name'].'</option>'.NL;
				}
				else {
					echo '<option value="'.$option.'">After '.$info['name'].'</option>'.NL;
				}
			}
		}
		else {
			echo '<tr><td>Category:</td><td><select name="category">' .NL;
			$tree = display_tree(1);
			for($num = 1; array_key_exists($num, $tree); $num++) {
				$ind = str_repeat('--', $tree[$num]['ind']-1);
				if($tree[$num]['ind'] < 2) {
					echo '<option value="0">&nbsp;</option>'.NL;
					echo '<option value="0" style="font-weight: bold; font-size: 11px;">'.$tree[$num]['title'].'</option>'.NL;
				}
				else {
					if($tree[$num]['id'] == $category) {
						echo '<option value="'.$tree[$num]['id'].'" selected="selected">'.$ind.' '.$tree[$num]['title'].'</option>'.NL;			
					}
					else {
						echo '<option value="'.$tree[$num]['id'].'">'.$ind.' '.$tree[$num]['title'].'</option>'.NL;
					}
				}
			}
			echo '</select></td></tr>'.NL;
		}
		
		if(!isset($_COOKIE['price_refresh']) OR $_COOKIE['price_refresh'] == 'yes') {
			echo '<tr><td>Reload Main:</td><td><input type="checkbox" name="refresh" value="true" checked="checked" /></td></tr>'.NL;
		}
		else {
			echo '<tr><td>Reload Main:</td><td><input type="checkbox" name="refresh" value="true" /></td></tr>'.NL;
		}
		echo '</table>'.NL;
		echo '<p align="center"><input type="submit" value="Submit" /><br /><br />'.NL;
		echo 'Item ID must be an integer.</p>'.NL;
		echo '</form>'.NL;
	
	}
	else {
		echo '<p align="center">Error</p>'.NL;
	}

}
else {
	echo '<p align="center">Error</p>'.NL;
}

echo '</div>';

end_page();
?>