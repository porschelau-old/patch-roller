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
	 * This is the database configuration object
	 * @var DatabaseConfig
	 */
	private $config;
	
	/**
	 * This is the static singleton instance of the Database accessor object
	 * @var Database
	 */
	private static $instance; 
	
	public function __construct($mysql, $config) {
		$this->mysql = $mysql;
		$this->config = $config;
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
			
			static::$instance = new Database($mysql, $config);
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
	 * This is wrapper interface to query function in the underlying implmenetation for the db accessor.
	 * 
	 * ** This API will allow multi query
	 * 
	 * We need to flush the multi query result or the mysqli will block the next batch of queries
	 * 
	 * @link http://www.php.net/manual/en/mysqli.multi-query.php
	 * 
	 * @param string $query
	 * @return mysqli_result - this is assumed have the Traversable interface
	 *
	 */
	public function queryMulti($query) {
		$results = $this->mysql->multi_query($query);
		if ($results === false) {
			throw new \DomainException("Database is not processing the query, result: $results, error msg: (" . $this->mysql->error . "), query: $query");
		} else if ($results === true) {
			//this is to flush the result from the multi query returns
			while ($result = $this->mysql->next_result()) {
				//var_dump($result);
			}
			return null;
		} else {
			return null;
		}
		
	}
	
	/**
	 * This is wrapper interface to query function in the underlying implmenetation for the db accessor.
	 * 
	 * ** This API will not allow multi query
	 * 
	 * @param string $query
	 * @return mysqli_result - this is assumed have the Traversable interface
	 * 
	 * @link http://www.php.net/manual/en/class.mysqli-result.php
	 */
	public function query($query) {
		$result = $this->mysql->query($query);
		if ($result === false) {
			throw new \DomainException("Database is not processing the query, error msg: (".$this->getError(). "), query: $query");
		}
		return $result;
	}
	
	
	/**
	 * Get the error related to the recent function call
	 * 
	 * @link http://www.php.net/manual/en/mysqli.errno.php
	 * @link http://docs.camlcity.org/docs/godisrc/ocaml-mysql-1.0.4.tar.gz/ocaml-mysql-1.0.4/etc/mysqld_error.txt
	 */
	public function getError() {
		return $this->mysql->error;
	}
	
	/**
	 * Interface to drop all the tables from the db.
	 * 
	 * We have 2 approaches: 
	 * 1. if we have keepDb set to true, we will keep the db and just drop all the tables.
	 * 2. if we have keepDb set to false, we will drop the database and recreate it.
	 */
	public function dump($keepDb = true) {
		if ($keepDb == true) {
			$results = $this->mysql->query("SHOW TABLES");
			
			while ($table = $results->fetch_array()) {
				$tableName = $table[0];
				$query = "DROP TABLE IF EXISTS `$tableName`";
				$r = $this->query($query);
			}
			
			$results->free();
			
		} else {
			$query = "DROP DATABASE IF EXISTS `".$this->config->database."`";
			$r = $this->query($query);
		}
	}
	
	public function create() {
		$query = "CREATE DATABASE `".$this->config->database."`";
		$r = $this->query($query);
	}
	
}