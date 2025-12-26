<?php
require('backend.php');
require('edit_class.php');
start_page('Radio Sessions');
$edit = new edit('sessions', $db);
echo '<div class="boxtop">Radio Sessions</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;
?>
<div style="float: right;"><a href="<?=$_SERVER['PHP_SELF']?>"><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="<?=$_SERVER['PHP_SELF']?>?act=new"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; Radio Calendar</font></b>
</div>
<hr class="main" noshade="noshade" align="left" />
<br />
<?
if(isset($_POST['act']) AND $_POST['act'] == 'edit' AND isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $dj = $edit->add_update($id, 'dj', $_POST['di'], 'You must enter your name.');
    $starttime = $edit->add_update($id, 'starttime', $_POST['starttime'], 'You must enter the start time of this session.');
    $endtime = $edit->add_update($id, 'endtime', $_POST['endtime'], 'You must enter the end time of this session.');    
    $execution = $edit->run_all(false, false);
    if(!$execution) {
        echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
        echo '<p align="center"><a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>' . NL;
        rpostcontent();
    }
    else {
        $ses->record_act('Radio Session', 'Edit', substr($content, 0, 20).'...', $ip);
        echo '<p align="center">Session was succesfully edited on calendar.</p>' . NL;
        header('refresh: 2; url=' . $_SERVER['PHP_SELF']);
    }
}
elseif(isset($_POST['act']) AND $_POST['act'] == 'new') {
    $dj = $edit->add_new(1, 'dj', $_POST['dj'], 'You must enter your name here.');
    $starttime = $edit->add_new(1, 'starttime', $_POST['starttime'], 'You must enter the start time of this session.');
    $endtime = $edit->add_new(1, 'endtime', $_POST['endtime'], 'You must enter the end time of this session.');
    $execution = $edit->run_all(false, false);
    if(!$execution) {
        echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
        echo '<p align="center"><a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>' . NL;
        rpostcontent();
    }
    else {
        $ses->record_act('Radio Session', 'New', substr($content, 0, 20).'...', $ip);
        echo '<p align="center">New session was successfully added to calendar.</p>' . NL;
        header('refresh: 2; url=' . $_SERVER['PHP_SELF']);
    }
}
elseif(isset($_GET['act']) AND (($_GET['act'] == 'edit' AND isset($_GET['id'])) OR $_GET['act'] == 'new')) {
    if($_GET['act'] == 'edit') {
        $id = intval($_GET['id']);
        $info = $db->fetch_row("SELECT * FROM sessions WHERE id = " . $id);
        if($info) {
            $dj = $info['dj'];
            $starttime = $info['starttime'];
            $endtime = $info['endtime'];
        }
        else {
            $info = $db->fetch_row("SELECT starttime FROM sessions ORDER BY starttime DESC LIMIT 0,1");
            $dj = '';
            $starttime = '';
            $endtime = '';
        }
    }
    else {
        $info = $db->fetch_row("SELECT starttime FROM sessions ORDER BY starttime DESC LIMIT 0,1");
        $dj = '';
        $starttime = '';
        $endtime = '';
    }
    echo '<br /><form method="post" name="ticker" action="' . $_SERVER['PHP_SELF'] . '">' . NL;
    if($_GET['act'] == 'edit') {
        echo '<input type="hidden" name="id" value="' . $id . '" />';
    }
    echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />';
    echo '<p style="text-align:center;">Not quite sure on the server time for when these will display yet.</p><table width="90%" align="center" style="border-left: 1px solid #000000" cellspacing="0">' . NL;
    echo '<tr>' . NL;
    echo '<td class="tabletop" colspan="3">General</td>' . NL;
    echo '</td></tr>' . NL;
    echo '<script src="extras/calendar.js" type="text/javascript"></script>'.NL;
    echo '<tr><td class="tablebottom" width="50%">Start Time:</td><td class="tablebottom"><input type="text" style="text-align:center;" size="30" maxlength="20" name="starttime" value="'.$starttime.'" /> <a href="javascript:starttime.popup();"><img src="images/b_calendar.png" width="16" height="16" border="0" alt="Click Here to Pick the date"></a></td>' . NL;
    echo '<td class="tablebottom" rowspan="2">yyyy-mm-dd <span title="This bit isn\'t needed" style="cursor:pointer;">hh:mm:ss</span></td></tr>' . NL;
    echo '<tr><td class="tablebottom" width="50%">End Time:</td><td class="tablebottom"><input type="text" style="text-align:center;" size="30" maxlength="20" name="endtime" value="'.$endtime.'" />  <a href="javascript:endtime.popup();"><img src="images/b_calendar.png" width="16" height="16" border="0" alt="Click Here to Pick the date"></a></td></tr>' . NL;
    echo '<td class="tabletop" colspan="3" style="border-top: none;">DJ Name</td>' . NL;
    echo '<tr><td class="tablebottom">Content</td><td class="tablebottom" colspan="2"><input type="text" size="100" maxlength="12" name="content" value="'.$dj.'" /></td></tr>' . NL;
    echo '<tr><td class="tablebottom" colspan="3"><input type="submit" value="Submit All" /></td></tr>' . NL;
    echo '</table>' . NL;
    echo '</form>' . NL;
    
    echo '<script>var starttime = new calendar3(document.forms[\'session\'].elements[\'starttime\']);
	starttime.year_scroll = true;
	starttime.time_comp = false;
	var endtime = new calendar3(document.forms[\'session\'].elements[\'endtime\']);
	endtime.year_scroll = false;
	endtime.time_comp = false;</script>';
}
elseif(isset($_GET['act']) AND $_GET['act'] == 'delete' AND $ses->permit(15)) {
    if(isset($_POST['del_id'])) {
        $edit->add_delete($_POST['del_id']);
        $execution = $edit->run_all();
        if(!$execution) {
            echo '<p align="center">' . $edit->error_mess . '</p>';
        }
        else {
            $ses->record_act('Session', 'Delete', $_POST['del_txt'], $ip);
            header('refresh: 2; url=' . $_SERVER['PHP_SELF']);
            echo '<p align="center">Session successfully deleted from calendar.</p>' . NL;
        }
    }
    else {
        $id = intval($_GET['id']);
        $info = $db->fetch_row("SELECT * FROM sessions WHERE id = " . $id);
        if($info) {
            $content = $info['content'];
            echo '<p align="center">Are you sure you want to delete the following session?</p><p>"' . $dj . '"</p>';
            echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?act=delete"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_txt" value="' . substr($content, 0, 20).'..." / ><input type="submit" value="Yes" /></center></form>' . NL;
            echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '"><center><input type="submit" value="No" /></center></form>' . NL;
        }
        else {
            echo '<p align="center">That identification number does not exist.</p>' . NL;
        }
    }
}

else {
    $query = $db->query("SELECT * FROM sessions ORDER BY starttime DESC");
    ?>
    <table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="1" cellspacing="0">
    <tr class="boxtop">
    <th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">DJ:</th>
    <th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Actions:</th>
    <th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Start Time:</th>
    <th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">End Time:</th>
    </tr>
    <?
    while($info = $db->fetch_array($query)) {
        echo '<tr align="center">' . NL;
        echo '<td class="tablebottom">' . substr($info['dj'], 0, 40) . '...</td>' . NL;
        echo '<td class="tablebottom"><a href="' . $_SERVER['PHP_SELF'] . '?act=edit&id=' . $info['id'] . '" title="Edit Session">Edit</a>';
        if($ses->permit(15)) {
            echo ' / <a href="' . $_SERVER['PHP_SELF'] . '?act=delete&id=' . $info['id'] . '" title="Delete Ticker">Delete</a></td>' . NL;
        }
        echo '<td class="tablebottom">' . $info['starttime'] . '</td>' . NL;
        echo '<td class="tablebottom">' . $info['endtime'] . '</td>' . NL;
        echo '</tr>' . NL;
    }
    if(mysqli_num_rows($query) == 0) {
        echo '<tr>' . NL;
        echo '<td class="tablebottom" colspan="3">Sorry, no entries match your search criteria.</td>' . NL;
        echo '</tr>' . NL;
    }
    ?>
    </table>
    <?
}
echo '<br /></div>'. NL;
end_page();
?>