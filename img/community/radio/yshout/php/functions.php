<?

	function cookie($name, $data) {
		return setcookie($name, $data, time() + 60 * 60 * 24 * 30);
	}

	function cookieGet($name, $default = null) {
		if (isset($_COOKIE[$name]))
			return $_COOKIE[$name];
		else
			return $default;
	}

	function cookieClear($name) {
		setcookie ($name, 'Forty-two.', time() - 42);
	}

	function getVar($name) {
		if (isset($_POST[$name])) return $_POST[$name];
		if (isset($_GET[$name])) return $_GET[$name];
		return null;
	}
	
	function clean($s) {
		if (get_magic_quotes_gpc()) $s = stripslashes($s);
		$s = htmlspecialchars($s);
		return $s;
	}

	function badword_filter($s) {
	$badwords = array('fuck','fuk', 'blowjob', 'crackhead', 'pussy', 'vagina', 'fag', 'dildo', 'f u c k', ' fking', ' fkin', ' s h i t', 'ñigger', 'shit', 'sheit', 'sheit', 'shyt', 'bitch', 'slut', 'motherfucker', 'vagina', 'penis', 'peni5', 'cunt', 'p3n15', 'p3n1s', 'p3nis', 'dick', '.exe', 'shlong', 'cock', 'sh1t', 'bastard', 'faggot', 'wanker', 'nigga', 'nigger', 'myspace.com', 'niger', 'ni99a', 'jewish', 'j3wish', 'j3w1sh', 'jew1sh', 'lesbian', 'jews', 'j3ws', 'j3w5', 'jew', '@@@@@@@', 'ooooo', '@!@', 'spam spam');
	$replace = '**';
	$s = $s;
	$s = str_ireplace($badwords, $replace, $s);
		return $s;
	}
	
		function pl_link($s) {
	$word = array('playlists', 'playlist', 'play lists', 'play list', ' pl ');
	$replace = '<a href="/img/community/radio/pl/index.html" target="_blank" title="Check them out!">'.$word[1].'</a>';
	$s = $s;
	$s = str_ireplace($word, $replace, $s);
		return $s;
	}
	
	function special_word($s) {
	$word = 'da ba dee da ba die';
	$replace = '<span style="color: blue; text-decoration:blink; font-weight:bold;">'.$word.'</span> (Congratulations, you\'ve won Zybez Radio\'s Secret Contest!)';
	$s = $s;
	$s = str_ireplace($word, $replace, $s);
		return $s;
	}

	function convert_case($s) { //not used
	$string = $s;
	$s = mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
		return $s;
	}
	
	
	function ip() {
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		else
			return $_SERVER['REMOTE_ADDR'];
	}

	function ipValid($ip) {
		if ($ip == long2ip(ip2long($ip)))		
			return true;		
		return false;
	}

	function jsonEncode(&$array) {
		if ($array) {
			$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
			return $json->encode($array);
		} else
			return 'ar';
	}

	function jsonDecode($encoded) {
		$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		return $json->decode($encoded);
	}

	function validIP($ip) {
		if ($ip == long2ip(ip2long($ip)))
			return true;
		return false;
	}

	function ts() {
		// return microtime(true);
		list($usec, $sec) = explode(" ", microtime());
	   return ((float)$usec + (float)$sec);

	}

	function len($string) {
		$i = 0; $count = 0;
		$len = strlen($string);

		while ($i < $len) {
			$chr = ord($string[$i]);
			$count++;
			$i++;

			if ($i >= $len) break;
			if ($chr & 0x80) {
				$chr <<= 1;
				while ($chr & 0x80) {
					$i++;
					$chr <<= 1;
				}
			}
		}

		return $count;
	}

	function error($err) {
		echo 'Error: ' . $err;
		exit;
	}

	function ys($log = 1) {
		global $yShout, $prefs;
		if ($yShout) return $yShout;

		if ($log > $prefs['logs']) $log = 1;

		$log = 'log.' . $log;

		return new YShout($log, loggedIn());
	}

	function dstart() {
		global $ts;

		$ts = ts();
	}

	function dstop() {
		global $ts;
		echo 'Time elapsed: ' . ((ts() - $ts) * 100000);
		exit;
	}

	function login($hash) {
		$_SESSION['yLoginHash'] = $hash;
		cookie('yLoginHash', $hash);
	//	return loggedIn();
	}

	function logout() {
		unset($_SESSION['yLoginHash']);
		cookie('yLoginHash', '');
	}

	function loggedIn() {
		global $prefs;

		if (isset($_SESSION['yLoginHash'])) 
			return $_SESSION['yLoginHash'] == md5($prefs['password']);
		else
			return false;
		
	}

?>