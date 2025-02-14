<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
// Connexion à la base de données
$host = "127.0.0.1";
$dbname = "afpa_wazaa_immo";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //  echo "✅ Connexion réussie à la base de données !";
} catch (PDOException $e) {
    die("❌ Erreur de connexion : " . $e->getMessage());
}

// Vérification des types d'utilisateurs
$isCommercialOrAdmin = isset($_SESSION['user_type']) && in_array($_SESSION['user_type'], ['Commercial', 'Admin']);
$isAdmin = isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'Admin';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <title>Accueil</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="index.php">
                    <img src="photos/wazaa_logo.png" alt="Bootstrap" width="60" height="48">
                </a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                        </li>
                        <?php if ($isAdmin): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Admin</a>
                        </li>
                        <?php endif; ?>
                        <?php if ($isCommercialOrAdmin): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="create_announce.php">Créer une annonce</a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="a_propos.php">À propos</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Rechercher" aria-label="Search">
                        <button class="btn btn-outline-light" type="submit">Rechercher</button>
                    </form>
                    <ul class="navbar-nav me mb-2 mb-lg-0">
                        <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a href="deconnexion.php" class="btn btn-primary">Déconnexion</a>
                        </li>
                        <?php else: ?>
                        <li class="nav-item">
                            <a href="connexion.php" class="btn btn-primary">Connexion</a>
                            <a href="inscription.php" class="btn btn-primary">Inscription</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>