<?php
$cleanArr = array(  array('username', $_GET['username'], 'sql', 'l' => 12),
				  );	
				  
  require( '../backend.php' );
  $db->connect();
	$db->select_db( MYSQL_DB );

   /* CLEAN THE USER */                                   
  $normalise = array("_", "-", "@", "+", "'", "\"", "=", ":", "/", ".","%",";","\\");
  $username = stripslashes($username);
  $username = str_replace($normalise,' ',$username);
  $username = ucwords($username);
  
  $query =$db->query("SELECT * FROM stats WHERE User = '" . $username . "' ORDER BY time DESC LIMIT 1");
  $total = mysql_result($db->query("SELECT max(overalll) FROM stats WHERE User = '" . $username . "'"),0);
  $data = array();

  $skillnames = array('Attack',
                      'Defence',
                      'Strength',
                      'Hitpoints',
                      'Ranged',
                      'Prayer',
                      'Magic',
                      'Cooking',
                      'Woodcutting',
                      'Fletching',
                      'Fishing',
                      'Firemaking',
                      'Crafting',
                      'Smithing',
                      'Mining',
                      'Herblore',
                      'Agility',
                      'Thieving',
                      'Slayer',
                      'Farming',
                      'Runecraft',
                      'Hunter',
                      'Construction',
                      'Summoning'
                      );
                      
  $info = $db->fetch_array($query);
  if($total == 0 || $total == -1) $total = 1000;
  for($m=0;$m<count($skillnames);$m++) {
  if($info[$skillnames[$m].'l'] != -1) {
      $value = ($info[$skillnames[$m].'l'] / $total) * 100;
      $data[] = round($value,2);
      //$skills[] = $skillnames[$m];
      //$levels[] = $info[$skillnames[$m].'l'];
      $labels[] = $skillnames[$m] . ' ('.$info[$skillnames[$m].'l'].')';
   }
  }

include_once( 'inc/open-flash-chart.php' );
$g = new graph();

//
// PIE chart, 60% alpha
//
$g->pie(60,'#505050');
//
// pass in two arrays, one of data, the other data labels
//
$g->pie_values( $data, $labels );
//
// Colours for each slice, in this case some of the colours
// will be re-used (3 colurs for 5 slices means the last two
// slices will have colours colour[0] and colour[1]):
//
$g->pie_slice_colours( array('#d01f3c','#356aa0','#C79810') );

$g->bg_colour = "#F4F9FA";
$g->set_tool_tip( '#val#% of overall' );

$g->title( 'Distribution of Skills over Total Level', '{font-size:18px; color: #d01f3c}' );
echo $g->render();
?>