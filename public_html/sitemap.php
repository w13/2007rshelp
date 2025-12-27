<?php
/*** Sitemap ***/
require('backend.php');
start_page('Sitemap');

?>
<div class="boxtop">OSRS RuneScape Help Sitemap</div>
<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<h3>Main Sections</h3>
<ul>
<li> - <a href="<?php=SITE_URL?>/index.php" title="Runescape Help">Runescape Help (Main Page)</a></li>
<li> - <a href="https://runescapecommunity.com" title="Runescape Community">Runescape Community (Forums)</a></li>
</ul>
<br />
<hr class="main" />
<h3>Tools</h3>
<ul>
<li> - <a href="<?php=SITE_URL?>/items.php" title="Item Database">Item Database</a></li>
<li> - <a href="<?php=SITE_URL?>/monsters.php" title="Monster Database">Monster Database</a></li>
<li> - <a href="<?php=SITE_URL?>/shops.php" title="Shop Database">Shop Database</a></li>
<li> - <a href="<?php=SITE_URL?>/locator.php" title="Coordiate Locator">Coordinate Locator</a></li>
<li> - <a href="<?php=SITE_URL?>/misc.php?id=57" title="Treasure Trail Help">Treasure Trail Help</a></li>
</ul>
<br />
<hr class="main" />
<h3>Runescape Skill Guides</h3>
<ul>
<?php
    
  $query = $db->query('SELECT * FROM `skills` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    echo '<li> - <a href="'. SITE_URL . '/skills.php?id=' . $info['id'] . '" title="'.$info['name'].'">' . $info['name'] . '</a></li>' . NL;
   } 
?>
</ul>
<br />
<hr class="main" />
<h3>Runescape Quest Guides</h3>
<ul>
<?php
  $query = $db->query('SELECT * FROM `quests` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    
    echo '<li> - <a href="'. SITE_URL . '/quests.php?id=' . $info['id'] . '" title="'.$info['name'].'">' . $info['name'] . '</a></li>' . NL;
   } 
?>
</ul>
<br />
<hr class="main" />
<h3>Runescape City Guides</h3>
<ul>
<?php
  $query = $db->query('SELECT * FROM `cities` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    
    echo '<li> - <a href="'. SITE_URL . '/cities.php?id=' . $info['id'] . '" title="'.$info['name'].'">' . $info['name'] . '</a></li>' . NL;
   } 
?>
</ul>
<br />
<hr class="main" />
<h3>Runescape Guild Guides</h3>
<ul>
<?php
  $query = $db->query('SELECT * FROM `guilds` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    
    echo '<li> - <a href="'. SITE_URL . '/guilds.php?id=' . $info['id'] . '" title="'.$info['name'].'">' . $info['name'] . '</a></li>' . NL;
   } 
?>
</ul>
<br />
<hr class="main" />
<h3>Runescape Miscellaneous Guides</h3>
<ul>
<?php
  $query = $db->query('SELECT * FROM `misc` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    
    echo '<li> - <a href="'. SITE_URL . '/misc.php?id=' . $info['id'] . '" title="'.$info['name'].'">' . $info['name'] . '</a></li>' . NL;
   } 
?>
</ul>
<br />
<hr class="main" />
<h3>Runescape Dungeon Maps</h3>
<ul>
<?php
  $query = $db->query('SELECT * FROM `dungeonmaps` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    
    echo '<li> - <a href="'. SITE_URL . '/dungeonmaps.php?id=' . $info['id'] . '" title="'.$info['name'].'">' . $info['name'] . '</a></li>' . NL;
   } 
?>
</ul>
<br />
<hr class="main" />
<h3>Runescape Mining Maps</h3>
<ul>
<?php
  $query = $db->query('SELECT * FROM `miningmaps` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    
    echo '<li> - <a href="'. SITE_URL . '/miningmaps.php?id=' . $info['id'] . '" title="'.$info['name'].'">' . $info['name'] . '</a></li>' . NL;
   } 
?>
</ul>
<br />
<?php/*<hr class="main" />
<h3>Runescape World Maps</h3>
<ul>
<?php
  $query = $db->query('SELECT * FROM `worldmaps` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    echo '<li> - <a href="'. SITE_URL . 'worldmaps.php?id=' . $info['id'] . '" title="' . $info['name'] . '">' . $info['name'] . '</a></li>' . NL;
   } 
?>
</ul>
<br />*/?>
</div>
<?php
end_page();
?>
