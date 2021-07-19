<?php 

require_once "class/db.class.php";

$db = new DB();



// definition des input comme vide
$nom = $prenom = $login = $mdp = $mdpv = " ";
// mise en place des patern pour les inputs d'inscription
$patternName = "/^[a-z][a-z '-]+$/i";
$patternMdp = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/";

if( $_SERVER['REQUEST_METHOD'] == 'POST') {

  $nom = $db->test_input($_POST['nom']);
  $prenom = $db->test_input($_POST['prenom']);
  $login = $db->test_input($_POST['login']);
  $mdp = $_POST['mdp'];
  $mdpv = $_POST['mdpv'];
  

  if($mdp == $mdpv && preg_match($patternName, $nom) && preg_match($patternName, $prenom) && preg_match($patternName, $login)){
    
    echo $db->inscriptionData($nom, $prenom, $login, $db->hashPass($mdp));
    
  }
  
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <div>
    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST">
    <div>
      <label for="nom">Nom :</label>
      <input type="text" name="nom">
      <?php 
        if(empty($nom)) echo '*le champ nom est vide';
        else if(!preg_match($patternName, $nom) && $_SERVER['REQUEST_METHOD'] == 'POST') echo 'le nom n\'est pas valide';
      ?>
    </div>
    <div>
      <label for="prenom">Prenom :</label>
      <input type="text" name="prenom">
      <?php 
        if(empty($prenom)) echo '*le champ prenom est vide';
        else if(!preg_match($patternName, $prenom) && $_SERVER['REQUEST_METHOD'] == 'POST') echo 'le prenom n\'est pas valide';
      ?>
    </div>
    <div>
      <label for="login">login :</label>
      <input type="text" name="login">
      <?php 
        if(empty($login)) echo '*le champ login est vide';
        else if(!preg_match($patternName, $login) && $_SERVER['REQUEST_METHOD'] == 'POST') echo 'le login n\'est pas valide';
      ?>
    </div>
    <div>
      <label for="mdp">Mot de passe :</label>
      <input type="text" name="mdp">
      <?php 
        if(empty($mdp)) echo '*le champ mdp est vide';
        else if(!preg_match($patternMdp, $mdp) && $_SERVER['REQUEST_METHOD'] == 'POST') echo 'le mdp n\'est pas valide';
      ?>
    </div>
    <div>
      <label for="mdpv">Confirmez le mot de passe :</label>
      <input type="text" name="mdpv">
      <?php 
        if(empty($mdpv)) echo '*le champ validation de mdp est vide';
        else if($mdpv != $mdp && $_SERVER['REQUEST_METHOD'] == 'POST') echo 'le validation de mdp n\'est pas valide';
      ?>
  </div>
    <div>
      <input type="submit"name="submit">
    </div>
    </form>
  </div>  
</body>
</html>

<?php



?>