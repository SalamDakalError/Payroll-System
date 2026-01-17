<?php
class Product{ 

    private $connJMS; 


    public $idJMS; 
    public $nameJMS;
    public $descriptionJMS;
    public $priceJMS; 
    public $category_idJMS; 
    public $category_nameJMS; 
    public $createdJMS; 

    public function __construct($dbJMS){
        $this->connJMS = $dbJMS; 
    }


    function readAll(){ 

        $queryJMS = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                FROM
                    products p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                ORDER BY
                    p.created DESC";


        $stmtJMS = $this->connJMS->prepare($queryJMS); 
      
        $stmtJMS->execute(); 

        return $stmtJMS;
    }

    function readOne(){ 

        $queryJMS = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                FROM
                    products p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                WHERE
                    p.id = ?
                LIMIT 0,1"; 
        

        $stmtJMS = $this->connJMS->prepare( $queryJMS ); 


        $stmtJMS->bindParam(1, $this->idJMS); 
    
   
        $stmtJMS->execute(); 
        
    
        $rowJMS = $stmtJMS->fetch(PDO::FETCH_ASSOC); 

        
        if ($rowJMS) {
            $this->nameJMS = $rowJMS['name'];
            $this->priceJMS = $rowJMS['price'];
            $this->descriptionJMS = $rowJMS['description'];
            $this->category_idJMS = $rowJMS['category_id'];
            $this->category_nameJMS = $rowJMS['category_name'];
        } else {
             $this->nameJMS = null; 
        }
    }

 
    function create(){ 

        $queryJMS = "INSERT INTO
                    products
                SET
                    name=:name,
                    price=:price,
                    description=:description,
                    category_id=:category_id,
                    created=:created";

        $stmtJMS = $this->connJMS->prepare($queryJMS); 

   
        $this->nameJMS=htmlspecialchars(strip_tags($this->nameJMS)); 
        $this->priceJMS=htmlspecialchars(strip_tags($this->priceJMS));
        $this->descriptionJMS=htmlspecialchars(strip_tags($this->descriptionJMS));
        $this->category_idJMS=htmlspecialchars(strip_tags($this->category_idJMS));
        $this->createdJMS=htmlspecialchars(strip_tags($this->createdJMS));

   
        $stmtJMS->bindParam(":name", $this->nameJMS); 
        $stmtJMS->bindParam(":price", $this->priceJMS);
        $stmtJMS->bindParam(":description", $this->descriptionJMS);
        $stmtJMS->bindParam(":category_id", $this->category_idJMS);
        $stmtJMS->bindParam(":created", $this->createdJMS);


        if($stmtJMS->execute()){ 
            return true;
        }

        return false;
    }


    function update(){ 
 
        $queryJMS = "UPDATE
                    products
                SET
                    name = :name,
                    price = :price,
                    description = :description,
                    category_id = :category_id
                WHERE
                    id = :id";
        
   
        $stmtJMS = $this->connJMS->prepare($queryJMS);


        $this->nameJMS=htmlspecialchars(strip_tags($this->nameJMS)); 
        $this->priceJMS=htmlspecialchars(strip_tags($this->priceJMS));
        $this->descriptionJMS=htmlspecialchars(strip_tags($this->descriptionJMS));
        $this->category_idJMS=htmlspecialchars(strip_tags($this->category_idJMS));
        $this->idJMS=htmlspecialchars(strip_tags($this->idJMS));
        
    
        $stmtJMS->bindParam(':name', $this->nameJMS); 
        $stmtJMS->bindParam(':price', $this->priceJMS);
        $stmtJMS->bindParam(':description', $this->descriptionJMS);
        $stmtJMS->bindParam(':category_id', $this->category_idJMS);
        $stmtJMS->bindParam(':id', $this->idJMS);


        if($stmtJMS->execute()){ 
            return true;
        }

        return false;
    }

    
    function delete(){ 
      
        $queryJMS = "DELETE FROM products WHERE id = ?"; 
        
     
        $stmtJMS = $this->connJMS->prepare($queryJMS); 
        
 
        $this->idJMS=htmlspecialchars(strip_tags($this->idJMS)); 

        $stmtJMS->bindParam(1, $this->idJMS); 

  
        if($stmtJMS->execute()){ 
            return true;
        }

        return false;
    }

 
    public function readPaging($from_record_numJMS, $records_per_pageJMS){
  
        $queryJMS = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                FROM
                    products p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                ORDER BY p.created DESC
                LIMIT ?, ?";
        
      
        $stmtJMS = $this->connJMS->prepare( $queryJMS );


        $stmtJMS->bindParam(1, $from_record_numJMS, PDO::PARAM_INT); 
        $stmtJMS->bindParam(2, $records_per_pageJMS, PDO::PARAM_INT); 

   
        $stmtJMS->execute(); 

   
        return $stmtJMS;
    }


    public function count(){ 
        $queryJMS = "SELECT COUNT(*) as total_rows FROM products"; 
        $stmtJMS = $this->connJMS->prepare( $queryJMS ); 
        $stmtJMS->execute(); 
        $rowJMS = $stmtJMS->fetch(PDO::FETCH_ASSOC); 
        return $rowJMS['total_rows'];
    }


    function search($keywordsJMS){ 
   
        $queryJMS = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                FROM
                    products p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                WHERE
                    p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
                ORDER BY
                    p.created DESC";

    
        $stmtJMS = $this->connJMS->prepare($queryJMS); 


        $keywordsJMS=htmlspecialchars(strip_tags($keywordsJMS)); 
        $keywordsJMS = "%{$keywordsJMS}%"; 

 
        $stmtJMS->bindParam(1, $keywordsJMS); 
        $stmtJMS->bindParam(2, $keywordsJMS);
        $stmtJMS->bindParam(3, $keywordsJMS);

        $stmtJMS->execute();

        return $stmtJMS;
    }
}
?>