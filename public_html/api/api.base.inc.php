<?php

require_once('../backend.php');

//	Created by dTwizy
//	Don't make any changes without consulting dTwizy
//	http://forums.zybez.net/user/162695-dtwizy/

//	The base class for anything API related
//	This handles the API on an abstract level,
//	it should be customized at a sub-class level only

abstract class APIBase
{
	private $action;
	private $query;
	private $cache_prefix = 'api.cache.';
	
	protected $sql_safe_query;
	protected $sql_safe_keywords;
	protected $response = array();
	
	private $db;
	
	public function __construct()
	{
		//	Extract input parameters
		if(isset($_GET['api_action']))
			$this->action = $_GET['api_action'];
		
		if(isset($_GET['api_query']))
			$this->query = $_GET['api_query'];
		
		$this->sql_safe_query = $this->sanitizedSqlString($this->query);
		
		//	Validate required fields
		if(!$this->action)
			$this->errorAndDie('api_action is required');
		
		if(!$this->sql_safe_query)
			$this->errorAndDie('api_query is required');
		
		//	Keywords = stripped of commas and split by spaces
		$this->sql_safe_keywords = explode(' ', str_replace(',', '', $this->sql_safe_query));
	}
	
	public function __get($name)
	{
		//	Lazy loaded db (loaded on request)
		if($name == 'db' && !$this->db)
			$this->initDb();
		
		return $this->$name;
	}
	
	public function __destruct()
	{
		//	Cleanup any mess
		if($this->db)
			$this->db->disconnect();
	}
	
	//----------------------------
	
	public function run()
	{
		//	Function = actionXXX();
		$function = 'action'.$this->action;
		
		//	Run the function if it exists, otherwise error
		if(method_exists($this, $function))
		{
			$this->$function();
			$this->outputAndDie();
		}
		else
		{
			$this->errorAndDie('Unknown action '.$this->action);
		}
	}
	
	protected function htmlToString($html)
	{
		//	Strips useless newlines and converts <br/> to new lines
		$find = array('/\r|\n/', '/<\s*br\s*\/?\s*>/');
		$replace = array('', "\n");
		
		return strip_tags(trim(preg_replace($find, $replace, $html)));
	}
	
	protected function sanitizedSqlString($string, $length = 40)
	{
		global $disp;
		
		$key = 'sql_string';
		$result = $disp->cleanVars(array(array($key, $string, 'sql', 'l' => $length)));
		return $result[$key];
	}
	
	protected function removeNullValues(&$array)
	{
		foreach($array as $key => $value)
		{
			if($value === NULL)
				unset($array[$key]);
		}
	}
	
	protected function actionSpecificCacheKey($key)
	{
		//	Individual cache per API action (separate cache for monsters, items etc etc)
		//	final key something such as "api.cache.monsters.dragon"
		return $this->action.'.'.$key;
	}
	
	protected function cacheStore($key, $object)
	{
		$cache_time = 3600;	//	1hr cache
		if (function_exists('apcu_store')) {
			apcu_store($this->cache_prefix.$key, $object, $cache_time);
		} elseif (function_exists('apc_store')) {
			apc_store($this->cache_prefix.$key, $object, $cache_time);
		}
	}
	
	protected function cacheFetch($key)
	{
		if (function_exists('apcu_fetch')) {
			return apcu_fetch($this->cache_prefix.$key);
		} elseif (function_exists('apc_fetch')) {
			return apc_fetch($this->cache_prefix.$key);
		}
		return false;
	}
	
	protected function errorAndDie($error)
	{
		$this->response['error'] = $error;
		$this->outputAndDie();
	}
	
	//	Private functions
	//----------------------------
	
	private function outputAndDie()
	{
		header('Cache-Control: no-cache');
		header('Pragma: no-cache');
		header('Content-Type: application/json');
		
		//	Clean anything else that may have been echoed
		@ob_end_clean();
		
		//	Gzip enabled response...
		ob_start('ob_gzhandler');
		
		echo json_encode($this->response);
		exit;
	}
	
	private function initDb()
	{
		global $db;	//	from backend.php
		$db->connect();
		$db->select_db(MYSQL_DB);
		$this->db = $db;
	}
}
