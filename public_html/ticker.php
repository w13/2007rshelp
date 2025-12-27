<?php
require( dirname(__FILE__) . '/' . 'backend.php' );
// Connect to DB
$db->connect();
$db->select_db( MYSQL_DB );

$outfromdb = '';

// Check if APCu is available (apc_* functions are usually APCu in modern PHP)
// If not available, we might want to fallback or just skip caching.
// But wait, the original code used apc_exists.
// Let's assume apc_* functions are available or we can use a polyfill if needed.
// For now, let's keep the logic but use $db.

if (function_exists('apcu_exists') && apcu_exists('osrshelpticker')) {
    $outfromdb = apcu_fetch('osrshelpticker');
} elseif (function_exists('apc_exists') && apc_exists('osrshelpticker')) {
    $outfromdb = apc_fetch('osrshelpticker');
} else {
    $query = $db->query("SELECT * FROM `ticker` WHERE NOW() BETWEEN starttime AND endtime ORDER BY priority DESC, starttime DESC LIMIT 15");
    $num=-1;
    while($info = $db->fetch_array($query)) {
        $num++;
        $outfromdb .= 'arrNewsItems[' . $num . '] = new Array("' . htmlentities($info['content']) . '","' . htmlentities($info['url']) . '"); ';
    }
    if (function_exists('apcu_store')) {
        apcu_store('osrshelpticker', $outfromdb);
    } elseif (function_exists('apc_store')) {
        apc_store('osrshelpticker', $outfromdb);
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>OSRS RuneScape Help Ticker</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link href="/css/ticker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
var arrNewsItems = new Array();
<?php
echo $outfromdb;
?>
var intTickSpeed = 5000;
var intTickPos = 0;
var intCursorPosition = 0;
var tickLocked = false;
var autoTimerID = 0;
var intMaxCursorPosition;

function initButtons() {
  var kids = document.getElementsByTagName('img');
  for (var i=0; i < kids.length; i++) {
    kids[i].onclick = buttonClick;
    kids[i].onmousedown = buttonDown;
    kids[i].onmouseup = buttonUp;
    kids[i].oncontextmenu = buttonMenu;
  }
  document.getElementById("ztick").onmouseover = stopTicker;
  document.getElementById("ztick").onmouseout = resumeTicker;
  setArticle(0);
  playTicker();
}

function buttonMenu(e) {
	return false;
}
function buttonDown(e) {
	if (!e) var e = window.event;
	if ((tickLocked == false) && (e.button != 2)) {
		document.getElementById(this.id).style.cssText = "margin: 2px 0px 0px 2px;";
	}
}
function buttonUp(e) {
	if (!e) var e = window.event;
	if ((tickLocked == false) && (e.button != 2)) {
		document.getElementById(this.id).style.cssText = "";
	}
}
function buttonClick(e) {
  delayTicker();
  if (this.id == "back") {
    prevArticle();
  } else if (this.id == "next") {
    nextArticle();
  }
}
function prevArticle() {
  if (tickLocked == false) {
	  if (intTickPos == 0) {
	    intTickPos = arrNewsItems.length-1;
	  } else {
	    intTickPos = intTickPos - 1;
		}
		setArticle(intTickPos);
	}
}
function nextArticle() {
	if (tickLocked == false) {
	  if (intTickPos == arrNewsItems.length-1) {
	    intTickPos = 0;
	  } else {
	    intTickPos++;
		}
		setArticle(intTickPos);
	}
}
function setArticle(intPos) {
  tickLocked = true;
  intCursorPosition = document.getElementById("ztick").offsetLeft;
  setCursorPosition(intCursorPosition);
  strResults = '';
  strResults += '<b><a href="' + arrNewsItems[intPos][1] + '" target="_blank">';
  strResults += arrNewsItems[intPos][0] + '</a></b>';
  document.getElementById("ztick").innerHTML = strResults;
  intMaxCursorPosition = document.getElementById("ztick").offsetLeft + document.getElementById("ztick").offsetWidth;
  tickLocked = false;
}
function setCursorPosition(intCursorPosition) {
	document.getElementById("zcursor").style.cssText = "left: " + intCursorPosition + "px;";
}
function playTicker() {
  if (autoTimerID != 0) {
  	nextArticle();
  }
  autoTimerID = self.setTimeout("playTicker()", intTickSpeed);
}
function stopTicker() {
  clearTimeout(autoTimerID);
}
function resumeTicker() {
  clearTimeout(autoTimerID);
  autoTimerID = self.setTimeout("playTicker()", intTickSpeed);
}
function delayTicker() {
  clearTimeout(autoTimerID);
  autoTimerID = self.setTimeout("playTicker()", intTickSpeed * 2);
}
-->
</script>
</head>
<body onload="initButtons();">
<div class="zticker">
<span class="ticktitle">LATEST NEWS:</span>
<img class="tickdir" id="back" src="/img/news/tick_back.gif" alt="" />
<img class="tickdir" id="next" src="/img/news/tick_next.gif" alt="" />
<span id="ztick" class="tickContent"></span>
<div id="zcursor"></div>
</div>
<form name="ezform" id="ezform" action="/index.php" style="display:none;"><input type="hidden" name="statuscache" /></form>
</body>
</html>