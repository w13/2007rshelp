<?php

require( 'backend.php' );
require( 'edit_class.php' );
start_page( 2, 'Quest Guide' );

$category = 'quests';
$cat_name = $cat_array[$category];
$edit = new edit( $category, $db );

echo '<div class="boxtop">Quest Guide</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right:24px;">' . NL;

?>
<script language="JavaScript">
function hide(i)
{
   var el = document.getElementById(i)
   if (el.style.display=="none")
   {
      el.style.display="block";
   }
   else
   {
      el.style.display="none";
   }
}
</script>
<div style="float: right;"><a href="?cat=<?php echo $category; ?>"><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="?act=new&cat=<?php echo $category; ?>"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; Quest Guides</font></b>
</div>
<hr class="main" noshade="noshade" align="left" />
<a href="#" onclick=hide('tohide')><b>HELLO, PLEASE READ THESE INSTRUCTIONS [ Click ]</b></a><br /><br />
<div id="tohide" style="display:none">
<p style="text-align:center;">YOU MUST FOLLOW THESE INSTRUCTIONS</p>
<b>Rules</b>
<ol>
<li>Use the <a href="guidewizard.php?quest">Quest Wizard</a>.</li>
<li>Look through the coding structure of a completed guide before starting your first one. The coding structure <strong>MUST</strong> be the same all throughout so they're easy to edit in future (this is: spaces between steps/parts, placing of br tags, images, etc).</li>
</ol>

<b>What to do</b>
<ol>
<li>Don't forget to change the Difficulty/Length image numbers for their images. Don't forget to change the questfolder in the start loc.png image to the quest guide's image folder.</li>
<li>Reward: Always use XP (not exp, experience or EXP), order the rewards by smallest to lowest XP rewarded.</li>
<li>Rename "Parts" sometimes (be more creative, dont use "beginning the quest" -- some parts may need to be merged with other parts and renamed entirely) as you will be merging more steps together (e.g. regicide from 34 to 14 steps, cook assistant, 3 parts to 1)</li>
<li>Write short notes in the span part under Step #. Shortened version of the paragraph, accounting for ASSUMED KNOWLEDGE and what you need to do whilst talking to someone. See Regicide guide for examples. ALWAYS end a step in a full stop (.). Separate steps using a &lt;br /&gt;</li>
<li>The notes shouldn't be any longer than the step. If the notes make white space at the bottom of the step, add more content to the step, merge or cut out some notes.</li>
<li>Make important images visible. Use the Quest Guide Wizard to insert an image right or middle and change the file path and alt tag. Don't worry about how they look, they will be fixed at the end.
<li>DO NOT USE DEPRECATED HTML [[use CSS]]: &lt;center&gt; [[use: style="display:block; margin:0 auto;"]], align [[style="float:left/right"]], &lt;i&gt; [[&lt;em&gt;]], &lt;font..&gt; [[span]], hspace/vspace [[style="padding:5px 0;"]]</li>
</ol></div>

<?php

if( isset( $_POST['act'] ) AND $_POST['act'] == 'edit' AND isset( $_POST['id'] ) ) {

	$id = intval( $_POST['id'] );
	$name = $edit->add_update( $id, 'name', $_POST['name'], 'You must enter a name.' );
	$author = $edit->add_update( $id, 'author', $_POST['author'], 'You must enter an author.' );
	$type = $edit->add_update( $id, 'type', $_POST['type'], 'You must enter a type.' );
	$text = $edit->add_update( $id, 'text', $_POST['text'], 'You must enter some content.' );
	$difficulty = $edit->add_update( $id, 'difficulty', $_POST['difficulty'], 'You must enter a difficulty rating (1-5).' );
	$length = $edit->add_update( $id, 'length', $_POST['length'], 'You must enter a length rating (1-5).' );
	$reward = $edit->add_update( $id, 'reward', $_POST['reward'], 'You must enter the XP and QP rewards.' );
	$hdimg = $edit->add_update( $id, 'hdimg', isset($_POST['hdimg']) ? 1 : 0, '', false );
	
	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
		rpostcontent();
	}
	else {
		$ses->record_act( 'Quest Guides', 'Edit', $name, $ip );
		echo '<p align="center">Entry successfully edited into OSRS RuneScape Help Quest Guide Area.</p>' . NL;
		//header( 'refresh: 2; url=' . $_SERVER['PHP_SELF'] . '?cat=' . $category );
	}

}
elseif( isset( $_POST['act'] ) AND $_POST['act'] == 'new' ) {

	$name = $edit->add_new( 1, 'name', $_POST['name'], 'You must enter a name.' );
	$author = $edit->add_new( 1, 'author', $_POST['author'], 'You must enter an author.' );
	$type = $edit->add_new( 1, 'type', $_POST['type'], 'You must enter a type.' );
	$text = $edit->add_new( 1, 'text', $_POST['text'], 'You must enter some content.' );
	$difficulty = $edit->add_new( 1, 'difficulty', $_POST['difficulty'], 'You must enter a difficulty rating (1-5).' );
	$length = $edit->add_new( 1, 'length', $_POST['length'], 'You must enter a length rating (1-5).' );
	$reward = $edit->add_new( 1, 'reward', $_POST['reward'], 'You must enter the XP/QP rewards.' );
	$hdimg = $edit->add_new( 1, 'hdimg', isset($_POST['hdimg']) ? 1 : 0, '', false );
	
	$execution = $edit->run_all( true, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
		rpostcontent();
	}
	else {
		$ses->record_act( 'Quest Guides', 'New', $name, $ip );
		echo '<p align="center">New entry was successfully added into OSRS RuneScape Help Quest Guide Area. No Cache has been performed.</p>' . NL;
		header( 'refresh: 2; url=?cat=' . $category );
	}
}

		
elseif( isset( $_GET['act'] ) AND ( ( $_GET['act'] == 'edit' AND isset( $_GET['id'] ) ) OR $_GET['act'] == 'new' ) ) {

	if( $_GET['act'] == 'edit' ) {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM quests WHERE id =" . $id );
	
		if( $info ) {
			$name = $info['name'];
			$author = $info['author'];
			$type = $info['type'];
			$text = $info['text'];
			$difficulty = $info['difficulty'];
			$length = $info['length'];
			$reward = $info['reward'];
			$hdimg = $info['hdimg'];
			
		}
		else {
			$_GET['act'] = 'new';
			$name = '';
			$author = '';
			$type = '';
			$text = '';
			$difficulty = 1;
			$length = 1;
			$reward = 'QP|';
			$hdimg = 0;
		}
	}
	else {
		$name = '';
		$author = '';
		$type = '';
		$text = '';
		$difficulty = 1;
		$length = 1;
		$reward = 'QP|';
		$hdimg = 0;
	}
	
	
	
	echo '<form method="post" action="?cat=' . $category . '">' . NL;
	echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />';
	
	$selhdimg = $info['hdimg'] == 1 ? ' checked="checked"' : '';
	
	if( $_GET['act'] == 'edit' ) {
		enum_correct( $category, $id );
		echo '<input type="hidden" name="id" value="' . $id . '" />';
	  $seltyp = $info['type'] == 1 ? ' checked="checked"' : '';
	}
	echo '<input type="hidden" name="type" value="' . $category . '" />';
	echo '<table width="90%" align="center" style="border-left: 1px solid #000000" cellspacing="0">' . NL;
	echo '<tr>' . NL;
	echo '<td class="tabletop" colspan="2">General</td>' . NL;
	echo '</td>' . NL;
	echo '<tr><td class="tablebottom" width="50%">Name:</td><td class="tablebottom"><input type="text" name="name" value="' . $name . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Original Author:</td><td class="tablebottom"><input type="text" name="author" value="' . $author . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Members?</td><td class="tablebottom"><input type="checkbox" name="type" value="1"'.$seltyp.' /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Difficulty:</td><td class="tablebottom"><input type="text" name="difficulty" value="' . $difficulty . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Length:</td><td class="tablebottom"><input type="text" name="length" value="' . $length . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom">Reward:<br />Skill Names ONLY. It\'s the first three letters. E.G. Fir, Smi, Hit, Con, Fis. Follow this by a vertical bar | and the XP (<strong>no commas!</strong>). E.G. Fir|2000. QP MUST be first: QP|#<br />Then for every skill, hit enter once for a new line.</td><td class="tablebottom"><textarea rows="5" name="reward" width="100%">' . htmlentities( $reward ) . '</textarea></td></tr>' . NL;	
	echo '<tr><td class="tablebottom">HD Images?:</td><td class="tablebottom"><input type="checkbox" name="hdimg"'.$selhdimg.' /></td></tr>' .NL;
	echo '<tr><td class="tabletop" colspan="2" style="border-top: none;">Content</td>' . NL;
	echo '<tr><td class="tablebottom" colspan="2"><input type="submit" value="Submit All" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom" colspan="2"><textarea rows="15" name="text" style="width: 99%;">' . htmlentities( $text ) . '</textarea></td></tr>' . NL;
	echo '</table><br />' . NL;
	echo '</form><br />' . NL;
	}
	
	elseif( isset( $_GET['act'] ) AND $_GET['act'] == 'delete' AND $ses->permit( 15 ) ) {
	if( isset( $_POST['del_id'] ) ) {
		$edit->add_delete( $_POST['del_id'] );
		$execution = $edit->run_all();
		
		if( !$execution ) {
			echo '<p align="center">' . $edit->error_mess . '</p>';
		}
		else {
			$ses->record_act( 'Quest Guides', 'Delete', $_POST['del_name'], $ip );
			header( 'refresh: 2; url=?cat=' . $category );
			echo '<p align="center">Entry successfully deleted from OSRS RuneScape Help.</p>' . NL;
		}
	}
	else {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM quests WHERE id = " . $id );
	
		if( $info ) {
		
			$name = $info['name'];
			echo '<p align="center">Are you sure you want to delete this test, \'' . $name . '\'?</p>';
			echo '<form method="post" action="?act=delete&cat=' . $category . '"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>' . NL;
			echo '<form method="post" action="?cat=' . $category . '"><center><input type="submit" value="No" /></center></form>' . NL;
		}
		else {
			
			echo '<p align="center">That id number does not exist.</p>' . NL;
		}
	}
}

else {

	$quack = "SELECT * FROM quests ORDER BY `name`" ;
	$query = $db->query( $quack);

	?>
	<table style="border-left: 1px solid #000;" width="100%" cellpadding="1" cellspacing="0">
	<tr>
	<th class="tabletop">Name:</th>
	<th class="tabletop">Actions:</th>
	<th class="tabletop">Last Edited (GMT):</th>
	</tr>
	<?php

	while($info = $db->fetch_array( $query ) ) {
	
	$complete = $info['hdimg'] == 1 ? ' id="complete"' : '';
	
    echo '<tr align="center">' . NL;
		echo '<td class="tablebottom"'.$complete.'><a href="/quests.php?id=' . $info['id'] . '" target="_new">' . $info['name'] . '</a></td>' . NL;
		echo '<td class="tablebottom"'.$complete.'><a href="?act=edit&cat=' . $category . '&id=' . $info['id'] . '" title="Edit '.$info['name'].'">Edit</a>';
		if( $ses->permit( 15 ) ) {
			echo ' / <a href="?act=delete&cat=' . $category . '&id=' . $info['id'] . '" title="Delete \'' . $info['name'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td class="tablebottom"'.$complete.'>' . format_time( $info['time'] ) . '</td>' . NL;
		echo '</tr>' . NL;
	}
	if( $db->num_rows( $quack ) == 0 ) {
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="3">Sorry, no entries match your search criteria.</td>' . NL;
		echo '</tr>' . NL;
	}
	
	?>
	</table><br />
<?php
}
echo '</div>'. NL;
end_page($name);
?>