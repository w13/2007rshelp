<?php
/*** CLASSES ***/

/* DB Class */
class db
{
	public $queries = 0;
	private $host = '';
	private $username = '';
	private $password = '';
	private $database = '';
	public $cache = '';
	public $connect;
	public $result;
	public $row;
	public $num_rows;
	public $select_db;
	public $disconnect;
	public $escape_string;

	function set_mysql_host( $host = '' ) {
		$this->host = $host;
	}
	function set_mysql_user( $user = '' ) {
		$this->username = $user;
	}
	function set_mysql_pass( $pass = '' ) {
		$this->password = $pass;
	}
	function set_mysql_database( $database = ''){    /*added sep 2018 while changing from mysql to mysqli due to php 7 - W13*/
		$this->database = $database;
	}
	
	function sql_err() {
		global $DEBUG;
		try {
			throw new Exception;
		}
		catch( Exception $e ) {
			echo $e;
		}
		
		
		if($DEBUG == 1) die( '<strong>MySQL Error: ' . mysqli_errno($this->connect) . ' -- ' . mysqli_error($this->connect) . '</strong><br /><br />'.$this->cache );
		else die( '<strong>MySQL Error: ' . mysqli_errno($this->connect) . ' -- ' . mysqli_error($this->connect) . '</strong>' );
	}
	function connect() {
		if ($this->connect instanceof mysqli) {
			return $this->connect;
		}
		$this->connect = mysqli_connect( $this->host , $this->username , $this->password ) or $this->sql_err();
		return $this->connect;
	}
	function disconnect() {
		$this->disconnect = mysqli_close( $this->connect );
		return $this->disconnect;
	}
	function select_db( $database = '' ) {
		$this->select_db = mysqli_select_db( $this->connect, $database ) or $this->sql_err();
		return $this->select_db;
	}
	function query( $query = '' ) {
	  global $DEBUG;
		if($DEBUG == 1) $this->cache .= '<br />'.$query;
		// lets get rid of this - W13 (Apr 5, 2013)
			//$query = $this->query_cache($query);
		$this->result = mysqli_query( $this->connect, $query ) or $this->sql_err();
		$this->queries++;
		return $this->result;
	}
	function fetch_row( $query = '' ) {
	  global $DEBUG;
		if($DEBUG == 1) $this->cache .= '<br />'.$query;
		$this->result = mysqli_query( $this->connect, $query ) or $this->sql_err();
		$this->row = mysqli_fetch_assoc( $this->result );
		$this->queries++;
		return $this->row;
	}
	function fetch_array( $query = '' ) {
		$this->row = mysqli_fetch_assoc( $query );
		return $this->row;
	}
	function fetch_object( $query = '' ) {
		$this->row = mysqli_fetch_object( $query );
		return $this->row;
	}
	function num_rows( $query = '' ) {
		$this->result = mysqli_query( $this->connect, $query ) or $this->sql_err();
		$this->num_rows = mysqli_num_rows( $this->result );
		$this->queries++;
		return $this->num_rows;
	}
	function add_queries( $num = 0 ) {
		$this->queries = $this->queries + $num;
	}
	function count_queries() {
		return $this->queries;
	}
	function escape_string( $string = '' ) {
		$this->escape_string = mysqli_real_escape_string( $this->connect, $string );
		if ($this->escape_string === false) $this->sql_err();
		return $this->escape_string;
	}

	function insert_id() {
		return mysqli_insert_id($this->connect);
	}

	function affected_rows() {
		return mysqli_affected_rows($this->connect);
	}
	
	function query_cache( $query = '' ) {
		/* SQL_CACHE is removed in MySQL 8.0. 
		   This function is now a pass-through.
		*/
		return $query;
	}
	
}

/* Display Class */
class display
{
	public $default = 'darkblue';
	public $path = '';
	public $ROOT = '';
	public $db;
	public $errlevel = 0;

	function __construct( $DB_OBJECT, $DIR = '' , $root = '' ) {
		$this->path = $DIR . 'css/';
		$this->ROOT = $root;
		$this->db = $DB_OBJECT;
	}

	function get_file( $location ) {
		ob_start();
		// Include template file - error suppression removed for PHP 8 compatibility
		require( $this->ROOT . $location );
		$contents = ob_get_contents();
		ob_end_clean();

		return $contents;
	}

	function use_css() {
		if( empty( $_COOKIE['skin'] ) OR $_COOKIE['skin'] == 'default.css' ) {
			if (!headers_sent()) {
				setcookie( 'skin' , $this->default , time() + 1200000 );
			}
			$css = $this->path . $this->default;
		}
		else $css = $this->path . $_COOKIE['skin'];
		return $css;
	}

	function title( $start , $end , $default ) {
		if		( $start != '' AND $end != '' ) $title = $end . ' - ' . $start . ' - ' . $default;
		elseif	( $start != '' AND $end == '' ) $title = $start . ' - ' . $default;
		elseif	( $start == '' AND $end != '' ) $title = 'RuneScape ' . $end . ' - ' . $default;
		else $title = $default . ': Your source for RuneScape guides since 2001';

		return $title;
	}

	function metadesc( $file ) {
	  global $_GET;
		$metas = array(
       '' => '',
			'priceguide.php' => "Runescape's most up-to-date Runescape item price guide! Market prices for over 1,300 Runescape items, Runescape trading locations, tips on avoiding Runescape cheats and scams and in-page calculators to help with bigger trades!",
			'quests.php' => "Runescape quest guides and quest walkthrus giving players step-by-step help and instructions on all Runescape quests.",
			'items.php' => "Runescape item database containing all Runescape items including plenty of information on what to do and where to find them, helpful tips on quest items, item prices and more!",
			'monsters.php' => "Runescape monster database containing all Runescape monsters with tactics on how to defeat them, in-page experience calculators, drops, locations, and more!",
			'skills.php' => "Runescape skill guides containing tips, tricks, strategies and lots of other information for all Runescape skills.",
			'tiko.php' => "Online Runescape Toolkit (Tiko), provides all the Runescape guides and tips of Zybez Runescape Help, as well as built-in Zybez Radio, timers, IRC chat client, hiscore lookup, calculators, notepad, and screen capture utility.",
			'swiftkit.php' => "SwiftKit (aka SwiftSwitch) is a 100% safe, legal and downloadable Runescape Toolkit containing Runescape guides, IRC chat client, stats lookup, Runescape server status, skill calculators, screen capture/upload utility and more!",
			'misc.php?id=57' => "Runescape Treasure Trail help, including a treasure trail co-ordinate locator tool, lists of all the clues in Runescape, and rewards from Treasure Trails.",
			'misc.php' => "Runescape general guides, tips, tricks, hints and strategies on many aspects of Runescape game-play.",
			'runescapevideos.php' => "Runescape clan war videos, pking videos, staking videos, quest and monster killing movies, Runescape music videos, event films and loads more!",
			'default' => "A RuneScape help site and RuneScape community providing all RuneScape players with Runescape skill and item price guides, Runescape quest guides, Runescape maps, and loads more!" );

		$key = array_search($file, array_keys($metas) );
		$meta = $key == False ? $metas['default'] : $metas[$file];

		if($file == 'misc.php' && $_GET['id'] == '57') $meta = $metas['misc.php?id=57'];

		return $meta;
	}
	
	function extra_css( $file ) {
	  global $_GET;
		$css_files = array(
      '' => '',
			'misc.php' => '<style type="text/css">@import "/css/misc.css";</style>',
			'minigames.php' => '<style type="text/css">@import "/css/misc.css";</style>',
			'quests.php' => '<style type="text/css">@import "/css/quest.css";</style>',
			'testing.php' => '<style type="text/css">@import "/css/quest.css";</style>',
			'runescapevideos.php' => '<style type="text/css">@import "/css/video.css";</style>',
			'index.php' => '<style type="text/css">@import "/css/index_new.css";</style>',
			'default' => '' );

		$key = array_search($file, array_keys($css_files) );
		$css_file = $key == False ? $css_files['default'] : $css_files[$file];

		return $css_file;
	}

	function check_status() {
		if ( OFFLINE == 1 ) {
			die( require( $this->ROOT . '/content/offline.inc' ) );
		}
	}
	
	function inputErr( $lvl ) {
		if($lvl > $this->errlevel) $this->errlevel = $lvl;
	}
	
	function cleanVars( $input ) {
		$this->db->connect();
		$dataArr = array();
		foreach($input as $v) {

			if((string)$v[1] === '') {
				if(isset($v['d']) && $v['d']) $dataArr[$v[0]] = $v['d'];
				continue; // skip since there's no data
			}

			$fdata = $v[1];

			switch($v[2]) {
				case 'bin': // does it look true?
					$fdata = substr($fdata, 0, 1);
					switch($fdata) {
						case ($fdata > 0):
						case 'y':
						case 't':
						case 'o':
							$fdata = true;
						 break;
						default:
							$fdata = false;
						 break;
					}
				 break;
				case 'ip': // valid IP?
					$long = ip2long($fdata);
					if($long == False || $fdata != long2ip($long)) {
						$this->inputErr(2);
						$fdata = '0.0.0.0';
					}
				 break;
				case 'int': // is a number?
					if(!is_numeric($fdata)) {
						$this->inputErr(2);
						$fdata = intval($fdata);
					}
					if(isset($v['l']) && $v['l']) {
						if(strlen($fdata) > $v['l']) {
							$this->inputErr(1);
							$fdata = substr($fdata, 0, $v['l']);
						}
					}
					if($v['s']) {
						$minmax = explode(',', $v['s']);
						if($fdata < $minmax[0]) {
							$this->inputErr(1);
							$fdata = $minmax[0];
						} else if($fdata > $minmax[1]) {
							$this->inputErr(1);
							$fdata = $minmax[1];
						}
					}
				 break;
				case 'sql': // Clean for SQL
					$fdata = html_entity_decode(urldecode(stripslashes(trim($fdata))));
					if(isset($v['l']) && $v['l']) {
						if(strlen($fdata) > $v['l']) {
							$this->inputErr(2);
							$fdata = substr($fdata, 0, $v['l']);
						}
					}
					$fdata = $this->db->escape_string($fdata);
				 break;
				case 'sql_no_html': // Clean for SQL ONLY
					$fdata = html_entity_decode(urldecode(stripslashes(trim($fdata))));
					if($v['l']) {
						if(strlen($fdata) > $v['l']) {
							$this->inputErr(2);
							$fdata = substr($fdata, 0, $v['l']);
						}
					}
					$fdata = $this->db->escape_string($fdata);
				 break;
				case 'string': // clean for general use
					$fdata = html_entity_decode(urldecode(trim($fdata)), ENT_QUOTES);
					if($v['l']) {
						if(strlen($fdata) > $v['l']) {
							$this->inputErr(2);
							$fdata = substr($fdata, 0, $v['l']);
						}
					}
					$fdata = htmlentities($fdata, ENT_QUOTES);
				 break;
				case 'enum':
					if(array_search($fdata, $v['e']) === False) {
						$this->inputErr(3);
						$fdata = $v['e'][0];
					}
				 break;
			}
		  $dataArr[$v[0]] = $fdata;
		}
		return $dataArr;
	}
}

/* Timer Class */
class timer 
{
 function startTimer() 
  {
   global $starttime;
   $mtime = microtime();
   $mtime = explode( ' ' , $mtime );
   $mtime = $mtime[1] + $mtime[0];
   $starttime = $mtime;
  }
  
 function endTimer()
  {
   global $starttime; 
   $mtime = microtime();
   $mtime = explode( ' ' , $mtime );
   $mtime = $mtime[1] + $mtime[0];
   $endtime = $mtime;
   $totaltime = round( ( $endtime - $starttime ) , 5 );
   return $totaltime;
  }
  
 function showLoad()
  {
   $loadavg_array = explode( ' ' , exec( 'cat /proc/loadavg' ) );
   $loadavg_array[2] = intval(($loadavg_array[2])/8*100) . '&#37;'; //w13 added this line
   return $loadavg_array[2];
  }
}

/* Guides Class */
class page
{
	public $table;
	public $db;
	public $area;

	function __construct($table, $DB_OBJECT, $area = '')
	{
		$this->db = $DB_OBJECT;
		if (empty($table)) die('Error -- Please enter a valid table name.');
		$this->table = $table;
		$this->area = $area ?: $table;
	}

	function show_list($orderBy = 'name', $constraint = '1=1')
	{
		// Attempt to use area-specific template if it exists, otherwise fallback to generic
		$template_start = '/content/guides/list_start_' . $this->area . '.inc';
		if (!file_exists(ROOT . $template_start)) $template_start = '/content/guides/list_start.inc';
		
		require(ROOT . $template_start);
		
		$query = $this->db->query('SELECT * FROM `' . $this->table . '` WHERE ' . $constraint . ' ORDER BY `' . $orderBy . '`');
		while ($info = $this->db->fetch_array($query)) {
			$this->render_list_row($info);
		}

		$template_end = '/content/guides/list_end_' . $this->area . '.inc';
		if (!file_exists(ROOT . $template_end)) $template_end = '/content/guides/list_end.inc';
		require(ROOT . $template_end);
	}

	protected function render_list_row($info)
	{
		// This can be overridden or use a default layout
		echo ' <tr align="center">' . NL;
		echo '  <td class="tablebottom"><a href="' . htmlspecialchars($_SERVER['SCRIPT_NAME']) . '?id=' . (int)$info['id'] . '">' . htmlspecialchars($info['name']) . '</a></td>' . NL;
		echo '  <td class="tablebottom">' . htmlspecialchars($info['type'] ?? '') . '</td>' . NL;
		echo '  <td class="tablebottom">' . htmlspecialchars($info['author'] ?? '') . '</td>' . NL;
		echo ' </tr>' . NL;
	}

	function show_page($id)
	{
		$id = (int)$id;
		$info = $this->db->fetch_row('SELECT * FROM `' . $this->table . '` WHERE `id` = ' . $id);
		if (!$info) {
			echo 'Error: Invalid ID.';
			return;
		}

		$template_start = '/content/guides/page_start_' . $this->area . '.inc';
		if (!file_exists(ROOT . $template_start)) $template_start = '/content/guides/page_start.inc';
		require(ROOT . $template_start);

		echo htmlspecialchars($info['name']);

		$template_mid = '/content/guides/page_mid_' . $this->area . '.inc';
		if (!file_exists(ROOT . $template_mid)) $template_mid = '/content/guides/page_mid.inc';
		require(ROOT . $template_mid);

		echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000"><u>Page</u>: ' . htmlspecialchars($info['name']) . '</td></tr>';
		echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">' . $info['text'] . '</td></tr>';
		echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Author: <b>' . htmlspecialchars($info['author']) . '</b></td>';

		$template_end = '/content/guides/page_end_' . $this->area . '.inc';
		if (!file_exists(ROOT . $template_end)) $template_end = '/content/guides/page_end.inc';
		require(ROOT . $template_end);
	}
}

?>
