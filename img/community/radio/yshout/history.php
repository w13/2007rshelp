<? include 'include.php'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>YShout History Viewer</title>
		<link rel="stylesheet" href="css/history.css" />
	</head>
	<body>
		<div id="header">
			<h1>YShout History Viewer</h1>
		</div>

		<div id="content">

			<ul id="index">
				<? for ($i = 1; $i <= $prefs['logs']; $i++) : ?>
					<li><a href="?log=<?= $i; ?>">Log <?= $i; ?></a></li>
				<? endfor; ?>
			</ul>

			<? 
				$logVar = getVar('log');
				$log = isset($logVar) ? $logVar : '1'; 
				$ys = ys($log);
				$posts = $ys->posts();
			?>
			<h2>Viewing Log #<?= $log; ?></h2>
			
			<? if(sizeof($posts) > 0) : ?>
				<? foreach($posts as $post) : ?>
						<p class="message">
							<em><?= $post['nickname'] ?>:</em>
							<span><?= $post['message'] ?></span>
						</p>
				<? endforeach; ?>
			<? else : ?>
				<p>this log does not contain any shouts.
			<? endif; ?>
		</div>
	</body>
</html>