<?php
/*** FUNCTIONS ***/
// Function used to avoid the offline config- added by ben apr 19.
function offline_start( $title = '' )
 {  
  // Global classes
  global $db, $TITLE;

  // Set the TITLE
  $TITLE = $title;
  
  // Connect & Select
  $db->connect();
  $db->select_db( MYSQL_DB );

  // Start the output buffer
  ob_start();
 }

// Format time for all uses.
function format_time($ftime) {
	$output = date ('M jS \'y - g:i A', $ftime);
	return $output;
}
// Get the time in the GMT timezone.
function gmt_time() {
	//global $db;
	$time = time();
	$time = intval($time);
	//$zone = $db->fetch_array($db->query("SELECT zone FROM admin WHERE id = ".$_SESSION['userid']));
	$gmt_time = $time + 18000; //gmt+0 no dst=zulu //$time + ((6 + $zone['zone']) * 60 * 60); 
	return $gmt_time;
}
// Get Number of Corrections
function num_correct($area = '', $id = 0) {
	global $db;
	if(empty($area)) {
		$query = "SELECT * FROM corrections";
	}
	elseif(empty($id)) {
		$query = "SELECT * FROM corrections WHERE cor_table = '".$area."'";
	}
	else {
		$query = "SELECT * FROM corrections WHERE cor_table = '".$area."' AND cor_id = ".$id ;
	}
	$num = $db->num_rows($query);
	return $num;
}
// Display Correction Notification
function enum_correct($area, $id) {
	$num = num_correct($area, $id);
	if($num == 1) {
		echo '<p align="center"><a href="correction.php?area='.$area.'&id='.$id.'" target="_new" title="Go to Correction Listing - New Window"><i>There is <b>1 correction</b> for this entry awaiting review.</i></a></p>'.NL;
	}
	if($num > 1) {
		echo '<p align="center"><a href="correction.php?area='.$area.'&id='.$id.'" target="_new" title="Go to Correction Listing - New Window"><i>There are <b>'.$num.' corrections</b> for this entry awaiting review.</i></a></p>'.NL;
	}
}
// Return POST Content in textbox
function rpostcontent($post_name = '', $return = false) {
    $out = '';
	if(empty($post_name)) {
		$post_main = array(1 => 'text', 2 => 'content');
		for($i = 1; array_key_exists($i, $post_main); $i++) {
			$post_name = $post_main[$i];
			if(!empty($_POST[$post_name])) {
				$out .= '<p align="center"><textarea rows="3" cols="0" style="width: 95%;">'.stripslashes($_POST[$post_name]).'</textarea></p>'.NL;
			}
		}
	}
	else {
		if(!empty($_POST[$post_name])) {
			$out .= '<p align="center"><textarea rows="3" cols="0" style="width: 95%;">'.stripslashes($_POST[$post_name]).'</textarea></p>'.NL;
		}
	}
    
    if ($return) {
        return $out;
    } else {
        echo $out;
    }
}

function last_active() {

    global $TITLE;
    $ntitle = explode(' - ',$TITLE);
    $ntitle = $ntitle[0];

    $currentmembers = '';
    $message = '';
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : '';

/** Get the last active users **/
    $lastactivefile = 'df5g54grf4rf5h6.txt';
    $members = file_get_contents($lastactivefile);

    $latime = time();

    $counter = 0;
    $members = explode('|',$members);

    foreach ($members as $membertime) {
      $info = explode(':', $membertime);
      if(isset($info[1]) && $info[1]+900 >= $latime && $info[0] != $user) {
        if($counter > 0) $currentmembers .= '|' . $info[0] . ':' . $info[1] . ':' . $info[2];
        else $currentmembers .= $info[0] . ':' . $info[1] . ':' . $info[2];
      $counter++;
      }
    }

  if ($user != '' && $currentmembers != '') {
    $currentmembers .=   '|' . $user . ':' . $latime . ':' . $ntitle;
  }
  elseif($user != '') {
    $currentmembers .=   $user . ':' . $latime . ':' . $ntitle;
  }
  else {
    $currentmembers .= 'error'; 
  }

/** Post user list to file **/
  $handle = fopen('df5g54grf4rf5h6.txt','w+');
  fwrite($handle,$currentmembers);

  $members = explode('|',$currentmembers);
  $counter = 1;
  $objects = count($members);
  
  foreach($members as $membertime) {
    $info = explode(':', $membertime);
    
    $message .= '<abbr title="' . round(($latime-$info[1])/60) . ' mins ago viewing: ' . $info[2] . '">' . $info[0] . '</abbr>';
    if($counter == $objects) $message .= '.';
    else $message .= ', ';
    $counter++;
  }
  
  fclose($handle);
  return $message;
}

?>