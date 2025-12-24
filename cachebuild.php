<html>
<head>
<title>Zybez Cache Control Panel - v.2.0.1</title>
<META NAME="ROBOTS" CONTENT="NOARCHIVE">
<style type="text/css">
body {font:10px Trebuchet MS, Verdana, sans-serif;margin:0;padding:0;}
table {font:10pt Trebuchet MS, Verdana, sans-serif;}
td {overflow:hidden;}
td a {text-decoration:none;}
tr.highlight	{background:#E2E2E2;}
.bar {background-color:#C2E9AE;padding-right:3px;margin-bottom:10px;border-bottom:6px solid #54C81C;font-size:22px;text-align:right;}
</style>
</head>
<body>

<?php

/* Path to Root */
$ROOT = dirname(__FILE__);
define( 'SYSROOT' , $ROOT );

/* security: check for cookie */
if (! isset($_COOKIE['cachebuild']) || $_COOKIE['cachebuild']!='Salazar Slitherin'){
  if($_POST['password']=='disengage'){
    setcookie("cachebuild", "Salazar Slitherin", time()+9600000);
  }elseif(! isset($_POST['password'])){
    echo '<h3 style="color:#4A7B7C">ZYBEZ CACHE SYSTEM</h3>
    <form action="'.$_SERVER['SCRIPT_NAME'].'" method="POST">
    Login Password: <input type="text" name="password"> <input type="submit" value="Login" />
    </form>
    ';
    die();
  }else{
    echo '<h3 style="color:#4A7B7C">ZYBEZ CACHE SYSTEM</h3>
    <b>Wrong password.</b> If you click back, this browser window will automatically close.<br />( '. $_SERVER['REMOTE_ADDR'] . ' recorded )';
    die();
  }
}

if(!isset($_GET['cacheframe']) AND !isset($_GET['recacheall']) AND !isset($_POST['beginrecache'])){

if(isset($_GET['submit']) || isset($_GET['submitto'])) {	die(); }
elseif(isset($_GET['removeit'])) { die(); }
elseif(isset($_GET['delall'])) {
	echo '<h1>!!!</h1>
	<h3>Are you sure you want to <b>delete</b> the entire cache?<br />This action is IRREVERSABLE!</h3><br />
	<h2>ARE YOU <i>REALLY</i> SURE YOU WANT TO CONTINUE?</h2>
	<form name="form" action="'.$_SERVER['SCRIPT_NAME'].'" method="POST">
	<input type="button" value="unlock:" onclick="document.form.delallyes.disabled=false; this.disabled=true;" /><input type="submit" name="delallyes" disabled="true" value="Yes, Delete The Entire Cache">
	</form>';
	die();
}
elseif(isset($_POST['delallyes'])){

function SureRemoveDir($dir, $DeleteMe) {
    if(!$dh = @opendir($dir)) return;
    while (false !== ($obj = readdir($dh))) {
        if($obj=='.' || $obj=='..') continue;
        if (!@unlink($dir.'/'.$obj)) SureRemoveDir($dir.'/'.$obj, true);
    }
    if ($DeleteMe){
        closedir($dh);
        @rmdir($dir);
    }
}
SureRemoveDir('md5cachetest', false); //empties folder

	echo 'ENTIRE CACHE DELETED.<br /><br /><a href="'.$_SERVER['SCRIPT_NAME'].'">Click here to continue</a>';
	die();
}

?>
<div class="bar">Zybez Cache Builder V2</div>
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
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      oldonload();
      func();
    }
  }
}
function addClass(element,value) {
  if (!element.className) {
    element.className = value;
  } else {
    newClassName = element.className;
    newClassName+= " ";
    newClassName+= value;
    element.className = newClassName;
  }
}
function highlightRows() {
  if(!document.getElementsByTagName) return false;
  var tbodies = document.getElementsByTagName("tbody");
  for (var j=0; j<tbodies.length; j++) {
		  var rows = tbodies[j].getElementsByTagName("tr");
		  for (var i=0; i<rows.length; i++) {
				rows[i].oldClassName = rows[i].className
				rows[i].onmouseover = function() {
				  addClass(this,"highlight");
				}
				rows[i].onmouseout = function() {
				  this.className = this.oldClassName
				}
		}
	}
}
addLoadEvent(highlightRows);
</script>
<?

function sectohms($inputval){
$hh = intval($inputval / 3600);
$ss_remaining = ($inputval - ($hh * 3600));
$mm = intval($ss_remaining / 60);
$ss = ($ss_remaining - ($mm * 60));

if($hh<10){ $hh = '0' . $hh; }
if($mm<10){ $mm = '0' . $mm; }
if($ss<10){ $ss = '0' . $ss; }

$out = $hh . ':' . $mm . ':' . $ss;
return $out;
}

mysql_select_db('helpdb', mysql_connect('localhost', 'zyhelp', '79g0ld42')) or die('Error: Unable to connect to database. ' . mysql_error());
$count = mysql_query("SELECT `id` FROM `cachedpages`");
$count = mysql_num_rows($count);

if(isset($_GET['filter'])) {
  $filter = $_GET['filter'];
  $whereq = "WHERE `url` LIKE '%" . htmlentities($filter) . "%' ";
} else {
  $filter = '';
  $whereq = 'WHERE 1=1';
}

if(isset($_GET['pricedata'])) {
  $pd = " AND url LIKE '%price-data%' ";
  $chkpd = 'checked="checked"';
} else {
  $pd = " AND url NOT LIKE '%price-data%' ";;
  $chkpd = '';
}

  if(isset($_GET['limit'])) $limit = intval($_GET['limit']);
  else $limit = 50;

  if(isset($_GET['failures'])) {
    $ignore = ' AND `date` < (UNIX_TIMESTAMP()-18000) '; //Check for any stragglers after a full re-cache
    $chkfa = 'checked="checked"';
    }
    else $ignore = ' ';
  
if(isset($_GET['allguides']) && $_GET['allguides'] == 'true') {
  
    $whereq = "WHERE (url LIKE '%skills.php%' OR url LIKE '%quests.php%' OR url LIKE '%cities.php%' OR url LIKE '%guilds.php%' OR url LIKE '%minigames.php%' OR url LIKE '%misc.php%' OR url LIKE '%genguides.php%' OR url LIKE '%priceguide.php%' OR url LIKE '%dungeonmaps.php%' OR url LIKE '%miningmaps.php%' OR url LIKE '%worldmaps.php%' OR url LIKE '%.php')"; // Full re-cache of guides and indexes, not dbs or price graphs (<1000 pages)
    $limit=2000;
    $chkag = 'checked="checked"';
  }

if(isset($_GET['speed']) && $_GET['speed'] == 'fast') { $speed = 800; $chksp = 'checked="checked"'; }
else $speed = 1200; // Just to make it go a bit faster...


if(isset($_GET['urllength']) && $_GET['urllength'] != ''){  // sorting by length of url?
  $chkln = 'checked="checked"';
  $result = mysql_query("SELECT * FROM `cachedpages` " . $whereq . $pd . $ignore . " ORDER BY `date` ASC LIMIT " . $limit);
}else{
  $result = mysql_query("SELECT * FROM `cachedpages` " . $whereq . $pd . $ignore . " ORDER BY LENGTH(`url`) ASC LIMIT " . $limit);
}
$time = time();

echo '
<div style="text-align:center;"><center>
<table style="text-align:center;width:98%;border: solid #000 3px;">
<tr style="font-size:11pt;">
<form action="'.$_SERVER['SCRIPT_NAME'].'" method="GET">
<th colspan="6" style="background-color:#E9F4E1; text-align:center;">
Search: <input type="text" name="filter" value="'.$filter.'" />
# Results: <input type="text" name="limit" value="'.$limit.'" /> <a href="#" onclick=hide(\'tohide\')>Advanced Options</a>
<div id="tohide" style="display:none;font-size:11px">
<table width="40%" border="0" align="center">
<tr>
<td>Sort by date:</td><td><input type="checkbox" name="urllength" value="1" ' . $chkln . ' /></td></tr>
<tr>
<td>Faster Cache (<acronym title="As opposed to 1200ms on normal cache speed">800ms</acronym>)</td><td><input type="checkbox" name="speed" value="fast" ' . $chksp . ' /> (only to be used at off-peak times)</td></tr>
<tr>
<td>Guides and Indexes Only</td><td><input type="checkbox" name="allguides" value="true" ' . $chkag . '  /> (does not do monsters/items)</td></tr>
<tr>
<td>After Full Cache, check any failures</td><td><input type="checkbox" name="failures" value="1" ' . $chkfa . ' /> (5hrs stale)</td></tr>
<tr>
<td>Include Price History Data</td><td><input type="checkbox" name="pricedata" value="1" ' . $chkpd . ' /> (like 2000 more to cache)</td></tr>
</table>
</div>
<input type="submit" value="Apply" /></th></form>
</tr>
<tr bgcolor="#CCCCCC">
<th width="70%">Cached Page</th>
<th width="5%">Cached File</th>
<th width="10%">Last (hh:mm:ss)</th>
<th width="5%">Delete Cache</th>
<th width="5%">Re-Cache</th>
</tr>
<tbody style="height:300px;overflow-y:scroll;overflow-x:hidden">';

$first = 1; //javascript has this strict law that you cant have stray comas - so we need an IF in the loop
$alltheurls = '';

while ($row = @mysql_fetch_assoc($result)) {
	$urlencoded = rawurlencode('http://www.zybez.net' . $row['url']);
	
     // lets take care of the mass cache-building javascript first... 
     if($first==1){
          $alltheurls .= '"http://www.zybez.net/getzybez.php?cachethis=' . $urlencoded . '"'; //first entry, no coma leading
          $first = 2;
        }else{
          $alltheurls .= ',"http://www.zybez.net/getzybez.php?cachethis=' . $urlencoded . '"'; //all other entries, comas leading
        }
        
	echo '<tr>
	<td><a href="' . $row['url'] . '">' . $row['url'] . '</a></td>
	<td><a href="/md5cache/' . $row['crc'] . '.html" target="_blank">[C]</a></td>
	<td title="' . date('M-d',$row['date']) . '">' . sectohms($time-$row['date']) . '</td>
	<td><a target="fakeframe" href="/getzybez.php?delthis=' . $urlencoded . '" style="text-decoration:none; color:red; font-size:large;"><b>&#215;</b></a></td>
	<td><a target="fakeframe" href="/getzybez.php?cachethis=' . $urlencoded . '"><img src="/tiko/toolkit/skins/def-lite/imgs/rload.gif" border="0" /></a></td>
	</tr>';
}
$returnedrows = mysql_num_rows($result);
echo '</tbody><tr><td colspan="6" style="background-color:black; color:white"><b>' . $returnedrows . ' entries returned</b> / ' . $count . ' total in database</td></tr>
<tr>
<form action="getzybez.php" target="fakeframe">
<td colspan="6" style="background-color:#B2EDAC; vertical-align:middle; height:1em;">
<input type="text" size="65" name="cachethis" style="border:1px black solid; background-color:#ECE7F6;" value="http://www.zybez.net/" /> OR Index <input type="checkbox" name="cacheindex" value="yes"  />
<input type="submit" style="background-image:url(\'http://www.zybez.net/tiko/toolkit/skins/def-lite/imgs/rload.gif\'); background-repeat: no-repeat;background-position: 0% 50%; background-color:white; text-align:right" value="   Add/Update" onclick="document.all.cachethis.value=\'http://www.zybez.net/\';" />
 <input type="button" value="unlock:" name="unlockbutton" onclick="document.all.updateallbutton.disabled=false; this.style.display=\'none\';" />
 <input disabled="true" name="updateallbutton" type="button" style="background-image:url(\'http://www.zybez.net/tiko/toolkit/skins/def-lite/imgs/rload.gif\'); background-repeat: no-repeat;background-position: 0% 50%; background-color:white; text-align:right" value="    Update all above" onclick="startcache()" /> 
 <input type="button" name="stopbutton" value="PAUSE MASS CACHING" onclick="stopcache()" style="color:red;font-weight:bold;display:none" />
</td>
</form>
</tr>
</table>
<div id="displayprogress" style="overflow:hidden; width:100%;"><b title="Mass Cache Engine Sleeping">-_-</b></div>';

?>
<script type="text/javascript">
              var i=0;
              
              var thebiglist = new Array(<?=$alltheurls?>);

var total= <?=$returnedrows?>;

function dothecache(){
if(i<total){
  document.getElementById("displayprogress").innerHTML =  "<b>" + parseInt(i/total*100) + "% done</b><br />" + thebiglist[i];
  fakeframe.location = thebiglist[i];
  i=i+1;
 }else{
  stopcache();
 }
}

function startcache(){
wooYayIntervalId = setInterval ( "dothecache()", <?=$speed?> );
  document.getElementById("displayprogress").innerHTML = "<b>o_o</b>";
  document.all.stopbutton.style.display = 'inline';
  document.all.updateallbutton.style.display = 'none';
}

function stopcache(){
  clearInterval ( wooYayIntervalId );
  document.getElementById("displayprogress").innerHTML = '<b title="Mass Cache Engine Sleeping">-_-</b>';
  document.all.stopbutton.style.display = 'none';
  document.all.updateallbutton.style.display = 'inline';
}
</script>

<!--<br /><input type="button" value="Delete Entire Cache" onclick="location=\''. $_SERVER['SCRIPT_NAME'] .'?delall=1\'" title="Dont even think about it... ">-->



</center>
</div>
<iframe name="fakeframe" style="width:100%; height: 2em; border:0px;  overflow:hidden; "></iframe>
<div style="position:absolute;top:5px;left:3px;">Server time now: <? echo date('M-d-Y H:i:s T',$time); ?></div>

<h2 style="padding-left:10px;"><a href="<?=$_SERVER['SCRIPT_NAME']?>?cacheframe">Launch ez-caching frame</a> <a href="<?=$_SERVER['SCRIPT_NAME']?>?cacheframe" target="_blank" title="new window or tab">&raquo;</a></h2>


<?

}
elseif(isset($_GET['cacheframe'])) {
echo '<br /><iframe name="ezframe" src="http://www.zybez.net" width="100%" height="450px"></iframe><br />
<form name="ezform" action="'.$_SERVER['SCRIPT_NAME'].'" target="fakeajax" method="GET">
<input type="hidden" name="cachethis" value="" />
<input type="hidden" name="delthis" value="" />
<input type="hidden" name="cacheremove" value="0" />
<input type="button" name="httpzybez" value="http://www.zybez.net" onclick="stickzybez()"><input type="text" name="url" size="60">
<input type="button" value="Go" onclick="javascript:gotourl();">
<input type="hidden" value="booty" name="submitto" />
[ <input type="button" value="Cache Above" onclick="javascript:subbutt();"  style="background-color:#CFFFCD;" > ] 
[ <input type="button" value="De-Cache Above" title="Remove from cache" onclick="javascript:decachebutt();"  style="background-color:pink;" > ] <br />
<input type="text" style="border:0; background-color:#DED4E1; font-weight:bold; text-align:center" name="statuscache" size="20" /> <input style="border:0;color:red" type="text" name="status" size="75" /> 
</form>

<iframe src="http://www.zybez.net/getzybez.php" name="fakeajax" style="width:100%; height: 75px; border:0;" /></iframe>
';

?>
<script>
function subbutt(){
document.ezform.url.value=ezframe.location.pathname + ezframe.location.search;
document.ezform.cachethis.value = 'http://www.zybez.net' + document.ezform.url.value;
document.ezform.action = 'http://www.zybez.net/getzybez.php';
document.ezform.delthis.value = '';
document.ezform.submit();
document.ezform.status.value = 'Now press GO to ensure page got cached properly (optional)';
}

function decachebutt(){
document.ezform.url.value=ezframe.location.pathname + ezframe.location.search;
document.ezform.cachethis.value = '';
document.ezform.delthis.value = 'http://www.zybez.net' + document.ezform.url.value;
document.ezform.action = 'http://www.zybez.net/getzybez.php';
document.ezform.submit();
document.ezform.status.value = 'Now press GO to ensure page got deleted from cache (optional)';
}

function gotourl(){
ezframe.location = document.ezform.url.value;
document.ezform.status.value = '';
}

function stickzybez(){
document.ezform.url.value = 'http://www.zybez.net' + document.ezform.url.value;
}
</script>

<? } ?>
</body>
</html>