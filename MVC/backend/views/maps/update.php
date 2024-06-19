<h2>Cập nhật bản đồ - liên hệ</h2>
<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Nhập địa chỉ liên hệ</label>
        <input type="text" name="title" value="<?php echo isset($_POST['title']) ? $_POST['title'] : $map['title'] ?>"
               class="form-control" id="title"/>
    </div>
    <div class="form-group">
        <label for="hotline">Nhập số Hotline</label>
        <input type="text" name="hotline" value="<?php echo isset($_POST['hotline']) ? $_POST['hotline'] : $map['hotline'] ?>"
               class="form-control" id="hotline"/>
    </div>
    <div class="form-group">
        <label for="fax">Nhập fax</label>
        <input type="text" name="fax" value="<?php echo isset($_POST['fax']) ? $_POST['fax'] : $map['fax'] ?>"
               class="form-control" id="fax"/>
    </div>
    <div class="form-group">
        <label for="email">Nhập email</label>
        <input type="text" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : $map['email'] ?>"
               class="form-control" id="email"/>
    </div>
    <div class="form-group">
        <label for="summary">Mô tả ngắn địa chỉ</label>
        <textarea name="summary" id="summary"
                  class="form-control"><?php echo isset($_POST['summary']) ? $_POST['summary'] : $map['summary'] ?></textarea>
    </div>
    <div class="form-group">
        <label for="map_url">Link bản đồ</label>
        <textarea name="map_url" id="map_url"
                  class="form-control"><?php echo isset($_POST['map_url']) ? $_POST['map_url'] : $map['map_url'] ?></textarea>
    </div>
    <div class="form-group">
        <label for="status">Trạng thái</label>
        <select name="status" class="form-control" id="status">
            <?php
            $selected_active = '';
            $selected_disabled = '';
            if (isset($_POST['status'])) {
                switch ($_POST['status']) {
                    case 0:
                        $selected_disabled = 'selected';
                        break;
                    case 1:
                        $selected_active = 'selected';
                        break;
                }
            }
            ?>
            <option value="0" <?php echo $selected_disabled; ?>>Disabled</option>
            <option value="1" <?php echo $selected_active ?>>Active</option>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" name="submit" value="Save" class="btn btn-primary"/>
        <a href="index.php?controller=map&action=index" class="btn btn-default">Back</a>
    </div>
</form>