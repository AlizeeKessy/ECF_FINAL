<?php
include 'includes/header.php';
session_start();

// Vérification si l'utilisateur est un administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'Admin') {
    echo '<meta http-equiv="refresh" content="0;url=index.php">'; // Redirection vers la page d'accueil si l'utilisateur n'est pas un administrateur
    exit();
}

// Configuration de la base de données
$host = '127.0.0.1';
$dbname = 'afpa_wazaa_immo';
$username = 'root';
$password = '';

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération de l'utilisateur à supprimer
$utilisateur_id = intval($_GET['id']);

// Préparer et exécuter la requête de suppression
$stmt = $pdo->prepare("DELETE FROM waz_utilisateurs WHERE utilisateur_id = :id");
$stmt->bindParam(':id', $utilisateur_id);

if ($stmt->execute()) {
    $_SESSION['message'] = "Utilisateur supprimé avec succès.";
} else {
    $_SESSION['message'] = "Une erreur est survenue lors de la suppression de l'utilisateur. Veuillez réessayer plus tard.";
}

echo '<meta http-equiv="refresh" content="0;url=admin.php">'; // Redirection vers la page d'administration
exit();
?>