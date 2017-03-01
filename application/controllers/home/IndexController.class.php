<?php 
class IndexController extends Controller{
	//action:show the view
	public function indexAction(){
		//get the categories to show the navigation
		$categoryModel = new CategoryModel('category');
		$cats = $categoryModel->getFrontCats();

		//gete the the recommended goods
		$goodsModel = new GoodsModel('goods');
		$bestGoods = $goodsModel->getBestGoods();

		include CUR_VIEW_PATH . "index.html";
	}


}