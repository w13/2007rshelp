<?
	$storage = 'FileStorage';

	function loadPrefs() {
		global $prefs, $storage, $null;
		$s = new $storage('yshout.prefs');
		$s->open();
		$prefs = $s->load();
		$s->close($null);
	}

	function savePrefs($newPrefs) {
		global $prefs, $storage;

		$s = new $storage('yshout.prefs');
		$s->open(true);
		$s->close($newPrefs);
		$prefs = $newPrefs;
	}

	function resetPrefs() {
		$defaultPrefs = array(
			'password' => 'fortytwo',

			'refresh' => 6000,

			'logs' => 5,

			'history' => 200,

			'inverse' => false,

			'truncate' => 15,

			'timestamp' => 12,

			'defaultNickname' => 'Nickname',
			'defaultMessage' => 'Message Text',
			'defaultSubmit' => 'Shout!',

			'nicknameLength' => 25,
			'messageLength' => 175,

			'flood' => true,
			'floodTimeout' => 5000,
			'floodMessages' => 4,
			'floodDisable' => 8000,

			'showCPLink' => true,

			'info' => 'overlay'
		);

		savePrefs($defaultPrefs);
	}

	loadPrefs();

?>
