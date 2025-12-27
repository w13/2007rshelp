<?php
// FOR IDB
$cleanArr = array(  array('id', $_GET['id'], 'int', 's' => '1,9999'),
					array('order', $_GET['order'], 'enum', 'e' => array('DESC', 'ASC'), 'd' => 'ASC' ),
					array('page', $_GET['page'], 'int', 's' => '1,400', 'd' => 1),
					array('awonly', $_GET['awonly'], 'int', 's' => '1,400'),
					array('category', $_GET['category'], 'enum', 'e' => array('name', 'member', 'trade', 'quest'), 'd' => 'name' ),
					array('search_area', $_GET['search_area'], 'enum', 'e' => array('name','quest','obtain','examine','notes','type') ),
					array('search_term', trim($_GET['search_term']), 'sql', 'l' => 40)
				  );
require('backend.php');
start_page('Item Comparator');

require_once("compare_functions.php"); //HOLDS ALL THE FUNCTIONS


if($disp->errlevel > 0) {
	$id = null;
	unset($search_area);
}
//END OF STUFF FOR IDB



//DON'T EVER EDIT THESE THREE VARIABLES!!!!
$compMax = 5;
$compMax = (($compMax < 2) ? (2) : ($compMax));
$ordinals = array (
		"First", "Second", "Third", "Fourth", "Fifth",
		"Sixth", "Seventh", "Eighth", "Ninth", "Tenth",
		"Eleventh", "Twelfth", "Thirteenth", "Fourteenth", "Fifteenth",
		"Sixteenth", "Seventeenth", "Eighteenth", "Nineteenth", "Twentieth",
		"Twenty-first", "Twenty-second", "Twenty-third", "Twenty-fourth", "Twenty-fifth"
	);
?>
<script type="text/javascript" src="compare.js"></script>
<style>
div.item-box {float: left;overflow: hidden;margin-right: 1em;}
.negative {color: #f00;}
.neutral {color: #ff8000;}
.positive {color: #339900;}

.boxed {width:15%;}
.tablebottom {vertical-align:middle;}

.noshow {display:none;}
.tableshow {display:table-row;}
.divshow {display:block;}
</style>

<div class="boxtop">Item Comparator</div>
<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
The Item Comparator is a Runescape tool that will enable you to see the pros and cons of any 2-5 items you wish!  You first select your "Primary item," then select 1-4 other items to compare to the Primary item.<br /><br />
<strong>&raquo;</strong> No more math! The differences of every item are right before your eyes.<br />
<strong>&raquo;</strong> In-depth break down of any item.<br />
<strong>&raquo;</strong> Easily make informed decisions on which items better suit <strong>your</strong> needs, rather than just going with the general consensus.<br />
<strong>&raquo;</strong> Add items to compare right from our own <a href="items.php" title="OSRS RuneScape Help's Item Database">Item Database</a>.  Using the Comparator is fast and simple!
<p>You may visit the <a href="items.php" title="OSRS RuneScape Help's Item Database" target="_blank">Item Database</a> to find items you wish to compare now or search the <a href="items.php" title="OSRS RuneScape Help's Item Database" target="_blank">Item Database</a> using the form below.  Once you have started adding items, they will appear on a queue below this search.</p>
<?php

## ITEM DATABASE INSERT TO ALLOW FOR EASY SEARCHING 
if ($search_term != '' && $search_area != '') {
	include('search.inc.php');
	echo '<table width="96%" style="margin:0 2%;" cellspacing="0" cellpadding="5">'.NL
		.'<tr style="height:23px;font-size:13px;font-weight:bold;">'.NL
		.'<td style="vertical-align:middle;text-align:right;"><a href="/correction.php?area=items&amp;id=4296" target="_blank">Submit Missing Item</a></td>'.NL
		.'</tr>'.NL
		.'</table><br />'.NL;
  echo '<div style="width:95%;height:350px;overflow:auto;margin:0 2.5%;"><table style="margin:0 12%;border-left: 1px solid #000;" width="76%" cellpadding="1" cellspacing="0">';

  echo '<tr>';
  echo '<th class="tabletop" width="5%">Picture</th>';
  echo '<th class="tabletop">Name <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?order=ASC&amp;category=name&amp;page=' . $page . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Name, Ascending"><img src="/img/up.GIF" width="9" height="9" alt="Sort by: Name, Ascending" border="0" /></a> <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?order=DESC&amp;category=name&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Name, Descending"><img src="/img/down.GIF" width="9" height="9" alt="Sort by: Name, Descending" border="0" /></a></th>';
  
  echo '<th class="tabletop"><abbr title="Item Comparator Queue">Compare?</abbr></th>';
  
  echo '<th class="tabletop">Members <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?order=ASC&amp;category=member&amp;page=' . $page . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Members, Ascending"><img src="/img/up.GIF" width="9" height="9" alt="Sort by: Members, Ascending" border="0" /></a> <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?order=DESC&amp;category=member&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Members, Descending"><img src="/img/down.GIF" width="9" height="9" alt="Sort by: Members, Descending" border="0" /></a></th>';
  
  echo '<th class="tabletop">Tradable <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?order=ASC&amp;category=trade&amp;page=' . $page . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Tradable, Ascending"><img src="/img/up.GIF" width="9" height="9" alt="Sort by: Tradable, Ascending" border="0" /></a> <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?order=DESC&amp;category=trade&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Tradable, Descending"><img src="/img/down.GIF" width="9" height="9" alt="Sort by: Tradable, Descending" border="0" /></a></th>';
  
  echo '<th class="tabletop">Quest <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?order=ASC&amp;category=quest&amp;page=' . $page . '&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Quest, Ascending"><img src="/img/up.GIF" width="9" height="9" alt="Sort by: Quest, Ascending" border="0" /></a> <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?order=DESC&amp;category=quest&amp;search_area=' . $search_area . '&amp;search_term=' . $search_term . '" title="Sort by: Quest, Descending"><img src="/img/down.GIF" width="9" height="9" alt="Sort by: Quest, Descending" border="0" /></a></th>';
  echo '</tr>';


if(empty($id)) {

while($info = $db->fetch_array($query))   {
	$seotitle = strtolower(preg_replace("/[^A-Za-z0-9]/", "", $info['name'] ?? ''));

	$info['member'] = $info['member'] == 1 ? 'Yes' : 'No';
	$info['equip'] = $info['equip'] == 1 ? 'Yes' : 'No';
	$info['trade'] = $info['trade'] == 1 ? 'Yes' : 'No';
	
	$quest = strip_tags($info['quest']);
    if (strlen($quest) > 20) {
		$quest = substr($quest,0,20) . '...';
	}
	
	$addid = "'".$info["id"]."','".$info["image"]."','".str_replace("'","\'",$info["name"])."','".$info["member"]."','".$info["trade"]."','".str_replace("'","\'",$quest)."'";
	
	$addSnippet = "<a id=\"link".$info["id"]."\" onclick=\"javascript:queueadd(" . $addid . ");\"><img src=\"/images/addtoqueue.gif\" alt=\"Add to comparison queue\" title=\"Add to comparison queue\" id=\"img".$info["id"]."\" /></a>";
	$removeSnippet = "<a id=\"link".$info["id"]."\" onclick=\"queuedelete(" . $info["id"] . ",'true');\"><img src=\"/images/deletefromqueue.gif\" alt=\"Remove from comparison queue\" title=\"Remove from comparison queue\" id=\"img".$info["id"]."\" /></a>";
	if (isset ($_COOKIE["item_comp_queue"]) && preg_match ("/(\d+(\|?))+/", $_COOKIE["item_comp_queue"])) {
		$queue = explode ("|", $_COOKIE["item_comp_queue"]);
		if (in_array (strval ($info["id"]), $queue)) $queueimage = $removeSnippet;
		else $queueimage = $addSnippet;
	} else $queueimage = $addSnippet;
	
    echo '<tr>';
    echo '<td class="tablebottom"><a href="/items.php?id=' . $info['id'] . '&amp;runescape_' . $seotitle . '.htm"><img src="/img/idbimg/' . $info['image'] . '" alt="OSRS RuneScape Help\'s ' . htmlspecialchars($info['name'] ?? '') .' image" width="50" height="50" /></a></td>';
    echo '<td class="tablebottom"><a href="/items.php?id=' . $info['id'] . '&amp;runescape_' . $seotitle . '.htm">' . htmlspecialchars($info['name'] ?? '') . '</a></td>' . NL;
	echo '<td class="tablebottom">'.$queueimage.'</td>';
    echo '<td class="tablebottom">' . htmlspecialchars($info['member'] ?? '') . '</td>';
    echo '<td class="tablebottom">' . htmlspecialchars($info['trade'] ?? '') . '</td>';
    echo '<td class="tablebottom">' . htmlspecialchars($quest) . '</td>';
    echo '</tr>';
  
} 

  if($row_count == 0 or $page <= 0 or $page > $page_count)
   {
	   $quayre = "SELECT name, id FROM `items` WHERE soundex(name) = soundex('".$search_term."') LIMIT 0,1";
   $result = $db->query($quayre);

    echo '<tr>';
    echo '<td class="tablebottom" colspan="6">Sorry, no items match your search criteria.';
    if ($db->num_rows($quayre) > 0) {
   while($info = $db->fetch_array($result))   {
   if($info['id'] != 950) echo ' Perhaps you meant <a href="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'?search_area=name&amp;search_term='.$info['name'].'">'.$info['name'].'</a>?'; }
    }
    echo '</td></tr>';
   
        
  }
        
  }
  echo '</table><br /></div>';

  if($page_count > 1)
   {
    echo '<br /><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>';
    echo '<td align="left"><form action="'.htmlspecialchars($_SERVER['SCRIPT_NAME']) . '" method="get">Jump to page';
    echo ' <input type="text" name="page" size="3" maxlength="3" />';
    echo '<input type="hidden" name="order" value="' . $order . '" />';
    echo '<input type="hidden" name="category" value="' . $category . '" />';
    echo '<input type="hidden" name="search_area" value="' . $search_area . '" />';
    echo '<input type="hidden" name="search_term" value="' . $search_term . '" />';
    echo ' <input type="submit" value="Go" /></form></td>';
    echo '<td align="right">' . $page_links . '</td></tr>';
    echo '<tr><td colspan="2" align="right" width="140">Page ' . $page . ' of ' . $page_count . '</td></tr>';
    echo '</table>';
  }
  
} else {
	echo '<form method="get" action="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '" style="text-align:center;">
Search <select name="search_area"><option value="name">Name</option><option value="quest">Quest</option><option value="obtain">Obtained From</option><option value="examine">Examine</option><option value="notes">Notes</option></select> for
 <input type="text" name="search_term" value="" maxlength="40" /> 
 <input type="checkbox" name="awonly" /> Weapons & Armour Only? 
 <input type="submit" value="Go" /></form><br /><br />';
}
## END OF IDB INSERT
?>
</div>

<?php

//COMPARISON QUEUE STUFF FIRST (BUILDING ONTO SAME PAGE RATHER THAN HAVING 2 PAGES)
// Quick-find: qf_data_parsecookie
// Get and parse the cookie.
if (!isset($_COOKIE["item_comp_queue"])) setcookie("item_comp_queue","0|2170|1904|713", 2147483647);

$queue = ((isset($_COOKIE["item_comp_queue"]) && preg_match("/^(\\d+(\\|?))+$/", $_COOKIE["item_comp_queue"]))
		? (explode ("|", $_COOKIE["item_comp_queue"]))
		: (array ()));
		
if (count($queue) == 0) $queue = array(2170,1904,713);

if (count($queue) != 0) {
		// We output now because we can skip working if there are no
		// items queued. If we waited till the normal output part, we'd
		// do a lot more work than needed.
	
	$iidlist = addslashes(implode (", ", $queue));

	// Quick-find: qf_data_query
	// Get items from the DB.
	$quotery = "SELECT id, image, name, member, trade, quest FROM items WHERE id IN (" . $iidlist . ") ORDER BY name ASC;";
	$q = $db->query($quotery);
	
	$items = array ();

	// Quick-find: qf_data_fetch
	// Fetch data from the query.
	//$holder is so javascript can have the IDs/Names of items to reconfigure drop-downs when items are added/removed
	echo '<script type="text/javascript">';
	while (($data = $db->fetch_row($quotery)) !== false) {
		$item = array (
			"id"		=>	intval ($data["id"]),
			"name"		=>	htmlspecialchars ($data["name"], ENT_COMPAT, "UTF-8"),
			"image"		=>	"/img/idbimg/" . $data["image"],
			"p2p"		=>	(($data["member"] == 1) ? (true) : (false)),
			"trade"		=>	(($data["trade"] == 1) ? (true) : (false)),
			"quest"		=>	(($data["quest"] != "No" && $data["quest"] != "") ? ($data["quest"]) : (false))
		);
		$items[] = $item;
		//SO THAT ITEMS CAN BE REMOVED/READDED
		if ($item["p2p"]) $item["p2p"] = 'Yes';
		else $item["p2p"] = 'No';
		if ($item["trade"]) $item["trade"] = 'Yes';
		else $item["trade"] = 'No';
		echo 'rememberadds['.$item["id"].'] = new Array("'.$item["id"].'","'.$data["image"].'","'.$item["name"].'","'.$item["p2p"].'","'.$item["trade"].'","'.$item["quest"].'");'.NL;
		//SO THAT ITEMS CAN BE REMOVED/READDED
		$holder .= $item["id"].'|'.$item["name"].',';
	}

	echo 'var items_comp_queue = "'.substr($holder,0,strlen($holder)-1).'";'.NL
		.'</script>'.NL;
	
	echo '<div style="width:69%;float:left;"><div class="boxtop">Comparison Queue</div>'
		.'<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">'
		
		.'			<p>These are the items in your comparison queue. You can view their individual information pages by clicking the names, and you can remove them from the queue by clicking the icons in the "Remove" column. Alternatively, you can click the "(wipe)" link to clear your entire queue.  To add more items to the queue, visit the <a href="items.php" title="OSRS RuneScape Help\'s Item Database">Item Database</a>.</p>
			<table style="border-left:1px #000 solid;width:80%;margin:0 10%;" cellspacing="0" id="list_queue">
				<tr>
					<th class="tabletop" style="width:50px;">Picture</th>
					<th class="tabletop">Name</th>
					<th class="tabletop">Members</th>
					<th class="tabletop">Tradeable</th>
					<th class="tabletop">Quest</th>
					<th class="tabletop">Remove<br /><a onclick="javascript:queuewipe();" title="Clear the queue.">(wipe)</a></th>
				</tr>';
	
	//THIS GOES BELOW THE TITLE ROW SO THAT IT ISN'T DELETED WHEN THE QUEUE IS WIPED :C
	echo '<tr class="tableshow" id="noqueue"><td class="tablebottom" colspan="6" style="text-align:center;">There aren\'t any items on the queue.</td></tr>';
		
		
	foreach ($items as $item) {
		echo '<tr id="queue'.$item["id"].'">
					<td class="tablebottom"><img src="'.$item["image"].'" alt="OSRS RuneScape Help\'s picture of '.$item["name"].'" /></td>
					<td class="tablebottom"><a href="items.php?id='.$item["id"].'">'.$item["name"].'</a></td>
					<td class="tablebottom">'.boolf ($item["p2p"]).'</td>
					<td class="tablebottom">'.boolf ($item["trade"]).'</td>
					<td class="tablebottom">'.boolf ($item["quest"]).'</td>
					<td class="tablebottom"><a onclick="javascript:queuedelete('.$item["id"].');"><img src="/images/deletefromqueue.gif" alt="Remove from queue" title="Remove from queue" /></a></td>
				</tr>';
	}
	echo '</table><br /><br /></div></div>';
	
	//SO THAT IF THERE ARE ITEMS IN THE QUEUE, IT HIDES THE "NO ITEMS" ROW
	echo '<script>if (getCookie("item_comp_queue") != 0 && getCookie("item_comp_queue") != "" && getCookie("item_comp_queue") !== false) 
	document.getElementById("noqueue").className = "noshow";</script>';
	
	
	///END OF QUEUE
	
	echo '<div style="width:30%;float:right;"><div class="boxtop">Choose Your Comparison</div>'
		.'<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">';
	echo '<p>Select up to five items to compare from the boxes below. All items will be compared to the primary item only. See the table to the left for a quick overview of the items.</p>
			<form action="'.htmlspecialchars($_SERVER['SCRIPT_NAME']).'" method="get" name="myform">
						<strong>Primary</strong> item:<br />
						<select id="sel_1" name="item1">
							<option value="not-used">--NONE--</option>';
	foreach ($items as $idx => $item) {
		echo '<option id="sel_1_item_'.$item["id"].'" value="'.$item["id"].'"';
		if ($idx == 0) echo " selected=\"selected\""; 
		echo '>'.$item["name"].'</option>'.NL;
	}
	echo '</select><br style="clear:both;" /><br />';
	for ($i = 2; $i < $compMax + 1; $i++) {
		echo ((count ($ordinals) >= ($i - 1)) ? ($ordinals[$i - 2]) : (($i - 1) . "th"));
		echo ' complementary item:<br /><select id="sel_'.$i.'" name="item'.$i.'"';
		if (count ($items) < $i) { echo " disabled=\"disabled\""; } 
		echo '>'.NL.'<option value="not-used"';
		if (count ($items) < $i) { echo " selected=\"selected\""; }
		echo '>--NONE--</option>'.NL;
		foreach ($items as $idx => $item) {
			echo '<option id="sel_'.$i.'_item_'.$item["id"].'" value="'.$item["id"].'"';
			if ($idx + 1 == $i) { echo " selected=\"selected\""; } 
			echo '>'.$item["name"].'</option>'.NL;
		}
		echo '</select><br />'.NL;
	}
	
	echo '
						<br /><br />
						<img src="/images/compare_button.gif" style="display:block;margin:0 auto;" onclick="document.myform.submit();" />
			</form>
			<br />
			<br /></div></div>';
}

	// Quick-find: qf_qf
	/*
	 * Table of quick-find comment codes (search for these to
	 * find the code for whatever is listed).
	 * First field is the code, second field is the description :)
	 *	qf_qf			This quick-find table.
	 *	qf_conf			Configurable settings.
	 *	qf_func			Functions.
	 *	qf_stylesheet		The stylesheet to use.
	 *	qf_data_iids		Collecting of item IDs.
	 *	qf_data_query		The primary database query.
	 *	qf_data_fetch		Fetching the data from the DB.
	 *	qf_content			Building the content markup.
	 *	qf_i1_global		Left item: global info.
	 *	qf_i2_global		Right item: global info.
	 *	qf_i1_money		Left item: monetary info.
	 *	qf_i2_money		Right item: monetary info.
	 *	qf_i1_combat		Left item: combat stats.
	 *	qf_i2_combat		Right item: combat stats.
	 *	qf_i1_desc			Left item: descriptive info.
	 *	qf_i2_desc			Right item: descriptive info.
	 *	qf_output.			Outputting the data.
	 */


// Sets $dispoutput variable.  If something that would trigger the inability to produce output (primarily ID screw-ups), $dispoutput is set to false and the regular output will not show.
$dispoutput = true;

// Quick-find: qf_data_iids
// Deal with item IDs and stuff.
$iids = array ();
for ($i = 1; $i < $compMax + 1; $i++) {
	if (isset ($_GET["item" . strval ($i)]) && is_numeric ($_GET["item" . strval ($i)])) {
		$iids[] = strval (abs (intval ($_GET["item" . strval ($i)])));
	}
}

if (count ($iids) == 0) {
	$contenterror .= "Error: at least two items are needed for comparison.";
	$dispoutput = false;
} elseif (count ($iids) == 1) {
	header ("Location: items.php?id=" . $iids[0]);
}

if ($dispoutput === true) {
// This is for the SQL `IN' operator.
$iidlist = "(" . implode (", ", $iids) . ")";

// Quick-find: qf_data_query
// The moment we've all been waiting for: the primary query!
$quayro = "SELECT items.*, price_items.price_low, price_items.price_high FROM items LEFT OUTER JOIN price_items ON price_items.id=items.pid WHERE items.id IN " . $iidlist . " ORDER BY items.name ASC LIMIT " . $compMax;
$q = $db->query($quayro);

if ($db->num_rows($quayro) == 0) {
	$contenterror .= "One or more of the ids specified is not an item.";
	$dispoutput = false;
}
}

if ($dispoutput === true) {

$items = array ();

// Quick-find: qf_data_fetch
// Fetch usable data from the resource.
while (($data = $db->fetch_row ($quayro)) !== false) {
	$item = array (
		"id"		=>	intval ($data["id"]),
		"name"		=>	htmlspecialchars ($data["name"], ENT_COMPAT, "UTF-8"),
		"image"		=>	"/img/idbimg/" . $data["image"],
		"type"		=>	intval ($data["type"]),
		"p2p"		=>	(($data["member"] == 1) ? (true) : (false)),
		"trade"		=>	(($data["trade"] == 1) ? (true) : (false)),
		"equip"		=>	(($data["equip"] == 1) ? (true) : (false)),
		"weight"	=>	((floatval ($data["weight"]) != -21.000) ? (floatval ($data["weight"])) : (0.000)),
		"stack"		=>	(($data["stack"] == 1) ? (true) : (false)),
		"examine"	=>	$data["examine"],
		"quest"		=>	(($data["quest"] != "No" && $data["quest"] != "") ? ($data["quest"]) : (false)),
		"obtain"	=>	(($data["obtain"] != "") ? ($data["obtain"]) : ("?")),
		"alc-l"		=>	intval ($data["lowalch"]),
		"alc-h"		=>	intval ($data["highalch"]),
		"gen-sell"	=>	intval ($data["sellgen"]),
		"gen-buy"	=>	intval ($data["buygen"]),
		"mp-low"	=>	intval ($data["price_low"]),
		"mp-high"	=>	intval ($data["price_high"]),
		"keepdrop"	=>	$data["keepdrop"],
		"retrieve"	=>	$data["retrieve"],
		"questuse"	=>	$data["questuse"],
		// We omit att, def and otherb, because we'll
		// add them individually later.
		"notes"		=>	$data["notes"],
		"credits"	=>	$data["credits"],
		"time"		=>	date ("l F jS, Y", $data["time"]),
		"complete"	=>	(($data["complete"] == 1) ? (true) : (false))
	);

	$att = explode ("|", $data["att"]);
	while (count ($att) < 5) {
		array_unshift ($att, 0);
	}
	$item["a-stab"] = intval ($att[0]);
	$item["a-slash"] = intval ($att[1]);
	$item["a-crush"] = intval ($att[2]);
	$item["a-magic"] = intval ($att[3]);
	$item["a-range"] = intval ($att[4]);
	
	$def = explode ("|", $data["def"]);
	while (count ($def) < 5) {
		array_unshift ($def, 0);
	}
	$item["d-stab"] = intval ($def[0]);
	$item["d-slash"] = intval ($def[1]);
	$item["d-crush"] = intval ($def[2]);
	$item["d-magic"] = intval ($def[3]);
	$item["d-range"] = intval ($def[4]);
	
	$otherb = explode ("|", $data["otherb"]);
	while (count ($otherb) < 2) {
		array_unshift ($otherb, 0);
	}
	$item["strength"] = intval ($otherb[0]);
	$item["prayer"] = intval ($otherb[1]);

	// It's imperative that we know which item is the first one,
	// so we ascertain that that item has index 0 in the array.
	if ($item["id"] == intval ($iids[0])) {
		array_unshift ($items, $item);
	} else {
		$items[] = $item;
	}
}

if (count ($items) == 1) {
	header ("Location: items.php?id=" . $items[0]["id"]);
}

//To display the tab buttons
for ($i = 1; $i < count ($items); $i++) {
	if ($i == 1) echo '<div class="boxtop" id="tabs" style="clear:both;">Choose which comparison you wish to see</div><div class="boxbottom" style="text-align:center;font-weight:bold;padding-top:10px;padding-bottom:10px;vertical-align:middle;">';
	echo '<a href="#tabs" onclick="hide('.$i.')" title="Compare '.$items[0]["name"].' to '.$items[$i]["name"].'"><img src="'.$items[0]["image"].'" alt="'.$items[0]["name"].'" /> <img src="/images/compare.gif" alt="Compare" /> <img src="'.$items[$i]["image"].'" alt="'.$items[$i]["name"].'" /></a>';
	if ($i + 1 != count($items)) echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	else echo '</div>';
}


// Quick-find: qf_content
// This is where we get the good stuff.

for ($i = 1; $i < count ($items); $i++) {
	$uType1 = ($items[0]["type"] == 1 && $items[$i]["type"] == 1);

	echo '
				<div id="'.$i.'" class="';
	if ($i == 1) echo 'divshow';
	else echo 'noshow';
	echo '">
				<div class="boxtop"><strong>'.$items[0]["name"].' vs '.$items[$i]["name"].'</strong></div>
				<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
				<h2>Global information</h2>';

		// Quick-find: qf_i1_global
		// Global information for the left item.


	echo '
				<div style="float:left;width:46%;">
					<h3 style="text-align:center;"><a href="items.php?id=' . $items[0]["id"] . '" title="OSRS RuneScape Help\'s item details for ' . $items[0]["name"] . '">' . $items[0]["name"] . '</a></h3>
					<table cellspacing="0" style="border-left:1px solid #000;width:94%;float:left;">
						<tr>
							<th class="tablebottom" rowspan="8" style="width:25%;border-top:1px solid #000;"><img src="' . $items[0]["image"] . '" alt="OSRS RuneScape Help\'s picture of ' . $items[0]["name"] . '" style="margin:auto;display:block;" /></th>
							<th class="tabletop">What</th>
							<th class="tabletop">Value</th>
							<th class="tabletop">Difference</th>
							<th class="tabletop"><abbr title="Value as a percentage of ' . $items[$i]["name"] . '\'s">Percent</abbr></th>
						</tr>
						<tr>
							<th class="tablebottom">Members</th>
							<td colspan="3" class="tablebottom">' . negboolf ($items[0]["p2p"]) . '</td>
						</tr>
						<tr>
							<th class="tablebottom">Tradeable</th>
							<td colspan="3" class="tablebottom">' . posboolf ($items[0]["trade"]) . '</td>
						</tr>
						<tr>
							<th class="tablebottom">Equipable</th>
							<td colspan="3" class="tablebottom">' . posboolf ($items[0]["equip"]) . '</td>
						</tr>
						<tr>
							<th class="tablebottom">Stackable</th>
							<td colspan="3" class="tablebottom">' . posboolf ($items[0]["stack"]) . '</td>
						</tr>
						<tr>
							<th class="tablebottom">Weight</th>
							<td class="tablebottom">' . kgf ($items[0]["weight"]) . '</td>
							<td class="tablebottom">' . kgdifff ($items[0]["weight"], $items[$i]["weight"], false, true) . '</td>
							<td class="tablebottom">' . percentf ($items[0]["weight"], $items[$i]["weight"], true) . '</td>
						</tr>
						<tr>
							<th class="tablebottom">Quest</th>
							<td colspan="3" class="tablebottom">' . boolf ($items[0]["quest"]) . '</td>
						</tr>
						<tr>
							<th class="tablebottom">Examine</th>
							<td colspan="3" class="tablebottom">' . $items[0]["examine"] . '</td>
						</tr>
					</table>
				</div>';

		// Quick-find: qf_i2_global
		// Global information for the right item.


	echo '
				<div style="float:right;width:46%;">
					<h3 style="text-align:center;"><a href="items.php?id=' . $items[$i]["id"] . '" title="OSRS RuneScape Help\'s item details for ' . $items[$i]["name"] . '">' . $items[$i]["name"] . '</a></h3>
					<table cellspacing="0" style="border-left:1px solid #000;width:94%;float:right;">
						<tr>
							<th class="tablebottom" rowspan="8" style="width:25%;border-top:1px solid #000;"><img src="' . $items[$i]["image"] .'" alt="OSRS RuneScape Help\'s picture of ' . $items[$i]["name"] . '" style="margin:auto;display:block;" /></th>
							<th class="tabletop">What</th>
							<th class="tabletop">Value</th>
							<th class="tabletop">Difference</th>
							<th class="tabletop"><abbr title="Value as a percentage of ' . $items[0]["name"] . '\'s">Percent</abbr></th>
						</tr>
						<tr>
							<th class="tablebottom">Members</th>
							<td colspan="3" class="tablebottom">' . negboolf ($items[$i]["p2p"]) . '</td>
						</tr>
						<tr>
							<th class="tablebottom">Tradeable</th>
							<td colspan="3" class="tablebottom">' . posboolf ($items[$i]["trade"]) . '</td>
						</tr>
						<tr>
							<th class="tablebottom">Equipable</th>
							<td colspan="3" class="tablebottom">' . posboolf ($items[$i]["equip"]) . '</td>
						</tr>
						<tr>
							<th class="tablebottom">Stackable</th>
							<td colspan="3" class="tablebottom">' . posboolf ($items[$i]["stack"]) . '</td>
						</tr>
						<tr>
							<th class="tablebottom">Weight</th>
							<td class="tablebottom">' . kgf ($items[$i]["weight"]) . '</td>
							<td class="tablebottom">' . kgdifff ($items[$i]["weight"], $items[0]["weight"], false, true) . '</td>
							<td class="tablebottom">' . percentf ($items[$i]["weight"], $items[0]["weight"], true) . '</td>
						</tr>
						<tr>
							<th class="tablebottom">Quest</th>
							<td colspan="3" class="tablebottom">' . boolf ($items[$i]["quest"]) . '</td>
						</tr>
						<tr>
							<th class="tablebottom">Examine</th>
							<td colspan="3" class="tablebottom">' . $items[$i]["examine"] . '</td>
						</tr>
					</table>
				</div>
				<br style="clear:both;" />
				<h2><br />Monetary values</h2>';
		// Quick-find: qf_i1_money
		// Monetary information for the left item.

	echo '
				<div style="float:left;width:49%;">
					<h3 style="text-align:center;"><a href="items.php?id=' . $items[0]["id"] . '" title="OSRS RuneScape Help\'s item details for ' . $items[0]["name"] . '">' . $items[0]["name"] . '</a></h3>
					<table cellspacing="0" style="border-left:1px solid #000;width:94%;float:left;">
						<tr>
							<th class="tabletop">What</th>
							<th class="tabletop">Value</th>
							<th class="tabletop">Difference</th>
							<th class="tabletop"><abbr  title="Prices/values as percentages of ' . $items[$i]["name"] . '\'s">Percent</abbr></th>
						</tr>';

/*	if ($items[0]["trade"] || $items[$i]["trade"]) {
			// ^^^
			// If either of the items in this comparison
			// is tradeable, show the row. Otherwise, don't bother.

		if ($items[0]["trade"]) {
				// ^^^
				// Display the normal row if the current item
				// is tradeable.

			echo '
						<tr>
							<th class="tablebottom">Market price</th>
							<td  class="tablebottom">' . gpf ($items[0]["mp-low"]) . '<br />' . gpf ($items[0]["mp-high"]) . '</td>
							<td  class="tablebottom">' . gpdifff ($items[0]["mp-low"], $items[$i]["mp-low"], false, true) . '<br />' . gpdifff ($items[0]["mp-high"], $items[$i]["mp-high"], false, true) . '</td>
							<td  class="tablebottom">' . percentf ($items[0]["mp-low"], $items[$i]["mp-low"], true) . '<br />' . percentf ($items[0]["mp-high"], $items[$i]["mp-high"], true) . '</td>
						</tr>';

		} else {
				// ^^^
				// Or if the current item isn't tradeable,
				// show the "not applicable" row.

			echo '
						<tr>
							<th class="tablebottom">Market price</th>
							<td colspan="3" class="tablebottom" style="font-style:italic;">Not applicable<br />&nbsp;</td>
						</tr>';

		}
	} */

	echo '
						<tr>
							<th class="tablebottom">High Alchemy</th>
							<td class="tablebottom">' . gpf ($items[0]["alc-h"]) . '</td>
							<td class="tablebottom">' . gpdifff ($items[0]["alc-h"], $items[$i]["alc-h"]) . '</td>
							<td class="tablebottom">' . percentf ($items[0]["alc-h"], $items[$i]["alc-h"]) . '</td>
						</tr>
						<tr>
							<th class="tablebottom">Low Alchemy</th>
							<td class="tablebottom">' . gpf ($items[0]["alc-l"]) . '</td>
							<td class="tablebottom">' . gpdifff ($items[0]["alc-l"], $items[$i]["alc-l"]) . '</td>
							<td class="tablebottom">' . percentf ($items[0]["alc-l"], $items[$i]["alc-l"]) . '</td>
						</tr>';

	if ($items[0]["trade"] || $items[$i]["trade"]) {
			// ^^^
			// If either of the items in this comparison
			// is tradeable, show the row. Otherwise, don't bother.

		if ($items[0]["trade"]) {
				// ^^^
				// Display the normal rows if the current item
				// is tradeable.

			echo '
						<tr>
							<th class="tablebottom">Sell to gen. store</th>
							<td class="tablebottom">' . gpf ($items[0]["gen-sell"]) . '</td>
							<td class="tablebottom">' . gpdifff ($items[0]["gen-sell"], $items[$i]["gen-sell"]) . '</td>
							<td class="tablebottom">' . percentf ($items[0]["gen-sell"], $items[$i]["gen-sell"]) . '</td>
						</tr>
						<tr>
							<th class="tablebottom">Buy from gen. store</th>
							<td class="tablebottom">' . gpf ($items[0]["gen-buy"]) . '</td>
							<td class="tablebottom">' . gpdifff ($items[0]["gen-buy"], $items[$i]["gen-buy"], false, true) . '</td>
							<td class="tablebottom">' . percentf ($items[0]["gen-buy"], $items[$i]["gen-buy"], true) . '</td>
						</tr>';

		} else {
				// ^^^
				// Or if the current item isn't tradeable,
				// show the "not applicable" rows.

			echo '
						<tr>
							<th class="tablebottom">Sell to gen. store</th>
							<td colspan="3" class="tablebottom" style="font-style:italic;">Not applicable</td>
						</tr>
						<tr>
							<th class="tablebottom">Buy from gen. store</th>
							<td colspan="3" class="tablebottom" style="font-style:italic;">Not applicable</td>
						</tr>';

		}
	}

	echo '
					</table>
				</div>';

		// Quick-find: qf_i2_money
		// Monetary information for the right item.

	echo '
				<div style="float:right;width:49%;">
					<h3 style="text-align:center;"><a href="items.php?id=' . $items[$i]["id"] . '" title="OSRS RuneScape Help\'s item details for ' . $items[$i]["name"] . '">' . $items[$i]["name"] . '</a></h3>
					<table cellspacing="0" style="border-left:1px solid #000;width:94%;float:right;">
						<tr>
							<th class="tabletop">What</th>
							<th class="tabletop">Value</th>
							<th class="tabletop">Difference</th>
							<th class="tabletop"><abbr title="Prices/values as percentages of ' . $items[0]["name"] . '\'s">Percent</abbr></th>
						</tr>';

	/* if ($items[$i]["trade"] || $items[0]["trade"]) {
			// ^^^
			// If either of the items in this comparison
			// is tradeable, show the row. Otherwise, don't bother.

		if ($items[$i]["trade"]) {
				// ^^^
				// Display the normal row if the current item
				// is tradeable.

			echo '
						<tr>
							<th class="tablebottom">Market price</th>
							<td class="tablebottom">' . gpf ($items[$i]["mp-low"]) . '<br />' . gpf ($items[$i]["mp-high"]) . '</td>
							<td class="tablebottom">' . gpdifff ($items[$i]["mp-low"], $items[0]["mp-low"], false, true) . '<br />' . gpdifff ($items[$i]["mp-high"], $items[0]["mp-high"], false, true) . '</td>
							<td class="tablebottom">' . percentf ($items[$i]["mp-low"], $items[0]["mp-low"], true) . '<br />' . percentf ($items[$i]["mp-high"], $items[0]["mp-high"], true) . '</td>
						</tr>';

		} else {
				// ^^^
				// Or if the current item isn't tradeable,
				// show the "not applicable" row.

			echo '
						<tr>
							<th class="tablebottom">Market price</th>
							<td colspan="3" class="tablebottom" style="font-style:italic;">Not applicable</td>
						</tr>';

		}
	} */

	echo '
						<tr>
							<th class="tablebottom">High Alchemy</th>
							<td class="tablebottom">' . gpf ($items[$i]["alc-h"]) . '</td>
							<td class="tablebottom">' . gpdifff ($items[$i]["alc-h"], $items[0]["alc-h"]) . '</td>
							<td class="tablebottom">' . percentf ($items[$i]["alc-h"], $items[0]["alc-h"]) . '</td>
						</tr>
						<tr>
							<th class="tablebottom">Low Alchemy</th>
							<td class="tablebottom">' . gpf ($items[$i]["alc-l"]) . '</td>
							<td class="tablebottom">' . gpdifff ($items[$i]["alc-l"], $items[0]["alc-l"]) . '</td>
							<td class="tablebottom">' . percentf ($items[$i]["alc-l"], $items[0]["alc-l"]) . '</td>
						</tr>';

	if ($items[$i]["trade"] || $items[0]["trade"]) {
			// ^^^
			// If either of the items in this comparison
			// is tradeable, show the row. Otherwise, don't bother.

		if ($items[$i]["trade"]) {
				// ^^^
				// Display the normal rows if the current item
				// is tradeable.

			echo '
						<tr>
							<th class="tablebottom">Sell to gen. store</th>
							<td class="tablebottom">' . gpf ($items[$i]["gen-sell"]) . '</td>
							<td class="tablebottom">' . gpdifff ($items[$i]["gen-sell"], $items[0]["gen-sell"]) . '</td>
							<td class="tablebottom">' . percentf ($items[$i]["gen-sell"], $items[0]["gen-sell"]) . '</td>
						</tr>
						<tr>
							<th class="tablebottom">Buy from gen. store</th>
							<td class="tablebottom">' . gpf ($items[$i]["gen-buy"]) . '</td>
							<td class="tablebottom">' . gpdifff ($items[$i]["gen-buy"], $items[0]["gen-buy"], false, true) . '</td>
							<td class="tablebottom">' . percentf ($items[$i]["gen-buy"], $items[0]["gen-buy"], true) . '</td>
						</tr>';

		} else {
				// ^^^
				// Or if the current item isn't tradeable,
				// show the "not applicable" rows.

			echo '
						<tr>
							<th class="tablebottom">Sell to gen. store</th>
							<td colspan="3" class="tablebottom" style="font-style:italic;">Not applicable</td>
						</tr>
						<tr>
							<th class="tablebottom">Buy from gen. store</th>
							<td colspan="3" class="tablebottom" style="font-style:italic;">Not applicable</td>
						</tr>';

		}
	}

	echo '
					</table>
				</div>';

	if ($items[0]["type"] == 1 || $items[$i]["type"] == 1) {
			// If either item is a piece of armour or weaponry,
			// show the combat table. Otherwise, save some space
			// by, well, not showing it.

		echo '
				<br style="clear:both;" />
				<h2><br />Combat statistics</h2>';

			// Quick-find: qf_i1_combat
			// Combat statistics of the left item.

		echo '
				<div style="float:left;width:49%;">
					<h3 style="text-align:center;"><a href="items.php?id=' . $items[0]["id"] . '" title="OSRS RuneScape Help\'s item details for ' . $items[0]["name"] . '">' . $items[0]["name"] . '</a></h3>
					<table cellspacing="0" style="border-left:1px solid #000;width:94%;float:left;">
						<tr>
							<th class="tabletop"><abbr title="Statistic">Stat</abbr></th>
							<th class="tabletop"><abbr title="Attack">Att.</abbr></th>
							<th class="tabletop"><abbr title="Difference in attack bonuses">&Delta;Att.</abbr></th>
							<th class="tabletop"><abbr title="Attack bonus as a percentage of ' . $items[$i]["name"] . '\'s">Att. %</abbr></th>
							<th class="tabletop"><abbr title="Defence">Def.</abbr></th>
							<th class="tabletop"><abbr title="Difference in defence bonuses">&Delta;Def.</abbr></th>
							<th class="tabletop"><abbr title="Defence bonus as a percentage of ' . $items[$i]["name"] . '\'s">Def. &</abbr></th>
						</tr>';

		$stats = array (
			array ("stab", "Stab"),
			array ("slash", "Slash"),
			array ("crush", "Crush"),
			array ("magic", "Magic"),
			array ("range", "Ranged")
		);

		if ($items[0]["type"] == 1) {
				// ^^^
				// If the current item is a weapon or piece of
				// armour, show the normal rows.

			foreach ($stats as $stat) {

				echo '
						<tr>
							<th class="tablebottom">' . $stat[1] . '</th>
							<td class="tablebottom">' . difff ($items[0]["a-" . $stat[0]]) . '</td>
							<td class="tablebottom">' . difff ($items[0]["a-" . $stat[0]], $items[$i]["a-" . $stat[0]]) . '</td>
							<td class="tablebottom">' . percentf ($items[0]["a-" . $stat[0]], $items[$i]["a-" . $stat[0]]) . '</td>
							<td class="tablebottom">' . difff ($items[0]["d-" . $stat[0]]) . '</td>
							<td class="tablebottom">' . difff ($items[0]["d-" . $stat[0]], $items[$i]["d-" . $stat[0]]) . '</td>
							<td class="tablebottom">' . percentf ($items[0]["d-" . $stat[0]], $items[$i]["d-" . $stat[0]]) . '</td>
						</tr>';

			}
		} else {
				// ^^^
				// Or if it's not a combat item, show the
				// "not applicable" rows.

			foreach ($stats as $stat) {

				echo '
						<tr>
							<th class="tablebottom">' . $stat[1] . '</th>
							<td class="tablebottom" style="font-style:italic;">N/A</td>
							<td class="tablebottom" style="font-style:italic;">N/A</td>
							<td class="tablebottom" style="font-style:italic;">N/A</td>
							<td class="tablebottom" style="font-style:italic;">N/A</td>
							<td class="tablebottom" style="font-style:italic;">N/A</td>
							<td class="tablebottom" style="font-style:italic;">N/A</td>
						</tr>';

			}
		}

		echo '
						<tr>
							<th class="tabletop" style="border-top:0px;"><abbr title="Statistic">Stat</abbr></th>
							<th class="tabletop" style="border-top:0px;"><abbr title="Extra">Ex.</abbr></th>
							<th class="tabletop" style="border-top:0px;"><abbr title="Difference in extra bonuses">&Delta;Ex.</abbr></th>
							<th class="tabletop" style="border-top:0px;"><abbr title="Extra bonus as a percentage of ' . $items[$i]["name"] . '\'s">Ex. %</abbr></th>
							<th colspan="3">&nbsp;</th>
						</tr>';

		$stats = array (
			array ("strength", "Strength"),
			array ("prayer", "Prayer"),

		);

		if ($items[0]["type"] == 1) {
				// ^^^
				// If the current item is a weapon or piece of
				// armour, show the strength and prayer rows.

			foreach ($stats as $stat) {

				echo '
						<tr>
							<th class="tablebottom">' . $stat[1] . '</th>
							<td class="tablebottom">' . difff ($items[0][$stat[0]]) . '</td>
							<td class="tablebottom">' . difff ($items[0][$stat[0]], $items[$i][$stat[0]]) . '</td>
							<td class="tablebottom">' . percentf ($items[0][$stat[0]], $items[$i][$stat[0]]) . '</td>
						</tr>';

			}
		} else {
				// ^^^
				// Or if it is not a combat item, show the
				// "not applicable" rows.

				foreach ($stats as $stat) {

					echo '
						<tr>
							<th class="tablebottom">' . $stat[1] . '</th>
							<td class="tablebottom" style="font-style:italic;">N/A</td>
							<td class="tablebottom" style="font-style:italic;">N/A</td>
							<td class="tablebottom" style="font-style:italic;">N/A</td>
						</tr>';

				}
		}

		echo '
					</table>
				</div>';

			// Quick-find: qf_i2_combat
			// Combat statistics of the right item.

		echo '
				<div style="float:right;width:49%;">
					<h3 style="text-align:center;"><a href="items.php?id=' . $items[$i]["id"] . '" title="OSRS RuneScape Help\'s item details for ' . $items[$i]["name"] . '">' . $items[$i]["name"] . '</a></h3>
					<table cellspacing="0" style="border-left:1px solid #000;width:94%;float:right;">
						<tr>
							<th class="tabletop"><abbr title="Statistic">Stat</abbr></th>
							<th class="tabletop"><abbr title="Attack">Att.</abbr></th>
							<th class="tabletop"><abbr title="Difference in attack bonuses">&Delta;Att.</abbr></th>
							<th class="tabletop"><abbr title="Attack bonus as a percentage of ' . $items[0]["name"] . '\'s">Att. %</abbr></th>
							<th class="tabletop"><abbr title="Defence">Def.</abbr></th>
							<th class="tabletop"><abbr title="Difference in defence bonuses">&Delta;Def.</abbr></th>
							<th class="tabletop"><abbr title="Defence bonus as a percentage of ' . $items[0]["name"] . '\'s">Def. %</abbr></th>
						</tr>';

		$stats = array (
			array ("stab", "Stab"),
			array ("slash", "Slash"),
			array ("crush", "Crush"),
			array ("magic", "Magic"),
			array ("range", "Ranged")
		);

		if ($items[$i]["type"] == 1) {
				// ^^^
				// If the current item is a weapon or piece of
				// armour, show the normal rows.

			foreach ($stats as $stat) {

				echo '
						<tr>
							<th class="tablebottom">' . $stat[1] . '</th>
							<td class="tablebottom">' . difff ($items[$i]["a-" . $stat[0]]) . '</td>
							<td class="tablebottom">' . difff ($items[$i]["a-" . $stat[0]], $items[0]["a-" . $stat[0]]) . '</td>
							<td class="tablebottom">' . percentf ($items[$i]["a-" . $stat[0]], $items[0]["a-" . $stat[0]]) . '</td>
							<td class="tablebottom">' . difff ($items[$i]["d-" . $stat[0]]) . '</td>
							<td class="tablebottom">' . difff ($items[$i]["d-" . $stat[0]], $items[0]["d-" . $stat[0]]) . '</td>
							<td class="tablebottom">' . percentf ($items[$i]["d-" . $stat[0]], $items[0]["d-" . $stat[0]]) . '</td>
						</tr>';

			}
		} else {
				// ^^^
				// Or if it's not a combat item, show the
				// "not applicable" rows.

				foreach ($stats as $stat) {

					echo '
						<tr>
							<th class="tablebottom" style="font-style:italic;">' . $stat[1] . '</th>
							<td class="tablebottom" style="font-style:italic;">N/A</td>
							<td class="tablebottom" style="font-style:italic;">N/A</td>
							<td class="tablebottom" style="font-style:italic;">N/A</td>
							<td class="tablebottom" style="font-style:italic;">N/A</td>
							<td class="tablebottom" style="font-style:italic;">N/A</td>
							<td class="tablebottom" style="font-style:italic;">N/A</td>
						</tr>';

				}
		}

		echo '
						<tr>
							<th class="tabletop" style="border-top:0px;"><abbr title="Statistic">Stat</abbr></th>
							<th class="tabletop" style="border-top:0px;"><abbr title="Extra">Ex.</abbr></th>
							<th class="tabletop" style="border-top:0px;"><abbr title="Difference in extra bonuses">&Delta;Ex.</abbr></th>
							<th class="tabletop" style="border-top:0px;"><abbr title="Extra bonus as a percentage of ' . $items[0]["name"] . '\'s">Ex. %</abbr></th>
							<th colspan="3">&nbsp;</th>
						</tr>';

		$stats = array (
			array ("strength", "Strength"),
			array ("prayer", "Prayer"),

		);

		if ($items[$i]["type"] == 1) {
				// ^^^
				// If the current item is a weapon or piece of
				// armour, show the strength and prayer rows.

			foreach ($stats as $stat) {

				echo '
						<tr>
							<th class="tablebottom">' . $stat[1] . '</th>
							<td class="tablebottom">' . difff ($items[$i][$stat[0]]) . '</td>
							<td class="tablebottom">' . difff ($items[$i][$stat[0]], $items[0][$stat[0]]) . '</td>
							<td class="tablebottom">' . percentf ($items[$i][$stat[0]], $items[0][$stat[0]]) . '</td>
						</tr>';

			}
		} else {
				// ^^^
				// Or if it is not a combat item, show the
				// "not applicable" rows.

			foreach ($stats as $stat) {

				echo '
						<tr>
							<th class="tablebottom">' . $stat[1] . '</th>
							<td class="tablebottom" style="font-style:italic;">N/A</td>
							<td class="tablebottom" style="font-style:italic;">N/A</td>
							<td class="tablebottom" style="font-style:italic;">N/A</td>
						</tr>';

			}
		}

		echo '
					</table>
				</div>';

	}

	echo '
				<br style="clear:both;" />
				<h2><br />Descriptive information</h2>';

			// Quick-find: qf_i1_desc
			// Descriptive information for the left item.

	echo '
				<div style="float:left;width:49%">
					<h3 style="text-align:center;"><a href="items.php?id=' . $items[0]["id"] . '" title="OSRS RuneScape Help\'s item details for ' . $items[0]["name"] . '">' . $items[0]["name"] . '</a></h3>
					<table cellspacing="0" style="border-top:1px solid #000;border-left:1px solid #000;width:94%;float:left;">
						<tr>
							<th class="boxed" style="border-top:0px;border-bottom:0px;border-left:0px;">Obtained from</th>
							<td class="tablebottom">' . $items[0]["obtain"] . '</td>
						</tr>';

	if ($items[0]["type"] == 2 || $items[$i]["type"] == 2) {
			// ^^^
			// If either item is a quest item, show the
			// quest-related rows. Otherwise, don't.

		if ($items[0]["type"] == 2) {
				// ^^^
				// If the current item is a quest item, show the
				// quest-related rows.

echo '
						<tr>
							<th class="boxed" style="border-bottom:0px;border-left:0px;">Keep/drop</th>
							<td class="tablebottom">' . $items[0]["keepdrop"] . '</td>
						</tr>
						<tr>
							<th class="boxed" style="border-bottom:0px;border-left:0px;">Retrieval</th>
							<td class="tablebottom">' . $items[0]["retrieve"] . '</td>
						</tr>
						<tr>
							<th class="boxed" style="border-bottom:0px;border-left:0px;">Quest use</th>
							<td class="tablebottom">' . $items[0]["questuse"] . '</td>
						</tr>';

		} else {
				// ^^^
				// Otherwise, if the current item isn't a quest
				// item, show the "not applicable" rows.

			echo '
						<tr>
							<th class="boxed" style="border-bottom:0px;border-left:0px;">Keep/drop</th>
							<td class="tablebottom" style="font-style:italic;">Not applicable</td>
						</tr>
						<tr>
							<th class="boxed" style="border-bottom:0px;border-left:0px;">Retrieval</th>
							<td class="tablebottom" style="font-style:italic;">Not applicable</td>
						</tr>
						<tr>
							<th class="boxed" style="border-bottom:0px;border-left:0px;">Quest use</th>
							<td class="tablebottom" style="font-style:italic;">Not applicable</td>
						</tr>';

		}
	}

	echo '
						<tr>
							<th class="boxed" style="border-bottom:0px;border-left:0px;">Notes</th>
							<td class="tablebottom">' . $items[0]["notes"] . '</td>
						</tr>
						<tr>
							<th class="boxed" style="border-bottom:0px;border-left:0px;">Credits</th>
							<td class="tablebottom">' . $items[0]["credits"] . '</td>
						</tr>
						<tr>
							<th class="boxed" style="border-left:0px;">Last updated</th>
							<td class="tablebottom">' . $items[0]["time"] . '</td>
						</tr>
					</table>
				</div>';

			// Quick-find: qf_i2_desc
			// Descriptive information for the right item.

	echo '
				<div style="float:right;width:49%">
					<h3 style="text-align:center;"><a href="items.php?id=' . $items[$i]["id"] . '" title="OSRS RuneScape Help\'s item details for ' . $items[$i]["name"] . '">' . $items[$i]["name"] . '</a></h3>
					<table cellspacing="0" style="border-top:1px solid #000;border-left:1px solid #000;width:94%;float:right;">
						<tr>
							<th class="boxed" style="border-bottom:0px;border-top:0px;border-left:0px;">Obtained from</th>
							<td class="tablebottom">' . $items[$i]["obtain"] . '</td>
						</tr>';

	if ($items[$i]["type"] == 2 || $items[0]["type"] == 2) {
			// ^^^
			// If either item is a quest item, show the
			// quest-related rows. Otherwise, don't.

		if ($items[$i]["type"] == 2) {
				// ^^^
				// If the current item is a quest item, show the
				// quest-related rows.

echo '
						<tr>
							<th class="boxed" style="border-bottom:0px;border-left:0px;">Keep/drop</th>
							<td class="tablebottom">' . $items[$i]["keepdrop"] . '</td>
						</tr>
						<tr>
							<th class="boxed" style="border-bottom:0px;border-left:0px;">Retrieval</th>
							<td class="tablebottom">' . $items[$i]["retrieve"] . '</td>
						</tr>
						<tr>
							<th class="boxed" style="border-bottom:0px;border-left:0px;">Quest use</th>
							<td class="tablebottom">' . $items[$i]["questuse"] . '</td>
						</tr>';

		} else {
				// ^^^
				// Otherwise, if the current item isn't a quest
				// item, show the "not applicable" rows.

			echo '
						<tr>
							<th class="boxed" style="border-bottom:0px;border-left:0px;">Keep/drop</th>
							<td class="tablebottom" style="font-style:italic;">Not applicable</td>
						</tr>
						<tr>
							<th class="boxed" style="border-bottom:0px;border-left:0px;">Retrieval</th>
							<td class="tablebottom" style="font-style:italic;">Not applicable</td>
						</tr>
						<tr>
							<th class="boxed" style="border-bottom:0px;border-left:0px;">Quest use</th>
							<td class="tablebottom" style="font-style:italic;">Not applicable</td>
						</tr>';

		}
	}

	echo'
						<tr>
							<th class="boxed" style="border-bottom:0px;border-left:0px;">Notes</th>
							<td class="tablebottom">' . $items[$i]["notes"] . '</td>
						</tr>
						<tr>
							<th class="boxed" style="border-bottom:0px;border-left:0px;">Credits</th>
							<td class="tablebottom">' . $items[$i]["credits"] . '</td>
						</tr>
						<tr>
							<th class="boxed" style="border-left:0px;">Last updated</th>
							<td class="tablebottom">' . $items[$i]["time"] . '</td>
						</tr>
					</table>
				</div><br style="clear:both;" />';

	echo "\n\t\t\t<br style=\"clear:both;\" />\n\t\t\t<br style=\"clear:both;\" />";

	echo '</div></div>';
}
} 

echo '<br style="clear:both;" />';
end_page();
?>