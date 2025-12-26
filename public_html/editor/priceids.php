<?php

/* Security For Our Info */
define( 'IN_ZYBEZ' , TRUE );

/*** ITEM DATABASE ***/
 require(dirname(__FILE__) . '/' . 'backend.php');
 start_page(6, 'Item Database Queries');
?>

<div class="boxtop">Item Database</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">

<div align="left" style="margin:1">
<b><font size="+1">&raquo; <a href="<?php echo $_SERVER['PHP_SELF']; ?>">Item Database</a></font></b></div>
<hr class="main" noshade="noshade" />
<br />

<span style="font-variant:small-caps; font-size: 14px;">Price IDs:</span><br />

<table>
<?php
  $query = $db->query("SELECT id, name FROM `price_items` ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<tr><td>' . $info['name'] . '</td><td>'.$info['id'].'</td></tr>';
   }
  echo '</table><br />';

		?>
				
<p style="text-align:center; font-weight: bold;">
<u>Database Copyright Notice</u>:<br />
All Database Information is Copyright &copy; Zybez, 2001 - 2005, All Rights Reserved.<br /><br />
All images and information submitted to Zybez become property of Zybez. Use on any other website is PROHIBITED! Content may only be used on other websites with permission from Zybez.
</p>
</div><br />
<?php
end_page();
?>