<?php

require_once('api.base.inc.php');

//	Created by dTwizy
//	Don't make any changes without consulting dTwizy
//	http://forums.zybez.net/user/162695-dtwizy/

//	The top-level class for handling API actions
//	Add a new action by creating a protected function actionXXX() {}
//	where XXX is http://2007rshelp.com/api/XXX/search+term

class API extends APIBase
{
	protected function actionMonsters()
	{
		$cache_key = $this->actionSpecificCacheKey($this->sql_safe_query);
		$monsters = $this->cacheFetch($cache_key);
		
		//	Does not exist in the cache
		if(!$monsters)
		{
			$monsters = array();
			
			$db = $this->db;
			
			//	Create a separate where clause for each separate search term
			$sql_safe_keyword_clauses = array();
			foreach($this->sql_safe_keywords as $keyword)
				$sql_safe_keyword_clauses []= "(name LIKE '%".$keyword."%' OR keyword LIKE '%".$keyword."%')";
			$sql_safe_keyword_where_clause = implode(' AND ', $sql_safe_keyword_clauses);
			
			//	The image url that we concat the filename to, in order to get a full url
			$root_image_url = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/img/npcimg/';
			
			//	950 is a placeholder 'missing' monster
			$result = $db->query("SELECT * FROM monsters WHERE id != 950 AND ".$sql_safe_keyword_where_clause." ORDER BY name ASC LIMIT 50");
			
			while($row = $db->fetch_array($result))
			{
				$monster = array();
				
				$monster['id'] = $row['id'];
				$monster['name'] = $row['name'];
				$monster['combat'] = $row['combat'];
				$monster['hp'] = $row['hp'];
				$monster['race'] = $row['race'];
				$monster['members'] = $row['member'] == TRUE;
				$monster['aggressive'] = strtolower(substr($row['nature'], 0, 3)) != 'not';	//	"Aggressive"/"Not Aggressive" -> bool
				$monster['style'] = $row['attstyle'];
				$monster['examine'] = $row['examine'];
				$monster['locations'] = $this->htmlToString($row['locations']);
				$monster['top_drops'] = $this->htmlToString($row['i_drops']);
				$monster['drops'] = $this->htmlToString($row['drops']);
				$monster['tactic'] = $this->htmlToString($row['tactic']);
				$monster['notes'] = $this->htmlToString($row['notes']);
				$monster['credits'] = $this->htmlToString($row['credits']);
				
				//	Only add the image url if it has an image
				if($row['img'] != 'nopic.gif')
					$monster['image_url'] = $root_image_url.$row['img'];
				
				$this->removeNullValues($monster);
				
				$monsters []= $monster;
			}
			
			//	Save in the cache for faster lookups
			$this->cacheStore($cache_key, $monsters);
		}
		
		$this->response['monsters'] = $monsters;
	}
	protected function actionItems()
	{
		$cache_key = $this->actionSpecificCacheKey($this->sql_safe_query);
		$items = $this->cacheFetch($cache_key);
		
		//	Does not exist in the cache
		if(!$items)
		{
			$items = array();
			
			$db = $this->db;
			
			//	Create a separate where clause for each separate search term
			$sql_safe_keyword_clauses = array();
			foreach($this->sql_safe_keywords as $keyword)
				$sql_safe_keyword_clauses []= "(name LIKE '%".$keyword."%' OR keyword LIKE '%".$keyword."%')";
			$sql_safe_keyword_where_clause = implode(' AND ', $sql_safe_keyword_clauses);
			
			//	The image url that we concat the filename to, in order to get a full url
			$root_image_url = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/img/idbimg/';
			
			$result = $db->query("SELECT * FROM items WHERE ".$sql_safe_keyword_where_clause." ORDER BY name ASC LIMIT 50");
			
			while($row = $db->fetch_array($result))
			{
				$item = array();
				
				$item['id'] = $row['id'];
				$item['name'] = $row['name'];
				$item['members'] = $row['member'] == TRUE;
				$item['tradable'] = $row['trade'] == TRUE;
				$item['equipable'] = $row['equip'] == TRUE;
				$item['stackable'] = $row['stack'] == TRUE;
				$item['weight_kg'] = (($row['weight'] < 0) ? -1 : floatval($row['weight']));
				$item['quest'] = strtolower($row['quest']) != 'no';
				$item['examine'] = $row['examine'];
				$item['general_sell'] = intval($row['sellgen']);
				$item['general_buy'] = intval($row['buygen']);
				$item['alchemy_low'] = intval($row['lowalch']);
				$item['alchemy_high'] = intval($row['highalch']);
				$item['obtain'] = $this->htmlToString($row['obtain']);
				$item['notes'] = $this->htmlToString($row['notes']);
				$item['credits'] = $this->htmlToString($row['credits']);
				
				//	Item stats, format of "4|1|..."
				$stats_attack_raw = $row['att'];
				$stats_defence_raw = $row['def'];
				$stats_other_raw = $row['otherb'];
				
				//	Split them into an array
				$stats_attack = explode('|', $stats_attack_raw);
				$stats_defence = explode('|', $stats_defence_raw);
				$stats_other = explode('|', $stats_other_raw);
				
				//	If the stats exist, add stats to this item
				if(count($stats_attack) >= 5 && count($stats_defence) >= 5 && count($stats_other) >= 2)
				{
					$stats = array();
					$attack = array();
					$defence = array();
					$other = array();
					
					$attack['stab'] = intval($stats_attack[0]);
					$attack['slash'] = intval($stats_attack[1]);
					$attack['crush'] = intval($stats_attack[2]);
					$attack['magic'] = intval($stats_attack[3]);
					$attack['range'] = intval($stats_attack[4]);
					
					$defence['stab'] = intval($stats_defence[0]);
					$defence['slash'] = intval($stats_defence[1]);
					$defence['crush'] = intval($stats_defence[2]);
					$defence['magic'] = intval($stats_defence[3]);
					$defence['range'] = intval($stats_defence[4]);
					
					$other['strength'] = intval($stats_other[0]);
					$other['prayer'] = intval($stats_other[1]);
					
					$stats['attack'] = $attack;
					$stats['defence'] = $defence;
					$stats['other'] = $other;
					
					$item['stats'] = $stats;
				}
				
				//	Only add the image url if it has an image
				if($row['image'] != 'nopic.gif')
					$item['image_url'] = $root_image_url.$row['image'];
				
				$this->removeNullValues($item);
				
				$items []= $item;
			}
			
			//	Save in the cache for faster lookups
			$this->cacheStore($cache_key, $items);
		}
		
		$this->response['items'] = $items;
	}
	
	protected function actionItemImageUrls()
	{
		//	Used for getting image urls for every image,
		//	the SwiftKit app has it's own background-less version of each image based on Zybez image ids
		//	http://cdn.swiftkit.net/client/osrs_items/5600
		if($this->sql_safe_query == 'dtwizy_item_image_key_2014')
		{
			$db = $this->db;
			
			$result = $db->query("SELECT id, image FROM items WHERE image != 'nopic.gif' ORDER BY name ASC");
			
			$items = array();
			
			while($row = $db->fetch_array($result))
			{
				$item = array();
				
				$item['id'] = $row['id'];
				$item['img'] = $row['image'];
				
				$items []= $item;
			}
			
			$this->response['items'] = $items;
		}
	}
}
