<?php
require( 'backend.php' );
start_page( 21, 'External Guides' );

echo '<div class="boxtop">External Guides</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">';
echo '<p align="center">' . NL;
echo '<a href="' . $_SERVER['PHP_SELF'] . '?guide=1"><img src="/img/community/radio/banner.png" alt="Zybez Radio" border="0" /></a>&nbsp;&nbsp;' . NL;
echo '</p>' . NL;
echo '</div>' . NL;

if( isset( $_GET['guide'] ) ) {

	switch( $_GET['guide'] ) {
		case 1:
			$title = 'Zybez Radio';
			$file = '/radio/DJs.txt';
			$guide = 1;
			break;
	}
	
	$file = ROOT . '/' . $file;
	$content = '';
	
	echo '<div class="boxtop">' . $title . '</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px; text-align: center;">' . NL;
	
	if( isset( $_POST['content'] ) ) {
		$content = stripslashes( $_POST['content'] );
		
		$handle = fopen( $file, 'a' );
		$erase = ftruncate ( $handle, 0 );
		$write = fwrite( $handle, $content );
		$close = fclose( $handle );
		
		if( $handle AND $erase AND $write AND $close ) {
			$ses->record_act( 'External Guides', 'Edit', $title, $ip );
			header( 'refresh: 2; url=' . $_SERVER['PHP_SELF'] );
			echo '<p align="center">The \'' . $title . '\' guide has been updated. Please wait while you are being transfered...</p>' . NL;
		}
		else {
			echo '<p align="center">Fatal Error. File was not accessable.</p>' . NL;
		}
	}
	elseif( file_exists( $file ) ) {
		$content = file_get_contents( $file );
	
		$last = filemtime( $file );
		$last = format_time( $last + 21600 );
		
		enum_correct( 'external', $guide );	
		
		echo '<form action="' . $_SERVER['PHP_SELF'] . '?guide=' . $guide . '" method="post">' . NL;
		echo 'Last Update: ' . $last . ' (GMT)<br />';
		echo '<textarea name="content" rows="20" style="width: 95%;">' . htmlentities( $content ) . '</textarea><br />' . NL;
		echo '<input type="submit" value="Update \'' . $title . '\'" />&nbsp;<input type="reset" value="Undo Changes" />' . NL;
		echo '</form>' . NL;
	}
	echo '</div>' . NL;
}

end_page();
?>