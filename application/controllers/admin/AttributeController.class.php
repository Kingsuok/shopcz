<?php
class AttributeController extends BaseController{
	private $attributeModel = null;
	public function __construct(){
		//execute the parent construct
		parent::__construct();

		//instantiate an object of typemodel
		$this->attributeModel = new AttributeModel('attribute');
	}


	public function addAction(){
        //get the goods' types
        $typeModel = new TypeModel('goods_type');
        $types = $typeModel->getTypes();
		include CUR_VIEW_PATH . "attribute_add.html";
	}

	public function insertAction(){
		//get the data
		$url = "index.php?p=admin&c=attribute&a=add";
		$data = $this->getFormData($url);

		//insert data to database
		$attributeModel = $this->attributeModel;
		if ($attributeModel->insert($data)){

			$this->jump("index.php?p=admin&c=attribute&a=index&type_id={$data['type_id']}", "upload success", 1);
		}else{
			$this->jump("index.php?p=admin&c=attribute&a=add", "upload fail");
		}
	}

	public function indexAction(){
		 /*
		 //no paging
		//get data from database
		$attributeModel = $this->attributeModel;
		//由于当添加完商品，点击又上角的商品属性，连接中没有过type_id，所以要处理没有type—_id 的情况
		$type_id = isset($_GET['type_id']) ? $_GET['type_id'] + 0 : 0;
		$attributes = $attributeModel->getAttributes($type_id);
        */
        
		//get all type
		$typeModel = new TypeModel('goods_type');
		$types = $typeModel->getTypes();

		//paging
		//(1),get data of the special page
		$pagesize = 2;
		$current = isset($_GET['page']) ? $_GET['page'] + 0 : 1;
		$offset = ($current - 1) * $pagesize;
		$attributeModel = $this->attributeModel;
		$type_id = isset($_GET['type_id']) ? $_GET['type_id'] + 0 : 0;
		$attributes = $attributeModel->getPageData($type_id,$offset, $pagesize);
        
		//(2),show paging detail
		//include the page class
		$this->library('Page');

		$script = "index.php";
		$params = array('p'=>'admin','c'=>'attribute','a'=>'index', 'type_id' => $type_id);
		//get the total number of data
		$where = $type_id == 0 ? "" : "type_id = $type_id";
		$total = $attributeModel->total($where);
		//instantiate a page object
		$page = new Page($total, $pagesize, $current, $script, $params);
        //get the paging information
        $pageInfo = $page->showPage();

		include CUR_VIEW_PATH . "attribute_list.html";
	}

	public function editAction(){
		//get data from database
		//get type_id
		$typeModel = new TypeModel('goods_type');
		$types = $typeModel->getTypes();

		$attributeID = $_GET['attr_id'] + 0;
		$attributeModel = $this->attributeModel;
		$attribute = $attributeModel->selectByPK($attributeID);

		include CUR_VIEW_PATH . "attribute_edit.html";
	}

	public function updateAction(){
		//get data from form
		$attrID = $_POST['attr_id'];
		$url = "index.php?p=admin&c=attribute&a=edit&attr_id=$attrID";
		$data = $this->getFormData($url);
		$data['attr_id'] = $attrID;
		//update data
		$attributeModel = $this->attributeModel;
		if ($attributeModel->update($data)){
			$this->jump("index.php?p=admin&c=attribute&a=index&type_id={$data['type_id']}","update successfully", 1);
		}else{
			$this->jump("index.php?p=admin&c=attribute&a=edit&attr_id={$data['attr_id']}", "update fail");
		}
	}

	public function deleteAction(){
		//get type_id
		$attrID = $_GET['attr_id'] + 0;//security: + 0
        $typeID = $_GET['type_id'] + 0;
		//delete the data
		$attributeModel = $this->attributeModel;
		if ($attributeModel->delete($attrID)) {
			$this->jump("index.php?p=admin&c=attribute&a=index&type_id=$typeID", "delete successfully", 1);
		}else{
			$this->jump("index.php?p=admin&c=attribute&a=index&type_id=$typeID", "delete fail");
		}
	}
    
	//Action: get attributes based on the type_id
	public function getAttributesAction(){
		$type_id = $_GET['type_id'];
		$attributeModel = $this->attributeModel;
		$attributes = $attributeModel->getAttributes($type_id);
		echo json_encode($attributes);

	}

	private function getFormData($url){
		//1.get data from the form
		$data['attr_name'] = trim($_POST['attr_name']);
		$data['type_id'] =$_POST['type_id'];
		$data['attr_type'] =$_POST['attr_type'];
		$data['attr_input_type'] =$_POST['attr_input_type'];
		$data['attr_value'] = isset($_POST['attr_value']) ? $_POST['attr_value'] : "";
		//$data['sort_order'] =$_POST['sort_order'];
		
		//2.check empty
		if ($data['attr_name'] === ""){
			$this->jump($url,"the attribute name should not be empty");
		}
        
        if ($data['type_id'] == 0){
			$this->jump($url,"the type should not be 0");
		}

		//3.check data security
		include HELPER_PATH . "input.php";
		$data = deepSpecialChars($data);
		$data = deepSlashes($data);

		return $data;
	}
}