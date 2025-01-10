<?php

class Article {

    private $conn;
    private $ID_auteur;
    private $ID_categorie;
    private $titre;
    private $contenu;
    private $image;
    private $statut;
    private $date_publication;

    private $statutAccepté = 'Accepté';
    private $statutEnCours = 'Encours'; 

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function setAuteur($ID_auteur) {
        $this->ID_auteur = $ID_auteur;
    }

    public function setCategorie($ID_categorie) {
        $this->ID_categorie = $ID_categorie;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
    }

    public function setContenu($contenu) {
        $this->contenu = $contenu;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
    }

    public function setDatePublication($date_publication) {
        $this->date_publication = $date_publication;
    }


    public function getAuteur() {
        return $this->ID_auteur;
    }

    public function getCategorie() {
        return $this->ID_categorie;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function getContenu() {
        return $this->contenu;
    }

    public function getImage() {
        return $this->image;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function getDatePublication() {
        return $this->date_publication;
    }





    public function addArticle() {
        $sql = "INSERT INTO article (ID_auteur, ID_categorie, Titre, Contenu, Image, Statut, Date_publication)
                VALUES (:ID_auteur, :ID_categorie, :titre, :contenu, :image, :statut, :date_publication)";
        
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':ID_auteur', $this->ID_auteur, PDO::PARAM_INT);
        $stmt->bindParam(':ID_categorie', $this->ID_categorie, PDO::PARAM_INT);
        $stmt->bindParam(':titre', $this->titre, PDO::PARAM_STR);
        $stmt->bindParam(':contenu', $this->contenu, PDO::PARAM_STR);
        $stmt->bindParam(':statut', $this->statut, PDO::PARAM_STR);
        $stmt->bindParam(':date_publication', $this->date_publication, PDO::PARAM_STR);
        $stmt->bindParam(':image', $this->image, PDO::PARAM_LOB);

        return $stmt->execute();
    }

    public function getAllArticles() {
        try {
            $stmt = $this->conn->prepare(
                "SELECT article.*, categorie.Nom AS categorie_nom
                FROM article
                JOIN categorie ON article.ID_categorie = categorie.ID
                WHERE article.Statut = :statut"
            );
            
            $stmt->bindParam(':statut', $this->statutAccepté, PDO::PARAM_STR);
    
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getAuteurArticles($id) {
        try {
            $stmt = $this->conn->prepare(
                "SELECT article.*, categorie.Nom AS categorie_nom
                FROM article
                JOIN categorie ON article.ID_categorie = categorie.ID 
                WHERE article.Statut = :statut AND article.ID_auteur = :id"
            );
            
            $stmt->bindParam(':statut', $this->statutAccepté, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getLecteurArticles() {
        try {
            $stmt = $this->conn->prepare(
                "SELECT 
                    article.*, 
                    categorie.Nom AS categorie_nom, 
                    utilisateur.Nom AS auteur_nom,
                    utilisateur.Prenom AS auteur_prenom,
                    utilisateur.Photo AS auteur_photo
                FROM article
                JOIN categorie ON article.ID_categorie = categorie.ID
                JOIN utilisateur ON article.ID_auteur = utilisateur.ID
                WHERE article.Statut = :statut"
            );
            
            $stmt->bindParam(':statut', $this->statutAccepté, PDO::PARAM_STR);
    
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getStatutArticles() {
        try {
            $stmt = $this->conn->prepare(
                "SELECT 
                    article.*, 
                    categorie.Nom AS categorie_nom, 
                    utilisateur.Nom AS auteur_nom,
                    utilisateur.Prenom AS auteur_prenom,
                    utilisateur.Photo AS auteur_photo
                FROM article
                JOIN categorie ON article.ID_categorie = categorie.ID
                JOIN utilisateur ON article.ID_auteur = utilisateur.ID
                WHERE article.Statut = :statut"
            );
            
            $stmt->bindParam(':statut', $this->statutEnCours, PDO::PARAM_STR);
    
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }


    public function updateArticleStatut($article_id, $new_statut) {
        try {
            $sql = "UPDATE article SET Statut = :statut WHERE ID = :article_id";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':statut', $new_statut, PDO::PARAM_STR);
            $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateArticle($ID_article) {
        try {
            $sql = "UPDATE article SET Titre = :titre, Contenu = :contenu, ID_categorie = :ID_categorie, Image = :image, Statut = :statut, Date_publication = :date_publication WHERE ID = :ID_article";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':ID_article', $ID_article, PDO::PARAM_INT);
            $stmt->bindParam(':titre', $this->titre, PDO::PARAM_STR);
            $stmt->bindParam(':contenu', $this->contenu, PDO::PARAM_STR);
            $stmt->bindParam(':ID_categorie', $this->ID_categorie, PDO::PARAM_INT);
            $stmt->bindParam(':image', $this->image, PDO::PARAM_LOB);
            $stmt->bindParam(':statut', $this->statut, PDO::PARAM_STR);
            $stmt->bindParam(':date_publication', $this->date_publication, PDO::PARAM_STR);

            return $stmt->execute();
            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function deleteArticle($id){

        $stmt = $this->conn->prepare("DELETE FROM article WHERE ID = :id");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
    
        return $stmt->execute();

    }
    
}

?>
