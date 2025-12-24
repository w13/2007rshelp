<?php
/* This page is obsolete now - W13 (Dec 3, 2013) */

  header ('HTTP/1.1 301 Moved Permanently');
  header ('Location: https://runescapecommunity.com');

die();

/* Anti DDoS */
//if(isset($_GET['search_terms'])){
// if($_GET['w13']!='rules'){ die('ERROR: Go back to <a href="http://www.zybez.net/priceguide.php">www.zybez.net/priceguide.php</a>');}
//}

$allpricedef = (strlen($_GET['price_low']) > 0 && strlen($_GET['price_high']) > 0) ? false : true;
$cleanArr = array(	array('scam', $_GET['scam'], 'int', 's' => '1,20'),
					array('search_area', $_GET['search_area'], 'int', 's' => '1,10'),
					array('search_terms', $_GET['search_terms'], 'sql', 'l' => 25, 'd' => ''),
					array('price_high', $_GET['price_high'], 'string', 'l' => 10, 'd' => ''),
					array('price_low', $_GET['price_low'], 'string', 'l' => 9, 'd' => ''),
					array('member', $_GET['member'], 'bin'),
					array('sort', $_GET['sort'], 'enum', 'e' => array('ASC', 'DESC'), 'd' => 'ASC'),
					array('sortby', $_GET['sortby'], 'enum', 'e' => array('price', 'category', 'name') ),
					array('page', $_GET['page'], 'int', 's' => '1,100', 'd' => 1),
					array('report', $_GET['report'], 'int', 's' => '1,9999'),
					array('area', $_GET['area'], 'int', 's' => '1,750'),
					array('category', $_GET['category'], 'int', 's' => '1,750'),
					array('all_prices', $_GET['all_prices'], 'bin', 'd' => $allpricedef)
				  );

//######### SETTINGS #########

$report_limit = 30;
##DISABLE ALL/500 RESULTS DURING 5PM AND 11PM GMT-6
$times = time();
$low = date('G', $times);
$high = date('G', $times);
if( $low > 17 AND $high < 23) $ppage_arr = array(50 => '50', 75 => '75', 100 => '100', 200 => '200');
else $ppage_arr = array(50 => '50', 75 => '75', 100 => '100', 200 => '200', 500 => '500', 0 => 'All');
$scam_arr = array(2, 3, 9, 13, 14);

$search_error = 'Your search did not return any results. Please make sure your spelling is correct and that you are typing full words.<br />Perhaps try searching the <a href="/items.php">Item Database</a> instead?';
//$link_box = 'Due to some issues with our Price Guide manager, prices will not be able to be updated for a few days. Sorry for any inconvenience.';
$link_box = ' &middot; <a href="/items.php" title="Item Database">Item Database</a> &middot; <a href="/shops.php" title="Shop Database">Shop Database</a> &middot; <a href="/community/index.php?showforum=203" title="Community Marketplace">Community Marketplace</a> &middot; <a href="/correction.php?area=items&id=4296" title="Submit Missing Item">Submit Missing Item</a> &middot;';
$ra_update = 24; //TIME BETWEEN REPORTS

//############################

$ctime = time() + 18000;

function gp_val($price_low) {
    $price_low = str_replace(',', '', strtolower($price_low));
    if($pos = strpos($price_low, 'gp')) {
        $price_low = floatval(substr($price_low, 0, $pos));
    }
    elseif($pos = strpos($price_low, 'k')) {
        $price_low = floatval(substr($price_low, 0, $pos));
        $price_low = $price_low * 1000;
    }
    elseif($pos = strpos($price_low, 'mill')) {
        $price_low = floatval(substr($price_low, 0, $pos));
        $price_low = $price_low * 1000000;
    }
    elseif($pos = strpos($price_low, 'm')) {
        $price_low = floatval(substr($price_low, 0, $pos));
        $price_low = $price_low * 1000000;
    }
    $price_low = intval($price_low);
    return $price_low;
}

require('backend.php');
require(ROOT.'/price_cat_functions.inc.php');
start_page('Runescape Market Price Guide');
if($disp->errlevel > 0) {
	unset($area);
	unset($category);
	unset($report);
	unset($search_area);
}
echo '<script type="text/javascript" src="/graphs/popup.js"></script>';
$graphjs = 'onclick="return popup(this,620,300,\'2px solid #fff\')"';
if(isset($report) AND isset($_GET['par'])) {
    echo'<div class="boxtop">\'Incorrect Price\' Report Submission</div>'.NL
    .'<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">'.NL;
    $id = $report;
    $de_par = base64_decode($_GET['par']);
    $par = $_GET['par'];
    $iinfo = $db->fetch_row("SELECT * FROM price_items WHERE phold_id = 0 AND id = ".$id);
    $after_time = $iinfo['time'] + (3600 * $ra_update);
    if($ctime < $after_time) {
        $wtime = ceil(($after_time - $ctime) / 3600);
        echo '<p style="text-align: center; font-size: 11px; font-weight: bold;">The price for \''.$iinfo['name'].'\' was recently updated. Reports are not accepted for items updated in the past '.$ra_update.' hours.</p>'.NL
        .'<p align="center">Reports for this item will be accepted in '.$wtime.' hours.</p>'.NL
        .'<center><input type="button" value="Go Back" onclick="javascript: location.href=\''.$_SERVER['SCRIPT_NAME'].'?'.$de_par.'\'" /></center>'.NL;

    }
    elseif(isset($_COOKIE['price_report'])) {
        echo '<p align="center">You must wait at least '.$report_limit.' seconds between price reports.</p>'.NL;
        header('refresh: 1; url='.$_SERVER['SCRIPT_NAME'].'?'.$de_par);
    }
    elseif($iinfo AND isset($_POST['do_report'])) {
        echo '<p align="center">Your report for \''.$iinfo['name'].'\' has been processed. Please wait...</p>'.NL;
        header('refresh: 0; url='.$_SERVER['SCRIPT_NAME'].'?'.$de_par);
        $db->query("UPDATE price_items SET reports = reports + 1 WHERE id = ".$id);
        setcookie('price_report', $id, time() + $report_limit);
    }
    elseif($iinfo) {
        $iprice = (empty($iinfo['price_high'])) ? number_format($iinfo['price_low']).'gp' : number_format($iinfo['price_low']).'gp - '.number_format($iinfo['price_high']).'gp';

        echo '<p style="text-align: center;">You are about to send a report to Zybez that the price for the item below is incorrect. Please confirm this action.</p>'.NL
        .'<table width="80%" align="center" style="border-left: 1px solid #000000" cellspacing="0">'.NL
        .'<tr>'.NL
        .'<td class="tabletop">Item</td>'.NL
        .'<td class="tabletop">Price</td>'.NL
        .'<td class="tabletop">Report Status</td>'.NL
        .'</tr>'.NL
        .'<tr>'.NL
        .'<td class="tablebottom">'.$iinfo['name'].'</td>'.NL
        .'<td class="tablebottom">'.$iprice.'</td>'.NL
        .'<td class="tablebottom">Awaiting Confirmation</td>'.NL
        .'</tr>'.NL
        .'</table>'.NL
        .'<form action="'.$_SERVER['SCRIPT_NAME'].'?report='.$id.'&amp;par='.$par.'" method="post" style="margin: 15px;"><center><input type="hidden" name="do_report" value="true" /><input type="submit" value="Yes, Submit this Report" /></center></form>'.NL
        .'<center><input type="button" value="No, Don\'t Submit this Report" onclick="javascript: location.href=\''.$_SERVER['SCRIPT_NAME'].'?'.$de_par.'\'" /></center>'.NL;
    }
    else {
        echo '<p align="center">That item does not exist.</p>'.NL;
        header('refresh: 1; url='.$_SERVER['SCRIPT_NAME'].'?'.$de_par);
    }
    echo '<br /></div>'.NL;
}
elseif(isset($area) OR isset($category)) {
    if(isset($area)) {
        $ainfo = $db->fetch_row("SELECT * FROM price_groups WHERE id = ".$area." AND parent = 1");
        $category = 0;
    }
    else {
        $cinfo = $db->fetch_row("SELECT * FROM price_groups WHERE id = ".$category);
        $lft = intval($cinfo['lft']);
        $rgt = intval($cinfo['rgt']);
        $bquery = $db->query("SELECT * FROM price_groups WHERE lft < ".$lft." AND rgt > ".$rgt." AND parent != 0");
        while($info = $db->fetch_array($bquery)) {
            if($info['parent'] == 1) $ainfo = $info;
            elseif($info['items'] == 1) $path_more .= ' &raquo; <a href="?category='.$info['id'].'">'.$info['title'].'</a>';
            else $path_more .= ' &raquo; '.$info['title'];
        }
        $area = intval($ainfo['id']);
    }
    $tree = display_tree($area);
    echo '<div class="boxtop">Guide to the RuneScape Marketplace</div>'.NL;
    
    if($category > 0) echo '<div class="boxbottom" style="margin-bottom: 10px; padding: 10px;"><span style="font-size:10pt;"><a href="'.$_SERVER['SCRIPT_NAME'].'">Runescape Price Guide</a> &raquo; <a href="'.$_SERVER['SCRIPT_NAME'].'?area='.$ainfo['id'].'">'.$ainfo['title'].'</a>'.$path_more.' &raquo; '.$cinfo['title'].'</span></div>'.NL.'<div style="float: left; width: 35%;">'.NL;
    else echo '<div class="boxbottom" style="margin-bottom:10px; padding:10px;"><a href="'.$_SERVER['SCRIPT_NAME'].'">Runescape Price Guide</a> &raquo; '.$ainfo['title'].'</div>'.NL;
    echo '<div class="boxbottom" style="border-top:1px solid #000; padding: 6px 24px 0 20px;">'.NL;
    
    //BEGIN ADVERT
    if($category < 1){
        echo '<div style="float: right;">
<script type="text/javascript">
<!--
if(sa == "true") {
document.writeln(\'<scr\'+\'ipt type="text/javascript">\');
document.writeln(\'google_ad_client = "pub-0109004644664993"; google_alternate_color = "B3B8BA"; google_ad_width = 336; google_ad_height = 280; google_ad_format = "336x280_as"; google_ad_type = "text_image";\');
document.writeln(\'//2007-10-20: zybez-priceguide\');
document.writeln(\'google_ad_channel = "6884019860"; google_color_border = "000000"; google_color_bg = "B3B8BA"; google_color_link = "FFFFFF"; google_color_text = "000000"; google_color_url = "38B63C";\');
document.writeln(\'</scr\'+\'ipt>\');
document.writeln(\'<scr\'+\'ipt type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></scr\'+\'ipt>\');
}
//-->
</script>
</div>';
    } //END ADVERT
    
    echo '<h1 style="font-size:13pt;">'.$ainfo['title'].'</h1>'.NL;
    for($i = 1; array_key_exists($i, $tree); $i++) {
        $id = $tree[$i]['id'];
        $title = $tree[$i]['title'];
        $items = $tree[$i]['items'];
        $ind = $tree[$i]['ind'];
        if($category == $id) $title = '<b><i>'.$title.'</i></b>';
        
        if($ind == 1) {
            $sym = '&raquo;';
            $marg = 10;
        }
        elseif($ind == 2) {
            $sym = '+';
            $marg = 40;
        }
        else {
            $sym = '-';
            $marg = 20 * $ind;
        }
        $fsize = 13 - $ind;
        
        if($items) echo '<div style="font-size:'.$fsize.'px; margin:0 0 2px '.$marg.'px;">'.$sym.' <a href="'.$_SERVER['SCRIPT_NAME'].'?category='.$id.'">'.$title.'</a></div>'.NL;
        else echo '<div style="font-size: '.$fsize.'px; margin:0 0 2px '.$marg.'px;">'.$sym.' '.$title.'</div>'.NL;
    }
    
    echo '<br /></div>'.NL;
    if($category > 0) {
        echo '</div>'.NL
        .'<div style="float: right; width: 63%;">'.NL
        .'<div class="boxtop">Category Information</div>'.NL
        .'<div class="boxbottom" style="padding: 6px 24px 6px 24px;">'.NL
        .'<h2 style="font-size:11pt;">'.$cinfo['title'].'</h2><br />'.NL;
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
	if (isNaN(nStr) || nStr == 0) {	return "Input the amount you are trading."; }
	if(nStr == myval){ return rangerover; }
	nStr = Math.ceil(nStr);
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) { x1 = x1.replace(rgx, '$1' + ',' + '$2'); 	}
	return x1 + x2 + 'gp';
}
</script>
<?
        echo '<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">'.NL
        .'<tr>'.NL
        .'<td class="tabletop" width="20">&nbsp;</td>'.NL
        .'<td class="tabletop" width="20">&nbsp;</td>'.NL
        .'<td class="tabletop">Name:</td>'.NL
        .'<td class="tabletop" width="20">&nbsp;</td>'.NL
        .'<td class="tabletop" width="20">&nbsp;</td>'.NL
        .'<td class="tabletop">Price:</td>'.NL
        .'<td class="tabletop" width="1%">&nbsp;</td>'.NL
        //.'<td class="tabletop" width="20">&nbsp;</td>'.NL
        .'</tr>'.NL
        .'<!-- Please link to Zybez when grabbing and parsing this page. -->'.NL;
        $iquery = $db->query("SELECT pi.*, ph.avgprice FROM price_items pi JOIN price_history ph ON ph.pid = pi.id WHERE pi.category = '".$category."' AND ph.pid = pi.id AND ph.bin = 1 ORDER BY iorder ASC");
        $en_url = base64_encode($_SERVER['QUERY_STRING']);
        $num = mysql_num_rows($iquery);
        if($num > 0) {
            while($iinfo = $db->fetch_array($iquery)) {
                echo '<tr>'.NL;
                if(empty($iinfo['phold_id'])) {
                    $price_low = number_format($iinfo['price_low']);
                    $price_high = number_format($iinfo['price_high']);
                    $iprice = (empty($price_high)) ? $price_low.'gp' : $price_low.'gp - '.$price_high.'gp';
                    $iinfo['member'] = $iinfo['member'] == 1 ? '<td class="tablebottom"><img src="/img/member.gif" alt="[M]"/></td>' : '<td class="tablebottom">&nbsp;</td>'; echo $iinfo['member'] . NL;
                    echo '<td class="tablebottom"><a href="/items.php?search_area=name&amp;search_term='.$iinfo['name'].'" title="More info on '.$iinfo['name'].'"><img src="/img/market/idb.gif" alt="More Info" border="0" /></a></td>'.NL;  
                    echo '<td class="tablebottom">'.$iinfo['name'].'</td>'.NL;
                    
                    $current_avg = $iinfo['price_high'] == 0 ? $iinfo['price_low'] : ( $iinfo['price_low'] + $iinfo['price_high'] ) / 2;
                    $graph = '<a href="/graphs/price.php?id='.$iinfo['id'].'" '.$graphjs.' title="Runescape Item Price History"><img src="/img/stats.gif" alt="Price History" border="0" /></a>';
                    
                    $itemid = $iinfo['id'];
                    $cost = '<input type="text" value="1" style="text-align:center;" size="4" title="Use \'K\' and \'M\' for thousands and millions." autocomplete="off" maxlength="6" onkeyup="javascript:document.getElementById(\'item_'.$itemid.'\').innerHTML = addCommas(eval(km(this.value)*'.$current_avg.'),range_'.$itemid.',myval_'.$itemid.');" name="prices" />';
        //echo '' . NL;
        
if (($iinfo['avgprice'] == $current_avg) or ($iinfo['avgprice'] == 0)) { //Price no change
        echo '<td class="tablebottom" title="No change"><img src="/img/market/p_n.gif" alt="This price hasn\'t changed" /></td>'.NL;
        }
        elseif ($current_avg > $iinfo['avgprice']) { // Price increase
        $change = $current_avg - $iinfo['avgprice'];
        echo '<td class="tablebottom" title="Former average price: '.number_format($iinfo['avgprice']).'gp (increased by '.number_format($change).'gp)"><img src="/img/market/p_u.gif" alt="This price has increased" /></td>'.NL;
        }
        elseif ($current_avg < $iinfo['avgprice']) { // Price decrease
        $change = $iinfo['avgprice'] - $current_avg;
       echo '<td class="tablebottom" title="Former average price: '.number_format($iinfo['avgprice']).'gp (decreased by '.number_format($change).'gp)"><img src="/img/market/p_d.gif" alt="This price has decreased" /></td>'.NL;
        }
                    echo '<td class="tablebottom">'.$graph.'</td>'.NL
                        .'<td class="tablebottom"><script type="text/javascript">range_'.$itemid.' = "'.$iprice.'"; myval_'.$itemid.' = "'.$current_avg.'"</script><div id="item_'.$itemid.'">'.$iprice.'</div></td>'.NL
                    .'<td class="tablebottom">'.$cost.'</td>'.NL;
                    //.'<td class="tablebottom" width="20"><a href="'.$_SERVER['SCRIPT_NAME'].'?report='.$iinfo['id'].'&amp;par='.$en_url.'" title="Report Incorrect Price"><img src="/img/!.gif" alt="[!]" border="0" /></a></td>'.NL;

                }
                
                 else {
                    echo '<td class="tablebottom" colspan="7"><a href="'.$_SERVER['SCRIPT_NAME'].'?category='.$iinfo['phold_cat'].'">Placeholder for '.$iinfo['name'].'  &raquo;</a></td>'.NL;
                }
                echo '</tr>'.NL;
            }
        }
        echo '</table><br />'.NL
       .'</div>'.NL;
        if(!empty($cinfo['text'])) {
            echo '<div class="boxbottom" style="border-top:1px solid #000; padding:6px 24px 6px 24px;">'.NL.$cinfo['text'].NL
            .'<br /></div>'.NL;
        }
        echo '</div>'.NL
        .'<div style="clear: both;"></div>'.NL;
    } 
    
}
elseif(isset($_GET['scam'])) {
    if(!empty($scam)) {
        $id = $scam;
        $info = $db->fetch_row("SELECT * FROM price_scams WHERE id = ".$id);
    }
    else {
        $info = $db->fetch_row("SELECT * FROM price_scams WHERE id = ".$scam_arr[rand(0, count($scam_arr)-1)]." LIMIT 0,1");
    }
    echo '<div class="boxtop">Guide to the RuneScape Marketplace</div>'.NL
    .'<div class="boxbottom" style="margin-bottom: 10px; padding: 10px;"><span style="font-size:11pt;float:right;"><a href="'.$_SERVER['SCRIPT_NAME'].'?scam" title="Display Another Scam Alert">Display Another Scam Alert</a></span>'
    .'<span style="font-size:11pt;"><a href="'.$_SERVER['SCRIPT_NAME'].'">Runescape Price Guide</a> &raquo; Scam Alert &raquo; '.$info['name'].'</span></div>'.NL
    .'<div class="boxbottom" style="border-top:1px solid #000; padding-left: 24px; padding-top: 6px; padding-right: 24px;">'.NL
    .'<p style="text-align: center;"><img src="/img/market/scams/'.$info['img'].'" height="80" width="391" alt="Image of '.$info['name'].'" /><img src="/img/market/warn'.$info['warn_level'].'.png" height="80" width="109" alt="Warn Level: '.$info['warn_level'].'" /></p>'.NL
    .$info['text'].NL
    .'</div>'.NL;
}
elseif(isset($search_area) AND ($all_prices == true OR (isset($price_low) AND isset($price_high)))) {
    echo '<div class="boxtop">Guide to the RuneScape Marketplace</div>'.NL
        .'<style type="text/css">td, .ntable { border-right:1px solid #000; border-bottom:1px solid #000; text-align:center; padding:1px; } .ntable { text-align:left;border:none; }</style>'.NL
        .'<div class="boxbottom" style="margin-bottom: 10px; padding: 10px;"><span style="font-size:11pt;"><a href="'.$_SERVER['SCRIPT_NAME'].'">Runescape Price Guide</a> &raquo; Search Results</span></div>'.NL
    .'<div class="boxbottom" style="border-top:1px solid #000; padding: 6px 24px 0 24px;">'.NL;
//search result search start
    //$carr = array(); //NOT NEEDED, ALL OPTIONS ARE BELOW.
    //$cquery = $db->query("SELECT * FROM price_groups WHERE parent = 1 ORDER BY lft ASC");
    //while($cinfo = $db->fetch_array($cquery)) {
    //    $carr[] = $cinfo;
    //    }
    echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="get" style="margin-bottom: 0px; margin-top: 5px;">'.NL
    .'<table width="100%" align="center"><tr style="text-align:left;">'.NL
    .'<td class="ntable">Item Search:</td><td class="ntable"><input type="text" name="search_terms" maxlength="25" value="'.stripslashes($search_terms).'" /></td>'.NL
    .'</tr><tr>'.NL
    .'<td class="ntable">Search Area:</td><td class="ntable"><select name="search_area">'.NL
    .'<option value="1">All Categories</option>'.NL
    .'<option value="2">Unstable &amp; Popular items</option>'.NL
    .'<option value="4">Armour &amp; Weapons</option>'.NL
    .'<option value="5">Magic, Runecraft &amp; Prayer</option>'.NL
    .'<option value="8">Archery equipment</option>'.NL
    .'<option value="7">Mining, Smithing &amp; Crafting</option>'.NL
    .'<option value="6">Herblore, Hunter, Farming, Summon</option>'.NL
    .'<option value="3">Cooking, Food &amp; Apparel</option>'.NL
    .'<option value="9">Construction &amp; Fletching</option>'.NL
    .'<option value="10">Miscellaneous</option>'.NL
    //for($i = 0; array_key_exists($i, $carr); $i++) {
    //    echo '<option value="'.$carr[$i]['id'].'">'.$carr[$i]['title'].'</option>'.NL;
    //}
    .'</select></td>'.NL
    .'</tr><tr>'.NL
    .'<td class="ntable">Price Range:</td><td class="ntable"><input type="text" name="price_low" size="8" maxlength="9" value="'.$price_low.'" /> to <input type="text" name="price_high" size="8" maxlength="10" value="'.$price_high.'" /> All Prices <input type="checkbox" name="all_prices" value="true" /></td>'.NL
    .'</tr><tr>'.NL
    .'<td class="ntable">Type:</td><td class="ntable"><select name="member"><option value="1" selected="selected">All Items</option><option value="0">Only Free Items</option></select></td>'.NL
    .'</tr></table>'.NL
//.'<input type="hidden" name="w13" value="rules">'.NL
    .'<center><input type="submit" value="Search" /></center>'.NL
    .'</form><br />'.NL;
    //search result end
    
    // Search Term Processing
    $search_terms = stripslashes($search_terms);
    if(!empty($search_terms)) {
        $search_terms_disp = '\''.$search_terms.'\'';
        $search_terms_q = str_replace(',', '', addslashes($search_terms));
        $search_terms_q = trim($search_terms_q);
        $search_terms_q = explode(' ', $search_terms_q);
        $search_terms_q[0] = "AND (pi.name LIKE '%".$search_terms_q[0]."%' OR (pi.keywords LIKE '%".$search_terms_q[0]."%' AND pi.keywords != ''))";
        for($num = 1; array_key_exists($num, $search_terms_q); $num++) {
            $search_terms_q[$num] = " AND (pi.name LIKE '%".$search_terms_q[$num]."%' OR pi.keywords LIKE '%".$search_terms_q[$num]."%') ";
        }
        $search_terms_q = implode('', $search_terms_q);
    }
    else {
        $search_terms_q = "";
        $search_terms_disp = 'any item';
    }
    // Search Area Processing
    //$search_area = $_GET['search_area'];
    //$search_area = addslashes($search_area);
    //$search_area = intval($search_area);
    if($search_area == "'" ) { die('What are you trying to do there matey?'); }
    
    if($search_area != 1) {
        $ainfo = $db->fetch_row("SELECT * FROM price_groups WHERE id = ".$search_area);
        $lft = intval($ainfo['lft']);
        $rgt = intval($ainfo['rgt']);
        $cquery = $db->query("SELECT * FROM price_groups WHERE lft >= ".$lft." AND rgt <= ".$rgt);
        $first = true;
        while($cinfo = $db->fetch_array($cquery)) {
            if($first == true) {
                $search_area_q = $cinfo['id'];
                $first = false;
            }
            else {
                $search_area_q .= ",".$cinfo['id'];
            }
        }
        $search_area_q = "AND category IN (".$search_area_q.")";
        $search_area_disp = '\''.$ainfo['title'].'\'';
    }
    else {
        $search_area_disp = 'all categories';
        $search_area_q = '';
    }
    // Price Range Processing
    $all_prices = (isset($all_prices)) ? $all_prices: false;
    if($all_prices == false) {
        $price_low = gp_val($price_low);
        $price_high = gp_val($price_high);
        if($price_low > $price_high) $price_high = $price_low;
        $price_range_q = "AND price_low <= ".$price_high." AND ((price_high = 0 AND price_low >= ".$price_low.") OR (price_high != 0 AND price_high >= ".$price_low."))";
        $price_text = 'with a price range from '.number_format($price_low).'gp to '.number_format($price_high).'gp';
        if($price_high == 0) {
            $all_prices = true;
            $price_text = 'of any price';
            $price_range_q = "";
        }
    }
    else {
        $price_text = 'of any price';
        $price_range_q = '';
    }
    // Type Processing
    $member_q = ($member == 0) ? "AND member = 0" : "";
    $pquery_string = "SELECT pi.*, pg.title, ph.avgprice FROM price_items pi, price_groups pg, price_history ph WHERE ph.pid = pi.id AND ph.bin = 1 AND phold_id = 0 AND pg.id = pi.category ".$search_terms_q." ".$search_area_q." ".$price_range_q." ".$member_q;
    // Ordering
    if(isset($sortby) AND $sortby == 'price') {
        $sortby = 'price';
        $sort_q = "ORDER BY pi.price_low ".$sort.", pi.price_high ".$sort;
        $sort_text = ($sort == 'DESC') ? 'Ordering by descending prices.' : 'Ordering by ascending prices';
    }
    elseif(isset($sortby) AND $sortby == 'category') {
        $sortby = 'category';
        $sort_q = "ORDER BY pg.title ".$sort.", pi.name ASC";
        $sort_text = ($sort == 'DESC') ? 'Ordering by descending categories.' : 'Ordering by ascending categories';
    }
    else {
        $sortby = 'name';
        $sort_q = "ORDER BY pi.name ".$sort;
        $sort_text = ($sort == 'DESC') ? 'Ordering by descending item names.' : 'Ordering by ascending item names';
    }
    // Page Processing
    $ppage_o = (array_key_exists($_GET['ppage'], $ppage_arr)) ? $_GET['ppage'] : 75;
    $item_count = $db->num_rows($pquery_string);
    $ppage = ($ppage_o == 0) ? $item_count : $ppage_o;
    $page_count = ($ppage != 0) ? ceil($item_count / $ppage) : 1;
    $next_page = $page + 1;
    $prev_page = $page - 1;
    $start_from = $ppage * ($page - 1);
    $href_base = 'search_terms='.$search_terms.'&amp;search_area='.$search_area.'&amp;price_low='.$price_low.'&amp;price_high='.$price_high.'&amp;all_prices='.$all_prices.'&amp;member='.$member.'&amp;ppage='.$ppage_o; //&amp;w13=rules
    $page_links = '';
    if($page > 2) $page_links .= ' <a href="'.$_SERVER['SCRIPT_NAME'].'?'.$href_base.'&amp;page=1">&laquo; First</a> ';
    if($page > 1) $page_links .= ' <a href="'.$_SERVER['SCRIPT_NAME'].'?'.$href_base.'&amp;page='.$prev_page.'">< Previous</a> ';
    for($i = 1; $i <= $page_count; $i++) {
        if($i == $page) $page_links .= ' <b>['.$i.']</b> ';
        else $page_links .= ' <a href="'.$_SERVER['SCRIPT_NAME'].'?'.$href_base.'&amp;page='.$i.'">'.$i.'</a> ';
    }
    if($page < $page_count) $page_links .= ' <a href="'.$_SERVER['SCRIPT_NAME'].'?'.$href_base.'&amp;page='.$next_page.'">Next ></a> ';
    if($page < ($page_count - 1)) $page_links .= ' <a href="'.$_SERVER['SCRIPT_NAME'].'?'.$href_base.'&amp;page='.$page_count.'">Last &raquo;</a> ';    
    // The Query
    $mquery_string = $pquery_string." ".$sort_q." LIMIT ".$start_from.",".$ppage;
    $mquery = $db->query($mquery_string);
    $results = mysql_num_rows($mquery);
    // Print
    echo '<!-- Search Page: Start -->'.NL.NL
    .'<!-- Search Information: Start -->'.NL.NL
    .'<hr /><div class="title3" style="text-align: center;">Searching for '.$search_terms_disp.' '.$price_text.' in '.$search_area_disp.'. '.$sort_text    .'.</div><hr /><br />'.NL.NL
    .'<form action="'.$_SERVER['SCRIPT_NAME'].'" method="get" name="ppage_form" style="margin: 0px; padding: 0px;">'.NL
    .'<input type="hidden" name="search_terms" value="'.stripslashes($search_terms).'" />'.NL
    //.'<input type="hidden" name="w13" value="rules">'.NL //ANTI DOS
    .'<input type="hidden" name="search_area" value="'.$search_area.'" />'.NL
    .'<input type="hidden" name="price_low" value="'.$price_low.'" />'.NL
    .'<input type="hidden" name="price_high" value="'.$price_high.'" />'.NL
    .'<input type="hidden" name="member" value="'.$member.'" />'.NL
    .'<input type="hidden" name="all_prices" value="'.$all_prices.'" />'.NL
    .'<input type="hidden" name="sortby" value="'.$sortby.'" />'.NL
    .'<input type="hidden" name="sort" value="'.$sort.'" />'.NL
    .'<table width="100%"><tr>'.NL
    .'<td style="text-align:left;width:180px;border:none;">Viewing '.$results.' of '.$item_count.' Results</td>'.NL
    .'<td style="text-align:center;border:none;">Results Per Page: <select name="ppage" onchange="javascript: document.ppage_form.submit()">';
    foreach($ppage_arr AS $value => $view) {
        if($ppage_o == $value) echo '<option value="'.$value.'" selected="selected">'.$view.'</option>';
        else echo '<option value="'.$value.'">'.$view.'</option>';
    }
    echo '</select></td>'.NL
    .'<td style="text-align:right;width:180px;border:none;">Page '.$page.' of '.$page_count.'</td>'.NL
    .'</tr></table>'.NL.NL
    .'<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">'.NL
    .'<tr>'.NL
    .'<td class="tabletop" width="20">&nbsp;</td>'.NL
    .'<td class="tabletop" width="20">&nbsp;</td>'.NL
    .'<td class="tabletop">Name: <a href="'.$_SERVER['SCRIPT_NAME'].'?'.$href_base.'&amp;sortby=name&amp;sort=ASC" title="Sort By: Name, Ascending"><img src="/img/up.GIF" alt="ASC" border="0" /></a> <a href="'.$_SERVER['SCRIPT_NAME'].'?'.$href_base.'&amp;sortby=name&amp;sort=DESC" title="Sort By: Name, Descending"><img src="/img/down.GIF" alt="DESC" border="0" /></a></td>'.NL
    .'<td class="tabletop" width="20">&nbsp;</td>'.NL
    .'<td class="tabletop" width="20">&nbsp;</td>'.NL //  colspan="2" for below
    .'<td class="tabletop">Price: <a href="'.$_SERVER['SCRIPT_NAME'].'?'.$href_base.'&amp;sortby=price&amp;sort=ASC" title="Sort By: Price, Ascending"><img src="/img/up.GIF" alt="ASC" border="0" /></a> <a href="'.$_SERVER['SCRIPT_NAME'].'?'.$href_base.'&amp;sortby=price&amp;sort=DESC" title="Sort By: Price, Descending"><img src="/img/down.GIF" alt="DESC" border="0" /></a></td>'.NL
    .'<td class="tabletop">Category: <a href="'.$_SERVER['SCRIPT_NAME'].'?'.$href_base.'&amp;sortby=category&amp;sort=ASC" title="Sort By: Category, Ascending"><img src="/img/up.GIF" alt="ASC" border="0" /></a> <a href="'.$_SERVER['SCRIPT_NAME'].'?'.$href_base.'&amp;sortby=category&amp;sort=DESC" title="Sort By: Category, Descending"><img src="/img/down.GIF" alt="DESC" border="0" /></a></td>'.NL
    .'</tr>'.NL.NL
    .'<!-- Search Information: End -->'.NL.NL
    .'<!-- Search Results: Start -->'.NL.NL
    .'<!-- Please link to www.zybez.net/priceguide.php when grabbing and parsing this page. -->'.NL.NL;
    while($info = $db->fetch_array($mquery)) {
        $price_low = number_format($info['price_low']);
        $price_high = number_format($info['price_high']);
        $graph = '<a href="/graphs/price.php?id='.$info['id'].'" '.$graphjs.' title="Runescape Item History"><img src="/img/stats.gif" alt="" border="0" /></a>';
        $price = (empty($price_high)) ? $price_low.'gp' : $price_low.'gp - '.$price_high.'gp';
        echo '<tr>'.NL;
        $info['member'] = $info['member'] == 1 ? '<td><img src="/img/member.gif" alt="[M]"/></td>' : '<td>&nbsp;</td>'; echo $info['member'] . NL;
        echo '<td><a href="/items.php?search_area=name&amp;search_term='.$info['name'].'" title="More information..."><img src="/img/market/idb.gif" alt="More Info" border="0" /></a></td>'.NL;  
        echo '<td>'.$info['name'].'</td>'.NL;
        $current_avg = ( $info['price_low'] + $info['price_high'] ) / 2;
if (($info['avgprice'] == $current_avg) or ($info['avgprice'] == 0)) { //Price no change
        echo '<td title="No change"><img src="/img/market/p_n.gif" alt="No change" /></td>'.NL;
        }
        elseif ($current_avg > $info['avgprice']) { // Price increase
        $change = $current_avg - $info['avgprice'];
        echo '<td title="Previously: '.number_format($info['avgprice']).'gp [&uarr; by '.number_format($change).'gp]"><img src="/img/market/p_u.gif" alt="Price has &uarr;" /></td>'.NL;
        }
        elseif ($current_avg < $info['avgprice']) { // Price decrease
        $change = $info['avgprice'] - $current_avg;
       echo '<td title="Previously: '.number_format($info['avgprice']).'gp [&darr; by '.number_format($change).'gp]"><img src="/img/market/p_d.gif" alt="Price has &darr;" /></td>'.NL;
        }
        echo '<td>'.$graph.'</td>'.NL
        .'<td>'.$price.'</td>'.NL
        //.'<td width="20"><a href="'.$_SERVER['SCRIPT_NAME'].'?report='.$info['id'].'&amp;par='.$en_url.'" title="Report Incorrect Price"><img src="/img/!.gif" alt="[!]" border="0" /></a></td>'.NL
        .'<td><a href="'.$_SERVER['SCRIPT_NAME'].'?category='.$info['category'].'">'.$info['title'].'</a></td>'
        .'</tr>'.NL;
    }
    if($results == 0) {
 /*
   	$time_allowed = $area == 'items' ? time() : time() + ( $time_lim * 60 );
			$ip_address = $_SERVER['REMOTE_ADDR'];
        $db->query("UPDATE `corrections_ip` SET status = 1, status_expire = " . $time_allowed . " WHERE ip = '" . $ip_address . "'");
				if( mysql_affected_rows() == 0 ) {
				
					$db->query("INSERT INTO `corrections_ip` ( `ip`, `status`, `status_expire` ) VALUES ( '" . $ip_address . "', '1', '" . $time_allowed . "' )");
				}
				
        $db->query("INSERT INTO `helpdb`.`corrections` (`ip`, `text` ,`cor_table` ,`cor_id` ,`time`) VALUES ('".$ip_address."', '".addslashes($search_terms)."', 'price_items', '1', NOW())");
        
        */
        
        echo '<tr>'.NL
        .'<td class="tablebottom" colspan="8">'.$search_error.'</td>'.NL
        .'</tr>'.NL;
    }
    echo '</table></form><br />'.NL.NL
    .'<!-- Search Results: End -->'.NL.NL;
    if($page_count > 1) echo '<!-- Page Links: Start -->'.NL.NL.'<hr /><center>'.$page_links.'</center><hr />'.NL.NL.'<!-- Page Links: End -->'.NL.NL;
    echo '<br /></div>'.NL.NL
    .'<!-- Search Page: End -->'.NL.NL;
}
else {
    //$carr = array(); // NOT NEEDED
    //$cquery = $db->query("SELECT * FROM price_groups WHERE parent = 1 ORDER BY lft ASC");
    //while($cinfo = $db->fetch_array($cquery)) {
    //    $carr[] = $cinfo;
    //}
    $uquery = $db->query("SELECT pi.*, pg.title, ph.avgprice FROM price_items pi LEFT JOIN price_groups pg ON (pi.category = pg.id) LEFT JOIN price_history ph ON (pi.id = ph.pid) WHERE ph.bin = 1 ORDER BY pi.time DESC LIMIT 0,10");
    $sinfo = $db->fetch_row("SELECT * FROM price_scams WHERE id = ".$scam_arr[rand(0, count($scam_arr)-1)]." LIMIT 0,1");
    
    echo '<div class="boxtop" style="margin-bottom: 10px;border-bottom:1px solid #000;">Guide to the RuneScape Marketplace</div>'.NL.NL
    .'<div style="float: left; width: 49%;">'.NL
    .'<div class="boxtop">Search</div>'.NL
    .'<div class="boxbottom" style="padding: 5px; height: 135px; margin-bottom: 10px; overflow: hidden;">'.NL
    .'<form action="'.$_SERVER['SCRIPT_NAME'].'" method="get" style="margin-bottom: 0px; margin-top: 5px;">'.NL
    .'<table width="100%"><tr>'.NL
    .'<td>Item Search:</td><td><input type="text" name="search_terms" maxlength="25" /></td>'.NL
    .'</tr><tr>'.NL
    .'<td>Search Area:</td><td><select name="search_area">'.NL
    .'<option value="1">All Categories</option>'.NL
    .'<option value="2">Unstable &amp; Popular items</option>'.NL
    .'<option value="4">Armour &amp; Weapons</option>'.NL
    .'<option value="5">Magic, Runecraft &amp; Prayer</option>'.NL
    .'<option value="8">Archery equipment</option>'.NL
    .'<option value="7">Mining, Smithing &amp; Crafting</option>'.NL
    .'<option value="6">Herblore, Hunter, Farming, Summon</option>'.NL
    .'<option value="3">Cooking, Food &amp; Apparel</option>'.NL
    .'<option value="9">Construction &amp; Fletching</option>'.NL
    .'<option value="10">Miscellaneous</option>'.NL
    //for($i = 0; array_key_exists($i, $carr); $i++) { //NOT NEEDED
    //    echo '<option value="'.$carr[$i]['id'].'">'.$carr[$i]['title'].'</option>'.NL;
    //}
    .'</select></td>'.NL
    .'</tr><tr>'.NL
    .'<td>Price Range:</td><td><input type="text" name="price_low" size="8" maxlength="9" /> to <input type="text" name="price_high" size="8" maxlength="10" /> All Prices <input type="checkbox" name="all_prices" value="true" /></td>'.NL
    .'</tr><tr>'.NL
    .'<td>Type:</td><td><select name="member"><option value="1" selected="selected">All Items</option><option value="0">Only Free Items</option></select></td>'.NL
    .'</tr></table>'.NL
    //.'<input type="hidden" name="w13" value="rules">'.NL // ANTI DOS
    .'<center><input type="submit" value="Search" /></center>'.NL
    .'</form>'.NL
    .'</div>'.NL
    .'</div>'.NL.NL
    .'<div style="float: right; width: 49%;">'.NL
    .'<div class="boxbottom" style="height: 150px; margin-bottom: 10px; border-top:1px solid #000; padding: 5px; overflow: hidden;">'.NL;
    $text = substr($sinfo['text'], 0, 275);
    if(strlen($sinfo['text']) > 275) $text .= '...';
    echo '<img src="/img/market/scamalert.gif" width="150" height="50" align="left" hspace="6" vspace="3" alt="Scam Alert" />'.NL
    .'<div class="title3" style="margin-top: px;">'.$sinfo['name'].'</div>'.NL
    .'<p style="margin-top: 8px; margin-bottom: 10px;">'.$text.'</p>'.NL
    .'<div class="title3" style="text-align: center; margin: 0px; padding: 0px;">Stay Informed! <a href="'.$_SERVER['SCRIPT_NAME'].'?scam='.$sinfo['id'].'">Read More...</a></div>'.NL
    .'</div>'.NL
    .'</div>'.NL
    .'<div style="clear: both;"></div>'.NL.NL
    .'<div class="boxbottom" style="border-top:1px solid #000;padding:5px;margin-bottom:10px;text-align:center;font-size:10pt;">'.NL
    .$link_box.NL
    .'</div>'.NL;
    echo '<div style="float: left; width: 49%;">'.NL
    
    .'<div class="boxed"><a href="'.$_SERVER['SCRIPT_NAME'].'?area=2">Unstable &amp; Popular items</a></div>'.NL
    .'<div class="boxed"><a href="'.$_SERVER['SCRIPT_NAME'].'?area=4">Armour &amp; Weapons</a></div>'.NL
    .'<div class="boxed"><a href="'.$_SERVER['SCRIPT_NAME'].'?area=5">Magic, Runecraft &amp; Prayer</a></div>'.NL
    .'<div class="boxed"><a href="'.$_SERVER['SCRIPT_NAME'].'?area=8">Archery equipment</a></div>'.NL
    .'<div class="boxed"><a href="'.$_SERVER['SCRIPT_NAME'].'?area=7">Mining, Smithing &amp; Crafting</a></div>'.NL
    .'<div class="boxed"><a href="'.$_SERVER['SCRIPT_NAME'].'?area=6">Herblore, Hunter, Farming &amp; Summoning</a></div>'.NL
    .'<div class="boxed"><a href="'.$_SERVER['SCRIPT_NAME'].'?area=3">Cooking, Food &amp; Apparel</a></div>'.NL
    .'<div class="boxed"><a href="'.$_SERVER['SCRIPT_NAME'].'?area=9">Construction &amp; Fletching</a></div>'.NL
    .'<div class="boxed"><a href="'.$_SERVER['SCRIPT_NAME'].'?area=10">Miscellaneous</a></div>'.NL

    //for($i = 0; array_key_exists($i, $carr); $i++) {  //NOT NEEDED
    //    echo '<div class="boxtop" style="width: 100%; margin-bottom: 3px; font-size: 12px;"><a href="'.$_SERVER['SCRIPT_NAME'].'?area='.$carr[$i]['id'].'" class="boxed">'.$carr[$i]['title'].'</a></div>'.NL;
    //}
    .'</div>'.NL.NL
    .'<div style="float: right; width: 49%;">'.NL
    .'<div class="boxtop">Recently Updated</div>'.NL
    .'<div class="boxbottom" style="padding: 5px; margin-bottom: 10px;">'.NL
    .'<table width="100%">'.NL;
    $today = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    $yesterday = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
    for($i = 1; $uinfo = $db->fetch_array($uquery); $i++) {
        $price_low = number_format($uinfo['price_low']);
        $price_high = number_format($uinfo['price_high']);
        $iprice = (empty($price_high)) ? $price_low.'gp' : $price_low.'gp - '.$price_high.'gp';
        $graph = '<a href="/graphs/price.php?id='.$uinfo['id'].'" '.$graphjs.' title="Runescape Item Price History"><img src="/img/stats.gif" alt="Price History" border="0" /></a>';
        $utime = $uinfo['time'];
        $change = $ctime - $utime;
        if($change < 60) {
            $secs = floor($change);
            $ptime = ($secs > 1) ? $secs.' seconds ago' : '1 second ago';
        }
        elseif($change < 3600) {
            $mins = floor($change / 60);
            $ptime = ($mins > 1) ? $mins.' minutes ago' : '1 minute ago';
        }
        elseif($utime >= $today) {
            $hrs = floor($change / 3600);
            $ptime = ($hrs > 1) ? $hrs.' hours ago' : '1 hour ago';
        }
        elseif($utime >= $yesterday) {
            $ptime = 'Yesterday';
        }
        else {
            $ptime = date('F jS, Y', $utime);
        }
        $current_avg = ( $uinfo['price_low'] + $uinfo['price_high'] ) / 2;
		if (($uinfo['avgprice'] == $current_avg) or ($uinfo['avgprice'] == 0)) { //Price no change
			$cng = '<td title="No change"><img src="/img/market/p_n.gif" alt="This price hasn\'t changed" /></td>';
        }
        elseif ($current_avg > $uinfo['avgprice']) { // Price increase
			$cng = '<td title="Former average price: '.number_format($uinfo['avgprice']).'gp [increased by '.number_format($current_avg - $uinfo['avgprice']).'gp]"><img src="/img/market/p_u.gif" alt="This price has increased" /></td>';
        }
        elseif ($current_avg < $uinfo['avgprice']) { // Price decrease
			$cng = '<td title="Former average price: '.number_format($uinfo['avgprice']).'gp [decreased by '.number_format($uinfo['avgprice'] - $current_avg).'gp]"><img src="/img/market/p_d.gif" alt="This price has decreased" /></td>';
        }
        echo '<tr>'.NL
        .$cng.NL
        .'<td>'.$graph.'</td>'.NL
        .'<td><a href="'.$_SERVER['SCRIPT_NAME'].'?category='.$uinfo['category'].'" title="Updated: '.$ptime.'">'.$uinfo['name'].'</a></td>'.NL;
        if($uinfo['member'] == 1) echo '<td><img src="/img/member.gif" alt="[M]"/></td>';
        else echo '<td>&nbsp;</td>';
        echo '<td style="text-align: left;">'.$iprice.'</td>'.NL
            .'</tr>'.NL;
    }
    echo '</table>'.NL
    .'</div>'.NL
    .'</div>'.NL
    .'<div style="clear: both;"></div>'.NL;
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

    <div class="boxtop">About</div>
    <div class="boxbottom">
    <img src="/img/market/title.gif" alt="Support the Zybez Market Price Guide!" style="float:right; padding:1em;" />    
    <p>Welcome to Runescape's most used, unique and up-to-date Runescape <i>Item Price Guide</i> around!</p>
    <p>This massive Runescape item price database contains over 1,300 Runescape items, their current market prices and Runescape trading locations and times, <i>and</i> tips on avoiding runescape cheats and scams! The built-in calculator beside each Runescape item will also help you with your Runescape trades - you can even use K and M to represent thousands or millions! For a <b>complete listing</b> of all the items in this database, <a href="<?=$_SERVER['SCRIPT_NAME']?>?search_terms=&amp;search_area=1&amp;price_low=0&amp;price_high=0&amp;all_prices=1&amp;member=1&amp;sortby=name&amp;sort=ASC&amp;ppage=0&amp;sortby=price&amp;sort=DESC" title="Click here to view a full list of items in this database"><b>click here</b></a>, or simply hit "search."</p>
    <p>Click <a href="javascript:addEngine('marketplace','gif','Marketplace','0')" title="Click Here to Download"><b>here</b></a> to install a <b>FireFox search engine addon</b>, OR click <a href="http://toolbar.google.com/buttons/add?url=http://www.zybez.net/runescapeprices.xml"><b>here</b></a> to install a <b>Google Toolbar search addon</b> for the price guide.</p>
    
    <div class="title3">What do the icons represent?</div>
    <p><img src="/img/member.gif" alt="[M]" /> - Members' only item: only <a href="http://www.runescape.com/lang/en/aff/runescape/members/members.ws">RuneScape Members</a> can trade these items.<br />
    <img src="/img/!.gif" alt="[!]" />&nbsp; - Report: if you feel a price is incorrect, report it and a Zybez staff member will review the price.<br />
    <img src="/img/market/idb.gif" alt="Item Database Connect" />&nbsp; -  Find an item in the <a href="/items.php">Runescape Items Database</a>.<br />
    <img src="/img/market/p_u.gif" alt="Price Increase" />&nbsp; - Average price increased.<br />
    <img src="/img/market/p_n.gif" style="padding-bottom:2px;" alt="Price Hasn't Changed" />&nbsp; - Price hasn't changed.<br />
    <img src="/img/market/p_d.gif" alt="Price Decrease" />&nbsp; -  Average price decreased.<br />
    <img src="/img/stats.gif" alt="Price History Graph" />&nbsp; -  Price History Graph.</p>
    <div class="title3">Where did this guide originate?</div>
    <p>RuneScape Community's first price guide appeared in 2002, for RuneScape Classic. It was written and maintained by aliq121, but later taken over by Charlie in 2003.<br /><br />A week after RuneScape 2 was released, <a href="http://www.zybez.net/community/index.php?showuser=1182">Ben_Goten78</a> created <i>The Guide to the RuneScape Marketplace</i> - also known as the "Market Price Guide" - and has independently maintained it ever since. It has been a chartbuster for <a href="http://www.zybez.net/community">RuneScape Community</a>, accumulating thousands of views per day. In May of 2006, it was incorporated into Zybez, as you see it today and is now updated daily, by a number of people.</p>
    </div>
    
    <div class="boxtop">Disclaimer</div>
    <div class="boxbottom">
    <p style="text-align: center;">This is a <i>guide</i>, not a bible. Use your better judgement and common sense if you are planning on buying a lot of items.<br />Prices of <i>all</i> items vary from player to player.</p>
    </div>
    <?
}
end_page();
?>
