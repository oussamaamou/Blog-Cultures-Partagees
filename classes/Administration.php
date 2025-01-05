<?php

class Administrateur{

    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function getAllLecteur(){
       try{ 
            $sql = ("SELECT * FROM utilisateur WHERE Role = :role");
            $stmt = $this->conn->prepare($sql);
            $role = 'Lecteur';
            
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
       }
       catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        return [];
       }
    }

    public function getAllAuteur(){
        try{ 
            $sql = ("SELECT * FROM utilisateur WHERE Role = :role");
            $stmt = $this->conn->prepare($sql);
            $role = 'Auteur';
            
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
       }
       catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        return [];
       }
    }

    public function getTotalLecteur() {

        $sql = "SELECT count(Nom) FROM utilisateur WHERE Role = :role";
        $stmt = $this->conn->prepare($sql);
        
        $role = 'Lecteur';
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetchColumn(); 
        
        return $result;
    }
    

    public function getTotalAuteur(){
        
        $sql = "SELECT count(Nom) FROM utilisateur WHERE Role = :role";
        $stmt = $this->conn->prepare($sql);
        
        $role = 'Auteur';
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetchColumn(); 
        
        return $result;
    }

    public function getTotalArticle(){
        
        $sql = "SELECT count(Titre) FROM article WHERE Statut = :statut";
        $stmt = $this->conn->prepare($sql);
        
        $statut = 'Accepté';
        $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetchColumn(); 
        
        return $result;
    }

    public function getTotalUtilisateur(){
        
        $sql = "SELECT count(Nom) FROM utilisateur";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute();
        $result = $stmt->fetchColumn(); 
        
        return $result;
    }
}


?>