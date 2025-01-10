<?php

class Interaction{
    
    private $conn;
    private $description;
    private $ID_lecteur;
    private $ID_article;
    private $date_publication;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setIDLecteur($ID_lecteur){
        $this->ID_lecteur = $ID_lecteur;
    }

    public function getIDLecteur(){
        return $this->ID_lecteur;
    }

    public function setIDArticle($ID_article){
        $this->ID_article = $ID_article;
    }

    public function getIDArticle(){
        return $this->ID_article;
    }

    public function setDataPublication($date_publication){
        $this->date_publication = $date_publication;
    }

    public function getDataPublication(){
        return $this->date_publication;
    }


    public function addComment(){
        $sql = ("INSERT INTO commentaire (ID_lecteur, ID_article, Description, Date_publication) VALUES(:ID_lecteur, :ID_article, :description, :date_publication)");
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':ID_lecteur', $this->ID_lecteur, PDO::PARAM_INT);
        $stmt->bindParam(':ID_article', $this->ID_article, PDO::PARAM_INT);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindParam(':date_publication', $this->date_publication, PDO::PARAM_STR);

        return $stmt->execute();
    }

    
    public function getCommentsByArticle($articleId){
        try{
            $sql = "SELECT c.ID, c.Description AS commentaire_description, c.Date_publication AS commentaire_date, 
                           u.Nom AS lecteur_nom, u.Photo AS lecteur_photo, u.Prenom AS lecteur_prenom, u.Email AS lecteur_email, 
                           a.Titre AS article_titre, a.Date_publication AS article_date
                    FROM commentaire c
                    INNER JOIN utilisateur u ON c.ID_lecteur = u.ID
                    INNER JOIN article a ON c.ID_article = a.ID
                    WHERE c.ID_article = :articleId";  
    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':articleId', $articleId, PDO::PARAM_INT);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            echo "Erreur : " . $e->getMessage();
            return [];
        }
    }

    public function deleteCommentaire($id){

        $stmt = $this->conn->prepare("DELETE FROM commentaire WHERE ID = :id");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
    
        return $stmt->execute();
    }

    public function ajouterLike(){
        
        $sql = ("INSERT INTO likes (ID_lecteur, ID_article) VALUES (:ID_lecteur, :ID_article)");
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':ID_lecteur', $this->ID_lecteur, PDO::PARAM_INT);
        $stmt->bindParam(':ID_article', $this->ID_article, PDO::PARAM_INT);

        return $stmt->execute();

    }

    public function getLikeCount($ID_article){
       
        $sql = "SELECT COUNT(*) AS like_count FROM likes WHERE ID_article = :article_id";
    
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':article_id', $ID_article, PDO::PARAM_INT);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $row['like_count'] : 0;
    }
    
    
}



?>