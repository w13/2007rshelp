<?php

require( 'backend.php' );
require( 'edit_class.php' );
start_page( 2, 'Guide Manager' );

		$cat_array = array(
					'skills' => 'Skill Guides',
					'guilds' => 'Guild Guides',
					);
					
if( array_key_exists( $_GET['cat'], $cat_array ) ) {
	$category = $_GET['cat'];
}
else {
	$category = 'skills';
}
$cat_name = $cat_array[$category];

$edit = new edit( $category, $db );

echo '<div class="boxtop">Guide Manager</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;

?>

<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function displayHTML(form) {
var inf = form.text.value;
win = window.open(", ", 'popup', 'toolbar = no, status = no');
win.document.write("" + inf + "");
}
//End -->
</script>
<script type="text/javascript">
var formChanged = false;

window.onbeforeunload = function() {
    if (formChanged) return "You have unsaved changes.";
}
</script>

<div style="float: right;"><a href="?cat=<?php echo $category; ?>"><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="?act=new&cat=<?php echo $category; ?>"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; Guide Manager &raquo; <?php echo $cat_name; ?></font></b>
</div>
<hr class="main" noshade="noshade" align="left" />
<p style="text-align:center;"><span style="font-weight:bold; font-variant:small-caps; font-size:15px;">Rules</span><br />
ALWAYS copy the guides' text to your clipboard before submitting any changes (ctrl + a and ctrl + c).<br />
ALWAYS check that the edit you made didn't mess up the guide.<br />
ALWAYS report any guide that's broken IMMEDIATELY (in message box).</p>

<?php

if( isset( $_POST['act'] ) AND $_POST['act'] == 'edit' AND isset( $_POST['id'] ) ) {

	$id = intval( $_POST['id'] );
	
	$name = $edit->add_update( $id, 'name', $_POST['name'], 'You must enter a name.' );
	$author = $edit->add_update( $id, 'author', $_POST['author'], 'You must enter an author.' );
	$type = $edit->add_update( $id, 'type', $_POST['type'], 'You must enter a type.' );
	$text = $edit->add_update( $id, 'text', $_POST['text'], 'You must enter some content.' );
	$hdimg = $edit->add_update( $id, 'hdimg', isset($_POST['hdimg']) ? 1 : 0, '', false );

	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
		rpostcontent();
	}
	else {
		$ses->record_act( $cat_name, 'Edit', $name, $ip );
		echo '<p align="center">Entry successfully edited on OSRS RuneScape Help.</p>' . NL;
	}
	
}
elseif( isset( $_POST['act'] ) AND $_POST['act'] == 'new' ) {

	$name = $edit->add_new( 1, 'name', $_POST['name'], 'You must enter a name.' );
	$author = $edit->add_new( 1, 'author', $_POST['author'], 'You must enter an author.' );
	$type = $edit->add_new( 1, 'type', $_POST['type'], 'You must enter a type.' );
	$text = $edit->add_new( 1, 'text', $_POST['text'], 'You must enter some content.' );
	$hdimg = $edit->add_new( 1, 'hdimg', isset($_POST['hdimg']) ? 1 : 0, '', false );

	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
		rpostcontent();
	}
	else {
		$ses->record_act( $cat_name, 'New', $name, $ip );
		echo '<p align="center">New entry was successfully added to OSRS RuneScape Help.</p>' . NL;
	}
	
}

		
elseif( isset( $_GET['act'] ) AND ( ( $_GET['act'] == 'edit' AND isset( $_GET['id'] ) ) OR $_GET['act'] == 'new' ) ) {

	if( $_GET['act'] == 'edit' ) {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM " . $category . " WHERE id = " . $id );
	
		if( $info ) {

			$name = $info['name'];
			$author = $info['author'];
			$type = $info['type'];
			$text = $info['text'];
			$hdimg = $info['hdimg'];
		}
		else {
			$_GET['act'] = 'new';
			$name = '';
			$author = '';
			$type = '';
			$text = '';
			$hdimg = 0;
		}
	}
	else {
		$name = '';
		$author = '';
		$type = '';
		$text = '';
		$hdimg = 0;
	}
	
	echo '<br /><form method="post" action="?cat=' . $category . '">' . NL;
	
	$selhdimg = $info['hdimg'] == 1 ? ' checked="checked"' : '';
	
	if( $_GET['act'] == 'edit' ) {
		enum_correct( $category, $id );	
		echo '<input type="hidden" name="id" value="' . $id . '" />';
	}
	echo '<input type="hidden" name="type" value="' . $category . '" />';
	echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />';
	
	echo '<table width="90%" align="center" style="border-left: 1px solid #000000" cellspacing="0">' . NL;
	echo '<tr>' . NL;
	echo '<td class="tabletop" colspan="2">General</td>' . NL;
	echo '</td>' . NL;
	echo '<tr><td class="tablebottom" width="50%">Name:</td><td class="tablebottom"><input type="text" name="name" value="' . $name . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Author:</td><td class="tablebottom"><input type="text" name="author" value="' . $author . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Type:</td><td class="tablebottom"><input type="text" name="type" value="' . $type . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">HD Images?:</td><td class="tablebottom"><input type="checkbox" name="hdimg"'.$selhdimg.' /></td></tr>' . NL;
	echo '<td class="tabletop" colspan="2" style="border-top: none;">Content</td>' . NL;
	echo '<tr><td class="tablebottom" colspan="2"><input type="submit" value="Submit All" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom" colspan="2"><textarea rows="15" onchange="formChanged = true;" name="text" style="width: 99%;">' . htmlentities( $text ) . '</textarea></td></tr>' . NL;
	echo '</table>' . NL;
	echo '</form>' . NL;
}
elseif( isset( $_GET['act'] ) AND $_GET['act'] == 'delete' AND $ses->permit( 15 ) ) {

	if( isset( $_POST['del_id'] ) ) {
		$edit->add_delete( $_POST['del_id'] );
		$execution = $edit->run_all();
		
		if( !$execution ) {
			echo '<p align="center">' . $edit->error_mess . '</p>';
		}
		else {
			$ses->record_act( $cat_name, 'Delete', $_POST['del_name'], $ip );
			header( 'refresh: 2; url=?cat=' . $category );
			echo '<p align="center">Entry successfully deleted from OSRS RuneScape Help.</p>' . NL;
		}
	}
	else {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM " . $category . " WHERE id = " . $id );
	
		if( $info ) {
		
			$name = $info['name'];
			echo '<p align="center">Are you sure you want to delete the guide, \'' . $name . '\'?</p>';
			echo '<form method="post" action="?act=delete&cat=' . $category . '"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>' . NL;
			echo '<form method="post" action="?cat=' . $category . '"><center><input type="submit" value="No" /></center></form>' . NL;
		}
		else {
			
			echo '<p align="center">That identification number does not exist.</p>' . NL;
		}
	}
}
else {

	echo '<center><form action="?cat=' . $category . '" method="get">' . NL;
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

	$quackquack = "SELECT * FROM " . $category . " ORDER BY `name`";
	$query = $db->query( $quackquack );

	?>
	<table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="1" cellspacing="0">
	<tr class="boxtop">
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Name:</th>
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Actions:</th>
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Last Edited (GMT):</th>
	</tr>
	<?php

	while($info = $db->fetch_array( $query ) ) {
	
		$complete = $info['hdimg'] == 1 ? ' id="complete"' : '';
	
		echo '<tr align="center">' . NL;
		echo '<td class="tablebottom"'.$complete.'><a href="/' . $category . '.php?id=' . $info['id'] . '" target="_new">' . $info['name'] . '</a></td>' . NL;
		echo '<td class="tablebottom"'.$complete.'><a href="?act=edit&cat=' . $category . '&id=' . $info['id'] . '" title="Edit ' . $info['name'] . '">Edit</a>';

		if( $ses->permit( 15 ) ) {
			echo ' / <a href="?act=delete&cat=' . $category . '&id=' . $info['id'] . '" title="Delete \'' . $info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td class="tablebottom"'.$complete.'>' . format_time( $info['time'] ) . '</td>' . NL;
		echo '</tr>' . NL;
	}
	if( $db->num_rows($quackquack) == 0 ) {
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="3">Sorry, no entries match your search criteria.</td>' . NL;
		echo '</tr>' . NL;
	}
	
	?>
	</table><br /><center><div id="yshout" width="100%"></div></center>
	<?php

}

echo '<br /></div>'. NL;

end_page($name);
?>