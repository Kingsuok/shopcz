<?php
class AdminModel extends Model{
	//action:get all admins
	public function getAdmins(){
		$sql = "SELECT * FROM {$this->table}";//
		return $this->db->getAll($sql);
	}

	//action: check an login 
	public function checkUser($username, $password){
		//$username = addslashes($username);//transferred meaning for security,后面会封装方法处理
		$password = md5($password);// encription for security
		$sql = "SELECT * FROM {$this->table} WHERE admin_name='$username' AND password='$password' LIMIT 1";
		return $this->db->getRow($sql);//return an array
	}
}