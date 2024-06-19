//Chờ HTML CSS hiển thị xong hết thị mới chạy JS
//để đẩm bảo code JS đặt trước hay sau HTML đều chạy đc
$(document).ready(function () {
    //Tích hợp CKeditor với textarea đang có name=description
    CKEDITOR.replace('description' , {
        //đường dẫn đến file ckfinder.html của ckfinder
        filebrowserBrowseUrl: 'assets/ckfinder/ckfinder.html',
        //đường dẫn đến file connector.php của ckfinder
        filebrowserUploadUrl: 'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
    });

});