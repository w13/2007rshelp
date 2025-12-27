<?php
/*** CLASSES ***/

/* DB Class */
class db
{
	public $queries = 0;
	private $host = '';
	private $username = '';
	private $password = '';
	public $cache = '';
	public $connect;
	public $result;
	public $row;
	public $num_rows;
	public $select_db;
	public $disconnect;
	public $escape_string;
	public $database;

 function set_mysql_host($host = '')
  {
   $this->host = $host;
  }

 function set_mysql_user($user = '')
  {
   $this->username = $user;
  }

 function set_mysql_pass($pass = '')
  {
   $this->password = $pass;
  }

	// MySQLi implementation (converted for PHP 7/8 compatibility)

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
	public $default = 'darkblue.css';
	public $path = '';
	public $ROOT = '';

	// Pull files for use
	function get_file( $location )
	{
		ob_start();
		// Include template file - error suppression removed for PHP 8
		require( $this->ROOT . $location );
		$contents = ob_get_contents();
		ob_end_clean();

		return $contents;
	}

 // Construction Function
  function __construct( $DIR = '' , $root = '' )
  {
  $this->path = $DIR . '/css/';
  $this->ROOT = $root;
  }
  
 // Check the CCS file to use
 function use_css()
  {
   if(empty($_COOKIE['rshelpskin']))
    {
     if (!headers_sent()) {
       setcookie('rshelpskin' , $this->default , time() + 1200000, '/');
     }
     $css = $this->path.$this->default;
    }
    else
    {
     $css = $this->path.$_COOKIE['rshelpskin'];
    }
   return $css;
  }

	function title( $start , $end , $default ) {
		if		( $start != '' AND $end != '' ) $title = $end . ' - ' . $start . ' - ' . $default;
		elseif	( $start != '' AND $end == '' ) $title = $start . ' - ' . $default;
		elseif	( $start == '' AND $end != '' ) $title = $end . ' - ' . $default;
		else $title = $default . ' - OSRS RuneScape Help Editor';

		return $title;
	}
	
 function show_attn($check = 0)
  {
   if($check == 1)
    {
     ob_start();
     require(dirname(__FILE__).'/'.'content'.'/'.'attn.inc');
     $attn = ob_get_clean();
    }
   else
    {
     $attn = '';
    }
   return $attn;
  }

	function check_status() {
		// Check if site is in offline mode
		if (defined('OFFLINE') && OFFLINE == 1) {
			die( require( $this->ROOT . '/editor/content/offline.inc' ) );
		}
	}
}

/* Timer Class */
class timer 
{
 function startTimer() 
  {
   global $starttime;
   $mtime = microtime();
   $mtime = explode(' ' , $mtime);
   $mtime = $mtime[1] + $mtime[0];
   $starttime = $mtime;
  }
  
 function endTimer()
  {
   global $starttime; 
   $mtime = microtime();
   $mtime = explode(' ' , $mtime);
   $mtime = $mtime[1] + $mtime[0];
   $endtime = $mtime;
   $totaltime = round(($endtime - $starttime) , 5);
   return $totaltime;
  }
  
 function showLoad()
  {
   $loadavg_array = explode(' ' , exec('cat /proc/loadavg'));
   return $loadavg_array[2];
  }
}

/* Login Session Class */
class ses {

	public $user = '';                    // Holder for username.
	public $userid = 0;                   // Holder for the users' identification number.
	public $perm = 1;                     // Holder for user permissions.
	public $logged_in = false;            // TRUE if user is logged in.

	private $db;                          // So we can use the DB class.
	public $expire_time = 10800;          // Maximum amount of allowed inactivity - seconds.
	public $login_error = '';             // Holder for login errors

    // Construction Function
    function __construct($db) {
            $this->db = $db;                    // So we can use the DB class.
            ini_set("session.gc_maxlifetime","10800");
            session_start();                    // Start the SESSION.
            $this->check_all();                    // Check SESSION AND COOKIE
            $this->session_setup();                // Finish Configuring the SESSION.
    }
    
    // Session Setup Function
    function session_setup() {

        $_SESSION['logged_in'] = $this->logged_in;    // Set the logged in SESSION variable.
        $_SESSION['user'] = $this->user;            // Set the user SESSION variable.
        $_SESSION['userid'] = $this->userid;        // Set the userid SESSION variable.
        $_SESSION['perm'] = $this->perm;            // Set the permission SESSION variable.
    }
    
    // All Login Entries Check Function
    function check_all() {
        $session = $this->check_session();        // Check SESSION.
        $cookie = $this->check_cookie();        // Check COOKIE.
        
        if($session AND $cookie) {            // If SESSION and COOKIE are true.
            $this->logged_in = true;                // Show that the user is logged in.
            $this->user = $_SESSION['user'];        // Set the user.
            $this->userid = $_SESSION['userid'];    // Set the userid.
            $this->perm = $_SESSION['perm'];        // Set the permissisons.
        }
        elseif($session AND !$cookie) {        // If COOKIE is false / expired - Login Error
            $this->login_error = 'No activity for '.$this->expire_time.' seconds.';
         }
        else {                                    // If another error happens - Login Error
            $this->login_error = 'You have not logged in.';
        }
        return;
    }

    // Login SESSION Check Function
    function check_session() {
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {    // If SESSION logged in variable is true.
            return true;                // Return function true.
        }
        else {                            // If SESSION logged in variable is false.
            return false;                // Return function false.
        }
    }

    // Login COOKIE Check Function
    function check_cookie() {
        if(isset($_COOKIE['logged_in']) && $_COOKIE['logged_in']) {   // If COOKIE has not expired.
            $this->cookie_set();        // Reset the cookie expiry time.
            return true;                   // Return function true.
        }
        else {                            // IF COOKIE has expired.
            return false;                // Return function false.
        }
    }
    
    // Login Function
    function login($user, $pass) {
    
        $valid_login = $this->check_info($user, $pass);
        
        if($valid_login == true) {            // Continue only if info is valid.
        
            $this->cookie_set();                // Set the session timeout COOKIE.
            $this->logged_in = true;            // Set SESSION info to Logged in.
            $this->set_lastlog();                // Set the time for this login.
            $this->set_lastip();                // Set the last login IP- ben apr 20.
            $this->session_setup();                // Re-setup the session with login information.
        }
        return;
    }

    // Check Login Information Function
    function check_info($user, $pass) {
        global $db;                                // So we can use the DB class.
        $en_pass = md5($pass);                // Encode the password.

		
        if(!preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/' , $user)) { /* if non-valid username is used, we know this is mySQL injection attempt. We log it. */
            $floginvar = '1';
            $file = 'extras/failedlogins.html';
            $record = "<tr><td class=\"tablebottom\">".$floginvar."</td><td class=\"tablebottom\">".$user."</td><td class=\"tablebottom\">".$_SERVER['REMOTE_ADDR']."</td><td class=\"tablebottom\">".date("D M d Y")." at ".date("g:i:s:A")."</td></tr>".NL;	
              $handle = fopen( $file, 'a' );
              fwrite( $handle, $record );
              fclose( $handle );
              $this->login_error = '<b>Incorrect Username or Password.</b>';
              return false;
        }
        else {
        // Check for username and password matches
        
		 $query = $db->query("SELECT * FROM admin WHERE user = '".$db->escape_string($user)."' AND pass = '".$db->escape_string($en_pass)."'"); // Security Fix
		 $check = $db->num_rows("SELECT * FROM admin WHERE user = '".$db->escape_string($user)."' AND pass = '".$db->escape_string($en_pass)."'"); // Security Fix


		 /* diagnosing this bug... 
		echo 'check: ' . $check;
		echo 'query: <textarea>';
		echo "SELECT * FROM admin WHERE user = '".addslashes($user)."' AND pass = '".$en_pass."'";
		echo '</textarea>';
*/
		
		
        if($check == 1) {                        // Continue if only ONE match.
            $info = $db->fetch_array($query);    // Get the information from the query.
            $this->user = $info['user'];        // Determine the user.
            $this->userid = $info['id'];        // Determine the userid.
            $this->perm = $info['perm'];        // Determine the permissions.
            return true;                        // If match exists, function return true.
        }
        else {
          $this->login_error = '<b>Incorrect Username or Password.</b>';
          $floginvar = '0';
          $file = 'extras/failedlogins.html';
          $record = "<tr><td class=\"tablebottom\">".$floginvar."</td><td class=\"tablebottom\">".$user."</td><td class=\"tablebottom\">".$_SERVER['REMOTE_ADDR']."</td><td class=\"tablebottom\">".date("D M d Y")." at ".date("g:i:s:A")."</td></tr>".NL;	
            $handle = fopen( $file, 'a' );
            fwrite( $handle, $record );
            fclose( $handle );

            return false;                        // If no match exists, function return false.
        }

      }
   }


    // Login Time Function
    function set_lastlog() {
        global $db;
        
        $time = gmt_time();
        $user = $this->user;
        $db->query("UPDATE admin SET last = ".$time." WHERE user = '".$user."'");
        return;
    }
    // Login IP function-Ben added apr 20.
    function set_lastip() {
        global $db;
        
        $lastip = $_SERVER["REMOTE_ADDR"];
        $user = $this->user;
        $db->query("UPDATE admin SET last_ip = '".$lastip."' WHERE user = '".$user."'");
        return;
    }
    // Custom COOKIE set Function
    function cookie_set() {
        setcookie('logged_in', true, time() + $this->expire_time);
        return;
    }

    // Custom COOKIE unset Function
    function cookie_unset() {
        setcookie('logged_in', false, time() - 1);
        return;
    }

    // Print Login Form Function
    function login_form($use_css) {
        
        ob_start();
        require('content/login.inc');
        $content = ob_get_clean();
        
        $action = $_SERVER['SCRIPT_NAME'].'?'.$_SERVER['QUERY_STRING'];
        
        $content = str_replace('[#CSS#]'        , $use_css                , $content);
        $content = str_replace('[#ERROR#]'        , $this->login_error    , $content);
        $content = str_replace('[#ACTION#]'    , $action                , $content);
        $content = str_replace('[#POSTTXT#]'    , rpostcontent('', true)        , $content);
        return $content;
    }
    
    // Check Permission Function
    function permit($page_perm, $total_perm = 0) {
    
        if(empty($total_perm)) {
            $total_perm = $this->perm;
        }
        
        if(($total_perm & pow(2 , $page_perm)) == pow(2 , $page_perm)) {
            return true;
        }
        else {
            return false;
        }
    }

    // Print No Permission Page Function
    function nopermit($use_css, $ses) {
    
        ob_start();
        require('content/noperm.inc');
        $content = ob_get_clean();

        ob_start();
        require('content/links.inc');
        $links = ob_get_clean();

        $content = str_replace('[#CSS#]'        , $use_css        , $content);
        $content = str_replace('[#LINKS#]'        , $links        , $content);
        $content = str_replace('[#CORRECTION#]', num_correct()    , $content);

        return $content;
    }

    // Record Actions Funtion
    function record_act($area, $action, $name, $ip) { //ben: ip
        global $db;
        
        $name = $db->escape_string($name);
        $area = $db->escape_string($area);
        $action = $db->escape_string($action);
	  
        $userid = intval($this->userid);
		
		$info = $db->query("SELECT `groups` FROM `admin` WHERE id = ". $userid . ""); //Ben
		$ip1 = explode(".", $_SERVER["REMOTE_ADDR"], 3);
        $ip2 = $ip1[0] . "." . $ip1[1] . ".*.*";
		while($vip = $db->fetch_array($info))
		{
		if ( $vip['groups'] == 1 ) { //ben
		$db->query("INSERT INTO admin_logs (userid, area, action, name, time, ip) VALUES ('".$userid."', '".$area."', '".$action."', '".$name."', '".gmt_time()."', '". $ip2 ."')"); //ben
		}
		else {
		$db->query("INSERT INTO admin_logs (userid, area, action, name, time, ip) VALUES ('".$userid."', '".$area."', '".$action."', '".$name."', '".gmt_time()."', '".$db->escape_string($_SERVER['REMOTE_ADDR'])."')"); //ben: remote addr/ip
		}
		}
        return;
    }
    
    // Logout Function
    function logout() {

        $this->cookie_unset(); // Make the COOKIE expire.
        $_SESSION = array();   // Clear out SESSION data.
        session_destroy();        // Destroy the SESSION.    
        return;                    
    }

    
}
        
?>