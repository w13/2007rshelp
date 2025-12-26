<?php
require('backend.php');
require('edit_class.php');
start_page(20, 'Ads Manager');

$filename = "../content/ads.inc";

if(isset($_POST['savethisplz'])){    // Do we need to SAVE to the file?
 $saved = '<b>SAVED FILE</b>';
 $load = $_POST['savethisplz'];

    if (!$handle = fopen($filename, 'w')) { echo "Cannot open file ($filename)"; }
    if (fwrite($handle, $load) === FALSE) { echo "Cannot write to file ($filename)";  exit; }
    fclose($handle);

}else{ // ... or do we need to just read data from the file?
  $saved = '';
  $handle = fopen($filename, "r");
  $load = fread($handle, filesize($filename));
  fclose($handle);
}

echo '<div class="boxtop">Ads Manager</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;
echo '<div align="left" style="margin:1">
<b><font size="+1">&raquo; Ads Manager</font></b>
</div>
<hr class="main" noshade="noshade" align="left" /><br />
'. $saved . '
<br />
<form method="POST" action="' . $_SERVER['PHP_SELF'] . '" style="text-align:center">
<input type="submit" value="Save" name="Save"><br />
<textarea name="savethisplz" cols="60" rows="15">' . $load . '</textarea><br />
<input type="submit" value="Save" name="Save">
</form>
<br /></div>';

end_page();
?>