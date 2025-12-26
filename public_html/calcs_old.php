<?php
$cleanArr = array(  array('user', $_COOKIE['calc_user'], 'sql', 'l' => 12),
					array('mode', $_COOKIE['calc_mode'], 'int', 's' => '1,2'),
					array('hide', $_COOKIE['calc_hide'], 'bin'),
					array('amount', $_GET['amount'], 'int', 's' => '1,10000000'),
					array('attack', $_GET['attack'], 'int', 's' => '1,99'),
					array('skill', $_GET['calc'], 'enum', 'e' => array('Attack', 'Mining', 'Strength', 'Smithing', 'Defence', 'Fishing', 'Ranged', 'Cooking', 'Magic', 'Firemaking', 'Prayer', 'Woodcutting', 'Runecrafting', 'Crafting', 'Agility', 'Fletching', 'Herblore', 'Slayer', 'Thieving', 'Farming', 'Construction', 'Hunter', 'Summoning', 'Combat', 'Maximum Hit') ),
					array('g_comp', $_GET['comp'], 'enum', 'e' => array('c', 'nc', 'sc') ),
					array('current', $_GET['current'], 'int', 's' => '0,200000000'),
					array('current_type', $_GET['current_type'], 'enum', 'e' => array('level', 'xp') ),
					array('defence', $_GET['defence'], 'int', 's' => '1,99'),
					array('g_display', $_GET['display'], 'enum', 'e' => array('0', 'Course', 'Obstacle', 'Cheap', 'Average', 'Expensive', 'General', 'Fish', 'Ale', 'Gnome', 'Jewelry', 'Glass', 'Leather', 'Battle', 'Bow', 'Ammo', 'Thrown', 'Bowu', 'Potion', 'Herb', 'Mix', 'Regular', 'Ancient', 'Lunar', 'Bar', 'Bronze', 'Iron', 'Steel', 'Mithril', 'Adamant', 'Rune', 'Door', 'Chest', 'Stall', 'Pickpocket', 'Vegetable', 'Flower', 'Bush', 'Herb', 'Fruit', 'Tree', 'Gold', 'Green', 'Crimson','Blue' ) ),
					array('g_hide', $_GET['hide'], 'bin'),
					array('hitpoints', $_GET['hitpoints'], 'int', 's' => '1,99'),
					array('id', $_GET['id'], 'int', 's' => '0,9999'),
					array('level_start', $_GET['level_start'], 'int', 's' => '1,138'),
					array('magic', $_GET['magic'], 'int', 's' => '1,99'),
					array('g_mode', $_GET['mode'], 'int', 's' => '1,2'),
					array('prayer', $_GET['prayer'], 'int', 's' => '1,99'),
					array('ranged', $_GET['ranged'], 'int', 's' => '1,99'),
					array('special', $_GET['special'], 'int', 's' => '0,3'),
					array('start_current', $_GET['start_current'], 'bin'),
					array('strength', $_GET['strength'], 'int', 's' => '1,99'),
					array('level_target', $_GET['target'], 'int', 's' => '1,138'),
					array('g_user', $_GET['user'], 'string', 'l' => 12),
					array('g_xp', $_GET['xp'], 'bin')
				  );

/****** CALCULATORS ******/

require( dirname(__FILE__) . '/' . 'backend.php' );
require( ROOT . '/' . 'calcs_old_functions.inc.php' );

if($disp->errlevel > 1) {
	unset($skill);
	unset($g_user);
}

if (isset($skill)){ start_page( 'Runescape ' . $skill . ' Calculator'); }else{ start_page('Runescape Calculators'); }

echo '<div class="boxtop">Runescape Calculators</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;

if( isset( $_GET['settings'] ) ) {

	?>
	<div style="margin:1px;font-weight:bold;font-size:large;">&raquo; <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">Runescape Calculators</a> &raquo; <u>Settings</u></div>
	<hr class="main" noshade="noshade" />
	<p>You may use this page to customize the configuration of the calculators for your own personal use. You must press the "Update My Settings" button to save your settings.</p>
	<br />
	<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="get">
	<table width="75%" align="center" cellspacing="0" style="border-left: 1px solid #000000">
	<tr>
	<td class="tabletop" colspan="2">RuneScape Name (Optional)</td>
	</tr><tr>
	<td class="tablebottom" width="150">
	<?php
		echo '<input type="text" name="user" maxlength="12" size="20" value="' . stripslashes($user) . '" style="font-family: Verdana; font-size: 10px; text-align: center;" />';
	?>
	</td>	
	<td class="tablebottom"><p>Inputting your runescape name will allow us to automatically retrieve any stats that are visible on the highscores.</p></td>
	</tr></table><br />

	<table width="75%" align="center" cellspacing="0" style="border-left: 1px solid #000000">
	<tr>
	<td class="tabletop" colspan="2">Calculation Mode</td>
	</tr><tr>
	<td class="tablebottom" width="150">
	<?php

	if( isset( $mode ) AND $mode == 2 ) {
		echo '<input type="radio" name="mode" value="1" /> Regular<br />';
		echo '<input type="radio" name="mode" value="2" checked="checked" /> Reversed';
	}
	else {
		echo '<input type="radio" name="mode" value="1" checked="checked" /> Regular<br />';
		echo '<input type="radio" name="mode" value="2" /> Reversed';
	}
	?>
	</td>	
	<td class="tablebottom"><p>The <em>regular</em> calculator mode will tell to how many actions to your target level. The <em>reversed</em> calculator mode does the opposite; tells you what level you will achieve when you do a specified amount of actions.</p></td>
	</tr></table><br />

	<table width="75%" align="center" cellspacing="0" style="border-left: 1px solid #000000">
	<tr>
	<td class="tabletop" colspan="2">Always Hide Member Options?</td>
	</tr><tr>
	<td class="tablebottom" width="150">
	<?php

	if( isset( $hide ) AND $hide == 1 ) {
		echo '<input type="checkbox" name="hide" checked="checked" />';
	}
	else {
		echo '<input type="checkbox" name="hide" />';
	}
	?>
	</td>	
	<td class="tablebottom"><p>Check this box if you want the "Hide Member Options" box on the calculators to be checked by default.</p></td>
	</tr></table><br />
	<center><input type="submit" value="Update My Settings" /></center>
	</form><br />

	<?php
}


/*** SET USER COOKIES PAGE ***/

elseif( isset( $g_user ) AND isset( $g_mode ) ) {

	header( 'refresh: 1; url=' . $_SERVER['SCRIPT_NAME'] );

	if( $g_mode == 1 ) {
		setcookie( 'calc_mode' , '1' , time() + 12000000 ); // SET THE ADVANCED MODE COOKIE
	}
	else {
		setcookie( 'calc_mode' , '2' , time() + 12000000 ); // SET THE SIMPLE MODE COOKIE
	}

	if( isset( $g_user ) ) {
		$user = str_replace( ' ', '_', $g_user ); // REPLACE SPACES WITH UNDERSCORES
		setcookie( 'calc_user' , $_GET['user'] , time() + 12000000 ); // SET THE USER COOKIE
	}
	else {
		setcookie( 'calc_user' , '' , time() - 9600 ); // EXPIRE THE USER COOKIE
	}

	if( isset( $g_hide ) ) {
		setcookie( 'calc_hide' , '1' , time() + 12000000 ); // SET THE HIDE COOKIE
	}
	else {
		setcookie( 'calc_hide' , '' , time() - 9600 ); // EXPIRE THE HIDE COOKIE
	}
	echo '<p align="center">Your settings are being applied. Please wait...</p>' . NL;

}

/*** MAIN CALCULATOR AREA ***/

else {

	/* W13's hack to get rid of that bug in calc_functions that doesn't update from db on the first try */
	if( isset( $user ) ) {
		$bugfixing = get_stat( stripslashes($user), 'Mining', 'xp' );
	}
	/* ---------- */

	// DETERMINE AND ECHO COOKIE SETTINGS
	echo '<div style="float: right; margin: -1px; border: 0;"><strong>' . NL;
	if( isset ( $mode ) AND $mode == 1) {
		echo 'Mode: Regular ' . NL;
	}
	elseif( isset ( $mode ) AND $mode == 2) {
		echo 'Mode: Reversed ' . NL;
	}
	else {
		setcookie( 'calc_mode' , '1' , time() + 12000000 );
		$mode = 1;
		echo 'Mode: Regular ' . NL;
	}

	echo '<br />' . NL;
/*
	if( isset( $user ) ) {
		echo 'Username: ' . stripslashes($user) . ' <a href="?settings" title="Change Username"><img src="/img/calcimg/go.gif" alt="" /></a>' . NL;
	}
	else {
		echo 'Username Not Set' . NL;
	}
*/
	echo '</strong></div>' . NL;

	// SET AVAILABLE CALCULATOR INFORMATION
	$calc_regular = array( 'Farming', 'Defence', 'Attack', 'Strength', 'Ranged', 'Agility', 'Construction', 'Crafting', 'Cooking', 'Firemaking', 'Fishing', 'Fletching', 'Herblore', 'Hunter', 'Magic', 'Mining', 'Prayer', 'Runecrafting', 'Smithing', 'Thieving', 'Woodcutting' );
	$calc_other = array( 'Combat', 'Maximum Hit', 'Slayer' );
	$calc_all = array_merge( $calc_other , $calc_regular );

	// ECHO THE HEADER
	if( isset( $skill ) ) {
		$head_extra = '&raquo; <u>' . $skill . '</u>';
	}
	else $head_extra = '';
	echo '<div style="margin:1px;font-weight:bold;font-size:large;">&raquo; <a href="' . $_SERVER['SCRIPT_NAME'] . '">Runescape Calculators</a> ' . $head_extra . '</div>' . NL;  
	echo '<hr class="main" noshade="noshade" /><br />' . NL;

	// ECHO CALCULATOR NAGIVATION
	echo '<table width="100%" cellspacing="0" cellpadding="5"><tr>' . NL;
	echo '<td width="80" valign="top" align="center">' . NL;

	?>
		<table cellspacing="1" cellpadding="0">
		<tr>
		<td colspan="2"><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>" title="Main"><img src="/img/calcimg/main.gif" width="67" height="17" border="0" alt="Runescape Calculators" /></a></td>
		</tr>
		<tr>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Attack" title="Runescape Calculator for Attack"><img src="/img/calcimg/Attack.gif" width="32" height="32" border="0" alt="Runescape Calculator for Attack" /></a></td>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Mining" title="Runescape Calculator for Mining"><img src="/img/calcimg/Mining.gif" width="32" height="32" border="0" alt="Runescape Calculator for Mining" /></a></td>
		</tr>
		<tr>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Strength" title="Runescape Calculator for Strength"><img src="/img/calcimg/Strength.gif" width="32" height="32" border="0" alt="Runescape Calculator for Strength" /></a></td>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Smithing" title="Runescape Calculator for Smithing"><img src="/img/calcimg/Smithing.gif" width="32" height="32" border="0" alt="Runescape Calculator for Smithing" /></a></td>
		</tr>
		<tr>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Defence" title="Runescape Calculator for Defence"><img src="/img/calcimg/Defence.gif" width="32" height="32" border="0" alt="Runescape Calculator for Defence" /></a></td>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Fishing" title="Runescape Calculator for Fishing"><img src="/img/calcimg/Fishing.gif" width="32" height="32" border="0" alt="Runescape Calculator for Fishing" /></a></td>
		</tr>
		<tr>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Ranged" title="Runescape Calculator for Ranged"><img src="/img/calcimg/Ranged.gif" width="32" height="32" border="0" alt="Runescape Calculator for Ranged" /></a></td>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Cooking" title="Runescape Calculator for Cooking"><img src="/img/calcimg/Cooking.gif" width="32" height="32" border="0" alt="Runescape Calculator for Cooking" /></a></td>
		</tr>
		<tr>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Magic" title="Runescape Calculator for Magic"><img src="/img/calcimg/Magic.gif" width="32" height="32" border="0" alt="Runescape Calculator for Magic" /></a></td>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Firemaking" title="Runescape Calculator for Firemaking"><img src="/img/calcimg/Firemaking.gif" width="32" height="32" border="0" alt="Runescape Calculator for Firemaking" /></a></td>
		</tr>
		<tr>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Prayer" title="Runescape Calculator for Prayer"><img src="/img/calcimg/Prayer.gif" width="32" height="32" border="0" alt="Runescape Calculator for Prayer" /></a></td>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Woodcutting" title="Runescape Calculator for Woodcutting"><img src="/img/calcimg/Woodcutting.gif" width="32" height="32" border="0" alt="Runescape Calculator for Woodcuting" /></a></td>
		</tr>
		<tr>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Runecrafting" title="Runescape Calculator for Runecrafting"><img src="/img/calcimg/Runecrafting.gif" width="32" height="32" border="0" alt="Runescape Calculator for RuneCrafting" /></a></td>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Crafting" title="Runescape Calculator for Crafting"><img src="/img/calcimg/Crafting.gif" width="32" height="32" border="0" alt="Runescape Calculator for Crafting" /></a></td>
		</tr>
		<tr>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Agility" title="Runescape Calculator for Agility"><img src="/img/calcimg/Agility.gif" width="32" height="32" border="0" alt="Runescape Calculator for Agility" /></a></td>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Fletching" title="Runescape Calculator for Fletching"><img src="/img/calcimg/Fletching.gif" width="32" height="32" border="0" alt="Runescape Calculator for Fletching" /></a></td>
		</tr>
		<tr>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Herblore" title="Runescape Calculator for Herblore"><img src="/img/calcimg/Herblore.gif" width="32" height="32" border="0" alt="Runescape Calculator for Herblore" /></a></td>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Slayer" title="Runescape Calculator for Slayer"><img src="/img/calcimg/Slayer.gif" width="32" height="32" border="0" alt="Runescape Calculator for Slayer" /></a></td>
		</tr>
		<tr>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Thieving" title="Runescape Calculator for Thieving"><img src="/img/calcimg/Thieving.gif" width="32" height="32" border="0" alt="Runescape Calculator for Thieving" /></a></td>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Farming" title="Runescape Calculator for Farming"><img src="/img/calcimg/Farming.gif" width="32" height="32" border="0" alt="Runescape Calculator for Farming" /></a></td>
		</tr>
		<tr>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Construction" title="Runescape Calculator for Construction"><img src="/img/calcimg/Construction.gif" width="32" height="32" border="0" alt="Runescape Calculator for Construction" /></a></td>
		<td><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?calc=Hunter" title="Runescape Calculator for Hunter"><img src="/img/calcimg/hunter.gif" width="32" height="32" border="0" alt="Runescape Calculator for Hunter" /></a></td>
		</tr>
		</table>
	<?php

	echo '</td>' . NL;

	// ECHO CALCULATOR CONTENT AREA
	echo '<td valign="top">' . NL;
	echo '<table width="95%" align="center"><tr><td>' . NL;

	/* SKILL CALCULATOR PAGE */

	if( isset( $skill ) && array_search($skill, $calc_other) === false ) {

		// DETERMINE THE SKILL DATA SET

		if( isset( $current ) ) {
			if( isset( $current_type ) AND $current_type == 'level' ) {
				if( $current > 138 ) {
					$current = 138;
				}
				elseif( $current < 1 ) {
					$current = 1;
				}
				$level_current = $current;	
				$xp_current = find_xp( $level_current );
			}
			else {
				$xp_current = $current;	
				$level_current = find_level( $xp_current );
			}
		}
		elseif( !isset( $user ) ) {
			$current = 0;
			$xp_current = 0;
			$level_current = 1;
		}
		else {
			$file = get_file( $user );
			$xp_current = get_stat( $file, $skill, 'xp' );
			$level_current = find_level( $xp_current );
			$current = $xp_current;
		}

		if( $mode == 1 ) {
			if( isset( $level_target ) ) {
				$xp_target = find_xp( $level_target );
			}
			else {
				$level_target = $level_current + 1;
				$xp_target = find_xp( $level_target );
			}
			if( $start_current == 1 ) {
					$level_start = $level_current;
			}
			elseif( !isset( $level_start ) ) {
				$level_start = 1;
			}
		}
		else {
			if( !isset( $amount ) ) {
				$amount = 1;
			}
		}

		// ECHO BEGINNING OF THE FORM
		echo '<form action="' . $_SERVER['SCRIPT_NAME'] . '" method="get">' . NL;
		echo '<input type="hidden" name="calc" value="' . $skill . '" />' . NL;

		// ECHO CURRENT AND OTHER INPUT FIELDS

		if( $mode == 1 ) {

			echo '<table width="100%" align="center" class="boxtop" style="border: 1px solid black;" cellspacing="2" cellpadding="0">' . NL;
			echo '<tr>' . NL;
			echo '<td align="right">Goal Starting Level:</td>' . NL;
			echo '<td width="70"><input type="text" name="level_start" size="5" maxlength="3" value="' . $level_start . '" /></td>' . NL;
      echo '<td align="left"><input type="checkbox" name="start_current" value="1" /> Use Current Level</td>' . NL;
			echo '<td align="center" width="80">Current:</td>' . NL;
			echo '<td align="left"><input type="text" name="current" size="13" maxlength="10" value="' . $current . '" /></td>' . NL;
			echo '</tr>' . NL;
			echo '<tr>' . NL;
			echo '<td align="right">Goal Target Level:</td>' . NL;
			echo '<td><input type="text" name="target" size="5" maxlength="3" value="' . $level_target . '" /></td>' . NL;
			echo '<td>&nbsp;</td>' . NL;
	
			if( isset( $current_type ) AND $current_type == 'level' ) {
				echo '<td align="center"><input type="radio" name="current_type" value="xp" /> XP</td>' . NL;
				echo '<td align="left"><input type="radio" name="current_type" value="level" checked="checked" /> Level</td>' . NL;
			}
			else {
				echo '<td align="center"><input type="radio" name="current_type" value="xp" checked="checked" /> XP</td>' . NL;
				echo '<td align="left"><input type="radio" name="current_type" value="level" /> Level</td>' . NL;
			}
			echo '</tr>' . NL;
			echo '</table><br />' . NL;
		}
		else {
			echo '<table width="100%" align="center" class="boxtop" style="border: 1px solid black;" cellspacing="2" cellpadding="0">' . NL;
			echo '<tr>' . NL;
			echo '<td align="right" width="25%">Current:</td>' . NL;
			echo '<td align="center" width="100"><input type="text" name="current" size="13" maxlength="10" value="' . $current . '" /></td>' . NL;
			echo '<td>&nbsp;</td>' . NL;
			echo '<td align="center" width="140">Number of Actions:</td>' . NL;
			echo '<td align="left" width="25%"><input type="text" name="amount" size="10" maxlength="8" value="' . $amount . '" /></td>' . NL;
			echo '</tr><tr>' . NL;

			if( isset( $current_type ) AND $current_type == 'level' ) {
				echo '<td align="right"><input type="radio" name="current_type" value="xp" /> XP</td>' . NL;
				echo '<td align="center"><input type="radio" name="current_type" value="level" checked="checked" /> Level</td>' . NL;
			}
			else {
				echo '<td align="right"><input type="radio" name="current_type" value="xp" checked="checked" /> XP</td>' . NL;
				echo '<td align="center"><input type="radio" name="current_type" value="level" /> Level</td>' . NL;
			}
			echo '</tr>' . NL;
			echo '</table><br />' . NL;
		}
		
		echo '<table width="100%" align="center" class="boxtop" style="border: 1px solid black;" cellspacing="2" cellpadding="0"><tr>' . NL;

		// ECHO HIDE MEMBERS OPTION BOX
		if( $skill != 'Agility' AND $skill != 'Construction' AND $skill != 'Herblore' AND $skill != 'Hunter' AND $skill != 'Fletching' AND $skill != 'Farming' AND $skill != 'Slayer' AND $skill != 'Thieving' AND $skill != 'Summoning' ) {
			if( $g_hide == 1 OR $hide == 1 ) {
				echo '<td valign="top" align="center"><input type="checkbox" name="hide" checked="checked" /> Hide Member Options</td>' . NL;
			}
			else {
				echo '<td valign="top" align="center"><input type="checkbox" name="hide" /> Hide Member Options</td>' . NL;
			}
		}
		
		// ECHO SPECIAL OPTIONS
		if( $skill == 'Prayer' ) {
		echo '<td valign="top" align="left">';
			if( $special == 1 ) {
				echo '<input type="radio" name="special" value="1" checked="checked" /> Use the Ectofuntus<br />' . NL;
				echo '<input type="radio" name="special" value="2" /> Use Gilded Altar (2 marble burners)' . NL;
			}
			elseif( $special == 2 ) {
				echo '<input type="radio" name="special" value="1" /> Use the Ectofuntus<br />' . NL;
				echo '<input type="radio" name="special" value="2" checked="checked" /> Use Gilded Altar (2 marble burners)' . NL;
			}
			else {
				echo '<input type="radio" name="special" value="1" /> Use the Ectofuntus<br />' . NL;
				echo '<input type="radio" name="special" value="2" /> Use Gilded Altar (2 marble burners)' . NL;
			}
			echo '</td>';
		}
		elseif( $skill == 'Firemaking' ) {
		echo '<td valign="top" align="left">';
			if( $special == 1 ) {
				echo '<input type="radio" name="special" value="0" /> With No Enhancers<br />' . NL;
				echo '<input type="radio" name="special" value="1" checked="checked" /> With Flame Gloves or Ring of Fire<br />' . NL;
				echo '<input type="radio" name="special" value="2" /> With Flame Gloves and Ring of Fire' . NL;
			}
			elseif( $special == 2 ) {
				echo '<input type="radio" name="special" value="0" /> With No Enhancers<br />' . NL;
				echo '<input type="radio" name="special" value="1" /> With Flame Gloves or Ring of Fire<br />' . NL;
				echo '<input type="radio" name="special" value="2" checked="checked" /> With Flame Gloves and Ring of Fire' . NL;
			}
			else {
				echo '<input type="radio" name="special" value="0" checked="checked" /> With No Enhancers<br />' . NL;
				echo '<input type="radio" name="special" value="1" /> With Flame Gloves or Ring of Fire<br />' . NL;
				echo '<input type="radio" name="special" value="2" /> With Flame Gloves and Ring of Fire' . NL;
			}
			echo '</td>';

		}
		elseif( $skill == 'Woodcutting' ) {
			if( $special == 1 ) {
				echo '<td valign="top" align="center"><input type="checkbox" name="special" value="1" checked="checked" /> Wear full lumberjack</td>' . NL;
			}
			else {
				echo '<td valign="top" align="center"><input type="checkbox" name="special" value="1" /> Wear full lumberjack</td>' . NL;
			}
		}

		elseif( $skill == 'Ranged' ) {
			echo '<td valign="top" align="left">' . NL;
			if( $special == 1 ) {
				echo '<input type="radio" name="special" value="0" /> Accurate Mode<br />' . NL;
				echo '<input type="radio" name="special" value="1" checked="checked" /> Rapid Mode<br />' . NL;
				echo '<input type="radio" name="special" value="2" /> Longrange Mode<br />' . NL;
				echo '<input type="radio" name="special" value="3" /> Cannon Mode<br />' . NL;
			}
			elseif( $special == 2 ) {
				echo '<input type="radio" name="special" value="0" /> Accurate Mode<br />' . NL;
				echo '<input type="radio" name="special" value="1" /> Rapid Mode<br />' . NL;
				echo '<input type="radio" name="special" value="2" checked="checked" /> Longrange Mode<br />' . NL;
				echo '<input type="radio" name="special" value="3" /> Cannon Mode<br />' . NL;
			}
			elseif( $special == 3 ) {
				echo '<input type="radio" name="special" value="0" /> Accurate Mode<br />' . NL;
				echo '<input type="radio" name="special" value="1" /> Rapid Mode<br />' . NL;
				echo '<input type="radio" name="special" value="2" /> Longrange Mode<br />' . NL;
				echo '<input type="radio" name="special" value="3" checked="checked" /> Cannon Mode<br />' . NL;
			}
			else {
				echo '<input type="radio" name="special" value="0" checked="checked" /> Accurate Mode<br />' . NL;
				echo '<input type="radio" name="special" value="1" /> Rapid Mode<br />' . NL;
				echo '<input type="radio" name="special" value="2" /> Longrange Mode<br />' . NL;
				echo '<input type="radio" name="special" value="3" /> Cannon Mode<br />' . NL;
			}
			echo '</td>' . NL;
		}
		elseif( $skill == 'Attack' ) {
			echo '<td valign="top" align="left">' . NL;
			if( $special == 1 ) {
				echo '<input type="radio" name="special" value="0" /> Accurate Mode<br />' . NL;
				echo '<input type="radio" name="special" value="1" checked="checked" /> Controlled Mode<br />' . NL;
			}
			else {
				echo '<input type="radio" name="special" value="0" checked="checked" /> Accurate Mode<br />' . NL;
				echo '<input type="radio" name="special" value="1" /> Controlled Mode<br />' . NL;
			}
			echo '</td>' . NL;
		}
		elseif( $skill == 'Strength' ) {
			echo '<td valign="top" align="left">' . NL;
			if( $special == 1 ) {
				echo '<input type="radio" name="special" value="0" /> Aggressive Mode<br />' . NL;
				echo '<input type="radio" name="special" value="1" checked="checked" /> Controlled Mode<br />' . NL;
			}
			else {
				echo '<input type="radio" name="special" value="0" checked="checked" /> Aggressive Mode<br />' . NL;
				echo '<input type="radio" name="special" value="1" /> Controlled Mode<br />' . NL;
			}
			echo '</td>' . NL;
		}
		elseif( $skill == 'Defence' ) {
			echo '<td valign="top" align="left">' . NL;
			if( $special == 1 ) {
				echo '<input type="radio" name="special" value="0" /> Melee: Defensive Mode<br />' . NL;
				echo '<input type="radio" name="special" value="1" checked="checked" /> Melee: Controlled Mode<br />' . NL;
				echo '<input type="radio" name="special" value="2" /> Ranged: Longrange Mode<br />' . NL;
				echo '<input type="radio" name="special" value="3" /> Magic: Focus (Defensive) Mode<br />' . NL;
			}
			elseif( $special == 2 ) {
				echo '<input type="radio" name="special" value="0" /> Melee: Defensive Mode<br />' . NL;
				echo '<input type="radio" name="special" value="1" /> Melee: Controlled Mode<br />' . NL;
				echo '<input type="radio" name="special" value="2" checked="checked" /> Ranged: Longrange Mode<br />' . NL;
				echo '<input type="radio" name="special" value="3" /> Magic: Focus (Defensive) Mode<br />' . NL;
			}
			elseif( $special == 3 ) {
				echo '<input type="radio" name="special" value="0" /> Melee: Defensive Mode<br />' . NL;
				echo '<input type="radio" name="special" value="1" /> Melee: Controlled Mode<br />' . NL;
				echo '<input type="radio" name="special" value="2" /> Ranged: Longrange Mode<br />' . NL;
				echo '<input type="radio" name="special" value="3" checked="checked" /> Magic: Focus (Defensive) Mode<br />' . NL;
			}
			else {
				echo '<input type="radio" name="special" value="0" checked="checked" /> Melee: Defensive Mode<br />' . NL;
				echo '<input type="radio" name="special" value="1" /> Melee: Controlled Mode<br />' . NL;
				echo '<input type="radio" name="special" value="2" /> Ranged: Longrange Mode<br />' . NL;
				echo '<input type="radio" name="special" value="3" /> Magic: Focus (Defensive) Mode<br />' . NL;
			}
			echo '</td>' . NL;
		}

		// ECHO INFORMATION DISPLAY OPTIONS

		$display_options = array(
			'Agility' => array( 'Course' => 'Show Agility Courses', 'Obstacle' => 'Show Other Obstacles' ),
			'Construction' => array( 'Cheap' => 'Show Cheap Method', 'Average' => 'Show Mid-range Method', 'Expensive' => 'Show Expensive Method' ),
			'Cooking' => array( 'General' => 'Show General Items', 'Fish' => 'Show Fish', 'Ale' => 'Show Ales/Brewing', 'Gnome' => 'Show Gnome Cuisine' ),
			'Crafting' => array( 'General' => 'Show General Items', 'Jewelry' => 'Show Jewelry and Gems', 'Glass' => 'Show Glassblowing', 'Leather' => 'Show Leather Items', 'Battle' => 'Show Battlestaves' ),
			'Fletching' => array( 'Bow' => 'Show Bows', 'Ammo' => 'Show Arrows', 'Thrown' => 'Show Darts', 'Bowu' => 'Show Unstrung Bows' ),
			'Herblore' => array( 'Potion' => 'Show Potions', 'Herb' => 'Show Herbs', 'Mix' => 'Show Mixed Potions' ),
			'Magic' => array( 'Regular' => 'Show Regular Spells', 'Ancient' => 'Show Ancient Magicks', 'Lunar' => 'Show Lunar Spells' ),
			'Smithing' => array( 'Bar' => 'Show Metal Bars', 'Bronze' => 'Show Bronze Smithing', 'Iron' => 'Show Iron Smithing', 'Steel' => 'Show Steel Smithing', 'Mithril' => 'Show Mithril Smithing', 'Adamant' => 'Show Adamant Smithing', 'Rune' => 'Show Runite Smithing' ),
			'Thieving' => array( 'Door' => 'Show Doors', 'Chest' => 'Show Chest Looting', 'Stall' => 'Show Stall Grabbing', 'Pickpocket' => 'Show Pickpocketing' ),
			'Farming' => array( 'Vegetable' => 'Show Vegetables', 'Flower' => 'Show Flowers', 'Bush' => 'Show Bushes', 'Herb' => 'Show Herbs', 'Fruit' => 'Show Fruit Tree', 'Tree' => 'Show Regular Trees', 'General' => 'Show Special Plants' ),
			'Summoning' => array( 'Gold' => 'Gold Charm Pouches', 'Green' => 'Green Charm Pouches', 'Crimson' => 'Crimson Charm Pouches', 'Blue' => 'Blue Charm Pouches' )
			);

		if( array_key_exists( $skill, $display_options ) ) {

			$skill_options = $display_options[$skill];

			if( $g_display != 0 ) {
				echo '<td valign="top" align="right">Show All<input type="radio" name="display" value="0" /></td>' . NL;
			}
			else {
				echo '<td valign="top" align="right">Show All<input type="radio" name="display" value="0" checked="checked" /></td>' . NL;
			}
			echo '<td align="left">' . NL;
		
			foreach( $skill_options as $code => $text ) {
				if( isset( $g_display ) AND $g_display == $code ) {
					echo '<input type="radio" name="display" value="' . $code . '" checked="checked" />' . $text . '<br />' . NL;
				}
				else {
					echo '<input type="radio" name="display" value="' . $code . '" />' . $text . '<br />' . NL;
				}
			}
			echo '</td>' . NL;
		}

		if( $skill == 'Farming' ) {

			echo '<td align="left" valign="top">' . NL;

			if( $g_comp == 'nc' OR !isset( $g_comp ) ) {
				echo '<input type="radio" name="comp" value="nc" checked="checked" />No Compost<br />' . NL;
			}
			else {
				echo '<input type="radio" name="comp" value="nc" />No Compost<br />' . NL;
			}
			if( $g_comp == 'c' ) {
				echo '<input type="radio" name="comp" value="c" checked="checked" />Compost<br />' . NL;
			}
			else {
				echo '<input type="radio" name="comp" value="c" />Compost<br />' . NL;
			}
			if( $g_comp == 'sc' ) {
				echo '<input type="radio" name="comp" value="sc" checked="checked" />Super Compost<br />' . NL;
			}
			else {
				echo '<input type="radio" name="comp" value="sc" />Super Compost<br />' . NL;
			}
			echo '</td>' . NL;
		}
	
		echo '</tr>' . NL;
	
		// ECHO END OF THE FORM
		echo '<tr><td colspan="10" align="right"><input type="submit" value="Calculate" /></td></tr>' . NL;
		echo '</table>' . NL;
		echo '</form>' . NL;

		if( $skill == 'Farming' AND !isset( $current ) AND !isset( $current_type ) ) {
			echo '<p align="center">This unique Farming calculator relies on a few concepts. First of all, Vegetables and Herb harvest numbers are based on specific averages with certain types of compost. These averages are not exact, although they are quite realistic.<br />' . NL;
			echo 'This calculator also assumes that, for regenerating plants - such as bushes and fruit trees - you pick the first harvest, then dig up the plant to plant another, not allowing for any regeneration.</p>' . NL;
		}

		if( isset( $current ) AND isset( $current_type ) ) {

			// DISPLAY OPTION CHECK AND CONFIG
			$query_where = '';

			if( isset( $g_display ) AND array_key_exists( $skill, $display_options ) AND array_key_exists( $g_display, $display_options[$skill] ) ) {
				$query_where = $query_where . " AND `calc_type` = '" . $g_display . "'";
			}

			// HIDE MEMBER CONFIG
	 		if( $g_hide == 1 || $hide == 1 ) {
				$query_where = $query_where . " AND `member` = 0";
			}

			// SPECIAL OPTION CHECK AND CONFIG
		 	if( isset( $special ) ) {

				if( $skill == 'Prayer' AND $special == 1 ) {
					$query_where = $query_where . " AND `calc_type` = 'Bone'";
					$xp_change = 4;
				}
				elseif( $skill == 'Prayer' AND $special == 2 ) {
					$query_where = $query_where . " AND `calc_type` = 'Bone'";
					$xp_change = 3.5;
				}
				if( $skill == 'Firemaking' AND $special == 1 ) {
					$query_where = $query_where . " AND `name` NOT LIKE '%ship%'";
					$xp_change = 1.02;
				}
				elseif( $skill == 'Firemaking' AND $special == 2 ) {
					$query_where = $query_where . " AND `name` LIKE '%log%'";
					$xp_change = 1.05;
				}
				elseif( $skill == 'Woodcutting' AND $special == 1 ) {
					$xp_change = 1.025;
				}
				elseif( $skill == 'Ranged' AND ( $special == 2 OR $special == 3 ) ) {
					$xp_change = 1 / 2;
				}
				elseif( ( $skill == 'Attack' OR $skill == 'Strength' ) AND $special == 1 ) {
					$xp_change = 1 / 3;
				}
				elseif( $skill == 'Defence' AND $special == 0 ) {
					$skill_cat = 'Warrior';
				}
				elseif( $skill == 'Defence' AND $special == 1 ) {
					$skill_cat = 'Warrior';
					$xp_change = 1 / 3;
				}
				elseif( $skill == 'Defence' AND $special == 2 ) {
					$skill_cat = 'Ranged';
					$xp_change = 1 / 2;
				}
				elseif( $skill == 'Defence' AND $special == 3 ) {
					$skill_cat = 'Magicdef';
				}
			}
			if( !isset( $xp_change ) ) {
				$xp_change = 1;
			}

			// CATAGORY CONFIG
	 		if( $skill == 'Attack' OR $skill == 'Strength' ) {
				$skill_cat =  'Warrior';
			}
			elseif ( $skill != 'Defence' ) {
				$skill_cat = $skill;
			}

			// FARMING COMPOST EFFECTS
			$herb_nc = 5;
			$herb_c = 6;
			$herb_sc = 7;						
			$veg_nc = 8;
			$veg_c = 9;
			$veg_sc = 11;

			if( $skill =='Farming' AND $g_comp == 'c' ) {
				$herb = $herb_c;
				$veg = $veg_c;
			}
			elseif( $skill =='Farming' AND $g_comp == 'sc' ) {
				$herb = $herb_sc;
				$veg = $veg_sc;
			}
			elseif( $skill =='Farming' ) {
				$herb = $herb_nc;
				$veg = $veg_nc;
			}


			if( isset( $level_target ) ) {

				// CHECK XP AND LEVEL AMOUNTS
				if( $level_target <= $level_current OR $level_start == $level_target) {

					if( $level_target <= $level_current ) {
					echo '<p align="center">' . NL;
					echo 'An error has occured in processing your request. It could be because:<br /><br />' . NL;	
					echo 'You have already accomplished your goal<br />' . NL;
					echo '</p>' . NL;
					}
					if( $level_start == $level_target ) {
					$level_target = $level_start + 1;
					header("Location: /calcs.php?calc=" . $skill . "&level_start=" . $level_start . "&current=" . $level_current . "&target=" . $level_target . "&current_type=level&display=" . $g_display );
						//echo 'Your goal starting level is the same as your target level.<br />' . NL;
					}

				}
				else {

					// INITIAL CALCULATIONS

					$xp_need = $xp_target - $xp_current;

					$xp_need_disp = number_format( $xp_need );
					$xp_current_disp = number_format( $xp_current );

					$xp_start = find_xp( $level_start );
					$xp_goal = $xp_target - $xp_start;

					$progress = $xp_current - $xp_start;
					$progress = $progress / $xp_goal;
					$progress = $progress * 100;
					$progress = floor( $progress );

					// ECHO TEXT BASED PROGRESS

					echo '<p align="center">' . NL;
					echo 'Your goal is to advance from level ' . $level_start . ' to level ' . $level_target . ' ' . $skill . '.<br />' . NL; 
					echo 'At the moment, you are at level ' . $level_current . ' with ' . number_format($xp_current) . ' XP.<br />' . NL;
					echo 'You have completed ' . $progress . '% of your goal and you will need a total of ' . number_format($xp_need) . ' XP to finish it!' . NL;
					echo '</p>' . NL;
	
					// ECHO PROGRESS BAR
					echo '<table class="boxtop" border="0" cellpadding="1" cellspacing="2" width="80%" align="center" style="border: 1px solid black;">' . NL;
					echo '<tr>' . NL;
					echo '<td align="center" colspan="3">Current Level: ' . $level_current . '</td>' . NL;
					echo '</tr>' . NL;
					echo '<tr>' . NL;
					echo '<td valign="top" align="center" rowspan="2" width="125">Starting Level: ' . $level_start . '</td>' . NL;
					echo '<td>' . NL;
					echo '<table width="100%" cellpadding="1" cellspacing="0" style="border: 1px solid black;"><tr>' . NL;
		
					if( $progress == 0 ) {
						echo '<td bgcolor="#B80000">&nbsp;</td>' . NL;
					}
					elseif( $progress > 0 AND $progress < 5 ) {
						echo '<td bgcolor="#009E00" width="' . $progress . '%" align="center">&nbsp;</td>' . NL;
						echo '<td bgcolor="#B80000" style="border-left: 1px solid black;"></td>' . NL;
					}
					else {
						echo '<td bgcolor="#009E00" width="' . $progress . '%" align="center">' . $progress . '%</td>' . NL;
						echo '<td bgcolor="#B80000" style="border-left: 1px solid black;"></td>' . NL;
					}
					echo '</tr></table>' . NL;
					echo '</td>' . NL;
					echo '<td valign="top" align="center" rowspan="2" width="125">Target Level: ' . $level_target . '</td>' . NL;
					echo '</tr>' . NL;
					echo '<tr>' . NL;
					echo '<td align="center">' . $xp_need_disp . ' XP Remaining in your Goal.</td>' . NL;
					echo '</tr>' . NL;
					echo '</table><br />' . NL;
					
$cskill = $skill;

if( $skill == 'Attack' OR $skill == 'Defence' OR $skill == 'Strength' ) {
$cskill = "Warrior";
					}
					
$cquery = $db->query("SELECT `id` FROM `calc_info` WHERE `calc_name`= '".$cskill."' LIMIT 1");

while ($cinfo = $db->fetch_array($cquery)) {
	
echo '<center><a href="/correction.php?area=calc_info&amp;id=' . $cinfo['id'] . '" title="Submit a Correction"><img src="/img/correct.gif" alt="Submit Correction" border="0" /></a></center>'.NL;
					
            }
            
            
					// ECHO OTHER STAT ADVANCEMENT IF APPLICABLE
					if( $skill == 'Attack' OR $skill == 'Strength' ) {

						if( isset( $special ) AND $special == 1 ) {
							echo '<p>Completing your goal in the controlled Melee mode will also give you experience in other combat areas. You will gain ' . $xp_need_disp . ' XP in Attack, Strength, Defence and Hitpoints. Please be sure that you are aware of this.</p>' . NL;
						}
						else {
							$xp_hp = $xp_need / 3;
							$xp_hp = floor($xp_hp);
							$xp_hp = number_format($xp_hp);
							echo '<p>Completing your goal in this Melee specialized mode will also give you ' . $xp_hp . ' Hitpoints XP. Please be sure that you are aware of this.</p>' . NL;
						}
					}
					elseif( $skill == 'Defence' ) {
				
						if( isset( $special ) AND $special == 1 ) {
							echo '<p>Completing your goal in the controlled Melee mode will also give you experience in other combat areas. You will gain ' . $xp_need_disp . ' XP in Attack, Strength, Defence and Hitpoints. Please be sure that you are aware of this.</p>' . NL;
						}
						elseif( isset( $special ) AND $special == 2 ) {
							$xp_hp = $xp_need * 2 / 3;
							$xp_hp = floor($xp_hp);
							$xp_hp = number_format($xp_hp);
							echo '<p>Completing your goal in the longrange Ranged mode will also give you experience in other combat areas. You will also gain ' . $xp_need_disp . ' XP in Ranged and ' . $xp_hp . ' XP in Hitpoints. Please be sure that you are aware of this.</p>' . NL;
						}
						elseif( isset( $special ) AND $special == 3 ) {
							$xp_hp = $xp_need * 4 / 3;
							$xp_hp = floor($xp_hp);
							$xp_hp = number_format($xp_hp);
							echo '<p>Completing your goal with Magic attacks will also give you ' . $xp_hp . ' Hitpoints XP. Since you are using magic spells, you will gain Magic Xp as well. Please be sure that you are aware of this.</p>' . NL;
						}
						else {
							$xp_hp = $xp_need / 3;
							$xp_hp = floor($xp_hp);
							$xp_hp = number_format($xp_hp);
							echo '<p>Completing your goal in the defensive Melee mode will also give you ' . $xp_hp . ' Hitpoints XP. Please be sure that you are aware of this.</p>' . NL;
						}
					}
					elseif( $skill == 'Ranged' ) {
						$xp_hp = $xp_need / 3;
						$xp_hp = floor($xp_hp);
						$xp_hp = number_format($xp_hp);

						if( isset( $special ) AND $special == 1 ) {
							echo '<p>Completing your goal in the rapid Ranged mode will also give you ' . $xp_hp . ' Hitpoints XP. Please be sure that you are aware of this.</p>' . NL;
						}
						elseif( isset( $special ) AND $special == 2 ) {
							echo '<p>Completing your goal in the longrange Ranged mode will also give you experience in other combat areas. You will gain ' . $xp_need_disp . ' XP in Defence and ' . $xp_hp . ' XP in Hitpoints. Please be sure that you are aware of this.</p>' . NL;
						}
						elseif( !isset( $special ) OR ( isset( $special ) AND $special != 3 ) ) {
							echo '<p>Completing your goal in the accurate Range mode will also give you ' . $xp_hp . ' Hitpoints XP. Please be sure that you are aware of this.</p>' . NL;
						}
					}
					elseif( $skill == 'Magic' ) {
						echo '<p>Combat type spells will always give you Hitpoints XP. If you use a staff and the \'Focus Mode\' you will also gain Defence XP. When advancing your magic level, please be aware that these spells will give out these extra experience points.</p>' . NL;
						echo '<p>When using combat type magic spells you will be given a set base XP each time, plus 2 XP for per a damage. This calculator ONLY shows the base XP for each combat type spell. Plus be aware that they will in fact give more XP if you do damage.</p>' . NL;
					}
		
					// MYSQL QUERY	
					$quero = "SELECT * FROM `calc_info` WHERE `calc_name` = '" . $skill_cat . "'" . $query_where . " ORDER BY `level` ASC, `xp` ASC, `name` ASC";
					$query = $db->query($quero);

					// ECHO ITEM TABLE, CALCULATE AMOUNTS
				
					if( $skill == 'Attack' OR $skill == 'Defence' OR $skill == 'Strength' OR $skill == 'Ranged' ) {

						echo '<p>The table below, provides a number of different options to help you reach level ' . $level_target . ' ' . $skill . '.</p>' . NL;
	
						echo '<table cellspacing="0" width="100%" style="border: none; border-left: 1px solid #000000" cellpadding="0" align="center"><tr>' . NL;
						echo '<th class="tabletop" width="20%">Monster\'s Level</th>' . NL;
						echo '<th class="tabletop" width="30%">Name</th>' . NL;
						echo '<th class="tabletop" width="20%">XP Given</th>' . NL;
						echo '<th class="tabletop">Amount to Level ' . $level_target . '</th>'. NL;
						echo '</tr>' . NL;

						while( $info = $db->fetch_array($query) ) {

							$xp_item = rtrim( $info['xp'], '0' );
							$xp_item = rtrim( $xp_item, '.' );
							$xp_item = $xp_item * $xp_change;
							$xp_item = round( $xp_item , 2 );

							$num_item = $xp_need / $xp_item;
							$num_item = ceil( $num_item );
							$num_item = number_format( $num_item );
	
							if( $info['level'] > $level_target ) {
								$ability_image = 'a_red.PNG';
							}
							elseif( $info['level'] > $level_current ) {
								$ability_image = 'a_yellow.PNG';
							}
							else {
								$ability_image = 'a_green.PNG';
							}
			
							echo '<tr>' . NL;
							echo '<td class="tablebottom">' . $info['level'] . '</td>' . NL;
							echo '<td class="tablebottom">' . $info['name']  . '</td>' . NL;
							echo '<td class="tablebottom">' . $xp_item  . '</td>' . NL;
							echo '<td class="tablebottom">' . $num_item . '</td>' . NL;
							echo '</tr>' . NL;
						}
					}
					else {

						echo '<p align="center">The table below, provides a number of different options to help you reach level ' . $level_target . ' ' . $skill . '.</p>' . NL;
								
						echo '<table border="0" cellpadding="3" cellspacing="0" width="100%" align="center"><tr>' . NL;
						echo '<td align="right"><img src="/img/calcimg/a_green.PNG" alt="" /></td><td align="left">You Have This Ability</td>' . NL;
						echo '<td align="right"><img src="/img/calcimg/a_yellow.PNG" alt="" /></td><td align="left">No Ability, Within Goal Range</td>' . NL;
						echo '<td align="right"><img src="/img/calcimg/a_red.PNG" alt="" /></td><td align="left">No Ability, Not Within Goal Range</td>' . NL;
						echo '</tr></table><br />' . NL;

						echo '<table cellspacing="0" width="100%" style="border: none; border-left: 1px solid #000000" cellpadding="0" align="center"><tr>' . NL;
						echo '<th class="tabletop" width="25">&nbsp;</th>' . NL;
						echo '<th class="tabletop" width="13%">Level</th>' . NL;
						echo '<th class="tabletop" width="50">Image</th>' . NL;
						echo '<th class="tabletop" width="35%">Name</th>' . NL;

						if( $skill != 'Farming' ) {
							echo '<th class="tabletop" width="15%">XP Given</th>' . NL;
						}
						echo '<th class="tabletop">Amount to Level ' . $level_target . '</th>' . NL;
						echo '</tr>' . NL;

						while( $info = $db->fetch_array($query) ) {

							$xp_item = rtrim( $info['xp'], '0' );
							$xp_item = rtrim( $xp_item, '.' );
							$xp_item = $xp_item * $xp_change;
							$xp_item = round( $xp_item , 2 );

							if( $skill == 'Farming' ) {

								if( $info['calc_type'] == 'Vegetable' ) {
									$xp_item = $xp_item + ( $veg * $info['xp_more'] );
								}
								elseif( $info['calc_type'] == 'Herb' ) {
									$xp_item = $xp_item + ( $herb * $info['xp_more'] );
								}
								elseif( $info['calc_type'] == 'Fruit' OR $info['name'] == 'Bittercap mushroom' OR $info['name'] == 'Calquat tree' ) {
									$xp_item = $xp_item + ( 6 * $info['xp_more'] );
								}
								elseif( $info['calc_type'] == 'Bush' ) {
									$xp_item = $xp_item + ( 4 * $info['xp_more'] );
								}
								elseif( $info['calc_type'] == 'Flower' OR $info['name'] == 'Belladonna(nightshade)' ) {
									$xp_item = $xp_item + ( 1 * $info['xp_more'] );
								}
								elseif( $info['name'] == 'Cactus plant' ) {
									$xp_item = $xp_item + ( 3 * $info['xp_more'] );
								}
							}

							$num_item = $xp_need / $xp_item	;
							$num_item = ceil( $num_item )	;
							$num_item = number_format( $num_item );	

							if( $info['level'] > $level_target ) {
								$ability_image = 'a_red.PNG';
							}
							elseif( $info['level'] > $level_current ) {
								$ability_image = 'a_yellow.PNG';
							}
							else {
								$ability_image = 'a_green.PNG';
							}
			
							echo '<tr>' . NL;
							echo '<td class="tablebottom"><img src="/img/calcimg/' . $ability_image . '" alt="" /></td>' . NL;
							echo '<td class="tablebottom">' . $info['level'] . '</td>' . NL;
							echo '<td class="tablebottom" valign="middle"><img src="/img/' . $info['image']  . '" width="30" height="30" alt="Runescape Image for ' . $info['name']  . '"/></td>' . NL;
							echo '<td class="tablebottom">' . $info['name']  . '</td>' . NL;

							if( $skill != 'Farming' ) {
								echo '<td class="tablebottom">' . $xp_item  . '</td>' . NL;
							}
							echo '<td class="tablebottom">' . $num_item . '</td>' . NL;
							echo '</tr>' . NL;
						}
					}
					$entry_count = $db->num_rows( $quero );
			
					if ( $entry_count == 0 ) {
					echo '<tr><td class="tablebottom" align="center" colspan="6">The calculator did not return any results for your criteria. Please try again.</td></tr>' . NL;
					}
					echo '</table>' . NL;
				}
			}
			elseif( isset( $amount ) ) {

				$next_level = $level_current + 1;
				$xp_next_level = find_xp( $next_level );
				$xp_next_level = $xp_next_level - $xp_current;	
				$xp_next_level = number_format( $xp_next_level );

				$xp_current_disp = number_format( $xp_current );
				$amount_disp = number_format( $amount );

				// ECHO TEXT BASED ANALYSIS
				echo '<p>You are currently level ' . $level_current . ' ' . $skill . ' with ' . $xp_current_disp . '. You are ' . $xp_next_level . ' XP away from the next level.</p>' . NL;
				echo '<p>The table below will tell you what level you will achieve if you do one of the actions <strong>' . $amount_disp . '</strong> times.</p>' . NL;

				// MYSQL QUERY	
				$quero = "SELECT * FROM `calc_info` WHERE `calc_name` = '" . $skill_cat . "'" . $query_where . " ORDER BY `level` ASC, `xp` ASC, `name` ASC";
				$query = $db->query($quero);

				// ECHO ITEM TABLE, CALCULATE AMOUNTS
				
				if( $skill == 'Attack' OR $skill == 'Defence' OR $skill == 'Strength' OR $skill == 'Ranged' ) {

					echo '<p>The table below, provides a number of different options to help you reach level ' . $level_target . ' ' . $skill . '.</p>' . NL;
	
					echo '<table cellspacing="0" width="100%" style="border: none; border-left: 1px solid #000000" cellpadding="0" align="center"><tr>' . NL;
					echo '<th class="tabletop" width="20%">Monster\'s Level</th>' . NL;
					echo '<th class="tabletop" width="30%">Name</th>' . NL;
					echo '<th class="tabletop" width="20%">XP Given</th>' . NL;
					echo '<th class="tabletop">Level Achieved</th>' . NL;
					echo '</tr>' . NL;

					while( $info = $db->fetch_array($query) ) {

						$xp_item = rtrim( $info['xp'], '0' );
						$xp_item = rtrim( $xp_item, '.' );
						$xp_item = $xp_item * $xp_change;
						$xp_item = round( $xp_item , 2 );

						$xp_after = $xp_item * $amount;
						$xp_after = floor( $xp_after );
						$xp_after = $xp_current + $xp_after;
						$level_after = find_level( $xp_after );

						echo '<tr>' . NL;
						echo '<td class="tablebottom">' . $info['level'] . '</td>' . NL;
						echo '<td class="tablebottom">' . $info['name']  . '</td>' . NL;
						echo '<td class="tablebottom">' . $xp_item  . '</td>' . NL;
						echo '<td class="tablebottom">' . $level_after . '</td>' . NL;
						echo '</tr>' . NL;
					}
				}
				else {

					echo '<p>The table below, provides a number of different options to help you reach level ' . $level_target . ' ' . $skill . '. Match the colored icons, from below this messege, to the action/item to see if you are able to use that method.</p>' . NL;

					echo '<table border="0" cellpadding="3" cellspacing="0" width="100%" align="center"><tr>' . NL;
					echo '<td align="right" width="15%"><img src="/img/calcimg/a_green.PNG" alt="" /></td><td align="left">You Have This Ability</td>' . NL;
					echo '<td align="right"><img src="/img/calcimg/a_red.PNG" alt="" /></td><td align="left" width="40%">You Do Not Have This Ability</td>' . NL;
					echo '</tr></table><br />' . NL;

					echo '<table cellspacing="0" width="100%" style="border: none; border-left: 1px solid #000000" cellpadding="0" align="center"><tr>' . NL;
					echo '<th class="tabletop" width="25">&nbsp;</th>' . NL;
					echo '<th class="tabletop" width="13%">Level</th>' . NL;
					echo '<th class="tabletop" width="50">Image</th>' . NL;
					echo '<th class="tabletop" width="35%">Name</th>' . NL;

					if( $skill != 'Farming' ) {
						echo '<th class="tabletop" width="15%">XP Given</th>' . NL;
					}
					echo '<th class="tabletop">Level Achieved</th>' . NL;
					echo '</tr>' . NL;
	
					while( $info = $db->fetch_array($query) ) {

						$xp_item = rtrim( $info['xp'], '0' );
						$xp_item = rtrim( $xp_item, '.' );
						$xp_item = $xp_item * $xp_change;
						$xp_item = round( $xp_item , 2 );

						if( $skill == 'Farming' ) {

							if( $info['calc_type'] == 'Vegetable' ) {
								$xp_item = $xp_item + ( $veg * $info['xp_more'] );
							}
							elseif( $info['calc_type'] == 'Herb' ) {
								$xp_item = $xp_item + ( $herb * $info['xp_more'] );
							}
							elseif( $info['calc_type'] == 'Fruit' OR $info['name'] == 'Bittercap mushroom' OR $info['name'] == 'Calquat tree' ) {
								$xp_item = $xp_item + ( 6 * $info['xp_more'] );
							}
							elseif( $info['calc_type'] == 'Bush' ) {
								$xp_item = $xp_item + ( 4 * $info['xp_more'] );
							}
							elseif( $info['calc_type'] == 'Flower' OR $info['name'] == 'Belladonna(nightshade)' ) {
								$xp_item = $xp_item + ( 1 * $info['xp_more'] );
							}
							elseif( $info['name'] == 'Cactus plant' ) {
							$xp_item = $xp_item + ( 3 * $info['xp_more'] );
							}
						}

						$xp_after = $xp_item * $amount;
						$xp_after = floor( $xp_after );
						$xp_after = $xp_current + $xp_after;
						$level_after = find_level( $xp_after );

						if( $info['level'] > $level_current ) {
							$ability_image = 'a_red.PNG';
						}
						else {
							$ability_image = 'a_green.PNG';
						}
		
						echo '<tr>' . NL;
						echo '<td class="tablebottom"><img src="/img/calcimg/' . $ability_image . '" alt="" /></td>' . NL;
						echo '<td class="tablebottom">' . $info['level'] . '</td>' . NL;
						echo '<td class="tablebottom" valign="middle"><img src="/img/' . $info['image']  . '" width="30" height="30" alt="Image for ' . $info['name']  . '" /></td>' . NL;
						echo '<td class="tablebottom">' . $info['name']  . '</td>' . NL;

						if( $skill != 'Farming' ) {
							echo '<td class="tablebottom">' . $xp_item  . '</td>' . NL;
						}
						echo '<td class="tablebottom">' . $level_after . '</td>' . NL;
						echo '</tr>' . NL;
					}
				}
				$entry_count = $db->num_rows( $quero );
			
				if ( $entry_count == 0 ) {
					echo '<tr><td class="tablebottom" align="center" colspan="6">The calculator did not return any results for your criteria. Please try again.</td></tr>' . NL;
				}
				echo '</table>' . NL;
			}
		}
	}
	/* SLAYER CALCULATOR PAGE */

	elseif( isset( $skill ) AND $skill == 'Slayer' ) {
		// DETERMINE THE SKILL DATA SET

		if( isset( $current ) ) {
			if( $current_type == 'level' ) {

				if( $current > 138 ) {
					$current = 138;
				}
				elseif( $current < 1 ) {
					$current = 1;
				}

				$level_current = $current;	
				$xp_current = find_xp( $level_current );
			}
			else {
				$xp_current = $current;	
				$level_current = find_level( $xp_current );
			}
		}
		elseif( !isset( $user ) ) {
			$current = 0;
			$xp_current = 0;
			$level_current = 1;
		}
		else {
			$file = get_file( $user );
			$xp_current = get_stat( $file, Slayer, 'xp' );
			$level_current = find_level( $xp_current );
			$current = $xp_current;
		}

		if( isset( $amount ) ) {
			if( $amount > 1000 ) {
				$amount = 1000;
			}
		}
		else {
			$amount = 1;
		}

		if( !isset( $id ) ) {
			$id = 0;
		}

		// MYSQL QUERY	
		$quero = "SELECT * FROM `calc_info` WHERE `calc_name` = 'Slayer' ORDER BY `name`";
		$query = $db->query($quero);

		// ECHO BEGINNING OF THE FORM
		echo '<form action="' . $_SERVER['SCRIPT_NAME'] . '" method="get">' . NL;
		echo '<input type="hidden" name="calc" value="Slayer" />' . NL;

		// ECHO CURRENT AND TASK FIELDS

		echo '<table width="100%" align="center" class="boxtop" style="border: 1px solid black;" cellspacing="2" cellpadding="0">' . NL;
		echo '<tr>' . NL;
		echo '<td align="right" width="20%">Current:</td>' . NL;
		echo '<td align="center" width="100"><input type="text" name="current" size="13" maxlength="10" value="' . $current . '" /></td>' . NL;
		echo '<td>&nbsp;</td>' . NL;
		echo '<td align="center" width="140">Assigned Monster:</td>' . NL;
		echo '<td align="left" width="30%"><select name="id">' . NL;

		if( !isset( $g_xp ) ) {
			echo '<option value="" selected="selected">-- Select One</option>' . NL;
		}
		else {
			echo '<option value="0">-- Select One</option>' . NL;
		}

		while( $info = $db->fetch_array($query) ) {

			if( $info['id'] == $id ) {
				echo '<option value="' . $info['id'] . '" selected="selected">' . $info['name'] . ' (' . $info['level'] . ')</option>' . NL;
			}
			else {
				echo '<option value="' . $info['id'] . '">' . $info['name'] . ' (' . $info['level'] . ')</option>' . NL;
			}			
		}


		echo '</select>&nbsp;</td>' . NL;
		echo '</tr><tr>' . NL;

		if( isset( $current_type ) AND $current_type == 'level' ) {
			echo '<td align="right"><input type="radio" name="current_type" value="xp" /> XP</td>' . NL;
			echo '<td align="center"><input type="radio" name="current_type" value="level" checked="checked" /> Level</td>' . NL;
		}
		else {
			echo '<td align="right"><input type="radio" name="current_type" value="xp" checked="checked" /> XP</td>' . NL;
			echo '<td align="center"><input type="radio" name="current_type" value="level" /> Level</td>' . NL;
		}
		echo '<td>&nbsp;</td>' . NL;
		echo '<td align="center" width="140">Assigned Amount:</td>' . NL;
		echo '<td align="left"><input type="text" name="amount" size="10" maxlength="4" value="' . $amount . '" />&nbsp;</td>' . NL;
		echo '</tr>' . NL;
		echo '</table><br />' . NL;

		// ECHO END OF THE FORM
		echo '<table width="100%" align="center" class="boxtop" style="border: 1px solid black;" cellspacing="2" cellpadding="0">' . NL;
		echo '<tr><td colspan="10" align="right"><input type="submit" value="Calculate" /></td></tr>' . NL;
		echo '</table>' . NL;
		echo '</form>' . NL;

		if( isset( $current ) AND isset( $current_type ) AND isset( $id ) AND isset( $amount ) ) {

			$data = $db->fetch_row("SELECT * FROM `calc_info` WHERE `calc_name` = 'Slayer' AND `id` = " . $id);

			if( !empty( $data ) ) {

				$next_level = $level_current + 1;
				$xp_next_level = find_xp( $next_level );
				$xp_next_level = $xp_next_level - $xp_current;			

				$xp_gain = $amount * $data['xp'];
				$xp_after = $xp_current + $xp_gain;
				$level_after = find_level( $xp_after );

				$xp_after = number_format( $xp_after );
				$xp_next_level = number_format( $xp_next_level );
				$xp_current = number_format( $xp_current );
				$xp_gain = number_format( $xp_gain );

				echo '<p align="center">You are currently level ' . $level_current . ' with ' . $xp_current . ' XP. You are ' . $xp_next_level . ' XP away from the next level.</p>' . NL;
				echo '<p align="center">After completing your task of ' . $amount . ' ' . $data['name'] . 's (Level ' . $data['level'] . '), you will have gained ' . $xp_gain . ' XP.<br />You will end up being level ' . $level_after . ' with ' . $xp_after . ' XP.</p>' . NL;
			}	
		}

		echo '<br /><br />' . NL;
		echo '<table width="50%" align="center"><tr>' . NL;
		echo '<td align="left"><img src="/img/npcimg/kurask.gif" alt="Runescape Kurask Picture" /></td>' . NL;
		echo '<td align="right"><img src="/img/npcimg/Nechryael115.gif" alt="Runescape Nechryael Picture" /></td>' . NL;
		echo '</tr></table>' . NL;

	}
	/* COMBAT CALCULATOR PAGE */

	elseif( isset( $skill ) AND $skill == 'Combat' ) {

		// PREFORM ALL STAT CHECKS AND DETERMINE DATA SET
		if( isset( $attack ) AND isset( $defence ) AND isset( $strength ) AND isset( $strength ) AND isset( $magic ) AND isset( $ranged ) AND isset( $prayer ) AND isset( $hitpoints ) AND isset( $summoning ) ) {

// Already verified--let's go!

		}
		elseif( !isset( $user ) ) {
			$attack = 1;
			$defence = 1;
			$strength = 1;
			$magic = 1;
			$ranged = 1;
			$prayer = 1;
		//	$summoning = 1;
			$hitpoints = 10;
		}
		else {
			$file = get_file( $user );

      $combatstat = get_stat( $file, 'Combat', 'level');
      $attack = $combatstat['Attackl'];
      $strength = $combatstat['Strengthl'];
      $defence = $combatstat['Defencel'];
      $magic = $combatstat['Magicl'];
      $ranged = $combatstat['Rangedl'];
      $prayer = $combatstat['Prayerl'];
     // $summoning = $combatstat['Summoningl'];
      $hitpoints = $combatstat['Hitpointsl'];      
		}


		// ECHO STAT INPUT FORM
		echo '<form action="' . $_SERVER['SCRIPT_NAME'] . '" method="get">' . NL;
		echo '<input type="hidden" name="calc" value="Combat" />' . NL;

		echo '<table width="80%" align="center" class="boxtop" style="border: 1px solid black;" cellspacing="0" cellpadding="2">' . NL;
		echo '<tr>' . NL;
		echo '<td align="right">Attack:</td>' . NL;
		echo '<td align="left"><input type="text" name="attack" size="5" maxlength="2" value="' . $attack . '" /></td>' . NL;
		echo '<td align="right">Strength:</td>' . NL;
		echo '<td align="left"><input type="text" name="strength" size="5" maxlength="2" value="' . $strength . '" /></td>' . NL;
		echo '<td align="right">Defence:</td>' . NL;
		echo '<td align="left"><input type="text" name="defence" size="5" maxlength="2" value="' . $defence . '" /></td>' . NL;
		echo '</tr>' . NL;
		echo '<tr>' . NL;
		echo '<td align="right">Magic:</td>' . NL;
		echo '<td align="left"><input type="text" name="magic" size="5" maxlength="2" value="' . $magic . '" /></td>' . NL;
		echo '<td align="right">Ranged:</td>' . NL;
		echo '<td align="left"><input type="text" name="ranged" size="5" maxlength="2" value="' . $ranged . '" /></td>' . NL;
		echo '<td align="right">Prayer:</td>' . NL;
		echo '<td align="left"><input type="text" name="prayer" size="5" maxlength="2" value="' . $prayer . '" /></td>' . NL;
		echo '</tr>' . NL;
		echo '<tr>' . NL;
		echo '<td align="right">Hitpoints:</td>' . NL;
		echo '<td align="left"><input type="text" name="hitpoints" size="5" maxlength="2" value="' . $hitpoints . '" /></td>' . NL;
		echo '<td colspan="2" align="center"><input type="submit" value="Calculate" /></td>' . NL;
		//echo '<td align="right">Summoning:</td>' . NL;
		//echo '<td align="left"><input type="text" name="summoning" size="5" maxlength="2" value="' . $summoning . '" /></td>' . NL;
		echo '</tr>' . NL;
		echo '</table>' . NL;
		echo '</form>' . NL;
			
		/* UPON CALCULATION REQUEST */
		if( isset( $attack ) AND isset( $defence ) AND isset( $strength ) AND isset( $strength ) AND isset( $magic ) AND isset( $ranged ) AND isset( $prayer ) AND isset( $hitpoints ) ) {
			
			$as_val = 0.3248;
			$dh_val = 0.25025; // Confirmed
			$p_val = 0.125; // Confirmed
			$rm_val = 0.4875;
			
			$prayer = $prayer + $summoning;
			
			// FIND 3 DIFFERENT COMBATS
			$warrior = ($strength * $as_val) + ($attack * $as_val) + ($defence * $dh_val) + ($hitpoints * $dh_val) + ($prayer * $p_val);
			$ranger = ($ranged * $rm_val) + ($defence * $dh_val) + ($hitpoints * $dh_val) + ($prayer * $p_val);
			$wizard = ($magic * $rm_val) + ($defence * $dh_val) + ($hitpoints * $dh_val) + ($prayer * $p_val);

			// USE HIGHEST COMBAT LEVEL
			$combat = max( $warrior , $ranger , $wizard );

			if( $combat == $warrior ) {
				$type = 'Warrior';
			}
			elseif( $combat == $ranger ) {
				$type = 'Ranger';
			}
			elseif( $combat == $wizard ) {
				$type = 'Wizard';
			}

			// ECHO COMBAT LEVEL
			// $combat_decimal = round( $combat , 2 );
			$combat_decimal = floor( $combat );

			echo '<br /><table width="80%" align="center" class="boxtop" style="border: 1px solid black;" cellspacing="0" cellpadding="2">' . NL;
			echo '<tr>' . NL;
			echo '<td align="center">Your combat level is ' . $combat_decimal . '. You are a ' . $type . '.</td>' . NL;
			echo '</tr>' . NL;
			echo '</table><br />' . NL;

			// FIND LEVELS NEEDED TO NEXT LEVEL
			$combat_round = floor( $combat );
			$combat_next = $combat_round + 1;

			$combat_check = $warrior; //Strength and Attack
			$warrior_need = 0;
			while( $combat_check < $combat_next ) {
				$combat_check = $combat_check + $as_val;
				$warrior_need++;
			}

			$combat_check = $ranger; //Ranged
			$ranged_need = 0;
			while( $combat_check < $combat_next ) {
				$combat_check = $combat_check + $rm_val;
				$ranged_need++;
			}

			$combat_check = $wizard; //Magic
			$magic_need = 0;
			while( $combat_check < $combat_next ) {
				$combat_check = $combat_check + $rm_val;
				$magic_need++;
			}

			$combat_check = $combat; //HP and Defence
			$hpdef_need = 0;
			while( $combat_check < $combat_next ) {
				$combat_check = $combat_check + $dh_val;
				$hpdef_need++;
			}

			$combat_check = $combat; //Prayer
			$prayer_need = 0;
			while( $combat_check < $combat_next ) {
				$combat_check = $combat_check + $p_val;
				$prayer_need++;
			}

			$warrior_total = $attack + $strength + $warrior_need;
			$ranged_total = $ranged + $ranged_need;
			$magic_total = $magic + $magic_need;
			$hpdef_total = $hitpoints + $defence + $hpdef_need;
			$prayer_total = $prayer + $prayer_need;

			// ECHO LEVELS NEEDED IF REASONABLE
			echo '<table width="80%" align="center" class="boxtop" style="border: 1px solid black;" cellspacing="0" cellpadding="2">' . NL;

			if( $warrior_total >= 198 AND $ranged_total >= 99 AND $magic_total >= 99 AND $hpdef_total >= 198 AND $prayer_total >= 198 ) {
				echo '<tr><td align="center">You cannot advance your Combat Level any further.</td></tr>' . NL;
			}
			else {
				echo '<tr><td align="center" colspan="2">To achieve level ' . $combat_next . ', you will need one of the following:</td></tr>' . NL;
				echo '<tr><td width="35%"></td>' . NL;
				echo '<td align="left">' . NL;

				if( $warrior_total <= 198 ) {
					echo $warrior_need . ' Attack or Strength Levels<br />' . NL;
				}
				if( $ranged_total <= 99 ) {
					echo $ranged_need . ' Ranged Levels<br />' . NL;
				}
				if( $magic_total <= 99 ) {
					echo $magic_need . ' Magic Levels<br />' . NL;
				}
				if( $hpdef_total <= 198 ) {
					echo $hpdef_need . ' Hitpoints or Defence Levels<br />' . NL;
				}
				if( $prayer_total <= 198 ) {
					echo $prayer_need . ' Prayer or Summoning* Levels' . NL;
				}
			}
			echo '</td></tr>' . NL;
			echo '</table><br />' . NL;
		}
		echo '<p align="center">This calculator is <b>not</b> 100% accurate and we are well aware of it. Please do not contact us about this inaccuracy.<br />* - Summoning only affects combat in members.' . NL;
		echo '<br /><br /><img src="/img/calcimg/img_combat.gif" alt="A Runescape Combat Situation" /></p>' . NL;
	}


	/* CALCULATOR COMING SOON */

	elseif( isset( $skill ) AND in_array( $skill, $calc_other ) ) {
		echo '<p align="center"><font size="+1">Coming Soon!</font><br /><br />This calculator is coming soon! Please check back at a later date.</p>' . NL;
	}

	/* CALCULATOR NOT FOUND */

	elseif( isset( $skill ) ) {
		echo '<p align="center"><font size="+1">Calculator Not Found!</font><br /><br />If a link seems to be broken, please contact a staff member to get it fixed.</p>' . NL;
	}

	/* CALCULATOR GREETING/INFO PAGE */

	else {

		echo 'Welcome to the Zybez RuneScape Help Calculator area!<br />' . NL;
		echo '<img src="/img/calcimg/img_firemaking.gif" hspace="4" align="right" alt="Picture of a Runescape Fire" />' . NL;
		echo '<p>To your left is a menu consisting of all the Runescape calculators we have to offer. The calculators operate in two different modes. The regular mode will give you information on achieving your goals; the reversed mode will tell you what level you will achieve with a certain amount of actions. You can switch modes as well as other things in the settings area.<br />' . NL;
		echo 'In order to do the calculations you will need to input some information first. The information needed is as follows:</p>' . NL;

		if( $mode == 1 ) {
			echo '<p><em>Goal Starting Level</em>: This is the level your goal started at. It may be your current level, in which case you can select the &quot;Use Current&quot; option, or it may be any other value lower than the stage you are currently at. Keep in mind that it must be less than or equal to your current level. By default, this is set to level 1.</p>' . NL;
			echo '<p><em>Current</em>: This is where you input where you are currently at. You may enter in your current experience points or your current level. Please remember to use the selection boxes below this feature to indicate which type you are inputting. By default, this field is set to 0 XP.</p>' . NL;
			echo '<p><em>Goal Target Level:</em> This is the level you would like to achieve and is the ending point of your goal. Remember that it must always be greater than your current level. By default, this option is set to 1 level greater than your current level. Since the maximum level in RuneScape is level 99, your goal level cannot exceed that number. Please be aware of this.</p>' . NL;
		}
		else {
			echo '<p><em>Current</em>: This is where you input where you are currently at. You may enter in your current experience points or your current level. Please remember to use the selection boxes below this feature to indicate which type you are inputting. By default, this field is set to 0 XP.</p>' . NL;
			echo '<p><em>Amount:</em> This is the number of actions you want to execute. If you want to do a thousand actions, it will tell you what level you will achieve with different items when doing at amount of them.</p>' . NL;
		}
		echo '<p>You may also encounter skills that ask for extra information or give you other options. Most of these extra options are not mandatory, so if you are having trouble figuring them out, chances are you can just ignore them.</p>' . NL;
		echo '<p>Other than skill calculators, Zybez Runescape Help also offers a Combat calculator to calculate in game combat levels based on certain skill stats. It is available just below the skill calculators on your left. The slayer calculator is also a bit different than the regular skill calculators.</p>' . NL;
		echo '<p>We hope these aid you in your RuneScape game play! To begin select a calculator on your left.</p>' . NL;
		echo '<p align="center"><img src="/img/calcimg/img_mining.gif" alt="Picture of a Runescape Miner" /></p>' . NL;

	}
	echo '</td></tr></table>' . NL;
	echo '</td></tr></table><br />' . NL;

	?>
	<center>
	<strong>DISCLAIMER:</strong> The data displayed herein should not be regarded as 100% correct. There may be errors in the data, which will affect the output. If you encounter any errors in our calculators, do not hesitate to submit a correction <a href="http://forums.zybez.net/forum/314-submit-content/" title="RuneScape Help's Corrections Submission Forum">here</a>.
	</center><br />
	<?php
}

echo '</div>' . NL;

end_page();
?>