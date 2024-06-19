<h2>Cập nhật giới thiệu</h2>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Nhập tiêu đề giới thiệu</label>
        <input type="text" name="title" value="<?php echo isset($_POST['title']) ? $_POST['title'] : $introduce['title'] ?>"
               class="form-control" id="title"/>
    </div>
    <div class="form-group">
        <label for="summary">Mô tả ngắn giới thiệu</label>
        <textarea name="summary" id="summary"
                  class="form-control"><?php echo isset($_POST['summary']) ? $_POST['summary'] : $introduce['summary'] ?></textarea>
    </div>
    <div class="form-group">
        <label for="avatar">Ảnh giới thiệu</label>
        <input type="file" name="avatar" value="" class="form-control" id="avatar"/>
        <?php if (!empty($introduce['avatar'])): ?>
            <img height="80" src="assets/uploads/<?php echo $introduce['avatar'] ?>"/>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="description">Mô tả chi tiết giới thiệu</label>
        <textarea name="content" id="description"
                  class="form-control"><?php echo isset($_POST['content']) ? $_POST['content'] : $introduce['content'] ?></textarea>
    </div>
    <div class="form-group">
        <label for="status">Trạng thái</label>
        <select name="status" class="form-control" id="status">
            <?php
            $selected_disabled = '';
            $selected_active = '';
            if ($introduce['status'] == 0) {
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
    <div class="form-group">
        <input type="submit" name="submit" value="Save" class="btn btn-primary"/>
        <a href="index.php?controller=introduce&action=index" class="btn btn-default">Back</a>
    </div>
</form>