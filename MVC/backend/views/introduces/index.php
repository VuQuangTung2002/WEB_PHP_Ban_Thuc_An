<?php
require_once 'helpers/Helper.php';
?>

<h2>Danh sách giới thiệu</h2>
<a href="index.php?controller=introduce&action=create" class="btn btn-success">
    <i class="fa fa-plus"></i> Thêm mới
</a>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Avatar</th>
        <th>Status</th>
        <th>Created_at</th>
        <th>Updated_at</th>
        <th></th>
    </tr>
    <?php if (!empty($introduces)): ?>
        <?php foreach ($introduces as $introduce): ?>
            <tr>
                <td><?php echo $introduce['id'] ?></td>
                <td><?php echo $introduce['title'] ?></td>
                <td>
                    <?php if (!empty($introduce['avatar'])): ?>
                        <img height="80" src="assets/uploads/<?php echo $introduce['avatar'] ?>"/>
                    <?php endif; ?>
                </td>
                <td><?php echo Helper::getStatusText($introduce['status']) ?></td>
                <td><?php echo date('d-m-Y H:i:s', strtotime($introduce['created_at'])) ?></td>
                <td><?php echo !empty($introduce['updated_at']) ? date('d-m-Y H:i:s', strtotime($introduce['updated_at'])) : '--' ?></td>
                <td>
                    <?php
                    $url_detail = "index.php?controller=introduce&action=detail&id=" . $introduce['id'];
                    $url_update = "index.php?controller=introduce&action=update&id=" . $introduce['id'];
                    $url_delete = "index.php?controller=introduce&action=delete&id=" . $introduce['id'];
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