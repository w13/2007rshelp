<?php
$cleanArr = array(  array('user', $_GET['user'], 'sql', 'l' => 12),
                    array('s',    $_GET['s'],    'sql', 'l' => 4),
				  );	
				  
  require( '../backend.php' );
  $db->connect();
	$db->select_db( MYSQL_DB );
	
  $stat_history = mysql_result($db->query("SELECT stat_history FROM mybez WHERE id = 1"),0);
  $stat_history = explode('|',$stat_history);
  $skill_rows = $stat_history[1];
  $skills = explode(',',$skill_rows);

  $query = $db->query("SELECT " . $skill_rows . ", `Time` FROM stats WHERE User = '" . $user . "' GROUP BY " . $skill_rows . " ORDER BY `time`");
  $name = mysql_result($db->query("SELECT User FROM stats WHERE User = '" . $user . "'"),0);
  
  /*$axis = mysql_fetch_row(mysql_query("SELECT max(defencel), min(defencel) FROM stats WHERE User = '" . $user . "'"));
  $max = $axis[0] * 1.05;
  $min = $axis[1] / 1.05;*/
  if($s == 'Overall') {
    $max = 3000;
  }
  else $max = 99;
  $min = 10;
  
  $data = array();
  $date = array();
  while($info = $db->fetch_array($query)) {
        for($m=0; $m<count($skills);$m++) {
            $data[$m][] = $info[$skills[$m]];
            $date[] = date('M', $info['Time']);
        }
  }

// use the chart class to build the chart:
include_once( 'inc/open-flash-chart.php' );
$g = new graph();

$g->bg_colour = '#242424';

// Spoon sales, March 2007
$g->title( 'RuneScape Hiscore Histories '. date("Y"), '{font-size: 18px; color: #ffffff;}' );
$colors = array('#808080', '0x80a033', '#FFFFFF');
for($m=0; array_key_exists($m, $skills); $m++) {
$g->set_data( $data[$m]  );
$g->line_hollow( 2, 4, $colors[$m], $skills[$m] . ' level for ' . $name, 10 );
}

// label each point with its value
$g->set_x_labels( $date );
$g->set_x_label_style( 'none' );

// set the Y max
$g->set_y_max( $max );
$g->set_y_min( $min );

// label every 20 (0,20,40,60)
$g->y_label_steps( 4 );
$g->set_y_label_style( 'none' );

//color of x and y-axis
$g->x_axis_colour( '#D0D0D0', '#808080' );
$g->y_axis_colour( '#D0D0D0', '#808080' );

// display the data
echo $g->render();

?>