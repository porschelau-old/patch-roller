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
		$result = $db->query("SHOW TABLES LIKE 'schema_version'");
		
		//if we don't have version informat, we will just return null
		if ($result->num_rows == 0) {
			$version =  null;
			
		} else {
			
			//result will be a QueryResultCollection object
			$result2 = QueryHelper::query(__CLASS__, "SELECT * FROM `schema_version` ORDER BY `id` DESC LIMIT 0,1");
			
			if ($result2->length() > 0) {
				
				//get the current version object, we only expect one to return anyway
				$version = $result2->current();
				
			} else {
				$version = null;
			}
			
			//close the schema version result
			$result2->close();
		}
		
		//close the table existence check result
		$result->close();
		
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