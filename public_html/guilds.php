<?php
$cleanArr = array(  array('id', $_GET['id'] ?? null, 'int', 's' => '1,250')
				  );
/*** GUILDS PAGE ***/
require(dirname(__FILE__) . '/' . 'backend.php');
start_page('OSRS RuneScape Guild Guides');
if($disp->errlevel > 0) {
	$id = null;
}
?>
<div class="boxtop">OSRS RuneScape Guild Guides</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<a name="top"></a>
<?php
if(empty($id))
 {
?>
<div style="margin:1pt;font-size:large;font-weight:bold">&raquo; OSRS RuneScape Guild Guides</div>
<hr class="main" noshade="noshade" />
<br />

<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">
 <tr class="boxtop">
<th class="tabletop">Guild Name</th>
<th class="tabletop" width="80">Type</th>
<th class="tabletop" width="40%">Author</th>
<th class="tabletop" width="100">Last Update</th>
 </tr>
<?php
  $query = $db->query("SELECT * FROM `guilds` ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<tr align="center">';
    echo '<td class="tablebottom"><a href="?id=' . $info['id'] . '">' . htmlspecialchars($info['name']) . '</a></td>' . NL;
    echo '<td class="tablebottom">' . htmlspecialchars($info['type']) . '</td>';
    echo '<td class="tablebottom">' . htmlspecialchars($info['author']) . '</td>';
	echo '<td class="tablebottom">'.date('M j, Y', $info['time']).'</td>'.NL;
    echo '</tr>';
   } 
?>
</table>
<br />
<?php
 }
else
 {
  $info = $db->fetch_row("SELECT * FROM `guilds` WHERE `id` = " . $id);
  if (!$info) {
      echo 'Error: Invalid Guild ID.';
  } else {
?>
<div style="font-size:large;font-weight:bold;">
&raquo; <a href="guilds.php">Runescape Guild Guides</a> &raquo; <u><?php echo htmlspecialchars($info['name']); ?></u></div>
<hr class="main" noshade="noshade" />
<table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="5" cellspacing="0">
<?php
  echo '<tr><td style="border-bottom: 1px solid #000; border-right: 1px solid #000" align="center"><a href="/correction.php?area=guilds&amp;id=' . $id . '" title="Submit a Correction"><img src="/img/correct.gif" alt="Submit Correction" border="0" /></a></td></tr>';
  echo '<tr><td style="border-right: 1px solid #000">' . $info['text'];
  echo city_shops($id) .'</div></td></tr>';
  echo '<tr><td style="border-bottom: 1px solid #000; border-right: 1px solid #000;border-top:1px solid #000;">Author: <b>' . htmlspecialchars($info['author']) . '</b></td>';
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
