<?php
require(dirname(__FILE__) . '/' . 'backend.php');
start_page( 1, 'Content Team Activity');
if(!isset($_GET['cache']) && !isset($_GET['cachefirst']) && !isset($_GET['nextcache']) && !isset($_GET['cacheall']) && !isset($_GET['deleteactions'])) {
?>
<div class="boxtop">Content Team Activity</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<div align="left" style="margin:1">
<b><font size="+1">&raquo; Content Team Activity</font></b>
</div>
<hr noshade="noshade" /><br />
<?php

$total_actions = reset($db->fetch_row("SELECT sum(actions) FROM `admin`"));
	$row = $db->query("SELECT DISTINCT a.user, actions, MAX(time) as TIMES FROM admin_logs al JOIN admin a ON a.id = al.userid WHERE locked = 0 GROUP BY user ORDER BY actions DESC");
		while($info = $db->fetch_array($row))
		{
	$perc = ($info['actions'] / $total_actions) * 100;

	echo '<div class="boxtop" style="border-top: 1px solid #000; border-bottom:1px solid #000; width: 35%; margin: 0 auto; text-align: left; padding: 5px;">' . NL;
    echo 'Username: ' . $info['user'] . '<br />' . NL;
	echo 'Total Actions: ' . number_format($info['actions']) . '<br />' . NL;
	echo 'Activity: ' . round($perc,2) . '% of total<br />' . NL;
	echo 'Last Action: ' . format_time($info['TIMES']) . ' (GMT)</p>' . NL;
	echo '</div><br />' . NL;
		}
?>

</div><br />

<?php
}
else
{
echo '<div class="boxtop">Actions Maintenance</div>'.NL.'<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">'.NL;
?>
<div style="text-align:left;margin:1pt;font-size:large;font-weight:bold;">&raquo; Actions Maintenance (<a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">Back</a>)</div>
<hr class="main" noshade="noshade" align="left" />
<br />
<?php
if(!isset($_GET['cachefirst']) && !isset($_GET['nextcache']) && !isset($_GET['deleteactions']) && !isset($_GET['cacheall']) && $ses->permit(18)) {

echo '<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">';
echo '<tr class="boxtop">';
echo '<th class="tabletop">ID:</th>';
echo '<th class="tabletop">Username:</th>';
echo '<th class="tabletop">Cache Options:</th>';
echo '<th class="tabletop">Actions:</th>';
echo '</tr>';

    $query = $db->query("SELECT * FROM `admin` ORDER BY `actions`");
    while($info = $db->fetch_array($query)) {
        echo '<tr align="center">'.NL;
        echo '<td class="tablebottom" width="5%">'.$info['id'].'</a></td>'.NL;
        echo '<td class="tablebottom">'.$info['user'].'</a></td>'.NL;
      if($info['actions'] == 0) {
        echo '<td class="tablebottom"><a href="'.$_SERVER['SCRIPT_NAME'].'?cachefirst='.$info['id'].'">First Cache (new user)</a></td>'.NL;
        }
      else {
        echo '<td class="tablebottom"><a href="'.$_SERVER['SCRIPT_NAME'].'?nextcache='.$info['id'].'">Next Cache (old user)</a></td>'.NL;
        }
        echo '<td class="tablebottom">'.$info['actions'].'</a></td>'.NL;
        echo '</tr>'.NL;
    }
    echo '</table>';
}
elseif(isset($_GET['nextcache'])) { ## Caching once a user's action cache has been established.

    $id = intval( $_GET['nextcache'] );
    $first_time = 1192197000;  	## Fri, 12 Oct 2007 13:50:02 GMT
    $db->query("UPDATE `admin` SET actions = (actions+(SELECT count(*) FROM admin_logs WHERE time > admin.action_cache AND userid = ".$id.")), action_cache = (SELECT MAX(time) FROM admin_logs WHERE userid = ".$id.") WHERE id = ".$id);
		if($ses->permit(18)) header( 'Location: ' . $_SERVER['SCRIPT_NAME'] . '?cache' );
		else header( 'Location: ' . $_SERVER['SCRIPT_NAME'] );
}
elseif(isset($_GET['cacheall'])) {
    $id=0;
    while ($id < 800) {

       $db->query("UPDATE `admin` SET actions = (actions+(SELECT count(*) FROM admin_logs WHERE time > admin.action_cache AND userid = ".$id.")), action_cache = (SELECT MAX(time) FROM admin_logs WHERE userid = ".$id.") WHERE id = ".$id);
       if(mysqli_affected_rows($db->connect) == 1 ) echo $id . ' query done<br />';
       $id++;
       }
}
#############
####### Create a log archive or not?
####### INSERT INTO archive $db->query(SELECT * FROM admin_logs WHERE userid = ".$id." AND time < ((UNIX_TIMESTAMP()+21600)-".$five_months_old."));
#############

elseif(isset($_GET['deleteactions'])) { ## Delete actions that are five months old.
    echo 'Deleting old actions';
    $five_months_old = 13219200; ## Five Months in Unix
    $db->query("DELETE FROM admin_logs WHERE `time` < (UNIX_TIMESTAMP()-".$five_months_old.")");
		header( 'Refresh: 2; url=https://runescapecommunity.com' . $_SERVER['SCRIPT_NAME'] . '?cache' );
}
elseif(isset($_GET['cachefirst'])) { ## First Caching of a New User.
    $id = intval( $_GET['cachefirst'] );
    //echo 'Creating action count cache for user ID, '.$id;
    ## Create a Cache of their total actions
    ## Set the date of last cache so only actions greater than the last cache are recorded.
    $db->query("UPDATE `admin` SET actions = (SELECT count(*) FROM admin_logs WHERE userid = ".$id."), action_cache = (SELECT MAX(time) FROM admin_logs WHERE userid = ".$id.") WHERE id = ".$id);
		header( 'Location: ' . $_SERVER['SCRIPT_NAME'] . '?cache' );
}
?>

<br /></div>
<?php
}
end_page();
?>