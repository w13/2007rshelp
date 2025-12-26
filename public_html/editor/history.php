
<?php
require('backend.php');
start_page(1, 'History', 'popup.inc');

echo '<div class="boxtop" style="width:608px;">History</div>'.NL.'<div class="boxbottom" style="padding: 1px 5px 0 5px;width:600px;word-wrap:break-word">'.NL.NL;
?>
<table width="100%" cellpadding="1" cellspacing="0">
<?php
	$query = $db->query("SELECT admin_message.*, admin.user, admin.groups FROM admin_message JOIN admin ON admin.id = admin_message.userid ORDER BY admin_message.id DESC LIMIT 0,200");

		while($info = $db->fetch_array($query)) {
    $grp = $info['groups'];
    $vip = '';
		if( $grp == 1 ) { $grp = '><img src="extras/manager.gif" alt="VIP" /><strong>';  $vip = ' class="vip"'; }
		elseif( $grp == 2 ) $grp = '>MC: <strong>';
		elseif( $grp == 3 ) $grp = '>QC: <strong>';
		elseif( $grp == 4 ) $grp = '>DC: <strong>';
		elseif( $grp == 5 ) $grp = '>FD: <strong>';
		else $grp = '><strong>';
		
		switch($grp) {
		case 1:
        echo $grp;
        echo $vip;
        break;
		case 2:
        echo $grp;
        break;
		case 3:
        echo $grp;
        break;
		case 4:
        echo $grp;
        break;
		case 5:
        echo $grp;
        break;
		}
      echo '<tr title="'.format_time($info['time']).'"><td style="width: 120px;" valign="top"'.$grp.''. $info['user'].':</strong></td><td'.$vip.'>'.$info['message'].'</td></tr>';
}
?>
</table><br /></div>


<?php
end_page();
?>