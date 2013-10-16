<?php
namespace app\model;

use app\lib\database\Database;

class SchemaVersion {
	
	/**
	 * Name of the patch in this version
	 * @var string
	 */
	private $data;
	
	public function __construct($data) {
		$this->data = $data;
	}
	
	/**
	 * API to find the latest version of the patch that was applied to the schema table
	 * We have embedded a schema table there in the taget db so we can do all the tracking
	 * by looking at the latest row on there.
	 * 
	 * @return SchemaVersion - we will send back the latest row if we have anything, null if we
	 * 		don't have anything
	 */
	public static function findLatestVersion() {
		$version = null;
		
		$db = Database::instance();
		
		//check for the empty database case
		$hasVersionTable = $db->query("SHOW TABLES LIKE 'schema_version'");
		
		//if we don't have version informat, we will just return null
		if ($hasVersionTable->num_rows == 0) {
			$version =  null;
			
		} else {
			$result = $db->query("SELECT * FROM `schema_version` ORDER BY `id` DESC LIMIT 0,1");
			
			if ($result->num_rows > 0) {
				//get the first result
				$data = $result->fetch_assoc();
				$version = new SchemaVersion($data);
				
			} else {
				$version = null;
			}
		}
		return $version;
	}
	
	/**
	 * Insert the schema version into the database
	 */
	public function insert() {
		
		$db = Database::instance();
		$result = $db->query("INSERT INTO `schema_version` (`patch_name`) VALUES ('".$this->data['patch_name']."')");
		
		if ($result === false){
			throw new DomainException("Cannot insert into the database");
		}
	}
	
	public function getPatchName() {
		return $this->data['patch_name'];
	}
}