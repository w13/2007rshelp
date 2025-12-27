<?php
require('backend.php');
start_page(1, 'CityKey Generator');

echo '<div class="boxtop">CityKey Generator</div>'.NL.'<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">'.NL;


$city_keys = array(

    'agil' => 'agility_training',
    'achd' => 'achievement_diary_start',
    'alte' => 'altar',
    'amul' => 'amulet_shop',
    'anvi' => 'anvil',
    'apot' => 'apothecary',
    'arch' => 'archery_shop',
    'aces' => 'axe_shop',
    'bank' => 'bank',
    'brew' => 'brewery',
    'cand' => 'candle_shop',
    'clot' => 'chainmail_shop',
    'clot' => 'clothes_shop',
    'comb' => 'combat_training',
    'cran' => 'cooking_range',
    'cook' => 'cookery_shop',
    'craf' => 'crafting_shop',
    'dair' => 'dairy_churn',
    'dung' => 'dungeon',
    'esta' => 'estate_agent',
    'far1' => 'farming_shop',
    'far2' => 'farming_spot',
    'fis1' => 'fishing_shop',
    'fis2' => 'fishing_spot',
    'food' => 'food_shop',
    'furt' => 'fur_trader',
    'furn' => 'furnace',
    'gems' => 'gem_shop',
    'gene' => 'general_store',
    'gran' => 'grand_exchange',    
    'guid' => 'guide',
    'hair' => 'hair_dresser',
    'helm' => 'helmet_shop',
    'herb' => 'herbalist',
	'heex' => 'herbs_expert',
    'hunt' => 'hunter_training',
    'huns' => 'hunter_store',
    'jewe' => 'jewelery',
    'keba' => 'kebab_seller',
    'loom' => 'loom',
	'loex' => 'log_expert',
    'mace' => 'mace_shop',
    'mage' => 'magic_shop',
    'make' => 'makeover_mage',
    'min1' => 'mini_game',
    'min2' => 'mini_obelisk',
    'min3' => 'mining_shop',
    'min4' => 'mining_site',
	'orex' => 'ores_expert',
    'pets' => 'pet_shop',
    'pla1' => 'platebody_shop',
    'pla2' => 'platelegs_shop',
    'pohp' => 'poh_portal',
    'pott' => 'potters_wheel',
    'pubb' => 'pub_or_bar',
    'ques' => 'quest_start',
    'rare' => 'rare_trees',
	'ruex' => 'runes_expert',
    'sanp' => 'sandpit',
    'sawm' => 'sawmill',
    'scim' => 'scimitar_shop',
    'shie' => 'shield_shop',
    'shor' => 'shortcut',
    'silk' => 'silk_trader',
    'silv' => 'silver_shop',
    'skir' => 'skirt_shop',
    'slay' => 'slayer_master',
    'spic' => 'spice_shop',
    'spin' => 'spinning_wheel',
    'staf' => 'staff_shop',
    'stag' => 'stagnant_water',
    'ston' => 'stonemason',
    'sumo' => 'summoning_obelisk',  
    'sums' => 'summoning_store',    
    'swor' => 'sword_shop',
    'tann' => 'tannery',
    'tran' => 'transport',
    'vege' => 'vegetable_store',
    'wate' => 'water_source',
	'weex' => 'weapons_expert',
    'wind' => 'windmill',
    'wcst' => 'woodcutting_stump'
);

if(!isset($_GET['do_keys'])) {

    echo '<p align="center">Please select the keys for the city guide below, then press \'Generate City Keys\'.</p>'.NL;

    echo '<form action="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?do_keys" method="post">'.NL;
    echo '<table width="80%" align="center">'.NL;

    $col = 1;
    foreach($city_keys AS $key => $value) {
    
        $td =  '<td><input type="checkbox" name="'.$key.'" id="'.$key.'" value="true" /> <label for="'.$key.'"><img src="/img/cimg/key/'.$value.'.gif" alt="" /> '.$value.'</label></td>'.NL;
    
        if($col == 1){
            echo '<tr>'.NL;
            echo $td;
            $col = 2;
        }
        elseif($col == 2) {
            echo $td;
            $col = 3;
        }
        else {
            echo $td;
            echo '</tr>'.NL;
            $col = 1;
        }
    }
    if($col == 1 OR $col = 2) {
        echo '</tr>'.NL;
    }
    echo '</table>'.NL;
    
    echo '<p align="center"><input type="submit" value="Generate City Keys" /></p>'.NL;
        
    echo '</form>'.NL;
}
else {
    
    $all_keys = '';
    foreach($city_keys AS $key => $value) {
        if(isset($_POST[$key])) {
            $all_keys = $all_keys.$value.',';
        }
    }
    
    echo '<p align="center">Your request have been completed. Below is the generate code for the city guides\' keys.</p>'.NL;
    echo '<center><textarea rows="15" style="width: 98%; align: center;">'.$all_keys.'</textarea></center>'.NL;

}

echo '<br /></div>'.NL;

end_page();
?>
