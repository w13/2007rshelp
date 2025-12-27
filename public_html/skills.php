<?php
$cleanArr = array(  array('id', $_GET['id'] ?? null, 'int', 's' => '1,50')
				  );
/*** SKILLS PAGE ***/
require(dirname(__FILE__) . '/' . 'backend.php');
start_page('OSRS RuneScape Skill Guides');
if($disp->errlevel > 0) {
	unset($id);
}
?>
<div class="boxtop">Old-School RuneScape Skill Guides</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<a name="top"></a>
<?php
if(!isset($id))
 {
?>
<div style="margin:1pt; font-size:large; font-weight:bold;">&raquo; Runescape Skill Guides</div>
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
  $query = $db->query("SELECT * FROM `skills` ORDER BY `name` LIMIT 100");
  
  $listofskills = '';
  
  while($info = $db->fetch_array($query))
   {
    $listofskills .= '<tr align="center">';
    $listofskills .= '<td class="tablebottom"><a href="?id=' . $info['id'] . '">' . htmlspecialchars($info['name']) . '</a></td>' . NL;
    $listofskills .= '<td class="tablebottom">' . htmlspecialchars($info['type']) . '</td>' . NL;
    $listofskills .= '<td class="tablebottom">' . htmlspecialchars($info['author']) . '</td>' . NL;
	$listofskills .= '<td class="tablebottom">'.date('M j, Y', $info['time']).'</td>'.NL;
    $listofskills .= '</tr>';
   }
   
   echo $listofskills;
?>
</table><br />

<?php
if (file_exists('img/skillimg/xp-table.txt')) {
    include('img/skillimg/xp-table.txt');
}
 }
else
 {
  $info = $db->fetch_row("SELECT * FROM `skills` WHERE `id` = " . $id . " LIMIT 1");
  if (!$info) {
      echo 'Error: Invalid Skill Guide ID.';
  } else {
?>
<div style="margin:1pt; font-size:large; font-weight:bold;">
&raquo; <a href="skills.php">Runescape Skill Guides</a> &raquo; <u><?php echo htmlspecialchars($info['name']); ?></u></div>
<hr class="main" noshade="noshade" />
<table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="5" cellspacing="0">
<?php
  echo '<tr><td class="tablebottom"><a href="/correction.php?area=skills&amp;id=' . $id . '" title="Submit a Correction"><img src="/img/correct.gif" alt="Submit Correction" border="0" /></a></td></tr>';
  echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">' . $info['text'] . '</td></tr>';
  echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Author: <b>' . htmlspecialchars($info['author']) . '</b></td>';
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