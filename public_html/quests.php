<?php
$cleanArr = array(  array('id', $_GET['id'] ?? '', 'int', 's' => '1,999'),
					array('hide', $_GET['hide'] ?? '', 'int', 's' => '1,999'),
					array('unhide', $_GET['unhide'] ?? '', 'int', 's' => '1,999'),
					array('order', $_GET['order'] ?? '', 'enum', 'e' => array('DESC', 'ASC'), 'd' => 'ASC' ),
					array('category', $_GET['category'] ?? '', 'enum', 'e' => array('name', 'type', 'text', 'reward', 'difficulty', 'length'), 'd' => 'name' ),
					array('search_area', $_GET['search_area'] ?? '', 'enum', 'e' => array('name', 'text', 'reward'), 'd' => 'name' ),
					array('search_term', $_GET['search_term'] ?? '', 'sql', 'l' => 40, 'd' => '')
				  );

/*** QUEST PAGE ***/
$amquest = 1;
require(dirname(__FILE__) . '/' . 'backend.php');

// Ensure database is connected before any queries
$db->connect();
$db->select_db(MYSQL_DB);

//--- IP/COOKIE/HIDDEN CHECK
$usercheck = $db->num_rows("SELECT * FROM `quests_ip` WHERE `ip` = '" . $db->escape_string($_SERVER['REMOTE_ADDR']) . "'"); //Check for IP

if(empty($_COOKIE['quests']) && $usercheck == 0 && isset($_GET['hide'])) { //User has no cookie and no IP. Set on first hide.
    $db->query("INSERT INTO `quests_ip` (id,ip,hidden_id) VALUES (UNIX_TIMESTAMP(), '" . $_SERVER['REMOTE_ADDR'] . "',0)");
    $cookie_id = $db->fetch_row("SELECT id FROM `quests_ip` WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "'");
    $expire = time() + 60 * 60 * 24 * 90;
    setcookie('quests',$cookie_id['id'],$expire);
    header( 'Location: ' . $_SERVER['SCRIPT_NAME'] );
    exit;
}
elseif($_COOKIE['quests'] && !empty($_COOKIE['quests']) && $usercheck == 0) { //User has Cookie and no IP/IP needs updating.
    $checkid = $db->num_rows("SELECT id FROM quests_ip WHERE id = '" . $_COOKIE['quests'] . "'");
    if($checkid == 0) $db->query("INSERT INTO `quests_ip` (id,ip,hidden_id) VALUES ('" . $_COOKIE['quests'] . "', '" . $_SERVER['REMOTE_ADDR'] . "',0)");
    if($checkid != 0) $db->query("UPDATE `quests_ip` SET `ip` = '" . $_SERVER['REMOTE_ADDR'] . "' WHERE `id` = '" . intval($_COOKIE['quests']) . "'");
    header( 'Location: ' . $_SERVER['SCRIPT_NAME'] );
    exit;
}
elseif(empty($_COOKIE['quests']) && $usercheck != 0) { //User has IP, but no Cookie.
    $cookie_id = $db->fetch_row("SELECT id FROM `quests_ip` WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "'");
    $expire = time() + 60 * 60 * 24 * 90;
    setcookie('quests',$cookie_id['id'],$expire);
    header( 'Location: ' . $_SERVER['SCRIPT_NAME'] );
    exit;
}

// Handle Hide/Unhide actions
if(isset($hide) && $hide > 0) {
    $db->query("UPDATE `quests_ip` SET `hidden_id` = CONCAT(hidden_id,',','" . $hide . "') WHERE `ip` = '" . $_SERVER['REMOTE_ADDR'] . "'");
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        exit; // Exit for AJAX
    }
    header('Location: ' . $_SERVER['SCRIPT_NAME']);
    exit;
}

$hidden_pre = $db->fetch_row("SELECT `hidden_id` FROM `quests_ip` WHERE `ip` = '" . $_SERVER['REMOTE_ADDR'] . "'");
$hidden = $hidden_pre['hidden_id'] ?? '0';

if(isset($_GET['unhide']) && $_GET['unhide'] > 0) {
    $vals = explode(',',$hidden);
    $remove = intval($_GET['unhide']);
    $out = "0";
    for($i=1; $i < count($vals); $i++) {
        if($vals[$i] != $remove) $out = $out . "," . $vals[$i];
    }
    $db->query("UPDATE `quests_ip` SET `hidden_id` = '" . $out . "' WHERE `ip` = '" . $_SERVER['REMOTE_ADDR'] . "'");
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        exit; // Exit for AJAX
    }
    header('Location: ' . $_SERVER['SCRIPT_NAME'] . '?unhide');
    exit;
}

$ptitle = 'OSRS RuneScape Quest Guides';
start_page($ptitle);

if($disp->errlevel > 0) {
	$id = null;
	$search_area = 'name';
}

?>
<div class="boxtop"><?php echo $ptitle; ?></div>
<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<a name="top"></a>
<?php
  if(isset($_GET['information'])) {
?>
<div style="margin:1pt; font-size:large; font-weight:bold;">
&raquo; <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>"><?php echo $ptitle; ?></a>
</div>
<hr class="main" noshade="noshade" />
<br />
<?php
echo '<h3>Difficulty</h3>'.NL
    .'<img src="/img/qimg/1.gif" alt="Difficulty" /> Beginner. Talk to a few people, nothing strenuous, no puzzles involved.<br />'.NL
    .'<img src="/img/qimg/2.gif" alt="Difficulty" /> Mild. Some parts may require a little thinking, fairly easy creatures to defeat.<br />'.NL
    .'<img src="/img/qimg/3.gif" alt="Difficulty" /> Intermediate. Nothing the average player \'shouldn\'t be able to handle.<br />'.NL
    .'<img src="/img/qimg/4.gif" alt="Difficulty" /> Hard. May be powerful monsters to defeat, difficult puzzles to crack or long distances to trek.<br />'.NL
    .'<img src="/img/qimg/5.gif" alt="Difficulty" /> Experienced. One of the harder quests in the game. Watch out for powerful NPCs or confusing and lengthy tasks.<br />'.NL
    .'<img src="/img/qimg/6.gif" alt="Difficulty" /> Master. One of the hardest quests in the game. Watch out for powerful NPCs or brain-racking puzzles.<br />'.NL
    .'<img src="/img/qimg/7.gif" alt="Difficulty" /> Grandmaster. This quest is one of the biggest and hardest in the game, with loads of high level requirements, powerful NPCs to beat and other challenging tasks to complete.<br />'.NL;

echo '<h3>Length</h3>'.NL
    .'<img src="/img/qimg/1.gif" alt="Length" /> Very short. Generally finished within 20 minutes and doesn\'t require much wandering around.<br />'.NL
    .'<img src="/img/qimg/2.gif" alt="Length" /> Short. May take about 20-40 minutes due to a bit of exploring, or long quest conversations.<br />'.NL
    .'<img src="/img/qimg/3.gif" alt="Length" /> Medium. May take 40-60mins depending on methods of transport.<br />'.NL
    .'<img src="/img/qimg/4.gif" alt="Length" /> Long. Could take anywhere from 1-3 hours.<br />'.NL
    .'<img src="/img/qimg/5.gif" alt="Length" /> Very long. May take 3-4 hours depending on your combat level, skills and equipment.<br />'.NL
    .'<img src="/img/qimg/6.gif" alt="Length" /> Very, very long. May take 4-6 hours depending on your combat level, skills and equipment.<br />'.NL
    .'<img src="/img/qimg/7.gif" alt="Length" /> Uber long. May take 6+ hours depending on your combat level, skills and equipment.<br /><br /><br />'.NL;
 }
  elseif(!isset($id)) {
?>
<div style="margin:1pt; font-size:large; font-weight:bold;">&raquo; <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>"><?php echo $ptitle; ?></a></div>
<hr class="main" noshade="noshade" />
<p style="text-align: center;">Welcome to RuneScape Help\'s Quest Guides section. Here you will find step-by-step help and walkthroughs for all Runescape quests.<br />You can hide quests you\'ve completed by clicking the image to the right, and unhide selected ones by clicking the <a href="/quests.php?unhide">Unhide</a> link.<br />If you\'re training a skill, use the search feature to find which quests give XP rewards for that skill.<br />Happy Questing!</p>
<!--AJAX FUNCTIONS -->
<script language="JavaScript" type="text/javascript">
function hide(id)
{
    document.getElementById('quest'+id).style.display = 'none';
    $.get('<?php echo $_SERVER['SCRIPT_NAME']; ?>', { hide: id });
}

function unhide(id)
{
    document.getElementById('quest'+id).style.display = 'none';
    $.get('<?php echo $_SERVER['SCRIPT_NAME']; ?>', { unhide: id });
}
</script>

<?php
//--- SEARCH

 if(isset($search_area) && ($search_area == 'name' || $search_area == 'text' || $search_area == 'reward'))
  { //Search
  if($search_area == 'reward') $search_term = substr($search_term, 0, 3);
   $search2 = "AND ".$search_area." LIKE '%" . $search_term . "%' ORDER BY `". $category . "` ".$order."";
   $search1 = "WHERE ".$search_area." LIKE '%" . $search_term . "%' ORDER BY `". $category . "` ".$order."";
 }
 else { //Index
   $search1 = "ORDER BY `". $category . "` ".$order;
   $search2 = "ORDER BY `". $category . "` ".$order;
 }
 
   echo '<form action="' . $_SERVER['SCRIPT_NAME'] . '" method="get" style="text-align:center;">';
   echo 'Search <select name="search_area">';
   
  $areas = array('name' => 'Name', 'reward' => 'XP Rewards', 'text' => 'Guide Content');
  foreach ($areas as $val => $name) {
      $selected = ($search_area == $val) ? ' selected="selected"' : '';
      echo '<option value="' . $val . '"' . $selected . '>' . $name . '</option>';
  }
  echo '</select> for';
  echo ' <input type="text" name="search_term" value="' . htmlspecialchars(stripslashes($search_term), ENT_QUOTES) . '" maxlength="40" />';
  echo ' <input type="submit" value="Go" /></form>';
  
  //--- END SEARCH

$up = '<img src="/img/up.GIF" width="9" height="9" alt="Sort Ascending" border="0" />';
$down = '<img src="/img/down.GIF" width="9" height="9" alt="Sort Descending" border="0" />';
$url = $_SERVER['SCRIPT_NAME'] . '?';
if(isset($_GET['unhide'])) $url = $_SERVER['SCRIPT_NAME'] . '?unhide&amp;';
echo '<table width="100%" cellpadding="5" cellspacing="0" class="quest-list">'.NL
.'<tr align="center" style="font-size: 17px;">'.NL
.'<th>Name <a href="' . $url . 'order=ASC&amp;category=name&amp;search_area='.$search_area.'&amp;search_term='.urlencode($search_term).'" title="Sort by: Name, Ascending (A-Z)">'.$up.'</a> <a href="' . $url . 'order=DESC&amp;category=name&amp;search_area='.$search_area.'&amp;search_term='.urlencode($search_term) .'" title="Sort by: Name, Descending  (Z-A)">'.$down.'</a></th>'.NL
.'<th>Members <a href="' . $url . 'order=ASC&amp;category=type&amp;search_area=' . $search_area . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Members, Ascending">'.$up.'</a> <a href="' . $url . 'order=DESC&amp;category=type&amp;search_area=' . $search_area . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Members, Descending">'.$down.'</a></th>'.NL
.'<th>QP <a href="' . $url . 'order=ASC&amp;category=reward&amp;search_area=' . $search_area . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Quest Points, Ascending">'.$up.'</a> <a href="' . $url . 'order=DESC&amp;category=reward&amp;search_area=' . $search_area . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Quest Points, Descending">'.$down.'</a></th>'.NL
.'<th>Difficulty (<a href="' . $url . 'information" title="Click here to see what the bars mean">?</a>) <a href="' . $url . 'order=ASC&amp;category=difficulty&amp;search_area=' . $search_area . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Difficulty (Easy-Hard), Ascending">'.$up.'</a> <a href="' . $url . 'order=DESC&amp;category=difficulty&amp;search_area=' . $search_area . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Difficulty (Hard-Easy), Descending">'.$down.'</a></th>'.NL
.'<th>Length (<a href="' . $url . 'information" title="Click here to see what the bars mean">?</a>) <a href="' . $url . 'order=ASC&amp;category=length&amp;search_area=' . $search_area . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Length, Ascending (Short-Long)">'.$up.'</a> <a href="' . $url . 'order=DESC&amp;category=length&amp;search_area=' . $search_area . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Length, Descending (Long-Short)">'.$down.'</a></th>'.NL;

if(isset($_GET['unhide']) || empty($_COOKIE['quests'])) { echo '<th>&nbsp;</th>'.NL; }
elseif(!isset($_GET['unhide'])) { echo '<th><a href="' . $_SERVER['SCRIPT_NAME'] . '?unhide" title="View your Hidden Guides">Unhide</a></th>'.NL; }
echo '</tr>'.NL;

//-- START VIEW AREA
if(isset($_GET['unhide'])) {
    if($hidden == '0') echo '<tr><td colspan="6"><h3 style="text-align:center;">You have no hidden quests. Click <a href="/quests.php">here</a> to go back to the quest index.</h3></td></tr>';
    elseif(empty($hidden)) $db->query("UPDATE `quests_ip` SET `hidden_id` = 0 WHERE `ip` = '" . $_SERVER['REMOTE_ADDR'] . "'");
    else $query = $db->query("SELECT * FROM `quests` WHERE `id` IN (" . $hidden . ") " . $search2 . ""); //Hidden Guides
} else {
    if($hidden == '0' || $hidden == FALSE ) $query = $db->query("SELECT * FROM `quests` " . $search1 . "");
    elseif($hidden != '0') $query = $db->query("SELECT * FROM `quests` WHERE id NOT IN (" . $hidden . ") " . $search2 . "");
}

if (isset($query)) {
    while($info = $db->fetch_array($query))
    {
        $reward = explode("\n",$info['reward']);
        $qp = explode("|",$reward[0]); //First in array is Quest Point. qp[1] is the value.
        $info['type'] = $info['type'] == 1 ? 'Yes' : 'No';
        
        echo '<tr align="center" id="quest'. $info['id'] .'">' . NL;
        echo '<td><a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?id=' . $info['id'] . '">' . htmlspecialchars($info['name']) . '</a></td>' . NL;
        echo '<td>' . htmlspecialchars($info['type']) . '</td>' . NL;
        echo '<td title="Quest Point Rewarded">' . intval($qp[1] ?? 0) . '</td>' . NL;
        echo '<td><img src="/img/qimg/' . $info['difficulty'] . '.gif" alt="Difficulty Rating: ' . $info['difficulty'] . '/7" title="Difficulty Rating: ' . $info['difficulty'] . '/7" class="bar" /></td>' . NL;
        echo '<td><img src="/img/qimg/' . $info['length'] . '.gif" alt="Length Rating: ' . $info['length'] . '/7" title="Length Rating: ' . $info['length'] . '/7" class="bar" /></td>' . NL;
        
        if (isset($_GET['unhide'])) {
            echo '<td><noscript><a href="' . $_SERVER['SCRIPT_NAME'] . '?unhide=' . $info['id'] . '" title="Click to unhide this guide"></noscript><img src="/img/unhide.gif" title="Click to unhide this guide" style="cursor:pointer;" alt="Unhide" onclick="unhide('.$info['id'].')" /><noscript></a></noscript></td>' . NL;
        } else {
            echo '<td><noscript><a href="' . $_SERVER['SCRIPT_NAME'] . '?hide=' . $info['id'] . '" title="Click to hide this guide"></noscript><img src="/img/hide.gif" title="Click to hide this guide" style="cursor:pointer;" alt="Hide" onclick="hide('.$info['id'].')" /><noscript></a></noscript></td>' . NL;
        }
        echo '</tr>' . NL;
    }
}
?>
</table>
<br />
<?php
 }
else
 {
  $info = $db->fetch_row("SELECT * FROM `quests` WHERE `id` = " . (int)$id);
?>

<div style="margin:1pt; font-size:large; font-weight:bold;">
&raquo; <a href="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>"><?php echo htmlspecialchars($ptitle); ?></a> &raquo; <u><?php echo htmlspecialchars($info['name'] ?? ''); ?></u>
</div>
<hr class="main" noshade="noshade" />
<br />
<table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="5" cellspacing="0">
<?php
  echo '<tr><td class="tablebottom"><a href="/correction.php?area=quests&amp;id=' . (int)$id . '" title="Submit a Correction"><img src="/img/correct.gif" alt="Submit Correction" border="0" /></a></td></tr>';
  echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">' . $info['text'] . '</td></tr>';
  echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Author: <b>' . htmlspecialchars($info['author'] ?? '') . '</b></td>';
?>  
 </tr>
</table>
<br />
<p style="text-align:center; font-weight:bold;"><a href="javascript:history.go(-1)">&lt;-- Go Back</a> | <a href="#top">Top -- ^</a></p>
<br />
<?php
 }
 ?>
[#COPYRIGHT#]
</div>
<?php
end_page( htmlspecialchars($info['name'] ?? '') );
?>