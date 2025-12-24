<?php

die('deprecated');

/* nope. */

/* Path to Root */
$ROOT = dirname(__FILE__);
define( 'SYSROOT' , $ROOT );

function pleasecache($cachethis){	
	echo "(cache system off)"; return false; // CACHE SYSTEM OFF.  REMOVE THIS LINE WHEN ITS BACK ONLINE
      $requested = str_replace("http://www.runescapecommunity.com", "", $cachethis);
      $req = $requested;
      $reqmd5 = md5($req);
      $requested = SYSROOT . '/md5cache/' . md5($requested ). '.html';

    if (file_exists($requested)) { //delete file if exists already
      $fh = fopen($requested, 'w');
      fclose($fh);
      unlink($requested);
    }

    $curl_handle=curl_init();
    curl_setopt($curl_handle,CURLOPT_URL,$cachethis);
    curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
    curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
    $buffer = curl_exec($curl_handle);
    curl_close($curl_handle);

    if (empty($buffer))    {
        print '<span style="font:9px Verdana">Sorry, page did not re-cache. Please try again.</span>';
    }
    else
    {
    
      $f1 = fopen($requested,"w");
      $buffer = $buffer;
      fwrite($f1,$buffer);
      fclose($f1);
      echo '<span style="font:9px Verdana">Cache Built to: ' . $requested . '</span><br />';
  
  
  mysql_select_db('helpdb', mysql_connect('localhost', 'rsc', 'heyplants44')) or die('Error: Unable to connect to database. ' . mysql_error());
	mysql_query("DELETE FROM `cachedpages` WHERE `crc`='$reqmd5' LIMIT 1");
	mysql_query("INSERT INTO `cachedpages` (date,url,crc) VALUES (UNIX_TIMESTAMP(),'$req','$reqmd5')");
	  
}
}

function pleasedelete($requested){

    $requested = $_GET['delthis'];
    $requested = str_replace("http://www.runescapecommunity.com", "", $requested);
    $reqmd5 = md5($requested);
    $requested = SYSROOT . '/md5cache/' . md5($requested) . '.html';

    $fh = fopen($requested, 'w');
    fclose($fh);
    unlink($requested);

    echo 'Deleted from cache: ' . $requested . '<br />';
  
  mysql_select_db('helpdb', mysql_connect('localhost', 'rsc', 'heyplants44')) or die('Error: Unable to connect to database. ' . mysql_error());
	mysql_query("DELETE FROM `cachedpages` WHERE `crc`='$reqmd5' LIMIT 1");

}

if(isset($_GET['cacheindex']) == 'yes'){
  pleasecache('http://www.runescapecommunity.com');
  pleasecache('http://www.runescapecommunity.com/');
  pleasecache('http://www.runescapecommunity.com/?');
  pleasecache('http://www.runescapecommunity.com/index.php');
  pleasecache('http://www.runescapecommunity.com/index.php?');

}elseif(isset($_GET['cachethis']) && $_GET['cachethis']!=''){
  pleasecache($_GET['cachethis']);

}elseif(isset($_GET['delthis'])){
 pleasedelete($_GET['delthis']);

}elseif(isset($_GET['add'])){

    echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" target="theframe">
    Put in complete URL of page you want to cache:<br />
    <input type="text" name="cachethis"> or: Cache Index <input type="checkbox" name="cacheindex" value="yes"  /> || 
    <input type="submit" value="cache" /></form>

    <iframe name="theframe" id="theframe" width="450"></iframe>';

}
?>