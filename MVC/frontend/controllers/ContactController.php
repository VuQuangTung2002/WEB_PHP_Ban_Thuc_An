<?php

require_once 'controllers/Controller.php';
require_once 'models/Contact.php';
require_once 'models/Slide.php';

class ContactController extends Controller {
    public function index() {
        // không cần validate id vì rewrite url đã bắt case này r
        $slide_model = new Slide();
        $slides = $slide_model->getSlide();
        //gọi model để lấy product tương ứng dựa vào id vừa lấy được
        $contact_model = new Contact();
        $contacts = $contact_model->getAll();
        //lấy nội dung view chi tiết tương ứng
        $this->content = $this->render('views/contacts/index.php', [
            'contacts' => $contacts,
            'slides' => $slides
        ]);
        //gọi layout để hiển thị ra nội dung view
        require_once 'views/layouts/main.php';
    }
}