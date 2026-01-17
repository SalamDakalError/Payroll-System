<?php
class DatabaseJMS {
    private $hostJMS = "localhost";
    private $dbNameJMS = "db_mp_api_sia101_jms"; // ✅ initials only here
    private $usernameJMS = "root";
    private $passwordJMS = "";
    public $connJMS;

    public function getConnectionJMS() {
        $this->connJMS = null;
        try {
            $this->connJMS = new PDO(
                "mysql:host={$this->hostJMS};dbname={$this->dbNameJMS}",
                $this->usernameJMS,
                $this->passwordJMS
            );
            $this->connJMS->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exceptionJMS) {
            echo "Connection error: " . $exceptionJMS->getMessage();
        }
        return $this->connJMS;
    }
}
