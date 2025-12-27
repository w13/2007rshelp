<?php
require(dirname(__FILE__) . '/' . 'backend.php');
start_page('Monster Database BETA');

function subCheck($string) {
  $char = substr($string, 0, 1);
  echo "<!--<br />character: " . $char.'-->';
  if($char == "n") { return true; }
  if(is_numeric($char)) { return true; }
  if($char == "l") {return true;}
  return false;
}

function itemTrim($name) {
  if(substr($name, 0, 6) == "noted ") $name = substr($name, 6);
  //if(substr($name, -7) == " (100%)") $name = substr($name, 0, -7);
  //if(substr($name, 12, 10) == " (level") $name = substr($name, 10);
  //$pos = 3;
  $pos = stripos($name, "(" );
  if($pos > 0) {
    echo "Debug info: Position: " . $pos . "<br /> Substring : " . substr($name, $pos+1);
    if(subCheck(substr($name, $pos+1))) {
      $name = substr($name, 0, $pos);
      echo '<!--bar <br/>-->';
    }
    echo '<br/>An error has occured. Please go back and submit a correction with the information above (if any).';
  }
  return $name;
}

$item = $_GET['item'];
$item = itemTrim($item);
//echo $item;
$quoory = "SELECT `id` FROM `items` WHERE `name` = '".addslashes(trim($item))."'";
$query = $db->query($quoory);

if($db->num_rows($quoory) != 0) {
$id = $db->fetch_row($quoory);
$id = $id['id'];

// header( 'Location: http://2007rshelp.com/items.php?id='.$id.'' );
// This is throwing a php warning (2 feb 2022)


echo '<a href="https://2007rshelp.com/items.php?id='.$id.'">Click here to continue...</a>';
echo '<script>
window.location.replace("https://2007rshelp.com/items.php?id='.$id.'");
</script>';

} else {

echo '<a href="https://2007rshelp.com/items.php?search_area=name&search_term='.$item.'">Click here to continue...</a>';
// this is throwing a PHP warning (2 feb 2022)
// header( 'Location: http://2007rshelp.com/items.php?search_area=name&search_term='.$item.'' );

echo '<script>
window.location.replace("https://2007rshelp.com/items.php?search_area=name&search_term='.$item.'");
</script>';

}
end_page();
?>
