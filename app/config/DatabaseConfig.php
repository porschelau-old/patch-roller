<?php
/**
 * Database configuration encapsulation
 * 
 * @author jonlau
 *
 */

namespace app\config;

class DatabaseConfig {
	
	public $host;
	public $database;
	public $user;
	public $password;
	
	/**
	 * Generate the databae configuration as a token
	 * @return \app\config\DatabaseConfig
	 */
	public static function newInstance() {
		$db = new DatabaseConfig();
		$db->host = "localhost";
		$db->database = "patch_test";
		$db->user = "root";
		$db->password = "jaclyn0530";
		return $db;
	}
}