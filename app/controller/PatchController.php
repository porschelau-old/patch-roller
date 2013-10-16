<?php

/**
 * Class to contain all the actions related to the patches
 */
namespace app\controller;

use app\component\PatchManager;

use core\controller\BaseController as BaseController;
use app\lib\database\Database as Database;
use app\model\SchemaVersion as SchemaVersion;

class PatchController extends BaseController {
	
	/**
	 * Apply the patch to the database
	 * 
	 * @param arg0 - we look at the first parameter, if the parameter says all, 
	 * 		we will look for the last know patch and apply all the ones after that 
	 * 		patch sequentially
	 */
	public function apply() {
		
		//argument array
		$argv = $this->request->getArgv();
		
		if ($argv[0] == "all") {
			$lastVersion = SchemaVersion::findLatestVersion();
			
			$patches = PatchManager::getPatches();
			
			//check to see if the last version is the last element in the patch set
			//we will skip through the whole thing if that's true;
			if ($patches != null && count($patches) > 0) {
				$lastPatch = end($patches);
				
				//only proceed if the last element is not the same as the last patch or there is no latest version
				if ($lastVersion == null || strcmp($lastVersion->getPatchName(), $lastPatch->getName()) != 0) {
					
					//reset the iterator pointer
					reset($patches);
					
					//we won't start applying the patch until we know that get past the known good patch
					$applyEn = false;
					
					printf("Beginning patch process\n");
					
					$db = Database::instance();
					
					foreach($patches as $patch) {
						if ($lastVersion != null && strcmp($patch->getName(), $lastVersion->getPatchName()) == 0) {
							printf("Processing patch, name: %s - skipped\n", $patch->getName());
							continue;
							
						} else if ($lastVersion != null && $applyEn == false && strcmp($patch->getName(), $lastVersion->getPatchName()) == 0) {
							//unlatch the logic
							printf("Processing patch, name: %s - skipped\n", $patch->getName());
							$applyEn = true;
							continue;
							
						} else {
							printf("Processing patch, name: %s - apply schema\n", $patch->getName());
							$sql = $patch->read();
							$result = $db->queryMulti($sql);

							//write into the version storage
							$currentVersion = new SchemaVersion(array("patch_name" => $patch->getName()));
							$currentVersion->insert();
						}
					}
					
				} else {
					printf("Schema is up-to-date, last patch: %s\n", $lastVersion->getPatchName());
				}
			}
			
		}
		
	}
	
	public function drop() {
		
		//dump and recreate the database
		printf("Dropping the exsting database\n");
		$db = Database::instance();
		$db->dump(false);
		$db->create();
		$db->close();
		
	}
	
	/**
	 * API to create a new patch file in the system
	 */
	public function create() {
		
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