<html>
<head>
<title>OSRS RuneScape Help Skill Total Graph</title>
<style>body{	background-color: #F4F9FA	}</style>
</head>
<body>
<?php
include_once 'inc/open_flash_chart_object.php';
open_flash_chart_object( 500, 300, 'skill-data.php?username=' . addslashes($_GET['username']) );
?>
</body>
</html>