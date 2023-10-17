document.addEventListener('DOMContentLoaded', function () {
    const line1Element = document.getElementById('line1');
    const line2Element = document.getElementById('line2');

    fetch('loadline.php')
        .then(response => response.json())
        .then(data => {
            line1Element.textContent = data.line1;
            line2Element.textContent = data.line2;
        })
        .catch(error => {
            console.error('Erreur lors du chargement de la ligne :', error);
        });
});
