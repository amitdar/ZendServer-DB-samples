<?php
error_reporting(E_ALL);
require_once 'LogEntriesTrigger.php';
define('USER_MODE', 1);
define('AUTO_MODE', 2);
class Router
{

	private $mode;
	private $logEnt;

	public function __construct()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'GET' && empty($_SERVER['QUERY_STRING']))
			$this->setMode(USER_MODE);
		else
			$this->setMode(AUTO_MODE);

		$this->setLogEnt(new LogEntriesTrigger());
		$this->processRequst();
	}

	public function getMode()
	{
		return $this->mode;
	}

	public function setMode($mode)
	{
		$this->mode = $mode;
	}
	
	public function getLogEnt() {
		return $this->logEnt;
	}
	
	public function setLogEnt($logEnt) {
		$this->logEnt = $logEnt;
	}

	public function processRequst()
	{
		switch ($this->getMode()) {
			case USER_MODE:
				$this->userReq();
				break;
			case AUTO_MODE:
				$this->autoReq();
				break;
		}
	}

	protected function userReq()
	{
		

	}

	protected function autoReq()
	{
		$funcsArr = (array)json_decode(urldecode($_SERVER['QUERY_STRING']));
		foreach ($funcsArr as $foo => $params){
			call_user_func_array(array($this->getLogEnt(),$foo), explode(",", $params));
		}
	}
}

$r = new Router();