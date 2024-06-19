<?php
require_once 'helpers/Helper.php';
?>

<h2>Danh sách đặt hàng</h2>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Customer_fullname</th>
        <th>Address</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Price_total</th>
        <th>Payment_Status</th>
        <th>Order_date</th>
        <th>Payment_date</th>
        <th></th>
    </tr>
    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo $order['id'] ?></td>
                <td><?php echo $order['fullname'] ?></td>
                <td><?php echo $order['address'] ?></td>
                <td><?php echo $order['mobile'] ?></td>
                <td><?php echo $order['email'] ?></td>
                <td><?php echo $order['price_total'] ?></td>
                <td><?php echo Helper::getStatusTextOrder($order['payment_status']) ?></td>
                <td><?php echo date('d-m-Y H:i:s', strtotime($order['created_at'])) ?></td>
                <td><?php echo !empty($order['updated_at']) ? date('d-m-Y H:i:s', strtotime($order['updated_at'])) : '--' ?></td>
                <td>
                    <?php
                    $url_detail = "index.php?controller=order&action=detail&id=" . $order['id'];
                    $url_update = "index.php?controller=order&action=update&id=" . $order['id'];
                    $url_delete = "index.php?controller=order&action=delete&id=" . $order['id'];
                    ?>
                    <a title="Chi tiết" href="<?php echo $url_detail ?>"><i class="fa fa-eye"></i></a> &nbsp;&nbsp;
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