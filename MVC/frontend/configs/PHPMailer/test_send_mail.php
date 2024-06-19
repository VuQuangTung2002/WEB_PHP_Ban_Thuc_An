<?php
//PHPMailer/test_send_mail.php
//Test chức năng gửi mail sử dụng thư viên PHPMailer
//Thực tế nếu muốn gửi mail, nên dùng các thư viện bên ngoài, thay
//vì dùng hàm mail() của PHP. Vì việc gửi mail phụ thuộc vào nhiều
//yếu tố như cấu hình ...
?>

<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//comment lại đoạn này, vì đoạn này dùng cho framework
// Load Composer's autoloader
//require 'vendor/autoload.php';

//nhúng 3 file sau đây
require_once 'src/Exception.php';
require_once 'src/PHPMailer.php';
require_once 'src/SMTP.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //thêm dòng sau để hiển thị đc ký tự có dấu
  $mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    //sử dụng server gmail để gửi mail
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    //nhập tài khoản gmail cho username
    //tạm thời dùng tài khoản sau để
    // đỡ mất thời gian Xác minh 2 bươc
    $mail->Username   = 'nguyenvietmanhit@gmail.com';                     // SMTP username
    //password ko phải là pasword gmail, mà gmail có 1 cơ chế
    //tạo password cho các ứng dụng, password này độc lập với
    //password gmail của bạn
    $mail->Password   = 'eveoishoiioelqdg';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    //gửi từ ai
    $mail->setFrom('abc@gmail.com', 'Gui tu Manh');
    //gửi tới ai
    $mail->addAddress('nguyenvietmanhit@gmail.com');     // Add a recipient
//    $mail->addAddress('ellen@example.com');               // Name is optional
//    $mail->addReplyTo('info@example.com', 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');

    // Attachments
    //đính kèm file muốn gửi cùng mail
    $mail->addAttachment('image.jpeg');         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Tiêu đề gửi mail';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}



