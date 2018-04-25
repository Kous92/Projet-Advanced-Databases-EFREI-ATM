<?php
session_start();
unset($_SESSION['auth']);
unset($_SESSION['nom']);
unset($_SESSION['prenom']);
unset($_SESSION['token']);
unset($_SESSION['token_retrait']);
header('Location: index.php');
?>