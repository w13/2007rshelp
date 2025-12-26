<html>
<head>
<title>Test Graph</title>
<style>	body{	background-color: #242424	}</style>
</head>
<body>
<?php
include_once 'inc/open_flash_chart_object.php';
$user = $_GET['u'];
$skill = $_GET['s'];
open_flash_chart_object( 400, 150, 'history-data.php?u=' . $user . '&s=' . $skill, false );
?>
</body>
</html>
