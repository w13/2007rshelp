<?php
////***** VIDEO FUNCTIONS *****////
function sanitize($var) {

      return htmlentities(strip_tags(addslashes($var)));
}

function breaklongwords($string,$limit=12,$chop=5){  // for example, this would return: $output = text("Well this text doesn't get cut up, yet thisssssssssssssssssssssssss one does.", 10, 5); echo($output); // "Well this text doesn't get cup up, yet thiss sssss sssss sssss sssss sss one does."

$text = explode(" ",$string);
// Replaced each() with foreach() for PHP 8 compatibility
foreach($text as $key => $value){
    $length = strlen($value);
    if($length >=20){
        for($i=0;$i<=$length;$i+=10){
            $new .= substr($value, $i, 10);
            $new .= " ";
        }
         $post .= $new;
    }
    elseif($length <=15){
        $post .= $value;
    }
    $post .= " ";
}
return($post);
}

function videoboxes($result) {

      global $db;
			global $cats;
			
			if(isset($_GET['cat']) || isset($_GET['search_area'])) {
           echo '<table align="center" cellpadding="5" cellspacing="0"><tr>';
           $v=0;
      }
      
			$result = $db->query($result);
			while ($row = $db->fetch_array($result)) {
			
        if(isset($_GET['cat']) || isset($_GET['search_area'])) $v++;
				$unix = $row['date'];
				$added = date("M j, Y", $unix);
				$row['rating'] = floor( $row['rating'] / $row['numratings']);

/**** STAR RATINGS ****/
    if($row['rating'] == 0) $stars = str_repeat('<img src="/img/videos/inactive_star.gif" alt="" />', 5);
    if($row['rating'] == 1) $stars = '<img src="/img/videos/active_star.gif" alt="" />' . str_repeat('<img src="/img/videos/inactive_star.gif" alt="" />', 4);
    if($row['rating'] == 2) $stars = str_repeat('<img src="/img/videos/active_star.gif" alt="" />', 2) . str_repeat('<img src="/img/videos/inactive_star.gif" alt="" />', 3);
    if($row['rating'] == 3) $stars = str_repeat('<img src="/img/videos/active_star.gif" alt="" />', 3) . str_repeat('<img src="/img/videos/inactive_star.gif" alt="" />', 2);
    if($row['rating'] == 4) $stars = str_repeat('<img src="/img/videos/active_star.gif" alt="" />', 4) . '<img src="/img/videos/inactive_star.gif" alt="" />';
    if($row['rating'] == 5) $stars = str_repeat('<img src="/img/videos/active_star.gif" alt="" />', 5);

/**** VIDEO TOP IMAGES ****/
    if(stripos($row['url'],"filefront") != FALSE) $videotop = 'ff';
    elseif(stripos($row['url'],"youtube") != FALSE) $videotop = 'yt';
    elseif(stripos($row['url'],"putfile") != FALSE) $videotop = 'pf';
    elseif(stripos($row['url'],"metacafe") != FALSE) $videotop = 'mc';
    elseif(stripos($row['url'],"veoh") != FALSE) $videotop = 've';
    
        if(isset($_GET['cat']) || isset($_GET['search_area'])) echo '<td>';
        echo '<table cellpadding="0" cellspacing="0" class="video" align="center">'
            .'<tr>'
            .'<td colspan="2" style="background: url(/img/videos/video_top' . $videotop . '.gif) no-repeat;">'
            .'<div class="videoheader">'
            .'&nbsp;&nbsp;<img src="/img/videos/views_icon.gif" alt="Views" />'
            . number_format($row['hits'])
            .'&nbsp;&nbsp;<img src="/img/videos/comment_icon.gif" alt="Comments" />'
            . number_format($row['comments'])
            .'&nbsp;&nbsp;<img src="/img/videos/runtime_icon.gif" alt="Duration" />'
            . $row['length']
            .'</div></td></tr>'
            .'<tr>'
            .'<td colspan="2" class="videomiddle">'
            .'<div class="videomiddle">';
        if(isset($_GET['forumcard'])) echo '<a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?id=' . $row['id'] . '" target="_blank" title="See this video">';
        else echo '<a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?id=' . $row['id'] . '" title="Added: ' . $added . '">';
        echo '<img style="width:208px;height:136px;border:none;" src="' . $row['thumb'] . '" alt="Added: ' . $added . '" /></a>'
            .'</div>'
            .'</td></tr>'
            .'<tr>'
            .'<td colspan="2" class="videomaintext">'
            .'<div class="videomaintext1">'. $row['name'] .'</div>'
            .'<div class="videomaintext2">' . $row['description'] . '</div>'
            .'</td></tr>'
            .'<tr>'
            .'<td class="videolowleft"><div class="videolowleft">Submitted By: ' . $row['author'] .'</div></td>'
            .'<td style="background: url(/img/videos/rating_section.gif) no-repeat;" class="videostars">' . $stars
            .'</td></tr>'
            .'</table><br />';
            if(isset($_GET['cat']) || isset($_GET['search_area'])) echo '</td>';
            if( (($v % 3) == 0) && (isset($_GET['cat']) || isset($_GET['search_area'])) ) echo '</tr>';
		}
            if(isset($_GET['cat']) || isset($_GET['search_area'])) echo '</table>';
}


function printpages($result) {

			global $per_page;
			global $page;
			global $cat;
			global $db;
			
      $per_page          = 9;
      $count             = $db->query($result);
      $count             = mysqli_num_rows($count);
      $page_count        = ceil($count / $per_page) > 1 ? ceil($count / $per_page) : 1;
      $page_links        = ($page > 1 AND $page < $page_count) ? '|' : '';
      $start_from        = $page - 1;
      $start_from        = $start_from * $per_page;
      $end_at            = $start_from + $per_page;
      $qstring           = isset($_GET['search_area']) ? '?search_area=' . $_GET['search_area'] . '&amp;search_term=' . $_GET['search_term'] : '?cat=' . $cat;
      
      if($page > 1) {
          $page_before = $page - 1;
          $page_links = '<a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . $qstring . '&amp;page=' . $page_before . '">< Previous</a> ' . $page_links;
      }
      if($page < $page_count) {
          $page_after = $page + 1;
          $page_links = $page_links . ' <a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . $qstring . '&amp;page=' . $page_after . '">Next ></a> ';
      }
      if($page > 2) {
          $page_links = '<a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . $qstring . '&amp;page=1">&laquo; First</a> '. $page_links;
      }
      if($page < ($page_count - 1)) {
          $page_links = $page_links . ' <a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . $qstring . '&amp;page=' . $page_count . '">Last &raquo;</a> ';
      }
      
      if(!empty($_SERVER['QUERY_STRING'])) {
         echo '<div style="float:left;">Browsing ' . $count . ' Video(s)</div>'
             .'<div style="float:right;margin-right:5px;text-align:right;">Page ' . $page . ' of ' . $page_count . '<br />'
             . $page_links . '</div><div style="clear:both;"></div>';
           }
      else {
      echo '<div style="padding-top:10px;">Total Videos ' . $count . '</div>';
      }
}


function listcategories() {
			global $db;
			$result = $db->query("SELECT * FROM `videoscategory` WHERE `disabled`='0'");
			$i=0;
			
      echo '<tr>'
          .'<td class="caticon">';
      
      while ($row = $db->fetch_array($result)) {
            $i++;
            echo '<a href="?cat=' . $row['id'] . '" title="' . $row['name'] . '" class="category">' . $row['name'] . '</a>';
            if(($i % 5) == 0) {
              echo '</td></tr><tr><td class="caticon">';
            }
			}
      echo '</td></tr>';
}

function thiscat($id) {
			global $db;
			$result = $db->query("SELECT `name` FROM `videoscategory` WHERE `id`= " . $id . " LIMIT 1");
			$row = $db->fetch_array($result);
			return $row['name'];
}

function loadcats() {
	global $db;
	$allcats = array();
	$result = $db->query("SELECT * FROM `videoscategory` WHERE `disabled` = 0");
	while($row = $db->fetch_array($result)){
		$allcats[$row['id']] = $row['name'];
	}
	return $allcats;
}
?>