<?php

require( 'backend.php' );

require( 'edit_class.php' );

start_page( 18, 'VIP Message Board');

echo '<div class="boxtop">VIP Message board</div>'.NL;
echo '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px; text-align: center;">'.NL;
  
echo '<p><b>Only Team Managers/Leaders+ have access to post here. Post messages for each other here.</b></p>'.NL;
$info = $db->fetch_row("SELECT * FROM `admin_pads` WHERE `file` = 'vip'");
$last = format_time( $info['time'] + 21600 );;

if( isset( $_POST['text'] ) ) {
    $pad = addslashes( $_POST['text'] );
    $query = $db->query("UPDATE `admin_pads` SET `text` = '".$pad."', `time` = '".time()."' WHERE `file` = 'vip'");
    header("Location: vip.php");
	}

echo '<form action="' . $_SERVER['SCRIPT_NAME'] . '" method="post">';
echo 'Last Update: ' . $last . ' (GMT)<br />';
echo '<textarea name="text" rows="40" style="width: 95%; font: 10px Verdana, Arial, Helvetica, sans, sans serif;">' . $info['text'] . '</textarea><br />';
echo '<input type="submit" value="Update" />&nbsp;<input type="reset" value="Undo Changes" />';
echo '</form>';
echo '</div>';
end_page();
?>