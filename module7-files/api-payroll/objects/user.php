<?php
class User{
    private $conn;
    private $table_name = "user";

    public $user_id;
    public $name;
    public $email;
    public $password;
    public $role_id;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){
        $query = "SELECT user_id, name, email, role_id FROM " . $this->table_name . " ORDER BY user_id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (name,email,password,role_id) VALUES (:name,:email,:password,:role_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name',$this->name);
        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam(':password',$this->password);
        $stmt->bindParam(':role_id',$this->role_id);
        return $stmt->execute();
    }
}

?>
