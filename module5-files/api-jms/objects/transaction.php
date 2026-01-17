<?php
class Transaction {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create($data){
        $sql = "INSERT INTO tbltransaction
                (Transaction_No, Customer_No, Product_ID, Quantity, Total_Amount)
                VALUES (?,?,?,?,?)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data["Transaction_No"],
            $data["Customer_No"],
            $data["Product_ID"],
            $data["Quantity"],
            $data["Total_Amount"]
        ]);
    }

    public function readAll(){
        $sql = "SELECT
            t.Transaction_No,
            t.Customer_No,
            CONCAT(c.Last_Name, ', ', c.First_Name,' ',c.Middle_Name) AS Customer_Name,
            p.name AS Product_Name,
            t.Quantity,
            t.Total_Amount
        FROM tbltransaction t
        LEFT JOIN tblcustomer c ON t.Customer_No = c.Customer_No
        LEFT JOIN products p ON t.Product_ID = p.id
        ORDER BY t.id DESC";

        return $this->conn->query($sql);
    }

    public function readOne($id){
        $stmt = $this->conn->prepare(
            "SELECT * FROM tbltransaction WHERE Transaction_No=?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id){
        $stmt = $this->conn->prepare(
            "DELETE FROM tbltransaction WHERE Transaction_No=?"
        );
        return $stmt->execute([$id]);
    }
}
