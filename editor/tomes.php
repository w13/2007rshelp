<?php
require( 'backend.php' );
start_page( 7, 'Tome Archive' );

$category = 'tomes';
require( 'edit_class.php' );
$edit = new edit( $category, $db );

?>
<script language="JavaScript">
function hide(iii)
{
   var el = document.getElementById(iii)
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
<div class="boxtop">Tome Manager</div>
<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<div style="float: right;"><a href=""><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="?act=new"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; <a href="tomes.php">Tome Manager</a></font></b>
</div>
<hr class="main" noshade="noshade" align="left" />

<b>Instructions:</b> <a href="#" onclick=hide('tohide')>Show/Hide</a><br />
<div id="tohide" style="display:none;">When typing up a book, first make sure you have an image of it (transparent) on a 50x50px canvas (you may be able to get the image <a href="http://tehfreak.net/itemsearch/">here</a>).<br />
Secondly, save all the images from the book as transparent .GIFs and submit them to Myst or Ben_Goten78 for upload.<br />
Once you have written the tome, pretty it up a little - make it nice and neat:<br />
--- Make titles bold or underlined<br />
----- <i>use &lt;h4&gt;&lt;/h4&gt; instead of &lt;div class="title3"&gt;&lt;/div&gt;</i>
--- Use tables if there are a number of images<br />
--- Center wide images or align some images to the right.</div>
<?php

if( isset( $_GET['act'] ) AND ( ( $_GET['act'] == 'edit' AND isset( $_GET['id'] ) ) OR $_GET['act'] == 'new' ) ) {

	$id = intval( $_GET['id'] );
	
	if( $_GET['act'] == 'edit' AND !isset( $_POST['do'] ) ) {
	
		$info = $db->fetch_row( "SELECT * FROM " . $category . " WHERE id = " . $id );
		if( $info ) {
		
			$name = $info['name'];
			$author = $info['author'];
			$item = $info['item'];
			$img = $info['img'];
			$content = $info['content'];
		}
		else {
			$name = '';
			$author = '';
			$item = '';
			$img = '';
			$content = '';
		}
	}
	elseif( $_GET['act'] == 'edit' AND isset( $_POST['do'] ) ) {
	
		$name = $edit->add_update( $id, 'name', $_POST['name'], 'You must enter a title.' );
		$author = $edit->add_update( $id, 'author', $_POST['author'], 'You must enter an author.' );
		$item = $edit->add_update( $id, 'item', $_POST['item'], 'You must enter an item.' );
		$img = $edit->add_update( $id, 'img', $_POST['img'], 'You must enter an image.' );
		$content = $edit->add_update( $id, 'content', $_POST['content'], 'You must enter some content.' );
	}
	elseif( $_GET['act'] == 'new' AND !isset( $_POST['do'] ) ) {
	
		$name = '';
		$author = '';
		$item = '';
		$img = '';
		$content = '';
	}
	elseif( $_GET['act'] == 'new' AND isset( $_POST['do'] ) ) {
	
		$name = $edit->add_new( 1, 'name', $_POST['name'], 'You must enter a title.' );
		$author = $edit->add_new( 1, 'author', $_POST['author'], 'You must enter an author.' );
		$item = $edit->add_new( 1, 'item', $_POST['item'], 'You must enter the items name.' );
		$img = $edit->add_new( 1, 'img', $_POST['img'], 'You must enter an image.' );
		$content = $edit->add_new( 1, 'content', $_POST['content'], 'You must enter some content.' );
	}
	
	$execution = $edit->run_all( false, true );
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>';
	}
	elseif( $_GET['act'] == 'new' AND isset( $_POST['do'] ) ) {
		$_GET['act'] == 'edit';
		$ses->record_act( 'Tome Archive', 'New', $name, $ip );
		echo '<p align="center">New entry was successfully added to Zybez.</p>';
		//header( 'refresh: 0; url=?cat=' . $category );
		
	}
	elseif( $_GET['act'] == 'edit' AND isset( $_POST['do'] ) )  {
		$ses->record_act( 'Tome Archive', 'Edit', $name, $ip );
		echo '<p align="center">Entry successfully edited on Zybez.</p>';
		//header( 'refresh: 0; url=?cat=' . $category );
	}
	
	if( $_GET['act'] == 'edit' ) {
		$action = 'act=edit&id=' . $id;
	}
	else {
		$action = 'act=new';
	}

	echo '<br /><form method="post" action="?' . $action . '">' . NL;
	echo '<input type="hidden" name="do" value="true" />' . NL;
	echo '<table width="90%" align="center" style="border-left: 1px solid #000000" cellspacing="0">' . NL;
	echo '<tr>' . NL;
	echo '<td class="tabletop" colspan="2">General</td>' . NL;
	echo '</td>' . NL;
	echo '<tr><td class="tablebottom" width="50%">Title:</td><td class="tablebottom"><input type="text" size="30" maxlength="100" name="name" value="' . $name . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom" width="50%">Author:</td><td class="tablebottom"><input type="text" size="30" maxlength="30" name="author" value="' . $author . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom" width="50%">Item Name:</td><td class="tablebottom"><input type="text" size="30" maxlength="30" name="item" value="' . $item . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom" width="50%">Image filename:</td><td class="tablebottom"><input type="text" size="30" maxlength="30" name="img" value="' . $img . '" /></td></tr>' . NL;
	echo '<td class="tabletop" colspan="2" style="border-top: none;">Content</td>' . NL;
	echo '<tr><td class="tablebottom" colspan="2"><input type="submit" value="Submit All" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom" colspan="2"><textarea rows="15" name="content" style="width: 99%;">' . htmlentities( $content ) . '</textarea></td></tr>' . NL;
	echo '</table>' . NL;
	echo '</form>' . NL;
}
elseif( isset( $_GET['act'] ) AND $_GET['act'] == 'delete' AND isset( $_GET['id'] ) AND $ses->permit( 15 ) ) {

	$id = intval( $_GET['id'] );
	$info = $db->fetch_row( "SELECT * FROM " . $category . " WHERE id = " . $id );

	if( $info ) {
	
		$names = $info['name'];
		echo '<p align="center">Are you sure you want to delete the entry, \'' . $names . '\'?</p>';
		echo '<form method="post" action=""><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>' . NL;
		echo '<form method="post" action=""><center><input type="submit" value="No" /></center></form>' . NL;
	}
	else {
		
		echo '<p align="center">That identification number does not exist.</p>' . NL;
	}
}
else {

	if( isset( $_POST['del_id'] ) AND $ses->permit( 15 ) ) {
		$edit->add_delete( $_POST['del_id'] );
		$execution = $edit->run_all();
		if( !$execution ) {
			echo '<p align="center">' . $edit->error_mess . '</p>';
		}
		else {
			$ses->record_act( 'Tome Archive', 'Delete', $_POST['del_name'], $ip );
			echo '<p align="center">Entry successfully deleted from Zybez.</p>' . NL;
			header( 'refresh: 0; url=?cat=' . $category );
		}
	}

	?>
	<br />
	<table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="1" cellspacing="0">
	<tr class="boxtop">
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Name:</th>
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Actions:</th>
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Posted (GMT):</th>
	</tr>
	<?php

	$query = $db->query( "SELECT * FROM " . $category . " ORDER BY `name` ASC" );
	
	while($info = $db->fetch_array( $query ) ) {
	
		echo '<tr align="center">' . NL;
		echo '<td class="tablebottom"><a href="/tomes.php?id=' . $info['id'] . '" target="_new">' . $info['name'] . '</a></td>' . NL;
		echo '<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000"><a href="?act=edit&id=' . $info['id'] . '" title="Edit ' . $info['user'] . '">Edit</a>';

		if( $ses->permit( 15 ) ) {
			echo ' / <a href="?act=delete&id=' . $info['id'] . '" title="Delete \'' . $info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '  <td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">' . format_time( $info['time'] ) . '</td>' . NL;
		echo ' </tr>' . NL;
	}
	?>
	</table>
	<?php

}

echo '<br /></div>'. NL;

end_page($name);
?>