<?php

require_once 'models/Model.php';

class OrderDetail extends Model {
    //khai báo các trường tương ứng trong bảng order_details
    public $order_id;
    public $product_id;
    public $quality;

    public function insert() {
        $sql_insert = "INSERT INTO order_details(`order_id`, `product_id`, `quality`) VALUE (:order_id, :product_id, :quality)";
        $obj_insert = $this->connection->prepare($sql_insert);
        $arr_insert = [
            ':order_id' => $this->order_id,
            ':product_id' => $this->product_id,
            ':quality' => $this->quality,
        ];
        $is_insert = $obj_insert->execute($arr_insert);
        return $is_insert;
    }


}