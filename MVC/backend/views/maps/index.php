<?php
require_once 'helpers/Helper.php';
?>

<h2>Bản Đồ</h2>
<a href="index.php?controller=map&action=create" class="btn btn-success">
    <i class="fa fa-plus"></i> Thêm mới
</a>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Hotline</th>
        <th>Fax</th>
        <th>Email</th>
        <th>Map_url</th>
        <th>Status</th>
        <th>Created_at</th>
        <th>Updated_at</th>
        <th></th>
    </tr>
    <?php if (!empty($maps)): ?>
        <?php foreach ($maps as $map): ?>
            <tr>
                <td><?php echo $map['id'] ?></td>
                <td><?php echo $map['title'] ?></td>
                <td><?php echo $map['hotline'] ?></td>
                <td><?php echo $map['fax'] ?></td>
                <td><?php echo $map['email'] ?></td>
                <td>
                    <textarea><?php echo $map['map_url'] ?></textarea>
                </td>
                <td><?php echo Helper::getStatusText($map['status']) ?></td>
                <td><?php echo date('d-m-Y H:i:s', strtotime($map['created_at'])) ?></td>
                <td><?php echo !empty($map['updated_at']) ? date('d-m-Y H:i:s', strtotime($map['updated_at'])) : '--' ?></td>
                <td>
                    <?php
                    $url_detail = "index.php?controller=map&action=detail&id=" . $map['id'];
                    $url_update = "index.php?controller=map&action=update&id=" . $map['id'];
                    $url_delete = "index.php?controller=map&action=delete&id=" . $map['id'];
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