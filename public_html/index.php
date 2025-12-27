<?php
require( 'backend.php' );
start_page();
?>

<!--
<div class="boxbottom">
<p><center><strong>Help us improve, <a href="http://forums.2007rshelp.com/topic/1634253-what-can-we-do-better/">What can we do better?</a></strong></center>
</p>
</div>
-->

<div class="boxtop"><strong>Old-School RuneScape Help</strong></div>
<div style="clear:both;"></div>
<div class="boxbottom">

<style>
	img.mainpagethumb{
		border:3px solid whitesmoke;
		box-shadow: 0 0 2px black;
		-webkit-filter: contrast(100%);
		-moz-filter: contrast(100%);
		-o-filter: contrast(100%);
		-ms-filter: contrast(100%);
	}
	img:hover.mainpagethumb{
		border: 3px solid whitesmoke;
		box-shadow: 0 0 20px black;
		left: -2px;
		top: -2px;
		position: relative;
		-webkit-filter: contrast(120%);
		-moz-filter: contrast(120%);
		-o-filter: contrast(120%);
		-ms-filter: contrast(120%);
	}
</style>

<table style="width:800px;margin-left:auto;margin-right:auto;text-align:center;margin-top:10px;margin-bottom:10px;">
<tr>
 <td><a href="skills.php"><img src="/img/index/skills.png" class="mainpagethumb" /></a></td>
 <td><a href="quests.php"><img src="/img/index/quests.png" class="mainpagethumb" /></a></td>
 <td><a href="misc.php?id=57"><img src="/img/index/clues.png" class="mainpagethumb" /></a></td>
 <td><a href="#"><img src="/img/index/discordindex.png" class="mainpagethumb" style="opacity:0.2;background:#000;" title="No longer available" /></a></td>
</tr>
<tr>
 <td><a href="items.php"><img src="/img/index/items.png" class="mainpagethumb" /></a></td>
 <td><a href="monsters.php"><img src="/img/index/npcs.png" class="mainpagethumb" /></a></td>
 <td><a href="calcs.php"><img src="/img/index/calcs.png" class="mainpagethumb" /></a></td>
 <td><a href="https://runescapecommunity.com"><img src="/img/index/forumsindex.png" class="mainpagethumb" /></a></td>
</tr>
</table>
</div>


<div class="boxbottom">
<p><center><strong>This website helps players of Old-School RuneScape.</strong>
<br />
If you're stuck or wish to share something. <a href="https://runescapecommunity.com">Ask somebody on our forums</a>.
</center>
</p>
</div>

<?php
end_page();
?>
