<?php
	if(IN_ZYBEZ !== true) exit;

	if(!empty($user)) {
		$combatstat = getStat($user, 'Combat', 'level');
		foreach($combatstat as $key => $val)
			if($val < 1) $combatstat[$key] = 1;
		
		$attack = $combatstat['Attackl'];
		$strength = $combatstat['Strengthl'];
		$defence = $combatstat['Defencel'];
		$magic = $combatstat['Magicl'];
		$ranged = $combatstat['Rangedl'];
		$prayer = $combatstat['Prayerl'];
		$hitpoints = $combatstat['Hitpointsl'];
	}
	else
		list($attack, $strength, $defence, $magic, $ranged, $prayer, $hitpoints) = array(1, 1, 1, 1, 1, 1, 10);
?>

<script type="text/javascript">
<!--
/*
 *	Javascripted Runescape Calculator
 *	Created by Ryan Hoerr, December 2008
 *	(c) 2008 Zybez Corporation
 */
function reCalculate() {
	combatLevel( document.getElementById('attack').value-0, document.getElementById('defence').value-0, document.getElementById('strength').value-0, document.getElementById('hitpoints').value-0, document.getElementById('prayer').value-0, document.getElementById('ranged').value-0, document.getElementById('magic').value-0);
}

// Javascript-based adaption of "The Combat Formula"
// Courtesy of "The Combat Formula Crew"
// RSB QFC 97-98-9-33330028
function combatLevel(attack, defence, strength, hitpoints, prayer, ranged, magic) {
	var advance;
	
	var base = (defence + hitpoints + Math.floor(prayer / 2)) * 0.25;

	var melee = (attack + strength) * 0.325;
	var range = Math.floor(ranged * 1.5) * 0.325;
	var mage = Math.floor(magic * 1.5) * 0.325;
	var max = Math.max(melee, range, mage);
	
	if(max == melee)
		var type = 'Warrior';
	else if(max == range)
		var type = 'Ranger';
	else if(max == mage)
		var type = 'Mage';

	advance = '<div style="text-align: left;">Combat Level: <span class="value"><b>'+Math.round((base + max) * 100) / 100+'</b> '+type+'</span></div><br />';
	
	
	// Combat calculation is done--now the level-up info
	// NO COPY!
		var next = Math.floor(base+max)+1;
		
		var melee_need = numLevels((base + melee), next, 0.325);
		var range_need = numLevelsRM(ranged, next, base);
		var mage_need = numLevelsRM(magic, next, base);
		var hpdef_need = numLevels((base + max), next, 0.25025);
		var pray_need = numLevels((base + max), next, 0.125);
		
		// Pray
		if(prayer % 2 == 0)
			++pray_need;
		
		var melee_tot = attack + strength + melee_need;
		var range_tot = ranged + range_need;
		var mage_tot = magic + mage_need;
		var hpdef_tot = hitpoints + defence + hpdef_need;
		var pray_tot = prayer + pray_need;
		
		if(melee_tot > 198 && range_tot > 99 && mage_tot > 99 && hpdef_tot > 198 && pray_tot > 99)
			advance += 'You cannot advance your combat level any further.';
		else {
			advance += 'To achieve level '+next+', you need one of the following:<br /><br /><div style="text-align: left">';
			
			if(melee_tot <= 198)
				advance += '- '+melee_need+' Attack or Strength Levels<br />';
			if(hpdef_tot <= 198)
				advance += '- '+hpdef_need+' Hitpoints or Defence Levels<br />';
			if(range_tot <= 99)
				advance += '- '+range_need+' Ranged Levels<br />';
			if(mage_tot <= 99)
				advance += '- '+mage_need+' Magic Levels<br />';
			if(pray_tot <= 99)
				advance += '- '+pray_need+' Prayer Levels<br />';
				
			advance += '</div>';
		}
		
		document.getElementById('advance').innerHTML = advance;
}

function numLevels(start, end, multiple) {
	var need = 0;
	while(start < end) {
		start += multiple;
		++need;
	}
	return need;
}

function numLevelsRM(start, end, dhp) {
	var need = 0;
	var base = start;
	start = Math.floor(start * 1.5) * 0.325;
	while((start + dhp) < end) {
		start = Math.floor((base + ++need) * 1.5) * 0.325;
	}
	return need;
}

function crement(e, value) {
	if(!e)
		var e = event;
	var key = e.which ? e.which : e.keyCode;

	if(key == 38 || key == 39) {
		if(parseInt(value) < 99)
			value++;
	}
	else if(key == 40 || key == 37) {
		if(parseInt(value) > 1)
			value--;
	}
	return value;
}
//-->
</script>
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
.noborder td {
border: 0;
}
.value {
font-size: 18px;
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
</style>

<div class="boxtop">Runescape Combat Calculator</div><div class="boxbottom" style="padding: 6px 24px">

	<div style="margin: 1pt; font-size: large; font-weight: bold;">

		» <a href="calcs.php">Runescape Calculators</a> » <?php=$skill?>
	</div>
	<hr class="main" noshade="noshade" />
	
	<div id="menu">
	<?php=$menulinks?>
	</div>

	<div id="wrap">
		<table class="tbl pad" cellspacing="0">
			<tr>
				<td>
					<table class="pad noborder" cellspacing="0" style="width: 100%">
						<tr>
							<td width="17%">Attack</td><td><input autocomplete="off" tabindex="1" type="text" id="attack" size="5" maxlength="2" value="<?php=$attack?>" onkeyup="reCalculate()" /></td>
							<td width="17%">Ranged</td><td><input autocomplete="off" tabindex="5" type="text" id="ranged" size="5" maxlength="2" value="<?php=$ranged?>" onkeyup="reCalculate()" /></td>
						</tr>
						<tr>
							<td>Strength</td><td><input autocomplete="off" tabindex="2" type="text" id="strength" size="5" maxlength="2" value="<?php=$strength?>" onkeyup="reCalculate()" /></td>
							<td>Magic</td><td><input autocomplete="off" tabindex="6" type="text" id="magic" size="5" maxlength="2" value="<?php=$magic?>" onkeyup="reCalculate()" /></td>
						</tr>
						<tr>
							<td>Defence</td><td><input autocomplete="off" tabindex="3" type="text" id="defence" size="5" maxlength="2" value="<?php=$defence?>" onkeyup="reCalculate()" /></td>
							<td>Prayer</td><td><input autocomplete="off" tabindex="7" type="text" id="prayer" size="5" maxlength="2" value="<?php=$prayer?>" onkeyup="reCalculate()" /></td>
						</tr>
						<tr>
							<td>Hitpoints</td><td><input autocomplete="off" tabindex="4" type="text" id="hitpoints" size="5" maxlength="2" value="<?php=$hitpoints?>" onkeyup="reCalculate()" /></td>

						</tr>
					</table>
				</td>
			</tr>
		</table>
		<div class="notice" id="advance" style="width: auto; margin: 4px 0;">You must have Javascript enabled to use this calculator.<br />If that is not a possibility, please use our <a href="calcs_old.php?calc=<?php=$skill?>">old calculators</a>.</div>
		<div id="debug"></div>
		<script type="text/javascript">
			document.getElementById("advance").className="progress";
			document.getElementById("advance").innerHTML="Calculating...";
			reCalculate();
			
			document.getElementById('attack').onkeydown = function(e) { this.value = crement(e, this.value) };
			document.getElementById('defence').onkeydown = function(e) { this.value = crement(e, this.value) };
			document.getElementById('strength').onkeydown = function(e) { this.value = crement(e, this.value) };
			document.getElementById('hitpoints').onkeydown = function(e) { this.value = crement(e, this.value) };
			document.getElementById('magic').onkeydown = function(e) { this.value = crement(e, this.value) };
			document.getElementById('ranged').onkeydown = function(e) { this.value = crement(e, this.value) };
			document.getElementById('prayer').onkeydown = function(e) { this.value = crement(e, this.value) };
		</script>
	</div>
	<br style="clear: both" />
</div>
<?php
end_page();
?>