<?php
require_once 'models/Model.php';
class New_Model extends  Model {
    public function getAll() {


        $sql_select_all =
            "SELECT *
            FROM news
            WHERE status = 1
            ";
        //comment lại điều kiện WHere cho việc test,
        // tuy nhiên thực tế sẽ dùng
//            WHERE categories.status=1 AND products.status=1";
        $obj_select_all =
            $this->connection->prepare($sql_select_all);
        $obj_select_all->execute();
        $news = $obj_select_all
            ->fetchAll(PDO::FETCH_ASSOC);
        return $news;
    }

    public function getById($id) {
        $sql_select_one =
            "SELECT news.* categories.name AS category_name
            FROM news
            INNER JOIN categories 
            ON news.category_id = categories.id
            WHERE news.id = $id";
        $obj_select_one =
            $this->connection->prepare($sql_select_one);
        $obj_select_one->execute();
        $new = $obj_select_one->fetch(PDO::FETCH_ASSOC);
        return $new;
    }

    public function getByNew() {
        $sql_select_hot = "SELECT news.*
            FROM news
             ORDER BY id DESC LIMIT 3";
        $obj_select_hot = $this->connection->prepare($sql_select_hot);
        $obj_select_hot->execute();
        $new = $obj_select_hot->fetchAll(PDO::FETCH_ASSOC);
        return $new;
    }

}