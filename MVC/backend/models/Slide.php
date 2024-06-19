<?php
require_once 'models/Model.php';

class Slide extends Model {
    public $id;
    public $avatar;
    public $position;
    public $component_img;
    public $title_component;
    public $title_detail;
    public $store_img;
    public $status;
    public $created_at;
    public $updated_at;

    //insert dữ liệu vào bảng slide
    public function insert(){
        $sql_insert = "INSERT INTO slides(`avatar`, `position`, `component_img`, `title_component`, `title_detail`, `store_img`, `status`) 
VALUES (:avatar, :position, :component_img, :title_component, :title_detail, :store_img, :status)";
        //chuẩn bị đối tượng truy vấn
        $obj_insert = $this->connection->prepare($sql_insert);
        //gán giá trị thật cho các placehoder
        $arr_insert = [
            ':avatar' => $this->avatar,
            ':position' => $this->position,
            ':component_img' => $this->component_img,
            ':title_component' => $this->title_component,
            ':title_detail' => $this->title_detail,
            ':store_img' => $this->store_img,
            ':status' => $this->status
        ];
        return $obj_insert->execute($arr_insert);
    }

    //lấy thông tin banner đang có trên hệ thống
    public function getAll() {
        $sql_select_all = "SELECT slides.* FROM slides ";
        $obj_select_all = $this->connection->prepare($sql_select_all);
        $obj_select_all->execute();
        $slides = $obj_select_all->fetchAll(PDO::FETCH_ASSOC);
        return $slides;
    }

    // cập nhật lại thông tin slide
    public  function update($id) {
        $obj_update = $this->connection->prepare("UPDATE slides SET `avatar` = :avatar,
 `position` = :position, `component_img`= :component_img,`title_component` = :title_component, 
 `title_detail`= :title_detail, `store_img`=:store_img, `status`= :status, `updated_at`= :updated_at WHERE id = $id");
        $arr_update = [
            ':avatar' => $this->avatar,
            ':position' => $this->position,
            ':component_img' => $this->component_img,
            ':title_component' => $this->title_component,
            ':title_detail' => $this->title_detail,
            ':store_img' => $this->store_img,
            ':status' => $this->status,
            ':updated_at' => $this->updated_at
        ];
        return $obj_update->execute($arr_update);
    }

    //xoá ảnh slide
    public function delete($id) {
        $obj_delete = $this->connection
            ->prepare("DELETE FROM slides WHERE id = $id");
        $is_delete = $obj_delete->execute();
        return $is_delete;
    }

    public function getById($id) {
        $sql_select_one = "SELECT slides.* FROM slides WHERE id = $id";
        $obj_select_one = $this->connection->prepare($sql_select_one);
        $obj_select_one->execute();
        return $obj_select_one->fetch(PDO::FETCH_ASSOC);
    }
}