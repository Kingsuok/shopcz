<?php
class BrandController extends BaseController{
	private $brandModel = null;

	public function __construct(){
		parent::__construct();
		$this->brandModel = new BrandModel('brand');
	}

	public function addAction(){
		//include add view
		include CUR_VIEW_PATH . "brand_add.html";
	}

	public function insertAction(){
		//1,get data from the form
		$url = "index.php?p=admin&c=brand&a=add";
		$data = $this->getFormData($url);
		//2,insert data to database
		$brandModel = $this->brandModel;
		if ($brandModel->insert($data)){
			$this->jump("index.php?p=admin&c=brand&a=index","upload success", 1);
		}else{
			$this->jump("index.php?p=admin&c=brand&a=add","upload fail");
		}

	}

	public function indexAction(){
		/* no paging
		//1, get the data from the database
		$brandModel = $this->brandModel;
		$brands = $brandModel->getBrands();
		*/
        
        //paging
        //get data of each page
        $pagesize = 2;
        $current = isset($_GET['page']) ? $_GET['page'] + 0 : 1;
        $offset = ($current - 1) * $pagesize;
        $brandModel = $this->brandModel;
        $brands = $brandModel->getPageData($offset, $pagesize);

        //use page class to show page detail
        //get total number of data
        $where = "";
        $total = $brandModel->total($where);
        $script = "index.php";
        $params = array('p'=>'admin','c'=>'brand','a'=>'index');
        //instantiate a page object
        $this->library('Page');
        $page = new Page($total, $pagesize, $current, $script, $params);
        $pageInfo = $page->showPage();
		//include index view
		include CUR_VIEW_PATH . "brand_list.html";
	}

	public function editAction(){
		//get the original data 
	    $brandModel = $this->brandModel;
	    $brandID = $_GET['brand_id'] + 0; //+0:security
	    $brand = $brandModel->selectByPK($brandID);
		//include edit view
		include CUR_VIEW_PATH . "brand_edit.html";
	}

	public function updateAction(){
        //1,get data from the form
        $brandID = $_POST['brand_id'];
        $url ="index.php?p=admin&c=brand&a=edit&brand_id=$brandID";
        $data = $this->getFormData();
        //get the brand id
        $data['brand_id'] = $brandID;
		//2,insert data to database
		$brandModel = $this->brandModel;
		if ($brandModel->update($data)){
			$this->jump("index.php?p=admin&c=brand&a=index","update success", 1);
		}else{
			$this->jump("index.php?p=admin&c=brand&a=edit&brand_id=$brandID","update fail");
		}

	}

	public function deleteAction(){
		//get which one to be deleted
		$brandID = $_GET['brand_id'] + 0; //security 
		//delete data
		$brandModel = $this->brandModel;
		if ($brandModel->delete($brandID)){
			$this->jump("index.php?p=admin&c=brand&a=index","delete successfully",1);
		}else{
			$this->jump("index.php?p=admin&c=brand&a=index", "delete fail");
		}
	}

	private function getFormData($url){
		//1,get the data of the form
		$data['brand_name'] = trim($_POST['brand_name']);
		$data['url'] = trim($_POST['url']);
		$data['brand_desc'] = trim($_POST['brand_desc']);
		$data['sort_order'] = trim($_POST['sort_order']);
		$data['is_show'] = $_POST['is_show'];

		//2,check data

		//(1)check the empty of the data
		if ($data['brand_name'] === ""){
			$this->jump($url, "brand name should not be empty");
		}
		
		//(2)security check for sql attacks and XSS attacks
		//include the functions
		include HELPER_PATH . "input.php";
		//call the function 
		$data = deepSpecialChars($data);
		$data = deepSlashes($data);

		//3, handle the upload image
		//image exist? yes: upload ;判断是否有文件上传，有的话就进行上传，
		if ($_FILES['logo']['name']){
			//load the Upload.class.php, use tool class to upload image
			$this->library('Upload');
			//instantiate an object
			$uploadTool = new Upload();
			//set the directory of the upload file
			$uploadTool->setUploadPath(UPLOAD_PATH);
			//set the type name of the file
			$uploadTool->setPrefix('brandOri');
			//upload the file
			if ($result = $uploadTool->uploadFile($_FILES['logo'])){
				$data['logo'] = $result;
			}else{
				$this->jump($url, $uploadTool->error);	
			}
		}
		
        return $data;
	}


}