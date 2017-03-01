<?php
class LoginController extends Controller{

	//show login view
	public function loginAction(){
		include CUR_VIEW_PATH . "login.html";
	}

	//check login
	public function signinAction(){

		//1,get the data 
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
        $captcha = trim($_POST['captcha']);
        
        //check captcha
        if (strtolower($captcha) != $_SESSION['captcha']){
        	$this->jump("index.php?p=admin&c=login&a=login","captcha is wrong");
        }

		//check data
		if ($username === "" || $password === ""){
			$this->jump("index.php?p=admin&c=login&a=login","userName and password should not be empty");
		}
        
		//security check for sql attacks and XSS attacks
		//include the functions
		include HELPER_PATH . "input.php";
		//call the function, because password has been encripted before executing sql, password does not need to XSS and single quote escape 
		$username = deepSpecialChars($username);
		$username = deepSlashes($username);
       

		//check username and password
		$adminModel = new AdminModel('admin');
		$userInfo = $adminModel->checkUser($username, $password);
		//var_dump($userInfo);
		if ($userInfo = $adminModel->checkUser($username, $password)) {
			//right
			//store user information :set session
			$_SESSION['admin'] = $userInfo;
			//jump
			$this->jump("index.php?p=admin&c=index&a=index","", 0);
		}else{
			//wrong
			$this->jump("index.php?p=admin&c=login&a=login","userName or password is wrong");
		}

	}

	//logout
	public function logoutAction(){
		//unset session
		unset($_SESSION['admin']);
		//distroy session
		session_destroy();
		$this->jump("index.php?p=admin&c=login&a=login", '',0);
	}

	//action:
	public function captchaAction(){
		//1,include the class
		$this->library("Captcha");
		//2,instantiate the object
		$captcha = new Captcha();
		//3,generate the captcha
		$captcha->generateCode();
		//4,store the captcha
		$_SESSION['captcha'] = $captcha->getCode();
	}
}