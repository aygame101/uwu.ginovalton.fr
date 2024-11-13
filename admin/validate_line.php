<?php

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['connected'])) {
    // Rediriger vers la page de connexion
    header('Location: connexion.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['index'])) {
    $index = $_GET['index'];
    $tempFile = '../txt/temp.txt';
    $ttFile = '../txt/citations.txt';
    $citGensFile = '../txt/cit_gens.txt';

    if (file_exists($tempFile) && file_exists($ttFile) && file_exists($citGensFile)) {
        $tempLines = file($tempFile, FILE_IGNORE_NEW_LINES);
        $ttLines = file($ttFile, FILE_IGNORE_NEW_LINES);
        $citGensLines = file($citGensFile, FILE_IGNORE_NEW_LINES);

        if ($index >= 0 && $index < count($tempLines)) {
            // Valider la ligne en la copiant de temp.txt vers tt.txt et cit_gens.txt
            $lineToValidate = $tempLines[$index];
            
            // Ajouter une ligne vide après chaque ligne existante dans tt.txt
            if (!empty($ttLines)) {
                file_put_contents($ttFile, implode(PHP_EOL, $ttLines) . PHP_EOL . $lineToValidate . PHP_EOL, LOCK_EX);
            } else {
                file_put_contents($ttFile, $lineToValidate . PHP_EOL, LOCK_EX);
            }

            // Ajouter une ligne vide après chaque ligne existante dans cit_gens.txt
            if (!empty($citGensLines)) {
                file_put_contents($citGensFile, implode(PHP_EOL, $citGensLines) . PHP_EOL . $lineToValidate . PHP_EOL, LOCK_EX);
            } else {
                file_put_contents($citGensFile, $lineToValidate . PHP_EOL, LOCK_EX);
            }

            // Supprimer la ligne de temp.txt
            unset($tempLines[$index]);
            file_put_contents($tempFile, implode(PHP_EOL, $tempLines));

            http_response_code(200); // OK
        } else {
            http_response_code(400); // Bad Request
        }
    } else {
        http_response_code(500); // Internal Server Error
    }
} else {
    http_response_code(400); // Bad Request
}
