<?php
include('backend.php');
start_page('Runescape Stats Tracker Competition');

// mysql_connect("localhost", "rsc", "heyplants44") or die(mysql_error());
//mysql_select_db("rsc_site") or die(mysql_error());

?>
<div class="boxtop">Runescape Tracker</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<center> <table cellspacing="0" style="border-left: 1px solid #000000">
<tr> </tr>
<tr><th class='tabletop'>RS Name</th><th class='tabletop'>Gained EXP</th></tr>
<?php
$result = $db->query("SELECT * FROM bonusexp ORDER BY rsname");  

while($row = $db->fetch_array($result))
  {
  $gainn = ($row['startexp'] - $row['endexp']);
    echo "<tr><td class='tablebottom'>". $row['rsname'] . "</a></td><td class='tablebottom'> " . number_format($gainn) . "</td></tr>";
  }
  
echo '</table></center></div>';

end_page();
?>