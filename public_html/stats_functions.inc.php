<?php

function get_file($file){
	return $file;
}

function get_stat($user, $skill, $type) {
	global $db;
	if($skill == 'Runecrafting') $skill = 'Runecraft';
	
	$user = str_replace(array('_', '-', '@', '+'), ' ', $user);
	$escaped_user = $db->escape_string($user);
	$url = 'https://services.runescape.com/m=hiscore_oldschool/index_lite.ws?player='.urlencode($user);

	$row = $db->fetch_row('SELECT max(`Time`) AS `Time` FROM `stats` WHERE `User` = "' . $escaped_user . '" LIMIT 1');
	if((intval($row['Time'] ?? 0) + 3600) < time()) {
		$url = 'https://services.runescape.com/m=hiscore_oldschool/index_lite.ws?player='.urlencode($user);
		$output = false;

		if (function_exists('curl_init')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);
			curl_close($ch);
		} elseif (ini_get('allow_url_fopen')) {
			$output = @file_get_contents($url);
		}
		
		$output = trim($output ?: '');
		
		if($output !== '' && substr($output, 0, 1) != '<') {
			$output_lines = explode("\n", $output);
			$values = array();
			foreach($output_lines as $line) {
				if(trim($line) !== '') {
					$values[] = $db->escape_string(trim($line));
				}
			}
			if(!empty($values)) {
				$db->query('INSERT IGNORE INTO `stats` VALUES ('.time().', "'.$escaped_user.'", '.implode(', ', $values).')');
			}
		}
	}

	$type = $type == 'xp' ? 'x' : 'l';
	$st = ucfirst($skill).$type;
	if($skill == 'Combat') {
		$grabinfo = $db->fetch_row('SELECT `Attackl`, `Defencel`, `Strengthl`, `Hitpointsl`, `Rangedl`, `Prayerl`, `Magicl`, `Summoningl` FROM `stats` WHERE `User` = "' . $escaped_user . '" ORDER BY `Time` DESC LIMIT 1');
		return $grabinfo;
	}
	else {
		$grabinfo = $db->fetch_row('SELECT `'.$st.'` FROM `stats` WHERE `User` = "' . $escaped_user . '" ORDER BY `Time` DESC LIMIT 1');
		return $grabinfo[$st] ?? 0;
	}
}

function find_level($xp) {

	if($xp >= 200000000) {
		$level = 126;
	}
	else {
		$level = 0;
		$points = 0;
		$check = 0;
		$num = 1;
		while($check <= $xp) {
			$a = $num / 7;
			$points = $points + floor($num + 300 * pow(2, $a));
			$check = floor($points / 4);
			$num++;
			$level++;
		}
	}
	return $level;
}

function find_xp($level) {

	$level--;
	$xp = 0;
	$num = 1;
	while($level > 0) {
		$a = $num / 7;
		$xp = $xp + floor($num + 300 * pow(2, $a));
		$num++;
		$level--;
	}
	$xp = floor($xp / 4);
	return $xp;
}

function colorcodemysocks($i) {
$i = intval($i);
if($i>99) { ## Overall
  $output = '';
    if($i<1138) { ## Green-Yelow
        $dec = dechex(intval($i*0.25));
        if(strlen($dec)==1) $dec = '0' . $dec;
        $color = $dec . 'FF00';    
    }
    else { ## Yellow-Red
        $dec = dechex(intval((2275-$i)*0.25));
        if(strlen($dec)==1) $dec = '0' . $dec;
        $color = 'FF' . $dec . '00';
    }
  return 'background-color:#' . $color . ';';
}
  $output = '';
    if($i<50) { ## Green-Yelow
        $dec = dechex(intval($i*5));
        if(strlen($dec)==1) $dec = '0' . $dec;
        $color = $dec . 'FF00';    
    }
    else { ## Yellow-Red
        $dec = dechex(intval((100-$i)*5));
        if(strlen($dec)==1) $dec = '0' . $dec;
        $color = 'FF' . $dec . '00';
    }
  return 'background-color:#' . $color . ';';
}

?>
