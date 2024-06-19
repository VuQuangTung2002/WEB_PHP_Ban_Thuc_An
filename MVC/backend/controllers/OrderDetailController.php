<?php
require_once 'models/Product.php';
require_once 'controllers/Controller.php';
require_once 'models/Order_Detail.php';

class OrderDetailController extends Controller {
    public function index() {
        $order__detail_model = new Order_Detail();
        $order_details = $order__detail_model->get_order_detail();

        $this->content = $this->render('views/order_details/index.php', [
            'order_details' => $order_details
        ]);
        require_once 'views/layouts/main.php';
    }

    public function delete() {
        $order_id = $_GET['id'];
        $order_detail_model = new Order_Detail();
        $is_delete = $order_detail_model->delete_order_detail($order_id);
        if ($is_delete) {
            $_SESSION['success'] = 'Xóa dữ liệu thành công';
        } else {
            $_SESSION['error'] = 'Xóa dữ liệu thất bại';
        }

        header('Location: index.php?controller=orderdetail');
        exit();
    }
}