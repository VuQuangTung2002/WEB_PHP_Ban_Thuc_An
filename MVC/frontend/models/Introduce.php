<?php

require_once 'models/Model.php';
class Introduce extends  Model {
    public function getAll() {


        $sql_select_all =
            "SELECT *
            FROM introduces
            WHERE status = 1
            ";
        //comment lại điều kiện WHere cho việc test,
        // tuy nhiên thực tế sẽ dùng
//            WHERE categories.status=1 AND products.status=1";
        $obj_select_all =
            $this->connection->prepare($sql_select_all);
        $obj_select_all->execute();
        $introduces = $obj_select_all
            ->fetchAll(PDO::FETCH_ASSOC);
        return $introduces;
    }


}