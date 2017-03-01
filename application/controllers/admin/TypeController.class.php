<?php
class TypeController extends BaseController{
	private $typeModel = null;
	public function __construct(){
		//execute the parent construct
		parent::__construct();

		//instantiate an object of typemodel
		$this->typeModel = new TypeModel('goods_type');
	}


	public function addAction(){

		include CUR_VIEW_PATH . "goods_type_add.html";
	}

	public function insertAction(){
		//get the data
		$url = "index.php?p=admin&c=type&a=add";
		$data = $this->getFormData($url);

		//insert data to database
		$typeModel = $this->typeModel;
		if ($typeModel->insert($data)){

			$this->jump("index.php?p=admin&c=type&a=index", "upload success", 1);
		}else{
			$this->jump("index.php?p=admin&c=type&a=add", "upload fail");
		}
	}

	public function indexAction(){
		/* no paging
		//get data from database
		$typeModel = $this->typeModel;
		$types = $typeModel->getTypes();
        */
       
		//paging
		//(1),get data of the special page
		$pagesize = 2;
		$current = isset($_GET['page']) ? $_GET['page'] + 0 : 1;
		$offset = ($current - 1) * $pagesize;
		$typeModel = $this->typeModel;
		$types = $typeModel->getPageData($offset, $pagesize);
        
		//(2),show paging detail
		//include the page class
		$this->library('Page');

		$script = "index.php";
		$params = array('p'=>'admin','c'=>'type','a'=>'index');
		//get the total number of data
		$where = "";
		$total = $typeModel->total($where);
		//instantiate a page object
		$page = new Page($total, $pagesize, $current, $script, $params);
        //get the paging information
        $pageInfo = $page->showPage();

		include CUR_VIEW_PATH . "goods_type_list.html";
	}

	public function editAction(){
		//get data from database
		//get type_id
		$typeID = $_GET['type_id'] + 0;
		$typeModel = $this->typeModel;
		$type = $typeModel->selectByPK($typeID);

		include CUR_VIEW_PATH . "goods_type_edit.html";
	}

	public function updateAction(){
		//get data from form
		$typeID = $_POST['type_id'];
		$url = "index.php?p=admin&c=type&a=edit&type_id=$typeID";
		$data = $this->getFormData($url);
		$data['type_id'] = $typeID;
		//update data
		$typeModel = $this->typeModel;
		if ($typeModel->update($data)){
			$this->jump("index.php?p=admin&c=type&a=index","update successfully", 1);
		}else{
			$this->jump("index.php?p=admin&c=type&a=edit&type_id=$typeID", "update fail");
		}
	}

	public function deleteAction(){
		//get type_id
		$typeID = $_GET['type_id'] + 0;//security: + 0

		//delete the data
		$typeModel = $this->typeModel;
		if ($typeModel->delete($typeID)) {
			$this->jump("index.php?p=admin&c=type&a=index", "delete successfully", 1);
		}else{
			$this->jump("index.php?p=admin&c=type&a=index", "delete fail");
		}
	}

	private function getFormData($url){
		//1.get data from the form
		$data['type_name'] = trim($_POST['type_name']);

		//2.check empty
		if ($data['type_name'] === ""){
			$this->jump($url,"the type should not be empty");
		}

		//3.check data security
		include HELPER_PATH . "input.php";
		$data = deepSpecialChars($data);
		$data = deepSlashes($data);

		return $data;
	}
}