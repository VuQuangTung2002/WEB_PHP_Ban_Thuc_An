<?php

require_once 'controllers/Controller.php';
require_once 'models/Introduce.php';
require_once 'models/Slide.php';
require_once 'models/Contact.php';

class IntroduceController extends Controller {
    public function index() {
        // không cần validate id vì rewrite url đã bắt case này r
        $slide_model = new Slide();
        $slides = $slide_model->getSlide();

        $contact_model = new Contact();
        $contacts = $contact_model->getAll();
        //gọi model để lấy product tương ứng dựa vào id vừa lấy được
        $introduce_model = new Introduce();
        $introduces = $introduce_model->getAll();
        //lấy nội dung view chi tiết tương ứng
        $this->content = $this->render('views/introduces/index.php', [
            'introduces' => $introduces,
            'slides' => $slides,
            'contacts' => $contacts
        ]);
        //gọi layout để hiển thị ra nội dung view
        require_once 'views/layouts/main.php';
    }
}