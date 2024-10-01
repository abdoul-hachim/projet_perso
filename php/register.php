<?php
include 'db.php';

if (isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['sector'])) {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password']; // Mot de passe non haché
    $hashedPass = password_hash($pass, PASSWORD_BCRYPT); // Hachage du mot de passe
    $sector = (int)$_POST['sector'];

    
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => "L'email est déjà utilisé"]);
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => "Le nom d'utilisateur est déjà pris"]);
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM sectors WHERE id = ?");
    $stmt->bind_param("i", $sector);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo json_encode(['status' => 'error', 'message' => "Le secteur sélectionné n'existe pas."]);
        exit;
    }

    $stmt = $conn->prepare("SELECT password FROM users");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        if (password_verify($pass, $row['password'])) {
            echo json_encode(['status' => 'error', 'message' => ""]);
            exit;
        }
    }

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, sector_id, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssi", $user, $email, $hashedPass, $sector);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => "Inscription réussie !"]);
    } else {
        echo json_encode(['status' => 'error', 'message' => "Erreur lors de l'insertion : " . $conn->error]);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => "Données manquantes"]);
}

$conn->close();
?>
