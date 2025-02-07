<!-- User.php -->
<?php
	require_once 'models/Model.php';
	class User extends Model {
		// khai báo các thuộc tính của class dựa vào trường trong bảng user
		public $username;
		public $password;
		public $first_name;
		public $last_name;
		public $phone;
		public $address;
		public $email;
		public function getUser($username) {
			$sql_select_once = "SELECT * FROM users WHERE `username` = :username";
			$obj_select_one = $this->connection->prepare($sql_select_once);
			$arr_select = [
				':username' => $username
			];
			$obj_select_one->execute($arr_select);
			$user = $obj_select_one->fetch(PDO::FETCH_ASSOC);
			return $user;
		}

		//Đăng ký user
		public function register() {
			$sql_insert = "INSERT INTO users (`username`, `password`, `first_name`, `last_name`, `phone`, `address`, `email`) VALUES(:username, :password, 
:first_name, :last_name, :phone, :address, :email)";
			$obj_insert = $this->connection->prepare($sql_insert);
			//gán giá trị thật cho các placeholder
			$arr_insert = [
				':username' => $this->username,
				':password' => $this->password,
                ':first_name' => $this->first_name,
                ':last_name' => $this->last_name,
                ':phone' => $this->phone,
                ':address' => $this->address,
                ':email' => $this->email
			];
			return $obj_insert->execute($arr_insert);
		}

		public function getUserLogin($username, $password) {
			$sql_select_one = "SELECT * FROM users WHERE `username` = :username AND `password` = :password";
			$obj_select_one = $this->connection->prepare($sql_select_one);
			// truyền giá trị thật cho các placeholder trong câu truy vấn
			$arr_select = [
				':username' => $username,
				':password' => $password
			];
			//thực thi truy vấn
			$obj_select_one->execute($arr_select);
			$user = $obj_select_one->fetch(PDO::FETCH_ASSOC);
			return $user;
		}
	} 
 ?>