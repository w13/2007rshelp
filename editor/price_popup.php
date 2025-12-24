
<?php
require('backend.php');
start_page(10, 'New Item', '/popup.inc');
echo '<div class="boxtop" style="width:389px;">Price Editor</div>' . NL . '<div class="boxbottom" style="width:355px;padding:6px 24px 0 12px;">' . NL;

require('price_cat_functions.inc.php');
require('edit_class.php');
$edit = new edit('price_items', $db);
if(isset($_POST['member'])) {
	setcookie('price_member', $_POST['member']);
}

if(isset($_POST['act']) AND $_POST['act'] == 'edit')  {

	// Changing the Title
	$TITLE = 'Processing';
		
	$id = intval($_POST['id']);
	$par = base64_decode($_POST['par']);
	
	if(isset($_POST['refresh'])) {
		$par = $par . '&anchor=' . $id;
		setcookie('price_refresh', 'yes', time() + 1800);
	}
	else {
		unset($par);
		setcookie('price_refresh', 'no', time() + 1800);
	}
		
	$name = $edit->add_update($id, 'name', $_POST['name'], 'You must enter a name.');
	$jagex_pid = $edit->add_update($id, 'jagex_pid', $_POST['jagex_pid'], 'You must enter a jagex_pid.');
	$category = $edit->add_update($id, 'category', $_POST['category'], 'You may not add items to that category.');
	$price_low = $edit->add_update($id, 'price_low', $_POST['price_low'], 'You must enter a price in the lower field.');
	$price_high = $edit->add_update($id, 'price_high', $_POST['price_high'], '', false);
	$member = $edit->add_update($id, 'member', $_POST['member'], '', false);
	$keywords = $edit->add_update($id, 'keywords', $_POST['keywords'], '', false);
	
	if($_POST['price_low'] == $_POST['olprice'] AND $_POST['price_high'] == $_POST['ohprice']) {
		  $ses->record_act('Price, No Chng', 'Edit', $name, $ip);
      $execution = $edit->run_all(false, false);
	}
	else {
		$db->query("UPDATE price_items SET reports = 0 WHERE id = ".$id);
	  $avgprice = ( $price_low + $price_high ) / 2;
		$db->query("INSERT INTO `price_history` (`pid`, `avgprice`, `time`) VALUES ('".$id."', '".$avgprice."', UNIX_TIMESTAMP())");
		$db->query("UPDATE `price_history` SET bin = 0 WHERE pid = ".$id." AND bin = 1");
		$row = $db->fetch_row("SELECT MAX( id ) as id FROM price_history WHERE id != (SELECT MAX( id ) FROM price_history WHERE pid = ".$id." ) AND pid = ".$id);
		$db->query("UPDATE `price_history` SET bin = 1 WHERE id = ".$row['id']);
	
	  $ses->record_act('Price Guide', 'Edit', $name, $ip);
		$execution = $edit->run_all(true, true);
	}

	if(!$execution) {
		echo '<p style="text-align:center;">' . $edit->error_mess . '<br />' . NL
		    .'<a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		echo '<p align="center">Entry has been updated...</p>' . NL;
        $db->query("UPDATE price_items SET phold_cat = ".$category.", name = '".addslashes($name)."' WHERE phold_id = ".$id);
		echo '<SCRIPT LANGUAGE="JavaScript"><!-- ' . NL;
		if(isset($par)) {
		$par = addslashes($par);
		echo 'go_parent(\'price.php?' . $par . '\')' . NL;
		}
		echo 'delay_close()' . NL;
		echo '//---></SCRIPT>' . NL;
	}
}

elseif(isset($_POST['act']) AND $_POST['act'] == 'new')  {

	// Changing the Title
	$TITLE = 'Processing';

	$par = base64_decode($_POST['par']);

	if(isset($_POST['refresh'])) {
		$par = $par . '&anchor=ilist';
		setcookie('price_refresh', 'yes', time() + 1800);
	}
	else {
		unset($par);
		setcookie('price_refresh', 'no', time() + 1800);
	}
	
	$name = $edit->add_new(1, 'name', $_POST['name'], 'You must enter a name.');
	$jagex_pid = $edit->add_new(1, 'jagex_pid', $_POST['jagex_pid'], 'You must enter a jagex_pid.');
	$category = $edit->add_new(1, 'category', $_POST['category'], 'You may not add items to that category.');
	$iorder = $edit->add_new(1, 'iorder', $_POST['iorder'], '', false);
	$price_low = $edit->add_new(1, 'price_low', $_POST['price_low'], 'You must enter a price in the lower field.');
	$price_high = $edit->add_new(1, 'price_high', $_POST['price_high'], '', false);
	$member = $edit->add_new(1, 'member', $_POST['member'], '', false);
	$keywords = $edit->add_new(1, 'keywords', $_POST['keywords'], '', false);
	
	$ses->record_act('Price Guide', 'New', $name, $ip);
	$execution = $edit->run_all(true, true);
	$avgprice = ( $price_low + $price_high ) / 2; // The 1 below, sets the item to visible. There needs to be another with a 0 after it.
	
$table = $db->query("SHOW TABLE STATUS LIKE 'price_items'");
$rows = mysql_fetch_assoc($table);
$next_id = $rows['Auto_increment'];
	$db->query("INSERT INTO `price_history` (`bin`, `pid`, `avgprice`, `time`) VALUES (1, ".$next_id.", '".$avgprice."', UNIX_TIMESTAMP())");
	mysqli_query($db->connect, "INSERT INTO `price_history` (`bin`, `pid`, `avgprice`, `time`) VALUES (0, ".$next_id.", '".$avgprice."', UNIX_TIMESTAMP())");
  
	if(!$execution) {
		echo '<p  style="text-align:center;">' . $edit->error_mess . '<br />' . NL
        .'<a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		
		$db->query("UPDATE price_items SET iorder = iorder + 1 WHERE category = '" . addslashes($category) . "' AND iorder >= " . $iorder . " AND name != '" . addslashes($name) . "'");
		echo '<p align="center">Entry has been added...</p>' . NL;
		echo '<SCRIPT LANGUAGE="JavaScript"><!-- ' . NL;
		if(isset($par)) echo 'go_parent(\'price.php?' . $par . '\')' . NL;
		echo 'delay_close()' . NL;
		echo '//---></SCRIPT>' . NL;
	}
}
elseif(isset($_GET['act']) AND (($_GET['act'] =='new' AND isset($_GET['category'])) OR ($_GET['act'] == 'edit' AND isset($_GET['id'])))) {

	if($_GET['act'] =='edit') {

		$id = $_GET['id'];
		$info = $db->fetch_row("SELECT * FROM price_items WHERE id = " . $id . " AND phold_id = 0");
	
		if($info) {
			$name = $info['name'];
			$jagex_pid = $info['jagex_pid'];
			$category = $info['category'];
			$member = $info['member'];
			$price_low = $info['price_low'];
			$price_high = $info['price_high'];
			$keywords = $info['keywords'];
			
			// Changing the Title
			$TITLE = $name;
		}
		else {
			$_GET['act'] = 'new';
			$name = '';
			$jagex_pid = '';
			$member = $_COOKIE['price_member'];
			$category = 1;
			$price_low = 1;
			$price_high = '';
			$keywords = '';
		}
	}
	else {
		$name = '';
		$jagex_pid = '';
		$category = $_GET['category'];
		$member = $_COOKIE['price_member'];
		$price_low = 1;
		$price_high = '';
		$keywords = '';
	}

	$cat = $db->fetch_row("SELECT title, id FROM price_groups WHERE id = " . $category . " AND items = 1");
	
	if($cat) {
	
		echo '<form name="form" action="' . $_SERVER['PHP_SELF'] . '" method="post">' . NL;
		echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />' . NL;
		
		if($_GET['act'] =='edit') {
			echo '<input type="hidden" name="id" value="' . $id . '" />' . NL;
			echo '<input type="hidden" name="par" value="' . $_GET['par'] . '" />' . NL;
			echo '<input type="hidden" name="olprice" value="' . $price_low . '" />' . NL;
			echo '<input type="hidden" name="ohprice" value="' . $price_high . '" />' . NL;
		}
		else {
			echo '<input type="hidden" name="par" value="' . $_GET['par'] . '" />' . NL;

		}
		
		echo '<table width="100%">' . NL;
		echo '<tr><td>Name:</td><td><input type="text" name="name" value="' . htmlentities($name) . '" style="width: 100%;" /></td></tr>' . NL;
		echo '<tr><td>Jagex Price ID:</td><td><input type="text" name="jagex_pid" value="' . intval($jagex_pid) . '" style="width: 50%;" /></td></tr>' . NL;
		echo '<tr><td>Keywords:</td><td><input type="text" name="keywords" value="' . $keywords . '" style="width: 100%;" /></td></tr>' . NL;
		if($member == 1) {
			echo '<tr><td>Members:</td><td><select name="member"><option value="1" selected="selected">Yes</option><option value="0">No</option></select></td></tr>' . NL;
		}
		else {
			echo '<tr><td>Members:</td><td><select name="member"><option value="1">Yes</option><option value="0" selected="selected">No</option></select></td></tr>' . NL;
		}
		
		if($_GET['act'] == 'new') {
		
			echo '<tr><td>Category:</td><td><input type="hidden" name="category" value="' . $cat['id'] . '" />' . $cat['title'] . '</td></tr>' . NL;

			echo '<tr><td>Placement:</td><td><select name="iorder">';
			$query = $db->query("SELECT * FROM price_items WHERE category = " . $category . " ORDER BY price_items.iorder ASC");
			$num = mysqli_num_rows($query);
			echo '<option value="1">Beginning of List</option>' . NL;
			while($info = $db->fetch_array($query)) {
				$option = $info['iorder'] + 1;
				if($info['iorder'] == $num) {
					echo '<option value="' . $option . '" selected="selected">After ' . $info['name'] . '</option>' . NL;
				}
				else {
					echo '<option value="' . $option . '">After ' . $info['name'] . '</option>' . NL;
				}
			}
		}
		else {
			echo '<tr><td>Category:</td><td><select name="category">'  . NL;
			$tree = display_tree(1);
			for($num = 1; array_key_exists($num, $tree); $num++) {
				$ind = str_repeat('--', $tree[$num]['ind']-1);
				if($tree[$num]['ind'] < 2) {
					echo '<option value="0">&nbsp;</option>' . NL;
					echo '<option value="0" style="font-weight: bold; font-size: 11px;">' . $tree[$num]['title'] . '</option>' . NL;
				}
				else {
					if($tree[$num]['id'] == $category) {
						echo '<option value="' . $tree[$num]['id'] . '" selected="selected">' . $ind . ' ' . $tree[$num]['title'] . '</option>' . NL;			
					}
					else {
						echo '<option value="' . $tree[$num]['id'] . '">' . $ind . ' ' . $tree[$num]['title'] . '</option>' . NL;
					}
				}
			}
			echo '</select></td></tr>' . NL;
		}
		echo '<tr><td>Price Low:</td><td><input type="text" name="price_low" value="' . $price_low . '" autocomplete="off" /></td></tr>' . NL;
		echo '<tr><td>Price High:</td><td><input type="text" name="price_high" value="' . $price_high . '" autocomplete="off" /></td></tr>' . NL;

		if(!isset($_COOKIE['price_refresh']) OR $_COOKIE['price_refresh'] == 'yes') {
			echo '<tr><td>Reload Main:</td><td><input type="checkbox" name="refresh" value="true" checked="checked" /></td></tr>' . NL;
		}
		else {
			echo '<tr><td>Reload Main:</td><td><input type="checkbox" name="refresh" value="true" /></td></tr>' . NL;
		}
		echo '</table>' . NL;
		echo '<p align="center"><input type="submit" value="Submit" /><br /><br />' . NL;
		echo 'For single price, only use low price bound.<br />Keywords seperated by a space <b>only</b>.</p>' . NL;
		echo '</form>' . NL;
	}
	else {
		echo '<p align="center">Error 1</p>' . NL;
	}

}
else {
	echo '<p align="center">Error 2</p>' . NL;
}

echo '</div>';

end_page();
?>