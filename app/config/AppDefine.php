<?php
/**
 * 
 * constant wrapper class
 * 
 * @author jonlau
 *
 */
namespace app\config;

class AppDefine {

	public static $PATCH_PATH;
	
	public static function __static() {
		
		//configure the patch path
		self::$PATCH_PATH = ROOT_PATH.'/patches';
		
		return;
	}
}