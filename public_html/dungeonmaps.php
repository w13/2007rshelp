<?php
$cleanArr = array(  array('id', $_GET['id'] ?? null, 'int', 's' => '1,250')
				  );
/*** MAP PAGE ***/
require(dirname(__FILE__) . '/' . 'backend.php');
start_page('OSRS RuneScape Dungeon Maps');
if($disp->errlevel > 0) {
	unset($id);
}
?>
<div class="boxtop">OSRS RuneScape Dungeon Maps</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<a name="top"></a>
<?php
if(!isset($id))
 {
?>
<div style="margin:1pt; font-size:large; font-weight:bold;">&raquo; OSRS RuneScape Dungeon Maps</div>
<hr class="main" noshade="noshade" />
<br />
<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">
 <tr class="boxtop">
  <th class="tabletop">Map Name:</th>
  <th class="tabletop">Type:</th>
  <th class="tabletop">Mapped By:</th>
 </tr>
<?php
  $query = $db->query("SELECT * FROM `dungeonmaps` ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<tr align="center">';
    echo '<td class="tablebottom"><a href="?id=' . $info['id'] . '">' . htmlspecialchars($info['name']) . '</a></td>';
    echo '<td class="tablebottom">' . htmlspecialchars($info['type']) . '</td>';
    echo '<td class="tablebottom">' . htmlspecialchars($info['author']) . '</td>';
    echo '</tr>';
   } 
?>
</table>
<br />
<?php
 }
else
 {
  $info = $db->fetch_row("SELECT * FROM `dungeonmaps` WHERE `id` = " . $id);
  if (!$info) {
      echo 'Error: Invalid Map ID.';
  } else {
?>
<div style="margin:1pt; font-size:large; font-weight:bold;">
&raquo; <a href="dungeonmaps.php">Runescape Dungeon Maps</a> &raquo; <u><?php echo htmlspecialchars($info['name']);?></u></div>
<hr class="main" noshade="noshade" />
<table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="5" cellspacing="0">
<?php
  echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center"><a href="/correction.php?area=dungeonmaps&amp;id=' . $id . '" title="Submit a Correction"><img src="/img/correct.gif" alt="Submit Correction" border="0" /></a></td></tr>';
  echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">' . $info['text'] . '</td></tr>';
  echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Mapped By: <b>' . htmlspecialchars($info['author']) . '</b></td>';
?>  
 </tr>
</table>
<br />
<p style="text-align:center; font-weight:bold;"><a href="javascript:history.go(-1)">&lt;-- Go Back</a> | <a href="#top">Top -- ^</a></p>
<br />
<?php
  }
 }
 ?>
[#COPYRIGHT#]
</div>
<?php
end_page( htmlspecialchars($info['name'] ?? '') );
?>
