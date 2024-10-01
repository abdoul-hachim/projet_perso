<?php
// Démarrer la session
session_start();

// Inclusion de la connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grecus";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérifier que les champs 'username' et 'password' existent
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Récupérer les données du formulaire et les sécuriser
        $user = htmlspecialchars($_POST['username']); // Échapper les caractères spéciaux
        $pass = $_POST['password']; // Garder le mot de passe tel quel

        // Vérifier que l'utilisateur existe dans la base de données
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        // Vérifier si l'utilisateur est trouvé
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Vérifier le mot de passe haché avec password_verify
            if (password_verify($pass, $row['password'])) {
                // Connexion réussie
                echo "Connexion réussie ! Bienvenue, " . $row['username'];

                // Stocker les informations de l'utilisateur dans la session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];

                // Rediriger vers la page d'accueil
                header('Location: ../index.php');
                exit(); // Arrêter l'exécution du script après la redirection
            } else {
                echo "Mot de passe incorrect.";
            }
        } else {
            echo "Aucun utilisateur trouvé avec ce nom d'utilisateur.";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
} else {
    echo "Formulaire non soumis.";
}

// Fermer la connexion
$conn->close();
?>
