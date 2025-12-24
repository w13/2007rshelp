<?php

require( 'backend.php' );
require( 'edit_class.php' );
start_page( 2, 'City Guide' );

$category = 'cities';
$cat_name = $cat_array[$category];
$edit = new edit( $category, $db );

echo '<div class="boxtop">City Guide</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right:24px;">' . NL;

?>
<div style="float: right;"><a href="?cat=<?php echo $category; ?>"><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="?act=new&cat=<?php echo $category; ?>"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; City Guides</font></b>
</div>
<hr class="main" noshade="noshade" align="left" />
<b>DON'T FORGET:</b>
<ol>
<li>Add exactly this after the &lt;/p&gt; tag of the introduction: &lt;!--s--&gt;</li>
<li>Ensure the special attractions section is directly after the introduction paragraph and the &lt;!--s--&gt;</li>
</ol>

<?php

if( isset( $_POST['act'] ) AND $_POST['act'] == 'edit' AND isset( $_POST['id'] ) ) {

	$id = intval( $_POST['id'] );
	$name = $edit->add_update( $id, 'name', $_POST['name'], 'You must enter a name.' );
	$author = $edit->add_update( $id, 'author', $_POST['author'], 'You must enter an author.' );
	$type = $edit->add_update( $id, 'type', $_POST['type'], 'You must enter a type.' );
	$text = $edit->add_update( $id, 'text', $_POST['text'], 'You must enter some content.' );
	//$map = $edit->add_update( $id, 'map', $_POST['map'], 'You must enter code for the map.' );
	$city_key = $edit->add_update( $id, 'city_key', $_POST['city_key'], 'You must enter city keys.' );
	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
		rpostcontent();
	}
	else {
		$ses->record_act( 'City Guides', 'Edit', $name, $ip );
		echo '<p align="center">Entry successfully edited into Zybez City Guide Area.</p>' . NL;
	}

}
elseif( isset( $_POST['act'] ) AND $_POST['act'] == 'new' ) {

	$name = $edit->add_new( 1, 'name', $_POST['name'], 'You must enter a name.' );
	$author = $edit->add_new( 1, 'author', $_POST['author'], 'You must enter an author.' );
	$type = $edit->add_new( 1, 'type', $_POST['type'], 'You must enter a type.' );
	$text = $edit->add_new( 1, 'text', $_POST['text'], 'You must enter some content.' );
	$map = $edit->add_new( 1, 'map', $_POST['map'], 'You must enter a difficulty rating (1-5).' );
	$city_key = $edit->add_new( 1, 'city_key', $_POST['city_key'], 'You must enter a length rating (1-5).' );
	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
		rpostcontent();
	}
	else {
		$ses->record_act( 'City Guides', 'New', $name, $ip );
		echo '<p align="center">New entry was successfully added into Zybez City Guide Area. No Cache has been performed.</p>' . NL;
		header( 'refresh: 2; url=?cat=' . $category );
	}
}

		
elseif( isset( $_GET['act'] ) AND ( ( $_GET['act'] == 'edit' AND isset( $_GET['id'] ) ) OR $_GET['act'] == 'new' ) ) {

	if( $_GET['act'] == 'edit' ) {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM cities WHERE id =" . $id );
    
		if( $info ) {
			$name = $info['name'];
			$author = $info['author'];
			$type = $info['type'];
			$text = $info['text'];
			$map = $info['map'];
			$city_key = $info['city_key'];
		}
		else {
			$_GET['act'] = 'new';
			$name = '';
			$author = '';
			$type = '';
			$text = '';
			$map = 1;
			$city_key = 1;
		}
	}
	else {
		$name = '';
		$author = '';
		$type = '';
		$text = '';
		$map = 1;
		$city_key = 1;
	}
	
	
	
	echo '<form method="post" action="?cat=' . $category . '">' . NL;
	echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />';
	
	if( $_GET['act'] == 'edit' ) {
		enum_correct( $category, $id );
		echo '<input type="hidden" name="id" value="' . $id . '" />';
	  $seltyp = $info['type'] == 1 ? ' checked="checked"' : '';
	}
	echo '<input type="hidden" name="type" value="' . $category . '" />';
	echo '<table width="90%" align="center" style="border-left: 1px solid #000000" cellspacing="0">' . NL;
	echo '<tr>' . NL;
	echo '<td class="tabletop" colspan="2">General</td>' . NL;
	echo '</td>' . NL;
	echo '<tr><td class="tablebottom" width="50%">Name:</td><td class="tablebottom"><input type="text" name="name" value="' . $name . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Author:</td><td class="tablebottom"><input type="text" name="author" value="' . $author . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Members?</td><td class="tablebottom"><input type="checkbox" name="type" value="1"'.$seltyp.' /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Map Code:</td><td class="tablebottom"><textarea rows="6" name="map" cols="45" maxlength="255">' . htmlentities($map) . '</textarea></td></tr>' . NL;
	echo '<tr><td class="tablebottom" colspan="2">City Keys:<br />File names of the city key images without extension, separated by commas with no spaces. E.G. bank,furnace,estate_agent,water_source etc.</td></tr><tr><td class="tablebottom" colspan="2"><input type="text" name="city_key" size="150" value="' . $city_key . '" /></td></tr>' . NL;	
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
			$ses->record_act( 'City Guides', 'Delete', $_POST['del_name'], $ip );
			header( 'refresh: 2; url=?cat=' . $category );
			echo '<p align="center">Entry successfully deleted from Zybez.</p>' . NL;
		}
	}
	else {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM cities WHERE id = " . $id );
	
		if( $info ) {
		
			$name = $info['name'];
			echo '<p align="center">Are you sure you want to delete this city, \'' . $name . '\'?</p>';
			echo '<form method="post" action="?act=delete&cat=' . $category . '"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>' . NL;
			echo '<form method="post" action="?cat=' . $category . '"><center><input type="submit" value="No" /></center></form>' . NL;
		}
		else {
			
			echo '<p align="center">That id number does not exist.</p>' . NL;
		}
	}
}

else {

$quack =  "SELECT * FROM cities";
	$query = $db->query($quack );

	?>
	<table style="border-left: 1px solid #000;" width="100%" cellpadding="1" cellspacing="0">
	<tr>
	<th class="tabletop">Name:</th>
	<th class="tabletop">Actions:</th>
	<th class="tabletop">Last Edited (GMT):</th>
	</tr>
	<?php

	while($info = $db->fetch_array( $query ) ) {
	
    echo '<tr align="center">' . NL;
		echo '<td class="tablebottom"><a href="/cities.php?id=' . $info['id'] . '" target="_new">' . $info['name'] . '</a></td>' . NL;
		echo '<td class="tablebottom"><a href="?act=edit&cat=' . $category . '&id=' . $info['id'] . '" title="Edit '.$info['name'].'">Edit</a>';
		if( $ses->permit( 15 ) ) {
			echo ' / <a href="?act=delete&cat=' . $category . '&id=' . $info['id'] . '" title="Delete \'' . $info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td class="tablebottom">' . format_time( $info['time'] ) . '</td>' . NL;
		echo '</tr>' . NL;
	}
	if( $db->num_rows( $quack ) == 0 ) {
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