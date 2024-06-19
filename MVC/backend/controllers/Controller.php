<?php
//controllers/Controler.php
//đóng vai trò là controller cha
//chứa thuộc tính content và error
//chứa phương thức render
//là các thuộc tính/phương thức dùng chung bởi các class con
//kế thừa từ class cha này
class Controller {
    //do tất cả các controller bên backend đều kế thừa từ class Controller cha nên sẽ check việc user đã đăng nhập thì mới sử dụng được
    //chức năng bên backend tại phương thức khởi tạo của class cha này
    public function __construct() {
        //nếu như không tồn tại session user và controller không phải là Login để tránh trường hợp chuyển hướng lặp lại liên tục

        if (!isset($_SESSION['user']) && $_GET['controller'] != 'login') {
            $_SESSION['error'] = 'Bạn chưa đăng nhập';
            header('Location: index.php?controller=login&action=login');
            exit();
        }
    }
    //chứa thông tin về lỗi validate của form
    public $error;
    //chứa thông tin của nội dung view theo từng chức năng
    public $content;

    //phương thức dùng để lấy nội dung view động
    //$file: đường dẫn tới file view
    //$variales: mảng các phần tử, chính là các biến sẽ
    //sử dụng ở trong view
    public function render($file, $variables = []) {
//        [
//            'categories' => $categories
//        ]
        //giải nén mảng $variables -> dùng tên biến dựa theo
        //key của mảng -> categories
        extract($variables);
        //mở vùng đệm để ghi nhớ nội dung view
        ob_start();
        //nhúng đường dẫn file view
        require_once $file;
        //kết thúc việc ghi nội dung file
        $view = ob_get_clean();
        return $view;
    }
}