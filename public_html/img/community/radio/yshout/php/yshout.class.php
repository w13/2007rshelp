<?

class YShout {

	function YShout($path, $admin = false) {
		global $storage;
		// Redo to check for folders or just not break, because nonextant files should be allowed.
		// if (!file_exists($path)) error('That file does not exist.');

		$this->storage = new $storage($path, true);
		$this->admin = $admin;
	}

	function posts() {
		global $null;
		$this->storage->open();
		$s = $this->storage->load();
		$this->storage->close($null);

		if ($s)
			return $s['posts'];
	}

	function info() {
		global $null;
		$s = $this->storage->open(true);

		$this->storage->close($null);

		if ($s)
			return $s['info'];
	}

	function postsAfter($ts) {
		$allPosts = $this->posts();

		$posts = array();

	/*	for ($i = sizeof($allPosts) - 1;  $i > -1; $i--) {
			$post = $allPosts[$i];

			if ($post['timestamp'] > $ts)
				$posts[] = $post; 
		} */

		foreach($allPosts as $post) {
			if ($post['timestamp'] > $ts)
				$posts[] = $post; 
		}

		$this->postProcess($posts);
		return $posts;
	}

	function latestPosts($num) {
		$allPosts = $this->posts();
		$posts = array_slice($allPosts, -$num, $num);

		$this->postProcess($posts);
		return array_values($posts);
	}

	function hasPostsAfter($ts) {
		$info = $this->info();
		$timestamp = $info['latestTimestamp'];
		return $timestamp > $ts;
	}

	function post($nickname, $message) {
		global $prefs;

		if ($this->banned(ip()) && !$this->admin) return false;

		if (!$this->validate($message, $prefs['messageLength'])) return false;
		if (!$this->validate($nickname, $prefs['nicknameLength'])) return false;

		$message = clean($message);
		$message = badword_filter($message);
		$message = special_word($message);
		//$message = convert_case($message);
		$message = pl_link($message);
		$nickname = clean($nickname);
		$nickname = badword_filter($nickname);

		$post = array(
			'nickname' => $nickname,
			'message' => $message,
			'timestamp' => ts(),
			'admin' => $this->admin,
			'adminInfo' => array(
				'ip' => ip()
			)
		);

		$s = $this->storage->open(true);

		$s['posts'][] = $post;

		if (sizeof($s['posts']) > $prefs['history']) 
			$this->truncate($s['posts']);

		$s['info']['latestTimestamp'] = $post['timestamp'];

		$this->storage->close($s);
		$this->postProcess($post);
		return $post;
	}

	function truncate(&$array) {
		global $prefs;

		$array = array_slice($array, -$prefs['history']);
		$array = array_values($array);
	}

	function clear() {
		global $null;

		$this->storage->open(true);
		$this->storage->resetArray();
		$this->storage->close($nulls);
	}

	function bans() {
		global $storage, $null;

		$s = new $storage('yshout.bans');
		$s->open();
		$bans = $s->load();
		$s->close($null);

		return $bans;
	}

	function ban($ip, $reason = '') {
		global $storage;

		$s = new $storage('yshout.bans');
		$bans = $s->open(true);

		$bans[] = array(
			'ip' => $ip,
			'reason' => $reason,
			'timestamp' => ts()
		);

		$s->close($bans);
	}

	function banned($ip) {
		global $storage, $null;

		$s = new $storage('yshout.bans');
		$bans = $s->open(true);
		$s->close($null);

		foreach($bans as $ban)
			if ($ban['ip'] == $ip)
				return true;

		return false;
	}

	function unban($ip) {
		global $storage;

		$s = new $storage('yshout.bans');
		$bans = $s->open(true);

		foreach($bans as $key=>$value)
			if ($value['ip'] == $ip) {
				unset($bans[$key]);
			}

		$bans = array_values($bans);
		$s->close($bans);

	}

	function unbanAll() {
		global $storage, $null;

		$s = new $storage('yshout.bans');
		$s->open(true);
		$s->resetArray();
		$s->close($null);
	}

	function validate($str, $maxLen) {
		return len($str) <= $maxLen;
	}

	function postProcess(&$post) {
		if (isset($post['message'])) {
			if ($this->banned($post['adminInfo']['ip'])) $post['banned'] = true;
			if (!$this->admin) unset($post['adminInfo']);
		} else {
			foreach($post as $key=>$value) {
				if ($this->banned($value['adminInfo']['ip'])) $post[$key]['banned'] = true;
				if (!$this->admin) unset($post[$key]['adminInfo']);
			}
		}
	}

}


?>