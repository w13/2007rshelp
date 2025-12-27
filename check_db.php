<?php
require( 'public_html/backend.php' );
$db->connect();
$db->select_db( MYSQL_DB );
$res = $db->query("SELECT name FROM items WHERE name LIKE '%&%' OR name LIKE '%\'%'");
while($row = $db->fetch_array($res)) {
    echo $row['name'] . "\n";
}
?>

