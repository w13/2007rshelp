<?php
$cleanArr = array(  array('id', $_GET['id'], 'int', 's' => '1,250')
				  );
/*** QUEST PAGE ***/
require(dirname(__FILE__) . '/' . 'backend.php');
start_page('OSRS RuneScape Mining Maps');
if($disp->errlevel > 0) {
	unset($id);
}
?>
<div class="boxtop">OSRS RuneScape Mining Maps</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<a name="top"></a>
<?php
if(!isset($id))
 {
?>
<div style="margin:1pt; font-size:large; font-weight:bold;">&raquo; Runescape Mining Maps</div>
<hr class="main" noshade="noshade" />
<br />
<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">
 <tr class="boxtop">
  <th class="tabletop">Map Name:</th>
  <th class="tabletop">Type:</th>
  <th class="tabletop">Mapped By:</th>
 </tr>
<?php
  $query = $db->query("SELECT * FROM `miningmaps` ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<tr align="center">';
	echo '<td class="tablebottom"><a href="?id=' . $info['id'] . '">' . $info['name'] . '</a></td>' . NL;
    echo '<td class="tablebottom">' . $info['type'] . '</td>' . NL;
    echo '<td class="tablebottom">' . $info['author'] . '</td>' . NL;
    echo '</tr>';
   } 
?>
</table>
<br />
<?php
 }
else
 {
  $info = $db->fetch_row("SELECT * FROM `miningmaps` WHERE `id` = " . $id);
?>
<div style="margin:1pt; font-size:large; font-weight:bold;">
&raquo; <a href="miningmaps.php">OSRS RuneScape Mining Maps</a> &raquo; <u><?php echo $info['name']; ?></u></div>
<hr class="main" noshade="noshade" />
<table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="5" cellspacing="0">
<?php
  echo '<tr><td class="tablebottom"><a href="/correction.php?area=miningmaps&amp;id=' . $id . '" title="Submit a Correction"><img src="/img/correct.gif" alt="Submit Correction" border="0" /></a></td></tr>' . NL;
  echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">' . $info['text'] . '</td></tr>' . NL;
  echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Mapped By: <b>' . $info['author'] . '</b></td>' . NL;
?>  
 </tr>
</table>
<br />
<p style="text-align:center; font-weight:bold;"><a href="javascript:history.go(-1)">&lt;-- Go Back</a> | <a href="#top">Top -- ^</a></p>
<br />
<?php
 }
 ?>
[#COPYRIGHT#]
</div>
<?php
end_page( $info['name'] );
?>