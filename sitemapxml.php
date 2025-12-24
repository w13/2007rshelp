<?php
/*** Sitemap XML ***/
require('backend.php');
start_page();
?>
<zybez>
    <section>
        <name>Main Sections</name>
		<nosub />
        <guide><url><?php=SITE_URL?></url><name>Zybez Runescape Help</name></guide>
        <guide><url><?php=SITE_URL?>community</url><name>Runescape Community</name></guide>
    </section>
    

<section>
	<name>Other</name>
	<guide><url><?php=SITE_URL?>runescapevideos.php</url><name>Runescape Videos</name></guide>
	<guide><url><?php=SITE_URL?>statsgrabber.php</url><name>Runescape Hiscore Histories</name></guide>
	<guide><url><?php=SITE_URL?>clantoplist.php</url><name>Runescape Clan Toplist</name></guide>
	<guide><url><?php=SITE_URL?>screenshots.php</url><name>Runescape Screenshots</name></guide>
	<guide><url><?php=SITE_URL?>blog.php</url><name>Runescape Blogs</name></guide>
	<guide><url><?php=SITE_URL?>irc.php</url><name>Zybez IRC</name></guide>
	<guide><url><?php=SITE_URL?>runescapeventrilo.php</url><name>Zybez Ventrilo</name></guide>
	<guide><url><?php=SITE_URL?>radio.php</url><name>Zybez Radio</name></guide>
	<guide><url><?php=SITE_URL?>concepts.php</url><name>Fan Concepts</name></guide>
	<guide><url><?php=SITE_URL?>links.php</url><name>Link to us</name></guide>
	<guide><url><?php=SITE_URL?>contact.php</url><name>Contact Us</name></guide>
	<guide><url><?php=SITE_URL?>faq.php</url><name>F.A.Q.</name></guide>
</section>

<section>
	<name>Tools</name>
	<guide><url><?php=SITE_URL?>priceguide.php</url><name>Market Price Guide</name></guide>
	<guide><url><?php=SITE_URL?>items.php</url><name>Item Database</name></guide>
	<guide><url><?php=SITE_URL?>monsters.php</url><name>Monster Database</name></guide>
	<guide><url><?php=SITE_URL?>shops.php</url><name>Shop Database</name></guide>
	<guide><url><?php=SITE_URL?>calcs.php</url><name>Calculators</name></guide>
	<guide><url><?php=SITE_URL?>locator.php</url><name>Coordiate Locator</name></guide>
	<guide><url><?php=SITE_URL?>misc.php?id=57</url><name>Treasure Trail Help</name></guide>
	<guide><url><?php=SITE_URL?>tiko.php</url><name>Tiko</name></guide>
	<guide><url><?php=SITE_URL?>swiftkit.php</url><name>Swiftkit</name></guide>
</section>


<section>
	<name>Runescape Skill Guides</name>
<?php
    
  $query = $db->query('SELECT * FROM `skills` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
   $seotitle = strtolower(ereg_replace("[^A-Za-z0-9]", "", $info['name']));
    echo '
	<guide><url>'. SITE_URL . 'skills.php?id=' . $info['id'] . '&amp;runescape_' . $seotitle . '.htm</url><name>' . $info['name'] . '</name></guide>';
   } 
?>
</section>

<section>
	<name>Runescape Quest Guides</name>
<?php
  $query = $db->query('SELECT * FROM `quests` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    $seotitle = strtolower(ereg_replace("[^A-Za-z0-9]", "", $info['name']));
    echo '
	<guide><url>'. SITE_URL . 'quests.php?id=' . $info['id'] . '&amp;runescape_' . $seotitle . '.htm</url><name>' . $info['name'] . '</name></guide>';
   } 
?>
</section>

<section>
<name>Runescape City Guides</name>
<?php
  $query = $db->query('SELECT * FROM `cities` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    $seotitle = strtolower(ereg_replace("[^A-Za-z0-9]", "", $info['name']));
    echo '
	<guide><url>'. SITE_URL . 'cities.php?id=' . $info['id'] . '&amp;runescape_' . $seotitle . '.htm</url><name>'.$info['name'].'</name></guide>';
   } 
?>
</section>

<section>
<name>Runescape Guild Guides</name>
<?php
  $query = $db->query('SELECT * FROM `guilds` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    $seotitle = strtolower(ereg_replace("[^A-Za-z0-9]", "", $info['name']));
    echo '
	<guide><url>'. SITE_URL . 'guilds.php?id=' . $info['id'] . '&amp;runescape_' . $seotitle . '.htm</url><name>' . $info['name'] . '</name></guide>';
   } 
?>
</section>

<section>
<name>Runescape Miscellaneous Guides</name>
<?php
  $query = $db->query('SELECT * FROM `misc` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    $seotitle = strtolower(ereg_replace("[^A-Za-z0-9]", "", $info['name']));
    echo '
	<guide><url>'. SITE_URL . 'misc.php?id=' . $info['id'] . '&amp;runescape_' . $seotitle . '.htm</url><name>' . $info['name'] . '</name></guide>';
   } 
?>
</section>

<section>
<name>Runescape Dungeon Maps</name>
<?php
  $query = $db->query('SELECT * FROM `dungeonmaps` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    $seotitle = strtolower(ereg_replace("[^A-Za-z0-9]", "", $info['name']));
    echo '
	<guide><url>'. SITE_URL . 'dungeonmaps.php?id=' . $info['id'] . '&amp;runescape_' . $seotitle . '.htm</url><name>' . $info['name'] . '</name></guide>';
   } 
?>
</section>

<section>
<name>Runescape Mining Maps</name>
<?php
  $query = $db->query('SELECT * FROM `miningmaps` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    $seotitle = strtolower(ereg_replace("[^A-Za-z0-9]", "", $info['name']));
    echo '
	<guide><url>'. SITE_URL . 'miningmaps.php?id=' . $info['id'] . '&amp;runescape_' . $seotitle . '.htm</url><name>' . $info['name'] . '</name></guide>';
   } 
?>
</section>

<section>
<name>Runescape World Maps</name>

<?php
  $query = $db->query('SELECT * FROM `worldmaps` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    echo '
	<guide><url>'. SITE_URL . 'worldmaps.php?id=' . $info['id'] . '</url><name>' . $info['name'] . '</name></guide>';
   } 
?>
</section>

<section>
        <name>Sister Sites</name>
		<nosub />
        <guide><url><?php=SITE_URL?>mechscape</url><name>Zybez Mechscape Help</name></guide>
        <guide><url>http://www.warcrafthelp.com</url><name>World of Warcraft Help</name></guide>
        <guide><url>http://www.guildwarshelp.com</url><name>Guild Wars Help</name></guide>
</section>

</zybez>
<?php
die();
end_page();
?>