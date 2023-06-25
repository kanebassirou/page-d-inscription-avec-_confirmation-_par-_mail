<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=confirmation email;charset=utf8;', 'root', '');
if(isset($_POST['valider'])){
    if(!empty($_POST['email'])){
        $recupUser =$bdd->prepare('SELECT *FROM users WHERE email =?');
        $recupUser->execute(array($_POST['email']));
        if($recupUser->rowCount() >0){
            $userInfo = $recupUser->fetch();
            header('Location: verifier.php?id='.$userInfo['id'].'&cle'.$userInfo['cle']);
        }else{
            echo '';
        }

    }else{
        echo"Veuillez mettre votre e-mail svp";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conexion</title>
</head>
<body>
    <form action="" method="post">
        <input type="email" name="email">
        <br>
        <input type="submit" name="valider">


    </form>
</body>
</html>