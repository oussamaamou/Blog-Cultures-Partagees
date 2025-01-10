<?php
class Administrateur {
    
    private $conn;
    private $roleLecteur = 'Lecteur';
    private $roleAuteur = 'Auteur';
    private $statutArticle = 'Accepté';

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function setRoleLecteur($role) {
        $this->roleLecteur = $role;
    }

    public function getRoleLecteur() {
        return $this->roleLecteur;
    }

    public function setRoleAuteur($role) {
        $this->roleAuteur = $role;
    }

    public function getRoleAuteur() {
        return $this->roleAuteur;
    }

    public function setStatutArticle($statut) {
        $this->statutArticle = $statut;
    }

    public function getStatutArticle() {
        return $this->statutArticle;
    }

    public function getAllLecteur() {
        try {
            $sql = "SELECT * FROM utilisateur WHERE Role = :role";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':role', $this->roleLecteur, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getAllAuteur() {
        try {
            $sql = "SELECT * FROM utilisateur WHERE Role = :role";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':role', $this->roleAuteur, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getTotalLecteur() {
        $sql = "SELECT count(Nom) FROM utilisateur WHERE Role = :role";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':role', $this->roleLecteur, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getTotalAuteur() {
        $sql = "SELECT count(Nom) FROM utilisateur WHERE Role = :role";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':role', $this->roleAuteur, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getTotalArticle() {
        $sql = "SELECT count(Titre) FROM article WHERE Statut = :statut";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':statut', $this->statutArticle, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getTotalUtilisateur() {
        $sql = "SELECT count(Nom) FROM utilisateur";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>
