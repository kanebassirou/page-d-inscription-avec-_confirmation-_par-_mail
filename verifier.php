<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=confirmation email;charset=utf8;', 'root', '');
if(isset($_GET['id']) AND !empty($_GET['id']) AND isset($_GET['cle']) AND !empty($_GET['cle'])){
    $getid = $_GET['id'];
    $getcle =$_GET['cle'];
    $recuUser =$bdd->prepare('SELECT *FROM users WHERE id =? AND cle =?');
    $recuUser ->execute(array($getid,$getcle));
    if($recuUser->rowCount()>0){
        $userInfo = $recuUser->fetch();
        if($userInfo['confirme']!= 1){
            $updateConfirme= $bdd ->prepare('UPDATE users SET confirme=? WHERE id =?');
            $updateConfirme -> execute(array(1,$getid));
            $_SESSION['cle'] = $getcle;
            header('Location: index.php');

        }else{
            $_SESSION['cle'] = $getcle;
            header('Location: index.php');

        }
    }else{
        echo'votre cle ou identifiant est incorrecte';
    }

}else{
    echo "aucun utilisateur correspondants";
}


?>