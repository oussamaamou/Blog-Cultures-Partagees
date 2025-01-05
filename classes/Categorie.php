<?php

class Categorie{

    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function creerCategorie($nom, $description){

        $sql = ("INSERT INTO categorie (Nom, Description) VALUES (:nom, :description)");

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);

        return $stmt->execute();
    }


    public function getAllCategorie(){
        try{ 
            $sql = ("SELECT * FROM categorie");
            $stmt = $this->conn->prepare($sql);
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
       }
       catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        return [];
       }
        
    }


}






?>