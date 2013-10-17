<?php
/**
 * Helper class to take on some of the query function 
 * 
 * @author jonlau
 *
 */
namespace app\model;

use app\lib\database\Database as Database;

class QueryHelper {
	
	/**
	 * Query the database and create a collection set based on the model class name
	 * @param string $daoName
	 * @param string $query
	 * @return QueryResultCollection - this is a collection set that contain the query result. It has an iterator interface 
	 * 		to make it easy for us to process the data
	 */
	public function query($daoName, $query) {
		
		$db = Database::instance();
		
		//overwrite the result variable with the result from another query
		$result = $db->query($query);
		
		return new QueryResultCollection($daoName, $result);
		
	}
}