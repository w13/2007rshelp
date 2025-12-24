<?php

$cleanArr = array(  array('user', $_GET['u'], 'sql', 'l' => 12),
					array('skill', $_GET['s'], 'sql', 'l' => 12),
				  );	
				  
  require( '../backend.php' );
  $db->connect();
	$db->select_db( MYSQL_DB );
				  
  $skill .= 'l';
  $query = $db->query("SELECT " . $skill . ", Time FROM stats WHERE User = '" . $user . "' AND " . $skill . " > 0 GROUP BY " . $skill . " ORDER BY `time` ASC");
  $name = ucwords($user);
  if($_GET['s'] == 'Overall') {
    $max = 2500;
  }
  else { 
  $max = 99;
  }
  
  $data = array();
  $date = array();
  while($info = $db->fetch_array($query)) {
    for($i=0; $i<count($info);$i++) {
        $data[] = $info[$skill];
        $date[] = date('M d Y', $info['Time']);
    }
  }

  // use the chart class to build the chart:
  include_once( 'inc/open-flash-chart.php' );
  $g = new graph();

  $g->bg_colour = '#242424';

  // Spoon sales, March 2007
  $g->title( 'Runescape Hiscore History for ' .$name, '{ font-size: 18px; color: #ffffff; }' );

  $g->set_data( $data );
  $g->line( 2, '#117AE5', substr($skill,0,-1) . ' History', 10 );


  // label each point with its value
  $g->set_x_labels( $date );
  $g->set_x_label_style( 'none' );

  // set the Y max
  $g->set_y_max( $max );
  $g->set_y_legend( 'Level', 17, '#FFFFFF' );
  $g->set_y_label_style( 10, '#FFFFFF' );

  // label every 20 (0,20,40,60)
  $g->y_label_steps( 5 );

  //color of x and y-axis
  $g->x_axis_colour( '#D0D0D0', '#344353' );
  $g->y_axis_colour( '#D0D0D0', '#3c4e61' );

  // display the data
  echo $g->render();
?>