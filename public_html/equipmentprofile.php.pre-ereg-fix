<?php
/* Security For Our Info */
define( 'IN_ZYBEZ' , TRUE );

/*** AJAX responseText VALUE
     must be called first ***/

if( isset($_GET['setbuilder']) && (isset($_GET['equip_type']) || isset($_GET['item'])) ) {

    mysql_select_db('helpdb', mysql_connect('localhost','zyhelp','79g0ld42')) or die('MySQL Error -- Could not connect to database!');
    
    if(isset($_GET['equip_type']))
    {
       $equip_type = intval($_GET['equip_type']);
       if($equip_type == 0) $iid = 5350;
       if($equip_type == 1) $iid = 5351;
       if($equip_type == 2) $iid = 5344;
       if($equip_type == 3) $iid = 5345;
       if($equip_type == 4) $iid = 5352;
       if($equip_type == 5) $iid = 5346;
       if($equip_type == 6) $iid = 5353;
       if($equip_type == 7) $iid = 5354;
       if($equip_type == 8) $iid = 5348;
       if($equip_type == 9) $iid = 5347;
       if($equip_type == 10) $iid = 5349;
       
       $search  = mysql_query("SELECT * FROM helpdb.items WHERE equip_type = " . $equip_type . " AND (equip_type !=-1 AND type !=0) OR id = " . $iid . " ORDER BY name ASC");
       while($r = mysql_fetch_assoc($search)) {
              $itlist .= $r['id'].','.$r['name'].','.$r['keyword'].';';
       }
       echo $itlist;
       break;
    }
    elseif(isset($_GET['item']))
    {
       $iid = intval($_GET['item']);
       $query = mysql_query("SELECT * FROM items WHERE id = " . $iid . " ORDER BY name ASC");
       $info  = mysql_fetch_assoc($query);
       $weight = ($info['weight'] == -21 || $info['weight'] == '') ? 0 : $info['weight'];
       $member = $info['member'] == '' ? 0 : $info['member'];
       $att = $info['att'] == '' ? "0|0|0|0|0" : $info['att'];
       $def = $info['def'] == '' ? "0|0|0|0|0|0" : $info['def'];
       $otherb = $info['att'] == '' ? "0|0" : $info['otherb'];
       $pquery = mysql_query("SELECT * FROM price_items WHERE id IN (SELECT pid FROM items WHERE id = " . $iid . ")");
       $pinfo  = mysql_fetch_assoc($pquery);
       $low    = $pinfo['price_low'] == '' ? 0 : $pinfo['price_low'];
       $high   = $pinfo['price_high'] == '' ? 0 : $pinfo['price_high'];
       echo $info['name'].';'.$weight.';'.$member.';'.$low.';'.$high.';'.$info['image'].';'.$att.';'.$def.';'.$otherb.';'.$info['id'];
       break;
    }
}
 
$cleanArr = array(  array('id', $_GET['id'], 'int', 's' => '1,9999'),
            array('order', $_GET['order'], 'enum', 'e' => array('DESC', 'ASC'), 'd' => 'ASC' ),
            array('page', $_GET['page'], 'int', 's' => '1,400', 'd' => 1),
            array('category', $_GET['category'], 'enum', 'e' => array('name','description'), 'd' => 'name' ),
            array('search_area', $_GET['search_area'], 'enum', 'e' => array('name','description') ),
            array('search_term', $_GET['search_term'], 'sql', 'l' => 40)
            );

/*** EQUIPMENT PROFILES DATABASE ***/
 require(dirname(__FILE__) . '/' . 'backend.php');
 start_page('Equipment Profiles Database');
?>
<style type="text/css">
.item {width:50px;cursor:pointer;}
#results {margin-top:10px;border:2px solid #262626;height:220px;width:190px;}
#content p, #content td, #content li {font:11px "Lucida Sans Unicode", Verdana, sans-serif;}
p.descr {text-align:center;border-bottom:3px solid #0099cc;padding-bottom:10px;}
.descr span {font-weight:bold;font-size:14px;letter-spacing:2pt;text-decoration:underline}
div.instr {width:96%;margin:0 2%;height:130px;border-top:3px solid #0099cc;}
</style>

<div class="boxtop">Runescape Equipment Profiles Database</div>
<div class="boxbottom" style="padding-left: 14px; padding-top: 6px; padding-right: 14px;">
<?php

if(isset($_GET['submit'])) {
        echo $_POST['description'] . '<br />';
      echo $_POST['ids'];
      echo 'penis';
  }
  
 if(!isset($id) && !isset($_GET['setbuilder']))
 {
?>
<div style="margin:1pt;font-weight:bold;font-size:large;">&raquo; <a href="<?php=$_SERVER['SCRIPT_NAME']?>">Runescape Equipment Profiles</a></div>
<hr class="main" noshade="noshade" />
<a href="?setbuilder" title="Create your own set now!"><img src="img/equipimg/edb.gif" width="348" height="149" style="float:left;" alt="" border="0" /></a>
<p style="text-align:center;">What should I wear to barrows? What should I wear when training magic? What's in my price range? <b>All answers are here!</b></p>
<p>
<b>&raquo;</b> Build your own equipment set to compare bonuses, prices and more!<br />
<b>&raquo;</b> Runescape equipment sets created and submitted by fellow Runescape players.<br />
<b>&raquo;</b> Sets split into <b>15 categories</b> like barrows, boss killing, training outfits and loads more!<br />
<b>&raquo;</b> Categories split into Magic, Melee &amp; Ranged groups, sorted by cost!</p>
<br />
<div style="clear:both;"></div>
<?php

  include('search.inc.php');
  
  echo NL.NL.'<table cellspacing="5" width="76%" style="margin:0 12%;">'
   .NL.'<tr>'
   .NL.'<td><br />'
     .NL.'<table style="border-left: 1px solid #000000;" width="95%" align="center" cellpadding="1" cellspacing="0">'
     .NL.'<tr>'
     .NL.'<th class="tabletop" width="5%">Picture</th>'
     .NL.'<th class="tabletop">Name <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=ASC&amp;category=name&amp;page=' . $page . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Name, Ascending"><img src="/img/up.GIF" width="9" height="9" border="0" /></a> <a href="' . $_SERVER['SCRIPT_NAME'] . '?order=DESC&amp;category=name&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Name, Descending"><img src="/img/down.GIF" width="9" height="9" border="0" /></a></th>'
     .NL.'</tr>';

if(!isset($id)) {

  while($info = $db->fetch_array($query)) {
    $seotitle = strtolower(ereg_replace("[^A-Za-z0-9]", "", $info['name']));
    echo NL.'<tr>'
     .NL.'<td class="tablebottom"><a href="' . $_SERVER['SCRIPT_NAME'] . '?id=' . $info['id'] . '&amp;runescape_' . $seotitle . '.htm">'
        .'<img src="/img/idbimg/' . $info['image'] . '" alt="Zybez Runescape Help\'s ' . $info['name'] .' image" width="50" height="50" />'
        .'</a></td>'
     .NL.'<td class="tablebottom">'
        .'<a href="' . $_SERVER['SCRIPT_NAME'] . '?id=' . $info['id'] . '&amp;runescape_' . $seotitle . '.htm">' . $info['name'] . '</a></td>'
     .NL.'</tr>';
  } 

  if($row_count == 0 or $page <= 0 or $page > $page_count)
  {
    echo NL.'<tr>'
        .NL.'<td class="tablebottom" colspan="2">Sorry, no items match your search criteria.</td>'
        .NL.'</tr>';
  }
}
  echo '</table><br /></td></tr></table><br />';

  if($page_count > 1)
   {
    echo '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>';
    echo '<td style="text-align:left;"><form action="' . $_SERVER['SCRIPT_NAME'] . '" method="get">Jump to page';
    echo ' <input type="text" name="page" size="3" maxlength="3" />';
    echo '<input type="hidden" name="order" value="' . $order . '" />';
    echo '<input type="hidden" name="category" value="' . $category . '" />';
    echo '<input type="hidden" name="search_area" value="' . $search_area . '" />';
    echo '<input type="hidden" name="search_term" value="' . $search_term . '" />';
    echo ' <input type="submit" value="Go" /></form></td>';
    echo '<td style="text-align:right;">' . $page_links . '</td></tr>';
    echo '<tr><td colspan="2" style="text-align:right;" width="140">Page ' . $page . ' of ' . $page_count . '</td></tr>';
    echo '</table>';
  }

}
  elseif(isset($_GET['setbuilder']))
  {
?>
<script type="text/javascript" src="/equipmentprofile.js"></script>
<div style="margin:1pt;font-weight:bold;font-size:large;">
&raquo; <a href="<?php=$_SERVER['SCRIPT_NAME']?>">Runescape Equipment Profiles</a> &raquo; Set Builder</div>
<hr class="main" noshade="noshade" />
<p class="descr"><span>Build your very own Runescape Equipment set!</span>
<br /><br />You can build a set just to check out how much it'll cost you, what monsters it will be good against, what stats it has and how much it weighs, <b>or</b> submit your Runescape equipment combination and have it available to other users of Zybez Runescape Help forever! <noscript><b>Javascript MUST be enabled to use this.</b></noscript></p>

<div id="holder"></div>
<br /><div id="images"></div>

<table width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
<td style="vertical-align:top;width:14%;">
<form action="<?php=$_SERVER['SCRIPT_NAME']?>" method="get" name="search">
<h3 style="font:13px 'Lucida Sans Unicode'">Searching <span id="group"></span> for...</h3>
<input type="text" style="width:185px;" id="ds" value="" onclick="this.value = ''" onkeyup="doSearch(this.value)" /><br />
<select id="results" size="18">
<option disabled="disabled">Select an equipment slot</option>
</select>
</form>
</td>
<?php
    $i=0;
    $query = $db->query("SELECT * FROM items WHERE id IN (5350,5344,5351,5345,5352,5353,5346,5354,5347,5348,5349) ORDER BY equip_type ASC");
    while($iinfo = $db->fetch_array($query)) {
        $td[]          =    '<td id="i' . $i . '" onclick="blankItem(' . $i . ')" class="item" style="background:url(\'/img/equipimg/'
                            .$iinfo['image'].'\') no-repeat"></td>';
        $i++;
    }
    
        $total_stab_att   =    '<span id="att_stab">0</span>';
        $total_slash_att  =    '<span id="att_slash">0</span>';
        $total_crush_att  =    '<span id="att_crush">0</span>';
        $total_mage_att   =    '<span id="att_mage">0</span>';
        $total_range_att  =    '<span id="att_range">0</span>';
        $total_stab_def   =    '<span id="def_stab">0</span>';
        $total_slash_def  =    '<span id="def_slash">0</span>';
        $total_crush_def  =    '<span id="def_crush">0</span>';
        $total_mage_def   =    '<span id="def_mage">0</span>';
        $total_range_def  =    '<span id="def_range">0</span>';
        $total_summo_def  =    '<span id="def_summo">0</span>';
        $total_str_other  =    '<span id="oth_str">0</span>';
        $total_pray_oth   =    '<span id="oth_pray">0</span>';
        $weight           =    '<span id="weights">0</span>';
        $table_members    =    '<span id="members"></span>';
        $description      =    '<span id="description" style="cursor:pointer;" onclick="javascript: addDescr()">Click to write your own description.</span>';

echo  '<td style="width:75%;">'
          .'<table style="width:100%;border-left:1px solid #000;border-top:none;" cellspacing="0" cellpadding="0">'
          .'<tr>'
          .'<th colspan="2" class="tabletop">Custom Build Your Own Runescape Equipment Set</th>'
          .'<td rowspan="10" style="padding-left:5px;vertical-align:top;width:25%;">'
            .'<table cellspacing="0" cellpadding="0" width="100%" style="border: none;">'
            .'<tr>'
            .'<td class="boxtop" onclick="removeItem()">Attack</td></tr>'
            .'<tr>'
            .'<td class="boxbottom">Stab: ' . $total_stab_att . '<br />Slash: ' . $total_slash_att . '<br />Crush: ' . $total_crush_att
                .'<br />Magic: ' . $total_mage_att . '<br />Range: ' . $total_range_att . '</td></tr>'
            .'<tr>'
            .'<td>&nbsp;</td></tr>'
            .'<tr>'
            .'<td class="boxtop">Defence</td></tr>'
            .'<tr>'
            .'<td class="boxbottom">Stab: ' . $total_stab_def . '<br />Slash: ' . $total_slash_def . '<br />Crush: ' . $total_crush_def
                .'<br />Magic: ' . $total_mage_def . '<br />Range: ' . $total_range_def . '<br />Summoning: ' . $total_summo_def . '</td></tr>'
            .'<tr>'
            .'<td>&nbsp;</td></tr>'
            .'<tr>'
            .'<td class="boxtop">Other</td></tr><tr><td class="boxbottom">Strength: ' . $total_str_other .'<br />Prayer: ' . $total_pray_oth . '</td></tr></table>'
          .'</td></tr>'
          .'<tr>'
          .'<td class="tablebottom" style="background-image:url(/img/bg.png);width:20%;">'
            .'<table style="width:150px;background-image:url(/img/bg.png)" align="center" border="0" cellspacing="0" cellpadding="5">'
            .'<tr style="height:50px;">'
            .'<td style="width:50px;"></td>'
            .$td[0] ## Helmet
            .'<td style="width:50px;"></td>'
            .'</tr>'
            .'<tr style="height:50px;">'
            .$td[2] ## Cape
            .$td[1] ## Neck
            .$td[3] ## Ammo
            .'</tr>'
            .'<tr style="height:50px;">'
            .$td[4] ## Weapon
            .$td[6] ## Chest
            .$td[5] ## Shield
            .'</tr>'
            .'<tr style="height:50px;">'
            .'<td style="width:50px;"></td>'
            .$td[7] ## Legs
            .'<td style="width:50px;"></td>'
            .'</tr>'
            .'<tr style="height:50px;">'
            .$td[9] ## Gloves
            .$td[8] ## Boots
            .$td[10] ## Finger
            .'</tr>'
            .'</table></td>'
          .'<td style="border-right:1px solid #000;border-bottom:1px solid #000;vertical-align:top;" width="55%">' 
            .'<table width="100%" cellspacing="0" cellpadding="5">'
            .'<tr>'
            .'<td style="vertical-align:top;width:25%;">Set type:</td>'
            .'<td>' . $info['themed'] . $info['type'] . '</td>'
            .'</tr>'
            .'<tr>'
            .'<td style="vertical-align:top;">Consists of:</td>'
            .'<td><span id="names"></span></td>'
            .'</tr>'
            .'<tr>'
            .'<td style="vertical-align:top;">Members:</td>'
            .'<td>' . $table_members . '</td>'
            .'</tr>'
            .'<tr>'
            .'<td>Market Price:</td>'
            .'<td><span id="price_low">0</span> - <span id="price_high">0</span>gp</td>'
            .'</tr>'
            .'<tr>'
            .'<td>Total Weight:</td>'
            .'<td>' . $weight . 'kg<acronym title="We may not have the weight information for some items.">+</acronym></td>'
            .'</tr>'
            .'<tr>'
            .'<td style="vertical-align:top;">Strengths:</td>'
            .'<td>Grab</td>'
            .'</tr>'
            .'<tr>'
            .'<td style="vertical-align:top;">Good against:</td>'
            .'<td>Grab</td>'
            .'</tr>'
            .'<tr>'
            .'<td style="vertical-align:top;">Weaknesses:</td>'
            .'<td>Grab</td>'
            .'</tr>'
            .'<tr>'
            .'<td style="vertical-align:top;">Weak against:</td>'
            .'<td>Grab</td>'
            .'</tr>'
            .'<tr>'
            .'<td colspan="2" style="text-align:center;"><form action="'. $_SERVER['SCRIPT_NAME'] . '?submit" method="post" style="display:inline;">' . $description . '</td>'
            .'</tr>'
            .'</table>'
          .'</td></tr>'
          .'</table></td></tr></table>';
echo '
<input type="text" id="ids" name="ids" value="" />
<h3 style="text-align:center;"><input type="submit" name="submit" value="SUBMIT YOUR SET" /></h3></form>';
echo '<div class="instr">'
    .'<img src="img/equipimg/edb.gif" width="348" height="149" style="float:left;padding-right:20px;" alt="" border="0" /><br />'
    .'<ol>'
    .'<li>Click an empty slot to bring up a list of available items.</li>'
    .'<li>Scroll through the list or refine your search using our simple-search system.</li>'
    .'<li>Double click an item to have it fill a slot. All the info will appear automatically.</li>'
    .'<li><em>Optional: Write a description, choose a set type and submit your set to our database.</em></li>'
    .'</ol></div>';
    
  }
  else
  {
        $id = $_GET['id'];
        $id = intval( $id );
        $info = $db->fetch_row("SELECT * FROM equipment WHERE id = " . $id);
?>

<div align="left" style="margin:1">
<b><font size="+1">&raquo; <a href="<?php=$_SERVER['SCRIPT_NAME']?>">Equipment Profiles Database</a> &raquo; <u><?php=$info['name']?></u></font></b>
</div><hr class="main" noshade="noshade" />

<?php
    if(!empty($info['itemids'])) { ## If there's a set to be displayed...
    
    $query = $db->query("SELECT * FROM items WHERE id IN (".$info['itemids'].") ORDER BY equip_type ASC");
    
    $total_stab_att   = 0;
    $total_slash_att  = 0;
    $total_crush_att  = 0;
    $total_mage_att   = 0;
    $total_range_att  = 0;
    $total_stab_def   = 0;
    $total_slash_def  = 0;
    $total_crush_def  = 0;
    $total_mage_def   = 0;
    $total_range_def  = 0;
    $total_str_other  = 0;
    $total_pray_oth   = 0;

    while($iinfo = $db->fetch_array($query)) {
      
    /*** NAME ***/
        $name[]            =    $iinfo['name'];
    /*** CREATE TABLE CELL ***/
        $td[]          =    '<td class="item" onclick="window.location=\'/items.php?id=' . $iinfo['id'] . '\'" style="background:url(\'/img/idbimg/'.$iinfo['image'].'\') no-repeat">';

    /*** WEIGHT ***/
        $weights           =    ($iinfo['weight'] == -21 || $iinfo['weight'] == '') ? 0 : $iinfo['weight'];
        $weight           +=    $weights;
    /*** MEMBER WATERMARK ***/
        $mstring           =    $iinfo['member'] == 1 ? '<img src="/img/equip-mem.png" alt="" />' : '';
        $table_members    +=    $iinfo['member'];
        $member[]          =    $mstring;
    /*** CALCULATE STATS ***/
        $attArr            =    explode('|',$iinfo['att']);
        $defArr            =    explode('|',$iinfo['def']);
        $otherArr          =    explode('|',$iinfo['otherb']);
        $total_stab_att   +=    $attArr[0];
        $total_slash_att  +=    $attArr[1];
        $total_crush_att  +=    $attArr[2];
        $total_mage_att   +=    $attArr[3];
        $total_range_att  +=    $attArr[4];
        $total_stab_def   +=    $defArr[0];
        $total_slash_def  +=    $defArr[1];
        $total_crush_def  +=    $defArr[2];
        $total_mage_def   +=    $defArr[3];
        $total_range_def  +=    $defArr[4];
        $total_summo_def  +=    $defArr[5];
        $total_str_other  +=    $otherArr[0];
        $total_pray_oth   +=    $otherArr[1];
    }
    
    /*** ADD + ***/
        $total_stab_att   =    $total_stab_att >=0 ? '+' . $total_stab_att : $total_stab_att;
        $total_slash_att  =    $total_slash_att >=0 ? '+' . $total_slash_att : $total_slash_att;
        $total_crush_att  =    $total_crush_att >=0 ? '+' . $total_crush_att : $total_crush_att;
        $total_mage_att   =    $total_mage_att >=0 ? '+' . $total_mage_att : $total_mage_att;
        $total_range_att  =    $total_range_att >=0 ? '+' . $total_range_att : $total_range_att;
        $total_stab_def   =    $total_stab_def >=0 ? '+' . $total_stab_def : $total_stab_def;
        $total_slash_def  =    $total_slash_def >=0 ? '+' . $total_slash_def : $total_slash_def;
        $total_crush_def  =    $total_crush_def >=0 ? '+' . $total_crush_def : $total_crush_def;
        $total_mage_def   =    $total_mage_def >=0 ? '+' . $total_mage_def : $total_mage_def;
        $total_range_def  =    $total_range_def >=0 ? '+' . $total_range_def : $total_range_def;
        $total_summo_def  =    $total_summo_def >=0 ? '+' . $total_summo_def : $total_summo_def;
        $total_str_other  =    $total_str_other >=0 ? '+' . $total_str_other : $total_str_other;
        $total_pray_oth   =    $total_pray_oth >=0 ? '+' . $total_pray_oth : $total_pray_oth;
        
    /*** WRITE MEMBERS ROW ***/        
        if($table_members >= 8) $table_members = 'Most of this set is members only.';
        elseif($table_members >= 4) $table_members = 'Some of this set is members only.';
        elseif($table_members > 0) $table_members = 'A few of these items are members only.';
        elseif($table_members == 0) $table_members = 'All of this set is available to free players.';

/*** GRAB PRICES -- ONLY GRABS PRICES WITH A PID ***/
        $prices = $db->query("SELECT price_low, price_high FROM price_items WHERE id IN (SELECT pid FROM items WHERE id IN (".$info['itemids']."))");    
        while($pinfo = $db->fetch_array($prices)) { ## Calculate total cost of items in set
              $low += $pinfo['price_low'];
              $high += $pinfo['price_high'];
        }
        $price = number_format($low) . ' - ' . number_format($high) . 'gp';

/*** SUBMITTER ***/
$info['submit_type']  = $info['submit_type'] == 0 ? 'User Submitted' : $info['submit_type'];
$info['submit_type']  = $info['submit_type'] == 1 ? 'Submitted by Zybez Staff' : $info['submit_type'];

/*** GROUPS ***/
$info['themed']  = $info['themed'] == -1 ? 'Unsorted': $info['themed'] ;
$info['themed']  = $info['themed'] == 0 ? 'Barrows Gear': $info['themed'] ;  
$info['themed']  = $info['themed'] == 1 ? 'Barrows Mini Game': $info['themed'] ; 
$info['themed']  = $info['themed'] == 2 ? 'Training (Level 40-70)': $info['themed'] ; 
$info['themed']  = $info['themed'] == 3 ? 'Training (Level 70-100)': $info['themed'] ; 
$info['themed']  = $info['themed'] == 4 ? 'Training (Level 100+)': $info['themed'] ;
$info['themed']  = $info['themed'] == 5 ? 'Best of the Best': $info['themed'] ; //Best Mage, Best Melee..?
$info['themed']  = $info['themed'] == 6 ? 'Wilderness Training': $info['themed'] ;
$info['themed']  = $info['themed'] == 7 ? 'Player Killing': $info['themed'] ;
$info['themed']  = $info['themed'] == 8 ? 'Combat Pure': $info['themed'] ;
$info['themed']  = $info['themed'] == 9 ? 'Clan Warring': $info['themed'] ;
$info['themed']  = $info['themed'] == 10 ? 'Boss Killing': $info['themed'] ;
$info['themed']  = $info['themed'] == 11 ? 'Skiller': $info['themed'] ;
$info['themed']  = $info['themed'] == 12 ? 'Holiday Atire': $info['themed'] ;
$info['themed']  = $info['themed'] == 13 ? 'Quest Getup': $info['themed'] ;
$info['themed']  = $info['themed'] == 14 ? 'Treasure Trails': $info['themed'];

/*** SUB-GROUPS ***/
    $info['type']  = $info['type'] == 0 ? ' (Melee)': $info['type'];  
    $info['type']  = $info['type'] == 1 ? ' (Range)': $info['type']; 
    $info['type']  = $info['type'] == 2 ? ' (Magic)': $info['type']; 
    $info['type']  = $info['type'] == 3 ? ' (Multi style)': $info['type'];
    
/*** ORDERED-BY ***/
      $info['cost']  = $info['cost'] == 0 ? ' (Cheap)': $info['cost'];  
      $info['cost']    = $info['cost'] == 1 ? ' (Mid-Range)': $info['cost']; 
      $info['cost']  = $info['cost'] == 2 ? ' (Expensive)': $info['cost'];

echo '<div style="text-align:center;"><a href="/correction.php?area=items&amp;id=' . $id . '" title="Submit a Correction"><img src="/img/correct.gif" vspace="5" alt="Submit Correction" border="0" /></a></div>';

echo '<table width="96%" style="margin:0 2%;border-left:1px solid #000;border-top:none;" cellspacing="0" cellpadding="0">'
    .'<tr>'
    .'<td colspan="2" class="tabletop">' . $info['name'] . '</td>'
    .'<td rowspan="10" style="padding-left:5px;vertical-align:top;width:20%;">'
      .'<table cellspacing="0" cellpadding="0" width="100%" style="border: none;">'
      .'<tr>'
      .'<td class="boxtop"><b>Attack Bonuses</b></td></tr>'
      .'<tr>'
      .'<td class="boxbottom">Stab: ' . $total_stab_att . '<br />Slash: ' . $total_slash_att . '<br />Crush: ' . $total_crush_att . '<br />Magic: ' . $total_mage_att . '<br />Range: ' . $total_range_att . '</td></tr>'
      .'<tr>'
      .'<td>&nbsp;</td></tr>'
      .'<tr>'
      .'<td class="boxtop"><b>Defence Bonuses</b></td></tr>'
      .'<tr>'
      .'<td class="boxbottom">Stab: ' . $total_stab_def . '<br />Slash: ' . $total_slash_def . '<br />Crush: ' . $total_crush_def . '<br />Magic: ' . $total_mage_def . '<br />Range: ' . $total_range_def . '<br />Summoning: ' . $total_summo_def . '</td></tr>'
      .'<tr>'
      .'<td>&nbsp;</td></tr>'
      .'<tr>'
      .'<td class="boxtop"><b>Other Bonuses</b></td></tr><tr><td class="boxbottom">Strength: ' . $total_str_other .'<br />Prayer: ' . $total_pray_oth . '</td></tr></table>'
      .'</td>'
    .'</tr>'
    .'<tr>'
    .'<td class="tablebottom" style="background-image:url(/img/bg.png);width:20%;">'
      .'<table style="width:150px;" align="center" border="0" cellspacing="0" cellpadding="5">'
      .'<tr style="height:50px;">'
      .'<td style="width:50px;"></td>'
      .$td[0] . $member[0] . '</td>' ## Helmet
      .'<td style="width:50px;"></td>'
      .'</tr>'
      .'<tr style="height:50px;">'
      .$td[2] . $member[2] . '</td>' ## Cape
      .$td[1] . $member[1] . '</td>' ## Neck
      .$td[3] . $member[3] . '</td>' ## Ammo
      .'</tr>'
      .'<tr style="height:50px;">'
      .$td[4] . $member[4] . '</td>' ## Weapon
      .$td[6] . $member[6] . '</td>' ## Chest
      .$td[5] . $member[5] . '</td>' ## Shield
      .'</tr>'
      .'<tr style="height:50px;">'
      .'<td style="width:50px;"></td>'
      .$td[7] . $member[7] . '</td>' ## Legs
      .'<td style="width:50px;"></td>'
      .'</tr>'
      .'<tr style="height:50px;">'
      .$td[9] . $member[9] . '</td>' ## Gloves
      .$td[8] . $member[8] . '</td>' ## Boots
      .$td[10] . $member[10] . '</td>' ## Finger
      .'</tr>'
      .'</table>'
    .'</td>'
    .'<td style="border-right:1px solid #000;border-bottom:1px solid #000;vertical-align:top;" width="50%">'
    .'<table width="100%" cellspacing="0" cellpadding="5">'
    .'<tr>'
    .'<td style="vertical-align:top;width:20%;">Set type:</td>'
    .'<td>' . $info['themed'] . $info['type'] . '</td>'
    .'</tr>'
    .'<tr>'
    .'<td style="vertical-align:top;width:20%;">Set consists of:</td>'
    .'<td>' . $name[0] . ', ' . $name[1] . ', ' . $name[2] . ', ' . $name[3] . ', ' . $name[4] . ', ' . $name[5] . ', ' . $name[6] . ', ' . $name[7] . ', ' . $name[8] . ', ' . $name[9] . ', ' . $name[10] . '</td>'
    .'</tr>'
    .'<tr>'
    .'<td style="vertical-align:top;">Members:</td>'
    .'<td>' . $table_members . '</td>'
    .'</tr>'
    .'<tr>'
    .'<td>Market Price:</td>'
    .'<td>' . $price . $info['cost'] . ' </td>'
    .'</tr>'
    .'<tr>'
    .'<td>Total Weight:</td>'
    .'<td>' . $weight . 'kg<acronym title="We may not have the weight information for some items.">+</acronym></td>'
    .'</tr>'
    .'<tr>'
    .'<td style="vertical-align:top;">Strengths:</td>'
    .'<td>&nbsp;</td>'
    .'</tr>'
    .'<tr>'
    .'<td style="vertical-align:top;">Good against:</td>'
    .'<td></td>'
    .'</tr>'
    .'<tr>'
    .'<td style="vertical-align:top;">Weaknesses:</td>'
    .'<td>&nbsp;</td>'
    .'</tr>'
    .'<tr>'
    .'<td style="vertical-align:top;">Weak against:</td>'
    .'<td>&nbsp;</td>'
    .'</tr>'
    .'<tr>'
    .'<td>Author\'s Description</td>'
    .'<td>' . $info['description'] . '</td>'
    .'</tr>'
    .'</table></td>'
    .'</tr></table>';
}
else {
    echo 'Incorrect ID';
    }
}
if(!isset($_GET['setbuilder'])) {
echo '<p style="text-align:center;"><a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>';
?>
[#COPYRIGHT#]
<?php
}
echo '<br /></div>';
end_page( );
?>