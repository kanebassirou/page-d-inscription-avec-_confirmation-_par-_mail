<?php

require 'PHPMailer-php-8.2/PHPMailer-php-8.2/src/SMTP.php';
require 'PHPMailer-php-8.2/PHPMailer-php-8.2/src/PHPMailer.php';
require 'PHPMailer-php-8.2/PHPMailer-php-8.2/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;

session_start();
$bdd = new PDO('mysql:host=localhost;dbname=confirmation email;charset=utf8;', 'root', '');

if (isset($_POST['valider'])) {
    if (!empty($_POST['email'])) {
        $cle = rand(100000, 900000);
        $email = $_POST['email'];
        try {
            // Préparez votre requête d'insertion
            $insertUser = $bdd->prepare('INSERT INTO users (email, cle, confirme) VALUES (?, ?, ?)');
        
            // Exécutez la requête avec les valeurs
            $insertUser->execute(array($email, $cle, 0));
            
        
            // Le reste de votre code après l'insertion réussie
            // ...
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                // La violation de contrainte unique s'est produite
                echo "L'adresse e-mail est déjà utilisée. Veuillez en choisir une autre.";
            } else {
                // Autre erreur PDO
                echo "Une erreur s'est produite lors de l'insertion dans la base de données.";
            }
        }
        

        $recUser = $bdd->prepare('SELECT * FROM users WHERE email = ?');
        $recUser->execute(array($email));

        if ($recUser->rowCount() > 0) {
            $userInfo = $recUser->fetch();
            $_SESSION['id'] = $userInfo['id'];

            function smtpmailer($to, $from, $from_name, $subject, $body)
            {
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->SMTPAuth = true;

                $mail->SMTPSecure = 'tls';
                $mail->Host = 'smtp.gmail.com';
                $mail->Port =587;
                $mail->Username = 'kaneb1927@gmail.com';
                $mail->Password = 'mpbwqjgyjgakrtmc
                ';

                $mail->IsHTML(true);
                $mail->From = $from;
                $mail->FromName = $from_name;
                $mail->Sender = $from;
                $mail->AddReplyTo($from, $from_name);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->AddAddress($to);

                if (!$mail->Send()) {
                    $error = "Une erreur s'est produite lors de l'envoi de l'e-mail. Veuillez réessayer plus tard.";
                    return $error;
                } else {
                    $error = "Merci ! Votre e-mail a été envoyé.";
                    return $error;
                }
            }

            $to = $_POST['email'];
            $from = 'kaneb1927@gmail.com';
            $name = 'Bassirou kane';
            $subj = 'Confirmation d\'e-mail pour activer votre compte';
            $msg = 'http://localhost/mon%20bog/confirmation%20par%20mail/verifier.php?id='. $_SESSION['id'] . '&cle=' . $cle;


            $error = smtpmailer($to, $from, $name, $subj, $msg);

            if (!empty($error)) {
                echo $error;
            }
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
    
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>

<body>
    <form action="" method="post">
        <input type="email" name="email">
        <br>
        <input type="submit" name="valider">
    </form>
    <a href="/PHPMailer-php-8.2/PHPMailer-php-8.2/src/PHPMailer.php"></a>

</body>

</html>