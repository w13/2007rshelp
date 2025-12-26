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
<textarea cols="55" rows="6" style="font-family:'Verdana'; font-size:10px;">
<?php
  $query = $db->query("SELECT * FROM `cities` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://www.zybez.net/cities.php?id=' . $info['id'] . NL;
   } 
?>
</textarea>

<br />
<h3>Concepts</h3><br />
<textarea cols="55" rows="6" style="font-family:'Verdana'; font-size:10px;">
<?php
  $query = $db->query("SELECT * FROM `concepts` ORDER BY `type`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://www.zybez.net/concepts.php?type=' . $info['type'] . '&id=' . $info['id'] . NL;
   } 
?>
</textarea>

<br />
<h3>Dungeon Maps</h3><br />
<textarea cols="55" rows="6" style="font-family:'Verdana'; font-size:10px;">
<?php
  $query = $db->query("SELECT * FROM `dungeonmaps` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://www.zybez.net/dungeonmaps.php?id=' . $info['id'] . NL;
   } 
?>
</textarea>

<br />
<h3>Guild Guides</h3><br />
<textarea cols="55" rows="6" style="font-family:'Verdana'; font-size:10px;">
<?php
  $query = $db->query("SELECT * FROM `guilds` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://www.zybez.net/guilds.php?id=' . $info['id'] . NL;
   } 
?>
</textarea>
<br />

<h3>Item Database</h3>
<textarea cols="55" rows="6" style="font-family:'Verdana'; font-size:10px;">
<?php
  $query = $db->query("SELECT * FROM `items`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://www.zybez.net/items.php?id=' . $info['id'] . NL;
   }
?>
</textarea>
<br />

<h3>Mini Game Guides</h3><br />
<textarea cols="55" rows="6" style="font-family:'Verdana'; font-size:10px;">
<?php
  $query = $db->query("SELECT * FROM `minigames` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://www.zybez.net/minigames.php?id=' . $info['id'] . NL;
   } 
?>
</textarea>
<br />
<h3>Mining Maps</h3><br />
<textarea cols="55" rows="6" style="font-family:'Verdana'; font-size:10px;">
<?php
  $query = $db->query("SELECT * FROM `miningmaps` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://www.zybez.net/miningmaps.php?id=' . $info['id'] . NL;
   } 
?>
</textarea>

<br />
<h3>Misc Guides</h3><br />
<textarea cols="55" rows="6" style="font-family:'Verdana'; font-size:10px;">
<?php
  $query = $db->query("SELECT * FROM `misc` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://www.zybez.net/misc.php?id=' . $info['id'] . NL;
   } 
?>
</textarea>

<br />
<h3>Monster Database</h3>
<textarea cols="55" rows="6" style="font-family:'Verdana'; font-size:10px;">
<?php
  $query = $db->query("SELECT * FROM `monsters`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://www.zybez.net/monsters.php?id=' . $info['id'] . NL;
   }
?>
</textarea>

<br />
<h3>Price Scams</h3><br />
<textarea cols="55" rows="6" style="font-family:'Verdana'; font-size:10px;">
<?php
  $query = $db->query("SELECT * FROM `price_scams` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://www.zybez.net/priceguide.php?scam=' . $info['id'] . NL;
   } 
?>
</textarea>
<br />
<h3>Quest Guides</h3><br />
<textarea cols="55" rows="6" style="font-family:'Verdana'; font-size:10px;">
<?php
  $query = $db->query("SELECT * FROM `quests` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://www.zybez.net/quests.php?id=' . $info['id'] . NL;
   } 
?>
</textarea>
<br />
<h3>Shops</h3><br />
<textarea cols="55" rows="6" style="font-family:'Verdana'; font-size:10px;">
<?php
  $query = $db->query("SELECT * FROM `shops` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://www.zybez.net/shops.php?id=' . $info['id'] . NL;
   } 
?>
</textarea>
<br />
<h3>Screenshots</h3><br />
<textarea cols="65" rows="6" style="font-family:'Verdana'; font-size:10px;">
<?php
  $query = $db->query("SELECT * FROM `screenshots` ORDER BY `type`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://www.zybez.net/screenshots.php?type=' . $info['type'] . '&id=' . $info['id'] . NL;
   } 
?>
</textarea>
<br />
<h3>Skill Guides</h3><br />
<textarea cols="55" rows="6" style="font-family:'Verdana'; font-size:10px;">
<?php
  $query = $db->query("SELECT * FROM `skills` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://www.zybez.net/skills.php?id=' . $info['id'] . NL;
   } 
?>
</textarea>
<br />

<h3>Tome Archive</h3><br />
<textarea cols="55" rows="6" style="font-family:'Verdana'; font-size:10px;">
<?php
  $query = $db->query("SELECT * FROM `tomes` ORDER BY `id`");
  while($info = $db->fetch_array($query))
   {
    echo 'http://www.zybez.net/tomes.php?id=' . $info['id'] . NL;
   } 
?>
</textarea>

</div>
<?php
}
?>


<?php
end_page();
?>