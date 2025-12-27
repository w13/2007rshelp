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

if($disp->errlevel > 0) {
	$id = null;
	$search_area = 'name';
}

start_page('Runescape Item Database');
?>
<div class="boxtop">Runescape Item Database</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">

<br />
<div style="clear:both;"></div>

<br /><?php
  include('search.inc.php');
  echo ' 
  <table width="96%" style="margin:0 2%;" cellspacing="0" cellpadding="5">
<tr style="height:23px;font-size:13px;font-weight:bold;">
<td style="vertical-align:middle;text-align:right;"><a href="/correction.php?area=items&amp;id=4296" target="_blank">Submit Missing Item</a></td></tr></table><br />
  ';
  echo '<table style="margin:0 12%;border-left: 1px solid #000;" width="76%" cellpadding="1" cellspacing="0">';

  echo '<tr>';
  echo '<th class="tabletop" width="5%">Picture</th>';
  echo '<th class="tabletop">Name <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?order=ASC&amp;category=name&amp;page=' . (int)$page . '&amp;search_area=' . htmlspecialchars($search_area) . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Name, Ascending"><img src="/img/up.GIF" width="9" height="9" alt="Sort by: Name, Ascending" border="0" /></a> <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?order=DESC&amp;category=name&amp;page=' . (int)$page . '&amp;search_area=' . htmlspecialchars($search_area) . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Name, Descending"><img src="/img/down.GIF" width="9" height="9" alt="Sort by: Name, Descending" border="0" /></a></th>';
  
  echo '<th class="tabletop">Members <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?order=ASC&amp;category=member&amp;page=' . (int)$page . '&amp;search_area=' . htmlspecialchars($search_area) . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Members, Ascending"><img src="/img/up.GIF" width="9" height="9" alt="Sort by: Members, Ascending" border="0" /></a> <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?order=DESC&amp;category=member&amp;page=' . (int)$page . '&amp;search_area=' . htmlspecialchars($search_area) . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Members, Descending"><img src="/img/down.GIF" width="9" height="9" alt="Sort by: Members, Descending" border="0" /></a></th>';
  
  echo '<th class="tabletop">Tradable <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?order=ASC&amp;category=trade&amp;page=' . (int)$page . '&amp;search_area=' . htmlspecialchars($search_area) . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Tradable, Ascending"><img src="/img/up.GIF" width="9" height="9" alt="Sort by: Tradable, Ascending" border="0" /></a> <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?order=DESC&amp;category=trade&amp;page=' . (int)$page . '&amp;search_area=' . htmlspecialchars($search_area) . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Tradable, Descending"><img src="/img/down.GIF" width="9" height="9" alt="Sort by: Tradable, Descending" border="0" /></a></th>';
  
  echo '<th class="tabletop">Quest <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?order=ASC&amp;category=quest&amp;page=' . (int)$page . '&amp;search_area=' . htmlspecialchars($search_area) . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Quest, Ascending"><img src="/img/up.GIF" width="9" height="9" alt="Sort by: Quest, Ascending" border="0" /></a> <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?order=DESC&amp;category=quest&amp;page=' . (int)$page . '&amp;search_area=' . htmlspecialchars($search_area) . '&amp;search_term=' . urlencode($search_term) . '" title="Sort by: Quest, Descending"><img src="/img/down.GIF" width="9" height="9" alt="Sort by: Quest, Descending" border="0" /></a></th>';
  echo '</tr>';


if(!isset($id)) {

while($info = $db->fetch_array($query))   {
	$seotitle = strtolower(preg_replace("/[^A-Za-z0-9]/", "", $info['name'] ?? ''));

$info['member'] = ($info['member'] ?? 0) == 1 ? 'Yes' : 'No';
$info['equip'] = ($info['equip'] ?? 0) == 1 ? 'Yes' : 'No';
$info['trade'] = ($info['trade'] ?? 0) == 1 ? 'Yes' : 'No';
    echo '<tr>';
    echo '<td class="tablebottom"><a href="/items.php?id=' . (int)$info['id'] . '&amp;runescape_' . $seotitle . '.htm"><img src="/img/idbimg/' . htmlspecialchars($info['image'] ?? '') . '" alt="Zybez Runescape Help\'s ' . htmlspecialchars($info['name'] ?? '') .' image" width="50" height="50" /></a></td>';
    echo '<td class="tablebottom"><a href="/items.php?id=' . (int)$info['id'] . '&amp;runescape_' . $seotitle . '.htm">' . htmlspecialchars($info['name'] ?? '') . '</a></td>' . NL;
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

  if(($row_count ?? 0) == 0 || $page <= 0 || $page > ($page_count ?? 1))
   {
   $result = $db->query("SELECT name, id FROM `items` WHERE soundex(name) = soundex('" . $db->escape_string($search_term) . "') LIMIT 0,1");
    echo '<tr>';
    echo '<td class="tablebottom" colspan="5">Sorry, no items match your search criteria.';
    if (mysqli_num_rows($result) > 0) {
   while($info = $db->fetch_array($result))   {
   if($info['id'] != 950) echo ' Perhaps you meant <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?search_area=name&amp;search_term='.urlencode($info['name']).'">'.htmlspecialchars($info['name']).'</a>?'; } 
    }
    echo '</td></tr>';
   
        
  }
        
  }
  echo '</table><br /></div>';

  if(($page_count ?? 1) > 1)
   {
    echo '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>';
    echo '<td align="left"><form action="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'" method="get">Jump to page';
    echo ' <input type="text" name="page" size="3" maxlength="3" />';
    echo '<input type="hidden" name="order" value="' . htmlspecialchars($order) . '" />';
    echo '<input type="hidden" name="category" value="' . htmlspecialchars($category) . '" />';
    echo '<input type="hidden" name="search_area" value="' . htmlspecialchars($search_area) . '" />';
    echo '<input type="hidden" name="search_term" value="' . htmlspecialchars($search_term, ENT_QUOTES) . '" />';
    echo ' <input type="submit" value="Go" /></form></td>';
    echo '<td align="right">' . ($page_links ?? '') . '</td></tr>';
    echo '<tr><td colspan="2" align="right" width="140">Page ' . (int)$page . ' of ' . (int)$page_count . '</td></tr>';
    echo '</table>';
  }



?>

</div>

<?php
end_page();
?>