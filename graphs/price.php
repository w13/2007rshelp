<html>
<head>
<title>Runescape Market Price Trend</title>
<style>	body{	background-color: #242424	}</style>
</head>
<body>
<?php
include_once 'inc/open_flash_chart_object.php';
$id = intval($_GET['id']);
open_flash_chart_object( 600, 250, 'price-data.php?id=' . $id, false );
?>
</body>
</html>
