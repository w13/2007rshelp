<?php
require('backend.php');
start_page(1, 'Table Generator');

echo '<div class="boxtop">Table Generator</div>'.NL.'<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">'.NL;

//TO CHANGE THIS BACK TO CODER ADDING IDS AND GETTING MANY TABLES AT ONCE, REMOVE COMMENTS FROM COMMENTED LINES AND REMOVE THE LINES THAT HAVE // AFTER THEM

$ids = explode(',',$_GET['ids']); //


/*$scimitars = Array(707,708,709,2975,710,711,712,713,2170);
$battleaxes = Array(734,728,729,2964,730,731,732,733,735);
$daggers = Array(650,649,651,2965,656,652,653,654,655);
$swords = Array(685,686,687,2972,688,689,690,691);
$mace = Array(755,754,756,2970,757,758,759,760,761);
$warhammers = Array(715,714,716,2976,717,718,719,720);
$claws = Array(1504,1505,1506,2963,1507,1508,1509,1510,6008);
$longswords = Array(692,693,694,2973,695,696,697,698,699);
$twohandedswords = Array(700,701,702,2974,703,704,705,706,2140);
$halberds = Array(1575,1576,1577,2969,1578,1579,1580,1581,1582);
$spears = Array(665,666,667,668,669,670,671);
$bits = Array(1905,2936,2940,2941,2938,1904,4729,4202);
$barrows = Array(2258,2271,2262,2275);
$godswords = Array(4735,4738,4736,4737);

$weapons = Array('Scimitars'=>$scimitars,'Battleaxes'=>$battleaxes,'Daggers'=>$daggers,'Swords'=>$swords,'Maces'=>$mace,'Warhammers'=>$warhammers,'Claws'=>$claws,'Longswords'=>$longswords,'Two-Handed Swords'=>$twohandedswords,'Halberds'=>$halberds,'Spears'=>$spears,'Barrows'=>$barrows,'Godswords'=>$godswords,'Other'=>$bits);*/

/*foreach ($weapons as $key => $value) {
	echo '<h1>'.$key.'</h1>';*/
	echo '<table width="100%" cellspacing="0" style="border-left: 1px solid #000000">
<tr>
<td class="tabletop">Picture</td>
<td class="tabletop">Name</td>
<td class="tabletop">Requirements</td>

<td class="tabletop" colspan="2">Item Stats</td></tr>';
	//foreach ($value as $itemid) {
	foreach ($ids as $itemid) { //
		$query = $db->query("SELECT * FROM `items` WHERE `id`=".$itemid);
		while ($info = $db->fetch_array($query)) {
			$name = $info['name'];
			$linkedname = '<a href="/items.php?id='.$itemid.'" title="OSRS RuneScape Help\'s '.$info['name'].' Item Database Entry">'.$info['name'].'</a>';
			$image = $info['image'];
			if ($info['member'] == 1) $member = ' <img src="/img/member.gif" alt="Members Weapon" title="Members Weapon" />';
			else $member = '';
			if ($info['att'][0] == '|') $info['att'] = '0'.$info['att'];
			if ($info['def'][0] == '|') $info['def'] = '0'.$info['def'];
			if ($info['otherb'][0] == '|') $info['otherb'] = '0'.$info['otherb'];
			$att = explode('|',$info['att']);
			$def = explode('|',$info['def']);
			$otherb = explode('|',$info['otherb']);
			foreach ($att as $key => $value) {
				if ($value < 0) $a = '-'.$value;
				elseif ($value == '' || !isset($value)) $att[$key] = '+0';
				else $att[$key] = '+'.$value;
			}
			foreach ($def as $key => $value) {
				if ($value < 0) $a = '-'.$value;
				elseif ($value == '' || !isset($value)) $def[$key] = '+0';
				else $def[$key] = '+'.$value;
			}
			foreach ($otherb as $key => $value) {
				if ($value < 0) $a = '-'.$value;
				elseif ($value == '' || !isset($value)) $otherb[$key] = '+0';
				else $otherb[$key] = '+'.$value;
			}
			echo '<tr>
<td class="tablebottom" rowspan="3"><img src="http://2007rshelp.com/img/idbimg/'.$image.'" alt="OSRS RuneScape Help\'s image of a '.$name.'" width="50" height="50" /></td>

<td class="tablebottom" rowspan="3">'.$linkedname.$member.'</td>
<td class="tablebottom" rowspan="3">&nbsp;</td>
<td class="tabletop" style="border-top:none;">Attack</td>
<td class="tablebottom">Stab: '.$att[0].', Slash: '.$att[1].', Crush: '.$att[2].', Magic: '.$att[3].', Range: '.$att[4].'</td></tr>
<tr>
<td class="tabletop" style="border-top:none;">Defence</td>
<td class="tablebottom">Stab: '.$def[0].', Slash: '.$def[1].', Crush: '.$def[2].', Magic: '.$def[3].', Range: '.$def[4].', Summoning: '.$def[5].'</td></tr>

<tr>
<td class="tabletop" style="border-top:none;">Other</td>

<td class="tablebottom">Strength: '.$otherb[0].', Ranged Strength: '.$otherb[1].', Prayer: '.$otherb[2].'</td></tr>';
		}
	}
	echo '</table>';
//}


echo '<br /></div>'. NL;

end_page();
?>