<?php
//views/layouts/main.php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/AdminLTE.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="assets/css/_all-skins.min.css">
    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <?php
    //nhúng file header.php
    require_once 'views/layouts/header.php';
    ?>

    <!-- Messaeg Wrapper. Contains messaege error and success -->
    <div class="message-wrap content-wrap content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
<!--         Nếu có lỗi validate thì mới hiển thị ra   -->
            <?php if (!empty($this->error)): ?>
                <div class="alert alert-danger">
                    <?php echo $this->error; ?>
                </div>
            <?php endif ?>
            <!--         Nếu có lỗi session error thì mới hiển thị ra   -->
          <?php if (isset($_SESSION['error'])): ?>
              <div class="alert alert-danger">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
              </div>
          <?php endif ?>
            <!--         Nếu có session success thì mới hiển thị ra   -->
          <?php if (isset($_SESSION['success'])): ?>
              <div class="alert alert-success">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
              </div>
          <?php endif ?>
        </section>
    </div>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
<!--            Nội dung hiển thị ở đây-->
            <?php
            //thuộc tính content này sẽ nằm trong class controller
//            cha, chính là nội dung động theo từng view cụ thể
            echo $this->content;
            ?>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
    //nhúng lại file footer sau khi tách file
    require_once 'views/layouts/footer.php';
    ?>
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="assets/js/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="assets/js/jquery-ui.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/js/adminlte.min.js"></script>
<!--Tích hợp CKEditor-->
<script src="assets/ckeditor/ckeditor.js"></script>
<!--My script-->
<script src="assets/js/script.js"></script>
</body>
</html>

