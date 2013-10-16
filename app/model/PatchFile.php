<?php
/**
 * Data model for the patch file
 * 
 * @author jonlau
 */

namespace app\model;

class PatchFile {
	
	/**
	 * This is the directory path for which the patch file exists
	 * @var string
	 */
	private $path;
	
	/**
	 * This is the file name for the path file
	 * @var string
	 */
	private $filename;
	
	public function __construct($path, $filename) {
		$this->path = $path;
		$this->filename = $filename;	
	}
	
	/**
	 * Read the file from disk and return the content as a string buffer
	 */
	public function read() {
		return file_get_contents($this->path."/".$this->filename);
	}
	
	public function getName() {
		return $this->filename;
	}
}