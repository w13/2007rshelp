<?php

/* Security For Our Info */
define( 'IN_OSRS_HELP' , TRUE );

/*** SHOP DATABASE ***/
 require(dirname(__FILE__) . '/' . 'backend.php');
 start_page('Shop Database');
?>

<div class="boxtop">Shop Database</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">

<?php
if(!isset($_GET['id']))
 {
?>

<div align="left" style="margin:1">
<b><font size="+1">&raquo; <a href="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>">Shop Database -No Pics-</a></font></b></div>
<hr class="main" noshade="noshade" />

<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">
<tr>
<td class="tabletop">Shops with no map</td>
</tr>
<?php
  $query = $db->query("SELECT * FROM `shops` WHERE image LIKE '%_nomap.png%' ORDER BY `shop_name`");
  while($info = $db->fetch_array($query))
   {
    echo '<tr>';
    echo '<td class="tablebottom"><a href="/shops.php?id=' . $info['id'] . '">' . $info['shop_name'] . '</a></td>';
    echo '</tr>';
   }
  echo '</table><br />';

}
		?>
		
<p style="text-align:center; font-weight: bold;">
<u>Database Copyright Notice</u>:<br />
All Database Information is Copyright &copy; OSRS RuneScape Help, 2001 - 2005, All Rights Reserved.<br /><br />
All images and information submitted to OSRS RuneScape Help become property of OSRS RuneScape Help. Use on any other website is PROHIBITED! Content may only be used on other websites with permission from OSRS RuneScape Help.</p>
</div><br />
<?php
end_page();
?>