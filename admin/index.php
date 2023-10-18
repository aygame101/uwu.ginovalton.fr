<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Panneau d'administration</title>
</head>
<body>
    <h1>Panneau d'administration</h1>

    <?php
    $tempFile = '../txt/temp.txt';

    if (file_exists($tempFile)) {
        $tempLines = file($tempFile, FILE_IGNORE_NEW_LINES);

        if (!empty($tempLines)) {
            echo '<ul>';
            foreach ($tempLines as $index => $line) {
                echo '<li>' . htmlspecialchars($line) . '</li>';
                echo '<button onclick="validateLine(' . $index . ')">Valider</button>';
                echo '<button onclick="deleteLine(' . $index . ')">Supprimer</button>';
            }
            echo '</ul>';
        } else {
            echo '<p>Aucune ligne à valider.</p>';
        }
    } else {
        echo '<p>Le fichier temporaire n\'existe pas.</p>';
    }
    ?>

    <script>
        function validateLine(index) {
            // Appeler un script PHP pour valider la ligne
            fetch('validate_line.php?index=' + index)
                .then(response => {
                    if (response.ok) {
                        location.reload(); // Recharger la page après validation
                    } else {
                        console.error('Erreur lors de la validation de la ligne.');
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la validation de la ligne :', error);
                });
        }

        function deleteLine(index) {
            // Appeler un script PHP pour supprimer la ligne
            fetch('delete_line.php?index=' + index)
                .then(response => {
                    if (response.ok) {
                        location.reload(); // Recharger la page après suppression
                    } else {
                        console.error('Erreur lors de la suppression de la ligne.');
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la suppression de la ligne :', error);
                });
        }
    </script>
</body>
</html>
