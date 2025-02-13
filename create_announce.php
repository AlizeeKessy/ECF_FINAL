<?php include 'includes/header.php'; ?>
<?php
// Récupérer les valeurs de type_offre_libelle
$stmt = $pdo->prepare("SELECT type_offre_libelle FROM waz_type_offre");
$stmt->execute();
$type_offres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les valeurs de type_bien_libelle
$stmt = $pdo->prepare("SELECT type_bien_libelle FROM waz_type_bien");
$stmt->execute();
$type_biens = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les valeurs de option_libelle
$stmt = $pdo->prepare("SELECT option_libelle FROM waz_options");
$stmt->execute();
$options = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les valeurs de diag_energie_libelle
$stmt = $pdo->prepare("SELECT diag_energie_libelle FROM waz_diag_energie");
$stmt->execute();
$diag_energies = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer et sécuriser les données du formulaire
    $ann_offre = htmlentities($_POST['ann_offre']);
    $ann_type = htmlentities($_POST['ann_type']);
    $ann_piece = htmlentities($_POST['ann_piece']);
    $ann_titre = htmlentities($_POST['ann_titre']);
    $ann_description = htmlentities($_POST['ann_description']);
    $ann_localisation = htmlentities($_POST['ann_localisation']);
    $ann_surf_hab = htmlentities($_POST['ann_surf_hab']);
    $ann_suf_total = htmlentities($_POST['ann_suf_total']);
    $ann_vue = htmlentities($_POST['ann_vue']);
    $ann_diag_energie = $_POST['ann_diag_energie']; // Récupérer les diagnostics énergétiques sélectionnés
    $ann_prix_bien = htmlentities($_POST['ann_prix_bien']);
    $ann_date_ajout = htmlentities($_POST['ann_date_ajout']);
    $ann_date_modif = htmlentities($_POST['ann_date_modif']);
    $type_offre_libelle = htmlentities($_POST['type_offre_libelle']);
    $type_bien_libelle = htmlentities($_POST['type_bien_libelle']);
    $options_libelle = $_POST['options_libelle']; // Récupérer les options sélectionnées
    $utilisateur_libelle = htmlentities($_POST['utilisateur_libelle']);

    // Vérifier que les valeurs de type_offre_libelle, type_bien_libelle et options_libelle existent
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM waz_type_offre WHERE type_offre_libelle = :type_offre_libelle");
    $stmt->bindParam(':type_offre_libelle', $type_offre_libelle);
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        die("Erreur : type_offre_libelle invalide.");
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM waz_type_bien WHERE type_bien_libelle = :type_bien_libelle");
    $stmt->bindParam(':type_bien_libelle', $type_bien_libelle);
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        die("Erreur : type_bien_libelle invalide.");
    }

    // Récupérer les IDs correspondants aux libellés
    $stmt = $pdo->prepare("SELECT type_offre_id FROM waz_type_offre WHERE type_offre_libelle = :type_offre_libelle");
    $stmt->bindParam(':type_offre_libelle', $type_offre_libelle);
    $stmt->execute();
    $type_offre_id = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT type_bien_id FROM waz_type_bien WHERE type_bien_libelle = :type_bien_libelle");
    $stmt->bindParam(':type_bien_libelle', $type_bien_libelle);
    $stmt->execute();
    $type_bien_id = $stmt->fetchColumn();

    // Insérer l'annonce
    $stmt = $pdo->prepare("INSERT INTO waz_annonces (ann_offre, ann_type, ann_piece, ann_titre, ann_description, ann_localisation, ann_surf_hab, ann_suf_total, ann_vue, ann_prix_bien, ann_date_ajout, ann_date_modif, type_offre_id, type_bien_id, utilisateur_id) VALUES (:ann_offre, :ann_type, :ann_piece, :ann_titre, :ann_description, :ann_localisation, :ann_surf_hab, :ann_suf_total, :ann_vue, :ann_prix_bien, :ann_date_ajout, :ann_date_modif, :type_offre_id, :type_bien_id, :utilisateur_id)");
    $stmt->bindParam(':ann_offre', $ann_offre);
    $stmt->bindParam(':ann_type', $ann_type);
    $stmt->bindParam(':ann_piece', $ann_piece);
    $stmt->bindParam(':ann_titre', $ann_titre);
    $stmt->bindParam(':ann_description', $ann_description);
    $stmt->bindParam(':ann_localisation', $ann_localisation);
    $stmt->bindParam(':ann_surf_hab', $ann_surf_hab);
    $stmt->bindParam(':ann_suf_total', $ann_suf_total);
    $stmt->bindParam(':ann_vue', $ann_vue);
    $stmt->bindParam(':ann_prix_bien', $ann_prix_bien);
    $stmt->bindParam(':ann_date_ajout', $ann_date_ajout);
    $stmt->bindParam(':ann_date_modif', $ann_date_modif);
    $stmt->bindParam(':type_offre_id', $type_offre_id);
    $stmt->bindParam(':type_bien_id', $type_bien_id);
    $stmt->bindParam(':utilisateur_id', $utilisateur_libelle);

    if ($stmt->execute()) {
        $ann_id = $pdo->lastInsertId();

        // Insérer les options sélectionnées
        foreach ($options_libelle as $option_libelle) {
            $stmt = $pdo->prepare("SELECT option_id FROM waz_options WHERE option_libelle = :option_libelle");
            $stmt->bindParam(':option_libelle', $option_libelle);
            $stmt->execute();
            $option_id = $stmt->fetchColumn();

            $stmt = $pdo->prepare("INSERT INTO waz_annonces_options (ann_id, option_id) VALUES (:ann_id, :option_id)");
            $stmt->bindParam(':ann_id', $ann_id);
            $stmt->bindParam(':option_id', $option_id);
            $stmt->execute();
        }

        // Insérer les diagnostics énergétiques sélectionnés
        foreach ($ann_diag_energie as $diag_energie_libelle) {
            $stmt = $pdo->prepare("SELECT diag_energie_id FROM waz_diag_energie WHERE diag_energie_libelle = :diag_energie_libelle");
            $stmt->bindParam(':diag_energie_libelle', $diag_energie_libelle);
            $stmt->execute();
            $diag_energie_id = $stmt->fetchColumn();

            $stmt = $pdo->prepare("INSERT INTO waz_annonces_diag_energie (ann_id, diag_energie_id) VALUES (:ann_id, :diag_energie_id)");
            $stmt->bindParam(':ann_id', $ann_id);
            $stmt->bindParam(':diag_energie_id', $diag_energie_id);
            $stmt->execute();
        }

        // Gérer le téléchargement des photos
        if (isset($_FILES['photos']) && count($_FILES['photos']['name']) > 0) {
            $uploadDir = 'photos/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            foreach ($_FILES['photos']['name'] as $key => $name) {
                $tmpName = $_FILES['photos']['tmp_name'][$key];
                $fileName = basename($name);
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($tmpName, $uploadFile)) {
                    // Insérer le chemin de la photo dans la base de données
                    $stmt = $pdo->prepare("INSERT INTO waz_photos (ann_id, photo_path) VALUES (:ann_id, :photo_path)");
                    $stmt->bindParam(':ann_id', $ann_id);
                    $stmt->bindParam(':photo_path', $uploadFile);
                    $stmt->execute();
                }
            }
        }

        echo "L'annonce a été créée avec succès.";
    } else {
        echo "Une erreur est survenue lors de l'enregistrement de l'annonce. Veuillez réessayer plus tard.";
    }
}
?>
<main>
    <div class="container mt-4">
        <h1>Créer une annonce</h1>
        <form id="announceForm" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="ann_offre" class="form-label">Offre</label>
                <?php foreach ($type_offres as $type_offre): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type_offre_libelle" id="type_offre_<?php echo $type_offre['type_offre_libelle']; ?>" value="<?php echo $type_offre['type_offre_libelle']; ?>" required>
                        <label class="form-check-label" for="type_offre_<?php echo $type_offre['type_offre_libelle']; ?>">
                            <?php echo $type_offre['type_offre_libelle']; ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mb-3">
                <label for="type_bien_libelle" class="form-label">Type de bien</label>
                <select class="form-select" id="type_bien_libelle" name="type_bien_libelle" required>
                    <option value="" selected disabled>Choisir un type de bien</option>
                    <?php foreach ($type_biens as $type_bien): ?>
                        <option value="<?php echo $type_bien['type_bien_libelle']; ?>"><?php echo $type_bien['type_bien_libelle']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="ann_piece" class="form-label">Nombre de pièces</label>
                <input type="number" class="form-control" placeholder="Ex: 5" id="ann_piece" name="ann_piece" required>
            </div>
            <div class="mb-3">
                <label for="ann_ref" class="form-label">Référence</label>
                <input type="text" class="form-control" placeholder="Ex: REF012" id="ann_ref" name="ann_ref" required>
            </div>
            <div class="mb-3">
                <label for="ann_titre" class="form-label">Titre</label>
                <input type="text" class="form-control" id="ann_titre" name="ann_titre" required>
            </div>
            <div class="mb-3">
                <label for="ann_description" class="form-label">Description</label>
                <textarea class="form-control" id="ann_description" name="ann_description" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="ann_localisation" class="form-label">Localisation</label>
                <input type="text" class="form-control" id="ann_localisation" name="ann_localisation" required>
            </div>
            <div class="mb-3">
                <label for="ann_surf_hab" class="form-label">Surface habitable (m²)</label>
                <input type="number" class="form-control" id="ann_surf_hab" name="ann_surf_hab" required>
            </div>
            <div class="mb-3">
                <label for="ann_suf_total" class="form-label">Surface totale (m²)</label>
                <input type="number" class="form-control" id="ann_suf_total" name="ann_suf_total" required>
            </div>
            <div class="mb-3">
                <label for="ann_vue" class="form-label">Vue</label>
                <input type="number" class="form-control" id="ann_vue" name="ann_vue" required>
            </div>
            <div class="mb-3">
                <label for="ann_diag_energie" class="form-label">Diagnostic énergétique</label>
                <?php foreach ($diag_energies as $diag_energie): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="ann_diag_energie[]" id="diag_energie_<?php echo $diag_energie['diag_energie_libelle']; ?>" value="<?php echo $diag_energie['diag_energie_libelle']; ?>">
                        <label class="form-check-label" for="diag_energie_<?php echo $diag_energie['diag_energie_libelle']; ?>">
                            <?php echo $diag_energie['diag_energie_libelle']; ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mb-3">
                <label for="ann_prix_bien" class="form-label">Prix</label>
                <input type="number" class="form-control" id="ann_prix_bien" name="ann_prix_bien" required>
            </div>
            <div class="mb-3">
                <label for="ann_date_ajout" class="form-label">Date d'ajout</label>
                <input type="date" class="form-control" id="ann_date_ajout" name="ann_date_ajout" required>
            </div>
            <div class="mb-3">
                <label for="ann_date_modif" class="form-label">Date de modification</label>
                <input type="date" class="form-control" id="ann_date_modif" name="ann_date_modif" required>
            </div>
            <div class="mb-3">
                <label for="utilisateur_libelle" class="form-label">ID Utilisateur</label>
                <input type="text" class="form-control" id="utilisateur_libelle" name="utilisateur_libelle" required>
            </div>
            <div class="mb-3">
                <label for="options_libelle" class="form-label">Options</label>
                <?php foreach ($options as $option): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="options_libelle[]" id="option_<?php echo $option['option_libelle']; ?>" value="<?php echo $option['option_libelle']; ?>">
                        <label class="form-check-label" for="option_<?php echo $option['option_libelle']; ?>">
                            <?php echo $option['option_libelle']; ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">Photos</label>
                <input type="file" class="form-control" id="photos" name="photos[]" multiple required>
            </div>
            <button type="submit" class="btn btn-primary">Créer l'annonce</button>
        </form>
    </div>
</main>
<?php include 'includes/footer.php'; ?>