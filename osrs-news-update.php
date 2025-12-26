<?php

/* 
				OSRS News Parser and RSC Poster Script
				by W13
				version 27 Sep 2018    (why use version numbers when we can just use dates?)
 */
 
 /* #### VARIABLES ### */
 
 $url_of_RSS = 'http://services.runescape.com/m=news/latest_news.rss?oldschool=true';
 $url_of_default_pic = 'https://cdn.runescape.com/assets/img/external/oldschool/2017/newsposts/2017-06-12/thumbnail-logo.png';
 $name_of_bot = 'Newsy';
 $uid_of_bot = '164';
 $news_forum_id = '24';
 
 $debug_mode = 1;
 
 $mysqli = new mysqli('localhost', 'phpbb', 'openbb#44#', 'rsc_mybb');

 
 /*  ~  ~  ~ ~ ~ ~ ~   ~  ~   ~     ~   ~    ~ ~ ~   ~    ~    ~ ~   ~ ~ */
 /* ________....__________...._________.(    )__________...._________..__*/
 /* #################################################################### */
 
	if ($mysqli->connect_errno) {
		if($debug_mode==1){
			echo "Error: Failed to make a MySQL connection: \n";
			echo "Errno: " . $mysqli->connect_errno . "\n";
			echo "Error: " . $mysqli->connect_error . "\n";
			}
		exit;
	}

 $qq = ''; function qq($q,$n='<br />'){$GLOBALS['qq'] .= $n . $q; } /* debug buffer handler */
 
 qq('Connected to mySQL');
 qq('Getting XML osrs news using file_get_contents...');
 
$url = $url_of_RSS;
$buffer = file_get_contents($url, FALSE, NULL);

if($buffer==FALSE || strlen($buffer)<200){
	// File_get_contents failed. Let's try cURL:
	qq('failed. trying cURL...');
		$buffer = curlGrab($url);
}else{ qq('...succeeded.',' ~ '); }


$xml = new SimpleXMLElement($buffer);

qq('Looping...');

foreach ($xml->channel->item as $element) {
	 

		 
	   /* We loop once for each 
			news story in the parsed XML.
			There's a special table (runescape_osrs_news) which stores the titles and pubDates for each story we parsed.
			and if it exists, we've already made thread on RSC.
			If it doesn't, we'll make a new thread posting.
	   */
	   

		$element->title = $mysqli->real_escape_string($element->title);
		$element->pubDate = $mysqli->real_escape_string($element->pubDate);
		
		qq(' - News already exists?');
		
		$query = 'SELECT * FROM `runescape_osrs_news` WHERE `title`="'.$element->title.'" AND `pubDate`="'.$element->pubDate.'" LIMIT 1';
			if ($result = $mysqli->query($query)) {
			if($result->num_rows==0){
					qq('No. Insert into DB...',' ~ ');
					/* This is a new story. So, store it in DB first so we dont double-post ever again */
					$sql = 'INSERT INTO `runescape_osrs_news` (`title`,`pubDate`) VALUES ("'.$element->title.'","'.$element->pubDate.'")';
					$mysqli->query($sql); 
					/* And now we scrape the news story... */
					
			$url = $element->link;
			
			// Security Fix: Whitelist domains for SSRF protection
			$allowed_domains = array('runescape.com', 'services.runescape.com', 'oldschool.runescape.com');
			$url_parts = parse_url($url);
			$is_allowed = false;
			foreach($allowed_domains as $domain) {
				if(isset($url_parts['host']) && (strtolower($url_parts['host']) == $domain || substr(strtolower($url_parts['host']), -strlen('.'.$domain)) == '.'.$domain)) {
					$is_allowed = true;
					break;
				}
			}

			if (!$is_allowed) {
				qq('Unauthorized URL skipped: ' . $url);
				continue;
			}

			qq('Attempting to parse using file_get_contents... ');
			$buffer = file_get_contents($url,FALSE, NULL); 
			
			if($buffer==FALSE){
				qq('failed. Trying cURL instead... ',' ');
				// File_get_contents failed. Let's try cURL:
					$buffer = curlGrab($url);
			}

			if($buffer==FALSE || strlen($buffer)<200){ qq('DOUBLE FAILED to get url: '. $url . ' We will skip it.'); }else{
						


	$bodyNews = getStringBetween($buffer,'<div id="article-top" name="article-top">',"<br><i>The Old School Team</i>"); 
					// Apr 23 2021: Fixed these tags ^ untested 
					// $bodyNews = getStringBetween($buffer,"<div class='news-article-content'>","<footer class='footer'>"); 
					/* dec 9 2020: fixed these tags ^ untested. */
					/* old: this would break if </div> tag is used in body of news article */
					
					$bodyNews = strip_tags($bodyNews); /* we strip all HTML tags. things to do list: do a HTML -> BB-Code transformaton first */
					
					/* lets append some pretty stuff... */
					
					// but first lets get the URL to the image mentioned in the XML... 
					//foreach ($element->enclosure->attributes as $elementtwo) { $newspic = $elementtwo->url; print_r($elementtwo); }
					//foreach ($element->enclosure as $elementtwo) { $newspic = $elementtwo->attributes->url; }
					// fuck it... I give up... can't get this shitty thing to give me the URL of the image from the array inside the object.
	/*
	SimpleXMLElement Object
	(
		[title] => Decanting, Withdraw X, and Bucket Packs
		[enclosure] => SimpleXMLElement Object
			(
				[@attributes] => Array
					(
						[type] => image/png
						[length] => 0
						[url] => https://cdn.runescape.com/assets/img/external/oldschool/2018/newsposts/2018-09-27/thumbnail.png
					)

			)

		[description] => 
					This week sees major QoL updates including improved decanting, withdraw-x banking on desktop, and the highly anticipated Bucket packs. 
			
	*/					
	//foreach($element->$enclosure as $elementtwo){ print_r($elementtwo); }
	$newspic = $element->$enclosure->$attributes->url ?? $url_of_default_pic; // default pic
					
						
					$bodyNews = '[align=center][img]'.$newspic.'[/img]
					[size=x-large][b]'.$element->title.'[/b][/size][/align]
					' . $bodyNews . '
					
					[url='.$element->link.']( Source: RuneScape.com )[/url]
					';
					
					$bodyNews = $mysqli->real_escape_string($bodyNews);
					
					/* then we post it on the forums... */
					/* this will break if myBB db table structure is updated in future versions */

						/* find highest post ID and highest thread ID, then, add 1 to each to help make IDs */
						
							$result = $mysqli->query("SELECT `tid` FROM `mybb_threads` ORDER BY `tid` DESC LIMIT 1");
							$row = $result->fetch_array(MYSQLI_ASSOC);
							$tid = $row['tid'] + 1;
							$result = $mysqli->query("SELECT `pid` FROM `mybb_posts` ORDER BY `pid` DESC LIMIT 1");
							$row = $result->fetch_array(MYSQLI_ASSOC);
							$pid = $row['pid'] + 1;

						
							
						/* Now actually do the posting... */	

							$sql = 'INSERT INTO `mybb_threads` (`tid`,`fid`,`subject`,`uid`,`username`,`dateline`,`firstpost`,`lastpost`,`lastposter`,`lastposteruid`,`visible`,`notes`) VALUES 
							(
							"'.$tid.'",
							"'.$news_forum_id.'",
							"'.$element->title.'",
							"'.$uid_of_bot.'",
							"'.$name_of_bot.'",
							"'.time().'",
							"'.$pid.'",
							"'.time().'",
							"'.$name_of_bot.'",
							"'.$uid_of_bot.'",
							"1",
"0"
							)';
							qq('Creating new thread: '.$sql);
							$mysqli->query($sql);

							
							$sql = 'INSERT INTO `mybb_posts` (`pid`,`tid`,`fid`,`uid`,`username`,`dateline`,`message`,`visible`) VALUES 
							(
							"'.$pid.'",
							"'.$tid.'",
							"'.$news_forum_id.'",
							"'.$uid_of_bot.'",
							"'.$name_of_bot.'",
							"'.time().'",
							"'.$bodyNews.'",
							"1"
							)';
							qq('Creating new post.');
							$mysqli->query($sql);
							
							
							$sql = 'UPDATE `mybb_forums` SET 
							`threads`=`threads`+1,
							`posts`=`posts`+1,
							`lastpost`="'.time().'",
							`lastposter`="'.$name_of_bot.'",
							`lastposteruid`="'.$uid_of_bot.'",
							`lastposttid`="'.$tid.'",
							`lastpostsubject`="'.$element->title.'" 
							WHERE `fid`="'.$news_forum_id.'" LIMIT 1';
							qq('Updating forum\'s last post info.');
							$mysqli->query($sql);
							
							$sql = 'UPDATE `mybb_users` SET
							`postnum`=`postnum`+1,
							`threadnum`=`threadnum`+1,
							`lastactive`="'.time().'",
							`lastvisit`="'.time().'",
							`lastpost`="'.time().'"
							WHERE `uid`="'.$uid_of_bot.'" LIMIT 1';
							qq('Updating '.$name_of_bot.'\'s post count.');
							$mysqli->query($sql);
							
			}			
		}else{ qq('yes.',' ~ '); }
			
			}else{ qq('ERROR: mySQL result couldnt be gotten.'); }
}
qq('<b>Done.</b>');


if($debug_mode==1){	echo $qq;
	if ($mysqli->error) {
		try {    
			throw new Exception("MySQL error $mysqli->error <br> Query:<br> $query", $msqli->errno);    
		} catch(Exception $e ) {
			echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
			echo nl2br($e->getTraceAsString());
		}
	}
	
	// print_r($http->logs); // uncomment this to see cURL errors. (untested)
	
}

function getStringBetween($str,$from,$to){
			$sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
			return substr($sub,0,strpos($sub,$to));
		}


function curlGrab($url){		
$http = new HTTP([
	'userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36',
	'timeout' => 10,
	'referer' => 'https://www.google.com',
]);
$response = $http->get($url);

if ($response) {
	return $response['body'];
}else{ return false;}
}
		
		
/**
 * HTTP: A very simple cURL wrapper.
 *
 * Copyright (c) 2017 Sei Kan
 *
 * Distributed under the terms of the MIT License.
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright  2017 Sei Kan <seikan.dev@gmail.com>
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 * @see       https://github.com/seikan/HTTP
 */
class HTTP
{
	/**
	 * cURL object.
	 *
	 * @var object
	 */
	protected $http;
	/**
	 * Collection of errors.
	 *
	 * @var array
	 */
	private $logs = [];
	/**
	 * File to store cookies.
	 *
	 * @var string
	 */
	private $cookies;
	/**
	 * Initialize cURL object.
	 *
	 * @param array $options
	 */
	public function __construct($options = [])
	{
		$this->http = curl_init();
		curl_setopt($this->http, CURLOPT_FAILONERROR, true);
		curl_setopt($this->http, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($this->http, CURLOPT_AUTOREFERER, true);
		curl_setopt($this->http, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->http, CURLOPT_HEADER, true);
		curl_setopt($this->http, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($this->http, CURLOPT_ENCODING, 'gzip, deflate');
		curl_setopt($this->http, CURLOPT_HTTP_VERSION, '1.1');
		$this->cookies = tempnam(sys_get_temp_dir(), 'cookies_' . md5(microtime()));
		curl_setopt($this->http, CURLOPT_COOKIEFILE, $this->cookies);
		curl_setopt($this->http, CURLOPT_COOKIEJAR, $this->cookies);
		if (isset($options['userAgent'])) {
			curl_setopt($this->http, CURLOPT_USERAGENT, $options['userAgent']);
		}
		if (isset($options['timeout'])) {
			curl_setopt($this->http, CURLOPT_TIMEOUT, $options['timeout']);
		}
		if (isset($options['referer'])) {
			curl_setopt($this->http, CURLOPT_REFERER, $options['referer']);
		}
		if (isset($options['headers'])) {
			curl_setopt($this->http, CURLOPT_HTTPHEADER, $options['headers']);
		}
		if (isset($options['username']) && isset($options['password'])) {
			curl_setopt($this->http, CURLOPT_USERPWD, $options['username'] . ':' . $options['password']);
		}
	}
	/**
	 * Destroy cURL object.
	 */
	public function __destruct()
	{
		curl_close($this->http);
	}
	/**
	 * Get logs for debugging purpose.
	 *
	 * @return array
	 */
	public function getLogs()
	{
		return $this->logs;
	}
	/**
	 * Send a GET request.
	 *
	 * @param string $url
	 *
	 * @return array|null
	 */
	public function get($url)
	{
		curl_setopt($this->http, CURLOPT_URL, $url);
		curl_setopt($this->http, CURLOPT_HTTPGET, true);
		$this->logs[] = 'GET ' . $url;
		$response = curl_exec($this->http);
		if (!curl_errno($this->http)) {
			$code = curl_getinfo($this->http, CURLINFO_HTTP_CODE);
			$size = curl_getinfo($this->http, CURLINFO_HEADER_SIZE);
			$this->logs[] = '[STATUS] ' . $code;
			$headers = $this->parseHeader(substr($response, 0, $size));
			return [
				'header' => $headers,
				'body'   => substr($response, $size),
			];
		}
		$this->logs[] = '[ERROR] [' . curl_errno($this->http) . '] ' . curl_error($this->http);
		return null;
	}
	/**
	 * Send a POST request.
	 *
	 * @param string $url
	 * @param array  $fields
	 *
	 * @return array|null
	 */
	public function post($url, $fields = [])
	{
		curl_setopt($this->http, CURLOPT_URL, $url);
		curl_setopt($this->http, CURLOPT_POST, true);
		$queries = (!empty($fields)) ? http_build_query($fields) : '';
		if ($queries) {
			curl_setopt($this->http, CURLOPT_POSTFIELDS, $queries);
		}
		$this->logs[] = 'POST ' . $url . (($queries) ? (' ' . $queries) : '');
		$response = curl_exec($this->http);
		if (!curl_errno($this->http)) {
			$code = curl_getinfo($this->http, CURLINFO_HTTP_CODE);
			$size = curl_getinfo($this->http, CURLINFO_HEADER_SIZE);
			$this->logs[] = '[STATUS] ' . $code;
			$headers = $this->parseHeader(substr($response, 0, $size));
			return [
				'header' => $headers,
				'body'   => substr($response, $size),
			];
		}
		$this->logs[] = '[ERROR] [' . curl_errno($this->http) . '] ' . curl_error($this->http);
		return null;
	}
	/**
	 * Download a file to local.
	 *
	 * @param string $url
	 * @param string $path
	 *
	 * @return array|false
	 */
	public function download($url, $path)
	{
		curl_setopt($this->http, CURLOPT_HEADER, false);
		curl_setopt($this->http, CURLOPT_URL, $url);
		curl_setopt($this->http, CURLOPT_HTTPGET, true);
		if (is_dir($path)) {
			$path = $path . DIRECTORY_SEPARATOR . md5(microtime());
		}
		$buffer = tmpfile();
		curl_setopt($this->http, CURLOPT_WRITEHEADER, $buffer);
		if (($fp = fopen($path, 'w')) === false) {
			$this->logs[] = '[ERROR] Directory is not writable.';
			return false;
		}
		curl_setopt($this->http, CURLOPT_FILE, $fp);
		$this->logs[] = 'GET ' . $url;
		$response = curl_exec($this->http);
		curl_setopt($this->http, CURLOPT_HEADER, 1);
		fclose($fp);
		if (!curl_errno($this->http)) {
			$code = curl_getinfo($this->http, CURLINFO_HTTP_CODE);
			$this->logs[] = '[STATUS] ' . $code;
			rewind($buffer);
			$headers = $this->parseHeader(stream_get_contents($buffer));
			fclose($buffer);
			if (isset($headers['Content-disposition'])) {
				if (preg_match('/filename="([^"]+)/', $headers['Content-disposition'], $matches)) {
					rename($path, dirname($path) . DIRECTORY_SEPARATOR . $matches[1]);
					$path = dirname($path) . DIRECTORY_SEPARATOR . $matches[1];
				}
			}
			return [
				'file' => $path,
				'size' => filesize($path),
			];
		}
		$this->logs[] = '[ERROR] [' . curl_errno($this->http) . '] ' . curl_error($this->http);
		return false;
	}
	/**
	 * Upload file.
	 *
	 * @param string $url
	 * @param array  $fields
	 * @param array  $files
	 *
	 * @return array|null
	 */
	public function upload($url, $fields = [], $files = [])
	{
		curl_setopt($this->http, CURLOPT_URL, $url);
		curl_setopt($this->http, CURLOPT_POST, 1);
		if (!empty($files)) {
			foreach ($files as $key => $file) {
				if (!file_exists($file)) {
					continue;
				}
				$fields[$key] = '@' . (((strpos(PHP_OS, 'WIN') !== false)) ? str_replace('/', '\\\\', $file) : $file);
			}
		}
		$queries = (!empty($fields)) ? http_build_query($fields) : '';
		if ($queries) {
			curl_setopt($this->http, CURLOPT_POSTFIELDS, $queries);
		}
		$this->logs[] = 'POST ' . $url . (($queries) ? (' ' . $queries) : '');
		$response = curl_exec($this->http);
		if (!curl_errno($this->http)) {
			$code = curl_getinfo($this->http, CURLINFO_HTTP_CODE);
			$size = curl_getinfo($this->http, CURLINFO_HEADER_SIZE);
			$this->logs[] = '[STATUS] ' . $code;
			$headers = $this->parseHeader(substr($response, 0, $size));
			return [
				'header' => $headers,
				'body'   => substr($response, $size),
			];
		}
		$this->logs[] = '[ERROR] [' . curl_errno($this->http) . '] ' . curl_error($this->http);
		return null;
	}
	/**
	 * Use a HTTP proxy.
	 *
	 * @param string $host
	 * @param string $port
	 * @param string $username
	 * @param string $password
	 */
	public function useProxy($host, $port, $username = '', $password = '')
	{
		curl_setopt($this->http, CURLOPT_PROXY, $host . ':' . $port);
		if ($username && $password) {
			curl_setopt($this->http, CURLOPT_PROXYUSERPWD, $username . ':' . $password);
		}
	}
	/**
	 * Process headers received from HTTP request.
	 *
	 * @param string $raw
	 *
	 * @return string
	 */
	private function parseHeader($raw)
	{
		$headers = [];
		$rows = explode("\r\n", $raw);
		foreach ($rows as $row) {
			if (strpos($row, ':') === false) {
				continue;
			}
			list($key, $value) = explode(':', $row, 2);
			$headers[$key] = trim($value);
		}
		return $headers;
	}
}
		


?>
