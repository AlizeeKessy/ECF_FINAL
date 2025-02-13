<?php
$host = "127.0.0.1"; // Ou "localhost"
$dbname = "afpa_wazaa_immo"; // Mets ici le nom exact de ta base
$username = "root"; // Vérifie ton nom d'utilisateur MySQL
$password = ""; // Vérifie si ton mot de passe est vide ou défini

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connexion réussie à la base de données !";
} catch (PDOException $e) {
    die("❌ Erreur de connexion : " . $e->getMessage());
}
?>
