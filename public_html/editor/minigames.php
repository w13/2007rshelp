<?php

require( 'backend.php' );
require( 'edit_class.php' );
start_page( 2, 'Mini Game Guides' );

$category = 'minigames';
$edit = new edit( $category, $db );

echo '<div class="boxtop">Mini Game Guide</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right:24px;">' . NL;

?>
<div style="float: right;"><a href=""><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="?act=new"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div style="margin:1pt;font-weight:bold;font-size:large;">&raquo; Mini Game Guides</div>
<hr class="main" noshade="noshade" />
<br />

<?php

if( isset( $_POST['act'] ) AND $_POST['act'] == 'edit' AND isset( $_POST['id'] ) ) {

	$id = intval( $_POST['id'] );
	$name = $edit->add_update( $id, 'name', $_POST['name'], 'You must enter a name.' );
	$author = $edit->add_update( $id, 'author', $_POST['author'], 'You must enter an author.' );
	$type = $edit->add_update( $id, 'type', $_POST['type'], '', false );
	$text = $edit->add_update( $id, 'text', $_POST['text'], 'You must enter some content.' );
	$group = $edit->add_update( $id, '`group`', $_POST['group'], 'You must enter a group', false );
	$keyword = $edit->add_update( $id, 'keyword', $_POST['keyword'], 'You must enter a short description.', false );
	$complete = $edit->add_update( $id, 'complete', $_POST['complete'], '', false );
	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
		rpostcontent();
	}
	else {
		$ses->record_act( 'Mini Games', 'Edit', $name, $ip );
		echo '<p align="center">Entry successfully edited into OSRS RuneScape Help Mini Guide Area.</p>' . NL;
		header( 'refresh: 2; url=?cat=' . $category );
	}

}
elseif( isset( $_POST['act'] ) AND $_POST['act'] == 'new' ) {

	$name = $edit->add_new( 1, 'name', $_POST['name'], 'You must enter a name.' );
	$author = $edit->add_new( 1, 'author', $_POST['author'], 'You must enter an author.' );
	$type = $edit->add_new( 1, 'type', $_POST['type'], 'You must enter a type.' );
	$text = $edit->add_new( 1, 'text', $_POST['text'], 'You must enter some content.' );
	$group = $edit->add_new( 1, '`group`', $_POST['group'], 'You must enter a group' );
	$keyword = $edit->add_new( 1, 'keyword', $_POST['keyword'], 'You must enter a description' );
	$complete = $edit->add_new( 1, 'complete', $_POST['complete'], '', false );
	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
		rpostcontent();
	}
	else {
		$ses->record_act( 'Mini Games', 'New', $name, $ip );
		echo '<p align="center">New entry was successfully added into OSRS RuneScape Help Minigame Guides. No Cache has been performed.</p>' . NL;
		header( 'refresh: 2; url=?cat=' . $category );
	}
}

		
elseif( isset( $_GET['act'] ) AND ( ( $_GET['act'] == 'edit' AND isset( $_GET['id'] ) ) OR $_GET['act'] == 'new' ) ) {

	if( $_GET['act'] == 'edit' ) {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM minigames WHERE id = " . $id );
	
		if( $info ) {
			$name = $info['name'];
			$author = $info['author'];
			$type = $info['type'];
			$text = $info['text'];
			$group = $info['group'];
			$keyword = $info['keyword'];
			$complete = $info['complete'];
			
		}
		else {
			$_GET['act'] = 'new';
			$name = '';
			$author = '';
			$type = 0;
			$text = '';
			$group = '';
			$keyword = '';
			$complete = 0;
		}
	}
	else {
		$name = '';
		$author = '';
		$type = 0;
		$text = '';
		$group = '';
		$keyword = '';
		$complete = 0;
	}
	
	echo '<form method="post" action="">' . NL;
	echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />';
	
	if( $_GET['act'] == 'edit' ) {
		enum_correct( $category, $id );
		echo '<input type="hidden" name="id" value="' . $id . '" />';
	  $seltyp = $info['type'] == 1 ? 'checked="checked"' : '';
	  $selcom = $info['complete'] == 1 ? 'checked="checked"' : '';
	} else {
      $seltyp = '';
      $selcom = '';
    }
	echo '<table width="90%" align="center" style="border-left: 1px solid #000000" cellspacing="0">' . NL;
	echo '<tr>' . NL;
	echo '<td class="tabletop" colspan="2">General</td>' . NL;
	echo '</td>' . NL;
	echo '<tr><td class="tablebottom" width="50%">Name:</td><td class="tablebottom"><input type="text" name="name" value="' . $name . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Original Author:</td><td class="tablebottom"><input type="text" name="author" value="' . $author . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Members?</td><td class="tablebottom"><input type="checkbox" name="type" value="1" '.$seltyp.' /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Complete?</td><td class="tablebottom"><input type="checkbox" name="complete" value="1" '.$selcom.' /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Group:</td><td class="tablebottom"><input type="text" name="group" value="' . $group . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Description:<br />Short, to the point. As many keywords from the guide in as possible. Max length is 130 chars. Will cut off if longer.</td><td class="tablebottom"><textarea style="font:9px Verdana;" rows="5" cols="40" name="keyword" width="100%">' . htmlentities( $keyword ) . '</textarea></td></tr>' . NL;
	echo '<tr><td class="tabletop" colspan="2" style="border-top: none;">Content</td>' . NL;
	echo '<tr><td class="tablebottom" colspan="2"><input type="submit" value="Submit All" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom" colspan="2"><textarea rows="15" name="text" style="width: 99%;">' . htmlentities( $text ) . '</textarea></td></tr>' . NL;
	echo '</table><br />' . NL;
	echo '</form><br />' . NL;

	}
	
	elseif( isset( $_GET['act'] ) AND $_GET['act'] == 'delete' AND $ses->permit( 15 ) ) {
	if( isset( $_POST['del_id'] ) ) {
		$edit->add_delete( $_POST['del_id'] );
		$execution = $edit->run_all();
		
		if( !$execution ) {
			echo '<p align="center">' . $edit->error_mess . '</p>';
		}
		else {
			$ses->record_act( 'Mini Games', 'Delete', $_POST['del_name'], $ip );
			header( 'refresh: 2; url=?cat=' . $category );
			echo '<p align="center">Entry successfully deleted from OSRS RuneScape Help.</p>' . NL;
		}
	}
	else {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM minigames WHERE id = " . $id );
	
		if( $info ) {
		
			$name = $info['name'];
			echo '<p align="center">Are you sure you want to delete this entry, \'' . $name . '\'?</p>';
			echo '<form method="post" action="?act=delete"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>' . NL;
			echo '<form method="post" action=""><center><input type="submit" value="No" /></center></form>' . NL;
		}
		else {
			
			echo '<p align="center">That id number does not exist.</p>' . NL;
		}
	}
}

else {

  for($i=0;$i<4;$i++) {
  $n=0;
  $query = $db->query("SELECT * FROM `minigames` WHERE `group` = " . $i . " ORDER BY `group`, name ASC");

  switch($i) {
  case 0:   $title = 'Not Sorted - Group ' . $i;
            break;  
  
  case 1:   $title = 'Combat - Group ' . $i;
            break;
            
  case 2:   $title = 'Player vs Player - Group ' . $i;
            break;
            
  case 3:   $title = 'Skilling - Group ' . $i;
            break;
  }

	?>
	<table style="border-left: 1px solid #000;" width="100%" cellpadding="1" cellspacing="0">
	<tr>
	<td colspan="3" class="tabletop"><?php echo $title; ?></td>
	</tr>
	<?php

	while($info = $db->fetch_array( $query ) ) {
	
    echo '<tr align="center">' . NL;
		echo '<td class="tablebottom" width="20%"><a href="/minigames.php?id=' . $info['id'] . '" target="_new">' . $info['name'] . '</a></td>' . NL;
		echo '<td class="tablebottom" width="5%"><a href="?act=edit&id=' . $info['id'] . '" title="Edit '.$info['name'].'">Edit</a>';
		if( $ses->permit( 15 ) ) {
			echo ' / <a href="?act=delete&id=' . $info['id'] . '" title="Delete \'' . $info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td class="tablebottom" width="20%">' . format_time( $info['time'] ) . '</td>' . NL;
		echo '</tr>' . NL;
	}
	
	?>
	</table><br />
<?php
}
//NOTEPAD
$info = $db->fetch_row("SELECT * FROM `admin_pads` WHERE `file` = 'mini'");
$last = format_time( $info['time'] + 21600 );
if( isset( $_POST['text'] ) ) {
    $pad = addslashes( $_POST['text'] );
    $query = $db->query("UPDATE `admin_pads` SET `text` = '".$pad."', `time` = '".time()."' WHERE `file` = 'mini'");
    $ses->record_act('Mini Guides', 'Edit', 'Notepad', $ip);
    header("Location: minigames.php");
	}

echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
echo 'Last Update: ' . $last . ' (GMT)<br />';
echo '<textarea name="text" rows="25" style="width: 95%; font: 10px Verdana, Arial, Helvetica, sans, sans serif;">' . $info['text'] . '</textarea><br />';
echo '<input type="submit" value="Update" />&nbsp;<input type="reset" value="Undo Changes" />';
echo '</form>';

}
echo '</div>'. NL;
if(!isset($name)) $name = '';
end_page($name);
?>