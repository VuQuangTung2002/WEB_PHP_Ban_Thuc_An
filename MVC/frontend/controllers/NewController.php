<?php

require_once 'controllers/Controller.php';
require_once 'models/New_Model.php';
require_once 'models/Slide.php';
require_once 'models/Contact.php';

class NewController extends Controller {

    public function index() {

        // không cần validate id vì rewrite url đã bắt case này r
        $slide_model = new Slide();
        $slides = $slide_model->getSlide();
        //gọi model để lấy product tương ứng dựa vào id vừa lấy được
        $new_model = new New_Model();
        $news = $new_model->getAll();

        $contact_model = new Contact();
        $contacts = $contact_model->getAll();
        //lấy nội dung view chi tiết tương ứng
        $this->content = $this->render('views/news/index.php', [
            'news' => $news,
            'slides' => $slides,
            'contacts' => $contacts
        ]);
        //gọi layout để hiển thị ra nội dung view
        require_once 'views/layouts/main.php';
    }

    public function detail() {
        // không cần validate id vì rewrite url đã bắt case này r
        $id = $_GET['id'];
        //gọi model để lấy product tương ứng dựa vào id vừa lấy được
        $slide_model = new Slide();
        $slides = $slide_model->getSlide();

        $contact_model = new Contact();
        $contacts = $contact_model->getAll();

        $new_model = new New_Model();
        $new = $new_model->getById($id);
        //lấy nội dung view chi tiết tương ứng
        $this->content = $this->render('views/news/detail.php', [
            'new' => $new,
            'slides' => $slides,
            'contacts' => $contacts
        ]);
        //gọi layout để hiển thị ra nội dung view
        require_once 'views/layouts/main.php';
    }
}