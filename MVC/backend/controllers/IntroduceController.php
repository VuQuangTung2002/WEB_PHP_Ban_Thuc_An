<?php
require_once 'controllers/Controller.php';
require_once 'models/Introduce.php';
require_once 'models/Category.php';

class IntroduceController extends Controller {
    public function index() {
        $introduce_model = new Introduce();
        $introduces = $introduce_model->getAll();
        $this->content = $this->render('views/introduces/index.php', [
            'introduces' => $introduces
        ]);
        require_once 'views/layouts/main.php';
    }

    public function create() {
        //xử lý submit form
        if (isset($_POST['submit'])) {
            $title = $_POST['title'];
            $summary = $_POST['summary'];
            $content = $_POST['content'];
            $status = $_POST['status'];

            //xử lý validate
            if (empty($title)) {
                $this->error = 'Không được để trống title';
            }else if (empty($summary)) {
                $this->error = 'Không được để trống summary';
            }else if ($_FILES['avatar']['error'] == 0) {
                // validate khi có file upload lên thì bắt buộc phải là ảnh và dung lượng không quá 2mb
                $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                $extension = strtolower($extension);
                $arr_extension = ['jpg', 'jpeg', 'png', 'gif'];

                $file_size_mb = $_FILES['avatar']['size'] / 1024 / 1024;
                //làm tròn theo đơn vị thập phân
                $file_size_mb = round($file_size_mb, 2);

                if (!in_array($extension, $arr_extension)) {
                    $this->error = 'Cần upload file định dạng ảnh';
                } else if ($file_size_mb > 2) {
                    $this->error = 'File upload không được quá 2MB';
                }
            }

            //nếu không có lỗi thì tiến hành save dữ liệu
            if (empty($this->error)) {
                $filename = '';
                //xử lý upload file nếu có
                if ($_FILES['avatar']['error'] == 0) {
                    $dir_uploads = __DIR__ . '/../assets/uploads';
                    if (!file_exists($dir_uploads)) {
                        mkdir($dir_uploads);
                    }
                    //tạo tên file theo 1 chuỗi ngẫu nhiên để tránh upload file trùng lặp
                    $filename = time() . '-product-' . $_FILES['avatar']['name'];
                    move_uploaded_file($_FILES['avatar']['tmp_name'], $dir_uploads . '/' . $filename);
                }

                // save dữ liệu vào bảng news
                $introduce_model = new Introduce();
                $introduce_model->title = $title;
                $introduce_model->summary = $summary;
                $introduce_model->avatar = $filename;
                $introduce_model->content = $content;
                $introduce_model->status = $status;
                $is_insert = $introduce_model->insert();
                if ($is_insert) {
                    $_SESSION['success'] = 'Insert dữ liệu thành công';
                } else {
                    $_SESSION['error'] = 'Insert dữ liệu thất bại';
                }
                header('Location: index.php?controller=introduce&action=index');
                exit();
            }
        }

        $this->content = $this->render('views/introduces/create.php');
        require_once 'views/layouts/main.php';
    }

    public function update() {
        $id = $_GET['id'];
        $introduce_model = new Introduce();
        $introduce = $introduce_model->getById($id);
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=introduce');
            exit();
        }


        //xử lý submit form
        if (isset($_POST['submit'])){
            $title = $_POST['title'];
            $summary = $_POST['summary'];
            $content = $_POST['content'];
            $status = $_POST['status'];

            //xử lý validate
            if (empty($title)) {
                $this->error = 'Không được để trống title';
            }else if (empty($summary)) {
                $this->error = 'Không được để trống summary';
            }else if ($_FILES['avatar']['error'] == 0) {
                //validate khi có file upload lên thì bắt buộc phải là ảnh và dung lượng không quá 2 Mb
                $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                $extension = strtolower($extension);
                $arr_extension = ['jpg', 'jpeg', 'png', 'gif'];

                $file_size_mb = $_FILES['avatar']['size'] / 1024 / 1024;
                //làm tròn theo đơn vị thập phân
                $file_size_mb = round($file_size_mb, 2);

                if (!in_array($extension, $arr_extension)) {
                    $this->error = 'Cần upload file định dạng ảnh';
                } else if ($file_size_mb > 2) {
                    $this->error = 'File upload không được quá 2MB';
                }
            }

            //nếu không có lỗi thì tiến hành save dữ liệu
            if (empty($this->error)) {
                $filename = $introduce['avatar'];
                //xử lý upload file nếu có
                if ($_FILES['avatar']['error'] == 0) {
                    $dir_uploads = __DIR__ . '/../assets/uploads';
                    //xóa file cũ, thêm @ vào trước hàm unlink để tránh báo lỗi khi xóa file ko tồn tại
                    @unlink($dir_uploads . '/' . $filename);
                    if (!file_exists($dir_uploads)) {
                        mkdir($dir_uploads);
                    }
                    //tạo tên file theo 1 chuỗi ngẫu nhiên để tránh upload file trùng lặp
                    $filename = time() . '-introduce-' . $_FILES['avatar']['name'];
                    move_uploaded_file($_FILES['avatar']['tmp_name'], $dir_uploads . '/' . $filename);
                }

                //save dữ liệu vào bảng news
                $introduce_model->title = $title;
                $introduce_model->summary = $summary;
                $introduce_model->avatar = $filename;
                $introduce_model->content = $content;
                $introduce_model->status = $status;
                $introduce_model->updated_at = date('Y-m-d H:i:s');

                $is_update = $introduce_model->update($id);
                if ($is_update) {
                    $_SESSION['success'] = 'Update dữ liệu thành công';
                } else {
                    $_SESSION['error'] = 'Update dữ liệu thất bại';
                }
                header('Location: index.php?controller=introduce');
                exit();
            }
        }


        $this->content = $this->render('views/introduces/update.php', [
            'introduce' => $introduce
        ]);
        require_once 'views/layouts/main.php';
    }

    public function detail() {
        $id = $_GET['id'];
        $introduce_model = new Introduce();
        $introduce = $introduce_model->getById($id);

        $this->content = $this->render('views/introduces/detail.php', [
            'introduce' => $introduce
        ]);
        require_once 'views/layouts/main.php';
    }

    public function delete() {
        $id = $_GET['id'];
        $introduce_model = new Introduce();
        $is_delete = $introduce_model->delete($id);
        if ($is_delete) {
            $_SESSION['success'] = 'Xóa dữ liệu thành công';
        } else {
            $_SESSION['error'] = 'Xóa dữ liệu thất bại';
        }
        header('Location: index.php?controller=introduce');
        exit();
    }
}