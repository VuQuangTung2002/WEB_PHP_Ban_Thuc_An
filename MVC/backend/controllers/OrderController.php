<?php
require_once 'controllers/Controller.php';
require_once 'models/Order.php';
require_once 'models/Category.php';

class OrderController extends Controller {
    public function index() {
        $order_model = new Order();
        $orders = $order_model->getAll();

        $this->content = $this->render('views/orders/index.php', [
            'orders' => $orders
        ]);
        require_once 'views/layouts/main.php';
    }

    public function detail() {
        $id = $_GET['id'];
        $order_model = new Order();
        $order = $order_model->getById($id);

        $this->content = $this->render('views/orders/detail.php', [
            'order' => $order
        ]);
        require_once 'views/layouts/main.php';
    }

    public function update() {
        $id = $_GET['id'];
        $order_model = new Order();
        $order = $order_model->getById($id);
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=order');
            exit();
        }


        //xử lý submit form
        if (isset($_POST['submit'])){
//            echo "<pre>";
//            print_r($_POST);
//            echo "</pre>";
            $fullname = $_POST['fullname'];
            $address = $_POST['address'];
            $mobile = $_POST['mobile'];
            $email = $_POST['email'];
            $note = $_POST['note'];
            $price_total = $_POST['price_total'];
            $payment_status = $_POST['payment_status'];

            //xử lý validate
            //xử lý validate
            if (empty($fullname)) {
                $this->error = 'Không được để trống fullname';
            }else if (empty($address)) {
                $this->error = 'Không được để trống address';
            }else if (empty($mobile)) {
                $this->error = 'Không được để trống mobile';
            }else if (empty($email)) {
                $this->error = 'Không được để trống email';
            }

            //nếu không có lỗi thì tiến hành save dữ liệu
            if (empty($this->error)) {
                //save dữ liệu vào bảng news
                $order_model->fullname = $fullname;
                $order_model->address = $address;
                $order_model->mobile = $mobile;
                $order_model->email = $email;
                $order_model->note = $note;
                $order_model->price_total = $price_total;
                $order_model->payment_status = $payment_status;
                $order_model->updated_at = date('Y-m-d H:i:s');

                $is_update = $order_model->update($id);
                if ($is_update) {
                    $_SESSION['success'] = 'Update dữ liệu thành công';
                } else {
                    $_SESSION['error'] = 'Update dữ liệu thất bại';
                }
                header('Location: index.php?controller=order');
                exit();
            }
        }


        $this->content = $this->render('views/orders/update.php', [
            'order' => $order
        ]);
        require_once 'views/layouts/main.php';
    }

    public function delete() {
        $id = $_GET['id'];
        $order_model = new Order();
        $is_delete = $order_model->delete($id);
        if ($is_delete) {
            $_SESSION['success'] = 'Xóa dữ liệu thành công';
        } else {
            $_SESSION['error'] = 'Xóa dữ liệu thất bại';
        }
        header('Location: index.php?controller=order');
        exit();
    }
}