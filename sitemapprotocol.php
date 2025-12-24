<?php
require('backend.php');

	$db->connect();
	$db->select_db( MYSQL_DB );

echo '<'.'?xml version="1.0" encoding="UTF-8" ?'.'>
	<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
      <url><loc><?php=SITE_URL?></loc></url>
	<url><loc><?php=SITE_URL?>/runescapeventrilo.php</loc></url>
	<url><loc><?php=SITE_URL?>/items.php</loc></url>
	<url><loc><?php=SITE_URL?>/monsters.php</loc></url>
	<url><loc><?php=SITE_URL?>/shops.php</loc></url>
	<url><loc><?php=SITE_URL?>/calcs.php</loc></url>
	<url><loc><?php=SITE_URL?>/locator.php</loc></url>
	<url><loc><?php=SITE_URL?>/misc.php?id=57</loc></url>
';
    
  $query = $db->query('SELECT * FROM `skills` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    echo '
	<url><loc>'. SITE_URL . 'skills.php?id=' . $info['id'] . '</loc></url>';
   } 

  $query = $db->query('SELECT * FROM `quests` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    
    echo '
	<url><loc>'. SITE_URL . 'quests.php?id=' . $info['id'] . '</loc></url>';
   } 

  $query = $db->query('SELECT * FROM `cities` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    
    echo '
	<url><loc>'. SITE_URL . 'cities.php?id=' . $info['id'] . '</loc></url>';
   } 

  $query = $db->query('SELECT * FROM `guilds` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    
    echo '
	<url><loc>'. SITE_URL . 'guilds.php?id=' . $info['id'] . '</loc></url>';
   } 
  $query = $db->query('SELECT * FROM `misc` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    
    echo '
	<url><loc>'. SITE_URL . 'misc.php?id=' . $info['id'] . '</loc></url>';
   } 
  $query = $db->query('SELECT * FROM `dungeonmaps` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    
    echo '
	<url><loc>'. SITE_URL . 'dungeonmaps.php?id=' . $info['id'] . '</loc></url>';
   } 

  $query = $db->query('SELECT * FROM `miningmaps` ORDER BY `name`');
  while($info = $db->fetch_array($query))
   {
    
    echo '
	<url><loc>'. SITE_URL . 'miningmaps.php?id=' . $info['id'] . '</loc></url>';
}
?>

</urlset>
