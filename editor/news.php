<?php
require( 'backend.php' );
start_page( 12, 'Zybez News Manager' );

$category = 'news';
require( 'edit_class.php' );
$edit = new edit( $category, $db );

?>
<script type="text/javascript">
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

function displayHTML(form) {
var inf = form.content.value;
win = window.open(", ", 'popup', 'toolbar = no, status = no');
win.document.write("" + inf + "");
}

var formChanged = false;
var submitting = false;
window.onbeforeunload = function() {
    if (formChanged && !submitting) {
    return "You have unsaved changes.";
    }
}
</script>
<div class="boxtop">Zybez News Manager</div>
<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<div style="float: right;"><a href="<?=$_SERVER['SCRIPT_NAME']?>"><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="<?=$_SERVER['SCRIPT_NAME']?>?act=new"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; Zybez News Manager</font></b>
</div>
<hr class="main" noshade="noshade" align="left" />
<p style="text-align:center;font-size:large;">Please have your news post checked by another staffer for errors before posting</p><br />
<b>Instructions:</b> <a href="#" onclick=hide('tohide')>Show/Hide</a><br />
<div id="tohide" style="display:none;">Give the post a meaningful title (usually the most important update of the post)<br />
Use raw HTML (make sure it's xHTML Valid), but no P tags.<br />
Before posting, read through it and ensure it makes sense and that there are no spelling errors.</div>
<?

if( isset( $_GET['act'] ) AND ( ( $_GET['act'] == 'edit' AND isset( $_GET['id'] ) ) OR $_GET['act'] == 'new' ) ) {

	$id = intval( $_GET['id'] );
	
	if( $_GET['act'] == 'edit' AND !isset( $_POST['do'] ) ) {
	
		$info = $db->fetch_row( "SELECT * FROM " . $category . " WHERE id = " . $id );
		if( $info ) {
		
			$title = $info['title'];
			$content = $info['content'];
			$mem_id = $info['mem_id'];
		}
		else {
			$title = '';
			$author = '';
			$content = '';
			$mem_id = $_COOKIE['member_id'];
		}
	}
	elseif( $_GET['act'] == 'edit' AND isset( $_POST['do'] ) ) {
	
		$title = $edit->add_update( $id, 'title', $_POST['title'], 'You must enter a title.' );
		$content = $edit->add_update( $id, 'content', $_POST['content'], 'You must enter some content.' );
		$mem_id = $edit->add_update( $id, 'mem_id', $_POST['mem_id'], 'You must enter your RSC member id.' );
	}
	elseif( $_GET['act'] == 'new' AND !isset( $_POST['do'] ) ) {
	
		$title = '';
		$author = '';
		$content = '';
		$mem_id = $_COOKIE['member_id'];
	}
	elseif( $_GET['act'] == 'new' AND isset( $_POST['do'] ) ) {
	
		$title = $edit->add_new( 1, 'title', $_POST['title'], 'You must enter a title.' );
		$author = $edit->add_new( 1, 'author', $ses->user, 'You must enter an author.' );
		$content = $edit->add_new( 1, 'content', $_POST['content'], 'You must enter some content.' );
		$mem_id = $edit->add_new( 1, 'mem_id', $_POST['mem_id'], 'You must enter your RSC member id.' );
	}
	
	$execution = $edit->run_all( false, true );
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>';
	}
	elseif( $_GET['act'] == 'new' AND isset( $_POST['do'] ) ) {
		$_GET['act'] == 'edit';
		echo '<p align="center">New entry was successfully added to Zybez.</p>';
		$ses->record_act( 'Zybez News', 'New', $title, $ip );
		header( 'refresh: 0; url=' . $_SERVER['SCRIPT_NAME']);
		
	}
	elseif( $_GET['act'] == 'edit' AND isset( $_POST['do'] ) )  {
		echo '<p align="center">Entry successfully edited on Zybez.</p>';
		$ses->record_act( 'Zybez News', 'Edit', $title, $ip );
		header( 'refresh: 0; url=' . $_SERVER['SCRIPT_NAME']);
	}
	
	if( $_GET['act'] == 'edit' ) {
		$action = 'act=edit&id=' . $id;
	}
	else {
		$action = 'act=new';
	}

	echo '<br /><form method="post" action="' . $_SERVER['SCRIPT_NAME'] . '?' . $action . '">' . NL;
	echo '<input type="hidden" name="do" value="true" />' . NL;
	echo '<table width="90%" align="center" style="border-left: 1px solid #000" cellspacing="0">' . NL;
	echo '<tr>' . NL;
	echo '<td class="tabletop" colspan="2">General</td>' . NL;
	echo '</td>' . NL;
	echo '<tr><td class="tablebottom" width="50%">Title:</td><td class="tablebottom"><input type="text" size="50" maxlength="40" name="title" value="' . $title . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom" width="50%">Member ID:</td><td class="tablebottom"><input type="text" size="15" maxlength="40" name="mem_id" value="' . $mem_id . '" /> (so it links properly)</td></tr>' . NL;
	echo '<td class="tabletop" colspan="2" style="border-top: none;">Content</td>' . NL;
	echo '<tr><td class="tablebottom" colspan="2"><input type="submit" value="Submit All" onclick="submitting = true;" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom" colspan="2"><textarea rows="15" name="content" onchange="formChanged = true;" style="width: 99%;">' . htmlentities( $content ) . '</textarea></td></tr>' . NL;
	echo '</table>' . NL;
	echo '</form>' . NL;
}
elseif( isset( $_GET['act'] ) AND $_GET['act'] == 'delete' AND isset( $_GET['id'] ) AND $ses->permit( 15 ) ) {

	$id = intval( $_GET['id'] );
	$info = $db->fetch_row( "SELECT * FROM " . $category . " WHERE id = " . $id );

	if( $info ) {
	
		$name = $info['title'];
		echo '<p align="center">Are you sure you want to delete the entry, \'' . $name . '\'?</p>';
		echo '<form method="post" action="' . $_SERVER['SCRIPT_NAME'] . '"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>' . NL;
		echo '<form method="post" action="' . $_SERVER['SCRIPT_NAME'] . '"><center><input type="submit" value="No" /></center></form>' . NL;
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
			$ses->record_act( 'Zybez News', 'Delete', $_POST['del_name'], $ip );
		header( 'refresh: 0; url=' . $_SERVER['SCRIPT_NAME'] . '?cat=' . $category );
		}
	}
	
	if(isset($_GET['headsup'])) {
	
    $call = file_get_contents('../content/headsup.inc');
    $call = explode("\n", $call);
    $url = $call[0];
    $url_title = $call[1];
    $desc = $call[2];
    $left = $call[3];
    $right =$call[4];
    
    echo '<form action="' . $_SERVER['SCRIPT_NAME'] . '" method="post" autocomplete="off">';
    echo '<table width="50%" style="margin: 0 25%;" border="0" cellspacing="0" cellpadding="5">';
    echo '<tr><th>URL to file:</th><td><input type="text" size="60" name="p0" value="' . $call[0] . '" /></td></tr>';
    echo '<tr><th>URL title tag:</th><td><input type="text" size="60" name="p1" value="' . $call[1] . '" /></td></tr>';
    echo '<tr><th>Description:</th><td><input type="text" size="60" name="p2" value="' . $call[2] . '" /></td></tr>';
    echo '<tr><td colspan="2" style="text-align:center;"><input type="submit" name="headsup" value="Submit" /></td></tr>';
    echo '</table></form>';
    
	}
	else {
	echo '<h2 style="text-align:center;"><a href="?headsup">Edit the Index Heads Up Bar</a></h2>';
	}
	
	if(isset($_POST['headsup'])) {
    $file = '../content/headsup.inc';
    $record = str_replace('&r','&amp;r',strip_tags($_POST['p0'])) . NL . strip_tags($_POST['p1']) . NL . strip_tags($_POST['p2']);
    $handle = fopen( $file, 'w' );
    fwrite( $handle, $record );
    fclose( $handle );
	}
	if ($_SESSION['user'] == 'Jeremy' || $_SESSION['user'] == 'Ben_Goten78') {
		echo '<h2 style="text-align:center;"><a href="?cacheindex">Cache The Index</a></h2>';
	}
	if (isset($_GET['cacheindex']) && ($_SESSION['user'] == 'Jeremy' || $_SESSION['user'] == 'Ben_Goten78')) {
		include('/home/w13/www/zybez.net/html/getzybez.php');
		pleasecache("http://www.zybez.net/");
	}
		
/* Jer: I commented this out... put the function above in
  $url = '/getzybez.php?cachethis=http%3A%2F%2Fwww.zybez.net%2F';
  $url2 = '/getzybez.php?cachethis=http%3A%2F%2Fwww.zybez.net%2F?';
  $url3 = '/getzybez.php?cachethis=http%3A%2F%2Fwww.zybez.net%2Findex.php';
  $url4 = '/getzybez.php?cachethis=http%3A%2F%2Fwww.zybez.net';
  echo '<p style="text-align:center;cursor:pointer;" onclick="window.open(\''.$url.'\'); window.open(\''.$url2.'\');window.open(\''.$url3.'\');window.open(\''.$url4.'\');">Re-Cache Category Indexes</p>';*/
  
	?>
	<br />
	<table style="border-left: 1px solid #000; border-top: 1px solid #000" width="100%" cellpadding="1" cellspacing="0">
	<tr class="boxtop">
	<th style="border-bottom: 1px solid #000; border-right: 1px solid #000">Name:</th>
	<th style="border-bottom: 1px solid #000; border-right: 1px solid #000">Actions:</th>
	<th style="border-bottom: 1px solid #000; border-right: 1px solid #000">Author:</th>
	<th style="border-bottom: 1px solid #000; border-right: 1px solid #000">Posted (GMT):</th>
	</tr>
	<?

	$query = $db->query( "SELECT * FROM " . $category . " ORDER BY `time` DESC" );
	
	while($info = $db->fetch_array( $query ) ) {
	
		echo '<tr align="center">' . NL;
		echo '<td style="border-bottom: 1px solid #000; border-right: 1px solid #000">' . $info['title'] . '</a></td>' . NL;
		echo '<td style="border-bottom: 1px solid #000; border-right: 1px solid #000"><a href="' . $_SERVER['SCRIPT_NAME'] . '?act=edit&id=' . $info['id'] . '" title="Edit ' . $info['user'] . '">Edit</a>';

		if( $ses->permit( 15 ) ) {
			echo ' / <a href="' . $_SERVER['SCRIPT_NAME'] . '?act=delete&id=' . $info['id'] . '" title="Delete \'' . $info['title'] . '\'">Delete</a></td>' . NL;
		}
		echo '  <td style="border-bottom: 1px solid #000; border-right: 1px solid #000">' . $info['author'] . '</td>' . NL;
		echo '  <td style="border-bottom: 1px solid #000; border-right: 1px solid #000">' . format_time( $info['time'] ) . '</td>' . NL;
		echo ' </tr>' . NL;
	}
	?>
	</table>
	<?

}

echo '<br /></div>'. NL;

end_page($name);
?>