<?php
//entity escape
function deepSpecialChars($data){
	if (empty($data)){
		return $data;
	}

	//simple codes
	return is_array($data) ? array_map('deepSpecialChars', $data) : htmlspecialchars($data);


	/*
		///complicated codes
		if (is_array($data)){
			foreach ($data as $key => $value) {
				$data[$key] = deepSpecialChars($value);
			}
			return $data;
		}else{
			return htmlspecialchars($data);
		}
	*/
}

//batch single quote escape
function deepSlashes($data){
	if (empty($data)){
		return $data;
	}

	return is_array($data) ? array_map('deepSlashes', $data) : addslashes($data);
}