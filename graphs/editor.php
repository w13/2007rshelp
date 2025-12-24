<html>
<head>
<title>Zybez Content Team</title>
<style>	body{	background-color: #F4F9FA	}</style>
</head>
<body>
<?php
include_once 'inc/open_flash_chart_object.php';
open_flash_chart_object( 400, 400, 'editor-data.php?group=' . intval($_GET['group']) );
?>
</body>
</html>