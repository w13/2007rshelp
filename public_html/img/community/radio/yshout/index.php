<?

error_reporting(E_ALL);
set_error_handler('errorOccurred');
include 'include.php';
if (isset($_POST['reqFor']))
	switch($_POST['reqFor']) {
		case 'shout':

			$ajax = new AjaxCall();
			$ajax->process();
			break;

		default:
			exit;
	}
else
	include 'example.html';

function errorOccurred($num, $str, $file, $line) {
	$err = array (
		'yError' => "$str. <br> File: <u>$file</u>, line <b>$line</b>"
	);

	echo jsonEncode($err);
	exit;
}

?>