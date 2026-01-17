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
}

?>
