<?php
	header('Access-Control-Allow-Origin:*');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
	
	include_once('../../configs/Database.php');
	include_once('../../model/API_categories.php');
	
	
	$db = new db();
	$connect = $db->connect();
	
	$category = new Category($connect);
	
	$data = json_decode(file_get_contents("php://input"));
	$category->name = $data->name;
	$category->avatar = $data->avatar;
	$category->description = $data->description;
	$category->status = $data->status;
	
	if($category->create()){
		echo json_encode(array('message','Danh mục được tạo thành công'));	
	}else{
		echo json_encode(array('message','Danh mục tạo thất bại'));	
	}
?>