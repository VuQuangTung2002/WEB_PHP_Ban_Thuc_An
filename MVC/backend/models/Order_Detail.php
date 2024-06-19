<?php
require_once 'models/Model.php';

class Order_Detail extends Model {
    public $order_id;
    public $product_id;
    public $quality;

    public function delete_order_detail($order_id) {
        //cbi truy vấn
        $obj_delete = $this->connection
            ->prepare("DELETE FROM order_details WHERE order_id= $order_id ");
        //gắn giá trị cho tham số


        //thực thi truy vấn
        return $obj_delete->execute();
    }

    public function get_order_detail(){
//        1 - chuẩn bị truy vấn
        $obj_select = $this->connection
            ->prepare(" select *
                      FROM order_details");

        //2 - truyền giá trị cho tham số và
        // thực thi truy vấn
        $obj_select->execute();

        //3 - lấy dữ liệu trả về dưới dạng mảng
        $order_details = $obj_select->fetchAll(PDO::FETCH_ASSOC);
        return $order_details;
    }
}