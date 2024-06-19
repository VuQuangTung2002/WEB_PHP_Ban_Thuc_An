<?php
//controllers/CategoryController
require_once 'controllers/Controller.php';
require_once 'models/Category.php';
//nhúng class phân trang
require_once 'models/Pagination.php';
class CategoryController extends Controller {

    //liệt kê danh mục
    public function index() {
        //khởi tạo 1 mảng params chứa các giá trị search nếu có 
        $params = [];
        //xử lý submit khi search để thêm các phần tử cho mảng param
        // echo "<pre>";
        // print_r($_GET);
        // echo "</pre>";
        if (isset($_GET['submit'])) {
          $params['name'] = $_GET['name'];
          $params['status'] = $_GET['status'];
        }
        //gọi model để truy vấn lấy tất cả danh mục, sau đó
        //hiển thị ra view
        $category_model = new Category();

       
        //tạo ra mảng các biến để view có thể sử dụng
        

        //hiển thị cơ chế phân trang cho trang list category
        // khởi tạo đối tượng từ class Pagination
        //tạo 1 mảng params để truyền vào class
        //hiện tại đang dùng dữ liệu tĩnh
        // goi model để lấy ra tổng số bản ghi dang có trong bảng categories
        $total = $category_model->getTotal();
        //cần xác định giá trị start: lấy từ bản ghi thứ mấy để sử dụng cho câu truy vấn LIMIT start, limit
        //dựa theo trang hiện tại để tính ra start
        $page = 1;
        if(isset($_GET['page'])) {
          $page = $_GET['page'];
        }
        //tính ra giá trị start
        $limit = 2;
        $start = ($page-1) * $limit;
        $params_pagination = [
          'total' => $total,
          'limit' => $limit,
          'controller' => 'category',
          'action' => 'index',
          'full_mode' => FALSE
        ];

        //gán thêm các phần tử cho mảng $params ban đầu
        $params['limit'] = $limit;
        $params['start'] = $start;

        $categories = $category_model->getAll($params);
		

        //SELECT * FORM categories LIMIT start, limit nếu ở trang 2L
        //SELECT * FROM categories LIMIT 5, 5
        //do phương thức khởi tạo của pagination đang bắt buộc phải truyền vào 1 mảng params
        //tham số page trên url = 1 start = 0, limit = 5 tham số page trên url = 2, start = 5, limit = 5 tham số page trên url = 3, start = 10, limit = 5
        $pagination_model = new Pagination($params_pagination);
        //gọi phương thức hiển thị phân trang
        $pagination = $pagination_model->getPagination();
        //echo $pagination;
        // tạo ra mảng các biến để view có thể sử dụng
        $arr_output = [
            'categories' => $categories,
            'pagination' => $pagination
        ];
        //lấy nội dung view tương ứng
        $this->content = $this
            ->render('views/categories/index.php', $arr_output);
        //gọi(nhúng file) layout để gắn nội dung view đó
       require_once 'views/layouts/main.php';
    }

  public function create()
  {
    if (isset($_POST['submit'])) {
      $name = $_POST['name'];
      $description = $_POST['description'];
      $status = $_POST['status'];
      $avatar_files = $_FILES['avatar'];

      //check validate
      if (empty($name)) {
        $this->error = 'Cần nhập tên';
      } //trường hợp có ảnh upload lên, thì cần kiểm tra điều kiện là file ảnh
      else if ($avatar_files['error'] == 0) {
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

      //nếu ko có lỗi thì tiến hành lưu dữ liệu và upload ảnh nếu có
      $avatar = '';
      if (empty($this->error)) {
        //xử lý upload ảnh nếu có
        if ($avatar_files['error'] == 0) {
          $dir_uploads = __DIR__ . '/../assets/uploads';
          if (!file_exists($dir_uploads)) {
            mkdir($dir_uploads);
          }
          $avatar = time() . '-' . $avatar_files['name'];
          move_uploaded_file($avatar_files['tmp_name'], $dir_uploads . '/' . $avatar);
        }
        //lưu vào csdl
        //gọi model để thực  hiện lưu
        $category_model = new Category();
        //gán các giá trị từ form cho các thuộc tính của category
        $category_model->name = $name;
        $category_model->avatar = $avatar;
        $category_model->description = $description;
        $category_model->status = $status;
        //gọi phương thức insert
        $is_insert = $category_model->insert();
        if ($is_insert) {
          $_SESSION['success'] = 'Thêm mới thành công';
        } else {
          $_SESSION['error'] = 'Thêm mới thất bại';
        }
        header('Location: index.php?controller=category&action=index');
        exit();
      }

    }

    //lấy nội dung view create.php
    $this->content = $this->render('views/categories/create.php');
    //gọi layout để nhúng nội dung view create vừa lấy đc
    require_once 'views/layouts/main.php';
  }

  public function update()
  {
    //về cơ bản update sẽ khá giống create
    //lấy category theo id bắt đươc
    //check validate nếu id không tồn tại thì báo lỗi
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
      $_SESSION['error'] = 'ID category không hợp lệ';
      header('Location: index.php?controller=category&action=index');
      exit();
    }

    $id = $_GET['id'];
    $category_model = new Category();
    $category = $category_model->getCategoryById($id);
    //submit form
    if (isset($_POST['submit'])) {
      $name = $_POST['name'];
      $description = $_POST['description'];
      $status = $_POST['status'];
      $avatar_files = $_FILES['avatar'];

      //check validate
      if (empty($name)) {
        $this->error = 'Cần nhập tên';
      } //trường hợp có ảnh upload lên, thì cần kiểm tra điều kiện là file ảnh
      else if ($avatar_files['error'] == 0) {
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

      //nếu ko có lỗi thì tiến hành lưu dữ liệu và upload ảnh nếu có
      $avatar = $category['avatar'];
      if (empty($this->error)) {
        //xử lý upload ảnh nếu có
        if ($avatar_files['error'] == 0) {
          //xóa file ảnh cũ đi

          $dir_uploads = __DIR__ . '/../assets/uploads';
          if (!file_exists($dir_uploads)) {
            mkdir($dir_uploads);
          }
          //xóa file ảnh cũ đi
          @unlink($dir_uploads . '/' . $avatar);
          //tạo tên file mới và save
          $avatar = time() . '-' . $avatar_files['name'];

          move_uploaded_file($avatar_files['tmp_name'], $dir_uploads . '/' . $avatar);
        }
        //lưu vào csdl
        //gọi model để thực  hiện lưu
        $category_model = new Category();
        //gán các giá trị từ form cho các thuộc tính của category
        $category_model->name = $name;
        $category_model->avatar = $avatar;
        $category_model->description = $description;
        $category_model->status = $status;
        $category_model->updated_at = date('Y-m-d H:i:s');
        //gọi phương thức update theo id
        $is_update = $category_model->update($id);
        if ($is_update) {
          $_SESSION['success'] = 'Update thành công';
        } else {
          $_SESSION['error'] = 'Update thất bại';
        }
        header('Location: index.php?controller=category&action=index');
        exit();
      }

    }

    //lấy nội dung view create.php
    $this->content = $this->render('views/categories/update.php', ['category' => $category]);
    //gọi layout để nhúng nội dung view create vừa lấy đc
    require_once 'views/layouts/main.php';
  }

  public function delete()
  {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
      $_SESSION['error'] = 'ID không hợp lệ';
      header('Location: index.php?controller=category&action=index');
      exit();
    }
    $id = $_GET['id'];
    $category_model = new Category();
    $is_delete = $category_model->delete($id);
    if ($is_delete) {
      $_SESSION['success'] = 'Xóa thành công';
    } else {
      $_SESSION['error'] = 'Xóa thất bại';
    }
    header('Location: index.php?controller=category&action=index');
    exit();
  }

  public function detail()
  {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
      $_SESSION['error'] = 'ID không hợp lệ';
      header('Location: index.php?controller=category&action=index');
      exit();
    }
    $id = $_GET['id'];
    $category_model = new Category();
    $category = $category_model->getCategoryById($id);
    //lấy nội dung view create.php
    $this->content = $this->render('views/categories/detail.php', [
        'category' => $category
    ]);
    //gọi layout để nhúng nội dung view detail vừa lấy đc
    require_once 'views/layouts/main.php';

  }
}