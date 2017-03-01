<?php
// base controller for all controllers to inherit
class Controller{

	// goto webpage to show the message
	public function jump($url, $message, $wait=3){
		if ($wait == 0){
			header("Location:$url");
			//die();// stop executing the belowing codes(becuse the last line has die(); this one can be avoided.
		}else{
			include CUR_VIEW_PATH . "message.html";// goto the message view
		}
		die();// this code is very important, because after executing the jump(), the following codes will be executed without the die();
	}

	//load class file, for captcha ....
	public function library($lib){
		$lib = ucfirst($lib);//the first character to be upper, 因为调用的是class，所以第一个字母大写，为了防止调用时误写成小写，这里提前处理一下
		include LIB_PATH . "{$lib}.class.php";
	}

	// include the gengeral functions in file of helpers
	public function helper($help){
		$help = lcfirst($help);//the first character to be lower, 因为调用的是函数，所以第一个字母小写，为了防止调用时误写成大写，这里提前处理一下
		include HELPER_PATH . "{$help}.class.php";
	} 
}