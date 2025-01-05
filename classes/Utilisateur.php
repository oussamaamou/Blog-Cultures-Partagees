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

                if($email === $gtemail){
                    
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
        
    public function getProfileInfos($id){
        try {
                $sql = ("SELECT Nom, Prenom, Photo, Role, Telephone, Email FROM utilisateur WHERE ID = :id");
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
                }
                else{
                    return null;
                }
        }
        catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return null;
        }
    }


    public function updateProfile($ID, $nwnom, $nwprenom, $nwphoto, $nwtelephone, $nwemail, $nwmot_de_passe) {
        $params = [$nwnom, $nwprenom, $nwtelephone, $nwemail];
        $updatePassword = '';
        $updatePhoto = '';
        $setClauses = [];
    
        if (!empty($nwmot_de_passe)) {
            $nwmot_de_passe = password_hash($nwmot_de_passe, PASSWORD_DEFAULT);
            $params[] = $nwmot_de_passe;  
            $updatePassword = "Mot_de_passe = ?";
            $setClauses[] = $updatePassword;
        }
    
        if (!empty($nwphoto)) {
            $params[] = $nwphoto;  
            $updatePhoto = "Photo = ?";
            $setClauses[] = $updatePhoto;
        }
    
        $params[] = $ID;
    
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