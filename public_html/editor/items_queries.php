<?php

/* Security For Our Info */
define( 'IN_OSRS_HELP' , TRUE );

/*** ITEM DATABASE ***/
 require(dirname(__FILE__) . '/' . 'backend.php');
 start_page(6, 'Item Database Queries');
?>
<script language="JavaScript">
function hide(i)
{
   var el = document.getElementById(i)
   if (el.style.display=="none")
   {
      el.style.display="block";
   }
   else
   {
      el.style.display="none";
   }
}
</script>

<div class="boxtop">Item Database</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">

<div align="left" style="margin:1">
<b><font size="+1">&raquo; <a href="<?php echo $_SERVER['PHP_SELF']; ?>">Item Database</a></font></b></div>
<hr class="main" noshade="noshade" />
<p>Click to expand lists.</p>

<a href="#" onclick=hide('tohide1')><span style="font-variant:small-caps; font-size: 14px;">Items needing a picture:</span></a><br />
<div id="tohide1" style="display:none">
<ol>
<?php
  $query = $db->query("SELECT * FROM `items` WHERE image = 'nopic.gif' AND type IN (1, 2, 3) ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<li><a href="/editor/items.php?act=edit&amp;id='.$info['id'].'" target="_blank">' . $info['name'] . '</a> (<i>' . $info['examine'] . '</i>)</li>';
    echo '<td class="tablebottom"></td>';
   }
  echo '</ol><br /></div>';

		?>

<!---		<a href="#" onclick=hide('tohide2')><span style="font-variant:small-caps; font-size: 14px;">Tradable, no price id:</span></a><br />
<div id="tohide2" style="display:none">
<ol>
<?php
 /* $query = $db->query("SELECT * FROM `items` WHERE trade = 1 AND pid =0 AND type IN (1, 2, 3) ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<li><a href="/editor/items.php?act=edit&amp;id='.$info['id'].'" target="_blank">' . $info['name'] . '</a> (<i>' . $info['examine'] . '</i>)</li>';
    echo '<td class="tablebottom"></td>';
   }
  echo '</ol><br /></div>';
*/
		?>
			-->
<a href="#" onclick=hide('tohide3')><span style="font-variant:small-caps; font-size: 14px;">Items needing an examine:</span></a><br />
<div id="tohide3" style="display:none">
<ol>
<?php
  $query = $db->query("SELECT * FROM `items` WHERE (examine = '' OR examine = '-' or examine = '?') AND type IN (1,2,3) ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<li><a href="/editor/items.php?act=edit&amp;id='.$info['id'].'" target="_blank">' . $info['name'] . '</a></li>';
   }
  echo '</ol><br /></div>';
		?>

<a href="#" onclick=hide('tohide4')><span style="font-variant:small-caps; font-size: 14px;">Check Quests:</span></a><br />
<div id="tohide4" style="display:none">
<table>
<?php
  $query = $db->query("SELECT id, name, quest FROM `items` WHERE `quest` != 'No' AND `quest` NOT IN (SELECT name FROM quests) AND id NOT IN (139, 5075) AND type IN (1,2,3) ORDER BY `quest`");
  while($info = $db->fetch_array($query))
   {
    echo '<tr><td><a href="/editor/items.php?act=edit&amp;id='.$info['id'].'" target="_blank">' . $info['name'] . '</a></td><td>'.$info['quest'].'</td></tr>';
   }
  echo '</table><br /></div>';

		?>
		
<a href="#" onclick=hide('tohide5')><span style="font-variant:small-caps; font-size: 14px;">Credits to fix (replace , with ;):</span></a><br />
<div id="tohide5" style="display:none">
<ol>
<?php
  $query = $db->query("SELECT * FROM `items` WHERE `credits` LIKE '%,%' ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<li><a href="/editor/items.php?act=edit&amp;id='.$info['id'].'" target="_blank">' . $info['name'] . '</a></li>';
   }
  echo '</ol><br /></div>';
		?>

<a href="#" onclick=hide('tohide6')><span style="font-variant:small-caps; font-size: 14px;">Are these really tradable quest items?</span></a><br />
<div id="tohide6" style="display:none">
<ol>
<?php
  $query = $db->query("SELECT * FROM `items` WHERE `type` = 2 AND `trade` = 'Yes' and `id` NOT IN (418,131,1600,782,783,784,785,119,849) ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<li><a href="/editor/items.php?act=edit&amp;id='.$info['id'].'" target="_blank">' . $info['name'] . '</a></li>';
   }
  echo '</ol><br /></div>';
		?>
		
<a href="#" onclick=hide('tohide7')><span style="font-variant:small-caps; font-size: 14px;">May need animated image:</span></a><br />
<div id="tohide7" style="display:none">
<ol>
<?php
  $query = $db->query("SELECT * FROM `items` WHERE `stack` = 1 AND `image` NOT LIKE '%.gif' ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<li><a href="/items.php?id='.$info['id'].'" target="_blank">' . $info['name'] . '</a></li>';
   }
  echo '</ol><br /></div>';
		?>
		
<a href="#" onclick=hide('tohide8')><span style="font-variant:small-caps; font-size: 14px;">Weapons without speed:</span></a><br />
<div id="tohide8" style="display:none">
<ol>
<?php
  $query = $db->query("SELECT * FROM `items` WHERE `equip_type`=4 AND `speed`=0 AND `type`!=0 ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<li><a href="/editor/items.php?act=edit&amp;id='.$info['id'].'" target="_blank">' . $info['name'] . '</a></li>';
   }
  echo '</ol><br /></div>';

		?>

<a href="#" onclick=hide('tohide9')><span style="font-variant:small-caps; font-size: 14px;">Weights to check:</span></a><br />
<div id="tohide9" style="display:none">
<ol>
<?php
  $query = $db->query("SELECT * FROM `items` WHERE `weight` = 1 or `weight` = -21 ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<li><a href="/editor/items.php?act=edit&amp;id='.$info['id'].'" target="_blank">' . $info['name'] . '</a></li>';
   }
  echo '</ol><br /></div>';
  echo '</div>';
  
  end_page();
?>