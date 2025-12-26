<?php
require( 'backend.php' );
require( 'edit_class.php' );
## Create table layout for editing content
## Choose details displayed on index
## Change these to suit content area.
  $ptitle = 'Item Database';
  $ptable = 'items';
  $constraint = '1';
  $categories = in_array($_GET['category'], array('name','member','type'));
  $search_areas = in_array($_GET['search_area'], array('name','member','notes'));
  $search_value = array('name','notes','member');
  $search_name = array('Name','Notes','Member');

start_page( 6, $ptitle );

$edit = new edit( $ptable, $db );

echo '<div class="boxtop">'.$ptitle.'</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;
?>

<?php
//---- Javascript Functions. Hide Instructions and Pre-Edit Alert.
?>
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

<script language="JavaScript" type="text/javascript">
<!-- Begin
function displayHTML(form) {
var inf = form.code.value;
win = window.open(", ", 'popup', 'toolbar = no, status = no');
win.document.write("" + inf + "");
}
//End -->
</script>
<script type="text/javascript">
var formChanged = false;

window.onbeforeunload = function() {
    if (formChanged) return "Do you really want to duplicate this entry?";
}
</script>
<?php
//---- Javascript Functions. Hide Instructions and Pre-Edit Alert.
?>

<div style="float: right;">
<a href="<?php=$_SERVER['PHP_SELF']?>"><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="<?php=$_SERVER['PHP_SELF']?>?act=new"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div style="margin:1pt; font-size:large; font-weight:bold;">&raquo; <?php=$ptitle?></div>

<hr class="main" noshade="noshade" align="left" />
<br />

<b>Instructions:</b> <a href="#" onclick=hide('tohide')>Show/Hide</a><br />
<div id="tohide" style="display:none"><p>Introduction text</p>
<ol>
<li>Instruction Listing</li>
</ol></div>

<?php
if( isset( $_POST['act'] ) AND $_POST['act'] == 'edit' AND isset( $_POST['id'] ) ) {

	$id = intval( $_POST['id'] );
	
	$name = $edit->add_update( $id, 'name', $_POST['name'], '', false );
	$image = $edit->add_update( $id, 'image', $_POST['image'], '', false );
	$type = $edit->add_update( $id, 'type', $_POST['type'], '', false );
	$member = $edit->add_update( $id, 'member', isset($_POST['member']) ? 1 : 0, '', false );
	$notes = $edit->add_update( $id, 'notes', $_POST['notes'], '', false );
	$keyword = $edit->add_update( $id, 'keyword', $_POST['keyword'], '', false );
	$credits = $edit->add_update( $id, 'credits', $_POST['credits'], '', false );

	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p style="text-align:center;">' . $edit->error_mess . '</p>' . NL;
		echo '<p style="text-align:center;"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		$ses->record_act( $ptitle, 'Edit', $name, $ip );
		echo '<p style="text-align:center;">Entry successfully edited on Zybez.</p>' . NL;
	}
	
}
elseif( isset( $_POST['act'] ) AND $_POST['act'] == 'new' ) {

	$name = $edit->add_new( 1, 'name', $_POST['name'], '', false );
	$image = $edit->add_new( 1, 'image', $_POST['image'], '', false );
	$type = $edit->add_new( 1, 'type', $_POST['type'], '', false );
	$member = $edit->add_new( 1, 'member', isset($_POST['member']) ? 1 : 0, '', false );
	$notes = $edit->add_new( 1, 'notes', $_POST['notes'], '', false );
	$keyword = $edit->add_new( 1, 'keyword', $_POST['keyword'], '', false );
	$credits = $edit->add_new( 1, 'credits', $_POST['credits'], '', false );
	
	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p style="text-align:center;">' . $edit->error_mess . '</p>' . NL;
		echo '<p style="text-align:center;"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		$ses->record_act( $ptitle, 'New', $name, $ip );
		echo '<p style="text-align:center;">New entry was successfully added to Zybez.</p>' . NL;
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
			$image = $info['image'];
			$type = $info['type'];
			$member = $info['member'];
			$notes = $info['notes'];
			$keyword = $info['keyword'];
			$credits = $info['credits'];
			
		}
		else {			
			$_GET['act'] = 'new';	
			$name = '';
			$image = 'nopic.gif';
			$type = '3';
			$member = 1;
			$notes = '';
			$keyword = '';
			$credits = '-';
	
		}
	}
	else {
			$name = '';
			$image = 'nopic.gif';
			$type = '3';
			$member = 1;
			$notes = 'None';
			$keyword = '';
			$credits = '-';
	}

	echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">' . NL;
	echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />';

	if( $_GET['act'] == 'edit') {
		enum_correct( $ptable, $id );	
		echo '<input type="hidden" name="id" value="' . $id . '" />';
    $sel = $info['member'] == 1 ? ' checked="checked"' : ''; ## Checkboxes
		}
		
  echo '<h1 style="text-align:center;">Edit Area. Place Table Layout and input boxes here</h1>';
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
else { ## Index Page

  $order = $_GET['order'] == 'DESC' ? 'DESC' : 'ASC';
  $category = $categories == TRUE ? $_GET['category'] : 'name';
  $page = intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;
  
if(isset($_GET['search_area']) AND $search_areas == TRUE) {
    $search_area = addslashes($_GET['search_area']);
    $search_term = strip_tags($_GET['search_term']);
    $search = "WHERE ".$constraint[0]." AND ".$search_area." LIKE '%".addslashes($search_term)."%' ORDER BY `".$category."` ".$order;
	}
	else {
		$search_term = '';
		$search_area = '';
		$search = "ORDER BY `time` DESC";
	}

/*===========  Page Control  ============*/

$rows_per_page     = 10;
$quee = "SELECT * FROM ".$ptable." " . $search;
$row_count         = $db->query($quee);
$row_count         = $db->num_rows($quee);;
$page_count        = ceil($row_count / $rows_per_page) > 1 ? ceil($row_count / $rows_per_page) : 1;
$page_links        = ($page > 1 AND $page < $page_count) ? '|' : '';
$start_from        = $page - 1;
$start_from        = $start_from * $rows_per_page;
$end_at            = $start_from + $rows_per_page;

$quaa = "SELECT * FROM ".$ptable." " . $search . " LIMIT " . $start_from . ", " . $rows_per_page;
$query = $db->query($quaa);

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
	

/*---- PROGRESS INFO ---- */

/*
$total = $db->query("SELECT * FROM ".$ptable);
$num_total = mysqli_num_rows($total );
$num_complete = 0;

  while( $info = $db->fetch_array( $total ) ) {
    if( $info['complete'] == 1) {
      $num_complete++;
    }
    elseif( $info['type'] != 0 && ( $info['image'] !='nopic.gif' && $info['notes'] == '' OR $info['complete'] == 0) ) {
      $num_started++;
    }
  }

$num_need = $num_total - $num_complete;
$percent_complete = $num_complete / $num_total;
$percent_complete = $percent_complete * 100;
$percent_complete = round( $percent_complete , 2 );

$percent_started = $num_started / $num_total;
$percent_started = $percent_started * 100;
$percent_started = round( $percent_started , 2 );

$percent_needed = 100 - $percent_complete - $percent_started;
$percent_needed = round ( $percent_needed , 3 );
?>
	
<table class="boxtop" border="0" cellpadding="1" cellspacing="2" width="100%" style="border: 1px solid black; margin: auto;">
<tr>
<td align="center" colspan="3">To Complete: <?php=$num_need?></td>
</tr>
<tr>
<td valign="top" align="center" width="110">Completed: <?php=$num_complete?></td>
<td>
<table width="100%" cellpadding="1" cellspacing="0" style="border: 1px solid black;"><tr>
<td bgcolor="#009E00" width="<?php=$percent_complete?>%" align="center"><?php=$percent_complete?>%</td>
<?php if( $percent_started > 0 ) { ?><td bgcolor="#D4D400" width="<?php=$percent_started?>%" style="border-left: 1px solid black;" align="center"><?php=$percent_started?>%</td>
<?php } else { ?><td bgcolor="#D4D400" align="center" style="border-left: 1px solid black;"></td> <?php } ?>
	<!--echo '<td bgcolor="#D4D400" width="' . $percent_started . '%" align="center" style="border-left: 1px solid black; text-color: black;">' . $percent_started . '%</td>';
}
?>-->
<td bgcolor="#B80000" style="border-left: 1px solid black;"><?php=$percent_needed?>%</td>
</tr></table>
</td>
<td valign="top" align="center" width="110">Total: <?php=$num_total?></td>
</tr>
<tr>
<td align="center" colspan="3">Incomplete/Started: <?php=$num_started?> ( <a href="<?php=$_SERVER['PHP_SELF']?>?act=incomplete">View</a> )</td>
</tr>

</table><br />
*/
?>
	<table style="border-left: 1px solid #000;" width="100%" cellpadding="1" cellspacing="0">
	<tr>
	<th class="tabletop">Image:</th>
	<th class="tabletop">Name:</th>
	<th class="tabletop">Actions:</th>
	<th class="tabletop">Last Edited (GMT):</th>
	</tr>
	<?php
	

	while($info = $db->fetch_array( $query ) ) {
	
		echo '<tr align="center">' . NL;
		echo '<td class="tablebottom"><img src="/img/idbimg/' . $info['image'] . '" alt="Item Image" /></td>';
		echo '<td class="tablebottom"><a href="/items.php?id=' . $info['id'] . '" title="View Item" target="item_view">' . $info['name'] . '</a></td>' . NL;
		echo '<td class="tablebottom"><a href="' . $_SERVER['PHP_SELF'] . '?act=edit&amp;id=' . $info['id'] . '" title="Edit ' . $info['name'] . '">Edit</a>';

		if( $ses->permit( 15 ) ) {
			echo ' / <a href="' . $_SERVER['PHP_SELF'] . '?act=delete&amp;id=' . $info['id'] . '" title="Delete \'' . $info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td class="tablebottom">' . format_time( $info['time'] ) . '</td>' . NL;
		echo '</tr>' . NL;
	}
	if( $db->num_rows( $quaa ) == 0 ) {
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="4">Sorry, no entries match your search criteria.</td>' . NL;
		echo '</tr>' . NL; 
  }
?>
</table><br />

<?php
}
echo '<br /></div>'. NL;
end_page();
?>