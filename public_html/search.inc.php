<?php
################  SEARCH VARIABLES  ################
###  CATEGORIES
########  Item Database: Name, Member, Trade, Quest
########  Monster Database: Name, Member, Combat, HP
########  Shop Database: Name, Location, Shopkeeper, Members
########  Quest Guides: Name, Members, QP, Difficulty, Length
###  SEARCH AREAS
########  Item Database: Name, Quest, Obtained From, Examine, Notes
########  Monster Database: Name, Location, Drops, Attack Style, Quest, Race, Notes, Training
########  Shop Database: Item Names, Shop Names, Locations, Shopkeeper, Notes
########  Quest Guides: Name, XP rewards, Guide Text
### ADDITIONAL QUERY CONSTRAINTS AND LIMITS
########  Item Database: `type` != 0; `id` IN (1308,1874,1904); 25
########  Monster Database: id != 950; `id` IN (912,521,803); 25
########  Shop Database: 
########  Quest Guides: 

$url = $_SERVER['SCRIPT_NAME'];

if($url == '/items.php') ### ITEM
{
  $constraint = array('`type` != 0',''); 
  $search_value = array('name','quest','obtain','examine','notes');
  $search_name = array('Name','Quest','Obtained From','Examine','Notes');
  $table = 'items';
}
elseif($url == '/compare.php') ### ITEM SEARCH IN COMPARATOR
{
  $constraint = array('`type` != 0',' AND `type` = 1'); ## 0 is standard, 1 is for weapons/armor only search
  $search_value = array('name', 'quest','obtain','examine','notes');
  $search_name = array('Name','Quest','Obtained From','Examine','Notes');
  $comparator = 'yes';
  $table = 'items';
}
elseif($url == '/monsters.php')  ### MONSTER
{
  $constraint = array('`id` != 950','AND `id` IN (912,521,803,479,487,644,497,642,511,510,617,912,619,803)'); ## 0 is standard, 1 is index listing.
  $search_value = array('name','locations','drops','attstyle','quest','race','notes');
  $search_name = array('Name', 'Locations','Drops','Attack Style','Quest','Race','Notes');
  $table = 'monsters';
}
elseif($url == '/runescapevideos.php') ### VIDEOS
{
  $constraint = array('disabled=0','');
  $search_value = array('name','author');
  $search_name = array('Videos', 'Author');
  $table = 'videos';
}
elseif($url == '/equipmentprofile.php')  ### SHOP
{
  $constraint = array('1=1','');
  $search_value = array('name','decsription');
  $search_name = array('Set Name','Description');
  $table = 'equipment';
}
elseif($url == '/development/shops.php')  ### SHOP
{
  $constraint = array('1=1','');
  $search_value = array('itemsearch','shop_name','location','shopkeeper','notes');
  $search_name = array('Item Names','Shop Names','Locations','Shop keepers','Notes');
  $table = 'shops';
}
elseif($url == '/misc.php')  ### MISC
{
  $constraint = array('1=1','');
  $categories = '';
  $search_value = array('name', 'text');
  $search_name = array('Name','Guide Content');
  $table = 'misc';
}
elseif($url == '/minigames.php')  ### MINI GAMES
{
  $constraint = array('1=1','');
  $categories = '';
  $search_value = array('name', 'text');
  $search_name = array('Name','Guide Content');
  $table = 'minigames';
}
elseif($url == '/development/quests.php')  ### QUEST
{
  $constraint = '';
  $categories = '';
  $search_areas = '';
  $search_value = array('name');
  $search_name = array('Name');
  $table = 'quests';
}
else
{
    // echo $_SERVER['SCRIPT_NAME'];
    return;
}
############################  SEARCH BEGINS
#################  ORDER, CATEGORY, PAGES, 
#################  SEARCH TERM, SEARCH AREAS
#################  ADDITIONAL QUERIES, 
#################  SEARCH FORM
############################  

if(isset($search_area) && $search_area != '') {
    
    /* Keyword Search */
    if( $search_area == 'name' && $search_term != '' && ($table == 'items' || $table == 'monsters' || $table == 'videos' || $table == 'equipment') ) {
        $search_terms_q = str_replace(',', '', $search_term);
        $search_terms_q = explode(' ', trim($search_terms_q));
        for($num = 0; array_key_exists($num, $search_terms_q); $num++) {
            $search_terms_q[$num] = "AND (name LIKE '%".$db->escape_string($search_terms_q[$num])."%' OR keyword LIKE '%".$db->escape_string($search_terms_q[$num])."%') ";
        }
		if (isset($awonly) && $awonly == 1) { //FOR ARMOUR/WEAPONS SEARCH ON COMPARATOR
			$search = "WHERE ".$constraint[0].$constraint[1]." ".implode('', $search_terms_q)." ORDER BY `".$db->escape_string($category)."` ".$db->escape_string($order);
		}
		else {
			$search = "WHERE ".$constraint[0]." ".implode('', $search_terms_q)." ORDER BY `".$db->escape_string($category)."` ".$db->escape_string($order);
		}
    }
    /* Monster DB Search */
        elseif($table == 'monsters') {
            if($search_area == 'combat' && in_array($search_term, array('1-25', '26-50', '51-80', '81-781')) !== false) {
                switch($search_term) {
                    case '1-25':      $com_constraint = "`combat` BETWEEN 1 AND 25 AND npc = 1"; break;
                    case '26-50':     $com_constraint = "`combat` BETWEEN 26 AND 50 AND npc = 1"; break;
                    case '51-80':     $com_constraint = "`combat` BETWEEN 51 AND 80 AND npc = 1"; break;
                    case '81-781':    $com_constraint = "`combat` BETWEEN 81 AND 781 AND npc = 1"; break;
                }
                $search = "WHERE ".$com_constraint." ORDER by `".$db->escape_string($category)."` ".$db->escape_string($order);
            }
            elseif($search_area == 'training' && ($search_term == 'range' || $search_term == 'mage' || $search_term == 'melee')) {
                switch($search_term) {
                    case 'mage':  $train_constraint = "(`tactic` LIKE '%magic%' or `tactic` LIKE '%mage%') AND `hp` > (`combat`-10)"; break;
                    case 'range': $train_constraint = "name IN (SELECT name FROM calc_info WHERE calc_name = 'Ranged')"; break;
                    case 'melee': $train_constraint = "name IN (SELECT name FROM calc_info WHERE calc_name = 'Warrior')"; break;
                }
                $search = "WHERE `npc` = 1 AND ".$train_constraint." AND `quest` = 'No' ORDER by `".$db->escape_string($category)."` ".$db->escape_string($order);
            }
            elseif($search_area == 'drops') {
                $search = "WHERE id != 950 AND (`drops` LIKE '%".$db->escape_string($search_term)."%' OR `i_drops` LIKE '%".$db->escape_string($search_term)."%') ORDER BY `".$db->escape_string($category)."` ".$db->escape_string($order);
            }
            else $search = "WHERE ".$constraint[0]." AND `".$db->escape_string($search_area)."` LIKE '%".$db->escape_string($search_term)."%' ORDER BY `".$db->escape_string($category)."` ".$db->escape_string($order);
        }
    /* SHOP DB Search */
        elseif($table == 'shops') {
        if( isset($_GET['search_area']) && $_GET['search_area'] == 'itemsearch' ) {
            $search = "s JOIN shops_items si ON (s.id = si.shop_id) WHERE `item_name` LIKE '%".$db->escape_string($search_term)."%' ORDER BY `".$db->escape_string($category)."` ".$db->escape_string($order).", `item_price` ASC, `item_stock` DESC, `item_name` ASC";
            }
        else $search = "WHERE `".$db->escape_string($search_area)."` LIKE '%".$db->escape_string($search_term)."%'";
       }
        /* Standard Search */
        else {
            $search = "WHERE ".$constraint[0]." AND `".$db->escape_string($search_area)."` LIKE '%".$db->escape_string($search_term)."%' ORDER BY `".$db->escape_string($category)."` ".$db->escape_string($order);
        }
}
else {
    $search_term = '';
    $search_area = '';
    $search = "WHERE ".$constraint[0]." ".$constraint[1]." ORDER BY `".$db->escape_string($category ?? 'name')."` ".$db->escape_string($order ?? 'ASC');
}
//debug: echo $search;
/*===========  Page Control  ============*/

if(empty($id) && $url !='/runescapevideos.php' && $url != '/misc.php' && $url != '/minigames.php') {
$rows_per_page     = 50;
$row_count_res     = $db->fetch_row("SELECT count(*) as count FROM ".$db->escape_string($table)." " . $search);
$row_count         = $row_count_res['count'] ?? 0;
$total_res         = $db->fetch_row("SELECT count(*) as count FROM ".$db->escape_string($table)." WHERE " . $constraint[0]);
$total             = $total_res['count'] ?? 0;
$page_count        = ceil($row_count / $rows_per_page) > 1 ? ceil($row_count / $rows_per_page) : 1;
$page_links        = ($page > 1 AND $page < $page_count) ? '|' : '';
$start_from        = ((int)$page - 1);
$start_from        = $start_from * $rows_per_page;
$end_at            = $start_from + $rows_per_page;

$query = $db->query("SELECT * FROM ".$db->escape_string($table)." " . $search . " LIMIT " . (int)$start_from . ", " . (int)$rows_per_page);

if($page > 1) {
    $page_before = (int)$page - 1;
    $page_links = '<a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']). '?page=' . $page_before . '&amp;order=' . htmlspecialchars($order) . '&amp;category=' . htmlspecialchars($category) . '&amp;search_area=' . htmlspecialchars($search_area) . '&amp;search_term=' . urlencode($search_term) . '">< Previous</a> ' . $page_links;
}
if($page < $page_count) {
    $page_after = (int)$page + 1;
    $page_links = $page_links . ' <a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']). '?page=' . $page_after . '&amp;order=' . htmlspecialchars($order) . '&amp;category=' . htmlspecialchars($category) . '&amp;search_area=' . htmlspecialchars($search_area) . '&amp;search_term=' . urlencode($search_term) . '">Next ></a> ';
}
if($page > 2) {
    $page_links = '<a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']). '?page=1&amp;order=' . htmlspecialchars($order) . '&amp;category=' . htmlspecialchars($category) . '&amp;search_area=' . htmlspecialchars($search_area) . '&amp;search_term=' . urlencode($search_term) . '">&laquo; First</a> '. $page_links;
}
if($page < ($page_count - 1)) {
    $page_links = $page_links . ' <a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']). '?page=' . (int)$page_count . '&amp;order=' . htmlspecialchars($order) . '&amp;category=' . htmlspecialchars($category) . '&amp;search_area=' . htmlspecialchars($search_area) . '&amp;search_term=' . urlencode($search_term) . '">Last &raquo;</a> ';
}

}

/*============  SEARCH FORM  ============*/
if (!isset($hide_search_form)) {
    echo '<form action="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '" method="get"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>'.NL;
    if(empty($id) && $url !='/runescapevideos.php' && $url != '/misc.php' && $url != '/minigames.php') echo '<td style="text-align:left;" width="200">Browsing ' . number_format($row_count) . ' of ' . number_format($total) . ' ' . htmlspecialchars(ucfirst($table)) . '(s)</td>'.NL;
    echo '<td style="text-align:center;">'.NL
    .'Search <select name="search_area">';

    for($num = 0; array_key_exists($num, $search_value) && array_key_exists($num, $search_name); $num++) {
        echo $search_area == $search_value[$num] ? '<option value="'.htmlspecialchars($search_value[$num]).'" selected="selected">'.htmlspecialchars($search_name[$num]).'</option>' : '<option value="'.htmlspecialchars($search_value[$num]).'">'.htmlspecialchars($search_name[$num]).'</option>';
    }

    echo '</select> for'.NL
    .' <input type="text" name="search_term" value="' . htmlspecialchars(stripslashes($search_term), ENT_QUOTES) . '" maxlength="40" />'.NL;

    if (isset($comparator) && $comparator == 'yes') {
        echo ' <input type="checkbox" name="awonly" value="1" ';
        if (isset($awonly) && $awonly == 1) echo 'checked="checked" ';
        echo '/> Weapons & Armour Only?  ';
    }

    echo ' <input type="submit" value="Go" /></td>'.NL;
    if(empty($id) && $url !='/runescapevideos.php' && $url != '/misc.php' && $url != '/minigames.php') echo '<td style="text-align:right;" width="140">Page ' . (int)$page . ' of ' . (int)$page_count . '</td>'.NL;
    echo '</tr></table></form>';
}
?>