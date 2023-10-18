<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['index'])) {
    $index = $_GET['index'];
    $tempFile = '../txt/temp.txt';
    $ttFile = '../txt/citations.txt';

    if (file_exists($tempFile) && file_exists($ttFile)) {
        $tempLines = file($tempFile, FILE_IGNORE_NEW_LINES);
        $ttLines = file($ttFile, FILE_IGNORE_NEW_LINES);

        if ($index >= 0 && $index < count($tempLines)) {
            // Valider la ligne en la copiant de temp.txt vers tt.txt
            $lineToValidate = $tempLines[$index];
            file_put_contents($ttFile, $lineToValidate . PHP_EOL, FILE_APPEND | LOCK_EX);

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
