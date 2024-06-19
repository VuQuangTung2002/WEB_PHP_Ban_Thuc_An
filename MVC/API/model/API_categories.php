<?php
class Category{
	private $conn;	
	public $id;
	public $name;
	public $avatar;
	public $description;
	public $status;
	
	//connect db;
	public function __construct($db){
		$this->conn = $db;
		}
		
		//read data
		public function read(){
			$query = "SELECT * FROM categories ORDER BY id DESC";
			
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt;
			}
		//show data
		public function show(){
			$query = "SELECT * FROM categories WHERE id=? LIMIT 1";
			
			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(1, $this->id);
			$stmt->execute();
			
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$this->name = $row['name'];
			$this->avatar = $row['avatar'];
			$this->description = $row['description'];
			$this->status = $row['status'];
			
			}
			
			//create data
		public function create(){
			$query = "INSERT INTO categories SET name=:name, avatar=:avatar, description=:description, status=:status";
			
			$stmt = $this->conn->prepare($query);
			
			
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->avatar = htmlspecialchars(strip_tags($this->avatar));
			$this->description = htmlspecialchars(strip_tags($this->description));
			$this->status = htmlspecialchars(strip_tags($this->status));
			
			$stmt->bindParam(':name',$this->name);
			$stmt->bindParam(':avatar',$this->avatar);
			$stmt->bindParam(':description',$this->description);
			$stmt->bindParam(':status',$this->status);	
			if($stmt->execute()){
				return true;
			}
			printf("Error %s.\n" , $stmt->error);
			return false;
		}
		
		//update data
		public function update(){
			$query = "UPDATE categories SET name=:name, avatar=:avatar, description=:description, status=:status WHERE id=:id";
			
			$stmt = $this->conn->prepare($query);
			
			//clean data
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->avatar = htmlspecialchars(strip_tags($this->avatar));
			$this->description = htmlspecialchars(strip_tags($this->description));
			$this->status = htmlspecialchars(strip_tags($this->status));
			$this->id = htmlspecialchars(strip_tags($this->id));
			
			//blind data
			$stmt->bindParam(':name',$this->name);
			$stmt->bindParam(':avatar',$this->avatar);
			$stmt->bindParam(':description',$this->description);
			$stmt->bindParam(':status',$this->status);
			$stmt->bindParam(':id',$this->id);	
			if($stmt->execute()){
				return true;
			}
			printf("Error %s.\n" , $stmt->error);
			return false;
		}
		//delete data
		public function delete(){
			$query = "DELETE FROM categories WHERE id=:id";
			
			$stmt = $this->conn->prepare($query);
			
			//clean data
			$this->id = htmlspecialchars(strip_tags($this->id));
			
			//blind data
			$stmt->bindParam(':id',$this->id);	
			if($stmt->execute()){
				return true;
			}
			printf("Error %s.\n" , $stmt->error);
			return false;
		}
	}
?>