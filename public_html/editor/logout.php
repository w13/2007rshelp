<?php
require( 'backend.php' );
start_page(0, 'Logged Out' );

header( 'refresh: 1; url=index.php' );

echo '<div class="boxtop">Logged out</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;
	
$ses->logout();
echo '<p align="center">You have been logged out. Please wait while we transfer you...</p>' . NL;

echo '</div>' . NL;
	
end_page();
?>