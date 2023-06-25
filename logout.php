<?php
session_start();
$_SEESION =array();
session_destroy();
header('Location: connexion.php');
?>