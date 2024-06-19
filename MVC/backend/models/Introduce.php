<?php
require_once 'models/Model.php';

class Introduce extends Model {
    public $id;
    public $title;
    public $summary;
    public $avatar;
    public $content;
    public $status;
    public $created_at;
    public $updated_at;

    public function getAll()
    {
        $obj_select = $this->connection
            ->prepare("SELECT * FROM introduces ");

        $arr_select = [];
        $obj_select->execute($arr_select);
        $introduce = $obj_select->fetchAll(PDO::FETCH_ASSOC);

        return $introduce;
    }

    public function getById($id) {
        $obj_select_one = $this->connection->prepare("SELECT * FROM introduces WHERE id = $id");
        $obj_select_one->execute();
        return $obj_select_one->fetch(PDO::FETCH_ASSOC);
    }

    public function insert() {
        $obj_insert = $this->connection->prepare("INSERT INTO introduces(`title`, `summary`, 
`avatar`, `content`, `status`) VALUES (:title, :summary, :avatar, :content, :status)");
        $arr_insert = [
            ':title' => $this->title,
            ':summary' => $this->summary,
            ':avatar' => $this->avatar,
            ':content' => $this->content,
            ':status' => $this->status
        ];
        return $obj_insert->execute($arr_insert);
    }

    public function update($id) {
        $obj_update = $this->connection->prepare("UPDATE introduces SET title=:title, summary=:summary, 
avatar=:avatar, content=:content, status=:status, updated_at=:updated_at WHERE id = $id");
        $arr_update = [
            ':title' => $this->title,
            ':summary' =>$this->summary,
            ':avatar' =>$this->avatar,
            ':content' =>$this->content,
            ':status' => $this->status,
            ':updated_at' => $this->updated_at
        ];
        return $obj_update->execute($arr_update);
    }

    public function delete($id) {
        $obj_delete = $this->connection->prepare("DELETE FROM introduces WHERE id = $id");
        return $obj_delete->execute();
    }
}