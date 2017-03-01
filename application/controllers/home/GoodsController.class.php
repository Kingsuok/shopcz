<?php
class GoodsController extends Controller{
	//action:
	public function indexAction(){
		$goods_id = $_GET['goods_id'] + 0;
		$model = new Model('goods');
		$good = $model->selectByPK($goods_id);
        
        include CUR_VIEW_PATH . "goods.html";
	}
	//
	public function categoryAction(){
		$cat_id = $_GET['cat_id'] + 0;
		$categoryModel = new CategoryModel('category');
		$reverseCats = $categoryModel->getReverseCategory($cat_id);
        
        include CUR_VIEW_PATH . "list.html";
	}
}