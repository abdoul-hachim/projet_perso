// Côté client, dans votre fichier JavaScript
fetch('register.php', {
    method: 'POST',
    body: new FormData(formElement),
})
.then(response => response.json())
.then(data => {
    if (data.status === 'success') {
        // Rediriger après succès
        window.location.href = 'login.html';
    } else {
        alert(data.message); // Afficher le message d'erreur
    }
});
