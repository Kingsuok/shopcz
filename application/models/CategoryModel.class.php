<?php
// back end: category model
class CategoryModel extends Model{

	//get all categories
	public function getCats(){
		$sql = "SELECT * FROM {$this->table}";
		$cats = $this->db->getAll($sql);
		return $this->tree($cats);
	}
    

	/**
	 * scale the categories to see which ones belong to which one
	 * @Author   Andrew
	 * @DateTime 2017-01-19T17:01:17-0500
	 * @param    array                  $arr   [orignal array]
	 * @param    integer                  $pid   [parent id]
	 * @param    integer                  $level [level ]
	 * @return   array                         [target array]
	 
	private function tree($arr, $pid = 0, $level = 0){
		static $res = array();
		foreach ($arr as $key => $value) {
			if ($value['parent_id'] == $pid){
				$value['level'] = $level;
				$res[] = $value;
				$this->tree($arr, $value['cat_id'], $level + 1);
			}
		}
		return $res;
	}*/
   
   //improved version of tree
	/**
	 * scale the categories to see which ones belong to which one
	 * @Author   Andrew
	 * @DateTime 2017-01-19T17:01:17-0500
	 * @param    array                  $arr   [orignal array]
	 * @param    integer                  $pid   [parent id]
	 * @param    integer                  $level [level ]
	 * @return   array                         [target array]
	 */
	private function tree($arr, $pid = 0, $level = 0){
	    $res = array();
		foreach ($arr as $key => $value) {
			if ($value['parent_id'] == $pid){
				$value['level'] = $level;
				$res[] = $value;
				$cat = $this->tree($arr, $value['cat_id'], $level + 1);
				$res = array_merge($res, $cat);
			}
		}
		return $res;
	}




	/**
	 * get the subIDs of the $cat_id
	 * @Author   Andrew
	 * @DateTime 2017-01-20T01:26:16-0500
	 * @param    string                   $cat_id 
	 * @return   array                    the subIDs                   
	 */
	public function getSubIDs($cat_id){
		$sql = "SELECT * FROM {$this->table}";
		$cats = $this->db->getAll($sql);
		$subCats = $this->tree($cats, $cat_id);
		$res = array();
		foreach ($subCats as $subcat){
			$res[] = $subcat['cat_id'];
		}
		// store itself
		$res[] = $cat_id;
		return $res;
	}

     
	/**
	 * get the front end navigation nested category
	 * @Author   Andrew
	 * @DateTime 2017-01-27T09:20:44-0500
	 * @return   array       ['name'=>'cloth','child'=>["men's cloth"]]            
	 */
	public function getFrontCats(){
		$sql = "SELECT * FROM {$this->table}";
		$cats = $this->db->getAll($sql);
		return $this->children($cats);
	}
	/**
	 * sort to get every category's children
	 * @Author   Andrew
	 * @DateTime 2017-01-27T10:02:43-0500
	 * @param    array                  $arr [description]
	 * @param    integer                  $pid [description]
	 * @return   array                      [description]
	 */
	private function children($arr, $pid = 0){
		$res = array();
		foreach ($arr as $key => $value) {
			if ($value['parent_id'] == $pid) {
				//continue to recursion
				$child = $this->children($arr, $value['cat_id']);
				//construct new array
				$value['child'] = $child;
				//store the new array
				$res[] = $value;
			}
		}
		//return the result
		return $res;
	}
	/**
	 * get array: form childer to parent
	 * @Author   Andrew
	 * @DateTime 2017-01-27T16:30:26-0500
	 * @param    string                   $cat_id [description]
	 * @return   array                           [description]
	 */
	public function getReverseCategory($cat_id){
		$sql = "SELECT * FROM {$this->table}";
		$cats = $this->db->getAll($sql);
		$sortCats = $this->reverseTree($cats, $cat_id);
        krsort($sortCats);//reverse sort
        return $sortCats;
	}
	/**
	 * form leaf to tree root
	 * @Author   Andrew
	 * @DateTime 2017-01-27T16:26:20-0500
	 * @param    array                   $arr    [description]
	 * @param    string                  $cat_id [description]
	 * @return   array                          [description]
	 */
	private function reverseTree($arr, $cat_id){
		$res = array();
		foreach($arr as $key => $value){
			if ($value['cat_id'] == $cat_id){
				$res[] = $value['cat_name'];
				$parent = $this->reverseTree($arr, $value['parent_id']);
				$res = array_merge($res, $parent);
			}
		}
		return $res;
	}

}