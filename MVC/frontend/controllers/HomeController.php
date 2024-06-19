<?php
require_once 'controllers/Controller.php';
require_once 'models/Product.php';
require_once 'models/Slide.php';
require_once 'models/Introduce.php';
require_once 'models/New_Model.php';
require_once 'models/Contact.php';
require_once 'models/User.php';

class HomeController extends Controller {
    public function index() {

        //lấy các sản phẩm để hiển thị ra view
        $product_model = new Product();
        $products = $product_model->getByHot();

        $compo_model = new Slide();
        $compo_imgs = $compo_model->getComponent();

        $slide_model = new Slide();
        $slides = $slide_model->getSlide();

        $introduce_model = new Introduce();
        $introduces = $introduce_model->getAll();

        $new_model = new New_Model();
        $news = $new_model->getByNew();

        $contact_model = new Contact();
        $contacts = $contact_model->getAll();



//        echo "<pre>";
//        print_r($products);
//        echo "</pre>";

        //truyền biến $product ra view
        $this->content =
            $this->render('views/homes/index.php', [
                'products' => $products,
                'compo_imgs' => $compo_imgs,
                'introduces' => $introduces,
                'news' => $news
            ]);

        require_once 'views/layouts/main.php';
    }
}