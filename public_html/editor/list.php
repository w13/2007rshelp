<?php
require(dirname(__FILE__) . '/' . 'backend.php');
start_page('Test');
if(!isset($_GET['id']))
 {
?>
<div class="boxtop">xHTML Maintenance</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<div align="left" style="margin:1">
<b><font size="+1">&raquo; Guide List</font></b>
</div>
<hr class="main" noshade="noshade" /><br />

<h3>City Guides</h3><br />
<?php
  $query = $db->query("SELECT * FROM `cities` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://2007rshelp.com/cities.php?id=' . $info['id'] . '<br />';
   } 
?>

<br />
<h3>Concepts</h3><br />
<?php
  $query = $db->query("SELECT * FROM `concepts` ORDER BY `type`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://2007rshelp.com/concepts.php?type=' . $info['type'] . '&id=' . $info['id'] . '<br />';
   } 
?>


<br />
<h3>Dungeon Maps</h3><br />
<?php
  $query = $db->query("SELECT * FROM `dungeonmaps` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://2007rshelp.com/dungeonmaps.php?id=' . $info['id'] . '<br />';
   } 
?>

<br />
<h3>Guild Guides</h3><br />
<?php
  $query = $db->query("SELECT * FROM `guilds` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://2007rshelp.com/guilds.php?id=' . $info['id'] . '<br />';
   } 
?>
<br />
<h3>Library</h3><br />
<?php
  $query = $db->query("SELECT * FROM `library` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://2007rshelp.com/tomes.php?id=' . $info['id'] . '<br />';
   } 
?>

<br />
<h3>Mini Game Guides</h3><br />
<?php
  $query = $db->query("SELECT * FROM `minigames` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://2007rshelp.com/minigames.php?id=' . $info['id'] . '<br />';
   } 
?>

<br />
<h3>Mining Maps</h3><br />
<?php
  $query = $db->query("SELECT * FROM `miningmaps` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://2007rshelp.com/miningmaps.php?id=' . $info['id'] . '<br />';
   } 
?>

<br />
<h3>Misc Guides</h3><br />
<?php
  $query = $db->query("SELECT * FROM `misc` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://2007rshelp.com/misc.php?id=' . $info['id'] . '<br />';
   } 
?>

<br />
<h3>Price Scams</h3><br />
<?php
  $query = $db->query("SELECT * FROM `price_scams` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://2007rshelp.com/priceguide.php?scam=' . $info['id'] . '<br />';
   } 
?>

<br />
<h3>Quest Guides</h3><br />
<?php
  $query = $db->query("SELECT * FROM `quests` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://2007rshelp.com/quests.php?id=' . $info['id'] . '<br />';
   } 
?>

<br /><br>
<h3>Shops</h3><br />
<?php
  $query = $db->query("SELECT * FROM `shops` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://2007rshelp.com/shops.php?id=' . $info['id'] . '<br />';
   } 
?>

<br />
<h3>Screenshots</h3><br />
<?php
  $query = $db->query("SELECT * FROM `screenshots` ORDER BY `type`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://2007rshelp.com/screenshots.php?type=' . $info['type'] . '&id=' . $info['id'] . '<br />';
   } 
?>

<br />
<h3>Skill Guides</h3><br />
<?php
  $query = $db->query("SELECT * FROM `skills` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://2007rshelp.com/skills.php?id=' . $info['id'] . '<br />';
   } 
?>

<!--<br />
<h3>World maps</h3><br />
<?php/*
  $query = $db->query("SELECT * FROM `worldmaps` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://2007rshelp.com/worldmaps.php?id=' . $info['id'] . '<br />';
   } */
?>--><br />
</div>
<?php
}
?>


<?php
end_page();
?>