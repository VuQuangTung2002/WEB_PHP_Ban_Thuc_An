<?php
//models/Model.php
//đóng vai trò là 1 model cha, chứa 1 thuộc tính connection
//và 1 phương thức để khởi tạo kết nối
//lợi dụng hàm khởi tạo để khởi tạo giá trị cho connection
require_once 'configs/Database.php';
class Model {
    //thuộc tính kết nối dùng chung cho các model con
    public $connection;

    //khai báo hàm khởi tạo để khởi tạo giá mặc định
    //cho thuộc tính connection
    public function __construct() {
        $this->connection = $this->getConnection();
    }
    //phương thức kết nối csdl
    public function getConnection() {
        $connection =
            new PDO(Database::DB_DSN,
                Database::DB_USERNAME,
                Database::DB_PASSWORD);
        return $connection;
    }
}