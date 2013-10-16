<?php
/**
 * Database model class to wrap the accessor function for the db
 */

namespace app\lib\database;

use app\config\Database;

use app\config;

class Database {
	
	/**
	 * This will be the mysql database composite
	 * @var mysqli
	 */
	private $mysql;
	
	/**
	 * This is the static singleton instance of the Database accessor object
	 * @var Database
	 */
	private static $instance; 
	
	public function __construct($mysql) {
		$this->mysql = $mysql;
	}
	
	/**
	 * singleton to invoke the creation of the mysql object and stick that into the database object
	 */
	public static function instance() {
		
		if (!static::$instance) {
			$config = \app\config\Database::newInstance();
			
			$mysql = new mysqli($config->$host, $config->$user, $config->$password, $config->$database);
			
			static::$instance = new Database($mysql);
		} 
		
		return static::$instance;
	}
	
	/**
	 * This is wrapper interface to query function in the underlying implmenetation for the db accessor 
	 * @param string $query
	 * @return mysqli_result
	 */
	public function query($query) {
		return $this->mysql->query($query);
	}
}