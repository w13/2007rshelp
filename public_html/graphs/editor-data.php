<?php

$cleanArr = array(  array('group', $_GET['group'], 'int', 's' => '1,10'),
				  );	
				  
  require( '../backend.php' );
  $db->connect();
	$db->select_db( MYSQL_DB );
	
  if($group==0) {
	$query = $db->query("SELECT user, actions FROM admin WHERE actions >0 GROUP BY user, actions");
    $res_total = $db->query("SELECT sum(actions) FROM admin WHERE actions > 0");
    $row_total = mysqli_fetch_row($res_total);
    $total = $row_total[0];
  } else {
    $query = $db->query("SELECT user, actions FROM admin WHERE actions >0 AND groups = " . $group . " GROUP BY user, actions");
    $res_total = $db->query("SELECT sum(actions) FROM admin WHERE actions > 0 AND groups = " . $group);
    $row_total = mysqli_fetch_row($res_total);
    $total = $row_total[0];
  }
  $data = array();
  while($info = $db->fetch_array($query)) {
      $value = ($info['actions'] / $total) * 100;
      $data[] = round($value,2);
      $users[] = $info['user'];
}

include_once( 'inc/open-flash-chart.php' );
$g = new graph();

//
// PIE chart, 60% alpha
//
$g->pie(60,'#505050','{font-size: 12px; color: #404040;');
//
// pass in two arrays, one of data, the other data labels
//
$g->pie_values( $data, $users  );
//
// Colours for each slice, in this case some of the colours
// will be re-used (3 colurs for 5 slices means the last two
// slices will have colours colour[0] and colour[1]):
//
$g->pie_slice_colours( array('#d01f3c','#356aa0','#C79810') );

$g->bg_colour = "#F4F9FA";
$g->set_tool_tip( '#val#% total team work' );

$g->title( 'Pie Chart', '{font-size:18px; color: #d01f3c}' );
echo $g->render();
?>