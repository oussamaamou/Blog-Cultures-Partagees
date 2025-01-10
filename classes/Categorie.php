<?php

class Categorie{

    private $conn;
    private $nom;
    private $description;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function setNom($nom){
        $this->nom = $nom;
    }

    public function getNom(){
        return $this->nom;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function getDescription(){
        return $this->description;
    }

    public function creerCategorie(){

        $sql = ("INSERT INTO categorie (Nom, Description) VALUES (:nom, :description)");

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);

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

    public function creerTag(){

        $sql = ("INSERT INTO tags (Nom) VALUES (:nom)");

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function getAllTags(){
        try{ 
            $sql = ("SELECT * FROM tags");
            $stmt = $this->conn->prepare($sql);
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
       }
       catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        return [];
       }
        
    }

    public function deleteCategorie($id){

        $stmt = $this->conn->prepare("DELETE FROM categorie WHERE ID = :id");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
    
        return $stmt->execute();
    }

    public function deleteTags($id){

        $stmt = $this->conn->prepare("DELETE FROM tags WHERE ID = :id");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
    
        return $stmt->execute();
    }


}






?>