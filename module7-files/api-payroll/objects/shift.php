<?php
class Shift{
    private $conn;
    private $table_name = "shift";

    public $shift_id;
    public $employee_id;
    public $shift_date;
    public $start_time;
    public $end_time;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){
        $query = "SELECT s.shift_id, s.employee_id, u.name, s.shift_date, s.start_time, s.end_time FROM " . $this->table_name . " s JOIN employee e ON s.employee_id=e.employee_id JOIN user u ON e.user_id=u.user_id ORDER BY s.shift_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readByEmployee(){
        $query = "SELECT shift_id, shift_date, start_time, end_time FROM " . $this->table_name . " WHERE employee_id = :employee_id ORDER BY shift_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':employee_id', $this->employee_id);
        $stmt->execute();
        return $stmt;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (employee_id, shift_date, start_time, end_time) VALUES (:employee_id, :shift_date, :start_time, :end_time)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':employee_id', $this->employee_id);
        $stmt->bindParam(':shift_date', $this->shift_date);
        $stmt->bindParam(':start_time', $this->start_time);
        $stmt->bindParam(':end_time', $this->end_time);
        return $stmt->execute();
    }

    public function update(){
        $query = "UPDATE " . $this->table_name . " SET shift_date = :shift_date, start_time = :start_time, end_time = :end_time WHERE shift_id = :shift_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':shift_date', $this->shift_date);
        $stmt->bindParam(':start_time', $this->start_time);
        $stmt->bindParam(':end_time', $this->end_time);
        $stmt->bindParam(':shift_id', $this->shift_id);
        return $stmt->execute();
    }

    public function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE shift_id = :shift_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':shift_id', $this->shift_id);
        return $stmt->execute();
    }
}
?>