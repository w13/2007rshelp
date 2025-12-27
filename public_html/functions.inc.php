<?php
/*** FUNCTIONS ***/

// Function used to avoid the offline config
function offline_start( $title = '' ) {
	global $db, $TITLE;

	$TITLE = $title;

	$db->connect();
	$db->select_db( MYSQL_DB );

	ob_start();
}

## PULL CONTENT, MANIPULATE AND RESTORE

function dynamify($input) {
  /** Perform Functions on Content **/
  $content = $input;
  $pos=0;  $count=0;
  $content_array = explode('($func->', $content);
  $output = $content_array[0];
  while(stripos($content, '($func->', $pos)>0) { // Must be formatted like this: ($func->function_name(#parameter#)$)
    /** Find Next Starting Position **/
    $pos = stripos($content, '($func->', $pos)+1;
    $count++;
    /** Find the Functions Name **/
      $fn_end = stripos($content_array[$count],'$)');
      $values = substr($content_array[$count], 0, $fn_end);
      $func = substr($values, 0, stripos($values,'(#'));
    /** Find the Functions Parameters **/
      $start = stripos($values,'(#') + 2;
      $end = stripos($values,'#)') - $start;
      $func_par = substr($values, $start, $end);
      $func_par = explode('||',$func_par);
      
    /** Perform the Function **/
    // Security Fix: Whitelist allowed functions to prevent RCE
    $allowed_functions = array('city_key', 'city_shops', 'city_npc', 'monsters');
    if (in_array($func, $allowed_functions)) {
        $result = call_user_func($func, $func_par[0], $func_par[1]);
    } else {
        $result = ''; // Or handle error appropriately
        error_log("Security Warning: Attempted to call unauthorized function '$func' in dynamify()");
    }
    /** Restore the Content **/
    $content_array[$count] = substr($content_array[$count], $fn_end+2);
    $output = $output . $result . $content_array[$count];
  }
    $content = $output;
    return $content;
}
## City Keys
function city_key($name) {
if($name != 'NA') {
  $bname = ucfirst(preg_replace("/_/", " ", $name));
  $key_html = '<img src="/img/cimg/key/'.$name.'.gif" alt="OSRS RuneScape Help\'s '.$bname.' Key" width="15" height="15" /> - '.$bname.'<br />';
  return $key_html;
 }
}

## Display Shops in City Guides
function city_shops($id)
{
    global $db;
    $id = intval($id);
    $output = '';
    if($_SERVER['SCRIPT_NAME'] == '/cities.php') {
        $squery = $db->query("SELECT * FROM shops WHERE shops.location LIKE CONCAT('%', (SELECT name FROM cities WHERE id = " . $id . "), '%')");
    }
    else {
        $squery = $db->query("SELECT * FROM shops WHERE shops.location LIKE CONCAT('%', (SELECT name FROM guilds WHERE id = " . $id . "), '%')");
    }
    if(mysqli_num_rows($squery) != 0) {
        $output .= '<br /><div class="title1">Shops</div>';
        $output .= '<div style="margin-top:12px;width:98%;display:block;padding:5px;">';
        while($sinfo = $db->fetch_array($squery)) {
            $iquery = $db->query("SELECT * FROM shops_items WHERE `shop_id` = '" . $sinfo['id'] . "'");
            $output .= '<table cellpadding="5" cellspacing="0">'.NL
                .'<tr>'.NL
                .'<td style="vertical-align:top;"><img src="/img/shopimg/'.htmlspecialchars($sinfo['image']).'" alt="Location" title="Shop Location" /></td>'.NL
                .'<td style="vertical-align:top;"><div class="title3">'.htmlspecialchars($sinfo['name']).'</div><em>Speak to: '.htmlspecialchars($sinfo['shopkeeper']).'</em>'.NL
                .'<ul style="padding-left:10px">';
            while($iinfo = $db->fetch_array($iquery)) {
                $iinfo['item_stock'] = $iinfo['item_stock'] == -1 ? '&#8734;' : $iinfo['item_stock'];
                $output .= '<li>' . htmlspecialchars($iinfo['item_name']).' ('.$iinfo['item_stock'].'): ' . number_format( $iinfo['item_price'] ) . '' . htmlspecialchars($iinfo['item_currency']) . '</li>'.NL;
            }
            $output .= '</ul></td></tr></table><br />';
        }
    }
    return $output;
}

## Display Monsters in City Guides
function city_npc($id) {
    global $db;
    $id = intval($id);
    $output = '';
    $mquery = $db->query("SELECT * FROM monsters WHERE locations LIKE CONCAT('%', (SELECT name FROM cities WHERE id = " . $id . "), '%')");
    if(mysqli_num_rows($mquery) != 0) {
        $output .= '<br /></div>'.NL
            .'<div class="title1">Inhabitants</div>'.NL
            .'<div style="margin-top:12px;width:96%;display:block;padding:5px;height:1000px;overflow:auto">'.NL
            .'<table cellpadding="5" cellspacing="0">'.NL;
        while($minfo = $db->fetch_array($mquery)) {
            $seotitle = strtolower(preg_replace("/[^A-Za-z0-9]/", "", $minfo['name'] ?? ''));
            $output .= '<tr>'.NL;
            if(($minfo['npc'] ?? 0) == 1) { 
                $output .= '<td style="width:125px;height:125px;background-image:url(\'/img/npcimg/'.htmlspecialchars($minfo['img'] ?? '').'\'); background-repeat:no-repeat; background-position:50% 50%;"></td>'.NL; 
            }
            else { 
                $output .= '<td style="width:110px;height:110px;background-image:url(\'/img/npcimg/npc/'.htmlspecialchars($minfo['img'] ?? '').'\'); background-repeat:no-repeat; background-position:50% 50%;"></td>'.NL; 
            }
            $output .= '<td style="vertical-align:top;">'.NL;
            if(($minfo['npc'] ?? 0) == 1) $output .= '<div class="title3">'.htmlspecialchars($minfo['name'] ?? '').' (level-'.htmlspecialchars($minfo['combat'] ?? '').')';
            else $output .= '<div class="title3">'.htmlspecialchars($minfo['name'] ?? '');
            $output .= ' <a href="/monsters.php?id='.(int)($minfo['id'] ?? 0).'&amp;runescape_' . $seotitle . '.htm" title="More information"><img src="/img/market/idb.gif" border="0" alt="More information" /></a></div>'
              .'<b>Examine:</b> '.htmlspecialchars($minfo['examine'] ?? '').'<br /><b>Notes:</b> '.($minfo['notes'] ?? '').'</td>'.NL
              .'</tr>';
        }
        $output .= '</table><br /></div>';
    }
    else $output .= '</div>';
    return $output;
}

function monsters($field, $search) {
  global $db;
  $query = $db->query("SELECT * FROM monsters WHERE " . $field . " LIKE '%" . $search . "%' AND npc = 1 ORDER BY combat ASC");
  $i=0;
  while($minfo = $db->fetch_array($query)) {
    $i++;
    $minfo['member'] = $minfo['member'] == 1 ? 'Yes' : 'No';
    $minfo['quest'] = $minfo['quest'] == '-'  || empty($minfo['quest']) ? 'No' : $minfo['quest'];
    $rowspan = $minfo['maxhit'] == '0' ? '9' : '10';
    $jsn = str_replace(' ', '_', strtolower(substr($minfo['name'], 0, 10)) . $i);
$results .= '<script type="text/javascript">
function avgxp_calc'.$jsn.' () {
var count'.$jsn.' = document.Average_XP'.$jsn.'.avg_xp.value;

if (isNaN(count'.$jsn.') || count'.$jsn.' == 0) {
  return;
}

var calc_cb'.$jsn.' = (count'.$jsn.' * ' . $minfo['hp'] . ' * 4 * 60);
var calc_hp'.$jsn.' = (count'.$jsn.' * ' . $minfo['hp'] . ' * 1.333 * 60);
document.getElementById("cbxp'.$jsn.'").innerHTML = Math.round(calc_cb'.$jsn.'*10)/10;
document.getElementById("hpxp'.$jsn.'").innerHTML = Math.round(calc_hp'.$jsn.'*10)/10;
}
</script>'.NL.NL;
$results  .= '<table cellspacing="0" cellpadding="4" style="width:76%;margin:0 12%;border: 1px solid #000;border-top: none">'
          .'<tr>'
          .'<td colspan="3" class="tabletop" style="border-right:none">' . $minfo['name'] . '</td></tr>'
          .'<tr>'
          .'<td rowspan="' . $rowspan . '" width="50%" align="center" style="margin:0 25%;border:none;border-right:1px solid #000">'
            .'<img src="/img/npcimg/' . $minfo['img'] . '" alt="Picture of ' . $minfo['name'] . '" /></td></tr>'
          .'<tr>'
          .'<td width="15%">Combat:</td><td width="35%">' . $minfo['combat'] . '</td></tr>'
          .'<tr>'
          .'<td>Hitpoints:</td><td>' . $minfo['hp'] . '</td></tr>';
          if($minfo['maxhit'] != '0' ) {
$results  .= '<tr>'
          .'<td>Max Hit:</td><td>' . $minfo['maxhit'] . '</td></tr>'; }
$results  .= '<tr>'
          .'<td>Race:</td><td>' . $minfo['race'] . '</td></tr>'
          .'<tr>'
          .'<td>Members:</td><td>'. $minfo['member'] .'</td></tr>'
          .'<tr>'
          .'<td>Quest:</td><td>' . $minfo['quest'] . '</td></tr>'
          .'<tr>'
          .'<td>Nature:</td><td>' . $minfo['nature'] . '</td></tr>'
          .'<tr>'
          .'<td>Attack Style:</td><td>' . $minfo['attstyle'] . '</td></tr>'
          .'<tr>'
          .'<td>Examine:</td><td>' . $minfo['examine'] . '</td></tr>'
          .'</table><br />';
          
          if($minfo['hp'] != '1' ) {
          //-- CALCULATOR
$results  .= '<form name="Average_XP'.$jsn.'" onsubmit="javascript:return false" action=""><table cellspacing="0" width="76%" style="margin:0 12%;border: 1px solid #000" cellpadding="4">'
          .'<tr>'
          .'<td width="20%" title="Input how many you think you kill per minute"><b>Kills per min:</b></td>'
          .'<td style="text-align:left;width:15%" title="Input how many you think you kill per minute"><input type="text" size="3" autocomplete="off" maxlength="5" onkeyup="javascript:avgxp_calc'.$jsn.'()" name="avg_xp" /></td>'
          .'<td style="text-align:left;width:40%"><b>Average Combat XP per hour:</b></td>'
          .'<td style="text-align:left;width:20%"><span id="cbxp'.$jsn.'"></span></td></tr>'
          .'<tr>'
          .'<td colspan="2"></td><td style="text-align:left;"><b>Average HP XP per hour:</b></td>'
          .'<td style="text-align:left;"><span id="hpxp'.$jsn.'"></span></td></tr>'
          .'</table></form><br />';
          //-- Calculator -->
          }

$results  .= '<table cellspacing="0" cellpadding="4" style="width:76%;margin:0 12%;border:1px solid #000">'
            .'<tr>'
            .'<td width="20%" valign="top">Where Found:</td><td>' . $minfo['locations'] . '</td></tr>';
          if(!empty($minfo['drops'])) {
$results  .= '<tr>'
            .'<td valign="top">Drops:</td><td>' . $minfo['drops'] . '</td></tr>';
            }
          if(!empty($minfo['i_drops'])) {
$results  .= '<tr>'
            .'<td style="vertical-align:top;">Top Drops:</td><td>' . $minfo['i_drops'] . '</td></tr>';
          }
          if(!empty($minfo['tactic'])) {
$results  .= '<tr>'
            .'<td style="vertical-align:top;">Tactic:</td><td>' . $minfo['tactic'] . '</td></tr>';
          }
          if(!empty($minfo['notes'])) {
$results  .= '<tr>'
            .'<td style="vertical-align:top;">Notes:</td><td>' . $minfo['notes'] . '</td></tr>';
          }
$results  .= '</table><br />'.NL.NL;
  }
  return $results;
}
?>
