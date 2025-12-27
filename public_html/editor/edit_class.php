<?php

class edit {

	public $db;
	public $table = '';
	
	public $update_arr = array();
	public $new_arr = array();
	public $delete_arr = array();
	
	public $no_errors = true;
	public $error_mess = '';
	
	function __construct( $table, $db ) {
		$this->table = $table;
		$this->db = $db;
	}

	function add_update( $id, $field, $entry, $error_mess = '' , $req = true ) {
		$entry = ltrim( $entry, "0" );
		$entry = addslashes( stripslashes( $entry ) );
		$entry = str_replace('&runescape','&amp;runescape',$entry);
		if( empty( $id ) OR empty( $field ) OR !is_int( $id ) OR ( $req AND empty( $entry ) ) ) {
			$this->do_error( $error_mess );
		}
		$update_arr = $this->update_arr;
		$update_arr[$id][$field] = $entry;
		$this->update_arr = $update_arr;
		return stripslashes( $entry );
	}
	
	function add_new( $update_num, $field, $entry, $error_mess = '', $req = true ) {
		$entry = ltrim( $entry, "0" );
		$entry = addslashes( stripslashes( $entry ) );
		if( empty( $update_num ) OR empty( $field ) OR !is_int( $update_num ) OR ( $req AND empty( $entry ) ) ) {
			$this->do_error( $error_mess );
		}
		$new_arr = $this->new_arr;
		$new_arr[$update_num][$field] = $entry;
		$this->new_arr = $new_arr;
		return stripslashes( $entry );
	}

	function add_delete( $id ) {
	
		if( empty( $id ) ) {
			$this->do_error( 'Identification number was not specified correctly.' );
		}
		$delete_arr = $this->delete_arr;
		
		if( empty( $delete_arr ) ) {
			$next = 1;
		} 
		else {
			$next = max( array_keys( $delete_arr ) ) + 1;
		}
		$delete_arr[$next] = intval( $id );
		$this->delete_arr = $delete_arr;
		return;
	}
	
	function run_all( $time_upd = false, $time_new = false ) {

		if( $this->no_errors ) {
			$this->run_update( $time_upd );
			$this->run_new( $time_new );
			$this->run_delete();
			$this->clear_arrs();
			return true;
		}
		else {
			return false;
		}
	}

	function run_update( $use_time = false ) {
		global $db;
		
		$update_arr = $this->update_arr;
		
		foreach( $update_arr AS $id => $field_arr ) {

			$id = intval( $id );
			$first = true;
				
			foreach( $field_arr AS $field => $value ) {
				if( $first ) {
					$sets = $field . " = '" . $value . "'";
					$first = false;
				}
				else {
					$sets = $sets . ", " . $field . " = '" . $value . "'";
				}
			}
			if( $use_time ) {
				$sets = $sets . ", time = " . gmt_time();
			}
			if( !empty( $sets ) ) {
				$db->query( "UPDATE " . $this->table . " SET " . $sets . " WHERE id = " . $id );

        header( 'refresh: 1; url=' . htmlspecialchars($_SERVER['SCRIPT_NAME']) );
/*
## Caching

	$url = htmlspecialchars($_SERVER['PHP_SELF']);		
  $ignore = array('/editor/fact.php','/editor/ticker.php','/editor/applications.php','/editor/news.php');
    if(!in_array($url, $ignore) && !isset($_POST['item_id'])) { ## Ignore SEO title
      //$shops = "SELECT shop_name FROM ".$this->table." WHERE id = ".$id;
      $normal = "SELECT name FROM ".$this->table." WHERE id = ".$id;
      // Get first result from query (mysql_result replaced with mysqli equivalent)
      $result = $db->query($normal);
      $row = mysqli_fetch_row($result);
      $seoname = $row[0];
      $seotitle = strtolower(preg_replace("/[^A-Za-z0-9_&.]/", "", '&runescape_'.$seoname.'.htm'));
    }
    if($url == "/editor/scam.php") {
    $id = "?scam=" . $id;
    }
    elseif(in_array($url, array("/editor/concepts.php","/editor/screenshots.php","/editor/blog.php"))) {
    $id = "?type=". $_GET['cat'] ."&id=". $id;
    }
    else {
    $id = "?id=" . $id;
    }
	$this->table = htmlspecialchars($_SERVER['PHP_SELF']) == "/editor/scam.php" ? "priceguide" : $this->table;
  cache($this->table, $id, $seotitle);
  */
			}
		}
		
	}
	
	function run_new( $use_time = false ) {
		global $db;

		$new_arr = $this->new_arr;
		
		foreach( $new_arr AS $update_num => $field_arr ) {
			$first = true;
			
			foreach( $field_arr AS $field => $value ) {
				
				if( $first ) {
					$field_str = $field;
					$value_str = "'" . $value . "'";
					$first = false;
				}
				else { 
					$field_str = $field_str . ", " . $field;
					$value_str = $value_str . ", '" . $value . "'";
				}
			}
			if( $use_time ) {
				$field_str = $field_str . ", time";
				$value_str = $value_str . ", '" . gmt_time() . "'";
			}
			if( !empty( $field_str ) AND !empty( $value_str ) ) {
				$db->query( "INSERT INTO " . $this->table . " (" . $field_str . ") VALUES (" . $value_str . ")" );
        header( 'refresh: 1; url=' . htmlspecialchars($_SERVER['PHP_SELF']) );
	/*			
## CACHING
	$url = htmlspecialchars($_SERVER['PHP_SELF']);
	$ignore = array('/editor/quests.php','/editor/shop.php','/editor/applications.php');
	if(!in_array($url, $ignore)) {
	
	$misc = array("/editor/concepts.php","/editor/screenshots.php","/editor/blog.php");
	if(in_array($url, $misc)) {
	$id = '?type='.$_GET['cat'];
	}
	else {
	$id ='';
	}
  $seotitle = '';
  cache($this->table, $id, $seotitle);
  }
  */
			}
		}
		return;
	}	
	
	function run_delete() {
		global $db;

		$delete_arr = $this->delete_arr;
		$first = true;

		foreach( $delete_arr AS $id ) {
			
			if( $first ) {
				$wheres = " id = " . $id;
				$first = false;
			}
			else {
				$wheres = $wheres . " OR id = " . $id;
			}
		}
		if( !empty( $wheres ) ) {
			$db->query( "DELETE FROM " . $this->table . " WHERE " . $wheres );
			$db->query( "DELETE FROM corrections WHERE cor_table = '" . $this->table . "' AND cor_" . substr($wheres,1) ); // To delete correction
			header( 'refresh: 1; url=' . htmlspecialchars($_SERVER['PHP_SELF']) );
/*
## CACHING
	$url = htmlspecialchars($_SERVER['PHP_SELF']);
	$ignore = array('/editor/quests.php','/editor/shop.php','/editor/videos.php','/editor/applications.php');
	if(!in_array($url, $ignore)) {
	
	$misc = array("/editor/concepts.php","/editor/screenshots.php","/editor/blog.php");
	if(in_array($url, $misc)) {
	$id = '?type='.$_GET['cat'];
	}
	else {
	$id ='';
	}
  $seotitle = '';
  cache($this->table, $id, $seotitle);
  }*/
  
		}
		return;
	}
	
	function do_error( $error = '' ) {
	
		$this->no_errors = false;
		$this->error_mess .= ' ' . $error;
		return;
	}
	
	function clear_arrs() {
	
		$this->update_arr = array();
		$this->new_arr = array();
		$this->delete_arr = array();
		return;
	}



	/* OTHER FUNCTIONS */
	
	function check_2pass( $pass1 = '', $pass2 = '' ) {

		$len = strlen( $pass1 );
		
		if( $pass1 != $pass2 ) {
			$this->do_error( 'Your passwords did not match.' );
			return false;
		}
		elseif( $len < 5 OR $len > 12 ) {
			$this->do_error( 'Your password must be between 5 and 12 characters long.' );
			return false;
		}
		else {
			return true;
		}
	}
	
}

?>
