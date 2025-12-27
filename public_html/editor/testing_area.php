<?php

require( 'backend.php' );
require( 'edit_class.php' );
start_page( 1, 'Testing Area' );

$cat_array = array(
					'testing' => 'Testing Area');
					
if( array_key_exists( $_GET['cat'], $cat_array ) ) {
	$category = $_GET['cat'];
}
else {
	$category = 'testing';
}
$cat_name = $cat_array[$category];

$edit = new edit( $category, $db );

echo '<div class="boxtop">Testing Area</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 

24px;">' . NL;

?>
<script type="text/javascript">

function displayHTML(form) {
var inf = form.code.value;
win = window.open(", ", 'popup', 'toolbar = no, status = no');
win.document.write("" + inf + "");
}

var formChanged = false;

window.onbeforeunload = function() {
    if (formChanged) return "You have unsaved changes.";
}

function hide(i)
{
   var el = document.getElementById(i)
   if (el.style.display=="none")
   {
      el.style.display="block";
   }
   else
   {
      el.style.display="none";
   }
}
</script>

<div style="float: right;"><a href="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>?cat=<?php echo $category; ?>"><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>?act=new&cat=<?php echo $category; ?>"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; Testing Area</font></b>
</div>
<hr class="main" noshade="noshade" align="left" />

<b>Instructions:</b> <a href="#" onclick=hide('tohide')>Show/Hide</a><br />
<div id="tohide" style="display:none"><b><a href="xhtml.php">Click here</a> before working on any guides to make sure your coding is correct!</b><br />
If you put something into the notepad, delete it (mark it as [DELETE]) when you don't need it anymore.<br />
You may add new guides here that you may wish to work on, just make sure you put what you're doing in the same format that's already in the notepad.<br />

<b>Key</b>
<ul>
<li>- [Z] = Ignore this - don't edit it</li>
<li>- [Review] = Needs reviewing/ updating - go ahead and make changes (as long as no one else is editing it at the same time)</li>
<li>- [NR] = Next release</li>
<li>- [CBE] = Currently Being Edited - do NOT edit a guide AT ALL while this is in the title.<br />
-- If you're going to work on a guide, edit it, put [CBE] at the end of the guide name, and hit submit. Then go back and start work.<br />
-- Only do this if you are working on it right then. When you've finished making your edits, take the [CBE] out.</li></ul>
</div>
<p style="text-align:center;">When editing a test area entry, always add [CBE] to the title before beginning a long edit, so no one overwrites your work.<br />Remove the [CBE] when you're done.</p>
<?php

if( isset( $_POST['act'] ) AND $_POST['act'] == 'edit' AND isset( $_POST['id'] ) ) {

	$id = intval( $_POST['id'] );
	
	$name = $edit->add_update( $id, 'name', $_POST['name'], 'You must enter a name.' );
	$author = $edit->add_update( $id, 'author', $_POST['author'], 'You must enter an author.' );
	$type = $edit->add_update( $id, 'type', $_POST['type'], 'You must enter a type.' );
	$text = $edit->add_update( $id, 'text', $_POST['text'], 'You must enter some content.' );

	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
		rpostcontent();
	}
	else {
		$db->query("UPDATE `testing` SET `locked`=0,`locked_user`='' WHERE `id`=".$id);
		$ses->record_act( $cat_name, 'Edit', $name, $ip );
		echo '<p align="center">Entry successfully edited into OSRS RuneScape Help Testing Area.</p>' . NL;
		header( 'refresh: 20; url=' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?cat=' . $category );
	}

}
elseif( isset( $_POST['act'] ) AND $_POST['act'] == 'new' ) {

	$name = $edit->add_new( 1, 'name', $_POST['name'], 'You must enter a name.' );
	$author = $edit->add_new( 1, 'author', $_POST['author'], 'You must enter an author.' );
	$type = $edit->add_new( 1, 'type', $_POST['type'], 'You must enter a type.' );
	$text = $edit->add_new( 1, 'text', $_POST['text'], 'You must enter some content.' );

	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
		rpostcontent();
	}
	else {
		$ses->record_act( $cat_name, 'New', $name, $ip );
		echo '<p align="center">New entry was successfully added into OSRS RuneScape Help Testing Area.</p>' . NL;
		header( 'refresh: 2; url=' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?cat=' . $category );
	}
}

		
elseif( isset( $_GET['act'] ) AND ( ( $_GET['act'] == 'edit' AND isset( $_GET['id'] ) ) OR $_GET['act'] == 'new' ) ) {

	if( $_GET['act'] == 'edit' ) {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM testing WHERE id =" . $id );
	
		if( $info ) {

			$name = $info['name'];
			$author = $info['author'];
			$type = $info['type'];
			$text = $info['text'];
			$locked = $info['locked'];
			$locked_user = $info['locked_user'];
		}
		else {
			$_GET['act'] = 'new';
			$name = '';
			$author = '';
			$type = '';
			$text = '';
			$locked = 0;
			$locked_user = '';
		}
	}
	else {
		$name = '';
		$author = '';
		$type = '';
		$text = '';
		$locked = 0;
		$locked_user = '';
	}
	
	if ($locked != 0 && ($locked + (120 * 60)) > time() && $locked_user != $_SESSION['user']) {
		echo '<p class="info">This guide is currently being edited by '.$info['locked_user'].'.  If '.$locked_user.' does not submit the changes he/she has made in '. (120 - round( (time() - $locked) / 60 ) ).' minutes, the guide will be unlocked automatically.  If you are having issues with a guide being locked, please contact a manager.<br /><br />This page will refresh after 10 seconds.</p><br /><br />';
		header('refresh:10;url='.htmlspecialchars($_SERVER['SCRIPT_NAME']));
	}
	
	else {
	
	if ($_GET['act'] != 'new') {
		$db->query("UPDATE `testing` SET `locked`=" . time() . ",`locked_user`='" . $_SESSION['user'] . "' WHERE `id`=".$id);
	}
	
	echo '<form method="post" action="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?cat=' . $category . '">' . NL;
	echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />';
	
	if( $_GET['act'] == 'edit' ) {
		enum_correct( $category, $id );
		echo '<input type="hidden" name="id" value="' . $id . '" />';
	}
	echo '<input type="hidden" name="type" value="' . $category . '" />';
	
	echo '<table width="90%" align="center" style="border-left: 1px solid #000000" cellspacing="0">' . NL;
	echo '<tr>' . NL;
	echo '<td class="tabletop" colspan="2">General</td>' . NL;
	echo '</td>' . NL;
	echo '<tr><td class="tablebottom" width="50%">Name:</td><td class="tablebottom"><input type="text" name="name" value="' . $name . '" 

/></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Author/Mapper:</td><td class="tablebottom"><input type="text" name="author" value="' . $author . '" 

/></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Type:</td><td class="tablebottom"><input type="text" name="type" value="' . $type . '" 

/></td></tr>' . NL;
	echo '<td class="tabletop" colspan="2" style="border-top: none;">Content</td>' . NL;
	echo '<tr><td class="tablebottom" colspan="2"><input type="submit" value="Submit All" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom" colspan="2"><textarea rows="15" name="text" onchange="formChanged = true;" style="width: 99%;">' . htmlentities( $text ) . 

'</textarea></td></tr>' . NL;
	echo '</table>' . NL;
	echo '</form>' . NL;
	echo '<br />';

		if( $_GET['act'] == 'edit') {
			echo '<br />';
echo '<div class="boxtop">Test Area Notepad</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px; text-align: center;">';

$info = $db->fetch_row("SELECT * FROM `admin_pads` WHERE `file` = 'testingarea'");
$last = format_time( $info['time'] + 21600 );

echo '<form action="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '" method="post">';
echo 'Last Update: ' . $last . ' (GMT)<br />';
echo '<textarea name="notepad2" rows="20" style="background: #B3B8BA; width: 95%; font: 10px Verdana, Arial, Helvetica, sans, sans serif; border-style-left: 1px black; border-style-right: 1px black; border-style-top; 1px black; border-style-bottom; 1px black">' 
. $info['text'] . '</textarea><br /><br />';
echo '</div>';
		}
		else {
			echo '<br />';
		}		
}		
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
			header( 'refresh: 2; url=' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?cat=' . $category );
			echo '<p align="center">Entry successfully deleted from OSRS RuneScape Help.</p>' . NL;
		}
	}
	else {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM testing WHERE id = " . $id );
	
		if( $info ) {
		
			$name = $info['name'];
			echo '<p align="center">Are you sure you want to delete this test, \'' . $name . '\'?</p>';
			echo '<form method="post" action="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?act=delete&cat=' . $category . '"><center><input type="hidden" 

name="del_id" value="' . $id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" 

/></center></form>' . NL;
			echo '<form method="post" action="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?cat=' . $category . '"><center><input type="submit" value="No" 

/></center></form>' . NL;
		}
		else {
			
			echo '<p align="center">That id number does not exist.</p>' . NL;
		}
	}
}

else {

	echo '<center><form action="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?cat=testing" method="get">' . NL;
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

	$qual = "SELECT * FROM testing ORDER BY `name`" ;
	$query = $db->query( $qual );

	?>
	<table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="1" cellspacing="0">
	<tr class="boxtop">
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Name:</th>
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Actions:</th>
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Last Edited (GMT):</th>
	</tr>
	<?php

	while($info = $db->fetch_array( $query ) ) {
	
		echo '<tr align="center">' . NL;
		echo '<td class="tablebottom"><a href="/editor/testing.php?id=' . $info['id'] . '" target="_new">' . 

$info['name'] . '</a></td>' . NL;
		echo '<td class="tablebottom">';

		if ($info['locked'] != 0 && ($info['locked'] + (120 * 60)) > time() && $info['locked_user'] != $_SESSION['user']) {
			if ($ses->permit(15)) {
				echo ' <a href="/editor/unlock.php?table=testing&id='.$info['id'].'" title="'.$info['locked_user'].' editing..."><img src="/editor/extras/locked.png" alt="locked" /></a>';
			} else {
				echo ' <img src="/editor/extras/locked.png" alt="locked" />';
			}
		} else {
			echo '<a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?act=edit&cat=' . $category . '&id=' . $info['id'] . '" title="Edit ' 
. $info['name'] . '">Edit</a>'; 
		}

		if( $ses->permit( 15 ) ) {
			echo ' / <a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?act=delete&cat=' . $category . '&id=' . $info['id'] . '" title="Delete \'' . 

$info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td class="tablebottom">' . format_time( $info['time'] ) . '</td>' . NL;
		echo '</tr>' . NL;
	}
	if( $db->num_rows( $qual ) == 0 ) {
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="3">Sorry, no entries match your search criteria.</td>' . NL;
		echo '</tr>' . NL;
	}
	
	?>
	</table>
	<?php

echo '<br />';
echo '<div class="boxtop">Test Area Notepad</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px; text-align: center;">';

$info = $db->fetch_row("SELECT * FROM `admin_pads` WHERE `file` = 'testingarea'");
$last = format_time( $info['time'] + 21600 );
if( isset( $_POST['text'] ) ) {
    $pad = addslashes( $_POST['text'] );
    $query = $db->query("UPDATE `admin_pads` SET `text` = '".$pad."', `time` = '".time()."' WHERE `file` = 'testingarea'");
    $ses->record_act('Test Area', 'Edit', 'Notepad', $ip);
    header("Location: testing_area.php");
	}

echo '<form action="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '" method="post">';
echo 'Last Update: ' . $last . ' (GMT)<br />';
echo '<textarea name="text" rows="25" style="width: 95%; font: 10px Verdana, Arial, Helvetica, sans, sans serif;">' . $info['text'] . '</textarea><br />';
echo '<input type="submit" value="Update" />&nbsp;<input type="reset" value="Undo Changes" />';
echo '</form>';
echo '</div>';

}
echo '</div>'. NL;

end_page($name);
?>