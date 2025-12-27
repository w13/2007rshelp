<?php
require(dirname(__FILE__) . '/' . 'backend.php');
start_page( 18, 'Activity Monitoring');

?>
<div class="boxtop">Activity Monitoring</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<div align="left" style="margin:1">
<b><font size="+1">&raquo; <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">Activity Monitoring</a> (<a href="<? echo $_SERVER['testingarea']; ?>?inactive">Inactive</a>)</font></b>
</div>
<hr class="main" noshade="noshade" />
<br />
<?php
//$crew = array('Maintenance Crew','Quality Control Crew','Database Crew','Future Development and Innovation','VIP');
//$groups = array(2,3,4,5,1);

$crew = array('Maintenance Crew','Database Crew','Team Leader','VIP');
$groups = array(2,4,6,1);

for($num=0;array_key_exists($num, $crew); $num++) { ## Encase entire contents in here

    $total = $db->query("SELECT count(*) AS num FROM `admin` WHERE `groups` = ".$groups[$num]);
    while($info = $db->fetch_array($total)) {
    echo '<h3>'.$crew[$num].' - Group '.$groups[$num].' (# Mem. '.$info['num'].')</h3>';
    }
## Table ##

echo '<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">'
    .'<tr>'
    .'<td class="tabletop" width="10%">Username</td>'
    .'<td class="tabletop" width="1%"></td>';
echo '<td class="tabletop" width="7%">Manage</td>';
echo '<td class="tabletop" width="6%">Total Actions</td>'
    .'<td class="tabletop" width="6%">Activity</td>';
if(!isset($_GET['inactive'])) echo '<td class="tabletop" width="10%">Last Fortnight</td>';
else echo '<td class="tabletop" width="15%">Inactivity Message</td>';
echo '<td class="tabletop" width="15%">Last Action</td></tr>';
    
## Total Actions ##
$action_count = reset($db->fetch_row("SELECT sum(actions) FROM `admin`"));

## Row Information ##
if(isset($_GET['inactive'])) {
$row_info = $db->query("SELECT al.*, a.*, MAX( `time` ) AS TIMES
     FROM admin_logs al JOIN admin a ON a.id = al.userid
     WHERE groups = ".$groups[$num]." AND
     userid NOT IN (SELECT userid
        FROM admin_logs
        WHERE `time` > (UNIX_TIMESTAMP()-1209600))
GROUP BY userid
ORDER BY TIMES DESC");
  }
else {
$row_info = $db->query("SELECT a.user, a.id, a.last, a.locked, a.groups, actions, MAX( `time` ) AS TIMES, Fortnight.fortnightactions AS 2wks
  FROM
      (SELECT count(*) AS fortnightactions, userid
      FROM admin_logs
      WHERE `time` > (UNIX_TIMESTAMP()-1209600) GROUP BY userid) AS Fortnight NATURAL JOIN admin_logs al JOIN admin a ON a.id=al.userid
  WHERE a.groups = ".$groups[$num]." GROUP BY user ORDER BY TIMES DESC");
}
		while($info = $db->fetch_array($row_info))
		{
      $locked = '';
      $perc = ($info['actions'] / $action_count) * 100;
      echo '<tr>';
    	if( $info['locked'] == 1 ) $locked = ' <img src="extras/locked.png" alt="Locked" title="This account is locked" />';
      echo '<td class="tablebottom">' . $info['user'] . $locked . '</td>'
          .'<td class="tablebottom"><a href="logs.php?search_area=user&amp;search_term=' . $info['user'] . '">'
          .'<img src="/img/market/idb.gif" alt="Logs" title="Check Logs" border="0" /></a></td>'
          .'<td class="tablebottom"><a href="accounts.php?act=edit&amp;id=' . $info['id'] . '">Edit</a>';
          if($ses->permit( 15 )) echo ' / <a href="accounts.php?act=delete&amp;id=' . $info['id'] . '" target="_blank">Delete</a></td>';
          else echo '</td>';
      
      echo '<td class="tablebottom">' . number_format($info['actions']) . '</td>'
          .'<td class="tablebottom">' . round($perc,2) . '% of total</td>';
          if(!isset($_GET['inactive'])) echo '<td class="tablebottom">' . $info['2wks'] . '</td>';
          else echo '<td class="tablebottom">' . $info['inactive'] . '</td>';
          echo '<td class="tablebottom" title="' . format_time($info['last']) . '">' . format_time($info['TIMES']) . ' (GMT)</td></tr>';
		}
  echo '</table>';
}

echo '<br /></div>';

end_page();
?>