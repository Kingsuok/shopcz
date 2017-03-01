<?php
// default controller 
class IndexController extends BaseController{
	// default action
	public function indexAction(){
		//load the view html
		include CUR_VIEW_PATH . "index.html";
	}

	//
	public function topAction(){
		include CUR_VIEW_PATH . "top.html";
	}

	//    	     
	public function menuAction(){
		include CUR_VIEW_PATH . "menu.html";
	}
	  
	 //   	     
	public function dragAction(){
		include CUR_VIEW_PATH . "drag.html";
	}
	
	//
	public function mainAction(){
		//instantiate a admin model
		//$adminModel = new AdminModel('admin');
		//$admins = $adminModel->getAdmins();
		//echo "<pre>";
		//var_dump($admins);
        
		include CUR_VIEW_PATH . "main.html";
	}

	// captcha 
	public function codeAction(){
		//load the captcha class
		$this->library("Captcha");
		//instantiate an object of captcha
		$captcha = new Captcha();
		// call the method to generate the captcha
		$captcha->generateCode();  
	}

}
