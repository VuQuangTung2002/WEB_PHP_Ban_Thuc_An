<?php
require_once 'helpers/Helper.php';
?>
<h2>Cập nhật đặt hàng</h2>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="fullname">Họ tên khách hàng</label>
        <input type="text" name="fullname" value="<?php echo isset($_POST['fullname']) ? $_POST['fullname'] : $order['fullname'] ?>"
               class="form-control" id="fullname"/>
    </div>
    <div class="form-group">
        <label for="address">Địa chỉ khách hàng</label>
        <textarea name="address" id="address"
                  class="form-control"><?php echo isset($_POST['address']) ? $_POST['address'] : $order['address'] ?></textarea>
    </div>

    <div class="form-group">
        <label for="mobile">Số điện thoại</label>
        <input type="text" name="mobile" value="<?php echo isset($_POST['mobile']) ? $_POST['mobile'] : $order['mobile'] ?>"
               class="form-control" id="mobile"/>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : $order['email'] ?>"
               class="form-control" id="email"/>
    </div>
    <div class="form-group">
        <label for="note">Ghi chú từ khách hàng</label>
        <input type="text" name="note" value="<?php echo isset($_POST['note']) ? $_POST['note'] : $order['note'] ?>"
               class="form-control" id="note"/>
    </div>
    <div class="form-group">
        <label for="price_total">Tổng giá trị đơn hàng</label>
        <input type="text" name="price_total" value="<?php echo isset($_POST['price_total']) ? $_POST['price_total'] : $order['price_total'] ?>"
               class="form-control" id="price_total"/>
    </div>
    <div class="form-group">
        <label>Thanh toán</label>
        <?php
        $selected_inactive = '';
        $selected_active = '';
        switch ($order['payment_status']) {
            case Helper::STATUS_DISABLED:
                $selected_inactive = "selected=TRUE";
                break;
            case Helper::STATUS_ACTIVE:
                $selected_active = "selected=TRUE";
                break;
        }
        ?>
        <select name="payment_status" class="form-control">
            <option <?php echo $selected_inactive?>
                value="<?php echo Helper::STATUS_DISABLED ?>">
                <?php echo Helper::STATUS_INACTIVE_TEXT_ORDER; ?>
            </option>
            <option <?php echo $selected_active ?>
                value="<?php echo Helper::STATUS_ACTIVE; ?>">
                <?php echo Helper::STATUS_ACTIVE_TEXT_ORDER; ?>
            </option>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" name="submit" value="Save" class="btn btn-primary"/>
        <a href="index.php?controller=order&action=index" class="btn btn-default">Back</a>
    </div>
</form>