<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

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

// Récupérer les informations de l'utilisateur à partir de la base de données
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Vérifier si l'utilisateur existe
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Utilisateur non trouvé.";
    exit();
}

// Fermer la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de <?php echo htmlspecialchars($user['username']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Profil de <?php echo htmlspecialchars($user['username']); ?></h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nom d'utilisateur : <?php echo htmlspecialchars($user['username']); ?></h5>
                <p class="card-text">Email : <?php echo htmlspecialchars($user['email']); ?></p>
                <p class="card-text">Secteur d'activité : <?php echo htmlspecialchars($user['sector_id']); ?></p>
                <p class="card-text">Date d'inscription : <?php echo htmlspecialchars($user['created_at']); ?></p>

                <!-- Si vous souhaitez permettre à l'utilisateur de modifier son profil -->
                <a href="edit_profile.php" class="btn btn-primary">Modifier le profil</a>
            </div>
        </div>
    </div>
</body>
</html>
