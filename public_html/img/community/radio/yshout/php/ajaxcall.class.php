<?

	class AjaxCall {
		function AjaxCall() {
			header('Content-type: application/json');
			session_start();

			$this->reqType = $_POST['reqType'];
		}

		function process() {
			switch($this->reqType) {
				case 'init':

					$this->initSession();
					$this->sendFirstUpdates();
					break;

				case 'post':
						$nickname = $_POST['nickname'];
						$message = $_POST['message'];
						cookie('yNickname', $nickname);
						$yShout = ys($_SESSION['yLog']);

						if ($post = $yShout->post($nickname, $message))	// To use post somewheres later
							$this->sendUpdates();
					break;

				case 'refresh':
					$this->sendUpdates();
					break;

				case 'reload':
					$this->reload();
					break;

				case 'ban':
					$this->doBan();
					break;

				case 'unban':
					$this->doUnban();
					break;

				}

			echo ' ';
		}

		function doBan() {
			$ip = $_POST['ip'];
			$send = array();
			$ys = ys($_SESSION['yLog']);

			switch(true) {
				case !loggedIn():
					$send['error'] = 'admin';
					break;
				case $ys->banned($ip):
					$send['error'] = 'already';
					break;
				default:
					$ys->ban($ip);
					$send['error'] = false;
			}

			echo jsonEncode($send);
		}

		function doUnban() {
			$ip = $_POST['ip'];
			$send = array();
			$ys = ys($_SESSION['yLog']);

			switch(true) {
				case !loggedIn():
					$send['error'] = 'admin';
					break;
				case !$ys->banned($ip):
					$send['error'] = 'already';
					break;
				default:
					$ys->unban($ip);
					$send['error'] = false;
			}

			echo jsonEncode($send);
		}

		function reload() {
			global $prefs;
			$yShout = ys($_SESSION['yLog']);

			$posts = $yShout->latestPosts($prefs['truncate']);
			$this->setSessTimestamp($posts);
			$this->updates['posts'] = $posts;						
			echo jsonEncode($this->updates);
		}

		function initSession() {
			$_SESSION['yLatestTimestamp'] = 0;
			$_SESSION['yYPath'] = $_POST['yPath'];
			if (!is_numeric($_POST['log'])) exit;
			$_SESSION['yLog'] = $_POST['log'];
			$loginHash = cookieGet('yLoginHash') ;
			if (isset($loginHash) && $loginHash != '') {
				login($loginHash);
			}
		}

		function sendUpdates() {
			global $prefs;
			$yShout = ys($_SESSION['yLog']);
			if (!$yShout->hasPostsAfter($_SESSION['yLatestTimestamp'])) return;

			$posts = $yShout->postsAfter($_SESSION['yLatestTimestamp']);
			$this->setSessTimestamp($posts);

			$this->updates['posts'] = $posts;

			echo jsonEncode($this->updates);
		}

		function setSessTimestamp(&$posts) {
			if (!$posts) return;

			$latest = array_slice( $posts, -1, 1);
			$_SESSION['yLatestTimestamp'] = $latest[0]['timestamp'];
		}

		function sendFirstUpdates() {
			global $prefs;

			$this->updates = array();

			$yShout = ys($_SESSION['yLog']);

			$posts = $yShout->latestPosts($prefs['truncate']);
			$this->setSessTimestamp($posts);

			$this->updates['posts'] = $posts;
			$this->updates['prefs'] = $prefs;

			if ($nickname = cookieGet('yNickname'))
				$this->updates['nickname'] = $nickname;

			echo jsonEncode($this->updates);
		}

	}

?>