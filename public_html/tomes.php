<?php
$cleanArr = array(  array('id', $_GET['id'] ?? null, 'int', 's' => '1,500')
				  );
/*** LIBRARY ***/
require(dirname(__FILE__) . '/' . 'backend.php');
start_page('OSRS RuneScape Tome Archive');
if($disp->errlevel > 0) {
	$id = null;
}
?>
<div class="boxtop">OSRS RuneScape Tome Archive</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<a name="top"></a>
<?php
if(empty($id))
 {
?>
<div style="margin:1pt; font-size:large; font-weight:bold;">&raquo; OSRS Tome Archive</div>
<hr class="main" noshade="noshade" />
<br />

<p style="text-align: center;">Welcome to OSRS RuneScape Help's Tome Archive. You might be wondering what exactly is meant by "Tome Archive". Well, it is basically a collection of RuneScape's literature; from books to manuals to manuscripts to decrepit tomes found during quests. Every piece of literature available in RuneScape is contained within this archive. Happy reading!</p>


<center><div style="width: 600px; margin: 0; background-repeat: repeat-y;">
<img style="position: relative; top: 25px; padding:0; margin: 0; z-index: 100; display: block;" src="/img/other/lib/menut.gif" alt="" width="612" height="50" />
<div style="background-image: url(/img/other/lib/menuc.gif); width:600px; position: relative; margin: 0 -5px; background-repeat: repeat-y;">
<br /><br /><br />
<table border="0" width="575px" cellspacing="5" cellpadding="5" align="center">
<tr>
<td><span style="font-family:'Harrington'; font-size: 15px; color:black;">Book Title:</span></td>
<td><span style="font-family:'Harrington'; font-size: 15px; color:black;">Entered by:</span></td>
<td><span style="font-family:'Harrington'; font-size: 15px; color:black;">Item Name:</span></td></tr>
<?php
   
     $query = $db->query("SELECT * FROM `tomes` ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<tr>' . NL;
    echo '<td><a href="?id=' . $info['id'] . '"><span style="color: black;">' . htmlspecialchars($info['name']) . '</span></a></td>' . NL;
    echo '<td style="color: black;">' . htmlspecialchars($info['author']) . '</td>' . NL;
    echo '<td style="color: black;">' . htmlspecialchars($info['item']) . '</td></tr>' . NL;
   }
?>
</table>
<br /><br />
</div><img style="padding: 0; position: relative; margin: 0; top: -25px; z-index: 100; display: block;" src="/img/other/lib/menub.gif" alt="" width="612" 

height="50" />
</div></center>
<?php
 }
else
 {
  $info = $db->fetch_row("SELECT * FROM `tomes` WHERE `id` = " . $id);
  if (!$info) {
      echo 'Error: Invalid Tome ID.';
  } else {
?>
<div style="margin:1pt; font-size:large; font-weight:bold;">
&raquo; <a href="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>">OSRS Tome Archive</a> &raquo; <u><?php echo htmlspecialchars($info['name']); ?></u></div>
<hr class="main" noshade="noshade" />
<center><div style="width: 600px; margin: 0; background-repeat: repeat-y;">
<img style="position: relative; top: 25px; padding:0; margin: 0; z-index: 100; display: block;" src="/img/other/lib/menut.gif" alt="" width="612" height="50" />
<div style="background-image: url(/img/other/lib/menuc.gif); width:600px; position: relative; margin: 0 -5px; background-repeat: repeat-y;">
<br /><br /><br />
<table border="0" width="575px" cellspacing="0" cellpadding="5" align="center">
<?php
  echo '<tr><td colspan="2" style="border-bottom: 1px solid #000000;" align="center"><a href="/correction.php?area=tomes&amp;id=' . $id . '" title="Submit a Correction"><img src="/img/correct.gif" alt="Submit Correction" border="0" /></a><br /><br /></td></tr>';
  echo '<tr><td colspan="2" style="font-family:\'Trebuchet MS\'; color: black; font-size:12px;">' . $info['content'] . '</td></tr>';
  echo '<tr><td style="border-top: 1px solid #000000; color: black; font-family:\'Trebuchet MS\'; font-size:12px;">Item Name: <b>' . htmlspecialchars($info['item']) . '</b></td>';
  echo '<td rowspan="2" style="border-top: 1px solid #000000; color: black; font-family:\'Trebuchet MS\'; font-size:12px;"><img src="/img/other/lib/' . htmlspecialchars($info['img']) . '" alt="OSRS RuneScape Help\'s Book Image" height="50" width="50" /></td></tr>';
  echo '<tr><td style="color:black; font-family:\'Trebuchet MS\'; font-size:12px;">Author: <b>' . htmlspecialchars($info['author']) . '</b></td>';
?>  
 </tr>
</table>
<br /><br />
</div><img style="padding: 0; position: relative; margin: 0; top: -25px; z-index: 100; display: block;" src="/img/other/lib/menub.gif" alt="" width="612" height="50" />
</div></center>
<br />
<p style="text-align:center; font-weight:bold;"><a href="javascript:history.go(-1)">&lt;-- Go Back</a> | <a href="#top">Top -- ^</a></p>
<br />
<?php
  }
 }
?>
[#COPYRIGHT#]</div>
<?php
end_page( htmlspecialchars($info['name'] ?? '') );
?>