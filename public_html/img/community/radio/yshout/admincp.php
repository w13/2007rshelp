<? 
ob_start();
session_start();

include 'include.php';
include 'cp/functions.php';

init();

switch (true) {
	case isset($_POST['reqType']):
		$reqType = $_POST['reqType'];
		break;
	case isset($_GET['reqType']):
		$reqType = $_GET['reqType'];
		break;
	case loggedIn(): 
		$reqType = 'home';
		break;
	default: 
		$reqType = 'showlogin';  
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>YShout Admin CP</title>
		<link rel="stylesheet" href="css/admincp.css" />
		<script src="js/jquery.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('fieldset:odd').addClass('odd');
				$('tr:odd').addClass('odd');
			});
		</script>
	</head>
	<body id="body-<?= $reqType; ?>">
		<div id="header">
			<h1>YShout Control Panel</h1>

			<div id="navigation">
				<ul>
					<li id="n-home"><a href="?reqType=home">Home</a></li>
					<li id="n-prefs"><a href="?reqType=prefs">Preferences</a></li>
					<li id="n-bans"><a href="?reqType=bans">Bans</a></li>
					<li id="n-logout"><a href="?reqType=logout">Log out</a></li>
				</ul>
			</div>
		</div>

		<? if($reqType == 'login') login(md5($_POST['password']));	?>

		<div id="content">

		<? if ($reqType == 'login' && !loggedIn()) : ?>
			<div class="notice">
				<p>The password you have entered does not coicide with the one intended for use with this YShout Control Panel. If you cannot recall the password you have set to use for the YShout Control Panel, 
				banging your head against the wall is the recommended action to take prior to manually trawling through the preferences file and attempting to decypher what you set as the password. Have a nice day!</p>
			</div>
		<? endif; ?>

		<? if (!loggedIn() || $reqType == 'showlogin') : ?>
			<? include 'cp/loginform.php' ?>
		<? abort(); endif; ?>

		<?

			switch($reqType) {
				case '':
				case 'login':
				case 'home':
					showNotice(); 
					include 'cp/home.php';
					break;

				case 'clearlogs':
					clearLogs();
					redirect(htmlspecialchars($_SERVER['PHP_SELF']) . '?reqType=home');
					break;

				case 'logout':
					logout();
					redirect(htmlspecialchars($_SERVER['PHP_SELF']));
					break;

				case 'bans':
					showNotice(); 
					include 'cp/bans.php';
					break;

				case 'help':
					showNotice(); 
					include 'cp/help.php';
			 		break;

				case 'prefs':
					showNotice(); 
					include 'cp/preferencesform.php'; 
					break;

				case 'setprefs':
					setPreferences();
					showNotice(); 
					include 'cp/preferencesform.php'; 
					break;

				case 'resetprefs':
					resetPreferences();
					showNotice(); 
					include 'cp/preferencesform.php'; 
					break;

				case 'ban':
					doBan();
					showNotice(); 
					include 'cp/bans.php';
					break;

				case 'unban':
					doUnban();
					showNotice(); 
					include 'cp/bans.php';
					break;

				case 'unbanall':
					doUnbanAll();
					showNotice(); 
					include 'cp/bans.php';
					break;
			}
			?>
		</div>
	</body>
</html>