<?php
require('backend.php');
start_page(1,'Skills Competition');

if ($_POST['act'] == 'updatetext') {
	echo 'POSTING...';
	$textstuff = $_POST['textstuff'];
	$db->query("UPDATE `admin_pads` SET `text`='" . addslashes($textstuff) . "' WHERE `file`='skilltext'") or die(mysqli_error($db->connect));
} else {	
	$query = $db->query("SELECT `text` FROM `admin_pads` WHERE `file`='skilltext'");
	$info = mysqli_fetch_array($query);
	$textstuff = $info['text'];
}

echo '<div class="boxtop">Skills Competition</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right:24px;">' . NL
	.'<div style="float: right;"><a href="'.$_SERVER['PHP_SELF'].'"><img src="images/browse.gif" title="Browse" border="0" /></a></div>'
	.'<div align="left" style="margin:1"><b><font size="+1">&raquo; Skills Competition';

echo '</font></b></div><hr class="main" noshade="noshade" align="left" />'
	.'<strong>Information:</strong><ol><li>Only click "Update Start XP at the beginning of the competition (never after) If you screw this up, the previous data <strong>cannot</strong> be recovered.</li><li>When adding names, you must use the following syntax: "runescape name,rsc name,<acronym title="The number at the end of a member\'s profile link.">rsc id</acronym>".  Do not put spaces around the commas.  The only thing needed when deleting names is the runescape name.  Place each new person on a new line.</li></ol><hr class="main" noshade="noshade" align="left" />';

if ($skill == '') {
	echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'" style="text-align:center;">'
		.'<strong>Text to display on the Skills Competition page:</strong><br />'
		.'<textarea name="textstuff" rows="10" cols="70">'.str_replace("\"","&quot;",$textstuff).'</textarea>'
		.'<br /><input type="hidden" name="act" value="updatetext" /><input type="submit" value="Update" /></form>'
		.'<hr class="main" noshade="noshade" align="left" /><br />'
		.'<table style="border-left: 1px solid #000;margin:0 25%" width="50%" cellpadding="1" cellspacing="0">';
	echo '</table>';
} else {
	if ($act == 'start' || $act == 'end') {
		$query = $db->query("SELECT * FROM `comp_names`");
		while ($info = $db->fetch_array($query)) {
			$name = $info['name'];
			$startxp = $info['startxp'];
			$xpstuff = get_stat($name);
			$key = array_search($skill,$skillsforhiscores);
			foreach ($xpstuff as $num => $value) {
				if ($num == $key) $xp = $value;
			}
			$xp = explode(',',$xp);
			$xp = $xp[2];
			if ($xp < 0) $xp = 0;
			$db->query("UPDATE `comp_names` SET `".$act."xp`='" . $xp . "' WHERE `name`='" . $name . "' AND `skill`='" . $skill . "'");
			if ($act == 'start') $db->query("UPDATE `comp_names` SET `".$act."xp`='" . $xp . "',`xpdiff`=0 WHERE `name`='" . $name . "' AND `skill`='" . $skill . "'");
			else $db->query("UPDATE `comp_names` SET `".$act."xp`='" . $xp . "',`xpdiff`='" . ($xp-$startxp) . "' WHERE `name`='" . $name . "' AND `skill`='" . $skill . "'");
		}
		header('Location: '.$_SERVER['PHP_SELF'].'?skill='.$skill);
	}
	elseif ($act == 'add') {
		$names = explode(NL,addslashes($_POST['names']));
		foreach ($names as $name) {
			$name = explode(',',$name);
			$rsn = $name[0];
			$rscn = $name[1];
			$rscid = $name[2];
			$db->query("INSERT INTO `comp_names` (`rscname`,`rscid`,`name`,`skill`) VALUES('" . $rscn . "','". $rscid . "','" . str_replace(NL,'',$rsn) . "','" . $skill . "')");
		}
		header('Location: '.$_SERVER['PHP_SELF'].'?skill='.$skill);
	} elseif ($act == 'delete') {
		$names = explode(NL,addslashes($_POST['names']));
		foreach ($names as $name) {
			$db->query("DELETE FROM `comp_names` WHERE `name`='" . $name . "' AND `skill`='" . $skill . "'");
		}
		header('Location: '.$_SERVER['PHP_SELF'].'?skill='.$skill);
	} elseif ($act == 'deleteall') {
		$db->query("DELETE FROM `comp_names` WHERE `skill`='" . $skill . "'");
		header('Location: '.$_SERVER['PHP_SELF'].'?skill='.$skill);
	} else {
		echo '<table style="border-left: 1px solid #000;margin:0 25%" width="50%" cellpadding="1" cellspacing="0">'
			.'<tr><th class="tabletop">RS Name</th><th class="tabletop">RSC Name</th></tr>';
		$query = $db->query("SELECT `name`,`rscname`,`rscid` FROM `comp_names` WHERE `skill`='" . $skill . "'");
		if (mysqli_num_rows($query) == 0) {
			echo '<tr><td class="tablebottom" colspan="2">No Names To Display</td></tr>';
		} else {
			while ($info = $db->fetch_array($query)) {
				echo '<tr><td class="tablebottom">'.$info['name'].'</td><td class="tablebottom"><a href="/community/index.php?showuser='.$info['rscid'].'">'.$info['rscname'].'</a></td></tr>';
			}
		}
		echo '</table>';
		echo '<br /><br /><table style="border-left: 1px solid #000;margin:0 25%" width="50%" cellpadding="1" cellspacing="0"><tr><th class="tabletop">Update Experience</th></tr>'
			.'<tr><td class="tablebottom"><form method="post" action="'.$_SERVER['PHP_SELF'].'?skill='.$skill.'&act=start"><input type="submit" value="Update Start XP" /></form><br /><br /><form method="post" action="'.$_SERVER['PHP_SELF'].'?skill='.$skill.'&act=end"><input type="submit" value="Update Current/End XP" /></form></td></tr></table>'
			.'<br /><br /><table style="border-left: 1px solid #000;margin:0 25%" width="50%" cellpadding="1" cellspacing="0"><tr><th class="tabletop">Add Names</th></tr>'
			.'<tr><td class="tablebottom"><form method="post" action="'.$_SERVER['PHP_SELF'].'?skill='.$skill.'&act=add"><textarea cols="20" rows="5" name="names"></textarea><br /><input type="submit" value="Add!" /></form></td></tr></table>'
			.'<br /><br /><table style="border-left: 1px solid #000;margin:0 25%" width="50%" cellpadding="1" cellspacing="0"><tr><th class="tabletop">Delete Names</th></tr>'
			.'<tr><td class="tablebottom"><form method="post" action="'.$_SERVER['PHP_SELF'].'?skill='.$skill.'&act=delete"><textarea cols="20" rows="5" name="names"></textarea><br /><input type="submit" value="Delete!" /></form></td></tr></table>'
			.'<br /><br /><table style="border-left: 1px solid #000;margin:0 25%" width="50%" cellpadding="1" cellspacing="0"><tr><th class="tabletop">Delete All</th></tr>'
			.'<tr><td class="tablebottom">This will delete all the names from this skill.<br /><br /><form method="post" action="'.$_SERVER['PHP_SELF'].'?skill='.$skill.'&act=deleteall"><input type="submit" value="Delete ALL!" /></form></td></tr></table>';
	}
}

echo '<br /></div>';
end_page();
?>