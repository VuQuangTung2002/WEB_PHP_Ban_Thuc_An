<?php
require_once 'helpers/Helper.php';
?>
    <h2>Danh sách banner</h2>
    <a href="index.php?controller=slide&action=create" class="btn btn-success">
        <i class="fa fa-plus"></i> Thêm mới
    </a>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Avatar</th>
            <th>Position</th>
            <th>Component_img</th>
            <th>Title_componentImg</th>
            <th>Title_detail</th>
            <th>Growmax_img</th>
            <th>Status</th>
            <th>Created_at</th>
            <th>Updated_at</th>
            <th></th>
        </tr>
        <?php if (!empty($slides)): ?>
            <?php foreach ($slides as $slide): ?>
                <tr>
                    <td><?php echo $slide['id'] ?></td>
                    <td>
                        <?php if (!empty($slide['avatar'])): ?>
                            <img height="80" src="assets/uploads/<?php echo $slide['avatar'] ?>"/>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $slide['position'] ?></td>
                    <td>
                        <?php if (!empty($slide['component_img'])): ?>
                            <img height="80" src="assets/uploads/<?php echo $slide['component_img'] ?>"/>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $slide['title_component'] ?></td>
                    <td><?php echo $slide['title_detail'] ?></td>
                    <td>
                        <?php if (!empty($slide['store_img'])): ?>
                            <img height="80" src="assets/uploads/<?php echo $slide['store_img'] ?>"/>
                        <?php endif; ?>
                    </td>
                    <td><?php echo Helper::getStatusText($slide['status']) ?></td>
                    <td><?php echo date('d-m-Y H:i:s', strtotime($slide['created_at'])) ?></td>
                    <td><?php echo !empty($slide['updated_at']) ? date('d-m-Y H:i:s', strtotime($slide['updated_at'])) : '--' ?></td>
                    <td>
                        <?php
                        $url_update = "index.php?controller=slide&action=update&id=" . $slide['id'];
                        $url_delete = "index.php?controller=slide&action=delete&id=" . $slide['id'];
                        ?>
                        <a title="Update" href="<?php echo $url_update ?>"><i class="fa fa-pencil-alt"></i></a> &nbsp;&nbsp;
                        <a title="Xóa" href="<?php echo $url_delete ?>" onclick="return confirm('Bạn có chắc chắn muốn xoá?')"><i
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