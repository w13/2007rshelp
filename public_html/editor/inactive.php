<?php
require( 'backend.php' );
start_page(0, 'Register Inactivity' );

$user = $_SESSION['user'];

if(isset($_POST['inactive']))
{
  $msg = strip_tags(addslashes($_POST['inactive']));
  $msg_key = 'I dont know how to get this...';
  $to_id = 119996; //tzu. create a session for their team. if team=mc, tzu else scott.
  $db->query("UPDATE admin SET inactive = '".$msg."' WHERE user ='".$user."'");
  /*$db->query("use community");
  $db->query("INSERT INTO `ibfmessage_text`
            (`msg_date`, `msg_post`, `msg_sent_to_count`, `msg_deleted_count`, `msg_post_key`, `msg_author_id`, `msg_ip_address`)
            VALUES (".time().", '".$msg."', 1, 0, '".$msg_key."', ".$_COOKIE['member_id'].", '".$_SERVER['REMOTE_ADDR']."')");
  $db->query("INSERT INTO `ibfmessage_topics` (`mt_msg_id`, `mt_date`, `mt_title`, `mt_from_id`, `mt_to_id`, `mt_owner_id`, `mt_vid_folder`)
            VALUES (".$db->insert_id().", ".time().", 'Re: Registering Inactivity on Zybez', ".$_COOKIE['member_id'].", ".$to_id.",".$to_id.", 'in')");
*/
  header( 'Location: inactive.php' );
}


$info = $db->fetch_row("SELECT * FROM admin WHERE user = '".$user."'");

echo '<div class="boxtop">Inactivity</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;
?>
<div style="margin:1pt; font-size:large; font-weight:bold;">&raquo; Register Inactivity</div>
<hr noshade="noshade" />
<p>If you are going to be inactive because of school, a holiday, family reasons or work, please give a short description below detailing the start date, what type of inactivity, and anticipated end date of inactivity.</p>
<p>If we find you are very active on RSC while doing absolutely nothing in here, you will be sent a warning message.</p>
<?php
echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post" style="text-align:center;">';
echo '<textarea name="inactive" style="font:10px Verdana; width:50%;height:150px;">'.$info['inactive'].'</textarea>';
echo '<br /><input type="submit" value="Submit" />';
echo '</form>';
echo '</div>';
end_page();
?>