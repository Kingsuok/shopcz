<?php
class GoodsModel extends Model{
	//get all goods
	public function getGoods(){
      
	}
    
	//get page data 
	public function getPageData($offset, $pagesize){
		$sql = "SELECT * FROM {$this->table} ORDER BY goods_id DESC LIMIT $offset, $pagesize";		
		return $this->db->getAll($sql);
	}

	public function getSearch($condition){
		$equ ="";
		foreach ($condition as $key => $value) {
			if ($key == "keyword"){
				$like = "goods_name LIKE '%$value%'";
			}else{
				$equ .= "$key=$value and "; 
			}
		}
		$sql = "SELECT * FROM {$this->table} WHERE ". $equ . $like;
		return $this->db->getAll($sql);	
	}

		public function getBestGoods(){
		$sql = "SELECT goods_id, goods_name, promote_price, goods_thumb FROM {$this->table}";
		return $this->db->getAll($sql);
	}
}