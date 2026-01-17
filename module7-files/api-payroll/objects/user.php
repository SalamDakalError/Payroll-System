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

    public function readOne(){
        $query = "SELECT user_id, name, email, password, role_id FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
            $this->name = $row['name'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->role_id = $row['role_id'];
        }
    }

    public function updatePassword(){
        $query = "UPDATE " . $this->table_name . " SET password = :password WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':user_id', $this->user_id);
        return $stmt->execute();
    }

    public function update(){
        $query = "UPDATE " . $this->table_name . " SET email = :email, role_id = :role_id";
        $params = [':email' => $this->email, ':role_id' => $this->role_id, ':user_id' => $this->user_id];

        if(!empty($this->password)){
            $query .= ", password = :password";
            $params[':password'] = password_hash($this->password, PASSWORD_DEFAULT);
        }

        $query .= " WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        foreach($params as $key => $value){
            $stmt->bindValue($key, $value);
        }
        return $stmt->execute();
    }

    public function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        return $stmt->execute();
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
