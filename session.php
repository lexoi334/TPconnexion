<?php 
session_start();
require_once "class/db.class.php";
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
  <h1>Je suis la page session</h1>
</body>
</html>

<?php 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $login = $db->test_input($_POST['login']);
  $mdp = $_POST['mdp'];
}

if(isset($_POST['login']) && isset($_POST['mdp']) && $db->verifConnexion($login, $mdp) || $_SESSION['validation'] == 'ok'){
  $_SESSION['validation'] = 'ok';
} else {
  $_SESSION['validation'] = 'off';
  header('location: login.php');
}

?>