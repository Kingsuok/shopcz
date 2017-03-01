<?php
// core class for instantiating the object of the controller class and call the action
// in otherwords : dispatch
class Framework {
	
	public static function run(){
		
		self::init();
		self::autoload();// autoload() must be front of dispatch(), because the classes used by dispatch() must be first
		self::dispatch();

	}
	// initial : determine dirctories 
	private static function init(){
		define("DS", DIRECTORY_SEPARATOR);// define directory separator for windows and linux 
		define("ROOT", getcwd() . DS); // define the roor directory
		define("APP_PATH", ROOT . "application" . DS);
		define("FRAMEWORK_PATH", ROOT . "framework" . DS);
		define("PUBLIC_PATH", ROOT . "public" . DS);
		define("CONFIG_PATH", APP_PATH . "config" . DS);
		define("CONTROLLER_PATH", APP_PATH . "controllers" . DS);
		define("MODEL_PATH", APP_PATH . "models" . DS);
		define("VIEW_PATH", APP_PATH . "views" . DS);
		define("CORE_PATH", FRAMEWORK_PATH . "core" . DS);
		define("DB_PATH", FRAMEWORK_PATH . "databases" . DS);
		define("HELPER_PATH", FRAMEWORK_PATH . "helpers" . DS);
		define("LIB_PATH", FRAMEWORK_PATH . "libraries" . DS);
		define("UPLOAD_PATH", PUBLIC_PATH . "uploads" . DS);
		//index.php?p=admin&c=goods&a=add---back-end ->GoodController -> addAction
		
		define("PLATFORM", isset($_GET['p']) ? $_GET['p'] : "home");
		define("CUR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFORM . DS);
		define("CUR_VIEW_PATH", VIEW_PATH . PLATFORM . DS);

        // The name of class of the controller
		define("CONTROLLER", isset($_GET['c']) ? ucfirst($_GET['c']) : "Index");//ucfirst():Make a string's first character uppercase


		// the name of the view
		define("ACTION", isset($_GET['a']) ? $_GET['a'] : "index");

         /*
           load the common classes, 这些类一定会被用到，所以在init（）中直接引入
          */
		// load the base controller class, this is a parent class
		include CORE_PATH . "Controller.class.php";
		//load the base model class, this is a parent class
		include CORE_PATH . "Model.class.php";
		//load the tool class: mysqldb
		include DB_PATH . "Mysql.class.php";

		// creating a global variable to store the config of mysql
		$GLOBALS['config'] = include CONFIG_PATH . "config.php";
        
        //open session
        session_start();

	}

	// routor's dispatch : instantiate an object of controller and call the action method
	// index.php?p=admin&c=goods&a=add---back-end ->GoodController -> addAction
	private static function dispatch(){
		$controllerName = CONTROLLER . "Controller";
		$actionName = ACTION . "Action";
		// instantiate an object of controller
		$controller = new $controllerName();
		// call the method of the action
		$controller->$actionName();
	}

	//autoload classes for controllers and models
	// Notice: only for the classes in the file of controllers and the file of models
	// Notice: other classes can not be autoloaded using this 
	private static function autoload(){
		//spl_autoload_register(array(__class__,'load')); //the same function to the next sentence
		spl_autoload_register('self::load');// register the load() as autoload function
	}
	// controller : GoodController 
	// model : BrandModel
	public static function load($className){
		//GoodController: Controller
		if (substr($className, -10) == "Controller"){
			include CUR_CONTROLLER_PATH . "{$className}.class.php";
		}else if (substr($className, -5) == "Model"){
			include MODEL_PATH . "{$className}.class.php";
		}else{

		}
	}

	
}