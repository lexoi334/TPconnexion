<?php 

require_once 'class/db.class.php';
//appel de la class et de son construct
$db = new DB();

if( $_SERVER['REQUEST_METHOD'] == 'POST' ){

  $login = $db->test_input($_POST['login']);
  $mdp = $_POST['mdp'];

if($db->verifConnexion($login, $mdp)){

  
  echo 'Connexion réussie !';
  $_SESSION['validation'] = 'ok';
  header('location: session.php');
} else echo 'Mot de passe et/ou Pseudo incorect';
}

if(isset($_SESSION['validation']) && $_SESSION['validation'] == 'ok'){
  header('location: session.php');
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
  <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
    <div>
      <label for="login">Pseudo :</label>
      <input type="text" name="login">
    </div>
    <div>
      <label for="mdp">Mot de passe :</label>
      <input type="text" name="mdp">
    </div>
    <input type="submit" name="submit">
  </form>
</body>
</html>