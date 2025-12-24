<?php
require('backend.php');
start_page(26, 'Skill X Tracker');

function get_xp($user) {
	
	$user = str_replace(array('_', '-', '@', '+'), ' ', $user);
	$url = 'http://hiscore.runescape.com/index_lite.ws?player='.$user;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = trim(curl_exec($ch));
	curl_close($ch);
	
	if(substr($output, 0, 1) != '<') {
		$output = explode("\n", $output);
	}
			
	$output = $output[0];
	$output = explode(',',$output);
	$output = $output[2];
	if ($output < 0) $output = 0;

	return $output;
}

//team -5 | rscname = notstarted
//team -5 | rscname= team# | endxp = XP

$query = $db->query("SELECT * FROM `skillx` WHERE `rsname`='status'");
$info = $db->fetch_array($query);
$status = $info['rscname'];

if ($_GET['act'] == 'add') {
	$query = $db->query("SELECT * FROM `skillx` WHERE `team`>0");
	/*if (mysql_num_rows($query) == 0) {*/
		$names = explode(NL,addslashes($_POST['names']));	
		foreach ($names as $name) {
			$name = explode(',',$name);
			$rsn = $name[0];
			$rscn = $name[1];
			$rscid = $name[2];
			
			if ($status == 'notstarted') {
				$team++;
				if ($team == 5) $team = 1;
			} else {
				$team = $name[3];
				if ($team == '') $team = 0;
			}
			
			$db->query("INSERT INTO `skillx` (`rscname`,`rscid`,`rsname`,`team`) VALUES('" . $rscn . "','". $rscid . "','" . str_replace(NL,'',$rsn) . "','" . str_replace(NL,'',$team) . "')");
		}
	$db->query("UPDATE `skillx` SET `rscname`='started' WHERE `rsname`='status'");
	header('Location: '.$_SERVER['PHP_SELF']);
} elseif ($_GET['act'] == 'delete') {
	$name = addslashes($_GET['name']);
	$db->query("DELETE FROM `skillx` WHERE `rsname`='".$name."' AND `team`!=-5");
	header('Location: '.$_SERVER['PHP_SELF']);
} elseif ($_GET['act'] == 'start' || $_GET['act'] == 'end') {
	$act = $_GET['act'];
	$teamxp = array(1 => 0, 2 => 0, 3 => 0, 4 => 0);
	settype($teamxp[1],'integer');
	settype($teamxp[2],'integer');
	settype($teamxp[3],'integer');
	settype($teamxp[4],'integer');
	for ($team = 1; $team <= 4; $team++) {
		$query = $db->query("SELECT * FROM `skillx` WHERE `team`='" . $team . "'");
		while ($info = $db->fetch_array($query)) {
			$rsname = $info['rsname'];
			$startxp = $info['startxp'];
			$xp = get_xp($rsname);
			$db->query("UPDATE `skillx` SET `".$act."xp`='" . $xp . "' WHERE `rsname`='" . $rsname . "'");
			if ($act == 'start') $db->query("UPDATE `skillx` SET `".$act."xp`='" . $xp . "' WHERE `rsname`='" . $rsname . "'");
			else {
				$db->query("UPDATE `skillx` SET `".$act."xp`='" . $xp . "' WHERE `rsname`='" . $rsname . "'");
				//if ($xp < $startxp) echo '<h1>WHOOOPS!</h1>';
				$teamxp[$team] += $xp-$startxp;
			}
		}
		echo '<h1>Team '.$team.': '.$teamxp[$team].'</h1>';
		$db->query("UPDATE `skillx` SET `endxp`='".$teamxp[$team]."' WHERE `rscname`='".$team."'");
	}
	if ($_GET['reload'] != 'yes') header('Location: '.$_SERVER['PHP_SELF']);
} elseif ($_GET['act'] == 'deleteall') {
	$db->query("DELETE FROM `skillx` WHERE `team`!=-5");
	$db->query("UPDATE `skillx` SET `endxp`=0 WHERE `rscname`>0 AND `rscname`<5");
	$db->query("UPDATE `skillx` SET `rscname`='notstarted' WHERE `rsname`='status'");
	header('Location: '.$_SERVER['PHP_SELF']);
} elseif ($_GET['act'] == 'settime') {
	$endtime = addslashes($_POST['time']);
	$db->query("UPDATE `skillx` SET `endxp`='".$endtime."' WHERE `rsname`='status'");
	header('Location: '.$_SERVER['PHP_SELF']);
} elseif ($_GET['act'] == 'starttime') {
	$starttime = addslashes($_POST['time']);
	$db->query("UPDATE `skillx` SET `startxp`='".$starttime."' WHERE `rsname`='status'");
	header('Location: '.$_SERVER['PHP_SELF']);
} elseif ($_GET['act'] == 'settopic') {
	$topic = addslashes($_POST['topic']);
	$db->query("UPDATE `skillx` SET `rscid`='".$topic."' WHERE `rsname`='status'");
	header('Location: '.$_SERVER['PHP_SELF']);
}

echo '<div class="boxtop">Skill X Tracker</div>'.NL.'<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">'.NL;

echo '<div align="left" style="margin:1">
<b><font size="+1">&raquo; Skill X Tracker</font></b>
</div>
<hr class="main" noshade="noshade" align="left" />
<strong>Information:</strong>
<ol>
<li>When adding the first batch of names, you must use the following syntax: "runescape name,rsc name,<acronym title="The number at the end of a member\'s profile link.">rsc id</acronym>".  The second and succeeding times, you need to use "runescape name,rsc name,rsc id,team".  This is because the page only auto-picks teams the first time; make sure you\'re keeping teams even! Do not put spaces around the commas.</li>
<li>Enter start/end time in "YYYY-MM-DD HH:MM" form.  Remember to use 24-hour format and that you should always use GMT. Also, the hour should only span from 0-23; 0 being midnight and 23 being 11PM. Setting time to midnight: Say you want the competition to end at the end of November 27, 2008, but at the beginning of November 28, 2008 (midnight).  You\'d set the time to "2008-11-28 00:00".  If the current time is earlier than the start time, it will show a time until event counter.   If it is after start time but before end time, it will show a time left counter.  If the current time is after both times, it will simply say "event is not underway."</li>
<li>Remember to update the topic ID with each event.</li>
</ol>
<hr class="main" noshade="noshade" align="left" />';

echo '<table style="border-left: 1px solid #000;margin:0 12.5%" width="75%" cellpadding="1" cellspacing="0"><tr><th class="tabletop">RS Name</th><th class="tabletop">RSC Name</th><th class="tabletop">Team</th><th class="tabletop">Delete?</th></tr>';

$query = $db->query("SELECT * FROM `skillx` WHERE `team`>-1 ORDER BY `team` ASC");
if (mysql_num_rows($query) == 0) {
	echo '<tr><td class="tablebottom" colspan="4">There are no contestants currently.</td></tr></table>';
} else {
	while ($info = $db->fetch_array($query)) {
		echo '<tr><td class="tablebottom">'.$info['rsname'].'</td><td class="tablebottom"><a href="/community/index.php?showuser='.$info['rscid'].'">'.$info['rscname'].'</a></td><td class="tablebottom">'.$info['team'].'</td><td class="tablebottom"><a href="'.$_SERVER['PHP_SELF'].'?act=delete&name='.$info['rsname'].'" title="Delete"><img src="/img/calcimg/a_red.PNG" alt="delete"></a></tr>';
	}
}

echo '</table>';

echo '<br /><br /><table style="border-left: 1px solid #000;margin:0 12.5%" width="75%" cellpadding="1" cellspacing="0"><tr><th class="tabletop">Update Experience</th></tr>'
	.'<tr><td class="tablebottom"><form method="post" action="'.$_SERVER['PHP_SELF'].'?act=start"><input type="submit" value="Update Start XP" /></form><br /><br /><form method="post" action="'.$_SERVER['PHP_SELF'].'?act=end"><input type="submit" value="Update Current/End XP" /></form></td></tr></table>';

echo '<br /><br /><table style="border-left: 1px solid #000;margin:0 12.5%" width="75%" cellpadding="1" cellspacing="0"><tr><th class="tabletop">Add Contestants</th></tr>
<tr><td class="tablebottom">
<form method="post" action="'.$_SERVER['PHP_SELF'].'?act=add">
<input type="hidden" name="act" value="add" />
<textarea cols="40" rows="5" name="names"></textarea><br /><input type="submit" value="Add!" /></form>
</td></tr></table>';

echo '<br /><br /><table style="border-left: 1px solid #000;margin:0 12.5%" width="75%" cellpadding="1" cellspacing="0"><tr><th class="tabletop">Delete All Contestants</th></tr>'
	.'<tr><td class="tablebottom"><form method="post" action="'.$_SERVER['PHP_SELF'].'?act=deleteall"><input type="submit" value="Delete All Contestants" /></form></td></tr></table>';
	
$query = $db->query("SELECT * FROM `skillx` WHERE `rsname`='status'");
$info = $db->fetch_array($query);
$starttime = $info['startxp'];
if ($starttime == '') $starttime = 'YYYY-MM-DD HH:MM';
echo '<br /><br /><table style="border-left: 1px solid #000;margin:0 12.5%" width="75%" cellpadding="1" cellspacing="0"><tr><th class="tabletop">Start Time</th></tr>'
	.'<tr><td class="tablebottom"><form method="post" action="'.$_SERVER['PHP_SELF'].'?act=starttime"><input name="time" type="text" value="'.$starttime.'" size="30" style="text-align:center;" /> <input type="submit" value="Update" /></form></td></tr></table>';

$query = $db->query("SELECT * FROM `skillx` WHERE `rsname`='status'");
$info = $db->fetch_array($query);
$endtime = $info['endxp'];
if ($endtime == '') $endtime = 'YYYY-MM-DD HH:MM';
echo '<br /><br /><table style="border-left: 1px solid #000;margin:0 12.5%" width="75%" cellpadding="1" cellspacing="0"><tr><th class="tabletop">End Time</th></tr>'
	.'<tr><td class="tablebottom"><form method="post" action="'.$_SERVER['PHP_SELF'].'?act=settime"><input name="time" type="text" value="'.$endtime.'" size="30" style="text-align:center;" /> <input type="submit" value="Update" /></form></td></tr></table>';

$query = $db->query("SELECT * FROM `skillx` WHERE `rsname`='status'");
$info = $db->fetch_array($query);
$topic = $info['rscid'];
echo '<br /><br /><table style="border-left: 1px solid #000;margin:0 12.5%" width="75%" cellpadding="1" cellspacing="0"><tr><th class="tabletop">RSC Topic ID</th></tr>'
	.'<tr><td class="tablebottom"><form method="post" action="'.$_SERVER['PHP_SELF'].'?act=settopic"><input name="topic" type="text" value="'.$topic.'" size="30" style="text-align:center;" /> <input type="submit" value="Update" /></form></td></tr></table>';


echo '<br /></div>'. NL;

end_page();
?>