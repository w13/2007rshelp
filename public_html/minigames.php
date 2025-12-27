<?php
$cleanArr = array(  array('id', $_GET['id'] ?? null, 'int', 's' => '1,50')
				  );
/*** MINIGAMES PAGE ***/
require(dirname(__FILE__) . '/' . 'backend.php');
start_page('OSRS RuneScape Mini Game Guides');
if($disp->errlevel > 0) {
	unset($id);
}
?>
<div class="boxtop">RuneScape Mini Game Guides</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<a name="top"></a>
<?php
if(!isset($id))
 {
?>
<div style="margin:1pt; font-size:large; font-weight:bold;">&raquo; Runescape Mini Game Guides</div>
<hr class="main" noshade="noshade" />
<br />
<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">
<tr class="boxtop">
<th class="tabletop">Name</th>
<th class="tabletop" width="80">Type</th>
<th class="tabletop" width="40%">Author</th>
<th class="tabletop" width="100">Last Update</th>
</tr>
<?php
  $query = $db->query("SELECT * FROM `minigames` ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<tr align="center">';
    echo '<td class="tablebottom"><a href="?id=' . $info['id'] . '">' . $info['name'] . '</a></td>' . NL;
    echo '<td class="tablebottom">' . $info['type'] . '</td>' . NL;
    echo '<td class="tablebottom">' . $info['author'] . '</td>' . NL;
	echo '<td class="tablebottom">'.date('M j, Y', $info['time']).'</td>'.NL;
    echo '</tr>';
   } 
?>
</table><br />

<?php
 }
else
 {
  $info = $db->fetch_row("SELECT * FROM `minigames` WHERE `id` = " . $id);
  if (!$info) {
      echo 'Error: Invalid Minigame ID.';
  } else {
?>
<div style="margin:1pt; font-size:large; font-weight:bold;">
&raquo; <a href="minigames.php">Runescape Mini Game Guides</a> &raquo; <u><?php echo $info['name'];?></u></div>
<hr class="main" noshade="noshade" />
<table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="5" cellspacing="0">
<?php
  echo '<tr><td class="tablebottom"><a href="/correction.php?area=minigames&amp;id=' . $id . '" title="Submit a Correction"><img src="/img/correct.gif" alt="Submit Correction" border="0" /></a></td></tr>';
  echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">' . $info['text'] . '</td></tr>';
  echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Author: <b>' . $info['author'] . '</b></td>';
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
end_page( $info['name'] ?? '' );
?>
