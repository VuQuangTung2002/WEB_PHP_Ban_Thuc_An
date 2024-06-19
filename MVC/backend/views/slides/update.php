<h2>Cập nhật slide</h2>
<form method="post" action="" enctype="multipart/form-data">


    <div class="form-group">
        <label>Ảnh slide</label>
        <input type="file" name="avatar" value="" class="form-control" id="avatar"/>
        <?php if (!empty($slide['avatar'])): ?>
            <img height="80" src="assets/uploads/<?php echo $slide['avatar'] ?>"/>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Vị trí hiển thị</label>
        <input type="number" min="1" value="1" name="position" class="form-control"
               value="<?php echo isset($_POST['position']) ? $_POST['position'] : $slide['position'] ?>"/>
    </div>
    <div class="form-group">
        <label>Ảnh Thành Phần</label>
        <input type="file" name="component_img" value="" class="form-control" id="component_img"/>
        <?php if (!empty($slide['component_img'])): ?>
            <img height="80" src="assets/uploads/<?php echo $slide['component_img'] ?>"/>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="title_component">Tiêu đề của ảnh thành phần</label>
        <input type="text" name="title_component" value="<?php echo isset($_POST['title_component']) ? $_POST['title_component'] : $slide['title_component'] ?>"
               class="form-control" id="title_component"/>
    </div>
    <div class="form-group">
        <label for="title_detail">Mô tả ngắn sản phẩm</label>
        <textarea name="title_detail" id="title_detail"
                  class="form-control"><?php echo isset($_POST['title_detail']) ? $_POST['title_detail'] : $slide['title_detail'] ?></textarea>
    </div>

    <div class="form-group">
        <label>Ảnh cửa hàng</label>
        <input type="file" name="store_img"
               class="form-control" />
        <?php if (!empty($slide['store_img'])): ?>
            <img height="80" src="assets/uploads/<?php echo $slide['store_img'] ?>"/>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="status">Trạng thái</label>
        <select name="status" class="form-control" id="status">
            <?php
            $selected_disabled = '';
            $selected_active = '';
            if ($product['status'] == 0) {
                $selected_disabled = 'selected';
            } else {
                $selected_active = 'selected';
            }
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

    <input type="submit" class="btn btn-primary" name="submit" value="Save"/>
    <a href="index.php?controller=slide&action=index" class="btn btn-default">Back</a>
</form>