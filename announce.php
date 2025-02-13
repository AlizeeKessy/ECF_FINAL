<?php
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

// Récupérer l'ID de l'annonce depuis l'URL
$ann_id = isset($_GET['ann_id']) ? intval($_GET['ann_id']) : 0;

if ($ann_id > 0) {
    // Préparer et exécuter la requête pour récupérer les informations de l'annonce
    $stmt = $pdo->prepare("SELECT * FROM waz_annonces WHERE ann_id = :ann_id");
    $stmt->bindParam(':ann_id', $ann_id);
    $stmt->execute();
    $annonce = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($annonce) {
        // Récupérer les photos associées à l'annonce
        $stmt = $pdo->prepare("SELECT photo_path FROM waz_photos WHERE ann_id = :ann_id");
        $stmt->bindParam(':ann_id', $ann_id);
        $stmt->execute();
        $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        die("Annonce non trouvée.");
    }
} else {
    die("ID d'annonce invalide.");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <title>Annonce - <?php echo htmlspecialchars($annonce['ann_titre']); ?></title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">Mon Agence Immobilière</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="create_announce.php">Créer une annonce</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Rechercher" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Rechercher</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1><?php echo htmlspecialchars($annonce['ann_titre']); ?></h1>
        <p><strong>Type :</strong> <?php echo htmlspecialchars($annonce['ann_type']); ?></p>
        <p><strong>Offre :</strong> <?php echo htmlspecialchars($annonce['ann_offre']); ?></p>
        <p><strong>Nombre de pièces :</strong> <?php echo htmlspecialchars($annonce['ann_piece']); ?></p>
        <p><strong>Référence :</strong> <?php echo htmlspecialchars($annonce['ann_ref']); ?></p>
        <p><strong>Description :</strong> <?php echo nl2br(htmlspecialchars($annonce['ann_description'])); ?></p>
        <p><strong>Localisation :</strong> <?php echo htmlspecialchars($annonce['ann_localisation']); ?></p>
        <p><strong>Surface habitable :</strong> <?php echo htmlspecialchars($annonce['ann_surf_hab']); ?> m²</p>
        <p><strong>Surface totale :</strong> <?php echo htmlspecialchars($annonce['ann_suf_total']); ?> m²</p>
        <p><strong>Vue :</strong> <?php echo htmlspecialchars($annonce['ann_vue']); ?></p>
        <p><strong>Diagnostic énergétique :</strong> <?php echo htmlspecialchars($annonce['ann_diag_energie']); ?></p>
        <p><strong>Prix :</strong> <?php echo htmlspecialchars($annonce['ann_prix_bien']); ?> €</p>
        <p><strong>Date d'ajout :</strong> <?php echo htmlspecialchars($annonce['ann_date_ajout']); ?></p>
        <p><strong>Date de modification :</strong> <?php echo htmlspecialchars($annonce['ann_date_modif']); ?></p>

        <h2>Photos</h2>
        <div class="row">
            <?php foreach ($photos as $photo): ?>
                <div class="col-md-4">
                    <img src="<?php echo htmlspecialchars($photo['photo_path']); ?>" class="img-fluid" alt="Photo de l'annonce">
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="script/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>