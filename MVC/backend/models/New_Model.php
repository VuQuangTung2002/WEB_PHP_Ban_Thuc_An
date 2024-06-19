<?php
require_once 'models/Model.php';

class New_Model extends Model {
    public $id;
    public $category_id;
    public $title;
    public $summary;
    public $avatar;
    public $content;
    public $status;
    public $created_at;
    public $updated_at;

    public function getAll() {
        $obj_select = $this->connection->prepare("SELECT news.*,
                      categories.name AS category_name,
                      categories.status AS category_status
                      FROM news
 INNER JOIN categories ON news.category_id = categories.id");
        $arr_select = [];
        $obj_select->execute($arr_select);
        $news = $obj_select->fetchAll(PDO::FETCH_ASSOC);

        return $news;
    }

    public function getById($id) {
        $obj_select_one = $this->connection->prepare("SELECT news.*,
                      categories.name AS category_name
                      FROM news
 INNER JOIN categories ON news.category_id = categories.id WHERE news.id = $id");
        $obj_select_one->execute();
        return $obj_select_one->fetch(PDO::FETCH_ASSOC);
    }

    public function insert() {
        $obj_insert = $this->connection->prepare("INSERT INTO news(`category_id`, `title`, `summary`, 
`avatar`, `content`, `status`) VALUES (:category_id, :title, :summary, :avatar, :content, :status)");
        $arr_insert = [
            ':category_id' => $this->category_id,
            ':title' => $this->title,
            ':summary' => $this->summary,
            ':avatar' => $this->avatar,
            ':content' => $this->content,
            ':status' => $this->status
        ];
        return $obj_insert->execute($arr_insert);
    }

    public function update($id) {
        $obj_update = $this->connection->prepare("UPDATE news SET category_id =:category_id, title=:title, summary=:summary, 
avatar=:avatar, content=:content, status=:status, updated_at=:updated_at WHERE id = $id");
        $arr_update = [
            ':category_id' => $this->category_id,
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
        $obj_delete = $this->connection->prepare("DELETE FROM news WHERE id = $id");
        return $obj_delete->execute();
    }
}