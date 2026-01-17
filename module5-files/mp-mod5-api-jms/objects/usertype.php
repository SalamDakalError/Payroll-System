<?php
class UserTypeJMS {
    private $connJMS;
    private $table = "tblusertype";

    public $idJMS;
    public $nameJMS;
    public $descriptionJMS;

    public function __construct($dbJMS) {
        $this->connJMS = $dbJMS;
    }

    function readAllJMS() {
        return $this->connJMS->prepare("SELECT * FROM {$this->table}");
    }

    function readOneJMS() {
        $stmt = $this->connJMS->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->bindParam(1, $this->idJMS);
        return $stmt;
    }

    function createJMS() {
        $stmt = $this->connJMS->prepare(
            "INSERT INTO {$this->table} SET Name=?, Description=?"
        );
        return $stmt->execute([$this->nameJMS, $this->descriptionJMS]);
    }

    function updateJMS() {
        $stmt = $this->connJMS->prepare(
            "UPDATE {$this->table} SET Name=?, Description=? WHERE id=?"
        );
        return $stmt->execute([$this->nameJMS, $this->descriptionJMS, $this->idJMS]);
    }

    function deleteJMS() {
        $stmt = $this->connJMS->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$this->idJMS]);
    }

    function pagingJMS($from, $limit) {
        return $this->connJMS->prepare(
            "SELECT * FROM {$this->table} LIMIT {$from}, {$limit}"
        );
    }

    function searchJMS($key) {
        return $this->connJMS->prepare(
            "SELECT * FROM {$this->table} WHERE Name LIKE ?"
        );
    }
}
