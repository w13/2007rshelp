<?php
/** CORRECTION CONFIGURATION **/

// DO NOT TOUCH THIS
$text_len = 600;    // Max Length of Correction (Characters)
$name_len = 12;        // Max Length of Name (Characters)
$time_lim = 2;        // Correction Time Limit (Minutes)

// Where Corrections are accepted. 
// 'SQL Table'    => array( 'area_name' => 'Area Name',        'sql_name' => 'Name Category' ),
$area_arr = array(
'skills'        => array( 'area_name' => 'Skill Guides',         'sql_name' => 'name',      'editor' => 'guide.php?act=edit&cat=skills&id=' ),
'quests'        => array( 'area_name' => 'Quest Guides',         'sql_name' => 'name',      'editor' => 'quests.php?act=edit&id=' ),
'cities'        => array( 'area_name' => 'City Guides',          'sql_name' => 'name',      'editor' => 'cities.php?act=edit&id=' ),
'guilds'        => array( 'area_name' => 'Guild Guides',         'sql_name' => 'name',      'editor' => 'guide.php?act=edit&cat=guilds&id=' ),
'minigames'     => array( 'area_name' => 'Mini-Game Guides',     'sql_name' => 'name',      'editor' => 'minigames.php?act=edit&cat=minigames&id=' ),
'misc'          => array( 'area_name' => 'Miscellaneous Guides', 'sql_name' => 'name',      'editor' => 'misc.php?act=edit&id=' ),
'dungeonmaps'   => array( 'area_name' => 'Dungeon Maps',         'sql_name' => 'name',      'editor' => 'map.php?act=edit&cat=dungeonmaps&id=' ),
'miningmaps'    => array( 'area_name' => 'Mining Maps',          'sql_name' => 'name',      'editor' => 'map.php?act=edit&cat=miningmaps&id=' ),
//'worldmaps'   => array( 'area_name' => 'World Maps',         'sql_name' => 'name',      'editor' => 'map.php?act=edit&cat=worldmaps&id=' ),
'shops'         => array( 'area_name' => 'Shop Database',        'sql_name' => 'name', 'editor' => 'shop.php?act=edit&id=' ),
'external'      => array( 'area_name' => 'External Guides',      'sql_name' => '',          'editor' => 'ex_guides.php?guide=' ),
'testing'       => array( 'area_name' => 'Testing Area',      	 'sql_name' => 'name',      'editor' => 'testing_area.php?id=' ),
'tomes'         => array( 'area_name' => 'Tome Archive',      	 'sql_name' => 'name',     'editor' => 'tomes.php?act=edit&id=' ),
'items'         => array( 'area_name' => 'Item Database',      	 'sql_name' => 'name',     'editor' => 'items.php?act=edit&id=' ),
'monsters'         => array( 'area_name' => 'Monster Database',      	 'sql_name' => 'name',     'editor' => 'monsters.php?act=edit&id=' ),
'calc_info'         => array( 'area_name' => 'Calculators',      	 'sql_name' => 'calc_name',     'editor' => 'calc.php?cat=' ));
//'price_items'         => array( 'area_name' => 'Price Guide',      	 'sql_name' => 'name',     'editor' => 'IgnoreThis' ) );

//$external = array(
//        1 => 'Getting Started',
//        3 => 'Treasure Trail Help');
?>