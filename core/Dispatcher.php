<?php
/**
 * Helper class for translating the paths and help with things 
 * related to dispatching the controllers
 */
class Dispatcher {
	
	private $request;
	
	private $controllerPath;
	private $controllerName;
	private $controllerAction;
	private $action;
	
	public function __construct($request, $controllerName, $controllerPath) {
		$this->request = $request;
		$this->controllerName = $controllerName;
		$this->controllerPath = $controllerPath;
		$this->controllerAction = $request->getControllerAction();
	}
	
	/**
	 * Create a dispatcher object based on the controller name from the request object
	 * @param Request $request
	 * @return Dispatcher
	 */
	public static function build(Request $request) {
		
		//request object contains the controller name with out the key postfix Controller
		//e.g. PatchController - the request object will return "patch"
		
		$name = ucfirst($request->getControllerName())."Controller";
		
		$controllerPath = ROOT_PATH."/app/controller/".$name.".php";
		return new Dispatcher($request, $name, $controllerPath);
	}
	
	/**
	 * Invoke the controller indicated from the path and run the code base
	 */
	public function dispatch() {
		//require the file indicated in the controller path
		require_once $this->controllerPath;
		
		$subject = new $this->controllerName($this->request);
		$subject->{$this->controllerAction}();
	}
	
}