<?php
$lines = file('citations.txt', FILE_IGNORE_NEW_LINES);
if ($lines === false) {
    $response = array('line1' => 'Erreur de lecture du fichier', 'line2' => '');
} else {
    // Filtrer les lignes qui ont le statut 0 (non affichées)
    $unshownLines = array_filter($lines, function($line) {
        $parts = explode(';', trim($line));
        return end($parts) === '0';
    });

    if (empty($unshownLines)) {
        // Toutes les lignes sont déjà affichées, réinitialisation
        foreach ($lines as &$line) {
            $parts = explode(';', trim($line));
            $parts[count($parts) - 1] = '0';
            $line = implode(';', $parts);
        }
        file_put_contents('citations.txt', implode("\n", $lines));
        $unshownLines = $lines;
    }

    // Sélectionner une ligne non affichée au hasard
    $randomIndex = array_rand($unshownLines);
    $line = $unshownLines[$randomIndex];
    list($line1, $line2, $status) = explode(';', trim($line));

    // Mettre à jour le statut de la ligne
    $parts = explode(';', trim($line));
    $parts[count($parts) - 1] = '1';
    $lines[$randomIndex] = implode(';', $parts);
    file_put_contents('citations.txt', implode("\n", $lines));

    $response = array('line1' => $line1, 'line2' => $line2, 'status' => $status);
}

header('Content-Type: application/json');
echo json_encode($response);

// Vérifier si toutes les lignes sont à 1 et réinitialiser
if (count(array_filter($lines, function($line) {
    $parts = explode(';', trim($line));
    return end($parts) === '1';
})) === count($lines)) {
    foreach ($lines as &$line) {
        $parts = explode(';', trim($line));
        $parts[count($parts) - 1] = '0';
        $line = implode(';', $parts);
    }
    file_put_contents('citations.txt', implode("\n", $lines));
}
?>
