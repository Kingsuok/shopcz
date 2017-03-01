<?php
/**
 * upload class tool
 * example:
 * 
 * 1,instantiate an object
 * $uploadTool = new Upload();
 *
 * 2,set upload directory
 * $uploadTool->setUploadPath(UPLOAD_PATH);
 *
 * 3,set type name of the file
 * $uploadTool->setPrefix('...');
 *
 * 4,upload the file
 * $uploadTool->uploadFile($_FILES['...']);
 * 
 */
class Upload{
	private $error;//store current error information
	/**
	 * get error
	 * @Author   Andrew
	 * @DateTime 2017-01-20T17:26:08-0500
	 * @return   string                   error information
	 */
	public function getError(){
		return $this->error;
	}

	private $uplaodPath;//upload file path
	private $prefix;//prefix
	private $maxSize; // maximized size
	private $extList; //suffix list
	private $MIMEList; // MIME list

	/**
	 * set upload directory
	 * @Author   Andrew
	 * @DateTime 2017-01-20T17:36:52-0500
	 * @param    string                   $uploadPath upload directory
	 */
	public function setUploadPath($uploadPath){
		//the inexistent directory can not be as the upload path
		if (is_dir($uploadPath)){
			$this->uploadPath = $uploadPath;			
		}else{
			trigger_error('upload directory setting is failure, using the default directory');
		}
	}

	public function setPrefix($prefix){
		$this->prefix = $prefix;
	}

	public function setMaxSize($maxSize){
		$this->maxSize = $maxSize;
	}

	public function setExtList($extList){
		$this->extList = $extList;
		//set the current MIME
		$this->setMIMEList($extList);
	}
 
	//array : general suffix <-> MIME 
	private $extMime = array(
		'.jpeg' =>'image/jpeg',
		'.jpg' => 'image/jpeg',
		'.png' => 'image/png',
		'.gif' => 'image/gif'
		);
	/**
	 * get the current MIME suffixes
	 * @Author   Andrew
	 * @DateTime 2017-01-20T17:54:23-0500
	 * @param    array                   $extList 
	 */
	private function setMIMEList($extList){
		$currentMIMEList = array();
		//traveral every suffix 
		foreach ($extList as $key => $value) {
			//store the corresponding MIME suffix
			$currentMIMEList[] = $this->extMime[$value];
		}
		//assign value
		$this->MIMEList = $currentMIMEList;
	}

	//construct method
	public function __construct(){
		//set the default value
		$this->uploadPath = './';// current directory
		$this->prefix = '';
		$this->maxSize = 1 * 1024 * 1024;
		$this->extList = array('.jpg','.jpeg','.png','.gif');
		$this->setMIMEList($this->extList);
	}


	/**
	 * upload file logical function
	 * @Author   Andrew
	 * @DateTime 2017-01-20T18:18:09-0500
	 * @param    array                   $fileInfo the information of an upload tempory file, the information comes from $_FILES 
	 * @return   string: success, the target file directory; flase: fail                             
	 */
	public function uploadFile($fileInfo){
		// check the errors of the upload temporary file
		if ($fileInfo['error'] != 0){
			$this->error = 'the upload file have errors';
			return false;
		} 

		//check the type of the upload file through suffix
		$extList = $this->extList; // allowable suffix lis
		$ext = strrchr($fileInfo['name'], '.');//get the suffix with a dot
		if (! in_array($ext, $extList)){
			$this->error = 'the type of the upload file is invalided';
			return false;
		}

		//MIME
		$MIMEList = $this->MIMEList;
		if (! in_array($fileInfo['type'], $MIMEList)){
			$this->error = "type: MIME is invalided";
			return false;
		}

		//php check MIME
		$finfo = new Finfo(FILEINFO_MIME_TYPE);
		$mimeType = $finfo->file($fileInfo['tmp_name']);
		if (! in_array($mimeType, $MIMEList)){
			$this->error = "type: MIME is invalided";
			return false;
		}

		//check the size of the file
		$maxSize = $this->maxSize;
		if ($fileInfo['size'] > $maxSize){
			$this->error = "the size is too big";
			return false;
		}

		//set the directory of the target file
		$uploadPath = $this->uploadPath;
		//set the subdirectory
		$subDir = date('YmdH') . '/';//这个地方一定要用斜杠“/”,不能使用反斜杠“\”，因为
		//check the existence
		if ( ! is_dir($uploadPath . $subDir)){
			// if inexist, create it
			mkdir($uploadPath . $subDir);
		}

		//set the name of the target file
		$prefix = $this->prefix;
		$targetName = uniqid($prefix, true) . $ext;

		//check the upload is the file uploaded by http
		if (! is_uploaded_file($fileInfo['tmp_name'])){
			$this->error = "not a file uploaded by http";
			return false;
		}

		//shift the upload file
		if (move_uploaded_file($fileInfo['tmp_name'], $uploadPath . $subDir . $targetName)){
			return $subDir . $targetName;
		}else{
			$this->error = "move fail";
			return false;
		}
	}
	/**
	 * upload multifile
	 * @Author   Andrew
	 * @DateTime 2017-01-21T18:22:17-0500
	 * @param    array                 $file_list [description]
	 * @return   array                             [description]
	 */
	public function uploadMulti($file_list){
		//traverse all the element
		foreach ($file_list['name'] as $key => $value) {
			//use subscript to get the file's 5 attributes
			$file_info['name'] = $file_list['name'][$key];
			$file_info['type'] = $file_list['type'][$key];
			$file_info['tmp_name'] = $file_list['tmp_name'][$key];
			$file_info['error'] = $file_list['error'][$key];
			$file_info['size'] = $file_list['size'][$key];
            
            //upload file
            $result_list[$key] = $this->uploadFile($file_info);
		}
		return $result_list;
	}
}