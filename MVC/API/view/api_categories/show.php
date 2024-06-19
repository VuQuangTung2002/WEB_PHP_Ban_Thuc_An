<?php
	header('Access-Control-Allow-Origin:*');
	header('Content-Type: application/json');
	
	include_once('../../configs/Database.php');
	include_once('../../model/API_categories.php');
	
	$db = new db();
	$connect = $db->connect();
	
	$category = new Category($connect);
	
	$category->id = isset($_GET['id']) ? $_GET['id'] : die();
	
	$category->show();
	
	$category_item = array(
		'id' => $category->id,
		'name' => $category->name,
		'avatar' => $category->avatar,
		'description' => $category->description,
		'status' => $category->status
	
	);
	print_r(json_encode($category_item));
?>