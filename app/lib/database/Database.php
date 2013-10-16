<?php
/**
 * Database model class to wrap the accessor function for the db
 */

namespace app\lib\database;

use app\config;
use app\config\DatabaseConfig as DatabaseConfig;


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
	 * 
	 * @return Database this is the new / exsting db instance 
	 */
	public static function instance() {
		
		if (!static::$instance) {
			$config = DatabaseConfig::newInstance();
			
			$mysql = new \mysqli($config->host, $config->user, $config->password, $config->database);
			
			if ($mysql->connect_errno) {
				throw new \Exception("Connect failed: ".$mysql->connect_error."\n");
			}
			
			static::$instance = new Database($mysql);
		} 
		
		return static::$instance;
	}
	
	/**
	 * Interface to close the connection to the db
	 */
	public function close() {
		$this->mysql->close();
		static::$instance = null;
	}
	
	/**
	 * This is wrapper interface to query function in the underlying implmenetation for the db accessor 
	 * @param string $query
	 * @return mysqli_result - this is assumed have the Traversable interface
	 * 
	 * @link http://www.php.net/manual/en/class.mysqli-result.php
	 */
	public function query($query) {
		return $this->mysql->query($query);
	}
}