<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quote'])) {
    $quote = $_POST['quote'];
    file_put_contents('../txt/temp.txt', $quote, FILE_APPEND | LOCK_EX);
    echo 'Citation enregistrée avec succès.';
} else {
    header('HTTP/1.1 400 Bad Request');
    echo 'Erreur lors de la requête.';
}
?>
