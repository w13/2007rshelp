<?php
require('backend.php');

start_page(11, 'Update Stats');

echo '<div class="boxtop">Edit </div>'.NL.'<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">'.NL;

$query = "SELECT userid, COUNT(id) FROM admin_logs GROUP BY userid"; 
$result = mysqli_query($db->connect, $query) or die(mysqli_error($db->connect));
// Print out result
while($row = mysqli_fetch_array($result)){
	echo "Amount of Actions: ". $row['COUNT(id)'] ." - Userid:". $row['userid'] .".";
	echo "<br />";
}

echo '<br /></div>'. NL;

end_page();
?>