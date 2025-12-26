<?

function clearLogs() {
	global $prefs;

	for ($i = 1; $i <= $prefs['logs']; $i++) {
		$log = 'log.' . $i;
		$ys = new YShout($log, false);
		$ys->clear();
	}

	notice('Logs cleared! If you\'re using Safari as your browser, <a href="?reqType=home">Click here</a>. There is a bug with Safari that keeps you on the last page you visited in this CP, even if you exit it or refresh the page. While usually a minor detail, it may cause the log to clear again when you open the CP the next time.');
}

function init() {
	$hash = cookieGet('yLoginHash');
	if (isset($hash) && $hash != '')
		login($hash);
}

function abort($html = '') {
	echo $html;
	echo '</body></html>';
	exit;
}

function setPreferences() {
	$newPrefs = array();

	if (!getVar('form'))
		return;

	$newPrefs['password'] = clean(getVar('password'));
	$newPrefs['refresh'] = clean(getVar('refresh'));
	$newPrefs['logs'] = getVar('logs');
	$newPrefs['history'] = getVar('history');
	$newPrefs['inverse'] = (getVar('inverse') == 'Top') ? true : false;
	$newPrefs['truncate'] = getVar('truncate');
	$timestampChoices = array('12-hour' => 12, '24-hour' => '24', 'No timestamps' => 0);
	$newPrefs['timestamp'] = $timestampChoices[getVar('timestamp')];
	$newPrefs['defaultNickname'] = clean(getVar('defaultNickname'));
	$newPrefs['defaultMessage'] = clean(getVar('defaultMessage'));
	$newPrefs['defaultSubmit'] = clean(getVar('defaultSubmit'));
	$newPrefs['nicknameLength'] = getVar('nicknameLength');
	$newPrefs['messageLength'] = getVar('messageLength');
	$newPrefs['floodTimeout'] = getVar('floodTimeout');
	$newPrefs['floodMessages'] = getVar('floodMessages');
	$newPrefs['floodDisable'] = getVar('floodDisable');
	$newPrefs['showCPLink'] = (getVar('showCPLink') == 'on' ? true : false) ;
	$newPrefs['flood'] =(getVar('flood') == 'on' ? true : false);
	$newPrefs['info'] = (getVar('info') == 'Overlay') ? 'overlay' : 'inline';


	savePrefs($newPrefs);
	login(md5($newPrefs['password'] ));
	notice('Preferences saved successfully!');
}

function resetPreferences() {
	resetPrefs();
	notice('Preferences reset!');
}

function doBan() {
	if (!getVar('form'))
		return;

	$ip = $_POST['ip'];
	$reason = isset($_POST['reason']) ? $_POST['reason'] : null;
	$ys = ys();
	
	if (!validIP($ip) || $ip == '') {
		notice('You might wanna doublecheck that IP, it doesn\'t look to be valid.');
		return;
	}

	if ($ys->banned($ip)) {
		notice ('You must really hate that guy, considering he\'s already banned and you insist on trying to do it to him again.');
		return;
	}

	$ys->ban($ip, $reason);
	notice('Hooray, you just banned ' . $ip . '!');
}

function doUnban() {
	$ip = getVar('ip');
	$ys = ys();

	if (!validIP($ip)) {
		notice('You might wanna doublecheck that IP, it doesn\'t look to be valid.');
		return;
	}

	if (!$ys->banned($ip)) {
		notice ('That guy isn\'t banned.');
		return;
	}

	$ys->unban($ip, $reason);
	notice('Unbanned ' . $ip . '.');

}

function doUnbanAll() {
	$ys = ys();

	$bans = $ys->bans();
	if (sizeof($bans) == 0) {
		notice('There ain\'t nobody to unban.');
		return;
	}

	$ys->unbanAll();
	notice ('Today is a day of joy;<br> For all those who once were banned <br> Are now are free to come back and spam.');
}


function notice($notice) {
	$_SESSION['yNotice'] = $notice;
}

function showNotice() {
	if (!hasNotice()) return;

	echo '<div class="notice"><p>' . $_SESSION['yNotice'] . '</p></div>';
	$_SESSION['yNotice'] = '';
}

function hasNotice() {
	return $_SESSION['yNotice'] != '';
}

function redirect($url) {
	session_write_close();
	header('Location: ' . $url);
}

?>