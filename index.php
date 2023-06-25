<?php
session_start();

if(!$_SESSION['cle']){
    header('Location:connexion.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>INscription valider bravo</h1>
    
</body>
</html>