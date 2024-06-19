<?php
require_once 'helpers/Helper.php';
?>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td><?php echo $order['id']?></td>
    </tr>

    <tr>
        <th>User_id</th>
        <td><?php echo $order['user_id']?></td>
    </tr>
    <tr>
        <th>Fullname</th>
        <td><?php echo $order['fullname']?></td>
    </tr>
    <tr>
        <th>Address</th>
        <td><?php echo $order['address']?></td>
    </tr>
    <tr>
        <th>Mobile</th>
        <td><?php echo $order['mobile']?></td>
    </tr>

    <tr>
        <th>Email</th>
        <td><?php echo $order['email']?></td>
    </tr>
    <tr>
        <th>Note</th>
        <td><?php echo $order['note']?></td>
    </tr>
    <tr>
        <th>Price_total</th>
        <td><?php echo $order['price_total']?></td>
    </tr>
    <tr>
        <th>Payment_status</th>
        <td>
            <?php echo Helper::getStatusTextOrder($order['payment_status']) ?>
        </td>
    </tr>
    <tr>
        <th>Order_date</th>
        <td><?php echo date('d-m-Y H:i:s', strtotime($order['created_at'])) ?></td>
    </tr>
    <tr>
        <th>Payment_Date</th>
        <td><?php echo !empty($order['updated_at']) ? date('d-m-Y H:i:s', strtotime($order['updated_at'])) : '--' ?></td>
    </tr>
</table>
<a href="index.php?controller=order&action=index" class="btn btn-primary">Back</a>