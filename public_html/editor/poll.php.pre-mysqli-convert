<?php

require( 'backend.php' );
require( 'edit_class.php' );
start_page( 29, 'Poll Manager' );

$edit = new edit( 'poll_main', $db );
$edit_opt = new edit( 'poll_options', $db );

echo '<div class="boxtop">Poll Manager</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;

echo '<p>Something is wrong with this part of the editor. Need to fix it. :-S</p>';
/*
?>
<div style="float: right;"><a href="<?=$PHP_SELF?>"><img src="images/browse.gif" title="Browse" border="0" /></a>
<a href="<?=$PHP_SELF?>?act=new"><img src="images/new%20entry.gif" title="New Entry" border="0" /></a></div>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; Poll Manager</font></b>
</div>
<hr class="main" noshade="noshade" align="left" /><br />
<?


if( isset( $_POST['act'] ) AND $_POST['act'] == 'edit' AND isset( $_POST['id'] ) ) {

	$id = intval( $_POST['id'] );
	
	$question = $edit->add_update( $id, 'question', $_POST['question'], 'You must enter the poll question.', true );
	
	$execution = $edit->run_all( false, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		$ses->record_act( 'Polls', 'Edit', substr( $question, 0, 25 ) );
		echo '<p align="center">Entry successfully edited on Zybez.</p>' . NL;
		header( 'refresh: 2; url=' . $PHP_SELF );
	}
	
}
elseif( isset( $_POST['act'] ) AND $_POST['act'] == 'new' ) {

	$question = $edit->add_new( 1, 'question', $_POST['question'], 'You must enter the poll question.', true );
	
	$execution = $edit->run_all( false, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		$ses->record_act( 'Polls', 'New', substr( $question, 0, 25 )  );
		echo '<p align="center">New entry was successfully added to Zybez.</p>' . NL;
		header( 'refresh: 2; url=' . $PHP_SELF );
	}
	
}
elseif( isset( $_POST['act'] ) AND $_POST['act'] == 'edopt' AND isset( $_POST['opt_id'] ) ) {

	$opt_id = intval( $_POST['opt_id'] );

	$option = $edit_opt->add_update( $opt_id, 'option', $_POST['option'], 'You must enter a poll option.' );

	$execution = $edit_opt->run_all( false, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit_opt->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;-- Go Back</b></a></p>' . NL;
	}
	else {
		$ses->record_act( 'Poll Options', 'Edit', substr( $option, 0, 25 ) );
		echo '<p align="center">Entry successfully edited on Zybez.</p>' . NL;
		header( 'refresh: 1; url=' . $PHP_SELF . '?act=edit&id=' . $pollid );
	}
	
}
elseif( isset( $_POST['act'] ) AND $_POST['act'] == 'nwopt' ) {

	$option = $edit_opt->add_update( 1, 'option', $_POST['option'], 'You must enter a poll option.' );

	$execution = $edit_opt->run_all( false, true );
	
	if( !$execution ) {
		echo '<p align="center">' . $edit_opt->error_mess . '</p>' . NL;
		echo '<p align="center"><a href="javascript:history.go( -1 )"><b>&lt;- Go Back</b></a></p>' . NL;
	}
	else {
		$ses->record_act( 'Poll Options', 'New', substr( $option, 0, 25 ) );
		echo '<p align="center">New entry was successfully added to Zybez.</p>' . NL;
		header( 'refresh: 1; url=' . $PHP_SELF . '?act=edit&id=' . $pollid );
	}
	
}

elseif( isset( $_GET['act'] ) AND ( ( $_GET['act'] == 'edopt' AND isset( $_GET['opt_id'] ) ) OR $_GET['act'] == 'nwopt' ) AND isset( $_GET['pollid'] ) ) {

	$pollid = intval( $_GET['pollid'] );
	$info = $db->fetch_row( "SELECT question FROM poll_main WHERE id = " . $pollid );
	$question = $info['question'];
	
	if( $_GET['act'] == 'edopt' ) {
		$opt_id = intval( $_GET['opt_id'] );
		$opt = $db->fetch_row( "SELECT * FROM poll_options WHERE id = " . $opt_id );

		if( $opt AND $pollid == $opt['pollid'] ) {
			$opt_id = $opt['id'];
			$option = $opt['option'];
		}
		else {
			$_GET['act'] = 'nwopt';
			$option = '';
		}
	}
	else {
		$option = '';
	}

	if( $_GET['act'] == 'edopt' ) {
		echo '<p align="center">Editing \'' . $option . '\' in \'<a href="' . $PHP_SELF . '?act=edit&id=' . $pollid . '" title="Edit Store Window"><i>' . $question . '</i></a>\'.</p>';
	}
	else {
		echo '<p align="center">Adding a new option to \'<a href="' . $PHP_SELF . '?act=edit&id=' . $pollid . '" title="Edit Store Window"><i>' . $question . '</i></a>\'.</p>';
	}
	
	echo '<form method="post" action="' . $PHP_SELF . '">' . NL;
	echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />' . NL;
	
	if( $_GET['act'] == 'edopt' ) {
		echo '<input type="hidden" name="opt_id" value="' . $opt_id . '" />' . NL;
	}
	echo '<input type="hidden" name="pollid" value="' . $pollid . '" />' . NL;

	echo '<table width="90%" align="center" style="border-left: 1px solid #000000" cellspacing="0">' . NL;
	echo '<tr>' . NL;
	echo '<td class="tabletop" width="50%">Field</td>' . NL;
	echo '<td class="tabletop">Input</td>' . NL;
	echo '</td>' . NL;
	echo '<tr><td class="tablebottom">Option:</td><td class="tablebottom"><input type="text" size="30" name="option" value="' . $option . '" /></td></tr>' . NL;
	echo '<tr><td class="tablebottom" colspan="2"><input type="submit" value="Submit All" /></td></tr>' . NL;
	echo '</table>' . NL;
}
		
elseif( isset( $_GET['act'] ) AND ( ( $_GET['act'] == 'edit' AND isset( $_GET['id'] ) ) OR $_GET['act'] == 'new' ) ) {

	if( isset( $_POST['del_id'] ) AND $ses->permit( 31 ) ) {
		$edit_opt->add_delete( $_POST['del_id'] );
		$execution = $edit_opt->run_all( false, false );
		if( !$execution ) {
			echo '<p align="center">' . $edit_opt->error_mess . '</p>';
		}
		else {
			$ses->record_act( 'Poll Options', 'Delete', $_POST['del_name'] );
		}
	}
	$opts = array();
	
	if( $_GET['act'] == 'edit' ) {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM poll_main WHERE id = " . $id );
		$query = $db->query( "SELECT * FROM poll_options WHERE pollid = " . $id . " ORDER BY id ASC" );
		
		if( $info AND $query ) {

			$question = $info['question'];
			
			$num = 0;
			while( $opt = $db->fetch_array( $query ) ) {
				$opts[$num] = $opt;
				$num++;
			}
		}
		else {
			$_GET['act'] = 'new';
			$question = '';
		}
	}
	else {
		$question = '';
	}
	
	echo '<form method="post" action="' . $PHP_SELF . '">' . NL;
	echo '<input type="hidden" name="act" value="' . $_GET['act'] . '" />';
	
	if( $_GET['act'] == 'edit' ) {
		echo '<input type="hidden" name="id" value="' . $id . '" />';
	}
	
	echo '<table width="90%" align="center" style="border-left: 1px solid #000000" cellspacing="0">' . NL;
	echo '<tr><td class="tabletop" colspan="3">Question</td></tr>' . NL;
	echo '<tr><td class="tablebottom" colspan="3"><input type="text" size="65" name="question" value="' . $question . '" style="width: 75%; text-align: center;" /></td></tr>' . NL;
	
	if( $_GET['act'] == 'edit' ) {
		echo '<tr>' . NL;
		echo '<td class="tabletop" style="border-top: none;">Option:</td>' . NL;
		echo '<td class="tabletop" style="border-top: none;">Votes:</td>' . NL;
		echo '<td class="tabletop" style="border-top: none;">Action:</td>' . NL;
		echo '</tr>' . NL;

		foreach( $opts AS $opt ) {
			echo '<tr>' . NL;
			echo '<td class="tablebottom">' . $opt['option'] . '</td>' . NL;
			echo '<td class="tablebottom">' . $opt['votes'] . '</td>' . NL;

			echo '<td class="tablebottom">';
			echo '<a href="' . $PHP_SELF . '?act=edopt&opt_id=' . $opt['id'] . '&pollid=' . $id . '" title="Edit \'' . $opt['option'] . '\'">Edit</a>';

			if( $ses->permit( 31 ) ) {
				echo ' / <a href="' . $PHP_SELF . '?act=delopt&opt_id=' . $opt['id'] . '" title="Delete \'' . $opt['option'] . '\'">Delete</a>' . NL;
			}
			echo '</td>';

			echo '</tr>' . NL;
		}
	}
	
	echo '<tr><td class="tablebottom" colspan="3"><input type="submit" value="Submit Question" /></td></tr>' . NL;
	echo '</table>' . NL;
	echo '</form>' . NL;

	if( $_GET['act'] == 'edit' ) {
		echo '<center><a href="' . $PHP_SELF . '?act=nwopt&pollid=' . $id . '" title="Add New Option"><img src="images/new_item.gif" border="0"/></a></center>' . NL;
	}
	
}
elseif( isset( $_GET['act'] ) AND $_GET['act'] == 'delopt' AND isset( $_GET['opt_id'] ) AND $ses->permit( 31 ) ) {

	$opt_id = intval( $_GET['opt_id'] );
	$info = $db->fetch_row( "SELECT * FROM poll_options WHERE id = " . $opt_id );

	if( $info ) {
	
		$name = $info['option'];
		echo '<p align="center">Are you sure you want to delete the option, \'' . $name . '\'?</p>';
		echo '<form method="post" action="' . $PHP_SELF . '?act=edit&id=' . $info['pollid'] . '"><center><input type="hidden" name="del_id" value="' . $opt_id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>' . NL;
		echo '<form method="post" action="' . $PHP_SELF . '?act=edit&id=' . $info['pollid'] . '"><center><input type="submit" value="No" /></center></form>' . NL;
	}
	else {
		echo '<p align="center">That identification number does not exist.</p>' . NL;
	}
}
elseif( isset( $_GET['act'] ) AND $_GET['act'] == 'delete' AND $ses->permit( 31 ) ) {

	if( isset( $_POST['del_id'] ) ) {
		$edit->add_delete( $_POST['del_id'] );
		$execution = $edit->run_all();
		
		if( !$execution  ) {
			echo '<p align="center">' . $edit->error_mess . '</p>';
		}
		else {
			$db->query("DELETE FROM poll_options WHERE pollid = " . $_POST['del_id'] );
			$ses->record_act( 'Polls', 'Delete', $_POST['del_name'] );
			header( 'refresh: 2; url=' . $PHP_SELF );
			echo '<p align="center">Entry successfully deleted from Zybez.</p>' . NL;
		}
	}
	else {

		$id = intval( $_GET['id'] );
		$info = $db->fetch_row( "SELECT * FROM poll_main WHERE id = " . $id );
	
		if( $info ) {
		
			$name = $info['question'];
			echo '<p align="center">Are you sure you want to delete the poll, \'' . $name . '\'?</p>';
			echo '<form method="post" action="' . $PHP_SELF . '?act=delete"><center><input type="hidden" name="del_id" value="' . $id . '" / ><input type="hidden" name="del_name" value="' . $name . '" / ><input type="submit" value="Yes" /></center></form>' . NL;
			echo '<form method="post" action="' . $PHP_SELF . '"><center><input type="submit" value="No" /></center></form>' . NL;
		}
		else {
			
			echo '<p align="center">That identification number does not exist.</p>' . NL;
		}
	}
}
else {


	$query = $db->query( "SELECT * FROM poll_main ORDER BY `id` DESC" );

	echo '<center><form action="' . $PHP_SELF . '" method="get">' . NL;
	
	?>
	<table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="1" cellspacing="0">
	<tr class="boxtop">
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Question:</th>
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Actions:</th>
	<th style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Posted (GMT):</th>
	</tr>
	<?

	while($info = $db->fetch_array( $query ) ) {
	
		echo '<tr align="center">' . NL;
		echo '<td class="tablebottom">' . $info['question'] . '</td>' . NL;
		echo '<td class="tablebottom"><a href="' . $PHP_SELF . '?act=edit&id=' . $info['id'] . '" title="Edit ' . $info['question'] . '">Edit</a>';

		if( $ses->permit( 31 ) ) {
			echo ' / <a href="' . $PHP_SELF . '?act=delete&id=' . $info['id'] . '" title="Delete \'' . $info['question'] . '\'">Delete</a></td>' . NL;
		}
		echo '<td class="tablebottom">' . format_time( $info['time'] ) . '</td>' . NL;
		echo '</tr>' . NL;
	}
	if( mysql_num_rows( $query ) == 0 ) {
		echo '<tr>' . NL;
		echo '<td class="tablebottom" colspan="3">Sorry, no entries match your search criteria.</td>' . NL;
		echo '</tr>' . NL;
	}
	
	?>
	</table>
	<?

}
*/
echo '<br /></div>'. NL;

end_page();
?>