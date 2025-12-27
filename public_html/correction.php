<?PHP
require(dirname(__FILE__) . '/editor/extras/correct.inc.php');
$cleanArr = array(  array('id', $_GET['id'] ?? null, 'int', 's' => '1,9999'),
					array('area', $_GET['area'] ?? null, 'enum', 'e' => array_keys($area_arr) ),
					array('name', $_POST['name'] ?? null, 'sql', 'l' => $name_len ),
					array('email', $_POST['email'] ?? null, 'sql'),
					array('reply', $_POST['reply'] ?? null, 'bin'),
					array('text', $_POST['text'] ?? null, 'sql', 'l' => $text_len )
				  );
//die('<h2>Sorry, corrections are currently not being taken.</h2>');
function is_valid_email_address( $email ) {

       $qtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
       $dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
       $atom = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c' . '\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
       $quoted_pair = '\\x5c\\x00-\\x7f';
       $domain_literal = "\\x5b($dtext|$quoted_pair)*\\x5d";
       $quoted_string = "\\x22($qtext|$quoted_pair)*\\x22";
       $domain_ref = $atom;
       $sub_domain = "($domain_ref|$domain_literal)";
       $word = "($atom|$quoted_string)";
       $domain = "$sub_domain(\\x2e$sub_domain)*";
       $local_part = "$word(\\x2e$word)*";
       $addr_spec = "$local_part\\x40$domain";

       return preg_match("!^$addr_spec$!", $email) ? 1 : 0;
}

function direct_back( $home = false ) {
	if ( !empty( $_SERVER['HTTP_REFERER'] ) AND !$home ) {
		$redir = $_SERVER['HTTP_REFERER'];
	}
	else {
		$redir = 'http://www.runescapecommunity.com';
	}
	header( 'refresh: 2; url=' . $redir );
	
	return;
}

require(dirname(__FILE__) . '/backend.php');
start_page( 'Correction Submission' );
if($disp->errlevel > 1) {
		direct_back();
		echo '<p align="center">At this time, corrections are not being taken for that content area.</p>' . NL;
}
?>
<div class="boxtop">Correction Submission</div>
<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<div style="font-size: large; font-weight: bold;">&raquo; Correction Submission</div>
<hr class="main" noshade="noshade" />
<?php

if( isset( $c_time )  ) {

	direct_back();
	$minutes = ceil( ( $c_time - time() ) / 60 );
	echo '<p align="center">You must wait ' . $time_lim . ' minutes between correction submissions.</p>' . NL;
	echo '<p align="center">You must wait ' . $minutes . ' more minute(s).</p>' . NL;
}
elseif( isset( $area ) AND !empty( $id ) ) {

	if( $area == 'external' AND !array_key_exists( $id, $external ) ) {
		direct_back();
		echo '<p align="center">At this time, corrections are not being taken for that content area.</p>' . NL;
	}
	elseif( $area != 'external' AND mysqli_num_rows( $query = $db->query( "SELECT * FROM `" . $area . "` WHERE id = " . $id )  ) == 0 ) {
		direct_back();
		echo '<p align="center">At this time, corrections are not being taken for that content area.</p>' . NL;
	}
	else {
		
		if( $_POST ) {
			$name_t = true;
			if( strlen( $name ) > $name_len ) {
				$name_t = false;
			}
			
			$email_t = true;
			if( !empty( $_POST['email'] ?? null ) ) {
				$email_t = is_valid_email_address( $_POST['email'] ?? null );
			}
			else {
				$reply = 0;
			}
			
			if( $reply != 0 AND $reply != 1 ) {
				$reply = 0;
			}
			
			$text_tl = false;
			if( strlen( $text ) <= $text_len ) {
				$text_tl = true;
			}
			$text_ts = false;
			if( strlen( $text ) >= 10 ) {
				$text_ts = true;
			}
		}
		else {
			$name = '';
			$email = '';
			$reply = 0;
			$text = '';
		}
	
		if( ( !isset( $text ) AND !isset( $reply ) ) OR ( isset( $text ) AND isset( $reply ) AND ( !$name_t OR !$text_tl OR !$text_ts OR !$email_t ) ) ) {
		
			if( $_POST ) {
			
				ob_start();
				echo '<p align="center"><b>Oops! ';
				if( !$name_t ) {
					echo 'Your name is too long. It must be ' . $name_len . ' characters or less. ';
				}
				if( !$email_t ) {
					echo 'Your email address is not valid. ';
				}
				if( !$text_tl ) {
					$len = strlen( $text );
					echo 'Your correction is ' . $len . ' characters which exceeds the ' . $text_len . ' character limit. ';
				}
				if( !$text_ts ) {
					echo 'Your correction isn\'t long enough. ';
				}
				echo '</b></p>' . NL;
				$error = ob_get_clean();
			}
		
			$cont_area = $area_arr[$area]['area_name'];
			
			if( $area == 'external' ) {
				$cont_name = $external[$id];
			}
			else {
				$info = $db->fetch_array( $query );
				$cont_name = $info[$area_arr[$area]['sql_name']];
			}
			//if($_COOKIE['member_id']) echo '<h3 style="text-align:center;">Member of RSC? Ever thought of joining the Zybez Content Team and helping make Zybez a better fansite directly?<br /><a href="/community/index.php?showtopic=1051278">Click here to find out more!</a></h3>';
			if($cont_name != "Missing item") { echo '<p>You are submitting a correction for our <b>\'' . $cont_name . '\'</b> entry. Abusing this form will result in a seven day suspension, or permanent ban from using it. Please only use it to submit a correction to our content.</p>' . NL; }
			else { echo '<p>You are submitting a correction informing us of a missing item. Please specify whether it is for the Item Database or Price Guide. Also double check that it is indeed missing before submitting. Abusing this form will result in a seven day suspension, or permanent ban from using it.</p>' . NL; }
			echo '<p>Any content submitted that is not a correction will be disregarded. This form is <b>not</b> for RuneScape assistance. Use Runescape Community\'s <a href="http://forums.zybez.net/forum/202-questions/">Questions</a> forums if you cannot find an answer to your question on <a href="/index.php">Zybez</a>.</p>'. NL;
if($cont_area == "Item Database" && $cont_name != "Missing item" ) {
echo '<p style="text-align:center;"><span style="font-size:15px;"><b>Submitting Item Database Corrections</b></span>'.NL;
echo '<br />If you are reporting a <b>MISSING</b> item, please <a href="/correction.php?area=items&id=4296">click here</a>.'.NL;
echo '<br />Do <b>NOT</b> submit Market Price corrections here, they will be ignored. Use the report icon (<img src="/img/!.gif" alt="" />) only.';
echo '<br />We will accept corrections pertaining to the quality (easy-to-read, contains all the information needed, etc) of the entry.</p>'.NL;
}
			if( isset( $error ) ) echo $error;

			                        echo '<form action="?area=' . $area . '&amp;id=' . (int)$id . '" method="post">' . NL;			echo '<table width="90%" align="center" style="border-left: 1px solid #000000" cellspacing="0">' . NL;
			echo '<tr><td class="tabletop" colspan="2">The Correction Area</td></tr>' . NL;
			echo '<tr><td class="tablebottom">Content Area</td><td class="tablebottom"><input type="text" value="' . $cont_area . '" size="30" disabled="disabled" /></td></tr>' . NL;
			echo '<tr><td class="tablebottom">Content Name</td><td class="tablebottom"><input type="text" value="' . $cont_name . '" size="30" disabled="disabled" /></td></tr>' . NL;
			echo '<tr><td class="tabletop" style="border-top: none;" colspan="2">Your Contact Details</td></tr>' . NL;
			echo '<tr><td class="tablebottom">Your Name (Optional)</td><td class="tablebottom"><input type="text" name="name" value="' . stripslashes( $name ) . '" size="30" maxlength="' . $name_len . '" /></td></tr>' . NL;
			echo '<tr><td class="tablebottom">Your Email (Optional)</td><td class="tablebottom"><input type="text" name="email" value="' . stripslashes( $email ) . '" size="30" /></td></tr>' . NL;
			echo '<tr><td class="tablebottom">Require Reply?</td><td class="tablebottom"><select name="reply">';
			
			if( $reply === 0 ) {
				echo '<option value="0" selected="selected">No - Don\'t E-mail Me</option><option value="1">Yes - Please E-mail Me</option></select></td></tr>' . NL;
			}
			else {
				echo '<option value="0">No - Don\'t E-mail Me</option><option value="1" selected="selected">Yes - Please E-mail Me</option></select></td></tr>' . NL;
			}
			
			echo '<tr><td class="tabletop" style="border-top: none;" colspan="2">Your Correction Submission ( Maximum ' . $text_len . ' Characters )</td></tr>' . NL;
			echo '<tr><td class="tablebottom" colspan="2"><textarea rows="5" cols="1" name="text" style="width: 99%;">' . stripslashes( $text ) . '</textarea></td></tr>' . NL;
			echo '<tr><td class="tablebottom" colspan="2" style="padding: 10px;">The information provided within this form is, to the best of my knowledge, accurate, and that I am not deliberately providing incorrect information.<br /><br />' . NL;
			echo '<input type="submit" value="I Agree - Submit My Correction" /></td></tr>' . NL;
			echo '</table>' . NL;
			echo '</form>' . NL;
			
		}
		else {
			$time_allowed = $area == 'items' ? time() : time() + ( $time_lim * 60 );
			$ip_address = $_SERVER['REMOTE_ADDR'];
			$info = $db->fetch_row( "SELECT * FROM corrections_ip WHERE ip = '" . $ip_address . "'" );

			if( $info['status'] == 3 ) {
				echo '<p align="center">This IP address has been <b>permanently banned</b> from use of the correction form.<br />It was used to send unacceptable content to the staff members of Zybez RuneScape Help.</p>' . NL;
			}
			elseif( $info['status'] == 2 AND $info['status_expire'] > time() ) {
				$days = ceil( ( $info['status_expire'] - time() ) / 86400 );
				echo '<p align="center">This IP address has been <b>suspended</b> from use of the correction form for 7 days.<br />It was used to send unacceptable content to the staff members of Zybez RuneScape Help.</p>' . NL;
				echo '<p align="center">The suspension will end in ' . $days . ' days.</p>' . NL;
			}
			elseif( $info['status'] == 1 AND $info['status_expire'] > time() ) {
				direct_back( true );
				setcookie( 'correct' , $time_allowed , $time_allowed );
				$minutes = ceil( ( $info['status_expire'] - time() ) / 60 );
				echo '<p align="center">You must wait ' . $time_lim . ' minutes between correction submissions.</p>' . NL;
				echo '<p align="center">You must wait ' . $minutes . ' more minute(s).</p>' . NL;
			}
			else {
				$gmt_time = time() + 21600;
			
				$db->query("UPDATE `corrections_ip` SET status = 1, status_expire = " . $time_allowed . " WHERE ip = '" . $ip_address . "'");
		
				if( mysqli_affected_rows() == 0 ) {
				
					$db->query("INSERT INTO `corrections_ip` ( `ip`, `status`, `status_expire` ) VALUES ( '" . $ip_address . "', '1', '" . $time_allowed . "' )");
				}				
				
				$db->query("INSERT INTO `corrections` ( `name`, `ip`,  `email`, `reply`, `text`, `cor_table`, `cor_id`, `time` ) VALUES ( '" . $name . "', '" . $ip_address . "', '" . $email . "', '" . $reply . "', '" . $text . "', '" . $area . "', '" . $id . "', '" . $gmt_time . "' )" ); 
				setcookie( 'correct' , $time_allowed , $time_allowed );
				
				echo '<p><b>Thank you for your submission!</b></p>' . NL;
				echo '<p>A Zybez Runescape Help staff member will now review your submission. ';
				
				if( $reply ) {
					echo 'When your submission is delt with, we will send an email to <i>' . $email . '</i> notifying you what we decided to do. ';
				}
				else {
					echo 'You have chosen <i>not to be notified</i> by our staff of the status of your correction. ';
				}
				echo 'It may take a while to deal with your correction, so please be patient.</p>' . NL;
			}
		}
	}
}
else {

	direct_back();
	echo '<p align="center">No information was provided.</p>' . NL;

}


?>
</div>
<?php
end_page();
?>