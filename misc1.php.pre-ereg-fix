<?php
/*** MISC PAGE ***/
$cleanArr = array(  array('id', $_GET['id'], 'int', 's' => '1,9999'),
					array('order', $_GET['order'], 'enum', 'e' => array('DESC', 'ASC'), 'd' => 'ASC' ),
					array('category', $_GET['category'], 'enum', 'e' => array('name'), 'd' => 'name' ),
					array('search_area', $_GET['search_area'], 'enum', 'e' => array('name','text') ),
					array('search_term', $_GET['search_term'], 'sql', 'l' => 40)
				  );
				  
require(dirname(__FILE__) . '/' . 'backend.php');
start_page('Runescape Guides');
$ptitle = '&raquo; Runescape Miscellaneous Guides';
if($search_area && $search_term) $ptitle = '&raquo; <a href="'.$_SERVER['SCRIPT_NAME'].'" title="Runescape Help Guides Index">Runescape Miscellaneous Guides</a> &raquo; Search Results';
?>
<div class="boxtop">Runescape Miscellaneous Guides</div>
<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<?
if(!isset($_GET['id']))
 {
?>
<a name="top"></a>
<div style="margin:1pt; font-size:large; font-weight:bold;"><?=$ptitle?></div>
<hr class="main" noshade="noshade" />
<br />
<?
  echo '<table class="misc_list_table" style="float: left; text-align: center;"><tr><td style="padding: 5px 2px; width: 175px;">
		<strong>Jump to:</strong>
		<ul style="list-style-type: circle; padding-left: 20px;">
		<li><a href="#popular">Popular</a></li>
		<li><a href="#achievement_diaries">Achievement Diaries</a></li>
		<li><a href="#monster_killing">Monster Killing &amp; Habitats</a></li>
		<li><a href="#activities_miniquests">Activities &amp; Mini Quests</a></li>
		<li><a href="#items_and_combat">Items &amp; Combat</a></li>
		<li><a href="#info_and_howto">Informational &amp; How To</a></li>
		</ul></td></tr></table>
		<script type="text/javascript">
		<!--
		function chBg(Id) {
			Blok = document.getElementById(Id);
			if(navigator.appName != "Microsoft Internet Explorer" && (navigator.userAgent).indexOf("Opera") == -1) {
				if(Blok.style.backgroundColor == "transparent")
					Blok.style.background = null;
				else
					Blok.style.backgroundColor = "transparent";
			}
		}
		//-->
		</script>';
  echo '<div style="width: 70%; margin: 20px auto 110px auto;">';
  include('search.inc.php');
  echo '</div>'.NL.NL;
  for($i=0;$i<7;$i++) {
  $n=0;
  if(!$search_area) $search = "WHERE `group` = '" . $i . "' ORDER BY `group`, name ASC";
  else $search = "WHERE `group` = " . $i . " AND ".$search_area." LIKE '%".$search_term."%' ORDER BY `group`, name ASC";
  $query = $db->query("SELECT * FROM misc " . $search);
  
  switch($i) {
  case 1:   $title = 'Popular';
            $image = 'c1';
            $aname = 'popular';
            break;
            
  case 2:   $title = 'Achievement Diaries';
            $image = 'diary';
            $aname = 'achievement_diaries';
            break;
            
  case 3:   $title = 'Monster Killing &amp; Habitats';
            $image = 'c3';
            $aname = 'monster_killing';
            break;
  
  case 4:   $title = 'Activities &amp; Mini Quests';
            $image = 'c4';
            $aname = 'activities_miniquests';
            break;
            
  case 5:   $title = 'Items &amp; Combat';
            $image = 'c5';
            $aname = 'items_and_combat';
            break;  
            
  case 6:   $title = 'Informational &amp; How To Guides';
            $image = 'c6';
            $aname = 'info_and_howto';
            break;
  }

if(mysql_num_rows($query) != 0) {
    echo '<a name="'.$aname.'"></a><h2>' . $title . '</h2>' . NL
        .'<table width="100%" class="misc_list_table">' . NL
        .'<tr>' . NL
        .'<td style="width:175px;background: url(/img/genimg/' . $image . '.gif) no-repeat 50% 50%;"></td>' . NL
        .'<td style="padding-right: 2px;">' . NL
        .'<ul class="guides">' . NL;
  while($info = $db->fetch_array($query))
   {
   $alt = '';
   $n++;
   if($n % 2 == 0) $alt = ' class="alt"';
   $seotitle = strtolower(ereg_replace("[^A-Za-z0-9]", "", $info['name']));
   $img = '<img src="/img/f2p.gif" alt="F2P" /> ';
   if($info['type'] == 1) $img = '<img src="/img/member.gif" alt="P2P" /> ';
echo '<li' . $alt . ' id="g'.$info['id'].'" style="cursor: pointer;" onmouseover="chBg(\'g'.$info['id'].'\');" onmouseout="chBg(\'g'.$info['id'].'\');" onclick="window.location=\''.$_SERVER['SCRIPT_NAME'].'?id=' . $info['id'] . '&amp;runescape_' . $seotitle . '.htm\'">'.NL
    .'<div class="guide_title"><span>'
    .$img . '<a href="'.$_SERVER['SCRIPT_NAME'].'?id=' . $info['id'] . '&amp;runescape_' . $seotitle . '.htm" title="Runescape Guide">' . $info['name'] . '</a>'
    .'</span></div>'.NL
    .'<div class="guide_descr"><p>' . $info['keyword'] . '</p></div>' . NL
    .'</li>'.NL;
   }
    echo '</ul></td></tr>';
   echo '</table>'.NL.NL;
   echo '<span style="float:right;"><a href="#top">Top</a></span>';
  }
}
?>
<br />
<h2 style="text-align:center; font-size: 1.7em;"><b>Didn't find what you were looking for?<br />We have a lot more Runescape guides on <a href="/community/index.php?showforum=317" title="Click here to see lots more Runescape Guides">Runescape Community</a></b></h2>
<?
 }
else
 {

  $id = $_GET['id'];
  $id = intval( $id );
  $info = $db->fetch_row("SELECT * FROM `misc` WHERE `id` = " . $id);

?>
<div style="margin:1pt; font-size:large; font-weight:bold;">
<a href="<?=$_SERVER['SCRIPT_NAME']?>"><?=$ptitle?></a> &raquo; <u><?=$info['name']?></u></div>
<hr noshade="noshade" />
<table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="5" cellspacing="0">
<?
  echo '<tr><td class="tablebottom"><a href="/correction.php?area=misc&amp;id=' . $id . '" title="Submit a Correction"><img src="/img/correct.gif" alt="Submit Correction" border="0" /></a></td></tr>';
  echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">' . dynamify($info['text']) . '</td></tr>';
  echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Author: <b>' . $info['author'] . '</b></td>'
?>  
 </tr>
</table>
<br />
<p style="text-align:center; font-weight:bold;"><a href="javascript:history.go(-1)">&lt;-- Go Back</a> | <a href="#top">Top -- ^</a></p>
<br />
<?
 }
 ?>
[#COPYRIGHT#]
</div>
<?
end_page( $info['name'] );
?>