document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour la connexion à la base de données
    function checkDatabaseConnection() {
        fetch('db.php')
        .then(response => response.json())
        .then(data => {
            if (data.status !== 'connected') {
                alert("Échec de la connexion à la base de données.");
            }
        })
        .catch(error => {
            console.error('Erreur de connexion:', error);
        });
    }


    // Vérifier la connexion à la base de données
    checkDatabaseConnection();

    // Formulaire d'inscription
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Empêcher l'envoi classique du formulaire

        // Récupérer les données du formulaire
        const formData = new FormData(this);

        // Envoyer les données via AJAX
        fetch('./php/register.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const messageDiv = document.getElementById('responseMessage');
            messageDiv.innerHTML = data.message;

            if (data.status === 'success') {
                messageDiv.style.color = 'green';
            } else {
                messageDiv.style.color = 'red';
            }
        })
        .catch(error => {
            console.error('Erreur lors de l\'inscription:', error);
        });
    });
});
