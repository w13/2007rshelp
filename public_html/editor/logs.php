<?php
require( 'backend.php' );
start_page( 1, 'Editor Logbook' );

echo '<div class="boxtop">Editor Logbook</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;


?>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; Editor Logbook</font></b>
</div>

<hr class="main" noshade="noshade" align="left" />
<?php
if($_SESSION['user'] == 'J36') echo '<h2 style="text-align:center;">Maintenance: <a href="actions.php?deleteactions">Wipe Old Logs</a> &middot; <a href="actions.php?cacheall">Re-Cache all user actions</a></h2>';
	if( isset( $_GET['search_area'] ) and ( $_GET['search_area'] == 'user' or $_GET['search_area'] == 'area' or $_GET['search_area'] == 'action' or $_GET['search_area'] == 'name' ) ) {
		$search_term = addslashes($_GET['search_term']);
		$search_area = $_GET['search_area'];
		$search = " WHERE " . $search_area . " LIKE '%" . $search_term . "%'";
	}
	else {
		$search_term = '';
		$search_area = '';
		$search = "";
	}
	$search = "SELECT * FROM admin_logs al JOIN admin a ON a.id = al.userid " . $search . " ORDER BY `time` DESC";
	
	if( isset( $_GET['page'] ) ) {
		$page = intval( $_GET['page'] );
	}
	 else {
		$page = '1';
	}
	
	$search_term = stripslashes( $search_term );

	$entries_per_page = 50;
	$entry_count = 5000;
	$total = reset($db->query("SELECT sum(actions) FROM `admin`"));
	$page_count = ceil( $entry_count / $entries_per_page );
	$page_links = '';
	$current_page = 0;

	while( $current_page < $page_count ) {
		$current_page++;
		if( $current_page == $page ) {
			$page_links = '' . $page_links . '<b>['. $current_page . ']</b> ';
		}
		else {
			$page_links = $page_links . '<a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?page=' . $current_page . '&amp;search_area=' . $search_area . '&amp;search_term=' . strip_tags($_GET['search_term']) . '">'. $current_page . '</a> ';
		}
	}

	if( $page_count > 1 AND $page > 1 )
	{
		  $page_before = $page - 1;
		  $page_links = '<a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']). '?page=' . $page_before . '&amp;search_area=' . $search_area . '&amp;search_term=' . strip_tags($_GET['search_term']) . '">< Previous</a> ' . $page_links;
	}

  	if( $page_count > 1 AND $page != $page_count ) {
		  $page_after = $page + 1;
		  $page_links = $page_links . '<a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']). '?page=' . $page_after . '&amp;search_area=' . $search_area . '&amp;search_term=' . strip_tags($_GET['search_term']) . '">Next ></a> ';
	}

	$start_from = $page - 1;
	$start_from = $start_from * $entries_per_page;
	$query = $db->query( $search . " LIMIT " . $start_from . ", " . $entries_per_page );

	echo '<form action="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '" method="get">' . NL;
	echo '<table width="100%"><tr>' . NL;
	echo '<td align="left" width="150">Total Actions: ' . number_format($total) . '</td>' . NL;

	echo '<td align="center">' . NL;
	echo 'Search <select name="search_area">' . NL;
	
	if( $search_area == 'user' ) {
		echo '<option value="user" selected="selected">Username</option>' . NL;
	}
	else {
		echo '<option value="user">Username</option>' . NL;
	}
	if( $search_area == 'area' ) {
		echo '<option value="area" selected="selected">Area</option>' . NL;
	}
	else {
		echo '<option value="area">Area</option>' . NL;
	}
	if( $search_area == 'action' ) {
		echo '<option value="action" selected="selected">Action</option>' . NL;
	}
	else {
		echo '<option value="action">Action</option>' . NL;
	}
	if( $search_area == 'name' ) {
		echo '<option value="name" selected="selected">Name</option>' . NL;
	}
	else {
		echo '<option value="name">Name</option>' . NL;
	}
	echo '</select> for ' . NL;

	echo '<input type="text" name="search_term" value="' . strip_tags($_GET['search_term']) . '" maxlength="40" />' . NL;
	echo '<input type="submit" value="Go" />' . NL;
	echo '</td>' . NL;

	echo '<td align="right" width="150">Page ' . $page . ' of ' . $page_count . '</td>' . NL;
	echo '</table></form>' . NL;
	
?>
<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">
<tr class="boxtop">
<th class="tabletop">Username:</th>
<th class="tabletop">Area:</th>
<th class="tabletop">Action:</th>
<th class="tabletop">Name:</th>
<th class="tabletop">Time (GMT):</th>
<?php
if($ses->permit(18)) {
?><th class="tabletop">IP Address</th>
<?php
}
?>
</tr>
<?php

while($info = $db->fetch_array( $query ) ) {
	echo '<tr align="center">' . NL;
	echo '<td class="tablebottom">' . $info['user'] . '</a></td>' . NL;
		
	echo '<td class="tablebottom">' . $info['area'] . '</a>' . NL;
	echo '<td class="tablebottom">' . $info['action'] . '</a>' . NL;
	echo '<td class="tablebottom">' . $info['name'] . '</a>' . NL;
	echo '<td class="tablebottom">' . format_time( $info['time'] ) . '</td>' . NL;
	if($ses->permit(18)) {
	echo '<td class="tablebottom">' . $info['ip'] . '</td>' . NL;
				 }
	echo '</tr>' . NL;
}
?>
</table>
<?php

if( $page_count > 1 ) {
	echo '<p align="center">' . $page_links . '</p>';
}

echo '<br /></div>'. NL;

end_page();
?>