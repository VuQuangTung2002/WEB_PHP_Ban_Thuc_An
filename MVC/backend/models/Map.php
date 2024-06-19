<?php
require_once 'models/Model.php';

class Map extends Model {
    public $id;
    public $title;
    public $hotline;
    public $fax;
    public $email;
    public $summary;
    public $map_url;
    public $status;
    public $created_at;
    public $updated_at;

    public function getAll() {
        $obj_select = $this->connection
            ->prepare("SELECT * FROM maps");

        $arr_select = [];
        $obj_select->execute($arr_select);
        $map = $obj_select->fetchAll(PDO::FETCH_ASSOC);

        return $map;
    }

    public function getById($id) {
        $obj_select_one = $this->connection->prepare("SELECT * FROM maps WHERE id = $id");
        $obj_select_one->execute();
        return $obj_select_one->fetch(PDO::FETCH_ASSOC);
    }
    public function insert() {
        $obj_insert = $this->connection->prepare("INSERT INTO maps(`title`, `hotline`, `fax`, `email`,
 `summary`, `map_url`, `status`) VALUES (:title, :hotline, :fax , :email, :summary, :map_url, :status)");
        $arr_insert = [
            ':title' => $this->title,
            ':hotline' => $this->hotline,
            ':fax' => $this->fax,
            ':email' => $this->email,
            ':summary' =>$this->summary,
            ':map_url' =>$this->map_url,
            ':status' => $this->status
        ];
        return $obj_insert->execute($arr_insert);
    }
    public function update($id) {
        $obj_update = $this->connection->prepare("UPDATE maps SET title=:title, hotline=:hotline,
        fax=:fax, email=:email, summary=:summary, map_url=:map_url, 
        status=:status, updated_at=:updated_at WHERE id = $id");
        $arr_update = [
            ':title' => $this->title,
            ':hotline' => $this->hotline,
            ':fax' => $this->fax,
            ':email' => $this->email,
            ':summary' =>$this->summary,
            ':map_url' =>$this->map_url,
            ':status' => $this->status,
            ':updated_at' => $this->updated_at
        ];
        return $obj_update->execute($arr_update);
    }
    public function delete($id) {
        $obj_delete = $this->connection->prepare("DELETE FROM maps WHERE id = $id");
        return $obj_delete->execute();
    }
}