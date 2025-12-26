<?php
require('backend.php');
require('edit_class.php');
start_page(20, 'Ticker Manager');
$edit = new edit('ticker', $db);
echo '<div class="boxtop">Ticker Manager</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;
?>
<div style="float: right;"><a href=""><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="?act=new"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; Ticker Manager</font></b>
</div>
<hr class="main" noshade="noshade" align="left" />
<br />
<?php
if(isset($_POST['act']) AND $_POST['act'] == 'edit' AND isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $content = $edit->add_update($id, 'content', $_POST['content'], 'You must enter some fact content.');
    $url = $edit->add_update($id, 'url', $_POST['url'], 'You must enter the relative URL of the topic (E.G. /community/index.php?showtopic=1111).');
    $starttime = $edit->add_update($id, 'starttime', $_POST['starttime'], 'You must enter the start time of this notice.');
    $endtime = $edit->add_update($id, 'endtime', $_POST['endtime'], 'You must enter the end time of this notice.');
    $priority = $edit->add_update($id, 'priority', $_POST['priority'], '',false);    
    $execution = $edit->run_all(false, false);
    if(!$execution) {
        echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
        echo '<p align="center"><a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>' . NL;
        rpostcontent();
    }
    else {
        $ses->record_act('Ticker', 'Edit', substr($content, 0, 20).'...', $ip);
        echo '<p align="center">Entry successfully edited on Zybez.</p>' . NL;
        header('refresh: 2; url=');
    }
}
elseif(isset($_POST['act']) AND $_POST['act'] == 'new') {
    $content = $edit->add_new(1, 'content', $_POST['content'], 'You must enter some fact content.');
    $url = $edit->add_new(1, 'url', $_POST['url'], 'You must enter the relative URL of the topic (E.G. /community/index.php?showtopic=1111).');
    $starttime = $edit->add_new(1, 'starttime', $_POST['starttime'], 'You must enter the start time of this notice.');
    $endtime = $edit->add_new(1, 'endtime', $_POST['endtime'], 'You must enter the end time of this notice.');
    $priority = $edit->add_new(1, 'priority', $_POST['priority'], '',false); 
    $execution = $edit->run_all(false, false);
    if(!$execution) {
        echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
        echo '<p align="center"><a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>' . NL;
        rpostcontent();
    }
    else {
        $ses->record_act('Ticker', 'New', substr($content, 0, 20).'...', $ip);
        echo '<p align="center">New ticker entry was successfully added to Zybez.</p>' . NL;
        header('refresh: 2; url=');
    }
}
elseif(isset($_GET['act']) AND (($_GET['act'] == 'edit' AND isset($_GET['id'])) OR $_GET['act'] == 'new')) {
    if($_GET['act'] == 'edit') {
        $id = intval($_GET['id']);
        $info = $db->fetch_row("SELECT * FROM ticker WHERE id = " . $id);
        if($info) {
            $content = $info['content'];
            $url = $info['url'];
            $starttime = $info['starttime'];
            $endtime = $info['endtime'];
            $priority = $info['priority'];
        }
        else {
            $info = $db->fetch_row("SELECT starttime FROM ticker ORDER BY starttime DESC LIMIT 0,1");
            $content = '';
            $url = '';
            $starttime = '';
            $endtime = '';
            $priority = '';
        }
    }
    else {
        $info = $db->fetch_row("SELECT starttime FROM ticker ORDER BY starttime DESC LIMIT 0,1");
        $content = '';
        $url = '';
        $starttime = '';
        $endtime = '';
        $priority = '';
    }
    echo '<br /><form method="post" name="ticker" action="">' . NL;
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
    echo '<tr><td class="tablebottom" width="50%">Priority<br />(ONLY for currently running events and IMPORTANT news-must set to 0 afterward):</td><td class="tablebottom" colspan="2"><input type="text" style="text-align:center;" size="5" maxlength="2" name="priority" value="'.$priority.'" /></td></tr>' . NL;
    echo '<td class="tabletop" colspan="3" style="border-top: none;">Ticker Content (No longer than 88 characters)</td>' . NL;
    echo '<tr><td class="tablebottom">Content</td><td class="tablebottom" colspan="2"><input type="text" size="100" maxlength="88" name="content" value="'.$content.'" /></td></tr>' . NL;
    echo '<tr><td class="tablebottom">URL</td><td class="tablebottom" colspan="2"><input type="text" size="100" maxlength="255"  name="url" value="'.$url.'" /></td></tr>' . NL;
    echo '<tr><td class="tablebottom" colspan="3"><input type="submit" value="Submit All" /></td></tr>' . NL;
    echo '</table>' . NL;
    echo '</form>' . NL;
    
    echo '<script>var starttime = new calendar3(document.forms[\'ticker\'].elements[\'starttime\']);
	starttime.year_scroll = true;
	starttime.time_comp = false;
	var endtime = new calendar3(document.forms[\'ticker\'].elements[\'endtime\']);
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
            $ses->record_act('Ticker', 'Delete', $_POST['del_txt'], $ip);
            header('refresh: 2; url=');
            echo '<p align="center">Entry successfully deleted from Zybez.</p>' . NL;
        }
    }
    else {
        $id = intval($_GET['id']);
        $info = $db->fetch_row("SELECT * FROM ticker WHERE id = " . $id);
        if($info) {
            $content = $info['content'];
            echo '<p align="center">Are you sure you want to delete the following fact?</p><p>"' . $content . '"</p>';
            echo '<form method="post" action="?act=delete"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_txt" value="' . substr($content, 0, 20).'..." / ><input type="submit" value="Yes" /></center></form>' . NL;
            echo '<form method="post" action=""><center><input type="submit" value="No" /></center></form>' . NL;
        }
        else {
            echo '<p align="center">That identification number does not exist.</p>' . NL;
        }
    }
}

else {
	$qua = "SELECT * FROM ticker ORDER BY priority DESC, starttime DESC";
    $query = $db->query($qua);
    ?>
    <table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="1" cellspacing="0">
    <tr class="boxtop">
    <th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Ticker:</th>
    <th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Actions:</th>
    <th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Priority:</th>
    <th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Start Date:</th>
    <th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">End Date:</th>
    </tr>
    <?php
    while($info = $db->fetch_array($query)) {
        echo '<tr align="center">' . NL;
        echo '<td class="tablebottom">' . substr($info['content'], 0, 40) . '...</td>' . NL;
        echo '<td class="tablebottom"><a href="?act=edit&id=' . $info['id'] . '" title="Edit Ticker">Edit</a>';
        if($ses->permit(15)) {
            echo ' / <a href="?act=delete&id=' . $info['id'] . '" title="Delete Ticker">Delete</a></td>' . NL;
        }
        echo '<td class="tablebottom">' . $info['priority'] . '</td>' . NL;
        echo '<td class="tablebottom">' . $info['starttime'] . '</td>' . NL;
        echo '<td class="tablebottom">' . $info['endtime'] . '</td>' . NL;
        echo '</tr>' . NL;
    }
    if($db->num_rows($qua) == 0) {
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