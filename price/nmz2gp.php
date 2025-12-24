#!/usr/local/bin/php
<?php

// get the JSON of each item
$snapeGrass = json_decode(getHTML("http://forums.zybez.net/runescape-2007-prices/api/item/97"));
$redSpiderEggs = json_decode(getHTML("http://forums.zybez.net/runescape-2007-prices/api/item/93"));
$flax = json_decode(getHTML("http://forums.zybez.net/runescape-2007-prices/api/item/959"));
$bucketOfSand = json_decode(getHTML("http://forums.zybez.net/runescape-2007-prices/api/item/961"));
$potatoCactus = json_decode(getHTML("http://forums.zybez.net/runescape-2007-prices/api/item/1535"));
$seaweed = json_decode(getHTML("http://forums.zybez.net/runescape-2007-prices/api/item/190"));
$dragonScaleDust = json_decode(getHTML("http://forums.zybez.net/runescape-2007-prices/api/item/102"));
$compostPotion = json_decode(getHTML("http://forums.zybez.net/runescape-2007-prices/api/item/2932"));
$airRune = json_decode(getHTML("http://forums.zybez.net/runescape-2007-prices/api/item/275"));
$waterRune = json_decode(getHTML("http://forums.zybez.net/runescape-2007-prices/api/item/274"));
$earthRune = json_decode(getHTML("http://forums.zybez.net/runescape-2007-prices/api/item/276"));
$fireRune = json_decode(getHTML("http://forums.zybez.net/runescape-2007-prices/api/item/273"));
$runeEssence = json_decode(getHTML("http://forums.zybez.net/runescape-2007-prices/api/item/762"));
$pureEssence = json_decode(getHTML("http://forums.zybez.net/runescape-2007-prices/api/item/3527"));
$vialOfWater = json_decode(getHTML("http://forums.zybez.net/runescape-2007-prices/api/item/95"));


// get the JSON data from the OSRS price guide and save it as a string
function getHTML ($www) {

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $www);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT , 4);	
	// get HTML
	$html = curl_exec($ch);
	curl_close($ch);
	
	return $html;
}
?>
<tr>
	<th>Item</th>
	<th>GP/Point Value</th>
</tr>
<tr>
	<td>Snape grass</td>
	<td class="tablebottom"><?php echo number_format(round($snapeGrass->average)/175,3) ?></td>
</tr>
<tr>
	<td>Red Spiders eggs</td>
	<td class="tablebottom"><?php echo number_format(round($redSpiderEggs->average)/300,3) ?></td>
</tr>
<tr>
	<td>Flax</td>
	<td class="tablebottom"><?php echo number_format(round($flax->average)/75,3) ?></td>
</tr>
<tr>
	<td>Bucket of sand</td>
	<td class="tablebottom"><?php echo number_format(round($bucketOfSand->average)/200,3) ?></td>
</tr>
<tr>
	<td>Potato cactus</td>
	<td class="tablebottom"><?php echo number_format(round($potatoCactus->average)/1250,3) ?></td>
</tr>
<tr>
	<td>Seaweed</td>
	<td class="tablebottom"><?php echo number_format(round($seaweed->average)/200,3) ?></td>
</tr>
<tr>
	<td>Dragon scale dust</td>
	<td class="tablebottom"><?php echo number_format(round($dragonScaleDust->average)/750,3) ?></td>
</tr>
<tr>
	<td>Compost potion(4)</td>
	<td class="tablebottom"><?php echo number_format(round($compostPotion->average)/5000,3) ?></td>
</tr>
<tr>
	<td>Air rune</td>
	<td class="tablebottom"><?php echo number_format(round($airRune->average)/25,3) ?></td>
</tr>
<tr>
	<td>Water rune</td>
	<td class="tablebottom"><?php echo number_format(round($waterRune->average)/25,3) ?></td>
</tr>
<tr>
	<td>Earth rune</td>
	<td class="tablebottom"><?php echo number_format(round($earthRune->average)/25,3) ?></td>
</tr>
<tr>
	<td>Fire rune</td>
	<td class="tablebottom"><?php echo number_format(round($fireRune->average)/25,3) ?></td>
</tr>
<tr>
	<td>Rune essence</td>
	<td class="tablebottom"><?php echo number_format(round($runeEssence->average)/60,3) ?></td>
</tr>
<tr>
	<td>Pure essence</td>
	<td class="tablebottom"><?php echo number_format(round($pureEssence->average)/70,3) ?></td>
</tr>
<tr>
	<td>Vial of water</td>
	<td class="tablebottom"><?php echo number_format(round($vialOfWater->average)/145,3) ?></td>
</tr>
