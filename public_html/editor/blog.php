<?php

require( 'backend.php' );
require( 'edit_class.php' );
start_page( 17, 'OSRS RuneScape Help Blog' );

$edit = new edit( 'blog', $db );

$cat_array = array(
					1 => 'RS News',
					2 => 'RS General',
					3 => 'Community News',
					4 => 'Guest Article');
					
if( array_key_exists( $_GET['cat'], $cat_array ) ) {
	$category = $_GET['cat'];
}
else {
	$category = 1;
}
$cat_name = $cat_array[$category];

echo '<div class="boxtop">OSRS RuneScape Help Blog</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right:24px;">' . NL;

?>
<div style="float: right;"><a href="<?=$_SERVER['PHP_SELF']?>?cat=<?=$category?>"><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="<?=$_SERVER['PHP_SELF']?>?act=new&cat=<?=$category?>"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; OSRS RuneScape Help Blog</font></b>
</div>
<hr class="main" noshade="noshade" align="left" /><br />



<?php

if( isset( $_POST['act'] ) AND $_POST['act'] == 'edit' AND isset( $_POST['id'] ) ) {

	$id = intval( $_POST['id'] );
	$name = $edit->add_update( $id, 'name', $_POST['name'], 'You must enter a name.' );
	$author = $edit->add_update( $id, 'author', $_POST['author'], 'You must enter an author.' );
	$url = $edit->add_update( $id, 'url', $_POST['url'], '', false );	
	$text = $edit->add_update( $id, 'text', $_POST['text'], 'You must enter some content.' );
	$date = $edit->add_update( $id, 'date', $_POST['date'], 'You must enter a date.' );
	$type = $edit->add_update( $id, 'type', $_POST['type'], 'You must enter a type.' );
	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
		rpostcontent();
	}
	else {
		$ses->record_act( 'OSRS RuneScape Help Blog', 'Edit', $name, $ip );
		echo '<p align="center">Entry successfully edited into OSRS RuneScape Help Blog Area.</p>' . NL;
	}

}
elseif( isset( $_POST['act'] ) AND $_POST['act'] == 'new' ) {

	$name = $edit->add_new( 1, 'name', $_POST['name'], 'You must enter a name.' );
	$author = $edit->add_new( 1, 'author', $_POST['author'], 'You must enter an author.' );
	$url = $edit->add_new( 1, 'url', $_POST['url'], '',false );	
	$text = $edit->add_new( 1, 'text', $_POST['text'], 'You must enter some content.' );
	$date = $edit->add_new( 1, 'date', $_POST['date'], 'You must enter a date.' );
	$type = $edit->add_new( 1, 'type', $_POST['type'], 'You must enter some content.' );
	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
		rpostcontent();
	}
	else {
		$ses->record_act( 'OSRS RuneScape Help Blog', 'New', $name, $ip );
		echo '<p align="center">New entry was successfully added into OSRS RuneScape Help Blog Area.</p>' . NL;
	}
}

		
elseif( isset( $_GET['act'] ) AND ( ( $_GET['act'] == 'edit' AND isset( $_GET['id'] ) ) OR $_GET['act'] == 'new' ) ) {

	if( $_GET['act'] == 'edit' ) {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM blog WHERE id =" . $id );
	
		if( $info ) {
			$name = $info['name'];
			$author = $info['author'];
			$url = $info['url'];
			$text = $info['text'];
			$date = $info['date'];
			$type = $info['type'];
		}
		else {
			$_GET['act'] = 'new';
			$name = '';
			$author = '';
			$url = '';
			$text = '';
			$type = '';
			$date = '';
		}
	}
	else {
		$name = '';
		$author = '';
		$url = '';
		$text = '';
		$type = '';
    $date = '';
	}
	
	
	
	echo '<form method="post" name="blog" action="' . $_SERVER['PHP_SELF'] . '?cat=' . $category . '">' . NL;
	echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />';
	
	if( $_GET['act'] == 'edit' ) {
		enum_correct( $category, $id );
		echo '<input type="hidden" name="id" value="' . $id . '" />';
	  $rsn = $info['type'] == 1 ? ' selected="selected"' : '';
	  $rsg = $info['type'] == 2 ? ' selected="selected"' : '';
	  $comm = $info['type'] == 3 ? ' selected="selected"' : '';
	  $guest = $info['type'] == 4 ? ' selected="selected"' : '';
	}
	echo '<script src="extras/calendar.js" type="text/javascript"></script>'.NL;
	echo '<input type="hidden" name="type" value="' . $category . '" />';
	echo '<table width="90%" align="center" style="border-left: 1px solid #000000" cellspacing="0">' . NL;
	echo '<tr>' . NL;
	echo '<td class="tabletop" colspan="2">General</td>' . NL;
	echo '</td>' . NL;
	echo '<tr><td class="tablebottom" width="50%">Name:</td><td class="tablebottom"><input type="text" name="name" value="' . $name . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Author:</td><td class="tablebottom"><input type="text" name="author" value="' . $author . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Type:</td><td class="tablebottom"><select name="type"><option value="1" '.$rsn.'>Runescape News</option><option value="2" '.$rsg.'>Runescape General</option><option value="3" '.$comm.'>Community News</option><option value="4" '.$guest.'>Guest Article</option></select></td></tr>' . NL;
  echo '<tr><td class="tablebottom">Start Time:</td><td class="tablebottom"><input type="text" style="text-align:center;" size="30" maxlength="20" name="date" value="'.$date.'" /> <a href="javascript:date.popup();"><img src="images/b_calendar.png" width="16" height="16" border="0" alt="Click Here to Pick the date"></a></td>' . NL;
	echo '<tr><td class="tablebottom">URL</td><td class="tablebottom" colspan="2"><input type="text" size="50" maxlength="100"  name="url" value="'.$url.'" /></td></tr>' . NL;
	echo '<tr><td class="tabletop" colspan="2" style="border-top: none;">Content</td>' . NL;
	echo '<tr><td class="tablebottom" colspan="2"><input type="submit" value="Submit All" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom" colspan="2"><textarea rows="15" name="text" style="width: 99%;">' . htmlentities( $text ) . '</textarea></td></tr>' . NL;
	echo '</table><br />' . NL;
	echo '</form><br />' . NL;

    echo '<script>var date = new calendar3(document.forms[\'blog\'].elements[\'date\']);
	date.year_scroll = true;
	date.time_comp = false;</script>';
	
	}
	
	elseif( isset( $_GET['act'] ) AND $_GET['act'] == 'delete' AND $ses->permit( 15 ) ) {
	if( isset( $_POST['del_id'] ) ) {
		$edit->add_delete( $_POST['del_id'] );
		$execution = $edit->run_all();
		
		if( !$execution ) {
			echo '<p align="center">' . $edit->error_mess . '</p>';
		}
		else {
			$ses->record_act( 'OSRS RuneScape Help Blog', 'Delete', $_POST['del_name'], $ip );
			echo '<p align="center">Entry successfully deleted from OSRS RuneScape Help.</p>' . NL;
		}
	}
	else {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM blog WHERE id = " . $id );
	
		if( $info ) {
		
			$name = $info['name'];
			echo '<p align="center">Are you sure you want to delete this Blog, \'' . $name . '\'?</p>';
			echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?act=delete&cat=' . $category . '"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>' . NL;
			echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?cat=' . $category . '"><center><input type="submit" value="No" /></center></form>' . NL;
		}
		else {
			
			echo '<p align="center">That id number does not exist.</p>' . NL;
		}
	}
}

else {

	echo '<center><form action="' . $_SERVER['PHP_SELF'] . '?cat=' . $category . '" method="get">' . NL;
	echo '<input type="submit" value="Go To" /> ' . NL;
	echo '<select name="cat">' . NL;
	
	foreach( $cat_array AS $key => $value ) {
		if( $category == $key ) {
			echo '<option value="' . $key . '" selected="selected">' . $value . '</option>' . NL;
		}
		else {
			echo '<option value="' . $key . '">' . $value . '</option>' . NL;
		}
	}
	echo '</select>' . NL;
	echo '</form></center>' . NL;

	$query = $db->query( "SELECT * FROM blog WHERE type = " . $category . " ORDER BY `date` DESC" );
	?>
	<table style="border-left: 1px solid #000;" width="100%" cellpadding="1" cellspacing="0">
	<tr>
	<th class="tabletop">Name:</th>
	<th class="tabletop">Actions:</th>
	<th class="tabletop">Start Date:</th>
	</tr>
	<?php

	while($info = $db->fetch_array( $query ) ) {
    echo '<tr align="center">' . NL;
		echo '<td class="tablebottom"><a href="/blog.php?type=' . $category . '&amp;id=' . $info['id'] . '" target="_new">' . $info['name'] . '</a></td>' . NL;
		$seotitle = strtolower(preg_replace("/[^A-Za-z0-9_&.]/", "", 'runescape_'.$info['name'].'.htm'));
		echo '<td class="tablebottom"><a href="' . $_SERVER['PHP_SELF'] . '?act=edit&cat=' . $category . '&id=' . $info['id'] . '" title="Edit '.$info['name'].'">Edit</a>';
		if( $ses->permit( 15 ) ) {
			echo ' / <a href="' . $_SERVER['PHP_SELF'] . '?act=delete&cat=' . $category . '&id=' . $info['id'] . '" title="Delete \'' . $info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td class="tablebottom">' . format_time( strtotime($info['date']) ) . '</td>' . NL;
		echo '</tr>' . NL;
	}
	if( mysqli_num_rows($query ) == 0 ) {
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="3">Sorry, no entries match your search criteria.</td>' . NL;
		echo '</tr>' . NL;
	}
	
	?>
	</table><br />
<?php
}
echo '</div>'. NL;
end_page($name);
?>