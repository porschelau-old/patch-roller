<?php
/**
 * Class to model the user input data
 * 
 * @author jonlau
 *
 */
namespace core;

class Request {
	
	private $controller;
	private $action;
	private $argv;
	
	private $parameter;
	
	public function __construct($controller, $action, $argv) {
		$this->controller = $controller;
		$this->action = $action;
		$this->argv = $argv;
	}
	
	/**
	 * API to construct the request object based on the arguments we get from the command line
	 * 
	 * We also shift the array pointer here.
	 * 
	 * @example 
	 * php cliner.php patch create arg0 arg1
	 * 
	 * $this->request->getArgv() will map to {0: argv0, 1: argv1}
	 * 
	 * @param unknown $argv
	 * @throws RuntimeException
	 * @return Request
	 */
	public static function build($argv) {
		//this is a dispatcher class that will just parse the parameters and call the components
		$action = $argv[ARG_OFFSET-1];
		
		$controller = $argv[ARG_OFFSET-2];
		
		//load up the class and dispatch the action
		if ($controller == null) {
			throw new RuntimeException("Controller is null");
		}
		
		if ($action == null) {
			throw new RuntimeException("Action is null");
		}
		
		return new Request($controller, $action, array_slice($argv, ARG_OFFSET));
	}
	
	/**
	 * Getter interfaces
	 */
	public function getControllerName() {
		return $this->controller;
	}
	
	public function getControllerAction() { 
		return $this->action;
	}
	
	/**
	 * This interface will allow us to get the argument from the command line
	 */
	public function getArgv() {
		return $this->argv;
	}
}