<?
require( 'backend.php' );
require( 'edit_class.php' );
start_page( 12, 'Test' );
## For Item, Monster, Shop database
## Go to item/monster/shop
## Hit 'copy'
## ?copy&amp;table='.$table.'&amp;id=
## 
##
    if(isset($_GET['copy']))
      {
        $table = substr(substr($_SERVER['PHP_SELF'], 8),0, -4);
        $id = $_GET['id'];
        $run = mysql_query("INSERT INTO " . $table . " ((SELECT * FROM ".$table." WHERE NOT EXISTS (SELECT TOP 1 * FROM ".$table."))) (SELECT * FROM ".$table." WHERE NOT EXISTS (SELECT TOP 1 * FROM ".$table.") AND id = ".$id));
       }
end_page();
?>