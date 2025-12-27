<?php
/*
 *	Javascripted Runescape Calculator
 *	Created by Ryan Hoerr, December 2008
 *	(c) 2008 Zybez Corporation
 */
 
$skilllist	= array('Agility', 'Attack', 'Combat', 'Construction', 'Cooking', 'Crafting', 'Defence', 'Farming', 'Firemaking', 'Fishing', 'Fletching', 'Herblore', 'Hitpoints', 'Hunter', 'Magic', 'Mining', 'Prayer', 'Ranged', 'Runecrafting', 'Slayer', 'Smithing', 'Strength', 'Thieving', 'Woodcutting');
$imglist	= array('Agility', 'Attack', 'Combat_sm', 'Construction', 'Cooking', 'Crafting', 'Defence', 'Farming', 'Firemaking', 'Fishing', 'Fletching', 'Herblore', 'Hitpoints', 'hunter', 'Magic', 'Mining', 'Prayer', 'Ranged', 'Runecrafting', 'Slayer', 'Smithing', 'Strength', 'Thieving', 'Woodcutting');
$cleanArr	= array(	array('user', $_COOKIE['calc_user'], 'sql', 'l' => 12),
						array('g_user', $_GET['user'], 'string', 'l' => 12),
						array('skill', $_GET['calc'], 'enum', 'e' => $skilllist ) );

	/*** Bonus options ***
	 *	By skill, array:
	 *		XP multiple
	 *		Title (words to put next to it)
	 *		Flag [optional] (1 checks the option by default; 0 sets it as a checkbox instead of a radio)
	 */
foreach ($skilllist as $skilly){
 $boni[$skilly][] = array('*=5', 'Deadman mode', 0);
}
	$boni['Prayer'][] = array('*=1', 'Bury bones', 1);
	$boni['Prayer'][] = array('Bone=4,Remains=1,Other=1', 'Use the Ectofuntus');
	$boni['Prayer'][] = array('Bone=3.5,Remains=1,Other=1', 'Use Gilded Altar (2 marble burners)');
	$boni['Crafting'][] = array('*=1', 'Normal needle', 1);
	$boni['Crafting'][] = array('General=1,Jewelry=1,Glass=1,Leather=2,Battlestaff=1', 'Sacred clay needle');
	$boni['Crafting'][] = array('General=1,Jewelry=1,Glass=1,Leather=2.2,Battlestaff=1', 'Volatile clay needle');
	$boni['Firemaking'][] = array('*=1.025', 'Using Flame Gloves', 0);
	$boni['Firemaking'][] = array('*=1.025', 'Using Ring of Fire', 0);
	$boni['Fletching'][] = array('*=1', 'Normal knife', 1);
	$boni['Fishing'][] = array('*=1', 'Normal harpoon', 1);
	$boni['Fishing'][] = array('Net=1,Rod=1,Cage=1,Harpoon=2,Other=1', 'Sacred clay harpoon');
	$boni['Fishing'][] = array('Net=1,Rod=1,Cage=1,Harpoon=2.2,Other=1', 'Volatile clay harpoon');
	$boni['Fletching'][] = array('Ammo=1,Thrown=1,Bow(u)=2,Bow(s)=1.5', 'Sacred clay knife');
	$boni['Fletching'][] = array('Ammo=1,Thrown=1,Bow(u)=2.2,Bow(s)=1.6', 'Volatile clay knife');
	$boni['Mining'][] = array('*=1', 'Normal pickaxe', 1);
	$boni['Mining'][] = array('*=2', 'Sacred clay pickaxe');
	$boni['Mining'][] = array('*=2.2', 'Volatile clay pickaxe');
	$boni['Smithing'][] = array('*=1', 'Normal hammer', 1);
	$boni['Smithing'][] = array('*=2', 'Sacred clay hammer');
	$boni['Smithing'][] = array('*=2.2', 'Volatile clay hammer');
	$boni['Woodcutting'][] = array('*=1.025', 'Wearing full lumberjack', 0);
	$boni['Woodcutting'][] = array('*=1', 'Normal hatchet', 1);
	$boni['Woodcutting'][] = array('*=2', 'Sacred clay hatchet');
	$boni['Woodcutting'][] = array('*=2.2', 'Volatile clay hatchet');
	$boni['Construction'][] = array('*=1', 'Normal hammer', 1);
	$boni['Construction'][] = array('*=2', 'Sacred clay hammer');
	$boni['Construction'][] = array('*=2.2', 'Volatile clay hammer');
	$boni['Ranged'][] = array('*=1', 'Accurate Mode', 1);
	$boni['Ranged'][] = array('*=1', 'Rapid Mode');
	$boni['Ranged'][] = array('*=0.5', 'Longrange Mode');
	$boni['Ranged'][] = array('*=0.5', 'Cannon Mode');
	$boni['Attack'][] = array('*=1', 'Accurate Mode', 1);
	$boni['Attack'][] = array('*=0.33', 'Controlled Mode');
	$boni['Strength'][] = array('*=1', 'Aggressive Mode', 1);
	$boni['Strength'][] = array('*=0.33', 'Controlled Mode');
	$boni['Defence'][] = array('*=1', 'Melee: Defensive Mode', 1);
	$boni['Defence'][] = array('*=0.33', 'Melee: Controlled Mode');

require('backend.php');
require('calcs_functions.inc.php');
start_page('Old School RuneScape Calculators');

	if($disp->errlevel > 0 || empty($skill)) $skill = 'Index';

	foreach($skilllist as $key => $val) {
		$sel = $skill == $val ? ' style="font-weight: bold"' : '';
		$menulinks .= '<a href="?calc='.$val.'" title="Runescape '.$val.' Calculator"'.$sel.'><img src="/img/calcimg/'.$imglist[$key].'.gif" />'.$val.'</a>';
	}
	
	if(isset($g_user)) {
		$user = str_replace( ' ', '_', $g_user );
		setcookie( 'calc_user' , $user , time() + 12000000 );
	}
	if(array_search($skill, array('Combat', 'Index')) !== false) {
		require('calcs_spec_'.strtolower($skill).'.php');
		exit;
	}
	if(isset($user)) {
		$current_xp = getStat($user, $skill, 'xp');
		$current_lvl = findLevel($current_xp);
	}
	
	$sel = array_search($skill, array('Attack', 'Strength', 'Defence', 'Hitpoints')) !== false ? 'Warrior' : $skill;
	$sql = $db->query('select * from calc_info where calc_name="'.$sel.'" order by level asc');
	$sortarr = array();
	$i = 0;
	while($row = $db->fetch_array($sql)) {
		if(!$cor_id) $cor_id = $row['id'];
		$sortarr[$row['calc_type']] = $row['calc_type'];
		$memb = $row['member'] == 1 ? ' memb' : '';
		$row['xp'] = $skill == 'Hitpoints' ? round($row['xp'] / 3, 2) : $row['xp'];
		$table .= '<tr class="'.htmlspecialchars($row['calc_type'] ?? '').$memb.'" id="tr'.$i.'"><td><img src="/img/calcimg/a_red.PNG" id="image'.$i.'" class="rimg" /></td><td width="30" height="30"><img src="/img/'.htmlspecialchars($row['image'] ?? '').'" class="iimg" /></td><td>'.htmlspecialchars($row['name'] ?? '').'</td><td id="level'.$i.'">'.(int)$row['level'].'</td><td id="xp'.$i.'">'.($row['xp'] + 0).'</td><td id="num'.$i.'"></td></tr>'.NL;
		$i++;
	}

	$opts = array();	
	$opts[] = '<input type="checkbox" id="reverse" onclick="reverseMode(this.checked)" /> Use planning mode';
	$opts[] = '<input type="checkbox" id="goalst" onclick="goalStart(this.checked)" checked="checked" /> Use current level as goal starting level';
	if( array_search($skill, array('Agility', 'Construction', 'Herblore', 'Hunter', 'Fletching', 'Farming', 'Slayer', 'Thieving')) === false )
		$opts[] = '<input type="checkbox" id="memb" onclick="hideMember(this.checked)" /> Hide member options';
	
	if(count($boni[$skill]) > 0) {
		foreach($boni[$skill] as $arr) {
			$sel = $arr[2] == 1 ? 'checked="checked" ' : '';
			if(isset($arr[2]) && $arr[2] == 0)
				$opts[] = '<input type="checkbox" name="specc" onclick="addCheckBonus(\''.$arr[0].'\', this.checked)" /> '.$arr[1];
			else
				$opts[] = '<input type="radio" name="specr" onclick="addRadioBonus(\''.$arr[0].'\')" '.$sel.'/> '.$arr[1];
		}
	}
	
	// If it's slayer or combat, hide the images
	if(array_search($skill, array('Slayer', 'Attack', 'Defence', 'Strength', 'Ranged', 'Magic', 'Hitpoints')) !== false) {
		$imgcss = 'width: 0;'.NL.'display: none;';
		$rimgcss = '.rimg {'.NL.'display: none;'.NL.'}';
	}
	else
		$imgcss = 'width: 30px;'.NL.'height: 30px;';
	
	// Do we have categories?
	$sort = array();
	if(count($sortarr) > 1) {
		$sort[] = '<select id="filterBy" onchange="filter(this.value)">';
		$sort[] = '<option value="*">Show All</option>';
		foreach($sortarr as $val) {
			$sort[] = '<option value="'.$val.'">'.str_replace('_', ' ', $val).'</option>';
		}
		$sort[] = '</select>';
	}
	
	echo '<div class="boxtop">'.$skill.' Runescape Skill Calculator</div><div class="boxbottom" style="padding: 6px 24px">'.NL;
?>

<script type="text/javascript">
<!--
// IE-compatible refactor of document.getElementsByName
function getElementsById(Id) {
	var Temp = new Array();
	for(var i=0;i<<?php echo $i;?>;i++)
		Temp[i] = document.getElementById(Id+i);
	return Temp;
}
//-->
</script>
<script type="text/javascript" src="calcs.js"></script>
<style type="text/css">
#wrap {
margin-left: 160px;
max-width: 700px;
}
.tbl {
border-collapse: collapse;
width: 100%;
border: 1px solid #000;
}
.tbl th,
.tbl td {
border: 0;
border-top: 1px solid #000;
padding: 0;
text-align: center;
}
.tbl th {
padding: 2px 4px;
}
.iimg {
border: 1px solid #000;
border-width: 0 1px;
<?php echo $imgcss; ?>
}
.progress {
border: 1px solid #000;
background: url('/img/calcimg/bg_0_25.png');
padding: 3px;
text-align: center;
}
.pad td {
padding: 2px 4px;
text-align: left;
}
#currentxp,
#goalxp,
#startxp {
background: #fff url('/img/calcimg/xp.png') no-repeat right bottom;
width: 100px;
}
#currentlvl,
#goallvl,
#startlvl {
background: #fff url('/img/calcimg/level.png') no-repeat right bottom;
width: 60px;
}
#menu {
float: left;
width: 150px;
}
#menu a {
display: block;
float: left;
width: 150px;
text-decoration: none;
}
#menu img {
vertical-align: middle;
width: 18px;
padding: 1px 5px 1px 0;
}
#status_inner {
padding: 3px;
}
#progress_bar {
margin: 3px -3px -3px;
}
#progress_bar td {
background-image: url('/img/gradient_bg.png');
background-position: left;
height: 7px;
}
#actions th {
cursor: pointer;
}
.asc:after {
content: 'ˆ';
}
.des:after {
content: 'ˇ';
}
<?php echo $rimgcss; ?>
</style>
<div style="margin: 1pt; font-size: large; font-weight: bold;">	» <a href="calcs.php">2007 RuneScape Skill Calculators</a> » <?php echo htmlspecialchars($skill); ?>
</div>
<hr class="main" noshade="noshade" />

<div id="menu">
<?php echo $menulinks; ?>
<a href="/correction.php?area=calc_info&amp;id=<?php echo $cor_id; ?>" title="Submit a Correction" style="text-align: center; margin-top: 20px;"><img src="/img/correct.gif" alt="Submit Correction" border="0" style="width: 110px" /></a>
</div>

<div id="wrap">
	<table class="tbl pad" cellspacing="0">
		<tr>
			<td height="22" width="100"><strong>Current:</strong></td>
			<td width="180" nowrap="nowrap">
				<input type="text" tabindex="1" id="currentxp" value="<?php echo ($current_xp > 0 ? $current_xp : 0); ?>" maxlength="9" onkeyup="sync('current', 'lvl', this.value); reCalculate()" />
				<input type="text" tabindex="4" id="currentlvl" value="<?php echo ($current_lvl ? $current_lvl : 1); ?>" maxlength="2" onkeyup="sync('current', 'xp', this.value); reCalculate()" />
			</td>
			<td rowspan="4" style="border-left: 1px solid #000; vertical-align: top;"><?php echo implode("<br />\n", $opts); ?></td>
		</tr>
		<tr>
			<td height="22" style="border-top: 0; display: none;" id="start_t"><strong>Goal Start:</strong></td>
			<td style="border-top: 0; display: none;" nowrap="nowrap" id="start_f">
				<input type="text" tabindex="2" id="startxp" value="<?php echo ($current_lvl ? findXp($current_lvl) : 0); ?>" maxlength="9" onkeyup="sync('start', 'lvl', this.value); reCalculate()" />
				<input type="text" tabindex="5" id="startlvl" value="<?php echo ($current_lvl ? $current_lvl : 1); ?>" maxlength="2" onkeyup="sync('start', 'xp', this.value); reCalculate()" />
			</td>
		</tr>
		<tr>
			<td height="22" style="border-top: 0;" id="target_t"><strong>Target:</strong></td>
			<td style="border-top: 0;" nowrap="nowrap" id="target_f">
				<input type="text" tabindex="3" id="goalxp" value="<?php echo ($current_lvl ? findXp($current_lvl + 1) : 83); ?>" maxlength="9" onkeyup="sync('goal', 'lvl', this.value); reCalculate()" />
				<input type="text" tabindex="6" id="goallvl" value="<?php echo ($current_lvl ? $current_lvl + 1 : 2); ?>" maxlength="2" onkeyup="sync('goal', 'xp', this.value); reCalculate()" />
			</td>
		</tr>
		<tr>
			<td style="border-top: 0; vertical-align: top;"><!--n--><?php echo (count($sort) > 0)?'<strong>Filter:</strong>':''; ?></td>
			<td style="border-top: 0; vertical-align: top;"><!--n--><?php echo implode("\n", $sort); ?></td>
		</tr>
	</table>
	
	<table class="tbl notice" id="status" style="margin: 4px 0; border-top: 0;" cellspacing="0">
		<tr><td id="status_inner"></td></tr>
	</table>
	
	<table class="tbl" id="actions" cellspacing="0">
		<thead><tr>
			<th class="tabletop" width="20">&nbsp;</th>
			<th class="tabletop" width="20">&nbsp;</th>
			<th class="tabletop">Name</th>
			<th class="tabletop" width="40">Level</th>
			<th class="tabletop" width="40">XP</th>
			<th class="tabletop" width="100" id="last_th">Number</th>
		</tr></thead>
		<tbody>
	<?php echo $table; ?>
		</tbody>
	</table>
	<script type="text/javascript">
	    var actions = new sortableTable("actions",3,"str,str,str,int,float,float");
        window.onload = function(){actions.init();}
		document.getElementById("status").className="tbl boxtop";
		document.getElementById("status_inner").innerHTML="Calculating...";
		reCalculate();
		document.getElementById('currentlvl').onkeydown = function(e) { this.value = crement(e, this.value) };
		document.getElementById('goallvl').onkeydown = function(e) { this.value = crement(e, this.value) };
		document.getElementById('startlvl').onkeydown = function(e) { this.value = crement(e, this.value) };
		<?php echo ($_COOKIE['calc_hidemembers'] == 'true' ? 'if(document.getElementById(\'memb\')) {hideMember(true); document.getElementById(\'memb\').checked=true;}' : ''); ?>
		<?php echo ($_COOKIE['calc_reversemode'] == 'true' ? 'reverseMode(true); document.getElementById(\'reverse\').checked=true;' : ''); ?>
		<?php echo ($_COOKIE['calc_goalstart'] == 'false' ? 'goalStart(false); document.getElementById(\'goalst\').checked=false;' : ''); ?>
	</script>
</div>
<br style="clear: both" />

</div>
<?php
end_page();
