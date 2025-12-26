<?php

/* Run hourly to get currently playing on OSRS */

$url = 'https://oldschool.runescape.com/';
$buffer = file_get_contents($url,FALSE, NULL); 
$players = getStringBetween($buffer,"player-count'>There are currently "," people playing!");
$players = preg_replace('#(?<=\d),(?=\d)#','',$players);

function getStringBetween($str,$from,$to){
    $sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
    return substr($sub,0,strpos($sub,$to));
}


/* Then store in database */

$mysqli = new mysqli('localhost', 'rsc_online', 'killher', 'rsc_online');

if ($mysqli->connect_errno) {
    echo "Error: Failed to make a MySQL connection: \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
    exit;
}

$sql = 'INSERT INTO `osrs` (`players`,`time`) VALUES ("'.$mysqli->real_escape_string($players).'","'.time().'")';
$mysqli->query($sql);

?>