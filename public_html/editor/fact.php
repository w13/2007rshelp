<?php
require('backend.php');
require('edit_class.php');
start_page(13, 'Facts Manager');
$edit = new edit('facts', $db);
echo '<div class="boxtop">Facts Manager</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;
?>
<div style="float: right;"><a href="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>"><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>?act=new"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; Facts Manager</font></b>
</div>
<hr class="main" noshade="noshade" align="left" />

<?
if($_SESSION['user'] == 'Ben_Goten78') echo '<h2 style="text-align:center;">Maintenance: <a href="fact.php?donttouch">Wipe old fact_ips</a></h2>';
if(isset($_POST['act']) AND $_POST['act'] == 'edit' AND isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $text = $edit->add_update($id, 'text', $_POST['text'], 'You must enter some fact content.');
    $execution = $edit->run_all(false, false);
    if(!$execution) {
        echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
        echo '<p align="center"><a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>' . NL;
        rpostcontent();
    }
    else {
        $ses->record_act('Facts', 'Edit', substr(strip_tags($text), 0, 20).'...', $ip);
        echo '<p align="center">Entry successfully edited on OSRS RuneScape Help.</p>' . NL;
    }
}
elseif(isset($_POST['act']) AND $_POST['act'] == 'new') {
    $text = $edit->add_new(1, 'text', $_POST['text'], 'You must enter some fact content.');
    $stime = $edit->add_new(1, 'starttime', $_POST['stime'], '', false);
    $execution = $edit->run_all(false, false);
    if(!$execution) {
        echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
        echo '<p align="center"><a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>' . NL;
        rpostcontent();
    }
    else {
        $ses->record_act('Facts', 'New', substr(strip_tags($text), 0, 20).'...', $ip);
        echo '<p align="center">New entry was successfully added to OSRS RuneScape Help.</p>' . NL;
    }
}
elseif(isset($_GET['act']) AND (($_GET['act'] == 'edit' AND isset($_GET['id'])) OR $_GET['act'] == 'new')) {
    if($_GET['act'] == 'edit') {
        $id = intval($_GET['id']);
        $info = $db->fetch_row("SELECT * FROM facts WHERE id = " . $id);
        if($info) {
            $text = $info['text'];
            $votes = $info['yes'] + $info['no'];
            $stime = $info['starttime'];
        }
        else {
            $info = $db->fetch_row("SELECT starttime FROM facts ORDER BY starttime DESC LIMIT 0,1");
            $text = '';
            $votes = 0;
            $stime = $info['starttime'] + 604800;
        }
    }
    else {
        $info = $db->fetch_row("SELECT starttime FROM facts ORDER BY starttime DESC LIMIT 0,1");
        $text = '';
        $votes = 0;
        $stime = $info['starttime'] + 604800;
    }
    echo '<br /><form method="post" action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '">' . NL; //?cat=' . $category . '
    if($_GET['act'] == 'edit') {
        echo '<input type="hidden" name="id" value="' . $id . '" />';
    }
    echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />';
    echo '<input type="hidden" name="stime" value="' . $stime . '" />';
    echo '<table width="90%" align="center" style="border-left: 1px solid #000000" cellspacing="0">' . NL;
    echo '<tr>' . NL;
    echo '<td class="tabletop" colspan="2">General</td>' . NL;
    echo '</td>' . NL;
    echo '<tr><td class="tablebottom" width="50%">Start Date:</td><td class="tablebottom">' . date("l F j, Y", $stime) . '</td></tr>' . NL;
    echo '<tr><td class="tablebottom" width="50%">Total Votes:</td><td class="tablebottom">' . $votes . '</td></tr>' . NL;
    echo '<td class="tabletop" colspan="2" style="border-top: none;">Did you know...</td>' . NL;
    echo '<tr><td class="tablebottom" colspan="2"><textarea rows="6" name="text" style="width: 99%;">' . htmlentities($text) . '</textarea></td></tr>' . NL;
    echo '<tr><td class="tablebottom" colspan="2"><input type="submit" value="Submit All" /></td></tr>' . NL;
    echo '</table>' . NL;
    echo '</form>' . NL;
}
elseif(isset($_GET['act']) AND $_GET['act'] == 'delete' AND $ses->permit(15)) {
    if(isset($_POST['del_id'])) {
        $edit->add_delete($_POST['del_id']);
        $execution = $edit->run_all();
        if(!$execution) {
            echo '<p align="center">' . $edit->error_mess . '</p>';
        }
        else {
            $ses->record_act('Facts', 'Delete', $_POST['del_txt'], $ip);
            header('refresh: 2; url=' . htmlspecialchars($_SERVER['PHP_SELF']));
            echo '<p align="center">Entry successfully deleted from OSRS RuneScape Help.</p>' . NL;
        }
    }
    else {
        $id = intval($_GET['id']);
        $info = $db->fetch_row("SELECT * FROM facts WHERE id = " . $id);
        if($info) {
            $text = $info['text'];
            echo '<p align="center">Are you sure you want to delete the following fact?</p><p>"' . $text . '"</p>';
            echo '<form method="post" action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?act=delete"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_txt" value="' . substr(strip_tags($text), 0, 20).'..." / ><input type="submit" value="Yes" /></center></form>' . NL;
            echo '<form method="post" action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '"><center><input type="submit" value="No" /></center></form>' . NL;
        }
        else {
            echo '<p align="center">That identification number does not exist.</p>' . NL;
        }
    }
}
elseif(isset($_GET['donttouch']) && $_SESSION['user'] == 'Ben_Goten78') {
$convert = 604800 / 60 / 60 / 24;
echo '<h2 style="text-align:center;">Wiping Fact IPs more than '.$convert.' days old</h2>';
$db->query("DELETE FROM facts_ip WHERE fid IN (SELECT id FROM facts WHERE starttime < ( UNIX_TIMESTAMP( ) -604800 ))");
header('refresh: 2; url=' . htmlspecialchars($_SERVER['PHP_SELF']));
}

else {
    $query = $db->query("SELECT * FROM facts ORDER BY starttime DESC");
    ?>
    <table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="1" cellspacing="0">
    <tr class="boxtop">
    <th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Fact:</th>
    <th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Actions:</th>
    <th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Start Date:</th>
    </tr>
    <?php
    while($info = $db->fetch_array($query)) {
        echo '<tr align="center">' . NL;
        echo '<td class="tablebottom">' . substr(strip_tags($info['text']), 0, 40) . '...</td>' . NL;
        echo '<td class="tablebottom"><a href="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?act=edit&id=' . $info['id'] . '" title="Edit Fact">Edit</a>';
        if($ses->permit(15)) {
            echo ' / <a href="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?act=delete&id=' . $info['id'] . '" title="Delete Fact">Delete</a></td>' . NL;
        }
        echo '<td class="tablebottom">' . format_time($info['starttime']) . '</td>' . NL;
        echo '</tr>' . NL;
    }
    if(mysqli_num_rows($query) == 0) {
        echo '<tr>' . NL;
        echo '<td class="tablebottom" colspan="3">Sorry, no entries match your search criteria.</td>' . NL;
        echo '</tr>' . NL;
    }
    ?>
    </table>
    <?php
}
echo '<br /></div>'. NL;
end_page();
?>