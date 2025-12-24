<?PHP
require(dirname(__FILE__) . '/' . 'backend.php');

$query = "SELECT FROM `news` ORDER BY `id` DESC";

$result = $db->query($query);

