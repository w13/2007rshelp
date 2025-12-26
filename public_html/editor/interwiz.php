<?php
require( 'backend.php' );
start_page( 1, 'Link Generator' );

echo '<div class="boxtop">Link Generator</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;

if(!isset($_POST['submit'])) {
    $squery = $db->query("SELECT * FROM skills ORDER BY name");
    $qquery = $db->query("SELECT * FROM quests ORDER BY name");
    $cquery = $db->query("SELECT * FROM cities ORDER BY name");
    $gquery = $db->query("SELECT * FROM guilds ORDER BY name");
    $mgquery = $db->query("SELECT * FROM minigames ORDER BY name");
    $mquery = $db->query("SELECT * FROM misc ORDER BY name");
    
    $dmquery = $db->query("SELECT * FROM dungeonmaps ORDER BY name");
    $mmquery = $db->query("SELECT * FROM miningmaps ORDER BY name");
    $lbquery = $db->query("SELECT * FROM tomes ORDER BY name");
    
    $sdquery = $db->query("SELECT * FROM shops ORDER BY name");
    
    echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post">'.NL;
    echo '<p style="text-align: center;"><input type="submit" value="Submit" /></p>'.NL;
    echo '<input type="hidden" name="submit" value="true" />'.NL;
    echo '<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">'.NL;
    echo '<tr>'.NL;
    echo '<td class="tabletop">Skill Guides</td>'.NL;
    echo '<td class="tabletop">Quest Guides</td>'.NL;
    echo '<td class="tabletop">Cities Guides</td>'.NL;
    echo '</tr><tr>'.NL;
    echo '<td class="tablebottom"><select name="skills[]" multiple="multiple" size="15" style="width: 100%;">'.NL.'<option value="0" selected="selected">-- None Selected</option>'.NL;
    while($info = $db->fetch_array($squery)) {
        echo '<option value="'.$info['id'].'<#>'.$info['name'].'">'.$info['name'].'</option>'.NL;
    }
    echo '</select></td>'.NL;
    
    echo '<td class="tablebottom"><select name="quests[]" multiple="multiple" size="15" style="width: 100%;">'.NL.'<option value="0" selected="selected">-- None Selected</option>'.NL;
    while($info = $db->fetch_array($qquery)) {
        echo '<option value="'.$info['id'].'<#>'.$info['name'].'">'.$info['name'].'</option>'.NL;
    }
    echo '</select></td>'.NL;
    
    echo '<td class="tablebottom"><select name="cities[]" multiple="multiple" size="15" style="width: 100%;">'.NL.'<option value="0" selected="selected">-- None Selected</option>'.NL;
    while($info = $db->fetch_array($cquery)) {
        echo '<option value="'.$info['id'].'<#>'.$info['name'].'">'.$info['name'].'</option>'.NL;
    }
    echo '</select></td>'.NL;
    
    echo '</tr><tr>'.NL;
    echo '<td class="tabletop" style="border-top: none;">Guild Guides</td>'.NL;
    echo '<td class="tabletop" style="border-top: none;">Mini-Game Guides</td>'.NL;
    echo '<td class="tabletop" style="border-top: none;">Misc Guides</td>'.NL;
    echo '</tr><tr>'.NL;
    
    echo '<td class="tablebottom"><select name="guilds[]" multiple="multiple" size="15" style="width: 100%;">'.NL.'<option value="0" selected="selected">-- None Selected</option>'.NL;
    while($info = $db->fetch_array($gquery)) {
        echo '<option value="'.$info['id'].'<#>'.$info['name'].'">'.$info['name'].'</option>'.NL;
    }
    echo '</select></td>'.NL;
    
    echo '<td class="tablebottom"><select name="minigames[]" multiple="multiple" size="15" style="width: 100%;">'.NL.'<option value="0" selected="selected">-- None Selected</option>'.NL;
    while($info = $db->fetch_array($mgquery)) {
        echo '<option value="'.$info['id'].'<#>'.$info['name'].'">'.$info['name'].'</option>'.NL;
    }
    echo '</select></td>'.NL;
    
    echo '<td class="tablebottom"><select name="misc[]" multiple="multiple" size="15" style="width: 100%;">'.NL.'<option value="0" selected="selected">-- None Selected</option>'.NL;
    while($info = $db->fetch_array($mquery)) {
        echo '<option value="'.$info['id'].'<#>'.$info['name'].'">'.$info['name'].'</option>'.NL;
    }
    echo '</select></td>'.NL;
    
    echo '</tr><tr>'.NL;
    echo '<td class="tabletop" style="border-top: none;">Dungeon Maps</td>'.NL;
    echo '<td class="tabletop" style="border-top: none;">Mining Maps</td>'.NL;
    echo '<td class="tabletop" style="border-top: none;">Shop Database</td>'.NL;
    echo '</tr><tr>'.NL;
    
    echo '<td class="tablebottom"><select name="dungeonmaps[]" multiple="multiple" size="15" style="width: 100%;">'.NL.'<option value="0" selected="selected">-- None Selected</option>'.NL;
    while($info = $db->fetch_array($dmquery)) {
        echo '<option value="'.$info['id'].'<#>'.$info['name'].'">'.$info['name'].'</option>'.NL;
    }
    echo '</select></td>'.NL;
    
    echo '<td class="tablebottom"><select name="miningmaps[]" multiple="multiple" size="15" style="width: 100%;">'.NL.'<option value="0" selected="selected">-- None Selected</option>'.NL;
    while($info = $db->fetch_array($mmquery)) {
        echo '<option value="'.$info['id'].'<#>'.$info['name'].'">'.$info['name'].'</option>'.NL;
    }
    echo '</select></td>'.NL;
    
    echo '<td class="tablebottom"><select name="shops[]" multiple="multiple" size="15" style="width: 100%;">'.NL.'<option value="0" selected="selected">-- None Selected</option>'.NL;
    while($info = $db->fetch_array($sdquery)) {
        echo '<option value="'.$info['id'].'<#>'.$info['name'].'">'.$info['name'].'</option>'.NL;
    }
    echo '</select></td>'.NL;
    
    echo '</tr><tr>'.NL;
    echo '<td class="tabletop" style="border-top: none;">Tome Archive</td>'.NL;
    echo '</tr><tr>'.NL;

    echo '<td class="tablebottom"><select name="tomes[]" multiple="multiple" size="15" style="width: 100%;">'.NL.'<option value="0" selected="selected">-- None Selected</option>'.NL;
    while($info = $db->fetch_array($lbquery)) {
        echo '<option value="'.$info['id'].'<#>'.$info['name'].'">'.$info['name'].'</option>'.NL;
    }
    echo '</select></td>'.NL;
    echo '</tr>'.NL;
    echo '</table></form>'.NL;
}
else {
    echo '<textarea cols="1" rows="10" style="width: 100%;" align="center">'.NL;
    $areas = array('skills', 'quests', 'cities', 'guilds', 'minigames', 'misc', 'dungeonmaps', 'miningmaps', 'tomes', 'shops');
    for($x = 0; array_key_exists($x, $areas); $x++) {
        for($i = 0; array_key_exists($i, $_POST[$areas[$x]]); $i++) {
            $arr = explode('<#>', $_POST[$areas[$x]][$i]);
            if($arr[0] != 0) {
                echo '<a href="/'.$areas[$x].'.php?id='.$arr[0].'&amp;amp;runescape_'.strtolower(str_replace(' ', '_',$arr[1])).'.htm" title="Zybez RuneScape Help\'s '.$arr[1].' Guide">'.$arr[1].'</a>'.NL;
            }
        }
    }
    echo '</textarea>'.NL;
}
echo '<br /></div>' . NL;

end_page();
?>
