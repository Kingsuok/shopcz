<?php
//back end: goods category management 
class CategoryController extends BaseController{
	private $categoryModel = null;
	public function __construct(){
		parent::__construct();
		$this->categoryModel = new CategoryModel('category');// because every action uses the categoryModel object, so define it in the construct 
	}
	//add action: just show the add form view
	public function addAction(){
		//get all category
		$categoryModel = $this->categoryModel;
		$cats = $categoryModel->getCats();
		//show the add view
		include CUR_VIEW_PATH . "cat_add.html";
	}
	//insert action: insert data into database
	public function insertAction(){
		
		//get the data
		$url = "index.php?p=admin&c=category&a=add";
		$data = $this->getFormData($url);

		//insert data into database
		$categoryModel = $this->categoryModel;

		if ($categoryModel->insert($data)){
			$this->jump("index.php?p=admin&c=category&a=index","Add successful",1);
		}else{
			$this->jump("?p=admin&c=category&a=add","Add failure");
		}


	}
    // index action: show the categroy view
    public function indexAction(){
    	//get all the category
    	$categoryModel = $this->categoryModel;
    	$cats = $categoryModel->getCats();
    	//show the category index view
    	//var_dump($cats);
    	include CUR_VIEW_PATH . "cat_list.html";
	}

	//edit action: 
	public function editAction(){
		//get the data of the category to show on the edit view
		$categoryModel = $this->categoryModel;
		$cats = $categoryModel->getCats();
		$catID = $_GET['cat_id'] + 0; //+0:security
		$cat = $categoryModel->selectByPK($catID);
		//show the edit view
		include CUR_VIEW_PATH . "cat_edit.html";
	}
	// update action: update the category into database
	public function updateAction(){
		//1,get the form data
		$catID = $_POST['cat_id'];
		$url = "index.php?p=admin&c=category&a=edit&cat_id=$catID";
		$data = $this->getFormData($url);
		$data['cat_id'] = $catID;
		
	
		//.....check other data
		//3,check the wrong parent category, when its parent category is itself or its child category, this data is wrong
		$categoryModel = $this->categoryModel;
		$subIDs = $categoryModel->getSubIDs($data['cat_id']);
		if (in_array($data['parent_id'], $subIDs)){
		 	$this->jump("index.php?p=admin&c=category&a=edit&cat_id={$data['cat_id']}","parent id should not be itself or its children");
		 }

		//4,update data into database
		//$categoryModel = new CategoryModel('category');
		if ($categoryModel->update($data)){
			$this->jump("index.php?p=admin&c=category&a=index","update successful",1);
		}else{
			$this->jump("index.php?p=admin&c=category&a=edit&cat_id={$data['cat_id']}","update failure");
		}
 
	}
    // delete action: delete category
	public function deleteAction(){
		//1,get the cat_id to delete
		$catID = $_GET['cat_id'] + 0; //+0:security
		//2,check the cat_id has children or not
		$categoryModel = $this->categoryModel;
		$subIDS = $categoryModel->getSubIDs($catID);
		if (count($subIDS) > 1){
			$this->jump("index.php?p=admin&c=category&a=index","It is a parent, can not be deleted");
		}
		//3,delete operation
		if ($categoryModel->delete($catID)) {
			$this->jump("index.php?p=admin&c=category&a=index","delete successfully",1);
		}else{
			$this->jump("index.php?p=admin&c=category&a=index","delete failure");
		}
	}

/**
 * [getFormData description]
 * @Author   Andrew
 * @DateTime 2017-01-24T21:49:05-0500
 * @param    STRING                   $url get form data fail: jump url
 * @return   [type]                        [description]
 */
	private function getFormData($url){
	//get the data of the category form and store to  an array
		$data['cat_name'] = trim($_POST['cat_name']);
		$data['parent_id'] = $_POST['parent_id'];
		$data['unit'] = trim($_POST['unit']);
		$data['sort_order'] = trim($_POST['sort_order']);
		$data['is_show'] = $_POST['is_show'];
		$data['cat_desc'] = trim($_POST['cat_desc']);

		//check data is empty?
		if ($data['cat_name'] === ''){
			$this->jump($url,"category name should not be empty");
		}
		//.....check other data
        
		//security check for sql attacks and XSS attacks
		//include the functions
		include HELPER_PATH . "input.php";
		//call the function 
		$data = deepSpecialChars($data);
		$data =deepSlashes($data);

		return $data;
	}


}