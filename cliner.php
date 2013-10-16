<?php
/**
 * This is a command line tool that will help us manage the schema patches.
 * The goal is to store the patches in the patches folder and name them in a sortable way.
 * The script will then go through the patches in the system to make sure we have applied 
 * each and one of them on the database in the right order.
 * 
 * Format: 
 * 
 * php roller.php <component> <command> <parameters>
 * 
 */

define("ROOT_PATH", __DIR__);

require_once 'include/CoreDefine.php';

//include core helpers
require_once 'core/Core.php';

use core\Request as Request;
use core\Dispatcher as Dispatcher;

$request = Request::build($argv);

$dispatcher = Dispatcher::build($request);
$dispatcher->dispatch();