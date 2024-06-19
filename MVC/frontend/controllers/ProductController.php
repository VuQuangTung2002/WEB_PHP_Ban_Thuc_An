<?php

require_once 'controllers/Controller.php';
require_once 'models/Category.php';
require_once 'models/Slide.php';
require_once 'models/Contact.php';
require_once 'models/Product.php';
class ProductController extends Controller{
    //Hiển thị chi tiết sản phẩm
    public function detail() {
        // không cần validate id vì rewrite url đã bắt case này r
        $id = $_GET['id'];
        //gọi model để lấy product tương ứng dựa vào id vừa lấy được
        $slide_model = new Slide();
        $slides = $slide_model->getSlide();

        $contact_model = new Contact();
        $contacts = $contact_model->getAll();

        $product_model = new Product();
        $product = $product_model->getById($id);
        //lấy nội dung view chi tiết tương ứng
        $this->content = $this->render('views/products/detail.php', [
            'slides' => $slides,
            'product' => $product,
            'contacts' => $contacts
        ]);
     //gọi layout để hiển thị ra nội dung view
        require_once 'views/layouts/main.php';
    }

    public function showAll() {
        // xử lý submit form - khi filer sản phẩm
        //debug thông tin form
        $params = [];
        if (isset($_POST['filter'])) {
            //xử lý lọc sản phẩm
            //câu truy vấn sẽ có dạng sau
            //tạo ra 2 biến kiểu string, chứa câu truy vấn khi lọc theo danh mục và khoảng giá
            $str_category_id = '';
            $str_price = '';
            // xử lý để lấy ra chuỗi truy vấn cho category id
            if (isset($_POST['category'])) {
                $str_implode_category = implode(',', $_POST['category']);
                $str_category_id = "($str_implode_category)";
                $str_category_id = "products.category_id IN $str_category_id";
                $params['str_category_id'] = $str_category_id;
//                var_dump($str_implode_category);
            }
            // xử lý price
            if (isset($_POST['price'])) {
                foreach ($_POST['price'] AS $price) {
                    switch ($price) {
                        case 1: $str_price .= " OR products.price < 10000";
                        break;
                        case 2: $str_price .= " OR products.price BETWEEN 10000 AND 30000";
                        break;
                        case 3: $str_price .= " OR products.price BETWEEN 30000 AND 50000";
                        break;
                        case 4: $str_price .= " OR products.price BETWEEN 50000 AND 80000";
                        break;
                        case 5: $str_price .= " OR products.price > 80000";
                        break;
                    }
                }
                // cắt bỏ OR ở đầu chuỗi
                $str_price = substr($str_price, 3);
                $str_price = "($str_price)";

                $params['str_price'] = $str_price;

            }
        }

        // lấy ra danh sách categories để hiển thị ra phần lọc
        // danh mục
        $category_model = new Category();
        $categories = $category_model->getAll();
        //lấy ra slide để hiển thị ra phần silde
        $slide_model = new Slide();
        $slides = $slide_model->getSlide();

        $contact_model = new Contact();
        $contacts = $contact_model->getAll();
        //lấy ra tất cả sản phẩm trên hệ thống
        $product_model = new Product();
        // truyền mảng params chứa các chuỗi truy vấn liên quan đến lọc danh mục vầ price nếu có
        $products = $product_model->getAll($params);

        $this->content = $this->render('views/products/show_all.php', [
            'categories' => $categories,
            'slide' => $slides,
            'products' => $products,
            'contacts' => $contacts
        ]);
        require_once 'views/layouts/main.php';
    }
}