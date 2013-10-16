<?php
/**
 * Database configuration encapsulation
 * 
 * @author jonlau
 *
 */

namespace app\config;

class Database {
	
	public $host;
	public $db;
	public $user;
	public $password;
	
	/**
	 * Generate the databae configuration as a token
	 * @return \app\config\Database
	 */
	public static function newInstance() {
		$db = new Database();
		$db->host = "localhost";
		$db->db = "test";
		$db->user = "root";
		$db->password = "jaclyn0530";
		return $db;
	}
}