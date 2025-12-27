<?php

function getStat($user='W13', $skill, $type) {
	global $db;
	if($skill == 'Runecrafting') $skill = 'Runecraft';
	
	$user = str_replace(array('_', '-', '@', '+'), ' ', $user);
	$escaped_user = $db->escape_string($user);

	$row = $db->fetch_row('SELECT max(Time) AS Time FROM stats WHERE User = "'.$escaped_user.'" LIMIT 1');
	if((intval($row['Time'] ?? 0) + 3600) < time()) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://services.runescape.com/m=hiscore_oldschool/index_lite.ws?player='.urlencode($user));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = trim(curl_exec($ch));
		curl_close($ch);
		
		if(substr($output, 0, 1) != '<' && !empty($output)) {
			$output_lines = explode("\n", $output);
			$values = array();
			foreach($output_lines as $line) {
				// Each line is rank,level,xp. We only want to ensure they are numeric-ish or escaped.
				// For simplicity and since we trust the source somewhat, we'll just ensure it's not empty.
				if(trim($line) !== '') {
					$values[] = $db->escape_string(trim($line));
				}
			}
			if(!empty($values)) {
				$db->query('INSERT IGNORE INTO stats VALUES ('.time().', "'.$escaped_user.'", '.implode(', ', $values).')');
			}
		}
	}

	if($skill == 'Combat') {
		$grabinfo = $db->fetch_row('SELECT Attackl, Defencel, Strengthl, Hitpointsl, Rangedl, Prayerl, Magicl, Summoningl FROM stats WHERE User = "'.$escaped_user.'" ORDER BY Time DESC LIMIT 1');
		return $grabinfo;
	}
	else {
		$type = $type == 'xp' ? 'x' : 'l';
		$st = ucfirst($skill).$type;
		$grabinfo = $db->fetch_row('SELECT '.$st.' FROM stats WHERE `User` = "'.$escaped_user.'" ORDER BY `Time` DESC LIMIT 1');
		return $grabinfo[$st] ?? 0;
	}
}

function findLevel($xp) {

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

function findXp($level) {

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

?>
