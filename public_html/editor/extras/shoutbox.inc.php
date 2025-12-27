<?php
		$sbox = '';
		if(!empty($_POST['shout'])) {
		if(substr($_POST['shout'], 0, 2) == '[[') {
		$post = $_POST['shout'];
		$post = str_replace('[[','',$post);
		$db->query("INSERT INTO admin_message SET userid=".$_SESSION['userid'].", message='<b>".htmlentities(stripslashes($post), ENT_QUOTES)."</b>', time=".gmt_time());
		}
		elseif(substr($_POST['shout'], 0, 3) == '[r]') {
		$post = $_POST['shout'];
		$post = str_replace('[r]','',$post);
		$db->query("INSERT INTO admin_message SET userid=".$_SESSION['userid'].", message='<b style=\'color:red\'>".htmlentities(stripslashes($post), ENT_QUOTES)."</b>', time=".gmt_time());
		}
		else {
		$db->query("INSERT INTO admin_message SET userid=".$_SESSION['userid'].", message='".htmlentities(stripslashes($_POST['shout']), ENT_QUOTES)."', time=".gmt_time());
		}
			header('Location: ..'.$_SERVER['SCRIPT_NAME'].'?'.$_SERVER['QUERY_STRING'].'#sbox');
			exit;
		}
		
		$query = $db->query("SELECT admin_message.*, admin.groups, admin.user FROM admin_message, admin WHERE admin.id = admin_message.userid ORDER BY admin_message.id DESC LIMIT 0,50");
		
		while($info = $db->fetch_array($query)) {
    $grp = $info['groups'];
    $vip = '';
		if( $grp == 1 ) { $grp = '<img src="extras/manager.gif" alt="VIP" /><strong>';  $vip = ' class="vip"'; }
		elseif( $grp == 6 ) $grp = '<img src="extras/tl.gif" alt="TL" /><strong>';
		elseif( $grp == 2 ) $grp = 'MC: <strong>';
		elseif( $grp == 4 ) $grp = 'DC: <strong>';
		else $grp = 'Noob: <strong>';
		
        $sbox .= NL.'<tr title="'.format_time($info['time']).'"><td class="sb">'.$grp . $info['user'].':</strong></td><td'.$vip.'>'.$info['message'].'</td></tr>';
}
?>