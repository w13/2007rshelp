<?php
require( 'backend.php' );
start_page(0, 'Home');

echo '<iframe src="actions.php?nextcache='.$_SESSION['userid'].'" style="display:none;"></iframe>';
echo '<p class="notice" style="margin-bottom:10px">Familiarise yourself with your <em>job description</em> and <a href="intro.php"><em>what we do here</em></a> before starting anything.<br />'
    .'<b># 1:</b> Update Guides with new Game Updates ASAP.<br />'
    .'<b># 2:</b> Work on the To Do Lists, <a href="monsters_queries.php">Monster database</a> and <a href="items_queries.php">Item database</a>.<br />'
    .'<b># 3:</b> Fix Corrections &amp; work on Test Area guides.</p>';

echo '<div class="boxtop">Notepad</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px; text-align: center;">';

$info = $db->fetch_row("SELECT * FROM `admin_pads` WHERE `file` = 'index'");
$last = format_time( $info['time'] + 21600 );
if( isset( $_POST['text'] ) ) {
    $pad = addslashes( $_POST['text'] );
    $query = $db->query("UPDATE `admin_pads` SET `text` = '".$pad."', `time` = '".time()."' WHERE `file` = 'index'");
    $ses->record_act('Main Page', 'Edit', 'Notepad', $ip);
    header("Location: index.php");
	}

echo '<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="post">';
echo 'Last Update: ' . $last . ' (GMT)<br />';
echo '<textarea name="text" rows="25" style="width: 95%; font: 10px Verdana, Arial, Helvetica, sans, sans serif;">' . $info['text'] . '</textarea><br />';
echo '<input type="submit" value="Update" />&nbsp;<input type="reset" value="Undo Changes" />';
echo '</form>';
echo '</div>';

end_page($name);
?>