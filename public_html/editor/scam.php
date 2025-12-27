<?php
require('backend.php');
require('edit_class.php');
start_page(10, 'Scam Manager');
$edit = new edit('price_scams', $db);
echo '<div class="boxtop">Scam Manager</div>'.NL.'<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">'.NL;
?>
<div style="float: right;"><a href="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>?"><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>?act=new"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; Scam Manager</font></b>
</div>
<hr class="main" noshade="noshade" align="left" />
<?
if(isset($_POST['act']) AND $_POST['act'] == 'edit' AND isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $name = $edit->add_update($id, 'name', $_POST['name'], 'You must enter a scam title.');
    $text = $edit->add_update($id, 'text', $_POST['text'], 'You must enter a scam description.');
    $img = $edit->add_update($id, 'img', $_POST['img'], 'You must enter an image name with file extension.');
    $warn_level = $edit->add_update($id, 'warn_level', $_POST['warn_level'], 'Warn level not provided.');
    $execution = $edit->run_all(true, true);
    if(!$execution) {
        echo '<p align="center">'.$edit->error_mess.'</p>'.NL;
        echo '<p align="center"><a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>'.NL;
        rpostcontent();
    }
    else {
        $ses->record_act('Scam Alert', 'Edit', $name, $ip);
        echo '<p align="center">Entry successfully edited on OSRS RuneScape Help.</p>'.NL;
        header('refresh: 2; url='.htmlspecialchars($_SERVER['PHP_SELF']));
    }
}
elseif(isset($_POST['act']) AND $_POST['act'] == 'new') {
    $name = $edit->add_new(1, 'name', $_POST['name'], 'You must enter a scam title.');
    $text = $edit->add_new(1, 'text', $_POST['text'], 'You must enter a scam description.');
    $img = $edit->add_new(1, 'img', $_POST['img'], 'You must enter an image name with extension.');
    $warn_level = $edit->add_new(1, 'warn_level', $_POST['warn_level'], 'Warn level not provided.');
    $execution = $edit->run_all(true, true);
    if(!$execution) {
        echo '<p align="center">'.$edit->error_mess.'</p>'.NL;
        echo '<p align="center"><a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>'.NL;
        rpostcontent();
    }
    else {
        $ses->record_act('Scam Alert', 'New', $name, $ip);
        echo '<p align="center">New entry was successfully added to OSRS RuneScape Help.</p>'.NL;
        header('refresh: 2; url='.htmlspecialchars($_SERVER['PHP_SELF']));
    }
}
elseif(isset($_GET['act']) AND (($_GET['act'] == 'edit' AND isset($_GET['id'])) OR $_GET['act'] == 'new')) {
    if($_GET['act'] == 'edit') {
        $id = intval($_GET['id']);
        $info = $db->fetch_row("SELECT * FROM price_scams WHERE id = ".$id);
        if($info) {
            $name = $info['name'];
            $text = $info['text'];
            $img = $info['img'];
            $warn_level = $info['warn_level'];
        }
        else {
            $name = '';
            $text = '';
            $img = 'generic.gif';
            $warn_level = 1;
            $_GET['act'] = 'new';
        }
    }
    else {
        $name = '';
        $text = '';
        $img = 'generic.gif';
        $warn_level = 1;
    }
    echo '<br /><form method="post" action="">'.NL;
    if($_GET['act'] == 'edit') {
        echo '<input type="hidden" name="id" value="'.$id.'" />';
    }
    echo '<input type="hidden" name="act" value="'.$_GET['act'].'" />';
    echo '<table width="90%" align="center" style="border-left: 1px solid #000000" cellspacing="0">'.NL;
    echo '<tr>'.NL;
    echo '<td class="tabletop" colspan="2">General</td>'.NL;
    echo '</td>'.NL;
    echo '<tr><td class="tablebottom" width="50%">Title:</td><td class="tablebottom"><input type="text" name="name" value="'.$name.'" /></td></tr>'.NL;
    echo '<tr><td class="tablebottom" width="50%">Image:</td><td class="tablebottom"><input type="text" name="img" value="'.$img.'" /></td></tr>'.NL;
    echo '<tr><td class="tablebottom" width="50%">Warn Level:</td><td class="tablebottom"><select name="warn_level">';
    for($i = 1; $i <= 5; $i++) {
        if($warn_level == $i) echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
        else echo '<option value="'.$i.'">'.$i.'</option>';
    }
    echo '</select></td></tr>'.NL;
    echo '<td class="tabletop" colspan="2" style="border-top: none;">Scam Description</td>'.NL;
    echo '<tr><td class="tablebottom" colspan="2"><textarea rows="15" name="text" style="width: 99%;">'.htmlentities($text).'</textarea></td></tr>'.NL;
    echo '<tr><td class="tablebottom" colspan="2"><input type="submit" value="Submit All" /></td></tr>'.NL;
    echo '</table>'.NL;
    echo '</form>'.NL;
}
elseif(isset($_GET['act']) AND $_GET['act'] == 'delete' AND $ses->permit(15)) {
    if(isset($_POST['del_id'])) {
        $edit->add_delete($_POST['del_id']);
        $execution = $edit->run_all();
        if(!$execution) {
            echo '<p align="center">'.$edit->error_mess.'</p>';
        }
        else {
            $ses->record_act('Scam Alert', 'Delete', $_POST['del_name'], $ip);
            header('refresh: 2; url='.htmlspecialchars($_SERVER['PHP_SELF']));
            echo '<p align="center">Entry successfully deleted from OSRS RuneScape Help.</p>'.NL;
        }
    }
    else {
        $id = intval($_GET['id']);
        $info = $db->fetch_row("SELECT * FROM price_scams WHERE id = ".$id);
        if($info) {
            $name = $info['name'];
            echo '<p align="center">Are you sure you want to delete the scam \''.$name.'\'';
            echo '<form method="post" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'?act=delete"><center><input type="hidden" name="del_id" value="'.$id.'" / ><input type="hidden" name="del_name" value="'.$name.'" / ><input type="submit" value="Yes" /></center></form>'.NL;
            echo '<form method="post" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'"><center><input type="submit" value="No" /></center></form>'.NL;
        }
        else {
            echo '<p align="center">That identification number does not exist.</p>'.NL;
        }
    }
}
else {
    $query = $db->query("SELECT * FROM price_scams ORDER BY name");
    ?>
    <table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">
    <tr class="boxtop">
    <th class="tabletop">Title:</th>
    <th class="tabletop">Actions:</th>
    <th class="tabletop">Last Edited (GMT):</th>
    </tr>
    <?
    while($info = $db->fetch_array($query)) {
        echo '<tr align="center">'.NL;
        echo '<td class="tablebottom"><a href="/development/price_guide.php?scam='.$info['id'].'" target="_new" title="View Scam">'.$info['name'].'</a></td>'.NL;
        echo '<td class="tablebottom"><a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'?act=edit&id='.$info['id'].'" title="Edit '.$info['name'].'">Edit</a>';
        if($ses->permit(15)) {
            echo ' / <a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'?act=delete&id='.$info['id'].'" title="Delete '.$info['name'].'">Delete</a></td>'.NL;
        }
        echo '<td class="tablebottom">'.format_time($info['time']).'</td>'.NL;
        echo '</tr>'.NL;
    }
    if(mysqli_num_rows($query) == 0) {
        echo '<tr>'.NL;
        echo '<td class="tablebottom" colspan="3">Sorry, no entries match your search criteria.</td>'.NL;
        echo '</tr>'.NL;
    }
    ?>
    </table>
    <?
}
echo '<br /></div>'. NL;
end_page();
?>