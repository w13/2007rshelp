<?php
echo '<div class="navigation">'.NL;


if($ses->permit(2) || $ses->permit(24) || $ses->permit(3)) {
	echo '<h3>Guides</h3>'.NL;
	echo '<ul>'.NL;
	if($ses->permit(2)) {
		echo '<li><a href="guide.php" title="Guide Manager"><img src="/images/banner/chart_bar.png" alt="" />Skills &amp; Guilds</a></li>'.NL;
		echo '<li><a href="quests.php" title="Quest Guide Manager"><img src="/images/banner/quest.png" alt="" />Quests</a></li>'.NL;
		echo '<li><a href="misc.php" title="Misc Guide Manager"><img src="/images/banner/book_open.png" alt="" />Miscellaneous</a></li>'.NL;
		echo '<li><a href="minigames.php" title="Mini Game Guide Manager"><img src="/images/banner/minigame.png" alt="" />Mini Games</a></li>'.NL;
		echo '<li><a href="cities.php" title="City Guide Manager"><img src="/images/banner/building.png" alt="" />Cities</a></li>'.NL;
	}
	if($ses->permit(3)) echo '<li><a href="map.php" title="Map Manager"><img src="/images/banner/map.png" alt="" />Maps</a></li>'.NL;
	echo '</ul>'.NL;
}


if($ses->permit(4) || $ses->permit(6) || $ses->permit(16) || $ses->permit(5) || $ses->permit(7) || $ses->permit(10) || $ses->permit(22) || $ses->permit(23)) {
	echo '<h3>Databases &amp; Tools</h3>'.NL;
	echo '<ul>'.NL;
	if($ses->permit(4)) echo '<li><a href="calc.php" title="Calculator Manager"><img src="/images/banner/calculator.png" alt="" />Calculators</a></li>'.NL;
	if($ses->permit(6)) echo '<li><a href="items.php" title="Item Database"><img src="/images/banner/wand.png" alt="" />Item Database</a> (<a href="items_disc.php">Notes</a>)</li>'.NL;
	if($ses->permit(16)) echo '<li><a href="monsters.php" title="Monster Database"><img src="/images/banner/bug.png" alt="" />Monster Database</a> (<a href="monsters_disc.php">Notes</a>)</li>'.NL;
	if($ses->permit(5)) echo '<li><a href="shop.php" title="Shop Database"><img src="/images/banner/basket.png" alt="" />Shop Database</a></li>'.NL;
	if($ses->permit(7)) echo '<li><a href="tomes.php" title="Tome Archive"><img src="/images/banner/book.png" alt="" />Tome Archive</a></li>'.NL;
	
	echo '</ul>'.NL;
}

/* deprecated. 23 April 2021 - W13.

if($ses->permit(8) OR $ses->permit(9) OR $ses->permit(12) OR $ses->permit(17) OR $ses->permit(20) OR $ses->permit(25) OR $ses->permit(26)) {
    echo '<h3>Interactive &amp; Features</h3>'.NL;
    echo '<ul>'.NL;
    if($ses->permit(20)) {
		echo '<li><a href="ticker.php" title="Ticker Manager"><img alt="" src="/images/banner/hourglass.png" />Ticker Manager</a></li>'.NL;
	}
	echo '</ul>';
}
*/


if($ses->permit(1)) {
	echo '<h3>Developer Tools</h3>'.NL;
	echo '<ul>'.NL;
	echo '<li><a href="testing_area.php" title="Test Area"><img src="/images/banner/folder_database.png" alt="" />Test Area</a></li>'.NL;
	echo '<li><a href="logs.php" title="Editor Logbook"><img src="/images/banner/table.png" alt="" />Editor Logbook</a> (<a href="actions.php">User Stats</a>)</li>'.NL;
    if($ses->permit(14)) echo '<li><a href="correction.php" title="Correction Listing [#CORRECTION#] Pending"><img src="/images/banner/tick.png" alt="" />Correction Listing</a> ([#CORRECTION#])</li>'.NL;
    echo '</ul>'.NL;
/*    echo '<h3>Developer Guides</h3>'.NL;
    echo '<ul>'.NL;
    echo '<li><a href="image_guide.php" title="Image Guide" target="_blank"><img src="/images/banner/picture.png" alt="" />Image Guide</a></li>'.NL;
    echo '<li><a href="html_guide.php" title="HTML Guide" target="_blank"><img src="/images/banner/html.png" alt="" />HTML Guide</a></li>'.NL;
    echo '<li><a href="database_management.php" title="Database Management" target="_blank"><img src="/images/banner/drive.png" alt="" />Database Management</a></li>'.NL;
	echo '<li><a href="guide_guide.php" title="Guide Creation" target="_blank"><img src="/images/banner/layout.png" alt="" />Guide Creation</a></li>'.NL;
    echo '</ul>'.NL;*/
}

/*if($ses->permit(19)){
	echo '<h3>Upload Images</h3>'.NL;
	echo '<ul>'.NL;
	echo '<li><a href="upload.php" title="Upload Images"><img src="/images/banner/arrow_up.png" alt="" />Main</a></li>'.NL;
	echo '<li><a href="upload.php?folder=monsters" title="Upload Images"><img src="/images/banner/bug.png" alt="" />Monsters</a></li>'.NL;
	echo '<li><a href="upload.php?folder=skills" title="Upload Images"><img src="/images/banner/chart_bar.png" alt="" />Skills</a></li>'.NL;
	echo '<li><a href="upload.php?folder=quests" title="Upload Images"><img src="/images/banner/quest.png" alt="" />Quests</a></li>'.NL;
	echo '<li><a href="upload.php?folder=misc" title="Upload Images"><img src="/images/banner/book_open.png" alt="" />Misc Guides</a></li>'.NL;
	echo '<li><a href="upload.php?folder=guilds" title="Upload Images"><img src="/images/banner/shield.png" alt="" />Guilds</a></li>'.NL;
	echo '</ul>';
}*/
    
if($ses->permit(11) OR $ses->permit(18) OR $ses->permit(21)) {
	echo '<h3>User Management</h3>'.NL;
	echo '<ul>'.NL;
	if($ses->permit(11)) {
		echo '<li><a href="accounts.php" title="Manage Accounts"><img src="/images/banner/user_edit.png" alt="" />Manage Accounts</a></li>'.NL; }
	if($ses->permit(18)) {
		echo '<li><a href="activitym.php" title="Monitor Activity"><img src="/images/banner/magnifier.png" alt="" />Monitor Activity</a></li>'.NL;
		echo '<li><a href="vip.php" title="VIP Message Board"><img src="/images/banner/lock.png" alt="" />VIP Message Board</a></li>'.NL;
    }
	echo '</ul>'.NL;
}
/*if($ses->permit(11) OR $ses->permit(18) OR $ses->permit(21) OR $ses->permit(1)) {
	echo '</div>'.NL;
}*/
echo '<h3>Currently Active (15min)</h3>';
echo '<ul><li><img src="/images/banner/group.png" alt="" />[#LASTACTIVE#]</li></ul></div>';
?>