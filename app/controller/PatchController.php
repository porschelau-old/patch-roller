<?php

/**
 * Class to contain all the actions related to the patches
 */
namespace app\controller;

use core\controller\BaseController as BaseController;

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
		
		var_dump($this->request->getArgv());
	} 
}