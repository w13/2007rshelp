<?php

$cleanArr = array(  array('player', $_GET['player'], 'sql', 'l' => 12),
					array('grabstats', $_GET['grabstats'], 'sql', 'l' => 12),
					array('calc_user', $_COOKIE['calc_user'], 'sql', 'l' => 12),
					array('page', $_GET['page'], 'int', 's' => '1,200', 'd' => 1),
					array('rscbox', $_GET['rscbox'], 'int', 's' => '1,2'),
					array('set_username', $_GET['set_username'], 'sql', 'l' => 12),
//					array('to', $_GET['to'], 'sql', 'l' => 12),
//					array('from', $_GET['from'], 'sql', 'l' => 12),
					array('u', $_GET['u'], 'sql', 'l' => 12),
					array('s', $_GET['s'], 'sql', 'l' => 12),
				  );			  

				  
require( dirname(__FILE__) . '/' . 'backend.php' );
require( ROOT . '/' . 'stats_functions.inc.php' );
start_page('Runescape Stats History');

if($disp->errlevel > 0) {
	unset($grabstats);
	unset($player);
	unset($calc_user);
}
  
  /* SET THE USER */
  if(isset($_GET['player'])) $username = $_GET['player'];               // Set from GET.
  elseif(!isset($_GET['player']) && !empty($calc_user)) $username = $calc_user; // No GET, use calc
  else $username = 'Zbart99';
  
   /* CLEAN THE USER */                                   
  $normalise = array("_", "-", "@", "+", "'", "\"", "=", ":", "/", ".","%",";","\\");
  $username = stripslashes($username);
  $username = str_replace($normalise,' ',$username);
  $username = ucwords($username);

  // Security Fix: Escape the username before query
  $username_safe = $db->escape_string($username);
  
  $skillnames = array('Overall',
                      'Attack',
                      'Defence',
                      'Strength',
                      'Hitpoints',
                      'Ranged',
                      'Prayer',
                      'Magic',
                      'Cooking',
                      'Woodcutting',
                      'Fletching',
                      'Fishing',
                      'Firemaking',
                      'Crafting',
                      'Smithing',
                      'Mining',
                      'Herblore',
                      'Agility',
                      'Thieving',
                      'Slayer',
                      'Farming',
                      'Runecraft',
                      'Hunter',
                      'Construction'
                      );
function stat_box($var) {

  global $db;
  global $username;
  global $skillnames;
  
  echo '<link href="/css/sig.css" rel="stylesheet" type="text/css" />';
  echo '<script type="text/javascript" src="http://www.runescapecommunity.com/graphs/popup.js"></script>';
  /*if($_COOKIE['update_time']) {
  echo '<script type="text/javascript" src="http://www.runescapecommunity.com/graphs/statsig.js"></script>';
  }*/
    $query = $db->query("SELECT * FROM `stats` WHERE `User`= '" . $username_safe . "' ORDER BY `time` DESC LIMIT 1");
  $info = $db->fetch_array($query);
  
  $images = array('0.jpg','1.jpg','2.jpg','3.jpg','4.gif', '5.gif', '6.gif', '7.gif','8.gif', '9.gif', '10.gif');
  $num = rand(0,(count($images)-1));
  $linkc = "#fff";
  if($num == 1) $linkc = "#000"; ## Which ones need black text?
  //echo '<div id="floaty" style="width:350px;height:130px;background-color:#000;text-align:center;">Its been five days since these stats were updated.....? No idea how to set this lol...</div>';
  echo '<div style="width:350px;height:130px;background:#000 url(\'/images/dynsig/'.$images[$num].'\') no-repeat 50% 50%">';
  if($var == 'rsc') {
      echo '<div class="closer" title="Close" onclick=\'document.getElementById("faladorstats").style.display="none";\'>Close</div>';
  }
  echo '<table style="width:350px;height:100px;" cellspacing="1" cellpadding="0" border="0">';
  echo '<tr>';
  
  $v=0;
  for($m=0;$m<count($skillnames);$m++) {
      if($m != 0 && $m < 25) {
      if($info[($skillnames[$m].'l')] == '-1') {
        echo '<td class="skill" title="'.$skillnames[$m].' - No Record">--</td>';
      }
      else {
        echo '<td class="skill" title="'.$skillnames[$m].' Level: ' . $info[($skillnames[$m].'l')] . '"><a style="color:' . $linkc . ';" href="/graphs/history.php?u='.$username.'&s='.$skillnames[$m].'" onclick="return popup(this,430,180,\'2px solid #fff\')">' . $info[($skillnames[$m].'l')] . '</a></td>';
      }
        $v++;
        if(($v % 8) == 0) echo '</tr>';
      }
  }
echo '</table>';

			// COMBAT LEVEL CALCULATION
			$attack = $info['Attackl'] ? $info['Attackl'] : 1;
			$strength = $info['Strengthl'] ? $info['Strengthl'] : 1;
			$defence = $info['Defencel'] ? $info['Defencel'] : 1;
			$hitpoints = $info['Hitpointsl'] ? $info['Hitpointsl'] : 1;
			$prayer = $info['Prayerl'] ? $info['Prayerl'] : 1;
			$magic = $info['Magicl'] ? $info['Magicl'] : 1;
			$summoning = $info['Summoningl'] ? $info['Summoningl'] : 1;
			
			$as_val = 0.3248;
			$dh_val = 0.25025; // Confirmed
			$p_val = 0.125; // Confirmed
			$rm_val = 0.4875;
			$prayer = $prayer + $summoning;
			// FIND 3 DIFFERENT COMBATS
			$warrior = ($strength * $as_val) + ($attack * $as_val) + ($defence * $dh_val) + ($hitpoints * $dh_val) + ($prayer * $p_val);
			$ranger = ($ranged * $rm_val) + ($defence * $dh_val) + ($hitpoints * $dh_val) + ($prayer * $p_val);
			$wizard = ($magic * $rm_val) + ($defence * $dh_val) + ($hitpoints * $dh_val) + ($prayer * $p_val);
			$combat = max( $warrior , $ranger , $wizard );
			$combat_decimal = floor( $combat );

    $combatstuff = '';
    if($combat_decimal != '-1') $combatstuff = '(level-'. $combat_decimal .')';
    echo '<div class="pname" style="color:' . $linkc . ';">'
        .'<a style="color:' . $linkc . ';" target="_blank" title="Click to Update Stats" href="/statsgrabber.php?grabstats=' . $username . '">' . $username . '</a> '
        . $combatstuff . '</div>';
        if($info[($skillnames[0].'l')] != -1) {
    echo '<div class="total" style="color:#000;">Total: ' . number_format($info[($skillnames[0].'l')]) . ' (<span>' . number_format($info[($skillnames[0].'x')]) . ' XP</span>)</div>';
    }
    else {
    echo '<div class="total" style="color:#000;">Total: <span>Not Available</span></div>';
    }
    echo '</div>';
    
}

/* Runescape Community Stat Boxes */
if($rscbox) {
  $query = $db->query("SELECT * FROM `stats` WHERE `User`= '".$username_safe."' ORDER BY `time` DESC LIMIT 1");
  $info = $db->fetch_array($query);
  
  switch($rscbox) {

    case 1 :
    //echo '<link href="/css/sig.css" rel="stylesheet" type="text/css" />';
    //echo '<script type="text/javascript" src="http://www.zybez.net/graphs/popup.js"></script>';
    echo '<div style="position:absolute;top:1;left:1">'
        .'<input type="button" value="X" onclick=\'document.getElementById("faladorstats").style.display="none";\'></div>'
        .'<center><b style="font-family:calibri, verdana, arial, sans-serif;">'
        .'<a href="/statsgrabber.php?player='. $username . '" target="_blank" title="View History & Update Stats">' . $username . '</a>'
        .'</b></center>'
        .'<table style="font-size:10pt; font-family: calibiri, verdana, arial; width: 100%">';
    for($i=0;$i<count($skillnames);$i++) {
          if($info[$skillnames[$i].'r'] == '-1' || $info[$skillnames[$i].'l'] == '-1') {
            $info[($skillnames[$i].'l')] = '-';
            $title = 'Unknown';
          }
          else {
            $title = 'XP: '.number_format($info[($skillnames[$i].'x')]).' | Rank: '.number_format($info[($skillnames[$i].'r')]);
          }
          echo '<tr><td> '  . $skillnames[$i] . ' </td>'
              .'<td title="'.$title.'" style="' . colorcodemysocks($info[($skillnames[$i].'l')]) . '; text-align:right;">'
              .$info[($skillnames[$i].'l')] . '</td></tr>';
    }
    echo '</table>';
        die();
        break;
        
  case 2 :
    echo stat_box('rsc');
    die();
    break;
  }
}
elseif(isset($grabstats)) {
    $what = get_stat($grabstats,"Mining","level"); // This updates all skills, regardless.
    echo '<div class="boxtop"><a name="top">Runescape Stats History</a></div>'
      .'<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">'
      .'<p style="text-align:center;">Updating hiscore info for '.$grabstats.'. Please wait...</p></div>';
      header("refresh: 1; url=" . $_SERVER['SCRIPT_NAME'] . "?player=" . $grabstats);
     // setcookie('update_time', time(), time() + 432000);
  }
elseif(isset($set_username)) {
    
    echo '<div class="boxtop"><a name="top">Runescape Stats History</a></div>'
      .'<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">'
      .'<p style="text-align:center;">Storing '.$set_username.' as your default account. Please wait...<br /><br />'
      .'Please note this will also change the account used in the <a href="calcs.php?settings">Runescape Calculators</a> settings.</p></div>';
      setcookie('calc_user', $set_username, time() + 12000000);
      header("refresh: 4; url=" . $_SERVER['SCRIPT_NAME'] . "?player=" . $set_username);
  }
else {
?>
<style type="text/css">
#stats table {border-left: 1px solid #000;width:100%;border-spacing:0;border-top:1px solid #000;}
#stats td, #stats th {border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;border-top:none !important;color:#000;}</style>

<div class="boxtop"><a name="top">Runescape Stats History</a></div>
<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<div style="float:right;padding:5px;"><?php echo stat_box('null'); ?></div><?php/*<iframe src="?player=<?php=$username?>&rscbox=2" frameborder="0" scrolling="no" allowtransparency="true" style="width:380px;height:140px;overflow:hidden; float:right;background-color:transparent;margin-right:0;"></iframe>*/?>
<div style="margin:1pt;font-size:large;font-weight:bold;">&raquo; <a href="<?php=$_SERVER['SCRIPT_NAME']?>">Runescape Stat History</a></div>
<hr noshade="noshade" />
<p>Want to record your Runescape stat history? You've come to the right place! Everytime you use the Zybez <a href="calcs.php">Runescape Calculators</a>, we record your latest stat information.
<p>We currently have over 1 stat histories for over 1 different players, recorded in our database.</p>
<?php
$modes = array('r','l','x');	## RANK, LEVEL, XP

//$showduplicates = $_GET['showduplicates'];

//if(!isset($from) || $_from==''){ $from = 'last month'; }
//if(!isset($to) || $to==''){ $to = 'now'; }

	echo '<form name="form" action="">'
      .'<strong>Search Runescape Histories for </strong>'
      .'<input type="text" value="'.stripslashes($username).'" name="player" style="text-align:center;">'	  
//	  .'<br /><input type="text" name="from" value="'.$from.'" /> to <input type="text" name="to" value="'.$to.'" />'
	  .'<input type="submit" value="Go">';
	//<br />Show duplicate entries <input type="checkbox" name="showduplicates" value="yes" ';
	//if($showduplicates=='yes'){ echo 'checked '; }
	//echo '/> 
	echo '</form>';

// w, your stupid addition doesn't work. -no1
//$between = 'AND `time` BETWEEN '.intval(strtotime($from)).' AND '.intval(strtotime($to)).'';

/** PAGES AND DISPLAY **/
  $title = '<h3 style="text-align:center;">Runescape hiscore history for <b>'. $username . '</b> (<a href="?set_username=' . $username . '" title="Set this as my default username"><img src="/img/go.gif" alt="" border="0" width="11" height="11" /></a>)</h3>';
//  .'<br /><b>'.date("F j, Y",strtotime($from)). ' to ' .date("F j, Y",strtotime($to)).'</b>';
//if(isset($_GET['Z-Scores'])) {
//  $list = "ORDER BY `Time` DESC";
//  $title = '<h3 style="text-align:center;">Zybez Runescape Help\'s Top 500 Ranked Users</h3>';
//  }
//  else 
  $list = 'WHERE `User`= "'.$username_safe.'" ORDER BY `time` DESC';
  //if($showduplicates=='yes')
  //else $list = "WHERE `User`= '".$username."' GROUP BY `overallx` ORDER BY `time` DESC";

  $rows_per_page = 10;
  $row_count = $db->fetch_row("SELECT count(*) as count FROM `stats` " . $list);
  $page_count = ceil($row_count['count'] / $rows_per_page);
  if($page_count <= 0) $page_count = 1;

$page_links = ($page > 1 AND $page < $page_count) ? '|' : '';

  if($page > 1)
   {
        $page_before = $page - 1;
        if(isset($_GET['Z-Scores'])) $page_links = '<a href="' . $_SERVER['SCRIPT_NAME']. '?Z-Scores&amp;page=' .
        $page_before . '&amp;">< Previous</a> ' . $page_links;
        else $page_links = '<a href="' . $_SERVER['SCRIPT_NAME']. '?page=' . $page_before .
        '&amp;player=' . $username . '&amp;from='.$from.'&amp;to='.$to.'">< Previous</a> ' . $page_links;
   }
  if($page < $page_count)
   {
        $page_after = $page + 1;
        if(isset($_GET['Z-Scores'])) $page_links = $page_links .
        ' <a href="' . $_SERVER['SCRIPT_NAME']. '?Z-Scores&amp;page=' . $page_after . '">Next ></a> ';
        else $page_links = $page_links . ' <a href="' . $_SERVER['SCRIPT_NAME']. '?page=' . $page_after .
        '&amp;player=' . $username . '&amp;from='.$from.'&amp;to='.$to.'">Next ></a> ';
   }
  if($page > 2)
   {
        if(isset($_GET['Z-Scores'])) $page_links = '<a href="' . $_SERVER['SCRIPT_NAME']. '?Z-Scores&amp;page=1">&laquo; First</a> '. $page_links;
        else $page_links = '<a href="' . $_SERVER['SCRIPT_NAME']. '?page=1&amp;player=' . $username .
        '&amp;from='.$from.'&amp;to='.$to.'">&laquo; First</a> '. $page_links;
   }
  if($page < ($page_count - 1))
   {
        if(isset($_GET['Z-Scores'])) $page_links = $page_links . ' <a href="' . $_SERVER['SCRIPT_NAME'] .
        '?Z-Scores&amp;page=' . $page_count . '">Last &raquo;</a> ';
        else $page_links = $page_links . ' <a href="' . $_SERVER['SCRIPT_NAME']. '?page=' . $page_count .
        '&amp;player=' . $username . '&amp;from='.$from.'&amp;to='.$to.'">Last &raquo;</a> ';
   }

  $start_from = $page - 1;
  $start_from = $start_from * $rows_per_page;
  $end_at = $start_from + $rows_per_page;
  $query = $db->query("SELECT * FROM stats " . $list . " LIMIT " . $start_from . ", " . $rows_per_page);

  /* Header */
  echo '<p style="text-align:right;">Page ' . $page . ' of ' . $page_count . '</p>';
  echo $title;
  echo '<div id="stats">';
  echo '<table cellspacing="0"><tr>';
  if(isset($_GET['Z-Scores'])) echo '<th class="tabletop">User</th>';
  else echo '<th class="tabletop">Date</th>';
    for($i=0;$i<count($skillnames);$i++) {
      echo '<th><a style="color:' . $linkc . ';" href="/graphs/history.php?u='.$username.'&s='.$skillnames[$i].'" onclick="return popup(this,430,180,\'2px solid #fff\')"><img src="/img/calcimg/sgrab/'. substr($skillnames[$i], 0, 4) .'.gif" alt="" title="'. $skillnames[$i] .'" style="width:18px; height:18px;border:0;"></a></th>';
      }
	echo '</tr>';
  /* Data */
		while($info = $db->fetch_array($query)) {
			echo '<tr>';
			if(isset($_GET['Z-Scores'])) echo '<th class="tabletop">' . $info['User'] . '</th>';
			else echo '<th class="tabletop">' . date("d.m.y",$info['Time']) . '</th>';
			for($i=0;$i<count($skillnames);$i++) {
				if($info[($skillnames[$i].'r')] == '-1' || $info[($skillnames[$i].'l')] == '-1') {
					$info[($skillnames[$i].'l')] = '-';
					$title = 'Unknown';
				}
				else {
          $title = 'XP: '.number_format($info[($skillnames[$i].'x')]).' | Rank: '.number_format($info[($skillnames[$i].'r')]);
        }
		
		/* TITLE info -->  if(isset($_GET['showtitle'])){ $title = 'title="'.$title.'"'; }else{ $title = ''; } // this hides the experience points and the rank, unless a particular GET var is passed	 */ $title = 'title="'.$title.'"';
		$style = 'style="' . colorcodemysocks($info[($skillnames[$i].'l')]) . '"';
    /* The table cell that displays the rows ====> */ echo '
										<td '.$title.' '.$style.'>' . $info[($skillnames[$i].'l')] . '</td>';
				}
				echo '
				</tr>';
}
  if($row_count['count'] > $rows_per_page) echo '<tr><td colspan="27">'.$page_links.'</td></tr>';
	echo '</table></div>';

	echo '<p style="text-align:center;">
	<a href="?grabstats='.$username.'" title="You may only update once an hour">Update '.$username.'\'s Stats from Runescape.com Now</a></p>';

	echo '</div>';
	}
	end_page();
?>