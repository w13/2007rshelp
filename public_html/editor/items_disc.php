<?php
require( 'backend.php' );
require( 'edit_class.php' );
start_page( 6, 'Notepad');

echo '<div class="boxtop">Item Database Notes and Discussion</div>'.NL;
echo '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px; text-align: center;">'.NL;
$info = $db->fetch_row("SELECT * FROM `admin_pads` WHERE `file` = 'items'");
$last = format_time( $info['time'] + 21600 );;
if( isset( $_POST['text'] ) ) {
    $pad = addslashes( $_POST['text'] );
    $query = $db->query("UPDATE `admin_pads` SET `text` = '".$pad."', `time` = '".time()."' WHERE `file` = 'items'");
    $ses->record_act('Main Page', 'Edit', 'Notepad', $ip);
    header("Location: items_disc.php");
	}

echo '<form action="" method="post">';
echo 'Last Update: ' . $last . ' (GMT)<br />';
echo '<textarea name="text" rows="35" style="width: 95%; font: 10px Verdana, Arial, Helvetica, sans, sans serif;">' . $info['text'] . '</textarea><br />';
echo '<input type="submit" value="Update" />&nbsp;<input type="reset" value="Undo Changes" />';
echo '</form>';
echo '</div>';
end_page();
?>