<?php
session_start();

//file index.php gốc của ứng dụng: phân tích url
//để lấy ra tên controller và action
//sau đó nhúng file controller tương ứng
//khởi tạo object từ controller đó, và gọi phương thức
//tương ứng
//set múi giờ việt nam
date_default_timezone_set('Asia/Ho_Chi_Minh');
//phân tích url
//với mô hình mvc hiện tại, url luôn có dạng
//index.php?controller=<>&action=<>
$controller = isset($_GET['controller']) ? $_GET['controller'] :
    'category';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
//chuyển đổi biến $controller thành tên class tương ứng
//mục đích để chuyển thành tên class: CategoryController
$controller = ucfirst($controller); //Category
$controller .= "Controller"; //CategoryController
//tạo 1 biến chứa đường dẫn đến file controller:
// controllers/CategoryController.php
$path_controller = "controllers/$controller.php";
//trước khi nhúng đường dẫn cần kiểm tra xem có tồn tại hay ko
if (!file_exists($path_controller)) {
    die("Trang bạn tìm ko tồn tại");
}
//nhúng file controller vào
require_once "$path_controller";
//sau khi nhúng class, thì sẽ khởi tạo đối tượng từ class đó
$object = new $controller();
//gọi phương thức của đối tượng dựa vào biến action bắt đc
//từ url
//cần check nếu ko tồn tại phương thức thì báo lỗi
if (!method_exists($object, $action)) {
    die("Ko tồn tại phương thức $action trong class $controller");
}
//gọi phương thức từ đối tượng
$object->$action();
