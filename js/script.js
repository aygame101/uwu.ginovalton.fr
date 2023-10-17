document.addEventListener('DOMContentLoaded', function () {
    const line1Element = document.getElementById('line1');
    const line2Element = document.getElementById('line2');
    const quoteForm = document.getElementById('quoteForm');

    // Chargement initial d'une citation
    loadRandomQuote();

    // Écouter la soumission du formulaire
    quoteForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const quote1Input = document.getElementById('quote1');
        const quote2Input = document.getElementById('quote2');

        const newQuote1 = quote1Input.value;
        const newQuote2 = quote2Input.value;

        // Enregistrer la nouvelle citation dans le fichier temp.txt
        saveNewQuote(newQuote1, newQuote2);

        // Réinitialiser les champs du formulaire
        quote1Input.value = '';
        quote2Input.value = '';

        // Charger une nouvelle citation aléatoire
        loadRandomQuote();
    });

    function loadRandomQuote() {
        fetch('save_load/loadline.php')
            .then(response => response.json())
            .then(data => {
                line1Element.textContent = data.line1;
                line2Element.textContent = data.line2;
            })
            .catch(error => {
                console.error('Erreur lors du chargement de la ligne :', error);
            });
    }

    function saveNewQuote(quote1, quote2) {
        const newQuote = `${quote1};${quote2};0\n`;
        fetch('save_load/savequote.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `quote=${encodeURIComponent(newQuote)}`,
        })
            .then(response => {
                if (response.ok) {
                    console.log('Citation enregistrée avec succès.');
                } else {
                    console.error('Erreur lors de l\'enregistrement de la citation.');
                }
            })
            .catch(error => {
                console.error('Erreur lors de l\'enregistrement de la citation :', error);
            });
    }
});
