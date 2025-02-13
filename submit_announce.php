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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer et sécuriser les données du formulaire
    $ann_offre = htmlentities($_POST['ann_offre']);
    $ann_type = htmlentities($_POST['ann_type']);
    $ann_piece = htmlentities($_POST['ann_piece']);
    $ann_ref = htmlentities($_POST['ann_ref']);
    $ann_titre = htmlentities($_POST['ann_titre']);
    $ann_description = htmlentities($_POST['ann_description']);
    $ann_localisation = htmlentities($_POST['ann_localisation']);
    $ann_surf_hab = htmlentities($_POST['ann_surf_hab']);
    $ann_suf_total = htmlentities($_POST['ann_suf_total']);
    $ann_vue = htmlentities($_POST['ann_vue']);
    $ann_diag_energie = htmlentities($_POST['ann_diag_energie']);
    $ann_prix_bien = htmlentities($_POST['ann_prix_bien']);
    $ann_date_ajout = htmlentities($_POST['ann_date_ajout']);
    $ann_date_modif = htmlentities($_POST['ann_date_modif']);
    $type_offre_id = htmlentities($_POST['type_offre_id']);
    $type_bien_id = htmlentities($_POST['type_bien_id']);
    $utilisateur_id = htmlentities($_POST['utilisateur_id']);

    // Préparer et exécuter la requête d'insertion
    $stmt = $pdo->prepare("INSERT INTO waz_annonces (ann_offre, ann_type, ann_piece, ann_ref, ann_titre, ann_description, ann_localisation, ann_surf_hab, ann_suf_total, ann_vue, ann_diag_energie, ann_prix_bien, ann_date_ajout, ann_date_modif, type_offre_id, type_bien_id, utilisateur_id) VALUES (:ann_offre, :ann_type, :ann_piece, :ann_ref, :ann_titre, :ann_description, :ann_localisation, :ann_surf_hab, :ann_suf_total, :ann_vue, :ann_diag_energie, :ann_prix_bien, :ann_date_ajout, :ann_date_modif, :type_offre_id, :type_bien_id, :utilisateur_id)");
    $stmt->bindParam(':ann_offre', $ann_offre);
    $stmt->bindParam(':ann_type', $ann_type);
    $stmt->bindParam(':ann_piece', $ann_piece);
    $stmt->bindParam(':ann_ref', $ann_ref);
    $stmt->bindParam(':ann_titre', $ann_titre);
    $stmt->bindParam(':ann_description', $ann_description);
    $stmt->bindParam(':ann_localisation', $ann_localisation);
    $stmt->bindParam(':ann_surf_hab', $ann_surf_hab);
    $stmt->bindParam(':ann_suf_total', $ann_suf_total);
    $stmt->bindParam(':ann_vue', $ann_vue);
    $stmt->bindParam(':ann_diag_energie', $ann_diag_energie);
    $stmt->bindParam(':ann_prix_bien', $ann_prix_bien);
    $stmt->bindParam(':ann_date_ajout', $ann_date_ajout);
    $stmt->bindParam(':ann_date_modif', $ann_date_modif);
    $stmt->bindParam(':type_offre_id', $type_offre_id);
    $stmt->bindParam(':type_bien_id', $type_bien_id);
    $stmt->bindParam(':utilisateur_id', $utilisateur_id);

    if ($stmt->execute()) {
        $ann_id = $pdo->lastInsertId();

        // Gérer le téléchargement des photos
        if (isset($_FILES['photos']) && count($_FILES['photos']['name']) > 0) {
            $uploadDir = 'uploads/';
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