<?php
class UsersJMS {
    private $connJMS;
    private $table = "tbluser";

    public $idJMS;
    public $userNameJMS;
    public $lastNameJMS;
    public $firstNameJMS;
    public $middleNameJMS;
    public $genderJMS;
    public $emailJMS;
    public $userTypeIdJMS;
    public $passwordJMS;

    public function __construct($dbJMS) {
        $this->connJMS = $dbJMS;
    }

    function readAllJMS() {
        return $this->connJMS->prepare(
            "SELECT u.*, t.Name AS UserTypeName
             FROM tbluser u
             LEFT JOIN tblusertype t
             ON u.User_Type_Id = t.id"
        );
    }

    function readOneJMS() {
        $stmt = $this->connJMS->prepare(
            "SELECT u.*, t.Name AS UserTypeName
             FROM tbluser u
             LEFT JOIN tblusertype t
             ON u.User_Type_Id = t.id
             WHERE u.id=?"
        );
        $stmt->bindParam(1, $this->idJMS);
        return $stmt;
    }

    function createJMS() {
        $stmt = $this->connJMS->prepare(
            "INSERT INTO {$this->table}
             VALUES (NULL,?,?,?,?,?,?,?,?)"
        );
        return $stmt->execute([
            $this->userNameJMS,
            $this->lastNameJMS,
            $this->firstNameJMS,
            $this->middleNameJMS,
            $this->genderJMS,
            $this->emailJMS,
            $this->userTypeIdJMS,
            $this->passwordJMS
        ]);
    }

    function updateJMS() {
        $stmt = $this->connJMS->prepare(
            "UPDATE {$this->table}
             SET Last_Name=?, First_Name=?, Gender=?, Email_Address=?
             WHERE id=?"
        );
        return $stmt->execute([
            $this->lastNameJMS,
            $this->firstNameJMS,
            $this->genderJMS,
            $this->emailJMS,
            $this->idJMS
        ]);
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
            "SELECT * FROM {$this->table} WHERE Last_Name LIKE ?"
        );
    }
}
