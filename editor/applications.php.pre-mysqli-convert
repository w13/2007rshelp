<?php
require( 'backend.php' );
require( 'edit_class.php' );
start_page(21, 'Zybez Applications');
if(isset($_GET['radioap'])) $edit = new edit( 'applicationsr', $db );
else $edit = new edit( 'applications', $db );
?>
<div class="boxtop">Applications</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<?php
## EDIT START
  if( isset( $_POST['act'] ) AND $_POST['act'] == 'edit' AND isset( $_POST['id'] ) ) {
  
	$id = intval( $_POST['id'] );  ## id
	$reviewernotes = $edit->add_update( $id, 'reviewernotes', $_POST['reviewernotes'], '', false );
	$processed = $edit->add_update( $id, 'processed', $_POST['processed'], '', false );
	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
		rpostcontent();
	}
	else {
		echo '<p style="text-align:center;">Application Updated.</p>' . NL;
		if(isset($_GET['radioap'])) header( 'refresh: 0; url=' . $_SERVER['PHP_SELF'].'?radio' );
		else header( 'refresh: 0; url=' . $_SERVER['PHP_SELF'] );
	}
}
elseif( (isset( $_GET['act'] ) AND ( ( $_GET['act'] == 'edit' AND isset( $_GET['id'] ) ) OR $_GET['act'] == 'new' )) OR isset($_GET['radioap']) ) {

	if( isset( $_POST['del_id'] ) AND $ses->permit( 15 ) ) {
		$edit_item->add_delete( $_POST['del_id'] );
		$execution = $edit_item->run_all( false, false );
		if( !$execution ) {
			echo '<p style="text-align:center;">' . $edit_item->error_mess . '</p>';
		}
	}
	
	if( $_GET['act'] == 'edit' ) {

		$id = intval( $_GET['id'] );
		## FOR THE LOVE OF GOD, NEVER TOUCH THIS QUERY!!!!
        if(isset($_GET['radioap'])) { $info = $db->fetch_row("SELECT field_1 AS rsn, field_10 AS status, ip_address AS CommunityIP, applicationsr.*, bday_year, bday_month, name, warn_level, joined, email, posts FROM community.ibfpfields_content, helpdb.applicationsr, community.ibfmembers WHERE rscid=member_id AND rscid=ibfmembers.id AND applicationsr.`id` = " . $id); }
		## FOR THE LOVE OF GOD, NEVER TOUCH THIS QUERY!!!!
        else { $info = $db->fetch_row("SELECT field_1 AS rsn, field_10 AS status, ip_address AS CommunityIP, applications.*, bday_year, bday_month, name, warn_level, joined, email, posts FROM community.ibfpfields_content, helpdb.applications, community.ibfmembers WHERE rscid=member_id AND rscid=ibfmembers.id AND applications.`id` = " . $id); }
	
		if( $info ) {
			$reviewernotes = $info['reviewernotes'];
			$processed = $info['processed'];
		}
	else {
			$reviewernotes = '';
			$processed = '';
	}
}
$info['crew'] = $info['crew'] == 'MC' ? 'Maintenance' : $info['crew'];
//$info['crew'] = $info['crew'] == 'QC' ? 'Quality Control' : $info['crew'];
$info['crew'] = $info['crew'] == 'DC' ? 'Database' : $info['crew'];
//$info['crew'] = $info['crew'] == 'FDI' ? 'Future Dev' : $info['crew'];
//$info['crew'] = $info['crew'] == 'ZET' ? 'Zybez Events Team' : $info['crew'];
$info['crew'] = $info['crew'] == 'BLO' ? 'Blog' : $info['crew'];
//$info['crew'] = $info['crew'] == 'DEV' ? 'Developer / Coder' : $info['crew'];
$info['crew'] = $info['crew'] == 'SC' ? 'Support' : $info['crew'];
$info['status'] = $info['status'] == 'f' ? '<span style="color:yellow;font-weight:bold">Free Player</span>' : $info['status'];
$info['status'] = $info['status'] == 'm' ? '<span style="color:green;font-weight:bold">Members</span>' : $info['status'];
$info['status'] = $info['status'] == 'r' ? '<span style="color:red;font-weight:bold">Retired</span>' : $info['status'];
$info['status'] = $info['status'] == 'i' ? '<span style="color:darkred;">Inactive</span>' : $info['status'];
$info['warn_level'] = $info['warn_level'] > 0 ? '+' . $info['warn_level'] : $info['warn_level'];

# Posts Per Day
$days = (time() - $info['joined']) / 60 / 60 / 24;
$ppd = $info['posts'] / $days;

# Age
$month = date('n', time());
$year = date('Y',time());
if ($info['bday_year'] == 0) $bday_unknown = true;

$bday_year = $year - $info['bday_year'];
$bday_month = $month - $info['bday_month'];
if ($bday_month < 0) {
	$bday_month = 12 + $bday_month;
	$bday_year = $bday_year-1;
}

# Years
$yrs = $days / 365;
$yrs = round($yrs,2) . ' years';
$yrs = $yrs > 1 ? '<span style="color:green;font-weight:bold;">'.$yrs.'</span>' : '<span style="color:red;font-weight:bold;">'.$yrs.'</span>';

/*Jer added for avatar viewing*/
$query_av = $db->query("SELECT * FROM community.ibfmember_extra WHERE `id`='" . $info['rscid'] . "'");
$result_av = $db->fetch_array($query_av);
$av = $result_av['avatar_location'];
$av_size = $result_av['avatar_size'];
$av_array = explode('x',$av_size);
if (strlen($av)<15) $av = 'http://www.zybez.net/community/uploads/' . $av;

/*Jer added for IP Checking*/
if ($_SESSION['user'] == 'Jeremy') {
	$info['appip'] = '<a href="/community/index.php?act=usercp&CODE=iptool&ip='.$info['appip'].'" title="RSC IP Check" target="_blank">'.$info['appip'].'</a>';
}
?>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; <a href="<?php echo $_SERVER['PHP_SELF']; ?>">Applications</a> &raquo; <u><a href="/community/index.php?showuser=<?php echo $info['rscid']; ?>" target="_blank"><?php echo $info['name']; ?></a>'s Application</u> (<a href="/recruiting.php" target="_blank">view form</a>)</font></b>
</div><hr class="main" noshade="noshade" />
<br />
<?php
$no = $info['processed'] == 0 ? ' selected="selected"' : '';
$yes = $info['processed'] == 1 ? ' selected="selected"' : '';
$inc = $info['processed'] == 2 ? ' selected="selected"' : '';
$wl = $info['processed'] == 3 ? ' selected="selected"' : '';
if(isset($_GET['radioap'])) {
echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?radioap">'
	  .'<input type="hidden" name="act" value="edit" />'
    .'<input type="hidden" name="id" value="' . $id . '" />'
    .'<table cellspacing="0" width="85%" style="border: 1px solid #000; border-top: none" cellpadding="4" align="center">'
    .'<tr>'
    .'<td colspan="6" class="tabletop" style="border-right:none;">DJ name: '.NL
    .$info['fname'].'</td>'.NL
    .'</tr>'.NL
    .'<tr>'.NL
    .'<td width="15%"># of Songs:</td><td width="20%"><b>'.$info['songs'].'</b></td>'
    .'<td width="15%">Genres:</td><td width="10%">'.$info['genre'].'</td>'
    .'</tr>'
    .'<tr>'
    .'<td>Rating:</td><td>'.$info['warn_level'].'</td><td>Microphone:</td><td>'.$info['mic'].'</td></tr>'
    .'<tr>'
    .'<td>Age:</td><td>';
if ($bday_unknown) echo 'Unknown';
else echo $bday_year.' years, '.$bday_month.' months old.';
echo '</td><td>Hours/Week:</td><td>'.$info['hours'].'</td></tr>'
    .'<tr>'
    .'<td>Timezone:</td><td>'.$info['timezone'].'</td><td>Friendliness:</td><td>'.$info['friend'].'</td></tr>'
    .'<tr>'
    .'<td>RSC Join Date:</td><td>'.date("j M Y",$info['joined']).' ('.$yrs.')</td><td>Experience:</td><td>'.$info['exp'].'</td></tr>'
    .'<tr>'
    .'<td>Posts:</td><td>'.number_format($info['posts']).' ('.round($ppd,2).' per day)</td><td width="10%">Computer Knowledge:</td><td>'.$info['compk'].'</td></tr></table>'
    .'<table cellspacing="0" width="85%" style="border: 1px solid #000; border-top: none" cellpadding="4" align="center">'
    .'<tr>'
    .'<td style="vertical-align:top;">Warn Log Contents (earliest to latest)</td><td><ol>'
	.'<a href="http://www.zybez.net/community/index.php?act=Search&CODE=getalluser&mid='.$info['rscid'].'" target="_blank"><img src="'.$av.'" class="fright" title="View Member\'s Posts" style="width:'.$av_array[0].'px;height:'.$av_array[1].'px;" /></a>';
    $query1 = $db->query("SELECT ibfwarn_logs.* FROM helpdb.applicationsr, community.ibfwarn_logs WHERE rscid=wlog_mid AND id=".$id);
    while($infos = mysql_fetch_array($query1))  {
    $infos['wlog_notes'] = str_replace(",d","",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("<mod>,</mod>","",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("<mod>0,</mod>","",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("<post>, </post>","",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("<post>,, </post>","",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("<post>0, </post>","",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("<susp>","",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("</susp>","",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("[quote]","<em>Quote: ",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("[/quote]","</em>",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("<mod>,,</mod>","",$infos['wlog_notes']);
    $infos['wlog_type'] = $infos['wlog_type'] == 'neg' ? '<span style="color:green;">+</span>' : '<span style="color:red;">-</span>';
    echo "<li>" . $infos['wlog_type'] . " <b>&raquo;</b> " . $infos['wlog_notes'] . "</li>";
    }
    echo '</ol></td>'
    .'</tr>'
    .'<tr>'
    .'<td style="vertical-align:top;">Applicant\'s Comments</td><td>'.$info['comments'].'</td>'
    .'</tr>'
    .'<tr>'
    .'<td colspan="2" class="tabletop">Manager Review Area</td>'
    .'</tr>'       
    .'<tr>'
    .'<td style="vertical-align:top;">Applicant\'s IP</td><td>'.$info['appip'].'</td>'
    .'</tr>'
    .'<tr>'
    .'<td style="vertical-align:top;">Reviewer\'s Comments</td><td><textarea rows="8" style="width: 98%; font: 10px Verdana, Arial, Helvetica, sans, sans serif;" name="reviewernotes">'.$reviewernotes.'</textarea></td>'
    .'</tr>'
    .'<tr>'
    .'<td>Accepted?</td><td><select name="processed"><option value="2" '.$inc.'>No</option><option value="1" '.$yes.'>Yes</option><option value="0" '.$no.'>Under Review</option></select></td>'
    .'</tr>'
    .'<tr><td colspan="2"><center><input type="submit" value="Submit Review" /></center></td></tr>'
	  .'</table></form><br />'
    .'<p style="text-align:center;"><a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>';
}
else { ## normal ap
/*ADDED BY JEREMY FOR HIM TO SEE WHICH APPS HE HAS VIEWED*/
if ($_SESSION['user'] == 'Jeremy') {
	 setcookie("applications",$_COOKIE['applications'].'|'.$id);
}
/*END COOKIE VIEWED STUFF*/
echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">'
	  .'<input type="hidden" name="act" value="edit" />'
    .'<input type="hidden" name="id" value="' . $id . '" />'
    .'<table cellspacing="0" width="85%" style="border: 1px solid #000; border-top: none" cellpadding="4" align="center">'
    .'<tr>'
    .'<td colspan="6" class="tabletop" style="border-right:none;">First name: '.NL
    .$info['fname'].' &raquo; Total Score: '.$info['total'].'/70</td>'.NL
    .'</tr>'.NL
    .'<tr>'.NL
    .'<td width="15%">Applying for:</td><td width="20%"><b>'.$info['crew'].'</b></td>'
    .'<td width="15%">RS Knowledge:</td><td width="10%">'.$info['rsk'].'/10</td>'
    .'</tr>'
    .'<tr>'
    .'<td>Rating:</td><td>'.$info['warn_level'].'</td><td>Literacy:</td><td>'.$info['lit'].'/10</td></tr>'
    .'<tr>'
    .'<td>Age:</td><td>';
if ($bday_unknown) echo 'Unknown';
else echo $bday_year.' years, '.$bday_month.' months old.';
echo '</td><td>Dependability:</td><td>'.$info['dep'].'/10</td></tr>'
    .'<tr>'
    .'<td>RS Status:</td><td>'.$info['status'].'</td><td>Personality:</td><td>'.$info['per'].'/10</td></tr>'
    .'<tr>'
    .'<td>RS Name(s):</td><td><a href="/statsgrabber.php?player='.$info['rsn'].'" target="_blank">'.$info['rsn'].'</a></td><td>Webscripting:</td><td>'.$info['web'].'/10</td></tr>'
    .'<tr>'
    .'<td>RSC Join Date:</td><td>'.date("j M Y",$info['joined']).' ('.$yrs.')</td><td>Graphics:</td><td>'.$info['gfx'].'/10</td></tr>'
    .'<tr>'
    .'<td>Posts:</td><td>'.number_format($info['posts']).' ('.round($ppd,2).' per day)</td><td width="10%">Zybez Interest:</td><td>'.$info['intr'].'/10</td></tr></table>'
    .'<table cellspacing="0" width="85%" style="border: 1px solid #000; border-top: none" cellpadding="4" align="center">'
    .'<tr>'
    .'<td width="20%">Programming Languages:</td><td>'.$info['plang'].'</td>'
    .'</tr>'
    .'<tr>'
    .'<td style="vertical-align:top;">Warn Log Contents (earliest to latest)</td><td><ol>'
	.'<a href="http://www.zybez.net/community/index.php?act=Search&CODE=getalluser&mid='.$info['rscid'].'" target="_blank"><img src="'.$av.'" class="fright" title="View Member\'s Posts" style="width:'.$av_array[0].'px;height:'.$av_array[1].'px;" /></a>';
    $query1 = $db->query("SELECT ibfwarn_logs.* FROM helpdb.applications, community.ibfwarn_logs WHERE rscid=wlog_mid AND id=".$id);
    while($infos = mysql_fetch_array($query1))  {
    $infos['wlog_notes'] = str_replace(",d","",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("<mod>,</mod>","",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("<mod>0,</mod>","",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("<post>, </post>","",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("<post>,, </post>","",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("<post>0, </post>","",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("<susp>","",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("</susp>","",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("[quote]","<em>Quote: ",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("[/quote]","</em>",$infos['wlog_notes']);
    $infos['wlog_notes'] = str_replace("<mod>,,</mod>","",$infos['wlog_notes']);
    $infos['wlog_type'] = $infos['wlog_type'] == 'neg' ? '<span style="color:green;">+</span>' : '<span style="color:red;">-</span>';
    echo "<li>" . $infos['wlog_type'] . " <b>&raquo;</b> " . $infos['wlog_notes'] . "</li>";
    }
    echo '</ol></td>'
    .'</tr>'
    .'<tr>'
    .'<td style="vertical-align:top;">Applicant\'s Comments</td><td>'.$info['comments'].'</td>'
    .'</tr>'
    .'<tr>'
    .'<td colspan="2" class="tabletop">Manager Review Area</td>'
    .'</tr>'       
    .'<tr>'
    .'<td style="vertical-align:top;">Applicant\'s IP</td><td>'.$info['appip'].'</td>'
    .'</tr>'
    .'<tr>'
    .'<td style="vertical-align:top;">Reviewer\'s Comments</td><td><textarea rows="8" style="width: 98%; font: 10px Verdana, Arial, Helvetica, sans, sans serif;" name="reviewernotes">'.$reviewernotes.'</textarea></td>'
    .'</tr>'
    .'<tr>'
    .'<td>Accepted?</td><td><select name="processed"><option value="2" '.$inc.'>No</option><option value="1" '.$yes.'>Yes</option><option value="3" '.$wl.'>Waiting List</option><option value="0" '.$no.'>Under Review</option></select></td>'
    .'</tr>'
    .'<tr><td colspan="2"><center><input type="submit" value="Submit Review" /></center></td></tr>'
	  .'</table></form><br />'
    .'<p style="text-align:center;"><a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>';
} #1 yes, 0 no, 2 incomplete, 3 waiting list
}
elseif( isset( $_GET['act'] ) AND $_GET['act'] == 'delete' AND $ses->permit( 15 ) ) {

	if( isset( $_POST['del_id'] ) ) {
		$edit->add_delete( $_POST['del_id'] );
		$execution = $edit->run_all();
		
		if( !$execution  ) {
			echo '<p style="text-align:center;">' . $edit->error_mess . '</p>';
		}
		else {
			if(isset($_GET['radio'])) $db->query("DELETE FROM `applicationsr` WHERE id = " . $_POST['del_id'] );
			else $db->query("DELETE FROM `applications` WHERE id = " . $_POST['del_id'] );
			$ses->record_act( 'Applications', 'Delete', $_POST['del_name'], $ip );
			header( 'refresh: 2; url=' . $_SERVER['PHP_SELF'] );
			echo '<p style="text-align:center;">Entry successfully deleted from Zybez.</p>' . NL;
		}
	}
	else {

		$id = intval( $_GET['id'] );
		if(isset($_GET['radio'])) $info = $db->fetch_row( "SELECT applicationsr.* FROM `applicationsr` WHERE id = " . $id );
    else $info = $db->fetch_row( "SELECT * FROM `applications` WHERE id = " . $id );
		if( $info ) {
		
			$name = $info['fname'];
			echo '<p style="text-align:center;">Are you sure you want to delete \'' . $name . 's\' Application?</p>';
			if(isset($_GET['radio']))	echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?act=delete&amp;radio"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>' . NL;
			else echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?act=delete"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>' . NL;
			echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '"><center><input type="submit" value="No" /></center></form>' . NL;
		}
		else {
			
			echo '<p style="text-align:center;">That identification number does not exist.</p>' . NL;
		}
	}
}
else {
?>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; <a href="<?php echo $_SERVER['PHP_SELF']; ?>">Applications</a> (<a href="<?php echo $_SERVER['PHP_SELF'];?>?radio">Radio</a>)</font></b>
</div><hr class="main" noshade="noshade" />
<br />
<?php
## SEARCH
  $categories = in_array($_GET['category'], array('crew','total','processed'));
  $search_areas = in_array($_GET['search_area'], array('rscid','crew','reviewernotes'));
  $search_value = array('rscid','crew','reviewernotes');
  $search_name = array('RSC ID','Crew','Reviewer\'s Notes');
  
$order = $_GET['order'] == 'DESC' ? 'DESC' : 'ASC';
$category = $categories == TRUE ? $_GET['category'] : 'rscid';
$page = intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;

if(isset($_GET['search_area']) AND $search_areas == TRUE) {

   $search_area = addslashes($_GET['search_area']);
   $search_term = strip_tags($_GET['search_term']);
	 $search = "WHERE ".$search_area." LIKE '%".addslashes($search_term)."%' ORDER BY total DESC";
}
else
  {
   $search_term = '';
   $search_area = '';
   $search = " ORDER BY `".$category."` ".$order;
}

$rows_per_page     = 50;
if(isset($_GET['radio'])) $row_count = $db->query("SELECT * FROM applicationsr " . $search);
else $row_count = $db->query("SELECT * FROM applications " . $search);
$row_count         = mysql_num_rows($row_count);
$page_count        = ceil($row_count / $rows_per_page) > 1 ? ceil($row_count / $rows_per_page) : 1;
$page_links        = ($page > 1 AND $page < $page_count) ? '|' : '';
$start_from        = $page - 1;
$start_from        = $start_from * $rows_per_page;
$end_at            = $start_from + $rows_per_page;

if(isset($_GET['radio'])) {
    $query = $db->query("SELECT applicationsr.*, name FROM helpdb.applicationsr JOIN community.ibfmembers ON rscid=ibfmembers.id " . $search . " LIMIT " . $start_from . ", " . $rows_per_page);
    }
else {
    $query = $db->query("SELECT applications.*, name, warn_level FROM helpdb.applications JOIN community.ibfmembers ON rscid=ibfmembers.id " . $search . ", warn_level DESC, joined ASC LIMIT " . $start_from . ", " . $rows_per_page);
}

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
//| <a href="applications.php?search_area=crew&search_term=QC">QC</a> | <a href="applications.php?search_area=crew&search_term=FDI">FDI</a>
  echo '<center><a href="applications.php?search_area=crew&search_term=MC">MC</a> | <a href="applications.php?search_area=crew&search_term=DC">DC</a>  | <a href="applications.php?search_area=crew&search_term=Blo">Blogs</a> | <a href="applications.php?search_area=crew&search_term=ZET">ET</a><br />';
  echo '<table cellspacing="5" width="75%"><tr><td class="news"><br />';
  echo '<table style="border-left: 1px solid #000000;" width="95%" align="center" cellpadding="1" cellspacing="0">';
  echo '<tr>';
  echo '<th class="tabletop">RSC Name</th>';
  echo '<th class="tabletop">Applied for <a href="' . $_SERVER['PHP_SELF'] . '?order=ASC&amp;category=crew&amp;page=' . $page . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Crew, Ascending"><img src="/img/up.GIF" width="9" height="9" alt="Sort by: Crew, Ascending" border="0" /></a> <a href="' . $_SERVER['PHP_SELF'] . '?order=DESC&amp;category=crew&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Crew, Descending"><img src="/img/down.GIF" width="9" height="9" alt="Sort by: Crew, Descending" border="0" /></a></th>';
  echo '<th class="tabletop">Options</th>';
  echo '<th class="tabletop">Accepted?</th>';
  echo '</tr>';

while($info = $db->fetch_array($query))   {
if ($info['processed'] == 1) {
	$info['processed'] = '<img src="/img/calcimg/a_green.PNG" alt="" /> Yes';
} elseif ($info['processed'] == 2) {
	$info['processed'] = '<img src="/img/calcimg/a_red.PNG" alt="" /> No';
} elseif ($info['processed'] == 3) {
	$info['processed'] = '<img src="/img/market/p_n.gif" alt="" /> Waiting List';
} else {
	$info['processed'] = '<img src="/img/calcimg/a_yellow.PNG" alt="" /> Under Review';
}

$info['crew'] = isset($_GET['radio']) ? 'Zybez Radio' : $info['crew'];
$info['crew'] = $info['crew'] == 'MC' ? 'Maintenance Crew' : $info['crew'];
//$info['crew'] = $info['crew'] == 'QC' ? 'Quality Control Crew' : $info['crew'];
$info['crew'] = $info['crew'] == 'DC' ? 'Database Crew' : $info['crew'];
//$info['crew'] = $info['crew'] == 'FDI' ? 'Future Dev' : $info['crew'];
//$info['crew'] = $info['crew'] == 'ZET' ? 'Zybez Events Team' : $info['crew'];
//$info['crew'] = $info['crew'] == 'DEV' ? 'Developer / Coder' : $info['crew'];
$info['crew'] = $info['crew'] == 'SC' ? 'Support Crew' : $info['crew'];
$info['crew'] = $info['crew'] == 'BLO' ? 'Blog' : $info['crew'];

    echo '<tr>';
if(isset($_GET['radio'])) echo '<td class="tablebottom"><a href="'.$_SERVER['PHP_SELF'].'?id='.$info['id'].'&amp;act=edit&amp;radioap">'.$info['name'].'</a></td>';
else {
	echo '<td class="tablebottom"';
	/*ADDED BY JEREMY FOR HIM TO SEE WHICH APPS HE HAS VIEWED*/
	if (in_array($info['id'],explode("|",$_COOKIE['applications'])) && $_SESSION['user']=='Jeremy') echo ' style="background-color:#000;"';
	/*END COOKIE STUFF*/
	echo '><a href="'.$_SERVER['PHP_SELF'].'?id='.$info['id'].'&amp;act=edit">'.$info['name'].'</a> ('.$info['total'].')</td>';
}
    echo '<td class="tablebottom">'.$info['crew'].'</td>';
if( $ses->permit( 15 ) && isset($_GET['radio'])) echo '<td class="tablebottom"><a href="' . $_SERVER['PHP_SELF'] . '?act=delete&amp;radio&amp;id=' . $info['id'] . '" title="Delete \'' . $info['fname'] . '\'">Delete</a></td>' . NL;
elseif( $ses->permit( 15 ) ) echo '<td class="tablebottom"<a href="' . $_SERVER['PHP_SELF'] . '?act=delete&amp;id=' . $info['id'] . '" title="Delete \'' . $info['fname'] . '\'">Delete</a></td>' . NL;
    echo '<td class="tablebottom">'.$info['processed'].'</td>';
    echo '</tr>';
  }

  if($row_count == 0 or $page <= 0 or $page > $page_count)
   {
    echo '<tr>';
    echo '<td class="tablebottom" colspan="5">Sorry, no items match your search criteria.';
    echo '</td></tr>';
  }
  echo '</table><br /></td></tr></table></center><br />';

  if($page_count > 1)
   {
    echo '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>';
    echo '<td align="left"><form action="' . $_SERVER['PHP_SELF'] . '" method="get">Jump to page';
    echo ' <input type="text" name="page" size="3" maxlength="3" />';
    echo '<input type="hidden" name="order" value="' . $order . '" />';
    echo '<input type="hidden" name="category" value="' . $category . '" />';
    echo '<input type="hidden" name="search_area" value="' . $search_area . '" />';
    echo '<input type="hidden" name="search_term" value="' . $search_term . '" />';
    echo ' <input type="submit" value="Go" /></form></td>';
    echo '<td align="right">' . $page_links . '</td></tr>';
    echo '<tr><td colspan="2" align="right" width="140">Page ' . $page . ' of ' . $page_count . '</td></tr>';
    echo '</table>';
  }
}
?>
<br /></div>
<?php
end_page();
?>