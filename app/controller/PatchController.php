<?php

/**
 * Class to contain all the actions related to the patches
 */
namespace app\controller;

use core\controller\BaseController as BaseController;
use app\lib\database\Database as Database;

class PatchController extends BaseController {
	
	/**
	 * Apply the patch to the database
	 */
	public function apply() {
		
	}
	
	/**
	 * API to create a new patch file in the system
	 */
	public function create() {
		
		$db = Database::instance();
		
		var_dump($db->query("SELECT * FROM cake"));
	} 
	
	/**
	 * Clean up the resources used
	 * (non-PHPdoc)
	 * @see \core\controller\BaseController::cleanup()
	 */
	public function cleanup() {
		parent::cleanup();
		
		$db = Database::instance();
		$db->close();
		
	}
}