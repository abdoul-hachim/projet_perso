<?php

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
echo "Connexion réussie";

// Fermer la connexion (facultatif, généralement géré par le serveur)
$conn->close();
?>
