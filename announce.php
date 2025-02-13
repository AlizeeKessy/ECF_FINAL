<?php

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


<main>
    
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
</main>