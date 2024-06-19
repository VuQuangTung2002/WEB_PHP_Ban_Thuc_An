<!-- signup.php -->
<!-- <h1>Form đăng ký user</h1> -->
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1 class="text-center">Đăng ký</h1>
            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Tải khoản: </label>
                    <input type="text" name="username" id="username" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu: </label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="confirm-password">Nhập lại mật khẩu: </label>
                    <input type="password" name="confirm_password" id="confirm-password" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Đăng ký" class="btn btn-primary">
                </div>
                Đã có tài khoản
                <a href="index.php?controller=login&action=login">Đăng nhập ngay</a>
            </form>
        </div>
    </div>
</div>
