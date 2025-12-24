<?php
require( 'backend.php' );
require( 'edit_class.php' );
## Create table layout for editing content
## Choose details displayed on index
## Change these to suit content area.
  $ptitle = 'Videos';
  $ptable = 'videos';
  $constraint = array('1');
  $categories = in_array($_GET['category'], array('name','author','description'));
  $search_areas = in_array($_GET['search_area'], array('name','author','description','category'));
  $search_value = array('name','author','description','category');
  $search_name = array('Name','Submitted By','Description','Category #');
  
start_page( 22, $ptitle );

$edit = new edit( $ptable, $db );

echo '<div class="boxtop">'.$ptitle.'</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;
?>

<div style="float: right;">
<a href="<?=$_SERVER['PHP_SELF']?>"><img src="images/browse.gif" title="Browse" border="0" /></a></div>
<div style="margin:1pt; font-size:large; font-weight:bold;">&raquo; <a href="<?=$_SERVER['PHP_SELF']?>"><?=$ptitle?></a> (<a href="?area=vidreports">Video Reports</a>) (<a href="?area=commentreports">Comment Reports</a>)</div>

<hr class="main" noshade="noshade" align="left" />
<br />

<script language="JavaScript">
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
<b>Instructions:</b> <a href="#" onclick=hide('tohide')>Show/Hide</a><br />
<div id="tohide" style="display:none;">
<ol>
<li>Disabled videos are at the top in here. All new videos won't have a thumb or title.</li>
<li>Uncheck the 'Disabled' box to approve it.</li>
<li>Look at the description. Click "Grab info automatically". If the description is <b>worse</b> after being grabbed, click in the textarea and ctrl+z to go back to authors original comments.</li>
<li>Tags will be grabbed automatically for PUTFILE and YOUTUBE videos. Filefront doesn't have tags.</li>
<li>URL should always end up in this format: http://www.youtube.com/v/VU1C-4KPrfo</li>
<li>Time should always be #:## format.</li>
<li>Ensure title isn't too long (try and take any useless bits out)</li>
<li><b>Fix any spelling/grammar issues in descriptions. Use &lt;br /&gt; to split paragraphs.</b></li>
<li><b>DELETE any "Runescape is &copy; Jagex LTD" shit. We don't need that.</b></li>
<li><b>DELETE any 'Runescape Video' or 'Runescape - ' from titles. Its in the Runescape Videos section, DUH</b></li>
<li>Ignore any \' in comments, they'll be stripped on video-preview.</li>
<li>Press Play on the video. If it says its unavailable, it means the author has disabled embedding. Submit it, but <b>check</b> DISABLE.</li>
<li>Hit submit</li>
<li>If its violent/excessive swearing, put this at start of description: &lt;img src="/img/videos/Mrate.gif" alt="Mature Audiences" style="float:right;padding:3px;" /&gt;</li></ol>
<p>With this you have access to Mod the Comments on videos page. Do NOT abuse this privilege. Only delete abusive, offensive or completely off topic comments. There aren't any warnings, it'll just delete the comments.<br /><br />
<b>Report Center</b>: Videos that have been reported for comments and/or inappropriate/broken video are in here. Check out the video in question, check for bad comments or if the video is broken, then delete the report marker.</p>
</div>
<p><b>Music Videos: Title should be: Band - SongName [anything else the submitter wants to say, e.g. tribute to blah blah]</b><br /><br />
<b>SOME OF YOU AREN'T READING THE INSTRUCTIONS -- fix grammar and spelling in the descriptions and remove RS/Runescape from titles!<br />
Featured section is ONLY for movies hosted by Zybez or RSC Staff.</b></p>
<?
if( isset( $_POST['act'] ) AND $_POST['act'] == 'edit' AND isset( $_POST['id'] ) ) {

	$id = intval( $_POST['id'] );
	
	$name = $edit->add_update( $id, 'name', $_POST['name'], '', false );
	$description = $edit->add_update( $id, 'description', $_POST['description'], '', false );
	$keyword = $edit->add_update( $id, 'keyword', $_POST['keyword'], '', false );
	$author = $edit->add_update( $id, 'author', $_POST['author'], '', false );
	$length = $edit->add_update( $id, 'length', $_POST['length'], '', false );
	$url = $edit->add_update( $id, 'url', $_POST['url'], '', false );
	$thumb = $edit->add_update( $id, 'thumb', $_POST['thumb'], '', false );
	$category = $edit->add_update( $id, 'category', $_POST['category'], '', false );
	$disabled = $edit->add_update( $id, 'disabled', $_POST['disabled'], '', false );
	$date = $edit->add_update( $id, 'date', $_POST['date'], '', false );
	$execution = $edit->run_all( false, true );
	
	if( !$execution ) {
		echo '<p style="text-align:center;">' . $edit->error_mess . '</p>' . NL;
		echo '<p style="text-align:center;"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		$ses->record_act( $ptitle, 'Edit', $name, $ip );
		echo '<p style="text-align:center;">Entry successfully edited on Zybez.</p>' . NL;
	}
	
}
elseif( isset( $_GET['act'] ) AND ( ( $_GET['act'] == 'edit' AND isset( $_GET['id'] ) ) OR $_GET['act'] == 'new' ) ) {

	if( isset( $_POST['del_id'] ) AND $ses->permit( 15 ) ) {
		$edit_item->add_delete( $_POST['del_id'] );
		$execution = $edit_item->run_all( false, false );
		if( !$execution ) {
			echo '<p style="text-align:center;">' . $edit_item->error_mess . '</p>';
		}
	}
	
	if( $_GET['act'] == 'edit' ) {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM ".$ptable." WHERE id = " . $id );

		if( $info ) { 
			$name = $info['name'];
			$description = $info['description'];
			$keyword = $info['keyword'];
			$author = $info['author'];
			$length = $info['length'];
			$url = $info['url'];
			$thumb = $info['thumb'];
			$category = $info['category'];
			$disabled = $info['disabled'];
			$date = $info['date'];			
		}
		else {			
			$_GET['act'] = 'new';	
			$name = '';
			$description = '';
			$keyword = '';
			$author = '';
			$length = '';
			$url = '';
			$thumb = '';
			$category = '';
			$disabled = '';
			$date = '';	
		}
	}
	else {
			$name = '';
			$description = '';
			$keyword = '';
			$author = '';
			$length = '';
			$url = '';
			$thumb = '';
			$category = '';
			$disabled = '';
			$date = '';
	}

	echo '<form method="post" name="form" action="' . $_SERVER['PHP_SELF'] . '">'
	    .'<input type="hidden" name="act" value="' . $_GET['act'] . '" />';
	    if($disabled == 1) echo '<input type="hidden" name="date" value="' . time() . '" />'; //New vid approved
	    else echo '<input type="hidden" name="date" value="' . $date . '" />'; //Old vid edited
	    
	if( $_GET['act'] == 'edit') {
		enum_correct( $ptable, $id );	
		echo '<input type="hidden" name="id" value="' . $id . '" />';
    $seldis = $disabled == 1 ? ' checked="checked"' : ''; ## Checkboxes
		}
$options = $category;
$category = ' ';

$stuff = $db->query("SELECT * FROM `videoscategory`;");
			while ($rows = mysql_fetch_assoc($stuff)) {
				$selected = ( $rows['id']==$options ? ' selected="selected"' : '');
				$category = $category . '<option value="' . $rows['id'] . '"'.$selected.'>'.$rows['name'].'</option>';
			}

$getinfo = $disabled == 1 && $name == '' ? '<input type="button" name="getyoutube" onclick="videocurl.location=\'videos_curl.php?url=\' + document.form.url.value + \'&bob=1\'" value="Grab Info Automatically" />' : '';

$embed = $disabled == 1 && $name == '' ? '<iframe src="videos_curl.php" name="videocurl" width="425" height="350"></iframe>' : '<object style="width:425px;height:350px;"><param name="movie" value="'.$url.'"></param><param name="wmode" value="transparent"></param><embed src="'.$url.'" type="application/x-shockwave-flash" wmode="transparent" style="width:425px;height:350px;"></embed></object>';

echo '<iframe id="fakeajax" style="display:none;"></iframe>'
    .'<table width="100%" style="border:1px solid #000;" cellspacing="0" cellpadding="5">';
    if($disabled == 0) {
echo '<tr>'
    .'<td class="tabletop" style="border-top:none;border-right:none" colspan="3">'.$name.'</td></tr>';
    }
echo '<tr>'
    .'<td rowspan="10" width="425">' . $embed . '</td></tr>'
    .'<tr>'
    .'<td>Disabled?:</td><td><input type="checkbox" name="disabled" value="1" '.$seldis.' /></td></tr>'
    .'<tr>'
    .'<td>Submitted By:</td><td><input type="text" name="author" value="'. $author .'" /></td></tr>'
    .'<tr>'
    .'<td>URL:</td><td><input type="text" name="url" value="'. $url .'" size="50" /> ' . $getinfo . '</td></tr>'
    .'<tr>'
    .'<td>Video Name:</td><td><input type="text" name="name" value="'. $name .'" size="50" /></td></tr>'
    .'<tr>'
    .'<td>Description:</td><td><textarea name="description" style="font: 10px Verdana" rows="7" cols="46">'. addslashes($description) .'</textarea></td></tr>'
    .'<tr>'
    .'<td>Video Tags:</td><td><input type="text" name="keyword" value="'. $keyword .'" size="50" /></td></tr>'
    .'<tr>'
    .'<td>Thumbnail URL:</td><td><input type="text" name="thumb" size="50" value="'. $thumb .'" onclick="document[thumbnail].src=this.value;" /> <img src="#" alt="" name="thumbnail" /></td></tr>'
    .'<tr>'
    .'<td>Length (00:00):</td><td><input type="text" name="length" value="'. $length .'" /></td></tr>'
    .'<tr>'
    .'<td>Category:</td><td><select name="category">'. $category .'</select></td></tr>'
    .'<tr>'
    .'<td colspan="3" style="text-align:center;"><input type="submit" name="submit" value="Submit" /></td></tr>'
    .'</table>';
	echo '</form>' . NL;
}
elseif( isset( $_GET['act'] ) AND $_GET['act'] == 'delete' AND $ses->permit( 15 ) ) {

	if( isset( $_POST['del_id'] ) ) {
		$edit->add_delete( $_POST['del_id'] );
		$execution = $edit->run_all();
		
		if( !$execution  ) {
			echo '<p style="text-align:center;">' . $edit->error_mess . '</p>';
		}
		else {
			$db->query("DELETE FROM ".$ptable." WHERE id = " . $_POST['del_id'] );
			$ses->record_act( $ptitle, 'Delete', $_POST['del_name'], $ip );
			header( 'refresh: 2; url=' . $_SERVER['PHP_SELF'] );
			echo '<p style="text-align:center;">Entry successfully deleted from Zybez.</p>' . NL;
		}
	}
	else {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM ".$ptable." WHERE id = " . $id );
	
		if( $info ) {
		
			$name = $info['name'];
			echo '<p style="text-align:center;">Are you sure you want to delete \'' . $name . '\'?</p>';
			echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?act=delete"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>' . NL;
			echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '"><center><input type="submit" value="No" /></center></form>' . NL;
		}
		else {
			
			echo '<p style="text-align:center;">That identification number does not exist.</p>' . NL;
		}
	}
}
elseif ($_GET['area'] == 'vidreports') { ## VIDEO REPORTS!
	$rquery = $db->query("SELECT * FROM `videosreports` ORDER BY `date` DESC LIMIT 0,30");
	echo '<p class="info">If the report is specific enough to identify the exact problem, act accordingly.  If the video was reported because of violence or language, follow step 14 in the show/hide instructions.  If the video no longer works, delete it or ask for it to be deleted.</p><br />';
	echo '<table style="border-left: 1px solid #000;" width="100%" cellpadding="1" cellspacing="0">'
		.'<tr><th class="tabletop">Thumb</th><th class="tabletop">Name</th><th class="tabletop">Report</th><th class="tabletop">Actions</th></tr>';
	while ($rinfo = $db->fetch_array($rquery)) {
		$vquery = $db->query("SELECT * FROM `videos` WHERE `id`='" . $rinfo['vid'] . "'");
		$vinfo = $db->fetch_array($vquery);
		echo '<tr><td class="tablebottom" style="width:130px;height:97px;"><a href="/runescapevideos.php?id=' . $vinfo['id'] . '" title="View Video" target="_blank"><img src="' . $vinfo['thumb'] . '" alt="" style="width:130px;height:97px;" border="0" /></a></td>'
			.'<td class="tablebottom">'.$vinfo['name'].'</td>'
			.'<td class="tablebottom">'.$rinfo['report'].'</td>'
			.'<td class="tablebottom"><a href="?deletereport=' . $rinfo['id'] . '">Delete Report</a><br /><br /><a href="' . $_SERVER['PHP_SELF'] . '?act=edit&amp;id=' . $vinfo['id'] . '" title="Edit">Edit</a>';
		if( $ses->permit( 15 ) ) {
			echo ' / <a href="' . $_SERVER['PHP_SELF'] . '?act=delete&amp;id=' . $vinfo['id'] . '" title="Delete \'' . $vinfo['name'] . '\'">Delete</a></td>';
		}
		echo '</td></tr>';
	}
	if (mysqli_num_rows($rquery) < 1) {
		echo '<tr><td colspan="4" class="tablebottom">There are no video reports to display.</td></tr>';
	}
	echo '</table>';
}
elseif (isset($_GET['deletereport'])) {
	$db->query("DELETE FROM `videosreports` WHERE `id`='" . intval($_GET['deletereport']) . "' LIMIT 1");
	$ses->record_act( $ptitle, 'Process Report', 'Video #' . intval($_GET['id']), $ip );
	echo '';
	header("refresh:2;url=videos.php?area=vidreports");
	echo '<p style="text-align:center;">Report successfully deleted from Zybez.</p>';
}
elseif ($_GET['area'] == 'commentreports') { ## COMMENT REPORTS!
	$query = $db->query("SELECT * FROM `videoscomments` WHERE `reported` > 0");
	echo '<p class="info">Click the link and read any comments that have a green checkmark beside them.  Click the red X to delete any comments or the green checkmark to clear the report.</p><br />';
	echo '<table style="border-left: 1px solid #000;" width="100%" cellpadding="1" cellspacing="0">'
		.'<tr><th class="tabletop">Video</th><th class="tabletop">Comment</th></tr>';
	while ($info = $db->fetch_array($query)) {
		echo '<tr><td class="tablebottom"><a href="/runescapevideos.php?id=' . $info['vid'] . '" title="View Video" target="_blank">Link</a></td>'
			.'<td class="tablebottom">'.$info['comment'].'</td></tr>';
	}
	if (mysqli_num_rows($query) < 1) {
		echo '<tr><td colspan="4" class="tablebottom">There are no comment reports to display.</td></tr>';
	}
	echo '</table>';
}
else { ## Index Page
if(!$_COOKIE['videoadmin']) {
  setcookie("videoadmin", "Y2F0ZWdvcnk9OTU", time()+9600,'/');
  }
  $order = $_GET['order'] == 'DESC' ? 'DESC' : 'ASC';
  $category = $categories == TRUE ? $_GET['category'] : 'name';
  $page = intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;
  
if(isset($_GET['search_area']) AND $search_areas == TRUE) {
    $search_area = addslashes($_GET['search_area']);
    $search_term = strip_tags($_GET['search_term']);
    $search = " WHERE ".$constraint[0]." AND ".$search_area." LIKE '%".addslashes($search_term)."%' ORDER BY `".$category."` ".$order;
} else {
		$search_term = '';
		$search_area = '';
		$search = " ORDER BY disabled DESC, `date` DESC";
}

/*===========  Page Control  ============*/

$rows_per_page     = 10;
$row_count         = $db->query("SELECT * FROM ".$ptable."" . $search);
$row_count         = mysqli_num_rows($row_count);
$page_count        = ceil($row_count / $rows_per_page) > 1 ? ceil($row_count / $rows_per_page) : 1;
$page_links        = ($page > 1 AND $page < $page_count) ? '|' : '';
$start_from        = $page - 1;
$start_from        = $start_from * $rows_per_page;
$end_at            = $start_from + $rows_per_page;

$query = $db->query("SELECT * FROM ".$ptable." " . $search . " LIMIT " . $start_from . ", " . $rows_per_page);

if($page > 1) {
    $page_before = $page - 1;
    $page_links = '<a href="' . $_SERVER['PHP_SELF']. '?page=' . $page_before . '&amp;order=' . $order . '&amp;category=' . $category . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '">< Previous</a> ' . $page_links;
}
if($page < $page_count) {
    $page_after = $page + 1;
    $page_links = $page_links . ' <a href="' . $_SERVER['PHP_SELF']. '?page=' . $page_after . '&amp;order=' . $order . '&amp;category=' . $category . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '">Next ></a> ';
}
if($page > 2) {
    $page_links = '<a href="' . $_SERVER['PHP_SELF']. '?page=1&amp;order=' . $order . '&amp;category=' . $category . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '">&laquo; First</a> '. $page_links;
}
if($page < ($page_count - 1)) {
    $page_links = $page_links . ' <a href="' . $_SERVER['PHP_SELF']. '?page=' . $page_count . '&amp;order=' . $order . '&amp;category=' . $category . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '">Last &raquo;</a> ';
}


/*============  SEARCH FORM  ============*/

echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="get"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>'.NL
.'<td align="left" width="150">Browsing ' . $row_count . ' ' . ucfirst($table) . '(s)</td>'.NL
.'<td align="center">'.NL
.'Search <select name="search_area">';

for($num = 0; array_key_exists($num, $search_value) && array_key_exists($num, $search_name); $num++) {
    echo $search_area == $search_value[$num] ? '<option value="'.$search_value[$num].'" selected="selected">'.$search_name[$num].'</option>' : '<option value="'.$search_value[$num].'">'.$search_name[$num].'</option>';
}

echo '</select> for'.NL
.' <input type="text" name="search_term" value="' . $search_term . '" maxlength="40" />'.NL
.' <input type="submit" value="Go" /></td>'.NL
.'<td align="right" width="140">Page ' . $page . ' of ' . $page_count . '</td>'.NL
.'</tr></table></form>';
	
?>
	<table style="border-left: 1px solid #000;" width="100%" cellpadding="1" cellspacing="0">
	<tr>
	<th class="tabletop">Thumb:</th>
	<th class="tabletop">Title:</th>
	<th class="tabletop">Author:</th>
	<th class="tabletop">Actions:</th>
	<th class="tabletop">Last Edited (GMT):</th>
	</tr>
	<?
	

	while($info = $db->fetch_array( $query ) ) {
	
		echo '<tr align="center">' . NL;
		echo '<td class="tablebottom" style="width:130px;height:97px;"><a href="/runescapevideos.php?id=' . $info['id'] . '" title="View Video" target="_blank"><img src="' . $info['thumb'] . '" alt="" style="width:130px;height:97px;" border="0" /></a></td>' . NL;
		echo '<td class="tablebottom">' . $info['name'] . '</td>' . NL;
		echo '<td class="tablebottom">' . $info['author'] . '</td>' . NL;
		echo '<td class="tablebottom">';
		echo '<a href="' . $_SERVER['PHP_SELF'] . '?act=edit&amp;id=' . $info['id'] . '" title="Edit">Edit</a>';
		if( $ses->permit( 15 ) ) {
			echo ' / <a href="' . $_SERVER['PHP_SELF'] . '?act=delete&amp;id=' . $info['id'] . '" title="Delete \'' . $info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td class="tablebottom">' . format_time( $info['date'] ) . '</td>' . NL;
		echo '</tr>' . NL;
	}
	if( mysqli_num_rows($query ) == 0 ) {
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="5">Sorry, no entries match your search criteria.</td>' . NL;
		echo '</tr>' . NL; 
  }
?>
</table><br />

<?
echo '<div style="text-align:center;font-weight:bold;"><p>'.$page_links.'</p></div>';
}
echo '<br /></div>'. NL;
end_page($name);
?>