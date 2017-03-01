<?php
class AttributeModel extends Model{
	//get attributes based on the type_id 
	public function getAttributes($type_id){
		$typeTable = $GLOBALS['config']['prefix'] . 'goods_type';
		if ($type_id == 0){
			$sql = "SELECT * FROM {$this->table} INNER JOIN $typeTable using(type_id)";
		}else{
			$sql = "SELECT * FROM {$this->table} INNER JOIN $typeTable using(type_id) 
					WHERE type_id = $type_id";
		}
		return $this->db->getAll($sql);
	}

	//get page data 
	public function getPageData($type_id, $offset, $pagesize){
		$typeTable = $GLOBALS['config']['prefix'] . 'goods_type';
		if ($type_id == 0){
			$sql = "SELECT * FROM {$this->table} INNER JOIN $typeTable using(type_id) ORDER BY attr_id DESC LIMIT $offset, $pagesize";
		}else{
			$sql = "SELECT * FROM {$this->table} INNER JOIN $typeTable using(type_id) 
					WHERE type_id = $type_id ORDER BY attr_id DESC 
					LIMIT $offset, $pagesize";
		}
		return $this->db->getAll($sql);
	}
}