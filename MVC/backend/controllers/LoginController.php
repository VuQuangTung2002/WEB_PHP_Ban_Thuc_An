<!-- LoginController.phps -->
<?php
	//xử lý đăng nhập đăng ký cho user
	require_once 'controllers/Controller.php';
	require_once 'models/User.php';
	class LoginController extends Controller {

		//xử lý đăng ký user
		public function signup() {
			//xử lý submit form
//			echo "<pre>";
//			print_r($_POST);
//			echo "</pre>";
			if (isset($_POST['submit'])) {
				//tạo biến và gán giá trị từ form cho biến
				$username = $_POST['username'];
				$password = $_POST['password'];
				$confirm_password = $_POST['confirm_password'];
				//validate form
				//không được để trống các trường username và password, trường password và confirm password phải giống nhau
				if (empty($username) || empty($password)) {
					$this->error = 'Username hoặc password không được để trống';
				}elseif ($password != $confirm_password) {
					$this->error = 'Password confirm chưa đúng';
				}

				//xử lý đăng ký user trong trường hợp k có lỗi validate
				
            	if (empty($this->error)) {
	                //can kiem tra Th username da ton tai trong csdl thi bao loi
	                $user_model = new User();
	                //lay thong tin user dua vao username
	                $user = $user_model->getUser($username);
	                //trường hợp username đã tồn tại
	                if (!empty($user)) {
	                	$this->error = 'Username đã trùng trong csdl';
	                }else {
	                	//gán các giá trị cho thuộc tính tương ứng của model
	                	$user_model->username = $username;
	                	// không bao giờ được lưu password kiểu plain text
	                	//bắt buộc phải mã hoá password trước khi lưu có rất nhiều cơ chế mã hoá, với mục đích demo thì sẽ sử dụng cơ chế mã hoá md5 cho đơn giản
	                	//$user_model->password = $password;
	                	$user_model->password = md5($password);
	                	$is_register = $user_model->register();
	                	if($is_register){
	                		$_SESSION['success'] = 'Đăng ký thành công';
	                	}else {
	                		$_SESSION['error'] = 'Đăng ký thất bại';
	                	}
	                	header('Location: index.php?controller=login&action=login');
	                	exit();
	                }
            	}
			}
			//lấy nội dung view tương ứng
			$this->content = $this->render('views/users/signup.php');
			//gọi layout tương ứng
			require_once 'views/layouts/main_login.php';
		}
		//xử lý login
		public function login() {
			//xử lý submit form
//			echo "<pre>";
//			print_r($_POST);
//			echo "</pre>";
			if (isset($_POST['submit'])) {
				//gán biến 
				$username = $_POST['username'];
				$password = $_POST['password'];
				//check validate
					//- không được để trống cả 2 trường
				if (empty($username) || empty($password)) {
					$this->error = 'Không được để trống trường username hoặc password';
				}
				//xử lý login submit form chỉ khi nào không có lỗi validate
				if (empty($this->error)) {
					// xử lý login thì thường sẽ tạo ra 1 session chứa thông tin của user tìm được
					$user_model = new User();
					// do password lưu trong CSDL đang được mã hoá theo cơ chế md5
					$password = md5($password);
					//gọi phương thức lấy user từ csdl
					//dựa vào username và password đã mã hoá
					$user = $user_model->getUserLogin($username, $password);
					if (empty($user)) {
						$_SESSION['error'] = 'Sai username hoặc password';
						header('Location: index.php?controller=login&action=login');
						exit();
					}else {
						$_SESSION['success'] = 'Đăng nhập thành công';
						//khi login thành công cần tạo session với giá trị chính là mảng user vừa tìm được
						$_SESSION['user'] = $user;
						//chuyển hướng tới trang admin
						header('Location: index.php?controller=category&action=index');
						exit();
					}
					// echo "<pre>";
					// print_r($user);
					// echo "</pre>";
				}
			}

			//lấy nội dung view login
			$this->content = $this->render('views/users/login.php');
			//gọi layout để hiển thị view
			require_once 'views/layouts/main_login.php';
		}

		//đăng xuất người dùng khỏi hệ thống
		public function logout() {
			//xoá tất cả các session liên quan đến user đã đăng nhập
			unset($_SESSION['user']);
			//xoá tất cả các session khác trên hệ thống
			$_SESSION['success'] = 'Logout thành công!';
			//chuyển hướng về trang login
			header('Location: index.php?controller=login&action=login');
			exit();
		}
	} 
 ?>