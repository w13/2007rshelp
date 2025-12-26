<?php

$cleanArr = array(  array('group', $_GET['group'], 'int', 's' => '1,10'),
				  );	
				  
  require( '../backend.php' );
  $db->connect();
	$db->select_db( 'community' );
	

  $query = $db->query("SELECT `bday_day`,`bday_month`,`bday_year` FROM `ibfmembers` WHERE `mgroup`!=5 AND `mgroup`!=3 GROUP BY `bday_year` ORDER BY `bday_year` ASC,`bday_month` ASC,`bday_day` ASC");
  //$total = mysql_result($db->query("SELECT `bday_day`,`bday_month`,`bday_year` FROM `ibfmembers` WHERE `mgroup`!=5 AND `mgroup`!=3"),0);
  $data = array();
	while($info = $db->fetch_array($query)) {
		if ($info['bday_day'] !== null && $info['bday_year']>1970)  {
			$birth = mktime(0,0,0,$info['bday_month'],$info['bday_day'],$info['bday_year']);
			echo $birth.'<br />';
			$age = time() - $birth;
			$age = $age/(60*60*24*365);
			$data[floor($age)] += 1;
			//$users[] = $info['user'];
		}
}
foreach ($data as $key => $value) {
	if (!isset($value)) $value=0;
}
$users = Array(0=>0,1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12,13=>13,14=>14,15=>15,16=>16,17=>17,18=>18,19=>19,20=>20,21=>21,22=>22,23=>23,24=>24,25=>25,26=>26,27=>27,28=>28,29=>29,30=>30,31=>31,32=>32,33=>33,34=>34,35=>35,36=>36,37=>37,38=>38,39=>39,40=>40);

///*
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
//*/
?>