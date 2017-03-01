<?php
class TypeModel extends Model{
	//get the all types
	public function getTypes(){
		$sql = "SELECT * FROM {$this->table}";
		return $this->db->getAll($sql);
	}

	/*//get the page data
	public function getPageData($offset, $pageSize){
		$sql = "SELECT * FROM {$this->table} ORDER BY type_id DESC LIMIT $offset , $pageSize";
		return $this->db->getAll($sql);
	}*/

	//get the page data (second version)
	public function getPageData($offset, $pageSize){
		$sql = "SELECT a.*, count(attr_id) as num FROM {$this->table} as a left join cz_attribute as b on a.type_id = b.type_id group by type_name ORDER BY a.type_id DESC LIMIT $offset , $pageSize";
		return $this->db->getAll($sql);
	}
}