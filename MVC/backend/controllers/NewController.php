<?php
require_once 'controllers/Controller.php';
require_once 'models/New_Model.php';
require_once 'models/Category.php';

class NewController extends Controller {
    public function index() {
        $new_model = new New_Model();
        $news = $new_model->getAll();
        $this->content = $this->render('views/news/index.php', [
            'news' => $news
        ]);
        require_once 'views/layouts/main.php';
    }

    public function create() {
        //xử lý submit form
        if (isset($_POST['submit'])) {
            $category_id = $_POST['category_id'];
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
                $new_model = new New_Model();
                $new_model->category_id = $category_id;
                $new_model->title = $title;
                $new_model->summary = $summary;
                $new_model->avatar = $filename;
                $new_model->content = $content;
                $new_model->status = $status;
                $is_insert = $new_model->insert();
                if ($is_insert) {
                    $_SESSION['success'] = 'Insert dữ liệu thành công';
                } else {
                    $_SESSION['error'] = 'Insert dữ liệu thất bại';
                }
                header('Location: index.php?controller=new&action=index');
                exit();
            }
        }
        $category_model = new Category();
        $categories = $category_model->getAll();

        $this->content = $this->render('views/news/create.php', [
            'categories' => $categories
        ]);
        require_once 'views/layouts/main.php';
    }

    public function update() {
        $id = $_GET['id'];
        $new_model = new New_Model();
        $new = $new_model->getById($id);
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=new');
            exit();
        }


        //xử lý submit form
        if (isset($_POST['submit'])){
            $category_id = $_POST['category_id'];
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
                $filename = $new['avatar'];
                //xử lý upload file nếu có
                if ($_FILES['avatar']['error'] == 0) {
                    $dir_uploads = __DIR__ . '/../assets/uploads';
                    //xóa file cũ, thêm @ vào trước hàm unlink để tránh báo lỗi khi xóa file ko tồn tại
                    @unlink($dir_uploads . '/' . $filename);
                    if (!file_exists($dir_uploads)) {
                        mkdir($dir_uploads);
                    }
                    //tạo tên file theo 1 chuỗi ngẫu nhiên để tránh upload file trùng lặp
                    $filename = time() . '-new-' . $_FILES['avatar']['name'];
                    move_uploaded_file($_FILES['avatar']['tmp_name'], $dir_uploads . '/' . $filename);
                }

                //save dữ liệu vào bảng news
                $new_model->category_id = $category_id;
                $new_model->title = $title;
                $new_model->summary = $summary;
                $new_model->avatar = $filename;
                $new_model->content = $content;
                $new_model->status = $status;
                $new_model->updated_at = date('Y-m-d H:i:s');

                $is_update = $new_model->update($id);
                if ($is_update) {
                    $_SESSION['success'] = 'Update dữ liệu thành công';
                } else {
                    $_SESSION['error'] = 'Update dữ liệu thất bại';
                }
                header('Location: index.php?controller=new');
                exit();
            }
        }
        $category_model = new Category();
        $categories = $category_model->getAll();

        $this->content = $this->render('views/news/update.php', [
            'categories' => $categories,
            'new' => $new
        ]);
        require_once 'views/layouts/main.php';
    }

    public function detail() {
        $id = $_GET['id'];
        $new_model = new New_Model();
        $new = $new_model->getById($id);

        $this->content = $this->render('views/news/detail.php', [
            'new' => $new
        ]);
        require_once 'views/layouts/main.php';
    }

    public function delete() {
        $id = $_GET['id'];
        $new_model = new New_Model();
        $is_delete = $new_model->delete($id);
        if ($is_delete) {
            $_SESSION['success'] = 'Xóa dữ liệu thành công';
        } else {
            $_SESSION['error'] = 'Xóa dữ liệu thất bại';
        }
        header('Location: index.php?controller=new');
        exit();
    }
}