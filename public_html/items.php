<?php
$cleanArr = array(  array('id', $_GET['id'] ?? null, 'int', 's' => '1,9999'),
					array('order', $_GET['order'] ?? null, 'enum', 'e' => array('DESC', 'ASC'), 'd' => 'ASC' ),
					array('page', $_GET['page'] ?? null, 'int', 's' => '1,400', 'd' => 1),
					array('category', $_GET['category'] ?? null, 'enum', 'e' => array('name', 'member', 'trade', 'quest'), 'd' => 'name' ),
					array('search_area', $_GET['search_area'] ?? null, 'enum', 'e' => array('name','quest','obtain','examine','notes','type'), 'd' => 'name' ),
					array('search_term', trim($_GET['search_term'] ?? ''), 'sql', 'l' => 40, 'd' => '')
				  );

/*** ITEM DATABASE ***/
require(dirname(__FILE__) . '/' . 'backend.php');

// Ensure database is connected before any queries
$db->connect();
$db->select_db(MYSQL_DB);

// Initialize variables to avoid undefined warnings if extract() skipped them
$search_area = $search_area ?? 'name';
$search_term = $search_term ?? '';
$id = $id ?? null;
$category = $category ?? 'name';
$order = $order ?? 'ASC';
$page = $page ?? 1;

if($disp->errlevel > 0) {
	$id = null;
	$search_area = 'name';
}

// Redirect if search returns exactly one result
if (!isset($id) && !empty($search_term)) {
    $hide_search_form = true;
    include('search.inc.php');
    if (isset($row_count) && $row_count == 1) {
        $info = $db->fetch_array($query);
        header('Location: ' . $_SERVER['SCRIPT_NAME'] . '?id=' . $info['id']);
        exit;
    }
    unset($hide_search_form);
}

start_page('OSRS RuneScape Item Database');

 echo '<script type="text/javascript" src="/graphs/popup.js"></script>';
  $graphjs = 'onclick="return popup(this,620,300,\'2px solid #fff\')"';
?>
<div class="boxtop">OSRS RuneScape Item Database</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<?php
 if(!isset($id))
  {
?>
<div style="margin:1pt; font-size:large; font-weight:bold;">&raquo; <a href="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']);?>">OSRS RuneScape Item Database</a></div>
<hr class="main" noshade="noshade" />
<br /><?php
  include('search.inc.php');
  echo '
  <table width="96%" style="margin:0 2%;" cellspacing="0" cellpadding="5">
<tr style="height:23px;font-size:13px;font-weight:bold;">
<td style="vertical-align:middle;text-align:right;"><a href="/correction.php?area=items&amp;id=4296">Submit Missing Item</a></td></tr></table><br />
  ';
  echo '<table style="margin:0 12%;border-left: 1px solid #000;" width="76%" cellpadding="1" cellspacing="0">

  <tr>';
  echo '<th class="tabletop" width="5%">Picture</th>';
  echo '<th class="tabletop">Name <a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?order=ASC&amp;category=name&amp;page=' . $page . '&amp;search_area=' . $search_area . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Name, Ascending"><img src="/img/up.GIF" width="9" height="9" alt="Sort by: Name, Ascending" border="0" /></a> <a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?order=DESC&amp;category=name&amp;search_area=' . $search_area . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Name, Descending"><img src="/img/down.GIF" width="9" height="9" alt="Sort by: Name, Descending" border="0" /></a></th>';
  
  echo '<th class="tabletop">Members <a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?order=ASC&amp;category=member&amp;page=' . $page . '&amp;search_area=' . $search_area . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Members, Ascending"><img src="/img/up.GIF" width="9" height="9" alt="Sort by: Members, Ascending" border="0" /></a> <a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?order=DESC&amp;category=member&amp;search_area=' . $search_area . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Members, Descending"><img src="/img/down.GIF" width="9" height="9" alt="Sort by: Members, Descending" border="0" /></a></th>';
  
  echo '<th class="tabletop">Tradable <a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?order=ASC&amp;category=trade&amp;page=' . $page . '&amp;search_area=' . $search_area . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Tradable, Ascending"><img src="/img/up.GIF" width="9" height="9" alt="Sort by: Tradable, Ascending" border="0" /></a> <a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?order=DESC&amp;category=trade&amp;search_area=' . $search_area . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Tradable, Descending"><img src="/img/down.GIF" width="9" height="9" alt="Sort by: Tradable, Descending" border="0" /></a></th>';
  
  echo '<th class="tabletop">Quest <a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?order=ASC&amp;category=quest&amp;page=' . $page . '&amp;search_area=' . $search_area . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Quest, Ascending"><img src="/img/up.GIF" width="9" height="9" alt="Sort by: Quest, Ascending" border="0" /></a> <a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?order=DESC&amp;category=quest&amp;search_area=' . $search_area . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Quest, Descending"><img src="/img/down.GIF" width="9" height="9" alt="Sort by: Quest, Descending" border="0" /></a></th>';
  echo '</tr>';

while($info = $db->fetch_array($query))   {
$info['member'] = ($info['member'] ?? 0) == 1 ? 'Yes' : 'No';
$info['equip'] = ($info['equip'] ?? 0) == 1 ? 'Yes' : 'No';
$info['trade'] = ($info['trade'] ?? 0) == 1 ? 'Yes' : 'No';
    echo '<tr>';
    echo '<td class="tablebottom"><a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?id=' . (int)$info['id'] . '"><img src="/img/idbimg/' . htmlspecialchars($info['image'] ?? '') . '" alt="Zybez Runescape Help\'s ' . htmlspecialchars($info['name'] ?? '') .' image" width="50" height="50" /></a></td>';
    echo '<td class="tablebottom"><a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?id=' . (int)$info['id'] . '">' . htmlspecialchars($info['name'] ?? '') . '</a></td>' . NL;
    echo '<td class="tablebottom">' . htmlspecialchars($info['member']) . '</td>';
    echo '<td class="tablebottom">' . htmlspecialchars($info['trade']) . '</td>';

    $quest = strip_tags($info['quest'] ?? '');
    if (strlen($quest) > 20)
      {
       $quest = substr($quest,0,20) . '...';
      }
    echo '<td class="tablebottom">' . htmlspecialchars($quest) . '</td>';
    echo '</tr>';
}

  if($row_count == 0 || $page <= 0 || $page > $page_count)
   {
   $result = $db->query("SELECT name, id FROM `items` WHERE soundex(name) = soundex('" . $db->escape_string($search_term) . "') LIMIT 0,1");
    echo '<tr>';
    echo '<td class="tablebottom" colspan="5">Sorry, no items match your search criteria.';
    if ($db->num_rows("SELECT name, id FROM `items` WHERE soundex(name) = soundex('" . $db->escape_string($search_term) . "') LIMIT 0,1") > 0) {
   while($info = $db->fetch_array($result))   {
   if($info['id'] != 950) echo ' Perhaps you meant <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?search_area=name&amp;search_term='.urlencode($info['name']).'">'.htmlspecialchars($info['name']).'</a>?'; } 
    }
    echo '</td></tr>';
  }
        
  echo '</table><br />';

  if($page_count > 1)
   {
    echo '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>';
    echo '<td align="left"><form action="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '" method="get">Jump to page';
    echo ' <input type="text" name="page" size="3" maxlength="3" />';
    echo '<input type="hidden" name="order" value="' . htmlspecialchars($order) . '" />';
    echo '<input type="hidden" name="category" value="' . htmlspecialchars($category) . '" />';
    echo '<input type="hidden" name="search_area" value="' . htmlspecialchars($search_area) . '" />';
    echo '<input type="hidden" name="search_term" value="' . htmlspecialchars($search_term, ENT_QUOTES) . '" />';
    echo ' <input type="submit" value="Go" /></form></td>';
    echo '<td align="right">' . $page_links . '</td></tr>';
    echo '<tr><td colspan="2" align="right" width="140">Page ' . (int)$page . ' of ' . (int)$page_count . '</td></tr>';
    echo '</table>';
  }

  }
  else
  {
        $info = $db->fetch_row("SELECT * FROM `items` WHERE `type` != 0 AND `id` = " . (int)$id);
        if (!$info) {
            echo 'Error: Invalid Item';
        } else {
        $type = $info['type'] ?? '';
        
        if(($info['trade'] ?? 0) == 1) {
			
		$price = $db->fetch_row("SELECT price_high, price_low, id FROM price_items WHERE phold_id = 0 AND name='" . $db->escape_string($info['name'] ?? '') . "' LIMIT 1");
		
		        if(isset($price['id'])) {
				?>
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
			if (isNaN(nStr) || nStr == 0) { 	return "Input the amount you are trading."; }
			if(nStr == myval){ return rangerover; }
			nStr = Math.ceil(nStr);
			nStr += "";
			x = nStr.split(".");
			x1 = x[0];
			x2 = x.length > 1 ? "." + x[1] : "";
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) { x1 = x1.replace(rgx, '$1' + "," + '$2'); 	}
			return x1 + x2 + "gp";
		}
		</script>
		<?php
					$price_low = number_format($price['price_low']);
			$price_high = number_format($price['price_high']);

			$prices = (empty($price_high)) ? $price_low.'gp' : $price_low.'gp - '.$price_high.'gp';

      $current_avg = $price['price_high'] == 0 ? $price['price_low'] : ( $price['price_low'] + $price['price_high'] ) / 2;

      $cost = '<input type="text" value="1" style="text-align:center;" size="4" title="Use \'K\' and \'M\' for thousands and millions." autocomplete="off" maxlength="6" onkeyup="javascript:document.getElementById(\'item_'.$id.'\').innerHTML = addCommas(eval(km(this.value)*'.$current_avg.'),range_'.$id.',myval_'.$id.');" name="prices" />';

			$prices = '<script type="text/javascript">range_'.$id.' = "'.$prices.'"; myval_'.$id.' = "'.$current_avg.'"</script><div style="display:inline;" id="item_'.$id.'">'.$prices.'</div>';

			$graph = '<a href="/graphs/price.php?id='.$price['id'].'" '.$graphjs.' title="Runescape Item Price History"><img src="/img/stats.gif" alt="Price History" border="0" /></a>';

			$en_url = base64_encode($_SERVER['QUERY_STRING']);

			if($price['id'] != 0) {

			$pricelist = $cost . ' ' . $prices.' <a href="priceguide.php?report='.$price['id'].'&amp;par='.$en_url.'" title="Report Incorrect Price"><img src="/img/!.gif" alt="[!" border="0" /></a> ' . $graph;

			} else {

			$pricelist = $cost . ' ' . $prices.' <a href="priceguide.php?report='.$price['id'].'&amp;par='.$en_url.'" title="Report Incorrect Price"><img src="/img/!.gif" alt="[!" border="0" /></a>';

			}

		}

        }

?>



<div style="margin:1pt; font-size:large; font-weight:bold;">
&raquo; <a href="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>">OSRS RuneScape Item Database</a> &raquo; <u><?php echo htmlspecialchars($info['name'] ?? ''); ?></u></div>
<hr class="main" noshade="noshade" />



<?php

$info['weight'] = ($info['weight'] ?? 0) == -21.0 ? '0' : $info['weight'];

$info['member'] = ($info['member'] ?? 0) == 1 ? 'Yes' : 'No';

$info['equip'] = ($info['equip'] ?? 0) == 1 ? 'Yes' : 'No';

$info['trade'] = ($info['trade'] ?? 0) == 1 ? 'Yes' : 'No';

$info['stack'] = ($info['stack'] ?? 0) == 1 ? 'Yes' : 'No';



$quests = explode(';',$info['quest'] ?? '');

$qid = array();

$questlist = '';

foreach($quests as $var) {

    $var = trim($var);

    if (empty($var)) continue;

    $qinfo = $db->fetch_row("SELECT `id`,`name` FROM `quests` WHERE `name` = '" . $db->escape_string($var) . "'");

	if(!$qinfo){ $questlist .= htmlspecialchars($var).', ';

	}else{

		$questlist .= '<a href="/quests.php?id=' . (int)$qinfo['id'] . '">' . htmlspecialchars($var) . '</a>, ';

	}

}

$questlist = substr($questlist, 0, -2);



   $ftime = $info['time'] ?? 0;

	 $date = date( 'l F jS, Y', $ftime );
  
  /* Change the query to suit certain items */
  $mquery = null;
  if(stripos($info['keyword'] ?? '','herb seed') !== false) {
    $mquery = $db->query("SELECT name, id FROM monsters WHERE drops LIKE '%herb seed%' OR i_drops LIKE '%herb seed%' ORDER BY combat ASC");
  }
  elseif(stripos($info['keyword'] ?? '','recipe for disaster') !== false) {
    $mquery = $db->query("SELECT name, id FROM monsters WHERE drops = 'recipe for disaster glove'");
  }
      elseif(stripos($info['keyword'] ?? '','half of a key') !== false) {
        $mquery = $db->query("SELECT name, id FROM monsters WHERE drops LIKE '%half of a key%'");
      }  elseif(substr($info['name'] ?? '',0,5) == 'grimy') {
    $mquery = $db->query("SELECT name, id FROM monsters WHERE drops LIKE '%grimy herb%' GROUP BY name");
  }
  elseif(($info['name'] ?? '') == 'Dragon bones') {
    $mquery = $db->query("SELECT name, id FROM monsters WHERE drops LIKE '%dragon bone%' AND `drops` not like '%baby%'  GROUP BY name");
  }
  elseif(($info['name'] ?? '') == 'Oil lamp') {
    $mquery = $db->query("SELECT name, id FROM monsters WHERE drops LIKE '%oil lamp%' GROUP BY name");
  }
  elseif(stripos($info['name'] ?? '','lamp') !== false) {
    $mquery = '';
  }
  else {
    $search = $info['name'] ?? '';
	if ($search==""){
 $mquery = $db->query("SELECT name, id FROM monsters WHERE id NOT IN (3488) GROUP BY name ORDER BY combat ASC LIMIT 18");
}
else{
    $mquery = $db->query("SELECT name, id FROM monsters WHERE id NOT IN (3488) AND (drops LIKE '%" . $db->escape_string($search) . "%' OR i_drops LIKE '%" . $db->escape_string($search) . "%') GROUP BY name ORDER BY combat ASC LIMIT 18");
}
}
  
  $s=0;
  $droplist = '';
  if ($mquery) {
      while($minfo = $db->fetch_array($mquery)) {
            $s++;
            if($s<16){ 
                $droplist .= '<a href="/monsters.php?id='.(int)$minfo['id'].'" title="Runescape Monster: '.htmlspecialchars($minfo['name']).'">'.htmlspecialchars($minfo['name']).'</a>, ';
            }
      }
  }
  
  /*Display Monsters that drop this item */
  $more = '';
  if($mquery && mysqli_num_rows($mquery) > 15 && !empty($droplist)) {
  if(stripos($info['keyword'] ?? '','half of a key') !== false)  {
      $more = ' <a href="/monsters.php?search_area=drops&amp;search_term=half of a key">... more &raquo;</a>';
  }
  else {
      $more = ' <a href="/monsters.php?search_area=drops&amp;search_term='.urlencode($info['name'] ?? '') . '">... more &raquo;</a>';
  }
  }
  $droplist = substr($droplist, 0, -2) . $more;
  
/* Attack/Defence Bonuses */
  $att = explode('|',$info['att'] ?? '');
  $def = explode('|',$info['def'] ?? '');
  $other = explode('|',$info['otherb'] ?? '');
  
  for($num = 0; $num < 5; $num++) {
      if (!isset($att[$num]) || $att[$num] === '') $att[$num] = 0;
      if (!isset($def[$num]) || $def[$num] === '') $def[$num] = 0;
      $att[$num] = $att[$num] >= 0 ? '+' . $att[$num] : $att[$num];
      $def[$num] = $def[$num] >= 0 ? '+' . $def[$num] : $def[$num];
  }
  for($num = 0; $num < 3; $num++) {
      if (!isset($other[$num]) || $other[$num] === '') $other[$num] = 0;
      $other[$num] = $other[$num] >= 0 ? '+' . $other[$num] : $other[$num];
  }

$picture_row = $db->fetch_row("SELECT p.jagex_pid FROM price_items p JOIN items i ON p.id=i.pid WHERE i.id = " . (int)$id);
if(!empty($picture_row)) $big_pic = '<img src="/img/idbimgb/' . htmlspecialchars($picture_row['jagex_pid']) . '.gif" alt="Picture of ' . htmlspecialchars($info['name'] ?? '') . '" />';
else $big_pic = '&nbsp;';

  if ($type == 1) {
    echo '<table border="0" cellspacing="5" cellpadding="0" style="width:76%;margin:0 12%;" ><tr><td style="vertical-align:top;width:70%">';
    echo '<table cellspacing="0" cellpadding="4" style="width:100%;border:1px solid #000;border-top:none">';
    echo '<tr><td colspan="4" class="tabletop" style="border-right:none">' . htmlspecialchars($info['name'] ?? '') . '</td></tr>';
    echo '<tr><td align="center" rowspan="8" width="100" style="border:none; border-right:1px solid #000"><img src="/img/idbimg/' . htmlspecialchars($info['image'] ?? '') . '" alt="Picture of ' . htmlspecialchars($info['name'] ?? '') . '" /></td></tr>';
    echo '<tr><td width="25%">Members:</td><td>' . htmlspecialchars($info['member']) . '</td>'
        .'<td rowspan="5" style="width:96px;">' . ($big_pic ?? '') . '</td></tr>';
    echo '<tr><td>Tradable:</td><td>' . htmlspecialchars($info['trade']) . '</td></tr>';
    echo '<tr><td>Equipable:</td><td>' . htmlspecialchars($info['equip']) . '</td></tr>';
    echo '<tr><td>Stackable:</td><td>' . htmlspecialchars($info['stack']) . '</td></tr>';
    echo '<tr><td>Weight:</td><td>' . htmlspecialchars($info['weight'] ?? '') . 'kg</td></tr>';
    echo '<tr><td style="vertical-align:top;">Quest:</td><td colspan="2">' . $questlist . '</td></tr>';
    echo '<tr><td style="vertical-align:top;">Examine:</td><td colspan="2">' . htmlspecialchars($info['examine'] ?? '') . '</td></tr></table>';
    echo '<br /><table cellspacing="0" cellpadding="4" style="width:100%;border:1px solid #000">';

if($info['trade']=='Yes') {
    echo '<tr><td width="35%">High Alchemy:</td><td width="70%">' . number_format($info['highalch'] ?? 0) . 'gp</td></tr>';
    echo '<tr><td>Low Alchemy:</td><td>' . number_format($info['lowalch'] ?? 0) . 'gp</td></tr>';
    echo '<tr><td>Sell to General Store:</td><td>' . number_format($info['sellgen'] ?? 0) . 'gp</td></tr>';
    echo '<tr><td>Buy from General Store:</td><td>' . number_format($info['buygen'] ?? 0) . 'gp</td></tr>';
	
}
else {
    echo '<tr><td width="35%">High Alchemy:</td><td>' . htmlspecialchars($info['highalch'] ?? '') . 'gp</td></tr>';
    echo '<tr><td>Low Alchemy:</td><td>' . htmlspecialchars($info['lowalch'] ?? '') . 'gp</td></tr>';
}
    echo '</table></td><td style="vertical-align:top;">';
    echo '<table cellspacing="0" cellpadding="0" style="width:100%;border:none;">';
    echo '<tr><td class="boxtop"><b>Attack Bonuses</b></td></tr>';
    echo '<tr><td class="boxbottom">Stab: '.htmlspecialchars($att[0]).'<br />Slash: '.htmlspecialchars($att[1]).'<br />Crush: '.htmlspecialchars($att[2]).'<br />Magic: '.htmlspecialchars($att[3]).'<br />Range: '.htmlspecialchars($att[4]).'</td></tr><tr><td style="height:4px"></td></tr>';
    echo '<tr><td class="boxtop"><b>Defence Bonuses</b></td></tr>';
    echo '<tr><td class="boxbottom">Stab: '.htmlspecialchars($def[0]).'<br />Slash: '.htmlspecialchars($def[1]).'<br />Crush: '.htmlspecialchars($def[2]).'<br />Magic: '.htmlspecialchars($def[3]).'<br />Range: '.htmlspecialchars($def[4]).'</td></tr><tr><td style="height:4px"></td></tr>';
    echo '<tr><td class="boxtop"><b>Other Bonuses</b></td></tr>';
    echo '<tr><td class="boxbottom">Strength: '.htmlspecialchars($other[0]).'<br />Ranged Strength: '.htmlspecialchars($other[2]).'<br />Prayer: '.htmlspecialchars($other[1]).'</td></tr>';
    echo '</table></td></tr><tr><td colspan="2">';
    echo '<table cellspacing="0" cellpadding="4" style="width:100%;border:1px solid #000">';
    echo '<tr><td width="24%">Obtained From:</td><td>' . htmlspecialchars($info['obtain'] ?? '') . '</td></tr>';
    echo '<tr><td style="vertical-align:top;">Notes:</td><td>' . htmlspecialchars($info['notes'] ?? '') . '</td></tr>';
if(!empty($droplist)) {
    echo '<tr><td style="vertical-align:top;" title="Up to 15 of lowest level droppers">Dropped By:</td><td>' . $droplist . '</td></tr>';
    }
    echo '<tr><td style="vertical-align:top;">Credits:</td><td>' . htmlspecialchars($info['credits'] ?? '') . '</td></tr>';
    echo '<tr><td>Last Modified:</td><td>' . $date . '</td></tr></table>';
    echo '</td></tr></table>';
 }
 else if ($type == 2) {
	
    echo '<table cellspacing="0" cellpadding="4" style="width:76%;margin:0 12%;border: 1px solid #000; border-top: none">';
    echo '<tr><td colspan="3" class="tabletop" style="border-right:none">' . htmlspecialchars($info['name'] ?? '') . '</td></tr>';
    echo '<tr><td align="center" rowspan="8" width="100" style="border:none; border-right:1px solid #000"><img src="/img/idbimg/' . htmlspecialchars($info['image'] ?? '') . '" alt="Picture of ' . htmlspecialchars($info['name'] ?? '') . '" /></td></tr>';
    echo '<tr><td width="30%">Members:</td><td>' . htmlspecialchars($info['member']) . '</td></tr>';
    echo '<tr><td>Tradable:</td><td>' . htmlspecialchars($info['trade']) . '</td></tr>';
    echo '<tr><td>Equipable:</td><td>' . htmlspecialchars($info['equip']) . '</td></tr>';
    echo '<tr><td>Stackable:</td><td>' . htmlspecialchars($info['stack']) . '</td></tr>';
    echo '<tr><td>Weight:</td><td>' . htmlspecialchars($info['weight'] ?? '') . 'kg</td></tr>';
    echo '<tr><td style="vertical-align:top;">Quest:</td><td>'.$questlist.'</td></tr>';
    echo '<tr><td style="vertical-align:top;">Examine:</td><td>' . htmlspecialchars($info['examine'] ?? '') . '</td></tr>';
    echo '</table><br />';
    echo '<table cellspacing="0" cellpadding="4" style="width:76%;margin:0 12%;border: 1px solid #000">';
if($info['trade']=='Yes') {
    echo  '<tr><td width="35%">High Alchemy:</td><td width="70%">' . number_format($info['highalch'] ?? 0) . 'gp</td></tr>';
    echo '<tr><td>Low Alchemy:</td><td>' . number_format($info['lowalch'] ?? 0) . 'gp</td></tr>';
    echo '<tr><td>Sell to General Store:</td><td>' . number_format($info['sellgen'] ?? 0) . 'gp</td></tr>';
    echo '<tr><td>Buy from General Store:</td><td>' . number_format($info['buygen'] ?? 0) . 'gp</td></tr>';
	
}
else {
    echo '<tr><td width="35%">High Alchemy:</td><td>' . htmlspecialchars($info['highalch'] ?? '') . 'gp</td></tr>';
    echo '<tr><td>Low Alchemy:</td><td>' . htmlspecialchars($info['lowalch'] ?? '') . 'gp</td></tr>';
}	
    echo '<tr><td width="20%">Obtained From: </td><td>' . htmlspecialchars($info['obtain'] ?? '') . '</td></tr>';
    echo '<tr><td style="vertical-align:top;">Keep/Drop:</td><td>' . htmlspecialchars($info['keepdrop'] ?? '') . '</td></tr>';
    echo '<tr><td style="vertical-align:top;">Retrieval:</td><td>' . htmlspecialchars($info['retrieve'] ?? '') . '</td></tr>';
    echo '<tr><td style="vertical-align:top;">Quest Use:</td><td>' . htmlspecialchars($info['questuse'] ?? '') . '</td></tr>';
    echo '<tr><td style="vertical-align:top;">Notes:</td><td>' . htmlspecialchars($info['notes'] ?? '') . '</td></tr></table>';
    echo '<br /><table cellspacing="0" cellpadding="4" style="width:76%;margin:0 12%;border: 1px solid #000">';
    echo '<tr><td style="width:20%;vertical-align:top;">Credits: </td><td>' . htmlspecialchars($info['credits'] ?? '') . '</td></tr>';
    echo '<tr><td>Last Modified:</td><td>' . $date . '</td></tr></table>';
 }
 else if ($type == 3) {
    echo '<table cellspacing="0" cellpadding="4" style="width:76%;margin:0 12%;border:1px solid #000;border-top:none">';
    echo '<tr><td colspan="4" class="tabletop" style="border-right:none">' . htmlspecialchars($info['name'] ?? '') . '</td></tr>';
    echo '<tr><td align="center" rowspan="8" width="100" style="border: none; border-right: 1px solid #000"><img src="/img/idbimg/' . htmlspecialchars($info['image'] ?? '') . '" alt="Picture of ' . htmlspecialchars($info['name'] ?? '') . '" /></td></tr>';
    echo '<tr><td width="25%">Members:</td><td>' . htmlspecialchars($info['member']) . '</td>'
        .'<td rowspan="5" style="width:96px;">' . ($big_pic ?? '') . '</td></tr>';
    echo '<tr><td>Tradable:</td><td>' . htmlspecialchars($info['trade']) . '</td></tr>';
    echo '<tr><td>Equipable:</td><td>' . htmlspecialchars($info['equip']) . '</td></tr>';
    echo '<tr><td>Stackable:</td><td>' . htmlspecialchars($info['stack']) . '</td></tr>';
    echo '<tr><td>Weight:</td><td>' . htmlspecialchars($info['weight'] ?? '') . 'kg</td></tr>';
    echo '<tr><td style="vertical-align:top;">Quest:</td><td colspan="2">' . $questlist . '</td></tr>';
    echo '<tr><td style="vertical-align:top;">Examine:</td><td colspan="2">' . htmlspecialchars($info['examine'] ?? '') . '</td></tr></table>';
    echo '<br />';
    echo '<table cellspacing="0" cellpadding="4" style="width:76%;margin:0 12%;border: 1px solid #000">';
if($info['trade']=='Yes') {
    echo '<tr><td>Sell to General Store:</td><td>' . number_format($info['sellgen'] ?? 0) . 'gp</td></tr>';
    echo '<tr><td>Buy from General Store:</td><td>' . number_format($info['buygen'] ?? 0) . 'gp</td></tr>';
	
}else {
    echo '<tr><td width="25%"></td></tr>';
}   echo '<tr><td width="25%">High Alchemy:</td><td>' . number_format($info['highalch'] ?? 0) . 'gp</td></tr>';
    echo '<tr><td>Low Alchemy:</td><td>' . number_format($info['lowalch'] ?? 0) . 'gp</td></tr>';
    echo '</table><br />';
    echo '<table cellspacing="0" width="76%" style="margin:0 12%;border: 1px solid #000" cellpadding="4">';
    echo '<tr><td style="width:25%;vertical-align:top;">Obtained From: </td><td>' . htmlspecialchars($info['obtain'] ?? '') . '</td></tr>';
    echo '    <tr><td style="vertical-align:top;">Notes:</td><td>' . htmlspecialchars($info['notes'] ?? '') . '</td></tr>';
if(!empty($droplist)) {
    echo '<tr><td style="vertical-align:top;" title="Up to 15 of lowest level droppers">Dropped By:</td><td>' . $droplist . '</td></tr>';
    }
    echo '<tr><td style="vertical-align:top;">Credits: </td><td>' . htmlspecialchars($info['credits'] ?? '') . '</td></tr>';
    echo '<tr><td style="vertical-align:top;">Last Modified:</td><td>' . $date . '</td></tr></table>';
 }
        }
  }
 echo '<br />';
 include 'search.inc.php';
  echo '<p style="text-align:center;"><a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>';
 ?>
[#COPYRIGHT#]
</div>

<?php
 end_page( htmlspecialchars($info['name'] ?? '') );
 ?>
