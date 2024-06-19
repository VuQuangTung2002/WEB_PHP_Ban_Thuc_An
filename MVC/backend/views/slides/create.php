<h2>Thêm mới slide</h2>
<form method="post" action="" enctype="multipart/form-data">


    <div class="form-group">
        <label>Ảnh slide</label>
        <input type="file" name="avatar"
               class="form-control" />
    </div>

    <div class="form-group">
        <label>Vị trí hiển thị</label>
        <input type="number" min="1" value="1" name="position" class="form-control"
               value="<?php echo isset($_POST['position']) ? $_POST['position'] : '' ?>"/>
    </div>
    <div class="form-group">
        <label>Ảnh Thành Phần</label>
        <input type="file" name="component_img"
               class="form-control" />
    </div>
    <div class="form-group">
        <label for="title_component">Tiêu đề của ảnh thành phần</label>
        <input type="text" name="title_component" value="<?php echo isset($_POST['title_component']) ? $_POST['title_component'] : '' ?>"
               class="form-control" id="title_component"/>
    </div>
    <div class="form-group">
        <label for="title_detail">Mô tả ngắn sản phẩm</label>
        <textarea name="title_detail" id="title_detail"
                  class="form-control"><?php echo isset($_POST['title_detail']) ? $_POST['title_detail'] : '' ?></textarea>
    </div>

    <div class="form-group">
        <label>Ảnh cửa hàng</label>
        <input type="file" name="store_img"
               class="form-control" />
    </div>
    <div class="form-group">
        <?php
        $selected_active = '';
        $selected_disabled = '';
        if (isset($_POST['status'])) {
            switch ($_POST['status']) {
                case 1:
                    $selected_active = 'selected';
                    break;
                case 0:
                    $selected_disabled = 'selected';
                    break;
            }
        }
        ?>
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="1" <?php echo $selected_active ?> >Active</option>
            <option value="0" <?php echo $selected_disabled ?> >Disabled</option>
        </select>
    </div>

    <input type="submit" class="btn btn-primary" name="submit" value="Thêm mới"/>
    <a href="index.php?controller=slide&action=index" class="btn btn-default">Back</a>
</form>