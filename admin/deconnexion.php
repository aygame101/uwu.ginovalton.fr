<?php
session_start();

// Détruire toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion ou toute autre page souhaitée
header("Location: connexion.php");
exit();
?>