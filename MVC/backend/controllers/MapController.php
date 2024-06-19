<?php
require_once 'controllers/Controller.php';
require_once 'models/Map.php';
require_once 'models/Category.php';

class MapController extends Controller {

    public function index() {
        $map_model = new Map();
        $maps = $map_model->getAll();

        $this->content = $this->render('views/maps/index.php', [
            'maps' => $maps
        ]);
        require_once 'views/layouts/main.php';
    }
    public function create() {
        //xử lý submit form
        if (isset($_POST['submit'])) {
            $title = $_POST['title'];
            $hotline = $_POST['hotline'];
            $fax = $_POST['fax'];
            $email = $_POST['email'];
            $summary = $_POST['summary'];
            $map_url = $_POST['map_url'];
            $status = $_POST['status'];

            //xử lý validate
            if (empty($title)) {
                $this->error = 'Không được để trống title';
            }else if (empty($hotline)) {
                $this->error = 'Không được để trống hotline';
            }else if (empty($fax)) {
                $this->error = 'Không được để trống fax';
            }else if (empty($email)) {
                $this->error = 'Không được để trống email';
            }else if (empty($map_url)) {
                $this->error = 'Không được để trống map_url';
            }

            //nếu không có lỗi thì tiến hành save dữ liệu
            if (empty($this->error)) {

                // save dữ liệu vào bảng news
                $map_model = new Map();
                $map_model->title = $title;
                $map_model->hotline = $hotline;
                $map_model->fax = $fax;
                $map_model->email = $email;
                $map_model->summary = $summary;
                $map_model->map_url = $map_url;
                $map_model->status = $status;
                $is_insert = $map_model->insert();
                if ($is_insert) {
                    $_SESSION['success'] = 'Insert dữ liệu thành công';
                } else {
                    $_SESSION['error'] = 'Insert dữ liệu thất bại';
                }
                header('Location: index.php?controller=map&action=index');
                exit();
            }
        }

        $this->content = $this->render('views/maps/create.php');
        require_once 'views/layouts/main.php';
    }

    public function update() {
        $id = $_GET['id'];
        $map_model = new Map();
        $map = $map_model->getById($id);
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=map');
            exit();
        }


        //xử lý submit form
        if (isset($_POST['submit'])){
//            echo "<pre>";
//            print_r($_POST);
//            echo "</pre>";
            $title = $_POST['title'];
            $hotline = $_POST['hotline'];
            $fax = $_POST['fax'];
            $email = $_POST['email'];
            $summary = $_POST['summary'];
            $map_url = $_POST['map_url'];
            $status = $_POST['status'];

            //xử lý validate
            if (empty($title)) {
                $this->error = 'Không được để trống title';
            }else if (empty($hotline)) {
                $this->error = 'Không được để trống hotline';
            }else if (empty($fax)) {
                $this->error = 'Không được để trống fax';
            }else if (empty($email)) {
                $this->error = 'Không được để trống email';
            }else if (empty($map_url)) {
                $this->error = 'Không được để trống map_url';
            }

            //nếu không có lỗi thì tiến hành save dữ liệu
            if (empty($this->error)) {

                //save dữ liệu vào bảng maps
                $map_model->title = $title;
                $map_model->hotline = $hotline;
                $map_model->fax = $fax;
                $map_model->email = $email;
                $map_model->summary = $summary;
                $map_model->map_url = $map_url;
                $map_model->status = $status;
                $map_model->updated_at = date('Y-m-d H:i:s');

                $is_update = $map_model->update($id);
                if ($is_update) {
                    $_SESSION['success'] = 'Update dữ liệu thành công';
                } else {
                    $_SESSION['error'] = 'Update dữ liệu thất bại';
                }
                header('Location: index.php?controller=map');
                exit();
            }
        }


        $this->content = $this->render('views/maps/update.php', [
            'map' => $map
        ]);
        require_once 'views/layouts/main.php';
    }

    public function detail() {
        $id = $_GET['id'];
        $map_model = new Map();
        $map = $map_model->getById($id);

        $this->content = $this->render('views/maps/detail.php', [
            'map' => $map
        ]);
        require_once 'views/layouts/main.php';
    }

    public function delete() {
        $id = $_GET['id'];
        $map_model = new Map();
        $is_delete = $map_model->delete($id);
        if ($is_delete) {
            $_SESSION['success'] = 'Xóa dữ liệu thành công';
        } else {
            $_SESSION['error'] = 'Xóa dữ liệu thất bại';
        }
        header('Location: index.php?controller=map');
        exit();
    }

}