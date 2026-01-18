<?php
class Attendance{
    private $conn;
    private $table_name = "attendance";

    public $attendance_id;
    public $employee_id;
    public $date;
    public $status;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readAllByEmployee($empId){
        $query = "SELECT attendance_id, employee_id, date, status FROM " . $this->table_name . " WHERE employee_id=:eid ORDER BY date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':eid',$empId);
        $stmt->execute();
        return $stmt;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (employee_id, date, status) VALUES (:eid, :date, :status)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':eid', $this->employee_id);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':status', $this->status);
        return $stmt->execute();
    }

    public function update(){
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE attendance_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->attendance_id);
        return $stmt->execute();
    }
}

?>
