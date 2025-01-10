<?php

class Utilisateur {

    private $conn;
    private $id;
    private $nom;
    private $prenom;
    private $role;
    private $telephone;
    private $email;
    private $mot_de_passe;
    private $photo;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setMotDePasse($mot_de_passe) {
        $this->mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getRole() {
        return $this->role;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getMotDePasse() {
        return $this->mot_de_passe;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function inscriptionUtilisateur() {
        $sql = "INSERT INTO utilisateur (Nom, Prenom, Photo, Role, Telephone, Email, Mot_de_passe) 
                VALUES (:nom, :prenom, :photo, :role, :telephone, :email, :mot_de_passe)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $this->prenom, PDO::PARAM_STR);
        $stmt->bindParam(':photo', $this->photo, PDO::PARAM_LOB);
        $stmt->bindParam(':role', $this->role, PDO::PARAM_STR);
        $stmt->bindParam(':telephone', $this->telephone, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':mot_de_passe', $this->mot_de_passe, PDO::PARAM_STR);

        return $stmt->execute();
    }



    public function loginUtilisateur() {
        $sql = "SELECT * FROM utilisateur WHERE Email = :email"; 
        $stmt = $this->conn->prepare($sql);
    
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
    
        if($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                $gtID = $result['ID'];
                $gtrole = $result['Role'];
                $gtemail = $result['Email'];
                $gtetat = $result['Etat'];
                $gtmot_de_passe = $result['Mot_de_passe'];

                if($this->email === $gtemail && 'Normal' === $gtetat) {
                    $_SESSION['ID'] = $gtID;

                    if($gtrole === 'Lecteur'){
                        header("Location: ../views/home_lecteur.php");
                        exit();
                    }
                    if($gtrole === 'Auteur'){
                        header("Location: ../views/home_auteur.php");
                        exit();
                    }
                    if($gtrole === 'Administrateur'){
                        header("Location: ../views/gestion.php");
                        exit();
                    }
                } else {
                    header('location: ../public/403page.php');
                    exit();
                }
            } else {
                echo "Email non trouvé.";
            }
        } else {
            echo "Erreur lors de l'exécution de la requête.";
        }
    }

    public function getProfileInfos($id) {
        try {
            $sql = "SELECT Nom, Prenom, Photo, Role, Telephone, Email FROM utilisateur WHERE ID = :id";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                return [
                    'Nom' => $row['Nom'],
                    'Prenom' => $row['Prenom'],
                    'Photo' => $row['Photo'],
                    'Role' => $row['Role'],
                    'Telephone' => $row['Telephone'],
                    'Email' => $row['Email']
                ];
            } else {
                return null;
            }
        } catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return null;
        }
    }

    public function updateProfile() {
        $params = [$this->nom, $this->prenom, $this->telephone, $this->email];
        $updatePassword = '';
        $updatePhoto = '';
        $setClauses = [];

        if (!empty($this->mot_de_passe)) {
            $params[] = $this->mot_de_passe;  
            $updatePassword = "Mot_de_passe = ?";
            $setClauses[] = $updatePassword;
        }

        if (!empty($this->photo)) {
            $params[] = $this->photo;  
            $updatePhoto = "Photo = ?";
            $setClauses[] = $updatePhoto;
        }

        $params[] = $this->id;

        $setClause = "Nom = ?, Prenom = ?, Telephone = ?, Email = ?";

        if (!empty($setClauses)) {
            $setClause .= ", " . implode(", ", $setClauses);
        }

        $sql = "UPDATE utilisateur SET $setClause WHERE ID = ?";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }
}

?>
