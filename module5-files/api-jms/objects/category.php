<?php
class Category {

    private $connJMS;
    private $tableJMS = "categories";

    public $idJMS;
    public $nameJMS;
    public $descriptionJMS;
    public $createdJMS;

    public function __construct($dbJMS) {
        $this->connJMS = $dbJMS;
    }

    // ==========================
    // CREATE
    // ==========================
    function create() {

        $sqlJMS = "
            INSERT INTO {$this->tableJMS}
            SET
                name = :name,
                description = :description,
                created = :created
        ";

        $stmtJMS = $this->connJMS->prepare($sqlJMS);

        $stmtJMS->bindParam(":name", $this->nameJMS);
        $stmtJMS->bindParam(":description", $this->descriptionJMS);
        $stmtJMS->bindParam(":created", $this->createdJMS);

        return $stmtJMS->execute();
    }

    // ==========================
    // READ ALL (NON-PAGING)
    // ==========================
    function readAll() {

        $sqlJMS = "
            SELECT
                id, name, description, created
            FROM
                {$this->tableJMS}
            ORDER BY
                created DESC
        ";

        $stmtJMS = $this->connJMS->prepare($sqlJMS);
        $stmtJMS->execute();

        return $stmtJMS;
    }

    // ==========================
    // READ ONE
    // ==========================
    function readOne() {

        $sqlJMS = "
            SELECT
                id, name, description, created
            FROM
                {$this->tableJMS}
            WHERE
                id = ?
            LIMIT 1
        ";

        $stmtJMS = $this->connJMS->prepare($sqlJMS);
        $stmtJMS->bindParam(1, $this->idJMS);
        $stmtJMS->execute();

        $rowJMS = $stmtJMS->fetch(PDO::FETCH_ASSOC);

        if ($rowJMS) {
            $this->nameJMS = $rowJMS["name"];
            $this->descriptionJMS = $rowJMS["description"];
            $this->createdJMS = $rowJMS["created"];
        }
    }

    // ==========================
    // UPDATE
    // ==========================
    function update() {

        $sqlJMS = "
            UPDATE {$this->tableJMS}
            SET
                name = :name,
                description = :description
            WHERE
                id = :id
        ";

        $stmtJMS = $this->connJMS->prepare($sqlJMS);

        $stmtJMS->bindParam(":name", $this->nameJMS);
        $stmtJMS->bindParam(":description", $this->descriptionJMS);
        $stmtJMS->bindParam(":id", $this->idJMS);

        return $stmtJMS->execute();
    }

    // ==========================
    // DELETE
    // ==========================
    function delete() {

        $sqlJMS = "DELETE FROM {$this->tableJMS} WHERE id = ?";

        $stmtJMS = $this->connJMS->prepare($sqlJMS);
        $stmtJMS->bindParam(1, $this->idJMS);

        return $stmtJMS->execute();
    }

    // ==========================
    // READ WITH PAGINATION (FIXED)
    // ==========================
    function readPaging($fromJMS, $recordsJMS) {

        $sqlJMS = "
            SELECT
                id, name, description, created
            FROM
                {$this->tableJMS}
            ORDER BY
                created DESC
            LIMIT ?, ?
        ";

        $stmtJMS = $this->connJMS->prepare($sqlJMS);
        $stmtJMS->bindParam(1, $fromJMS, PDO::PARAM_INT);
        $stmtJMS->bindParam(2, $recordsJMS, PDO::PARAM_INT);
        $stmtJMS->execute();

        return $stmtJMS;
    }

    // ==========================
    // COUNT (FOR PAGINATION)
    // ==========================
    function count() {

        $sqlJMS = "SELECT COUNT(*) AS total FROM {$this->tableJMS}";

        $stmtJMS = $this->connJMS->prepare($sqlJMS);
        $stmtJMS->execute();

        $rowJMS = $stmtJMS->fetch(PDO::FETCH_ASSOC);
        return $rowJMS["total"];
    }

    // ==========================
    // SEARCH
    // ==========================
    function search($keywordsJMS) {

        $sqlJMS = "
            SELECT
                id, name, description, created
            FROM
                {$this->tableJMS}
            WHERE
                name LIKE ?
                OR description LIKE ?
            ORDER BY
                created DESC
        ";

        $stmtJMS = $this->connJMS->prepare($sqlJMS);

        $keywordsJMS = "%{$keywordsJMS}%";
        $stmtJMS->bindParam(1, $keywordsJMS);
        $stmtJMS->bindParam(2, $keywordsJMS);
        $stmtJMS->execute();

        return $stmtJMS;
    }
}
