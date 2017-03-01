<?php
class BrandModel extends Model{
	//select the brand data from database
	public function getBrands(){
		$sql = "SELECT * FROM {$this->table}";
		return $this->db->getAll($sql);
	}

	//get page data
	public function getPageData($offset, $pagesize){
		$sql = "SELECT * FROM {$this->table} ORDER BY brand_id DESC LIMIT $offset , $pagesize";
		return $this->db->getAll($sql);
	}
}