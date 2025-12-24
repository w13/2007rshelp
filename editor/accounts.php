<?php
require('backend.php');
start_page(11, 'Manage Accounts');

echo '<div class="boxtop">Manage Accounts</div>'.NL.'<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">'.NL;

// Start some of my worst coding ever.
    $query = $db->query("SELECT count(*) AS num FROM `admin`");
    while($info = $db->fetch_array($query)) {
?>
<div style="float: right;"><a href="accounts.php"><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="?act=new"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>

<div align="left" style="margin:1">
<b><font size="+1">&raquo; Manage Accounts (<?php $info['num']; ?>)</font></b> <a href="extras/failedlogins.html" target="_blank">Failed Logins</a>
</div>

<hr class="main" noshade="noshade" align="left" />
<?php
}
if(isset($_GET['act']) AND (($_GET['act'] == 'edit' AND isset($_GET['id'])) OR $_GET['act'] == 'new')) {

    $sections = array(
        1 => 'Staff Tools', ## Basic Permissions
        14 => 'Correction Listings',
        19 => 'Upload Images',
        
        2 => '<b>&raquo; MC</b> Guide Managers',  ## MC Permissions
        3 => 'Map Manager',
        4 => 'Calculators <b>&laquo;</b> ---------------',
        
        5 => '<b>&raquo; DC</b> Shop Database',   ## DC Permissions
        6 => 'Item Database',
        16 => 'Monster Database',
        23 => 'Equipment Profile Database',
        7 => 'Tome Archive <b>&laquo;</b> ---------------',
        
       10 => '<b>&raquo; Special</b> Marketplace Manager',    ## Special Permissions
       17 => 'Blogs',
        13 => '<b>&raquo; Special</b> Facts',
       8 => 'Screenshots',
        9 => 'Concepts',
        22 => 'Videos',
		25 => 'Skill Competition',
		 26 => 'Skill X Tracker',
       24 => 'Atlas <b>&laquo;</b> ---------------',        
        
        18 => '<b>&raquo; Managers</b> Team Management',     ## Manager Permissions (Monitor Activity + VIP Message Board)
		20 => 'Ticker',
		15 => 'Ban/Delete Ability',
		 21 => 'Applications <b>&laquo;</b> ---------------',
        
        12 => '<b>&raquo; Admin</b> News Manager',     ## Admin Permissions
        11 => 'Manage Accounts <b>&laquo;</b> ---------------'
        );
    
    $permitted = 0;
    $tuser = '';
    $message = '';
    if($_GET['act'] == 'edit') {
        $id = $_GET['id'];
        $info = $db->fetch_row("SELECT * FROM `admin` WHERE id = ".$id);
        $permitted = $info['perm'];
        $tuser = $info['user'];
        $groups = $info['groups'];
        $inactive = $info['inactive'];
        $sel = $info['locked'] == 1 ? ' checked="checked"' : '';
    }
    if(isset($_POST['do'])) {
        $new_pass = false;
        $new_permitted = 1;
        for($i = 1; array_key_exists($i, $sections); $i++) {
            if(isset($_POST['p'.$i])) {
                $new_permitted += pow(2, $i);
            }
        }
        $message = $message.'You must enter a password. ';
        
        if(!empty($_POST['pass1']) OR !empty($_POST['pass2'])) {
            $new_pass = true;
            
            $len = strlen($_POST['pass1']);
            if($_POST['pass1'] != $_POST['pass2']) {
                $message .= 'The passwords don\'t match. ';
            }
            elseif($len < 5 OR $len > 12) {
                $message .= 'The password must be from 5-12 charcters. ';
            }
            else {
                $message = '';
                $pass = md5(stripslashes($_POST['pass1']));
            }
        }
        if($_GET['act'] == 'edit') {
            $locked = isset($_POST['locked']) ? 1 : 0;
            $sel = isset($_POST['locked']) ? ' checked="checked"' : '';
            $tuser = stripslashes($_POST['tuser']);
            $groups = intval($_POST['groups']);
            $inactive = addslashes($_POST['inactive']);
            if(empty($_POST['pass1']) AND empty($_POST['pass2'])) {
                $message = '';
            }
            if($new_pass AND empty($message)) {
$query = $db->query("UPDATE `admin` SET perm = ".$new_permitted.", pass = '".$pass."', groups = ".$groups.", locked = ".$locked.", user = '".addslashes($tuser)."', inactive = '" . $inactive . "' WHERE id = ".$id);
                $message = 'Settings updated successfully. They will take effect after '.$tuser.'\'s next login.';
                $ses->record_act('Manage Users', 'Edit', $tuser, $ip);
            }
            elseif(empty($message)) {
                $query = $db->query("UPDATE `admin` SET perm = ".$new_permitted.", groups = ".$groups.", locked = ".$locked.", user = '".addslashes($tuser)."', inactive = '" . $inactive . "' WHERE id = ".$id);
                $message = 'Settings updated successfully. They will take effect after '.$tuser.'\'s next login. ';
                $ses->record_act('Manage Users', 'Edit', $tuser, $ip);
            }
        }
        else {
            $tuser = ucwords(strtolower($_POST['user']));
            if(empty($tuser) OR !empty($message)) {
            
                if(empty($tuser)) {
                    $message .= 'You must enter a username. ';
                }
            }
            else {
				$quee = "SELECT pass FROM admin WHERE user = '".$tuser."'";
                $query = $db->query($quee);
                $num = $db->num_rows($quee);
                
                if($num == 0) {
                    $unique = true;
                }
                else {
                    $unique = false;
                }
                if($unique) {
                    $_GET['act'] = 'edit';
                    $groups = $_POST['groups'];
$query = $db->query("INSERT INTO admin (user, pass, perm, groups, last) VALUES ('".$tuser."', '".$pass."', '".$new_permitted."', '".$groups."', '".time()."')");
                    $message .= 'Account creation successful. ';
                    $ses->record_act('Manage Users', 'New User', $tuser, $ip);
                }
                else {
                    $message .= 'That username already exists. Please enter another. ';
                }
            }    
        }
        $permitted = $new_permitted;
    }
    if($_GET['act'] == 'edit') {
        $action = 'act=edit&id='.$id;
    }
    else {
        $action = 'act=new';
    }
    if(!empty($message)) {
        echo '<p align="center">'.$message.'</p>';
    }
    
    echo '<form method="post" action="?'.$action.'">';
    echo '<input type="hidden" name="do" value="true" />';
    echo '<table width="75%" align="center" style="border-left: 1px solid #000" cellspacing="0">';
    echo '<tr>';
    echo '<td class="tabletop" colspan="2">General</td>';
    echo '</td>';
    
    if($_GET['act'] == 'edit') {
    
    $vip = $groups == 1 ? ' selected="selected"' : '';
    $mc = $groups == 2 ? ' selected="selected"' : '';
    $dc = $groups == 4 ? ' selected="selected"' : '';
    $tl = $groups == 6 ? ' selected="selected"' : '';
    
        echo '<tr><td class="tablebottom">Username:</td><td class="tablebottom"><input type="text" name="tuser" value="'.$tuser.'" /></td></tr>';
        echo '<tr><td class="tablebottom">Group:</td><td class="tablebottom"><select name="groups"><option value="1"'.$vip.'>VIP</option><option value="2"'.$mc.'>MC</option><option value="4"'.$dc.'>DC</option><option value="6"'.$tl.'>TL</option></select></td></tr>';
    }
    else {
        echo '<tr><td class="tablebottom">Username:</td><td class="tablebottom"><input type="text" name="user" value="'.$tuser.'" /></td></tr>';
        echo '<tr><td class="tablebottom">Group:</td><td class="tablebottom"><select name="groups"><option value="1">VIP</option><option value="2">MC</option><option value="4">DC</option><option value="6">TL</option></select></td></tr>';
    }
    
    echo '<tr><td class="tablebottom">New Password:</td><td class="tablebottom"><input type="password" name="pass1" autocomplete="off" /></td></tr>';
    echo '<tr><td class="tablebottom">Confirm New Password:</td><td class="tablebottom"><input type="password" name="pass2" autocomplete="off" /></td></tr>';
    echo '<tr><td class="tablebottom">LOCKED:</td><td class="tablebottom"><input type="checkbox" name="locked" value"1"'.$sel.' /></td></tr>';
    echo '<td class="tabletop" colspan="2" style="border-top: none;">Permissions</td>';
    
    foreach($sections AS $key => $section) {
    
        if($ses->permit($key, $permitted)) {
            echo '<tr><td class="tablebottom" style="text-align:left;padding-left:20px;">'.$section.'</td><td class="tablebottom"><input type="checkbox" name="p'.$key.'" value="yes" checked="checked" /></td></tr>';
        }
        else {
            echo '<tr><td class="tablebottom" style="text-align:left;padding-left:20px;">'.$section.'</td><td class="tablebottom"><input type="checkbox" name="p'.$key.'" value="yes" /></td></tr>';
        }
    }
    echo '<tr><td class="tablebottom" colspan="2"><textarea style="font:9px Verdana;width:50%;height:100px;" name="inactive">' . $inactive . '</textarea></td></tr>';
    echo '<tr><td class="tablebottom" colspan="2"><input type="submit" value="Submit" /></td></tr>';
    echo '</table>';
    echo '</form>';
}
elseif(isset($_GET['act']) AND $_GET['act'] == 'delete' AND isset($_GET['id'])) {

    $id = $_GET['id'];
    $info = $db->fetch_row("SELECT * FROM `admin` WHERE id = ".$id);
    $tuser = $info['user'];
    
	
	 if(isset($_POST['del_id']) AND isset($_POST['del_tuser'])) {
        $db->query("DELETE FROM admin WHERE id = ".$_POST['del_id']." LIMIT 1");
        $ses->record_act('Manage Users', 'Delete', $_POST['del_tuser'], $ip);
		echo '<p align="center" style="color:red;font-weight:bold;font-size:1.5em;">Deleted '.$_POST['del_tuser'].'. <br />Click Browse to go back.</p>';
	}else{
	
    echo '<p align="center">Are you sure you want to delete the user, '.$tuser.'?</p>';
    echo '<form method="post" action=""><center><input type="hidden" name="del_id" value="'.$id.'" / ><input type="hidden" name="del_tuser" value="'.$tuser.'" / ><input type="submit" value="Yes" /></center></form>';
    echo '<form method="get" action=""><center><input type="submit" value="No" /></center></form>';
	
	}
	
	}
else {

    if(isset($_POST['del_id']) AND isset($_POST['del_tuser'])) {
        $db->query("DELETE FROM admin WHERE id = ".$_POST['del_id']);
        $ses->record_act('Manage Users', 'Delete', $_POST['del_tuser'], $ip);
    }
    ?>
<table style="border-left: 1px solid #000;" width="100%" cellpadding="1" cellspacing="0">
 <tr class="boxtop">
  <th class="tabletop">ID:</th>
  <th class="tabletop">Group:</th>
  <th class="tabletop">Username:</th>
  <th class="tabletop">Actions:</th>
  <th class="tabletop">Last Logged On (GMT):</th>
  <th class="tabletop">Last Login IP address:</th>
 </tr>
    <?php
    
    $query = $db->query("SELECT * FROM `admin` ORDER BY `user`");
    while($info = $db->fetch_array($query)) {
        echo ' <tr align="center">'.NL;
        echo '  <td class="tablebottom" width="5%">'.$info['id'].'</a></td>'.NL;
        echo '  <td class="tablebottom" width="5%">'.$info['groups'].'</a></td>'.NL;
        echo '  <td class="tablebottom">'.$info['user'].'</a></td>'.NL;
        echo '  <td class="tablebottom" width="20%"><a href="?act=edit&id='.$info['id'].'" title="Edit '.$info['user'].'">Edit</a>';
	 if($ses->permit(15)) {
        echo ' / <a href="?act=delete&id='.$info['id'].'" title="Delete '.$info['user'].'">Delete</a></td>'.NL;
	 }
        echo '  <td class="tablebottom" width="25%">'.format_time($info['last']).'</td>'.NL;
        echo '  <td class="tablebottom" width="20%"><a href="http://whois.domaintools.com/'.$info['last_ip'].'" target="_blank" title="Click here to find information on this IP" rel="nofollow">'.$info['last_ip'].'</a></td>'.NL;
        echo ' </tr>'.NL;
    }
    ?>
</table>
    <?php
    

}

echo '<br /></div>'. NL;

end_page();
?>