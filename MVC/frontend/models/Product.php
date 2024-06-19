<?php
//models/Product.php
require_once 'models/Model.php';
class Product extends Model {

    //Lấy tất cả sản phẩm đang có trên hệ thống
    public function getAll($params = []) {

        $str_category_id = '';
        $str_price = '';

        if (isset($params['str_category_id'])) {
            $str_category_id = " AND " . $params['str_category_id'];
        }
        if (isset($params['str_price'])) {
            $str_price = " AND " . $params['str_price'];
        }
        //với truy vấn mà có join bảng, thì luôn cần sử dụng
        //tên bảng trước tên trường, vd: products.price
        $sql_select_all =
            "SELECT products.*, categories.name AS category_name
            FROM products
            INNER JOIN categories 
            ON products.category_id = categories.id WHERE TRUE $str_category_id $str_price";
        //comment lại điều kiện WHere cho việc test,
        // tuy nhiên thực tế sẽ dùng
//            WHERE categories.status=1 AND products.status=1";
        $obj_select_all =
            $this->connection->prepare($sql_select_all);
        $obj_select_all->execute();
        $products = $obj_select_all
            ->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    public function getById($id) {
        $sql_select_one =
            "SELECT products.*, categories.name AS category_name
            FROM products
            INNER JOIN categories 
            ON products.category_id = categories.id
            WHERE products.id = $id";
        $obj_select_one =
            $this->connection->prepare($sql_select_one);
        $obj_select_one->execute();
        $product = $obj_select_one->fetch(PDO::FETCH_ASSOC);
        return $product;
    }

    public function getByHot() {
        $sql_select_hot = "SELECT products.*, categories.name AS category_name
            FROM products
            INNER JOIN categories 
            ON products.category_id = categories.id
            WHERE hot = 1
             ORDER BY id DESC LIMIT 8";
        $obj_select_hot = $this->connection->prepare($sql_select_hot);
        $obj_select_hot->execute();
        $product = $obj_select_hot->fetchAll(PDO::FETCH_ASSOC);
        return $product;
    }
}