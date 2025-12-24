<?php
require(dirname(__FILE__) . '/' . 'backend.php');
start_page('Runescape Test Guides');


$id = $_GET['id'];
?>
<div class="boxtop">Runescape Test Guides</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<a name="top"></a>
<?php
if(!isset($id))
 {
header('Location: http://www.runescapecommunity.com');
 }
else
 {
  $info = $db->fetch_row("SELECT * FROM `testing` WHERE `id` = " . $id . " LIMIT 1");
?>
<div style="margin:1pt; font-size:large; font-weight:bold;">
&raquo; <a href="testing_area.php">Runescape Test Guides</a> &raquo; <u><?php echo $info['name']; ?></u></div>
<hr class="main" noshade="noshade" />
<table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="5" cellspacing="0">
<?php
  echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">' . $info['text'] . '</td></tr>';
  echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Author: <b>' . $info['author'] . '</b></td>'
?>  
 </tr>
</table>
<br />
<p style="text-align:center; font-weight:bold;"><a href="javascript:history.go(-1)">&lt;-- Go Back</a> | <a href="#top">Top -- ^</a></p>
<br />
<?php
 }
 ?>
</div>
<?php
end_page( $info['name'] );
?>