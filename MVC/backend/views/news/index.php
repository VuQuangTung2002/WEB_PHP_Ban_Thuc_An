<?php
require_once 'helpers/Helper.php';
?>

<h2>Danh sách tin tức</h2>
<a href="index.php?controller=new&action=create" class="btn btn-success">
    <i class="fa fa-plus"></i> Thêm mới
</a>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Category name</th>
        <th>Title</th>
        <th>Avatar</th>
        <th>Status</th>
        <th>Created_at</th>
        <th>Updated_at</th>
        <th></th>
    </tr>
    <?php if (!empty($news)): ?>
        <?php foreach ($news as $new): ?>
            <tr>
                <td><?php echo $new['id'] ?></td>
                <td><?php echo $new['category_name'] ?></td>
                <td><?php echo $new['title'] ?></td>
                <td>
                    <?php if (!empty($new['avatar'])): ?>
                        <img height="80" src="assets/uploads/<?php echo $new['avatar'] ?>"/>
                    <?php endif; ?>
                </td>
                <td><?php echo Helper::getStatusText($new['status']) ?></td>
                <td><?php echo date('d-m-Y H:i:s', strtotime($new['created_at'])) ?></td>
                <td><?php echo !empty($new['updated_at']) ? date('d-m-Y H:i:s', strtotime($new['updated_at'])) : '--' ?></td>
                <td>
                    <?php
                    $url_detail = "index.php?controller=new&action=detail&id=" . $new['id'];
                    $url_update = "index.php?controller=new&action=update&id=" . $new['id'];
                    $url_delete = "index.php?controller=new&action=delete&id=" . $new['id'];
                    ?>
                    <a title="Chi tiết" href="<?php echo $url_detail ?>"><i class="fa fa-eye"></i></a> &nbsp;&nbsp;
                    <a title="Update" href="<?php echo $url_update ?>"><i class="fa fa-pencil-alt"></i></a> &nbsp;&nbsp;
                    <a title="Xóa" href="<?php echo $url_delete ?>" onclick="return confirm('Bạn có chắc chắn muốn xoá')"><i
                            class="fa fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>

    <?php else: ?>
        <tr>
            <td colspan="9">No data found</td>
        </tr>
    <?php endif; ?>
</table>