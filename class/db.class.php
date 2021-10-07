<?php 

class DB {
  //déclare les variables
  private $con;
  private $servername = "localhost";
  private $dbname = "tp_connexion";
  private $username = "alex";
  private $password = "******";
//fais un construct pour la connexion a la DB
  public function __construct() {

    $dsn = "mysql:host=". $this->servername. ";dbname=". $this->dbname;
//try & catch pour vérifier l'état de connexion
    try {
      $this->con = new PDO($dsn, $this->username, $this->password);
      $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connexion réussie";
    } catch(PDOException $e){
      echo "Connexion échouée". $e->getMessage();
    }
}

  public function inscriptionData($nom, $prenom, $login, $mdp){
    
    if($this->verifLog($login)){
      
      return 'Pseudo déjà utilisé mamene';
      
    } else {
      $query = "INSERT INTO utilisateurs (nom, prenom, login, pass) VALUES (:nom, :prenom, :login, :mdp)";
      $stmt = $this->con->prepare($query);
      $stmt->bindParam(':nom', $nom);
      $stmt->bindParam(':prenom', $prenom);
      $stmt->bindParam(':login', $login);
      $stmt->bindParam(':mdp', $mdp);
      $stmt->execute();
      return 'Enregistrement réussi';
    }
    
    
  }

  private function verifLog($login){
    $query = "SELECT login FROM utilisateurs WHERE login = :login";
    $stmt = $this->con->prepare($query);
    $stmt->bindParam(':login', $login);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $data = $stmt->fetchAll();
    return $data;
  }

  public function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  public function verifConnexion($login, $mdp){
    $query = "SELECT pass FROM utilisateurs WHERE login = :login LIMIT 1";
    $stmt = $this->con->prepare($query);
    $stmt->bindParam(':login', $login);
    // $stmt->bindParam(':pass', $mdp);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $data = $stmt->fetchColumn(0);
    $isVerif = $this->hashVerif($mdp, $data);
    return $isVerif;

  }

  public function hashPass($mdp){

    $hash = password_hash($mdp, PASSWORD_DEFAULT);
    return $hash;

  }

  public function hashVerif($mdp, $hash){

    
    if(password_verify($mdp, $hash))
    {
        echo "SUCCESS !!!!!!!!";
        if(password_needs_rehash($hash, PASSWORD_DEFAULT))
        {
            $newHash = password_hash($mdp, PASSWORD_DEFAULT);
        }
    }
    else
    {
        echo "ERRORRRRRRRRR !!!!!!!!!!!!!!!";
    }


    var_dump(password_get_info($hash));
  }


}

?>
