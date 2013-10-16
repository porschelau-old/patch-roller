<?php
/**
 * This class is to capture the operations related to the patches
 */
namespace app\component;

use app\config\AppDefine;
use app\model\PatchFile;

class PatchManager {
	
	/**
	 * Interface to fetch all the patches from the patch directory
	 * and it will wrap the path and the file name into the path file object
	 * 
	 * ** scandir will sort the file, so as long as we name things correctly, this will work.
	 */
	public static function getPatches() {
		//scane the directory and get the file name in decending order
		$files = \scandir(AppDefine::$PATCH_PATH, 0);

		//use those files to form the patch data model and send it back to the user
		$patches = array();
		foreach ($files as $filename) {
			if (substr($filename, -4) == ".sql") {
				$patches[$filename] = new PatchFile(AppDefine::$PATCH_PATH, $filename);
			}
		} 
		
		return $patches;
	}
}