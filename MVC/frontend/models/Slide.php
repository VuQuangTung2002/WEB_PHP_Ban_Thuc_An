<?php

require_once 'models/Model.php';
class Slide extends  Model {
    public function getSlide() {


        $sql_select_all =
            "SELECT *
            FROM slides 
            WHERE status = 1
            ORDER BY id DESC LIMIT 3 
            ";
        //comment lại điều kiện WHere cho việc test,
        // tuy nhiên thực tế sẽ dùng
//            WHERE categories.status=1 AND products.status=1";
        $obj_select_all =
            $this->connection->prepare($sql_select_all);
        $obj_select_all->execute();
        $slides = $obj_select_all
            ->fetchAll(PDO::FETCH_ASSOC);
        return $slides;
    }

    public function getComponent() {


        $sql_select_all =
            "SELECT *
            FROM slides 
            where status = 1
            ORDER BY id LIMIT 4
            ";

        $obj_select_all =
            $this->connection->prepare($sql_select_all);
        $obj_select_all->execute();
        $compo_imgs = $obj_select_all
            ->fetchAll(PDO::FETCH_ASSOC);
        return $compo_imgs;
    }
}