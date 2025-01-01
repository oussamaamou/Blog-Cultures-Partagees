<?php

class Utilisateur{
    
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
        
    }

    public function inscriptionUtilisateur($nom, $prenom, $role, $telephone, $email, $mot_de_passe){
        
        $mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $sql = ("INSERT INTO utilisateur (Nom, Prenom, Role, Telephone, Email, Mot_de_passe) VALUES (:nom, :prenom, :role, :telephone, :email, :mot_de_passe )");
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':telephone', $telephone, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);

        return $stmt->execute();

    }

    public function loginUtilisateur($email, $mot_de_passe) {

        $sql = ("SELECT * FROM utilisateur WHERE Email = :email"); 
        $stmt = $this->conn->prepare($sql);
    
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    
        if($stmt->execute()){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                $gtID = $result['ID'];
                $gtrole = $result['Role'];
                $gtemail = $result['Email'];
                $gtmot_de_passe = $result['Mot_de_passe'];

                if($email === $gtemail && password_verify($mot_de_passe, $gtmot_de_passe)){
                    
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
                } 
                else {
                    echo "Mot de passe incorrect.";
                }
            } 
            else {
                echo "Email non trouvé.";
            }
        } 
        else {
            echo "Erreur lors de l'exécution de la requête.";
        }

    }
    
}

?>