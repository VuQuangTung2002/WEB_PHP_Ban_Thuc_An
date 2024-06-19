<?php
	header('Access-Control-Allow-Origin:*');
	header('Content-Type: application/json');
	
	include_once('../../configs/Database.php');
	include_once('../../model/API_categories.php');
	
	$db = new db();
	$connect = $db->connect();
	
	$category = new Category($connect);
	$read = $category->read();
	
	$num = $read->rowCount();
	if($num>0){
		$category_array = [];
		$category_array['category'] = [];
		
		while($row = $read->fetch(PDO::FETCH_ASSOC)){
			
			extract($row);
			
			$category_item = array(
				'id' => $id,
				'name' => $name,
				'avatar' => $avatar,
				'description' => $description,
				'status' => $status
			);	
			array_push($category_array['category'],$category_item);
		}
		echo json_encode($category_array);	
	}
?>