<?php
class GoodsController extends BaseController{
	private $goodsModel = null;

	public function __construct(){
		parent::__construct();
		$this->goodsModel = new GoodsModel('goods');
	}

	public function addAction(){
		//get categories of goods
		$categoryModel = new CategoryModel('category');
		$cats = $categoryModel->getCats();		

		//get brands of goods
		$brandModel = new BrandModel('brand');
		$brands = $brandModel->getBrands();

		//get types of goods
		$typeModel = new TypeModel('goods_type');
		$types = $typeModel->getTypes();

		//include add view
		include CUR_VIEW_PATH . "goods_add.html";
	}

	public function insertAction(){
		//1,get data from the form
		$url = "index.php?p=admin&c=goods&a=add";
		$data = $this->getFormData($url);
		//2,insert data to database
		$goodsModel = $this->goodsModel;
		if ($goods_id = $goodsModel->insert($data)){
			//when insertting good successfully, then insert data to goods_attr table
            if (isset($_POST['attr_id_list'])){
            	$ids = $_POST['attr_id_list'];
            	$values = $_POST['attr_value_list'];
            	$prices = $_POST['attr_price_list'];
            	//insert batch 
            	$model = new Model('goods_attr');
            	foreach ($ids as $key => $value) {
            		$list['goods_id'] = $goods_id;
            		$list['attr_id'] = $value;
            		$list['attr_value'] = $values[$key];
            		$list['attr_price'] = $prices[$key];
            		$model->insert($list);
            	}
            }
			
			$this->jump("index.php?p=admin&c=goods&a=index","upload success", 1);
		}else{
			$this->jump("index.php?p=admin&c=goods&a=add","upload fail");
		}

	}

	public function indexAction(){
		/* no paging
		//1, get the data from the database
		$goodsModel = $this->goodsModel;
		$goodss = $goodsModel->getBrands();
		*/
         
        //paging
        //get data of each page
        $pagesize = 2;
        $current = isset($_GET['page']) ? $_GET['page'] + 0 : 1;
        $offset = ($current - 1) * $pagesize;
        $goodsModel = $this->goodsModel;
        $goods = $goodsModel->getPageData($offset, $pagesize);

        //use page class to show page detail
        //get total number of data
        $where = "";
        $total = $goodsModel->total($where);
        $script = "index.php";
        $params = array('p'=>'admin','c'=>'goods','a'=>'index');
        //instantiate a page object
        $this->library('Page');
        $page = new Page($total, $pagesize, $current, $script, $params);
        $pageInfo = $page->showPage();
		//include index view
		include CUR_VIEW_PATH . "goods_list.html";
	}

	public function editAction(){
		//get the original data 
	    $goodsModel = $this->goodsModel;
	    $goodsID = $_GET['goods_id'] + 0; //+0:security
	    $goods = $goodsModel->selectByPK($goodsID);
		//include edit view
		include CUR_VIEW_PATH . "goods_edit.html";
	}

	public function updateAction(){
        //1,get data from the form
        $goodSID = $_POST['goods_id'];
        //$url = 
        $data = $this->getFormData();
        //get the goods id
        $data['goods_id'] = $goodsID;
		//2,insert data to database
		$goodsModel = $this->goodsModel;
		if ($goodsModel->update($data)){
			$this->jump("index.php?p=admin&c=goods&a=index","update success", 1);
		}else{
			$this->jump("index.php?p=admin&c=goods&a=edit","update fail");
		}

	}

	public function deleteAction(){
		//get which one to be deleted
		$goodsID = $_GET['goods_id'] + 0; //security 
		//delete data
		$goodsModel = $this->goodsModel;
		if ($goodsModel->delete($goodsID)){
			$this->jump("index.php?p=admin&c=goods&a=index","delete successfully",1);
		}else{
			$this->jump("index.php?p=admin&c=goods&a=index", "delete fail");
		}
	}


	public function searchAction(){
		//var_dump($_POST['keyword']);
		//print_r($_POST);
		//get the search condition
		if ($_POST['cat_id'] != 0){
			$data['cat_od'] = $_POST['cat_id'];
		}
		if ($_POST['brand_id'] != 0){
			$data['brand_id'] = $_POST['brand_id'];
		}
		if ($_POST['intro_type'] != 0){
			$data[$_POST['intro_type']] = 1;
		}
		if ($_POST['suppliers_id'] != 0){
			$data[$_POST['suppliers_id']] = 1;
		}
		if ($_POST['is_on_sale'] != 0){
			$data[$_POST['is_on_sale']] = 1;
		}
		if (trim($_POST['keyword']) != ""){
			$data['keyword'] = $_POST['keyword'];			
		}
        if (isset($data)){       	
			$goodsModel = $this->goodsModel;
			$searchData = $goodsModel->getSearch($data);
		}else{
			die();
		}
		if (empty($searchData)){
			echo "";
		}else{
			echo json_encode($searchData);
		}
        
		
	
	}

	private function getFormData($url){
		//1,get the data of the form
		$data['goods_name'] = trim($_POST['goods_name']);
		$data['goods_sn'] = trim($_POST['goods_sn']);
		$data['shop_price'] = trim($_POST['shop_price']);
		$data['market_price'] = trim($_POST['market_price']);
		$data['cat_id'] = $_POST['cat_id'];
		$data['brand_id'] = $_POST['brand_id'];
		$data['type_id'] = $_POST['type_id'];
		$data['promote_start_time'] = $_POST['goods_name'];
		$data['promote_end_time'] = $_POST['promote_end_time'];
		$data['goods_desc'] = trim($_POST['goods_desc']);
		$data['goods_number'] = trim($_POST['goods_number']);
		$data['is_best'] = isset($_POST['is_best']) ? $_POST['is_best'] : 0;
		$data['is_hot'] = isset($_POST['is_hot']) ? $_POST['is_hot'] : 0;
		$data['is_new'] = isset($_POST['is_new']) ? $_POST['is_new'] : 0;
		$data['is_onsale'] = isset($_POST['is_onsale']) ? $_POST['is_onsale'] : 0;

		//2,check data

		//(1)check the empty of the data
		if ($data['goods_name'] === ""){
			$this->jump($url,"goods name should not be empty");
		}
		//.....others needs to check empty.....

		//(2)security check for sql attacks and XSS attacks
		//include the functions
		include HELPER_PATH . "input.php";
		//call the function 
		$data = deepSpecialChars($data);
		$data = deepSlashes($data);

		//3, handle the upload image
		//image exist? yes: upload ;判断是否有文件上传，有的话就进行上传，
		if ($_FILES['goods_img']['name']){
			//load the Upload.class.php, use tool class to upload image
			$this->library('Upload');
			//instantiate an object
			$uploadTool = new Upload();
			//set the directory of the upload file
			$uploadTool->setUploadPath(UPLOAD_PATH);
			//set the type name of the file
			$uploadTool->setPrefix('goodsOri');
			//upload the file
			if ($result = $uploadTool->uploadFile($_FILES['goods_img'])){
				$data['goods_img'] = $result;
			}else{
				$this->jump($url, $uploadTool->error);	
			}
		}
        
		//handle the thumb image

		if (isset($_FILES['goods_img']['name']) && $_POST['auto_thumb']){
			//load the Upload.class.php, use tool class to upload image
			$this->library('Image');
			//instantiate an object
			$image = new Image();
			//set the directory of the upload file,and upload
			$result = $image->thumbnail(UPLOAD_PATH.$data['goods_img'],100,100,UPLOAD_PATH);
			
			if ($result){
				$data['goods_thumb'] = $result;
			}else{
				$this->jump($url, "fail");	
			}
		}

        return $data;
	}


}