<?php

$cleanArr = array(  array('id', $_GET['id'], 'int', 's' => '1,9999'),
					);	
		  
require( '../backend.php' );

$db->connect();
$db->select_db( MYSQL_DB );

$query = $db->query("SELECT avgprice, time FROM price_history WHERE pid = " . $id . ' GROUP BY avgprice ORDER BY id LIMIT 0, 200');
$name = mysql_result($db->query("SELECT name FROM price_items WHERE id = " . $id),0);
$name = ucwords($name);
$max = mysql_result($db->query("SELECT max(avgprice) FROM price_history WHERE pid = " . $id),0) * 1.1;

$data = array();
$date = array();
while($info = $db->fetch_array($query)) {
	$data[$info['time']] = $info['avgprice'];
	$times[] = $info['time'];
}

// Interpolate
$base	= $times[0] / 86400;
$day	= 0;
foreach($times as $val) {
	$num = $val / 86400 - $base;
	while(++$day < $num) {
		$date[($day + $base) * 86400] = ($day + $base) * 86400;
		$data[($day + $base) * 86400] = 'null';
	}
	$date[$val] = date('M d#\c\o\m\m\a# Y', $val);
}
unset($times);
ksort($date);
ksort($data);

// use the chart class to build the chart:
include_once( 'inc/open-flash-chart.php' );
$g = new graph();

$g->bg_colour = '#242424';

// Spoon sales, March 2007
$g->title( 'Runescape Market Trend for ' .$name, '{ font-size: 18px; color: #ffffff; }' );

$g->set_data( $data );
$g->line( 2, '#117AE5', 'Price Trend for ' .$name, 10 );
$g->set_tool_tip( '#x_label#<br>#val#gp' );

// label each point with its value
$g->set_x_labels( $date );
$g->set_x_label_style( 'none', '#242424' );
$g->set_x_axis_steps( 30 );

// set the Y max
$g->set_y_max( $max );
$g->set_y_legend( 'RuneScape GP', 17, '#FFFFFF' );
$g->set_y_label_style( 10, '#FFFFFF' );

// label every 20 (0,20,40,60)
$g->y_label_steps( 5 );

//color of x and y-axis
$g->x_axis_colour( '#D0D0D0', '#344353' );
$g->y_axis_colour( '#D0D0D0', '#3c4e61' );

// display the data
echo $g->render();
?>