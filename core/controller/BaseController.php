<?php

/**
 * base controller class that kind of define the based route which we run
 */
namespace core\controller;

class BaseController {

	/**
	 * This is the request token which will be passed by the dispatcher
	 * @var Request
	 */
	protected $request;
	
	public function __construct($request) {
		$this->request = $request;
	}
}