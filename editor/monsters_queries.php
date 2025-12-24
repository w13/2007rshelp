<?php

/* Security For Our Info */
define( 'IN_ZYBEZ' , TRUE );

/*** MONSTER DATABASE ***/
 require(dirname(__FILE__) . '/' . 'backend.php');
 start_page('Monster Database');
?>

<div class="boxtop">Monster Database</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
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

<?php
if(!isset($_GET['id']))
 {
?>

<div align="left" style="margin:1">
<b><font size="+1">&raquo; <a href="">Monster Database</a></font></b></div>
<hr class="main" noshade="noshade" />
<p>Click to expand lists.</p>

<a href="#" onclick=hide('tohide6')><span style="font-variant:small-caps; font-size: 14px;">Check Quests [IMPORTANT]:</span></a><br />

<div id="tohide6" style="display:none">
<table>
<?php
  $query = $db->query("SELECT id, name, quest FROM `monsters` WHERE `quest` != 'No' AND `quest`  NOT IN (SELECT name FROM quests) ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<tr><td><a href="/editor/monsters.php?act=edit&amp;id='.$info['id'].'" target="_blank">' . $info['name'] . '</a></td><td>'.$info['quest'].'</td></tr>';
   }
  echo '</table><br /></div>';

		?>
		
<a href="#" onclick=hide('tohide8')><span style="font-variant:small-caps; font-size: 14px;">Check entries with same names (make sure they aren't duplicates):</span></a><br />

<div id="tohide8" style="display:none">
<table>
<tr>
<td><b>Name</b></td><td><b># entries with this name</b></td></tr>
<?php
  $query = $db->query("SELECT Count(*) AS numextras, name FROM monsters Where name = name GROUP BY name HAVING count(*) > 1 ORDER BY 1 DESC");
  while($info = $db->fetch_array($query))
   {
    echo '<tr><td><a href="/editor/monsters.php?search_area=name&amp;search_term='.$info['name'].'" target="_blank">' . $info['name'] . '</a></td><td>'.$info['numextras'].'</td></tr>';
   }
  echo '</table><br /></div>';

		?>
		
<a href="#" onclick=hide('tohide7')><span style="font-variant:small-caps; font-size: 14px;">Fix Drops [IMPORTANT]:</span></a><br />
<div id="tohide7" style="display:none">
<ol>
<?php
  $query = $db->query("SELECT * FROM `monsters` WHERE id NOT IN (52,145,249,92) AND ((`drops` LIKE '%;%' OR `i_drops` LIKE '%;%') OR (`drops` LIKE '%lvl%' OR `i_drops` LIKE '%lvl%') OR (`drops` LIKE '%level %' OR `i_drops` LIKE '%level %') OR (`drops` LIKE '%-noted%' OR `i_drops` LIKE '%-noted%') OR (`drops` LIKE '%noted)%' OR `i_drops` LIKE '%noted)%') OR (`drops` LIKE '%scimm%' OR `i_drops` LIKE '%scimm%') OR (`drops` LIKE '% p %' OR `i_drops` LIKE '% p %') OR (`drops` LIKE '% plate,%' OR `i_drops` LIKE '% plate,%') OR (`drops` LIKE '%uncut,%' OR `i_drops` LIKE '%uncut,%') OR (`drops` LIKE '%mail%' OR `i_drops` LIKE '%mail%') OR (`drops` LIKE '%square%' OR `i_drops` LIKE '%square%') OR (`drops` LIKE '% axe%' OR `i_drops` LIKE '% axe%') OR (`drops` LIKE '%medium%' OR `i_drops` LIKE '%medium%') OR (`drops` LIKE '%half key%' OR `i_drops` LIKE '%half key%') OR (`drops` LIKE '%half a key%' OR `i_drops` LIKE '%half a key%') OR (`drops` LIKE '%dragon left%' OR `i_drops` LIKE '%dragon left%') OR (`drops` LIKE '%half a shield%' OR `i_drops` LIKE '%half a shield%') OR (`drops` LIKE '%2-h%' OR `i_drops` LIKE '%2-h%') OR (`drops` LIKE '%two%' OR `i_drops` LIKE '%two') OR (`drops` LIKE '%hander%' OR `i_drops` LIKE '%hander%') OR (`drops` LIKE '%kite,%' OR `i_drops` LIKE '%kite,%') OR (`drops` LIKE '%mith %' OR `i_drops` LIKE '%mith %') OR (`drops` LIKE '%2h,%' OR `i_drops` LIKE '%2h,%') OR (`drops` LIKE '%rune bar%' OR `i_drops` LIKE '%rune bar%') OR (`drops` LIKE '%ives,%' OR `i_drops` LIKE '%ives,%') OR (`drops` LIKE '%square,%' OR `i_drops` LIKE '%square,%') OR (`drops` LIKE '%sq,%' OR `i_drops` LIKE '%sq,%') OR (`drops` LIKE '%dose%' OR `i_drops` LIKE '%dose%') OR (`drops` LIKE '%[%' OR `i_drops` LIKE '%[%') OR (`drops` LIKE '%]%' OR `i_drops` LIKE '%]%'))");
  while($info = $db->fetch_array($query))
   {
    echo '<li><a href="/editor/monsters.php?act=edit&amp;id='.$info['id'].'" target="_blank">' . $info['name'] . '</a></li>';
   }
  echo '</ol><br /></div>';
		?>
		
<a href="#" onclick=hide('tohide5')><span style="font-variant:small-caps; font-size: 14px;">Fix attack style to what is specified in instructions [IMPORTANT]:</span></a><br />

<div id="tohide5" style="display:none">
<ol>
<?php
  $query = $db->query("SELECT id, name FROM `monsters` WHERE `npc` =1 AND `attstyle` NOT IN ('Melee', 'Magic', 'Range', 'Mage and Range', 'Magic and Melee', 'Melee and Range', 'Melee, Mage and Range','Not Applicable') ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<li><a href="/editor/monsters.php?act=edit&amp;id='.$info['id'].'" target="_blank">' . $info['name'] . '</a></li>';
   }
  echo '</ol><br /></div>';

		?>

<a href="#" onclick=hide('tohide1')><span style="font-variant:small-caps; font-size: 14px;">Monsters needing a picture:</span></a><br />
<div id="tohide1" style="display:none">
<ol>
<?php
  $query = $db->query("SELECT id, name, combat, examine FROM `monsters` WHERE img = 'nopic.gif' ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<li><a href="/monsters.php?id='.$info['id'].'" target="_blank">' . $info['name'] . '</a> [ level ' . $info['combat'] . ' ]  (<i>' . $info['examine'] . '</i>)</li>';
   }
  echo '</ol><br /></div>';

		?>

<a href="#" onclick=hide('tohide2')><span style="font-variant:small-caps; font-size: 14px;">Missing examines:</span></a><br />
<div id="tohide2" style="display:none">
<ol>
<?php
  $query = $db->query("SELECT id, name, combat FROM `monsters` WHERE `examine` = '' or `examine` = '-' ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<li><a href="/editor/monsters.php?act=edit&amp;id='.$info['id'].'" target="_blank">' . $info['name'] . '</a> [ level ' . $info['combat'] . ' ]</li>';
   }
  echo '</ol><br /></div>';

		?>

<a href="#" onclick=hide('tohide3')><span style="font-variant:small-caps; font-size: 14px;">Incomplete F2P Monsters:</span></a><br />

<div id="tohide3" style="display:none">
<ol>
<?php
  $query = $db->query("SELECT id, name, combat FROM `monsters` WHERE member != 1 AND `complete` != 1 ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<li><a href="/editor/monsters.php?act=edit&amp;id='.$info['id'].'" target="_blank">' . $info['name'] . '</a> [ level ' . $info['combat'] . ' ]</li>';
   }
  echo '</ol><br /></div>';

		?>

<a href="#" onclick=hide('tohide4')><span style="font-variant:small-caps; font-size: 14px;">Monsters with 1hp/cb:</span></a><br />

<div id="tohide4" style="display:none">
<ol>
<?php
  $query = $db->query("SELECT id, name, hp FROM `monsters` WHERE complete != 1 AND npc= 1 AND (`hp` = 1 or `hp` = 0 or `combat` = 0 or `combat` = 1) ORDER BY `name`");
  while($info = $db->fetch_array($query))
   {
    echo '<li><a href="/editor/monsters.php?act=edit&amp;id='.$info['id'].'" target="_blank">' . $info['name'] . '</a> [ hp: ' . $info['hp'] . ' ]</li>';
   }
  echo '</ol><br /></div>';

		?>

</div><br />
<?php
}
end_page();
?>