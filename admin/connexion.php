<?php
require_once('uranus.php');

session_start();

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['connected'])) {
    header('Location: index.php');
    exit();
}

// Vérifier si la variable de session existe
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

// Initialiser la variable pour stocker la valeur de l'identifiant
$identifiant_saisi = '';

// Vérifier si le formulaire de connexion est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier les identifiants de connexion
    $identifiant = $_POST['identifiant'] ?? '';
    $mdp = $_POST['mdp'] ?? '';

    // Stocker la valeur de l'identifiant saisie
    $identifiant_saisi = $identifiant;

    // Vérifier si les identifiants sont corrects // Changer MDP
    if ($identifiant === $IDENTIFIANT && hash('sha256', $mdp) === $PASSWORD_ONE) {
        // Réinitialiser le compteur de tentatives
        $_SESSION['login_attempts'] = 0;
        $_SESSION['connected'] = true;
        $_SESSION['last_activity'] = time();
        $_SESSION['$timeout'] = 300;

        // Rediriger vers la page index.php
        header('Location: index.php');
        exit();
    } else {
        // Incrémenter le compteur de tentatives
        $_SESSION['login_attempts']++;

        // Enregistrer l'heure de la dernière tentative
        $_SESSION['last_login_attempt'] = time();

        // Afficher le message d'erreur
        $erreur = "Identifiant ou mot de passe incorrect.";
    }
}

// Vérifier si le nombre de tentatives a atteint la limite
if ($_SESSION['login_attempts'] >= 5) {
    echo '<script>
            alert("Trop de tentatives de connexion. Veuillez patientez un instant.");
            window.location.reload();
            </script>';
        $_SESSION['login_attempts'] = 0;
        exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="../css/admin.css">
    <script src="../js/conn_php.js"></script>
</head>
<body onload="masquerMessageErreur()">
    <h1 class="titre_conn">Connexion</h1>
    <?php if (isset($erreur)) { ?>
        <p id="error_conn"><?php echo $erreur; ?></p>
    <?php } ?>
    <form action="connexion.php" method="post">
        <input class="buttons_conn" type="text" name="identifiant" placeholder="Identifiant" required value="<?php echo htmlspecialchars($identifiant_saisi); ?>"><br>
        <input class="buttons_conn" type="password" name="mdp" placeholder="Mot de passe" required><br>
        <input type="submit" value="Se connecter" id="connect_btn">
    </form>
</body>
</html>