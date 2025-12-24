<?
if ($_SERVER["SERVER_ADDR"] != '127.0.0.1') {

    mysql_select_db('helpdb', mysql_connect('localhost', 'zyhelp', '79g0ld42'));
    include('/home/w13/www/zybez.net/html/getzybez.php');
    $query = mysql_query("SELECT url, date FROM cachedpages WHERE date = (SELECT min(date) FROM cachedpages WHERE url LIKE '%search%' OR url LIKE '%genguides%' OR url LIKE '%index%' OR url = '/priceguide.php' OR url LIKE '%community%' OR url = '' OR url = '/' OR url LIKE '%ticker%' OR url LIKE '%archive%' OR url = '/blog.php?type=1' OR url = '/blog.php?type=2' OR url = '/blog.php?type=3' OR url like '%swiftswitch%' OR url like '%runescapevideos%') LIMIT 1");
    $result = mysql_fetch_row($query);
    $stamp = $result[1];
    $check = time() - 86400;
    if(mysql_num_rows($query) == 1 && $stamp < (time() - 86400)) {
      echo 'http://www.zybez.net' . $result[0] . '<br />';
      pleasecache('http://www.zybez.net' . $result[0]);
      header( 'refresh: 1; url=http://www.zybez.net/autocache.php' );
   }
   else {
     echo 'Not caching anything... no results, or more than one result, or no stale cache.';
   } 

}
else {

    echo 'oops';

}
?>
