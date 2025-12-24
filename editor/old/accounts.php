<?php
require('backend.php');
start_page(11, 'Manage Accounts');

echo '<div class="boxtop">Manage Accounts</div>'.NL.'<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">'.NL;

// Start some of my worst coding ever.

?>
<div style="float: right;"><a href="<?=$_SERVER['PHP_SELF']?>"><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="<?=$_SERVER['PHP_SELF']?>?act=new"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>

<div align="left" style="margin:1">
<b><font size="+1">&raquo; Manage Accounts</font></b>
</div>

<hr class="main" noshade="noshade" align="left" />
<?

if(isset($_GET['act']) AND (($_GET['act'] == 'edit' AND isset($_GET['id'])) OR $_GET['act'] == 'new')) {

    $sections = array(
        1 => 'Staff Tools',
        2 => 'Guide Manager',
        3 => 'Map Manager',
        14 => 'Correction Listings',
        4 => 'Calculator Manager',
        5 => 'Shop Database',
        6 => 'Item Database',
        16 => 'Monster Database',
        7 => 'Zybez Library',
        17 => 'RSC Newsletter',
        8 => 'Screenshots',
        9 => 'Concepts',
        10 => 'Marketplace Manager',
        11 => 'Manage Accounts',
        12 => 'News Manager',
        13 => 'Fact Manager',
        15 => 'Ban/Delete Ability',
        18 => 'Team Management/Monitoring');
    
    $permitted = 0;
    $tuser = '';
    $tgroup = '';
    $message = '';
    if($_GET['act'] == 'edit') {
        $id = $_GET['id'];
        $info = $db->fetch_row("SELECT * FROM `admin` WHERE id = ".$id);
        $permitted = $info['perm'];
        $tuser = $info['user'];
        $tgroup = $info['group'];
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
            if(empty($_POST['pass1']) AND empty($_POST['pass2'])) {
                $message = '';
            }
            if($new_pass AND empty($message)) {
                $query = $db->query("UPDATE `admin` SET perm = ".$new_permitted.", pass = '".$pass."' WHERE id = ".$id);
                $message = 'Settings updated successfully. They will take effect after '.$tuser.'\'s next login.';
                $ses->record_act('Manage Users', 'Edit', $tuser);
            }
            elseif(empty($message)) {
                $query = $db->query("UPDATE `admin` SET perm = ".$new_permitted." WHERE id = ".$id);
                $message = 'Settings updated successfully. They will take effect after '.$tuser.'\'s next login. ';
                $ses->record_act('Manage Users', 'Edit', $tuser);
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
                $query = $db->query("SELECT pass FROM admin WHERE user = '".$tuser."'");
                $num = mysql_num_rows($query);
                
                if($num == 0) {
                    $unique = true;
                }
                else {
                    $unique = false;
                }
                if($unique) {
                    $_GET['act'] = 'edit';
                    $query = $db->query("INSERT INTO admin (user, pass, perm, group, last, locked) VALUES ('".$tuser."', '".$pass."', '".$new_permitted."', '".$group."', '".time()."', '".$locked."')");
                    $message .= 'Account creation successful. ';
                    $ses->record_act('Manage Users', 'New User', $tuser);
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
    
    echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'?'.$action.'">';
    echo '<input type="hidden" name="do" value="true" />';
    echo '<table width="75%" align="center" style="border-left: 1px solid #000000" cellspacing="0">';
    echo '<tr>';
    echo '<td class="tabletop" colspan="2">General</td>';
    echo '</td>';
    
    if($_GET['act'] == 'edit') {
        echo '<tr><td class="tablebottom">Username:</td><td class="tablebottom"><input type="text" name="user" value="'.$tuser.'" disabled="disabled" /></td></tr>';
    }
    else {
        echo '<tr><td class="tablebottom">Username:</td><td class="tablebottom"><input type="text" name="user" value="'.$tuser.'" /></td></tr>';
    }
    
    echo '<tr><td class="tablebottom">New Password:</td><td class="tablebottom"><input type="password" name="pass1" /></td></tr>';
    echo '<tr><td class="tablebottom">Confirm New Password:</td><td class="tablebottom"><input type="password" name="pass2" /></td></tr>';
    echo '<tr><td class="tablebottom">Group:</td><td class="tablebottom"><input type="text" name="group" value="'.$group.'" /></td></tr>';
    echo '<tr><td class="tablebottom">LOCKED:</td><td class="tablebottom"><input type="checkbox" name="locked" value"1"'.$sel.' /></td></tr>';
    echo '<td class="tabletop" colspan="2" style="border-top: none;">Permissions</td>';
    
    foreach($sections AS $key => $section) {
    
        if($ses->permit($key, $permitted)) {
            echo '<tr><td class="tablebottom">'.$section.':</td><td class="tablebottom"><input type="checkbox" name="p'.$key.'" value="yes" checked="checked" /></td></tr>';
        }
        else {
            echo '<tr><td class="tablebottom">'.$section.':</td><td class="tablebottom"><input type="checkbox" name="p'.$key.'" value="yes" /></td></tr>';
        }
    }
    
    echo '<tr><td class="tablebottom" colspan="2"><input type="submit" value="Submit" /></td></tr>';
    echo '</table>';
    echo '</form>';
}
elseif(isset($_GET['act']) AND $_GET['act'] == 'delete' AND isset($_GET['id'])) {

    $id = $_GET['id'];
    $info = $db->fetch_row("SELECT * FROM `admin` WHERE id = ".$id);
    $tuser = $info['user'];
    
    echo '<p align="center">Are you sure you want to delete the user, '.$tuser.'?</p>';
    echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'"><center><input type="hidden" name="del_id" value="'.$id.'" / ><input type="hidden" name="del_tuser" value="'.$tuser.'" / ><input type="submit" value="Yes" /></center></form>';
    echo '<form method="get" action="'.$_SERVER['PHP_SELF'].'"><center><input type="submit" value="No" /></center></form>';

}
else {

    if(isset($_POST['del_id']) AND isset($_POST['del_tuser'])) {
        $db->query("DELETE FROM admin WHERE id = ".$_POST['del_id']);
        $ses->record_act('Manage Users', 'Delete', $_POST['del_tuser']);
    }
    ?>
<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">
 <tr>
  <th class="tabletop">Group:</th>
  <th class="tabletop">Username:</th>
  <th class="tabletop">Actions:</th>
  <th class="tabletop">Last Logged On (GMT):</th>
 </tr>
    <?
    
    $query = $db->query("SELECT * FROM `admin` ORDER BY `user`");
    while($info = $db->fetch_array($query)) {
        echo ' <tr align="center">'.NL;
        echo '  <td class="tablebottom" width="5%">'.$info['group'].'</a></td>'.NL;
        echo '  <td class="tablebottom">'.$info['user'].'</a></td>'.NL;
        echo '  <td class="tablebottom"><a href="'.$_SERVER['PHP_SELF'].'?act=edit&id='.$info['id'].'" title="Edit '.$info['user'].'">Edit</a> / ';
        echo '<a href="'.$_SERVER['PHP_SELF'].'?act=delete&id='.$info['id'].'" title="Delete '.$info['user'].'">Delete</a></td>'.NL;
        echo '  <td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">'.format_time($info['last']).'</td>'.NL;
        echo ' </tr>'.NL;
    }
    ?>
</table>
    <?
    

}

echo '<br /></div>'. NL;

end_page();
?>