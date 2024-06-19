<?php
require_once 'controllers/Controller.php';
require_once 'models/Product.php';
require_once 'models/Slide.php';
require_once 'models/Contact.php';

// xử lý thêm sử xoá, liệt kê giỏ hàng
class CartController extends Controller {
    //xử lý thêm sản phẩm vào giỏ hàng
    public function add() {
//        echo "<pre>";
//        print_r($_GET);
//        echo "</pre>";
        //xử lý logic thêm vào giỏ hàng
        //lấy ra thông tin sản phẩm dựa vào id bắt được từ url do dùng rewrite id r nên ko cần bắt lại bằng code
        $id = $_GET['id'];
        $product_model = new Product();
        $product = $product_model->getById($id);
//        echo "<pre>";
//        print_r($product);
//        echo "</pre>";
        //tạo 1 mảng chứa các thông tin cần thiết để thêm giỏ hàng
        $cart = [
            'name' => $product['title'],
            'price' => $product['price'],
            'avatar' => $product['avatar'],
            //mặc định mỗi lần thêm chỉ thêm 1 sản phẩm
            'quality' => 1
        ];

        //nếu tại thời điểm thêm sản phẩm vào giỏ hàng mà giỏ hàng chưa từng tồn tại thì tạo mới giỏ hàng và thêm sản phẩm vào giỏ hàng
        // 2- Nếu giỏ hàng đã tồn tại r thì lại có 2 trường hợp sau:
        // + SP chưa tồn tại trong giỏ hàng -> thêm mới (giống bước 1)
        // + nếu sản phẩm tồn tại trong giỏ hàng r -> tăng số lượng lên 1
        // đặt tên giỏ hàng = cart
        if (!isset($_SESSION['cart'])) {
            // khởi tạo giá trị giỏ hàng và thêm mới sản phẩm vào giỏ hàng
            // cấu trúc phần tử của giỏ hàng:
            // key chính là id của sản phẩm
            // value chính là mảng các thông tin của sản phẩm dó
            $_SESSION['cart'][$id] = $cart;
        }else {
          // nếu sp thêm vào chưa tồn tại trong giỏ hàng, thì thực hiện thêm mới
            // tương đương id của sp khi thêm ko tồn tại trong danh sách các key của giỏ hàng
            if (!array_key_exists($id, $_SESSION['cart'])) {
                $_SESSION['cart'][$id] = $cart;
            } else {
                // trường hợp id sp đã tồn tại trong danh sách các key của mảng giỏ hàng thì chỉ cập nhật số lượng cho phần tử đó trong giỏ hàng
                $_SESSION['cart'][$id]['quality']++;
            }
        }
        //chuyển hướng về trang giỏ hàng của bạn
        //chú ý: khi chuyển hướng với url đã đc rewrite thì cần sử dụng cách sau để set lại url gốc cho trang
        $url_redirect = $_SERVER['SCRIPT_NAME'] .'/gio-hang-cua-ban';
        header("Location: $url_redirect");
        exit();
    }

    //liệt kê giỏ hàng
    public function index() {
        //xử lý submit form, cập nhật lại giỏ hàng
        // debug thông tin mảng $_POST để xem dữ liệu gửi từ form
        // nếu user submit form, click nut cập nhật giỏ hàng
        if (isset($_POST['submit'])) {
            // lặp giỏ hàng và gán số lượng tương ứng với sản phẩm trong giỏ hàng được gửi từ form lên cho giỏ hàng tương ứng
           foreach ($_SESSION['cart'] AS $product_id => $cart) {
                $_SESSION['cart'][$product_id]['quality'] = $_POST[$product_id];
            }
        }

        $slide_model = new Slide();
        $slides = $slide_model->getSlide();

        $contact_model = new Contact();
        $contacts = $contact_model->getAll();
        $this->content = $this->render('views/carts/index.php', [
            'slides' => $slides,
            'contacts' => $contacts
        ]);
        require_once 'views/layouts/main.php';
    }

    public function delete() {
        //do đã dùng rewrite url để validate id r nên k cần code validate nữa
        $product_id = $_GET['id'];
        //xoá phần tử của giỏ hàng với key chính là id của sản phẩm vừa bắt được từ url
        unset($_SESSION['cart'][$product_id]);
        //nếu như xoá hết toàn bộ sản phẩm trong giỏ hàng thì sẽ xoá luôn giỏ hàng
        if (empty($_SESSION['cart'])){
            unset($_SESSION['cart']);
        }
        $_SESSION['success'] = 'Xoá sản phẩm khỏi giỏ hàng thành công';

        //chuyển hướng về trang giỏ hàng của bạn
        // khi chuyển hướng về link url dạng rewrite thì cần lấy được url gốc của ứng dụng
        $url_redirect = $_SERVER['SCRIPT_NAME'] . '/gio-hang-cua-ban';
        header("Location: $url_redirect");
        exit();
    }
}