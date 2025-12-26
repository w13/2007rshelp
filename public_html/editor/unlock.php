<?php
require( 'backend.php' );
start_page( 15, 'Unlock Page' );

$table_array = array('testing');

echo '<div class="boxtop">Unlock Page</div>
<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">';

$id = intval($_GET['id']);
$table = addslashes($_GET['table']);

if (!$_POST) {
	if (in_array($table,$table_array)) {
		$query = $db->query("SELECT * FROM `".$table."` WHERE `id`=".$id);
		$info = $db->fetch_array($query);
		echo '<center>Are you sure you want to unlock "'.$info['name'].'"?<br /><br />'
			.'<form method="post" action="'.$_SERVER['REQUEST_URI'].'">'
			.'<input type="submit" name="del_yes" value="Yes" /><br /><br />'
			.'<input type="submit" value="No" /><br /><br />'
			.'<input type="hidden" name="redirect" value="'.$_SERVER['HTTP_REFERER'].'" />'
			.'</form></center>';
	} else {
		echo 'Error!';
		header("refresh:3;url=".$_SERVER['HTTP_REFERER']);
	}
} else {
	if (in_array($table,$table_array) && $_POST['del_yes'] == 'Yes') {
		$db->query("UPDATE `".$table."` SET `locked`=0,`locked_user`='' WHERE `id`=".$id);
		echo '<p class="info">The guide has been unlocked.</p><br /><br />';
		header("refresh:3;url=".$_POST['redirect']);
	} else {
		echo 'Error!';
		header("refresh:3;url=".$_POST['redirect']);
	}
}

echo '</div>';
end_page();
?>