<?php
## THEEXTREMISTS' TESTING FILE ##
require(dirname(__FILE__) . '/' . 'backend.php');
//if($_SESSION['user'] == 'Ben_Goten78' || $_SESSION['user'] == 'Jeremy' || $_SESSION['user'] == 'Myst') {
require(dirname(__FILE__) . '/extras/correct.inc.php');
start_page( 14, 'Correction Listings' );

?>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function displayHTML(form) {
var inf = form.code.value;
win = window.open(", ", 'popup', 'toolbar = no, status = no');
win.document.write("" + inf + "");
}
//End -->
</script>
<script type="text/javascript">
var formChanged = false;

window.onbeforeunload = function() {
    if (formChanged) return "Is this REALLY the action you want to apply?";
}
</script>
<div class="boxtop">Correction Listing</div>
<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<?php

if( isset( $_POST['count'] ) ) {
	
	$count = $_POST['count'];
	$delete = '';
	while( $count > 0 ) {
		$act = $_POST['act' . $count ];
		$en_info = $_POST['info' . $count ];
		$info = unserialize( base64_decode( $en_info ) );

		if( $act != 'NA' AND $info['reply'] ) {

			if( !empty( $info['name'] ) ) {
				$name = $info['name'];
			}
			else {
				$name = 'Anonymous User';
			}

			$to = $name . '<' . $info['email'] . '>';
			$subject = 'A Reply to Your Submission';
			$headers = 'From: OSRS RuneScape Help Corrections <no-reply@2007rshelp.com>';

			$stime = date( "l F jS, Y", $info['time'] ) . ' at ' . date( "g:i a", $info['time'] );
			$correction = $info['text'];
			
			if( $act == 'F' ) {
				$msg_file = 'extras/fixed.msg.txt';
			}
			elseif( $act == 'S' ) {
				$msg_file = 'extras/suspend.msg.txt';
			}
			elseif( $act == 'B' ) {
				$msg_file = 'extras/banned.msg.txt';
			}
			else {
				$msg_file = 'extras/notfixed.msg.txt';
			}
				
			ob_start();
			require( $msg_file );
			$message = ob_get_clean();
			
			$message = str_replace( '[#NAME#]'			, $name			, $message );
			$message = str_replace( '[#TIME#]'			, $stime		, $message );
			$message = str_replace( '[#CORRECTION#]'	, $correction	, $message );
			$message = str_replace( '\n'	, '.\n'	, $message );
			
			mail( $to, $subject, $message, $headers );
		}

		if( $act == 'B' ) {
			$db->query( "UPDATE corrections_ip SET status = 3, status_expire = 0, rating = rating - 5 WHERE ip = '" . $info['ip'] . "'" );
			$add_delete = " ip = '" . $info['ip'] . "'";
		}
		elseif( $act == 'S' ) {
			$expire_time = time() + 604800;
			$db->query( "UPDATE corrections_ip SET status = 2, status_expire = " . $expire_time . ", rating = rating - 2 WHERE ip = '" . $info['ip'] . "'" );	
			$add_delete = " ip = '" . $info['ip'] . "'";
		}
		elseif( $act == 'NF' ) {
      $db->query( "UPDATE corrections_ip SET rating = rating - 1 WHERE ip = '" . $info['ip'] . "'" );
			$add_delete = " id = " . $info['id'];
		}
		elseif( $act == 'F' ) {
			$db->query( "UPDATE corrections_ip SET rating = rating + 1 WHERE ip = '" . $info['ip'] . "'" );
			//Seems like it needs to be here for it to work... but where does the info in the query come from?
			//$db->query("UPDATE `".$area."` SET `credits` = CONCAT(credits,', ','".$name."') WHERE id = " . $id);
			$add_delete = " id = " . $info['id'];
		}

		if( isset( $add_delete ) AND empty( $delete ) ) {
			$delete = $add_delete;
		}
		elseif( isset( $add_delete ) ) {
			$delete .= " OR" . $add_delete;
		}

		$count--;
	}
	if( !empty( $delete ) ) {
		$db->query( "DELETE FROM corrections WHERE " . $delete );
	}
	if( $act != 'NA') {
	$stuff = 'Correction Listing';
	$ses->record_act( $stuff, 'Process', $_POST['entry'], $ip ); }
    echo '<p align="center">All requested actions have been taken. Redirecting to Correction Listings...</p>' . NL;
    header( 'refresh: 0; url=' . htmlspecialchars($_SERVER['SCRIPT_NAME']) );
}
elseif( isset( $_GET['area'] ) AND array_key_exists( $_GET['area'], $area_arr ) AND isset( $_GET['id'] ) ) {

	$area = $_GET['area'];
	$area_nm = $area_arr[$area]['area_name'];
	$sql_nm = $area_arr[$area]['sql_name'];
	$id = intval( $_GET['id'] );
	
	$query = $db->query( "SELECT corrections.*, corrections_ip.rating FROM corrections, corrections_ip WHERE cor_table = '" . $area . "' AND cor_id = " . $id . " AND corrections_ip.ip = corrections.ip ORDER BY time" );

	if( $area == 'external' ) {
		$entry_name = $external[$id];
	}
	else {
		$temp_info = $db->fetch_row( "SELECT " . $sql_nm . " FROM " . $area . " WHERE id = " . $id );
		$entry_name = $temp_info[$sql_nm];
	}
	$url = '/editor/'.$area_arr[$area]['editor'].$id;
	$url2 = '/'.$area.'.php?id='.$id;
	?>
	      <div style="font-size: large; font-weight: bold;">&raquo; <a href="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>">Correction Listing</a> &raquo; <a href="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>?area=<?php echo $area;?>"><?php echo $area_nm; ?></a> &raquo; <a href="<?php echo $url; ?>" target="_new"><?php echo $entry_name; ?></a> (<a href="<?php echo $url2;?>" target="_new">Preview</a>)</div>
	
	<hr class="main" noshade="noshade" />
	<p style="text-align:center;">Make sure the submission is CORRECT. If you are unsure, ask in the Questions Forum.<br />If you don't think a correction is a useful addition to a guide, get a second opinion first before NFing it.<br />If someone needs to be banned, please LEAVE the correction and post a link in the shoutbox.<br />For those who NF a LOT, make sure you are 100% sure that the correction is useless to the guide/entry. If someone asks a question, why are they asking? Because it's not in the guide! Fix that correction and add it!</p>
	<?php
	if($_GET['area'] == 'price_items') echo '<h3 style="text-align:center;color:red;">These corrections have automatically been submitted by a script I created, to help update our keywords.<br />These are not user submitted!</h3>';
	if($_GET['id'] == 5577 || $_GET['id'] == 2165) echo '<p style="text-align:center;font-weight:bold;color:red;">THESE ARE AUTO-SUBMITTED CORRECTIONS.<br />When a user fails a search in the database, it automatically submits this correction. <span style="color:#fff;">If you can figure out what item they were trying to find, add the search term they used to that entry\'s keywords.</span><br />ONLY add the part of their search term that we dont have in the name or keyword field. E.G. bandos cheset. Only add cheset, because bandos is in the name.</p>';
	?>
	      <form action="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>" method="post">
	
	<input type="hidden" name="entry" value="<?php echo $entry_name; ?>" />
	<table width="90%" align="center" cellpadding="1" cellspacing="0" style="border-left: 1px solid #000000;">
	<tr>
	<td class="tabletop" width="10%">Name</td>
	<td class="tabletop">Correction Submission</td>
	<td class="tabletop" width="37" title="Ban IP - Delete All Related Submissions">B</td>
	<td class="tabletop" width="37" title="Suspend IP - Delete All Related Submissions">S</td>
	<td class="tabletop" width="37" title="Correction Fixed - Delete Submission">F</td>
	<td class="tabletop" width="37" title="Correction Not Fixed - Delete Submission">NF</td>
	<td class="tabletop" width="37" title="No Action Taken">NA</td>
	</tr>
	<?php
	
	$num = 0;
	while( $info = $db->fetch_array( $query ) ) {
		$num++;
		$en_info = base64_encode( serialize( $info ) );
		
		if( empty( $info['name'] ) ) $info['name'] = '-';

		echo '<tr>' . NL;
		echo '<input type="hidden" name="info' . $num . '" value="' . $en_info . '" />' . NL;
		echo '<td class="tablebottom" rowspan="3" title="Email: '.$info['email'].'">' . $info['name'] . '</td>' . NL;
		echo '<td class="tablebottom" rowspan="3" style="text-align: left;">' . str_replace('&amp;quot;','&quot;',nl2br(htmlentities(stripslashes($info['text']), ENT_QUOTES))) . '</td>' . NL;
		
		if( $ses->permit( 15 ) ) {
			echo '<td class="tablebottom" title="Ban IP - Delete All Related Submissions" onclick="formChanged = true;"><input type="radio" name="act' . $num . '" value="B" /></td>' . NL;
		}
		else {
			echo '<td class="tablebottom" title="Ban IP - Delete All Related Submissions"><input type="radio" name="act' . $num . '" value="B" disabled="disabled" /></td>' . NL;
		}
		echo '<td class="tablebottom" title="Suspend IP - Delete All Related Submissions" onclick="formChanged = true;"><input type="radio" name="act' . $num . '" value="S" /></td>' . NL;
		echo '<td class="tablebottom" title="Correction Fixed - Delete Submission"><input type="radio" name="act' . $num . '" value="F" /></td>' . NL;
		echo '<td class="tablebottom" title="Correction Not Fixed - Delete Submission" onclick="formChanged = true;"><input type="radio" name="act' . $num . '" value="NF" /></td>' . NL;
		echo '<td class="tablebottom" title="No Action Taken"><input type="radio" name="act' . $num . '" value="NA" checked="checked" /></td>' . NL;
		echo '</tr>' . NL;
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="5" title="IP Address (Rating)">' . $info['ip'] . ' (' . $info['rating'] . ')</td>' . NL;
		echo '</tr>' . NL;
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="5" title="Date/Time Submitted (GMT)">' . format_time($info['time']) . '</td>' . NL;
		echo '</tr>' . NL;
	}

	if( $num == 0 ) {
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="8">There are no corrections in this category.</td>' . NL;
		echo '</tr>' . NL;
	}
	
	?>
	</table>
	<?php
	
	if( $num > 0 ) {
		echo '<input type="hidden" name="count" value="' . $num . '" />' . NL;
		echo '<p align="center"><input type="submit" value="Process Corrections for \'' . $entry_name . '\'" /></p>' . NL;
	}
	
	?>
	</form>
	<?php
	

}
elseif( isset( $_GET['area'] ) AND array_key_exists( $_GET['area'], $area_arr ) ) {

	$area = $_GET['area'];
	$area_nm = $area_arr[$area]['area_name'];
	$sql_nm = $area_arr[$area]['sql_name'];
	
	if( $area == 'external' ) {
		$quack = "SELECT cor_id, COUNT(cor_id) AS amount FROM corrections WHERE cor_table = 'external' GROUP BY cor_id HAVING ( COUNT(cor_id) > 0 ) ";
	}
	else {
		$quack = "SELECT corrections.cor_id, " . $area . "." . $sql_nm . ", COUNT(cor_id) AS amount FROM corrections, " . $area . " WHERE cor_table = '" . $area . "' AND " . $area . ".id = cor_id GROUP BY cor_id HAVING ( COUNT(cor_id) > 0 ) ORDER BY " . $area . "." . $sql_nm;
	}
	
	$query = $db->query($quack);
	$num = $db->num_rows( $quack );
	
	?>
	        <div style="font-size: large; font-weight: bold;">&raquo; <a href="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>">Correction Listing</a> &raquo; <?php echo $area_nm;?> </div>
	
	<hr class="main" noshade="noshade" /><br />
	<table style="border-left: 1px solid #000000;" width="80%" align="center" cellpadding="1" cellspacing="0">
	<tr>
	<td class="tabletop">Name</td>
	<td class="tabletop">Number of Corrections</td>
	</tr>
	<?php
	
	while( $info = $db->fetch_array( $query ) ) {

		if( $area == 'external' ) {
			$name = $external[$info['cor_id']];
		}
		else {
			$name = $info[$sql_nm];
		}

		echo '<tr>' . NL;
		echo '<td class="tablebottom"><a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?area=' . $area . '&id=' . $info['cor_id'] . '">' . $name . '</a></td>' . NL;
		echo '<td class="tablebottom">' . $info['amount'] . '</td>' . NL;
		echo '</tr>' . NL;
	}
	if( $num == 0 ) {
	
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="5">There are no corrections in this category.</td>' . NL;
		echo '</tr>' . NL;
	}
	
	?>
	</table><br />
	<?php
}
elseif(isset($_GET['wipe_old']) && $_SESSION['user'] == 'Ben_Goten78') {
$db->query("DELETE FROM `corrections_ip` WHERE status_expire < UNIX_TIMESTAMP()-2592000 AND status !=3 AND rating < 5");
echo 'Wiping old shit';
header("refresh: 2; url=correction.php");
}
else {
	
	?>
	<div style="font-size: large; font-weight: bold;">&raquo; Correction Listing</div>
	<hr class="main" noshade="noshade" /><br />
	<?php if($_SESSION['user'] == 'J36') echo '<h2 style="text-align:center;">Maintenance: <a href="correction.php?wipe_old">Wipe Old Correction Submitters</a></h2>'; ?>
	<table style="border-left: 1px solid #000000;" width="80%" align="center" cellpadding="1" cellspacing="0">
	<tr>
	<td class="tabletop">Area</td>
	<td class="tabletop">Number of Corrections</td>
	</tr>
	<?php
	
	$quack = "SELECT cor_table, COUNT(cor_table) AS amount FROM corrections GROUP BY cor_table ORDER BY cor_table";
	$query = $db->query($quack );
	$num = $db->num_rows( $quack );

	while( $info = $db->fetch_array( $query ) ) {

		$area = $info['cor_table'];
		$area_name = $area_arr[$area]['area_name'];
		
		echo '<tr>' . NL;
		echo '<td class="tablebottom"><a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?area=' . $area . '">' .$area_name . '</a></td>' . NL;
		echo '<td class="tablebottom">' . $info['amount'] . '</td>' . NL;
		echo '</tr>' . NL;
	}
	if( $num == 0 ) {
	
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="5">There are no corrections in this category.</td>' . NL;
		echo '</tr>' . NL;
	}

	echo '</table>' . NL;
}

echo '<br /></div>' . NL;
end_page();
/*}
else {die('Corrections are OFF until the Miscellaneous Guides are completed! Pink ones are done, so there\'s only like 25ish to go. Hop to it!'); }*/
?>