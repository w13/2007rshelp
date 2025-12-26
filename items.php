<?php
 
$cleanArr = array(  array('id', $_GET['id'] ?? null, 'int', 's' => '1,9999'),
					array('order', $_GET['order'] ?? null, 'enum', 'e' => array('DESC', 'ASC'), 'd' => 'ASC' ),
					array('page', $_GET['page'] ?? null, 'int', 's' => '1,400', 'd' => 1),
					array('category', $_GET['category'] ?? null, 'enum', 'e' => array('name', 'member', 'trade', 'quest'), 'd' => 'name' ),
					array('search_area', $_GET['search_area'] ?? null, 'enum', 'e' => array('name','quest','obtain','examine','notes','type') ),
					array('search_term', trim($_GET['search_term'] ?? ''), 'sql', 'l' => 40)
				  );

/*** ITEM DATABASE ***/
require(dirname(__FILE__) . '/' . 'backend.php');
start_page('OSRS RuneScape Item Database');

// error_reporting(0);


if($disp->errlevel > 0) {
	unset($id);
	unset($search_area);
}

 echo '<script type="text/javascript" src="/graphs/popup.js"></script>';
  $graphjs = 'onclick="return popup(this,620,300,\'2px solid #fff\')"';
?>
<div class="boxtop">OSRS RuneScape Item Database</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<?php
 if(!isset($id))
  {

?>
<script type="text/javascript">function addEngine(name,ext,cat,type)
<!--
{
    if ((typeof window.sidebar == "object") && (typeof window.sidebar.addSearchEngine == "function")) { 
        window.sidebar.addSearchEngine(
            "http://www.zybez.net/img/market/"+name+".src",
            "http://www.zybez.net/img/market/"+name+"."+ext, name, cat
        );
    } else {
        alert("Sorry, you need a Mozilla-based browser to install a search plugin.");
    } 
}
//-->
</script>

<div style="margin:1pt; font-size:large; font-weight:bold;">&raquo; <a href="<?php echo $_SERVER['SCRIPT_NAME'];?>">OSRS RuneScape Item Database</a></div>
<hr class="main" noshade="noshade" />
<!-- (commented out on dec 3, 2013)
<img src="img/news/idb.gif" style="float:left;padding:20px 5px;" alt="" />
<p>This massive database contains tons of information and tips on Runescape's items. This interactive guide will help you research any aspect of any item in Runescape.</p>
<p><b>&raquo;</b>&nbsp;<a href="/items.php?search_area=type&amp;search_term=1">Armour and weapons</a>, <a href="/items.php?search_area=type&amp;search_term=2">Quest</a> and <a href="/items.php?search_area=type&amp;search_term=3">General</a> categories<br /><b>&raquo;</b> Tips on what you should do with your quest items<br /><b>&raquo;</b> Market Prices, Low and High Alchemy prices<br /><b>&raquo;</b> Extensive notes on each item<br /><b>&raquo;</b> A javascript tool to calculate amounts of items you're trading<br /><b>&raquo;</b> ... and loads more!</p>
<br />
<div style="clear:both;"></div>
-->
<br /><?php
  include('search.inc.php');
  echo '
  <table width="96%" style="margin:0 2%;" cellspacing="0" cellpadding="5">
<tr style="height:23px;font-size:13px;font-weight:bold;">
<td style="vertical-align:middle;text-align:right;"><a href="/correction.php?area=items&amp;id=4296">Submit Missing Item</a></td></tr></table><br />
  ';
  echo '<table style="margin:0 12%;border-left: 1px solid #000;" width="76%" cellpadding="1" cellspacing="0">';

  echo '<tr>';
  echo '<th class="tabletop" width="5%">Picture</th>';
  echo '<th class="tabletop">Name <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=ASC&amp;category=name&amp;page=' . $page . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Name, Ascending"><img src="/img/up.GIF" width="9" height="9" alt="Sort by: Name, Ascending" border="0" /></a> <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=DESC&amp;category=name&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Name, Descending"><img src="/img/down.GIF" width="9" height="9" alt="Sort by: Name, Descending" border="0" /></a></th>';
  
  echo '<th class="tabletop">Members <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=ASC&amp;category=member&amp;page=' . $page . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Members, Ascending"><img src="/img/up.GIF" width="9" height="9" alt="Sort by: Members, Ascending" border="0" /></a> <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=DESC&amp;category=member&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Members, Descending"><img src="/img/down.GIF" width="9" height="9" alt="Sort by: Members, Descending" border="0" /></a></th>';
  
  echo '<th class="tabletop">Tradable <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=ASC&amp;category=trade&amp;page=' . $page . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Tradable, Ascending"><img src="/img/up.GIF" width="9" height="9" alt="Sort by: Tradable, Ascending" border="0" /></a> <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=DESC&amp;category=trade&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Tradable, Descending"><img src="/img/down.GIF" width="9" height="9" alt="Sort by: Tradable, Descending" border="0" /></a></th>';
  
  echo '<th class="tabletop">Quest <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=ASC&amp;category=quest&amp;page=' . $page . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Quest, Ascending"><img src="/img/up.GIF" width="9" height="9" alt="Sort by: Quest, Ascending" border="0" /></a> <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=DESC&amp;category=quest&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Quest, Descending"><img src="/img/down.GIF" width="9" height="9" alt="Sort by: Quest, Descending" border="0" /></a></th>';
  echo '</tr>';


if(!isset($id)) {

while($info = $db->fetch_array($query))   {
	
  if($row_count == 1)
  {
  header('Location: '.$_SERVER['SCRIPT_NAME'] .'?id='.$info['id']);
  }
else {
$info['member'] = $info['member'] == 1 ? 'Yes' : 'No';
$info['equip'] = $info['equip'] == 1 ? 'Yes' : 'No';
$info['trade'] = $info['trade'] == 1 ? 'Yes' : 'No';
    echo '<tr>';
    echo '<td class="tablebottom"><a href="' . $_SERVER['SCRIPT_NAME'] . '?id=' . $info['id'] . '"><img src="/img/idbimg/' . $info['image'] . '" alt="Zybez Runescape Help\'s ' . $info['name'] .' image" width="50" height="50" /></a></td>';
    echo '<td class="tablebottom"><a href="' . $_SERVER['SCRIPT_NAME'] . '?id=' . $info['id'] . '">' . $info['name'] . '</a></td>' . NL;
    echo '<td class="tablebottom">' . $info['member'] . '</td>';
    echo '<td class="tablebottom">' . $info['trade'] . '</td>';

    $quest = strip_tags($info['quest']);
    if (strlen($quest) > 20)
      {
       $quest = substr($quest,0,20) . '...';
      }
    echo '<td class="tablebottom">' . $quest . '</td>';
    echo '</tr>';
  }
} 

  if($row_count == 0 or $page <= 0 or $page > $page_count)
   {
   $result = $db->query("SELECT name, id FROM `items` WHERE soundex(name) = soundex('".addslashes($search_term)."') LIMIT 0,1");
    echo '<tr>';
    echo '<td class="tablebottom" colspan="5">Sorry, no items match your search criteria.';
    if ($db->num_rows("SELECT name, id FROM `items` WHERE soundex(name) = soundex('".addslashes($search_term)."') LIMIT 0,1") > 0) {
   while($info = $db->fetch_array($result))   {
   if($info['id'] != 950) echo ' Perhaps you meant <a href="'.$_SERVER['SCRIPT_NAME'].'?search_area=name&amp;search_term='.$info['name'].'">'.$info['name'].'</a>?'; }
    }
    echo '</td></tr>';
    
    /*if(!empty($search_term) && $search_area == 'name') {
   	$time_allowed = $area == 'items' ? time() : time() + ( $time_lim * 60 );
			$ip_address = $_SERVER['REMOTE_ADDR'];
        $db->query("UPDATE `corrections_ip` SET status = 1, status_expire = " . $time_allowed . " WHERE ip = '" . $ip_address . "'");
				if( mysql_affected_rows() == 0 ) {
				
					$db->query("INSERT INTO `corrections_ip` ( `ip`, `status`, `status_expire` ) VALUES ( '" . $ip_address . "', '1', '" . $time_allowed . "' )");
				}
				
        $db->query("INSERT INTO `helpdb`.`corrections` (`ip`, `text` ,`cor_table` ,`cor_id` ,`time`) VALUES ('".$ip_address."', 'Search ".addslashes($search_area) . ' for ' . addslashes($search_term)."', 'items', '5577', NOW())");
        }*/
        
  }
        
  }
  echo '</table><br />';

  if($page_count > 1)
   {
    echo '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>';
    echo '<td align="left"><form action="' . $_SERVER['SCRIPT_NAME'] . '" method="get">Jump to page';
    echo ' <input type="text" name="page" size="3" maxlength="3" />';
    echo '<input type="hidden" name="order" value="' . $order . '" />';
    echo '<input type="hidden" name="category" value="' . $category . '" />';
    echo '<input type="hidden" name="search_area" value="' . $search_area . '" />';
    echo '<input type="hidden" name="search_term" value="' . $search_term . '" />';
    echo ' <input type="submit" value="Go" /></form></td>';
    echo '<td align="right">' . $page_links . '</td></tr>';
    echo '<tr><td colspan="2" align="right" width="140">Page ' . $page . ' of ' . $page_count . '</td></tr>';
    echo '</table>';
  }

  }
  else
  {
        $info = $db->fetch_row("SELECT * FROM `items` WHERE `type` != 0 AND `id` = " . $id);
        $type = $info['type'];
        
        if($info['trade'] == 1) {
			
		$price = $db->fetch_row("SELECT price_high, price_low, id FROM price_items WHERE phold_id = 0 AND name='".addslashes($info['name'])."' LIMIT 1");
		
		if(!isset($price['id'])) {
		// $pricelist = '<a href="/priceguide.php?search_terms=' . $info['name'] . '&amp;search_area=1&amp;price_low=&amp;price_high=&amp;member=1" title="Click here to view ' . $info['name'] . '\'s Price">Click here</a>';
		}
		else {
		echo '
<script type="text/javascript">
function km(kString)
{
  mulby = 1;
  if(kString.indexOf("m")>0 || kString.indexOf("M")>0){
  kString = kString.replace("m", "");
  kString = kString.replace("M", "");
  mulby = 1000000;
  }
  if(kString.indexOf("k")>0 || kString.indexOf("K")>0){
  kString = kString.replace("k", "");
  kString = kString.replace("K", "");
  mulby = 1000;
  }
  kString = eval(Number(kString)*mulby);
  return kString;
}

function addCommas(nStr,rangerover,myval)
{
	if (isNaN(nStr) || nStr == 0) {	return "Input the amount you are trading."; }
	if(nStr == myval){ return rangerover; }
	nStr = Math.ceil(nStr);
	nStr += \'\';
	x = nStr.split(\'.\');
	x1 = x[0];
	x2 = x.length > 1 ? \'.\' + x[1] : \'\';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) { x1 = x1.replace(rgx, \'$1\' + \',\' + \'$2\'); 	}
	return x1 + x2 + \'gp\';
}
</script>
		';
			$price_low = number_format($price['price_low']);
			$price_high = number_format($price['price_high']);
			$prices = (empty($price_high)) ? $price_low.'gp' : $price_low.'gp - '.$price_high.'gp';
      $current_avg = $price['price_high'] == 0 ? $price['price_low'] : ( $price['price_low'] + $price['price_high'] ) / 2;
      $cost = '<input type="text" value="1" style="text-align:center;" size="4" title="Use \'K\' and \'M\' for thousands and millions." autocomplete="off" maxlength="6" onkeyup="javascript:document.getElementById(\'item_'.$id.'\').innerHTML = addCommas(eval(km(this.value)*'.$current_avg.'),range_'.$id.',myval_'.$id.');" name="prices" />';
			$prices = '<script type="text/javascript">range_'.$id.' = "'.$prices.'"; myval_'.$id.' = "'.$current_avg.'"</script><div style="display:inline;" id="item_'.$id.'">'.$prices.'</div>';
			$graph = '<a href="/graphs/price.php?id='.$price['id'].'" '.$graphjs.' title="Runescape Item Price History"><img src="/img/stats.gif" alt="Price History" border="0" /></a>';
			$en_url = base64_encode($_SERVER['QUERY_STRING']);
			if($price['id'] != 0) {
			$pricelist = $cost . ' ' . $prices.' <a href="priceguide.php?report='.$price['id'].'&amp;par='.$en_url.'" title="Report Incorrect Price"><img src="/img/!.gif" alt="[!]" border="0" /></a> ' . $graph;
			}
			else {
			$pricelist = $cost . ' ' . $prices.' <a href="priceguide.php?report='.$price['id'].'&amp;par='.$en_url.'" title="Report Incorrect Price"><img src="/img/!.gif" alt="[!]" border="0" /></a>';
			}
		}
        }
?>

<div style="margin:1pt; font-size:large; font-weight:bold;">
&raquo; <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">OSRS Item Database</a> &raquo; <u><?php echo $info['name']; ?></u></div>
<hr class="main" noshade="noshade" />

<?php
echo '<center><a href="/correction.php?area=items&amp;id=' . $id . '" title="Submit a Correction"><img src="/img/correct.gif" vspace="5" alt="Submit Correction" border="0" /></a></center>';
$info['weight'] = $info['weight'] == -21.0 ? '0' : $info['weight'];
$info['member'] = $info['member'] == 1 ? 'Yes' : 'No';
$info['equip'] = $info['equip'] == 1 ? 'Yes' : 'No';
$info['trade'] = $info['trade'] == 1 ? 'Yes' : 'No';
$info['stack'] = $info['stack'] == 1 ? 'Yes' : 'No';

$quests = explode(';',$info['quest']);
$qid[0] = $db->fetch_row("SELECT `id`,`name` FROM `quests` WHERE `name` = '".addslashes($quests[0])."'");
for($num = 1; array_key_exists($num, $quests); $num++) { $qid[$num] = $db->fetch_row("SELECT `id` FROM `quests` WHERE `name` = '".addslashes(trim($quests[$num]))."'"); }
foreach($quests as $key => $var) {
	if($qid[$key]['id'] == ''){ $questlist .= trim($var).', ';
	}else{
		$questlist .= '<a href="/quests.php?id='.$qid[$key]['id'].'">' . trim($var) . '</a>, ';
	}
}
$questlist = substr($questlist, 0, -2);

   $ftime = $info['time'];
	 $date = date( 'l F jS, Y', $ftime );
  
  /* Change the query to suit certain items */
  if(stripos($info['keyword'],'herb seed')>0) {
    $mquery = $db->query("SELECT name, id FROM monsters WHERE drops LIKE '%herb seed%' OR i_drops LIKE '%herb seed%' ORDER BY combat ASC");
  }
  elseif(stripos($info['keyword'],'recipe for disaster')>0) {
    $mquery = $db->query("SELECT name, id FROM monsters WHERE drops = 'recipe for disaster glove'");
  }
  elseif(stripos($info['keyword'],'half of a key')>0) {
    $mquery = $db->query("SELECT name, id FROM monsters WHERE drops LIKE '%half of a key%'");
  }
  elseif(substr($info['name'],0,5) == 'grimy') {
    $mquery = $db->query("SELECT name, id FROM monsters WHERE drops LIKE '%grimy herb%' GROUP BY name");
  }
  elseif($info['name'] == 'Dragon bones') {
    $mquery = $db->query("SELECT name, id FROM monsters WHERE drops LIKE '%dragon bone%' AND `drops` not like '%baby%'  GROUP BY name");
  }
  elseif($info['name'] == 'Oil lamp') {
    $mquery = $db->query("SELECT name, id FROM monsters WHERE drops LIKE '%oil lamp%' GROUP BY name");
  }
  elseif(stripos($info['name'],'lamp')>0) {
    $mquery = '';
  }
  else {
    $search = addslashes($info['name']);
	if ($search==""){
 $mquery = $db->query("SELECT name, id FROM monsters WHERE id NOT IN (3488) GROUP BY name ORDER BY combat ASC LIMIT 18");
}
else{
    $mquery = $db->query("SELECT name, id FROM monsters WHERE id NOT IN (3488) AND (drops LIKE '%" . $search . "%' OR i_drops LIKE '%" . $search . "%') GROUP BY name ORDER BY combat ASC LIMIT 18");
}  
}
  
  $s=0;
  while($minfo = $db->fetch_array($mquery)) {
        $s++;
        if($s<16){ // If more than 16 monsters that drop this, then instead show a "... more". If this is changed, make sure the LIMIT in the query above is also changed accordingly and kept higher than than this number
			
			$droplist .= '<a href="/monsters.php?id='.$minfo['id'].'" title="Runescape Monster: '.$minfo['name'].'">'.$minfo['name'].'</a>, ';
		}
  }
  
  /*Display Monsters that drop this item */
  $more = '';
  if(@mysqli_num_rows($mquery) > 15 && !empty($droplist)) {
  if(stripos($info['keyword'],'half of a key')>0)  {
      $more = ' <a href="/monsters.php?search_area=drops&amp;search_term=half of a key">... more &raquo;</a>';
  }
  else {
      $more = ' <a href="/monsters.php?search_area=drops&amp;search_term='.addslashes($info['name']) . '">... more &raquo;</a>';
  }
  }
  $droplist = substr($droplist, 0, -2) . $more;
  
/* Attack/Defence Bonuses */
  $att = explode('|',$info['att']);
  $def = explode('|',$info['def']);
  $other = explode('|',$info['otherb']);
  
  $att[0] = empty($att[0]) ? '+0' . $att[0] : ($att[0] = $att[0] >= 0 ? '+' . $att[0] : $att[0]);
  $def[0] = empty($def[0]) ? '+0' . $def[0] : ($def[0] = $def[0] >= 0 ? '+' . $def[0] : $def[0]);
  $other[0] = empty($other[0]) ? '+0' . $other[0] : ($other[0] = $other[0] >= 0 ? '+' . $other[0] : $other[0]);
	for($num = 1; $num<6; $num++) {
	$att[$num] = $att[$num] >= 0 ? '+' . $att[$num] : $att[$num];
	$def[$num] = $def[$num] >= 0 ? '+' . $def[$num] : $def[$num];
	$other[$num] = $other[$num] >= 0 ? '+' . $other[$num] : $other[$num];
}

$picture = $db->fetch_row("SELECT p.jagex_pid FROM price_items p JOIN items i ON p.id=i.pid WHERE i.id = " . $id);
if(!empty($picture)) $big_pic = '<img src="/img/idbimgb/' . $picture . '.gif" alt="Picture of ' . $info['name'] . '" />';
else $big_pic = '&nbsp;';

  if ($type == 1) {
    echo '<table border="0" cellspacing="5" cellpadding="0" style="width:76%;margin:0 12%;" ><tr><td style="vertical-align:top;width:70%">';
    echo '<table cellspacing="0" cellpadding="4" style="width:100%;border:1px solid #000;border-top:none">';
    echo '<tr><td colspan="4" class="tabletop" style="border-right:none">' . $info['name'] . '</td></tr>';
    echo '<tr><td align="center" rowspan="8" width="100" style="border:none;border-right:1px solid #000"><img src="/img/idbimg/' . $info['image'] . '" alt="Picture of ' . $info['name'] . '" /></td></tr>';
    echo '<tr><td width="25%">Members:</td><td>' . $info['member'] . '</td>'
        .'<td rowspan="5" style="width:96px;">' . $big_pic . '</td></tr>';
    echo '<tr><td>Tradable:</td><td>' . $info['trade'] . '</td></tr>';
    echo '<tr><td>Equipable:</td><td>' . $info['equip'] . '</td></tr>';
    echo '<tr><td>Stackable:</td><td>' . $info['stack'] . '</td></tr>';
    echo '<tr><td>Weight:</td><td>' . $info['weight'] . 'kg</td></tr>';
    echo '<tr><td style="vertical-align:top;">Quest:</td><td colspan="2">' . $questlist . '</td></tr>';
    echo '<tr><td style="vertical-align:top;">Examine:</td><td colspan="2">' . $info['examine'] . '</td></tr></table>';
    echo '<br /><table cellspacing="0" cellpadding="4" style="width:100%;border:1px solid #000">';

if($info['trade']=="Yes") {
	$j36 = strtolower(str_replace(" ","-",$info['name']));
	if($info['pricelink']=='' || $info['pricelink']=='0'){ $info['pricelink'] = $info['id']; }
    /* echo '<tr><td width="35%">Market Price:</td><td width="70%"><a href="http://forums.zybez.net/runescape-2007-prices/'.$info['pricelink'].'-'.$j36.'">View latest buy/sell offers.</a></td></tr>';  */  
    echo '<tr><td width="35%">High Alchemy:</td><td width="70%">' . number_format($info['highalch']) . 'gp</td></tr>';
    echo '<tr><td>Low Alchemy:</td><td>' . number_format($info['lowalch']) . 'gp</td></tr>';
    echo '<tr><td>Sell to General Store:</td><td>' . number_format($info['sellgen']) . 'gp</td></tr>';
    echo '<tr><td>Buy from General Store:</td><td>' . number_format($info['buygen']) . 'gp</td></tr>';
	
}
else {
    //echo '<tr><td width="35%">Market Price:</td><td>Not Applicable</td></tr>';
    echo '<tr><td width="35%">High Alchemy:</td><td>' . $info['highalch'] . 'gp</td></tr>';
    echo '<tr><td>Low Alchemy:</td><td>' . $info['lowalch'] . 'gp</td></tr>';
}
    echo '</table></td><td style="vertical-align:top;">';
    echo '<table cellspacing="0" cellpadding="0" style="width:100%;border:none;">';
    echo '<tr><td class="boxtop"><b>Attack Bonuses</b></td></tr>';
    echo '<tr><td class="boxbottom">Stab: '.$att[0].'<br />Slash: '.$att[1].'<br />Crush: '.$att[2].'<br />Magic: '.$att[3].'<br />Range: '.$att[4].'</td></tr><tr><td style="height:4px"></td></tr>';
    echo '<tr><td class="boxtop"><b>Defence Bonuses</b></td></tr>';
    echo '<tr><td class="boxbottom">Stab: '.$def[0].'<br />Slash: '.$def[1].'<br />Crush: '.$def[2].'<br />Magic: '.$def[3].'<br />Range: '.$def[4].'</td></tr><tr><td style="height:4px"></td></tr>';
    echo '<tr><td class="boxtop"><b>Other Bonuses</b></td></tr>';
    echo '<tr><td class="boxbottom">Strength: '.$other[0].'<br />Ranged Strength: '.$other[2].'<br />Prayer: '.$other[1].'</td></tr>';
    echo '</table></td></tr><tr><td colspan="2">';
    echo '<table cellspacing="0" cellpadding="4" style="width:100%;border:1px solid #000">';
    echo '<tr><td width="24%">Obtained From:</td><td>' . $info['obtain'] . '</td></tr>';
    echo '<tr><td style="vertical-align:top;">Notes:</td><td>' . $info['notes'] . '</td></tr>';
if(!empty($droplist)) {
    echo '<tr><td style="vertical-align:top;" title="Up to 15 of lowest level droppers">Dropped By:</td><td>' . $droplist . '</td></tr>';
    }
    echo '<tr><td style="vertical-align:top;">Credits:</td><td>' . $info['credits'] . '</td></tr>';
    echo '<tr><td>Last Modified:</td><td>' . $date . '</td></tr></table>';
    echo '</td></tr></table>';
 } 
 else if ($type == 2) {
	
    echo '<table cellspacing="0" cellpadding="4" style="width:76%;margin:0 12%;border: 1px solid #000; border-top: none">';
    echo '<tr><td colspan="3" class="tabletop" style="border-right:none">' . $info['name'] . '</td></tr>';
    echo '<tr><td align="center" rowspan="8" width="100" style="border:none;border-right:1px solid #000"><img src="/img/idbimg/' . $info['image'] . '" alt="Picture of ' . $info['name'] . '" /></td></tr>';
    echo '<tr><td width="30%">Members:</td><td>' . $info['member'] . '</td></tr>';
    echo '<tr><td>Tradable:</td><td>' . $info['trade'] . '</td></tr>';
    echo '<tr><td>Equipable:</td><td>' . $info['equip'] . '</td></tr>';
    echo '<tr><td>Stackable:</td><td>' . $info['stack'] . '</td></tr>';
    echo '<tr><td>Weight:</td><td>' . $info['weight'] . 'kg</td></tr>';
    echo '<tr><td style="vertical-align:top;">Quest:</td><td>'.$questlist.'</td></tr>';
    echo '<tr><td style="vertical-align:top;">Examine:</td><td>' . $info['examine'] . '</td></tr>';
    echo '</table><br />';
    echo '<table cellspacing="0" cellpadding="4" style="width:76%;margin:0 12%;border: 1px solid #000">';
if($info['trade']=="Yes") {
	$j36 = strtolower(str_replace(" ","-",$info['name']));
	if($info['pricelink']=='' || $info['pricelink']=='0'){ $info['pricelink'] = $info['id']; }
   /* echo '<tr><td width="35%">Market Price:</td><td width="70%"><a href="http://forums.zybez.net/runescape-2007-prices/'.$info['pricelink'].'-'.$j36.'">View latest buy/sell offers.</a></td></tr>';    */
    echo  '<tr><td width="35%">High Alchemy:</td><td width="70%">' . number_format($info['highalch']) . 'gp</td></tr>';
    echo '<tr><td>Low Alchemy:</td><td>' . number_format($info['lowalch']) . 'gp</td></tr>';
    echo '<tr><td>Sell to General Store:</td><td>' . number_format($info['sellgen']) . 'gp</td></tr>';
    echo '<tr><td>Buy from General Store:</td><td>' . number_format($info['buygen']) . 'gp</td></tr>';
	
}
else {
    //echo '<tr><td width="35%">Market Price:</td><td>Not Applicable</td></tr>';
    echo '<tr><td width="35%">High Alchemy:</td><td>' . $info['highalch'] . 'gp</td></tr>';
    echo '<tr><td>Low Alchemy:</td><td>' . $info['lowalch'] . 'gp</td></tr>';
}	
    echo '<tr><td width="20%">Obtained From: </td><td>' . $info['obtain'] . '</td></tr>';
    echo '<tr><td style="vertical-align:top;">Keep/Drop:</td><td>' . $info['keepdrop'] . '</td></tr>';
    echo '<tr><td style="vertical-align:top;">Retrieval:</td><td>' . $info['retrieve'] . '</td></tr>';
    echo '<tr><td style="vertical-align:top;">Quest Use:</td><td>' . $info['questuse'] . '</td></tr>';
    echo '<tr><td style="vertical-align:top;">Notes:</td><td>' . $info['notes'] . '</td></tr></table>';
    echo '<br /><table cellspacing="0" cellpadding="4" style="width:76%;margin:0 12%;border: 1px solid #000">';
    echo '<tr><td style="width:20%;vertical-align:top;">Credits: </td><td>' . $info['credits'] . '</td></tr>';
    echo '<tr><td>Last Modified:</td><td>' . $date . '</td></tr></table>';
 } 
 else if ($type == 3) {
    echo '<table cellspacing="0" cellpadding="4" style="width:76%;margin:0 12%;border:1px solid #000;border-top:none">';
    echo '<tr><td colspan="4" class="tabletop" style="border-right:none">' . $info['name'] . '</td></tr>';
    echo '<tr><td align="center" rowspan="8" width="100" style="border: none;border-right: 1px solid #000"><img src="/img/idbimg/' . $info['image'] . '" alt="Picture of ' . $info['name'] . '" /></td></tr>';
    echo '<tr><td width="25%">Members:</td><td>' . $info['member'] . '</td>'
        .'<td rowspan="5" style="width:96px;">' . $big_pic . '</td></tr>';
    echo '<tr><td>Tradable:</td><td>' . $info['trade'] . '</td></tr>';
    echo '<tr><td>Equipable:</td><td>' . $info['equip'] . '</td></tr>';
    echo '<tr><td>Stackable:</td><td>' . $info['stack'] . '</td></tr>';
    echo '<tr><td>Weight:</td><td>' . $info['weight'] . 'kg</td></tr>';
    echo '<tr><td style="vertical-align:top;">Quest:</td><td colspan="2">' . $questlist . '</td></tr>';
    echo '<tr><td style="vertical-align:top;">Examine:</td><td colspan="2">' . $info['examine'] . '</td></tr></table>';
    echo '<br />';
    echo '<table cellspacing="0" cellpadding="4" style="width:76%;margin:0 12%;border: 1px solid #000">';
if($info['trade']=="Yes") {
	$j36 = strtolower(str_replace(" ","-",$info['name']));
	if($info['pricelink']=='' || $info['pricelink']=='0'){ $info['pricelink'] = $info['id']; }
  /*  echo '<tr><td width="35%">Market Price:</td><td width="70%"><a href="http://forums.zybez.net/runescape-2007-prices/'.$info['pricelink'].'-'.$j36.'">View latest buy/sell offers.</a></td></tr>';
*/	
    echo '<tr><td>Sell to General Store:</td><td>' . number_format($info['sellgen']) . 'gp</td></tr>';
    echo '<tr><td>Buy from General Store:</td><td>' . number_format($info['buygen']) . 'gp</td></tr>';
	
}else {
    echo '<tr><td width="25%"></td></tr>';
}   echo '<tr><td width="25%">High Alchemy:</td><td>' . number_format($info['highalch']) . 'gp</td></tr>';
    echo '<tr><td>Low Alchemy:</td><td>' . number_format($info['lowalch']) . 'gp</td></tr>';
    echo '</table><br />';
    echo '<table cellspacing="0" cellpadding="4" style="width:76%;margin:0 12%;border: 1px solid #000">';
    echo '<tr><td style="width:25%;vertical-align:top;">Obtained From: </td><td>' . $info['obtain'] . '</td></tr>';
    echo '<tr><td style="vertical-align:top;">Notes:</td><td>' . $info['notes'] . '</td></tr>';
if(!empty($droplist)) {
    echo '<tr><td style="vertical-align:top;" title="Up to 15 of lowest level droppers">Dropped By:</td><td>' . $droplist . '</td></tr>';
    }
    echo '<tr><td style="vertical-align:top;">Credits: </td><td>' . $info['credits'] . '</td></tr>';
    echo '<tr><td style="vertical-align:top;">Last Modified:</td><td>' . $date . '</td></tr></table>';
 } 
  else {
   echo 'Error: Invalid Item';
  }
 echo '<br />';
 include 'search.inc.php';
 echo '<p style="text-align:center;"><a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>';
 }
?>
[#COPYRIGHT#]
</div>

<?php
end_page( $info['name'] );
?>
