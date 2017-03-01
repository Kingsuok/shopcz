<?php
/**
 * function:check whether admin login or or
 */
class BaseController extends Controller{
	public function __construct(){
		$this->checkLogin();
	}
	private function checkLogin(){
		if (! isset($_SESSION['admin'])) {
			$this->jump("index.php?p=admin&c=login&a=login","please login first");
		}
	}
}