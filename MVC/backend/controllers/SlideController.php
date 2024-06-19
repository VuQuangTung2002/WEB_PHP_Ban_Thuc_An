<?php
require_once 'controllers/Controller.php';
require_once 'models/Slide.php';
require_once 'models/Category.php';

class SlideController extends Controller {
    public function index() {
        $slide_model = new Slide();
        $slides = $slide_model->getAll();
        $arr_output = [
            'slides' => $slides
        ];

        $this->content = $this->render('views/slides/index.php', $arr_output);
        //gọi(nhúng file) layout để gắn nội dung view đó
        require_once 'views/layouts/main.php';
    }

    //thêm mới
    public function create() {
        //xử lý submit form
        if (isset($_POST['submit'])) {
//            echo "<pre>";
//            print_r($_FILES);
//            echo "</pre>";
            $avatar_files = $_FILES['avatar'];
            $position = $_POST['position'];
            $component_img_files = $_FILES['component_img'];
            $title_component = $_POST['title_component'];
            $title_detail = $_POST['title_detail'];
            $store_img_files = $_FILES['store_img'];
            $status = $_POST['status'];

                //xử lý validate
            if (empty($position)){
                $this->error = 'Không được để trống position';
            }else if ($avatar_files['error'] == 0) {
                $extension_arr = ['jpg', 'jpeg', 'gif', 'png'];
                $extension = pathinfo($avatar_files['name'], PATHINFO_EXTENSION);
                $extension = strtolower($extension);
                $file_size_mb = $avatar_files['size'] / 1024 / 1024;
                //làm tròn theo đơn vị thập phân
                $file_size_mb = round($file_size_mb, 2);

                if (!in_array($extension, $extension_arr)) {
                    $this->error = 'Cần upload file định dạng ảnh';
                } else if ($file_size_mb >= 2) {
                    $this->error = 'File upload không được lớn hơn 2Mb';
                }
            }

            //nếu không có lỗi tiến hành lưu dữ liệu và upload ảnh nếu có
            $avatar = '';
            $component_img = '';
            $store_img = '';
            if (empty($this->error)) {
                //xử lý upload ảnh nếu có
                if ($avatar_files['error'] == 0) {
                    $avatar_uploads = __DIR__ . '/../assets/uploads';
                    if (!file_exists($avatar_uploads)) {
                        mkdir($avatar_uploads);
                    }
                    $avatar = time() . '-' . $avatar_files['name'];
                    move_uploaded_file($avatar_files['tmp_name'], $avatar_uploads . '/' . $avatar);

                    if ($component_img_files['error'] == 0){
                        $dir_uploads = __DIR__ . '/../assets/uploads';
                        if (!file_exists($dir_uploads)) {
                            mkdir($dir_uploads);
                        }
                        $component_img = time() . '-' . $component_img_files['name'];
                        move_uploaded_file($component_img_files['tmp_name'], $dir_uploads . '/' . $component_img);
                    }

                    if ($store_img_files['error'] == 0){
                        $store_uploads = __DIR__ . '/../assets/uploads';
                        if (!file_exists($store_uploads)) {
                            mkdir($store_uploads);
                        }
                        $store_img = time() . '-' . $store_img_files['name'];
                        move_uploaded_file($store_img_files['tmp_name'], $store_uploads . '/' . $store_img);
                    }
                }
                //lưu vào csdl
                //gọi model để thực  hiện lưu
                $slide_model = new Slide();
                //gán các giá trị từ form cho các thuộc tính của category
                $slide_model->avatar = $avatar;
                $slide_model->position = $position;
                $slide_model->component_img = $component_img;
                $slide_model->title_component = $title_component;
                $slide_model->title_detail = $title_detail;
                $slide_model->store_img = $store_img;
                $slide_model->status = $status;
                //gọi phương thức insert
                $is_insert = $slide_model->insert();
                if ($is_insert) {
                    $_SESSION['success'] = 'Thêm mới thành công';
                } else {
                    $_SESSION['error'] = 'Thêm mới thất bại';
                }
                header('Location: index.php?controller=slide&action=index');
                exit();
            }
        }
        $this->content = $this->render('views/slides/create.php');
        require_once 'views/layouts/main.php';
    }

    public function update() {
        $id = $_GET['id'];
        $slide_model = new Slide();
        $slide = $slide_model->getById($id);
        //xử lý submit form
        if (isset($_POST['submit'])) {

            $avatar_files = $_FILES['avatar'];
            $position = $_POST['position'];
            $component_img_files = $_FILES['component_img'];
            $title_component = $_POST['title_component'];
            $title_detail = $_POST['title_detail'];
            $store_img_files = $_FILES['store_img'];
            $status = $_POST['status'];

            //xử lý validate
            if (empty($position)){
                $this->error = 'Không được để trống position';
            }else if ($avatar_files['error'] == 0) {
                $extension_arr = ['jpg', 'jpeg', 'gif', 'png'];
                $extension = pathinfo($avatar_files['name'], PATHINFO_EXTENSION);
                $extension = strtolower($extension);
                $file_size_mb = $avatar_files['size'] / 1024 / 1024;
                //làm tròn theo đơn vị thập phân
                $file_size_mb = round($file_size_mb, 2);

                if (!in_array($extension, $extension_arr)) {
                    $this->error = 'Cần upload file định dạng ảnh';
                } else if ($file_size_mb >= 2) {
                    $this->error = 'File upload không được lớn hơn 2Mb';
                }
            }
//            echo "<pre>";
//            print_r($_FILES);
//            echo "</pre>";
            //nếu không có lỗi tiến hành lưu dữ liệu và upload ảnh nếu có

            if (empty($this->error)) {
                $filename_ava = $slide['avatar'];
                $filename_compo = $slide['component_img'];
                $filename_sto = $slide['store_img'];
                //xử lý upload ảnh nếu có
                if ($avatar_files['error'] == 0) {
                    $avatar_uploads = __DIR__ . '/../assets/uploads';
                    //xóa file cũ, thêm @ vào trước hàm unlink để tránh báo lỗi khi xóa file ko tồn tại
                    @unlink($avatar_uploads . '/' . $filename_ava);
                    if (!file_exists($avatar_uploads)) {
                        mkdir($avatar_uploads);
                    }
                    $filename_ava = time() . '-' . $avatar_files['name'];
                    move_uploaded_file($avatar_files['tmp_name'], $avatar_uploads . '/' . $filename_ava);
                }
                    if ($component_img_files['error'] == 0){
                        $dir_uploads = __DIR__ . '/../assets/uploads';
                        //xóa file cũ, thêm @ vào trước hàm unlink để tránh báo lỗi khi xóa file ko tồn tại
                        @unlink($dir_uploads . '/' . $filename_compo);
                        if (!file_exists($dir_uploads)) {
                            mkdir($dir_uploads);
                        }
                        $filename_compo = time() . '-' . $component_img_files['name'];
                        move_uploaded_file($component_img_files['tmp_name'], $dir_uploads . '/' . $filename_compo);
                    }

                    if ($store_img_files['error'] == 0){
                        $dir_uploads = __DIR__ . '/../assets/uploads';
                        //xóa file cũ, thêm @ vào trước hàm unlink để tránh báo lỗi khi xóa file ko tồn tại
                        @unlink($dir_uploads . '/' . $filename_sto);
                        if (!file_exists($dir_uploads)) {
                            mkdir($dir_uploads);
                        }
                        $filename_sto = time() . '-' . $store_img_files['name'];
                        move_uploaded_file($store_img_files['tmp_name'], $dir_uploads . '/' . $filename_sto);
                    }

                echo "<pre>";
                print_r($store_img_files);
                echo "</pre>";
                //lưu vào csdl
                //gọi model để thực  hiện lưu

                //gán các giá trị từ form cho các thuộc tính của category
                $slide_model->avatar = $filename_ava;
                $slide_model->position = $position;
                $slide_model->component_img = $filename_compo;
                $slide_model->title_component = $title_component;
                $slide_model->title_detail = $title_detail;
                $slide_model->store_img = $filename_sto;
                $slide_model->status = $status;
                $slide_model->updated_at = date('Y-m-d H:i:s');
                //gọi phương thức insert
                echo "<pre>";
            print_r($slide_model);
            echo "</pre>";
                $is_update = $slide_model->update($id);
                if ($is_update) {
                    $_SESSION['success'] = 'Update dữ liệu thành công';
                } else {
                    $_SESSION['error'] = 'Update dữ liệu thất bại';
                }
                header('Location: index.php?controller=slide&action=index');
                exit();
            }
        }
        $this->content = $this->render('views/slides/update.php', [
            'slide' => $slide
        ]);
        require_once 'views/layouts/main.php';
    }
    public function delete() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=slide');
            exit();
        }

        $id = $_GET['id'];
        $product_model = new Slide();
        $is_delete = $product_model->delete($id);
        if ($is_delete) {
            $_SESSION['success'] = 'Xóa dữ liệu thành công';
        } else {
            $_SESSION['error'] = 'Xóa dữ liệu thất bại';
        }
        header('Location: index.php?controller=slide');
        exit();
    }

}