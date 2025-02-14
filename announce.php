<?php include 'includes/header.php'; ?>
<?php
// Récupérer l'ID de l'annonce depuis l'URL
$ann_id = isset($_GET['ann_id']) ? intval($_GET['ann_id']) : 0;

if ($ann_id > 0) {
    // Récupérer les données de l'annonce
    $stmt = $pdo->prepare("SELECT * FROM waz_annonces WHERE ann_id = :ann_id");
    $stmt->bindParam(':ann_id', $ann_id);
    $stmt->execute();
    $annonce = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($annonce) {
        // Récupérer les options associées à l'annonce
        $stmt = $pdo->prepare("SELECT o.option_libelle FROM avoir a JOIN waz_options o ON a.option_id = o.option_id WHERE a.ann_id = :ann_id");
        $stmt->bindParam(':ann_id', $ann_id);
        $stmt->execute();
        $options = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Récupérer les photos associées à l'annonce
        $stmt = $pdo->prepare("SELECT photo_type_bien FROM waz_photos WHERE ann_id = :ann_id");
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
        <p><strong>Référence :</strong> <?php echo htmlspecialchars($annonce['ann_ref']); ?></p>
        <p><strong>Description :</strong> <?php echo htmlspecialchars($annonce['ann_description']); ?></p>
        <p><strong>Localisation :</strong> <?php echo htmlspecialchars($annonce['ann_localisation']); ?></p>
        <p><strong>Surface habitable :</strong> <?php echo htmlspecialchars($annonce['ann_surf_hab']); ?> m²</p>
        <p><strong>Surface totale :</strong> <?php echo htmlspecialchars($annonce['ann_suf_total']); ?> m²</p>
        <p><strong>Prix :</strong> <?php echo htmlspecialchars($annonce['ann_prix_bien']); ?> €</p>
        <p><strong>Diagnostic énergétique :</strong> <?php echo htmlspecialchars($annonce['ann_diag_energie']); ?></p>
        <p><strong>Options :</strong>
            <ul>
                <?php foreach ($options as $option): ?>
                    <li><?php echo htmlspecialchars($option['option_libelle']); ?></li>
                <?php endforeach; ?>
            </ul>
        </p>
        <p><strong>Photos :</strong>
            <div class="photos">
                <?php foreach ($photos as $photo): ?>
                    <img src="<?php echo htmlspecialchars($photo['photo_type_bien']); ?>" alt="Photo de l'annonce" style="max-width: 200px; margin: 10px;">
                <?php endforeach; ?>
            </div>
        </p>
    </div>
</main>
<?php include 'includes/footer.php'; ?>