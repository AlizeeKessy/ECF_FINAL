<?php include 'includes/header.php'; ?>
<?php
// Vérification si l'utilisateur est un administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'Admin') {
    echo '<meta http-equiv="refresh" content="0;url=index.php">'; // Redirection vers la page d'accueil si l'utilisateur n'est pas un administrateur
    exit();
}

// Récupération de l'utilisateur à modifier
$utilisateur_id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM waz_utilisateurs WHERE utilisateur_id = :id");
$stmt->bindParam(':id', $utilisateur_id);
$stmt->execute();
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$utilisateur) {
    die("Utilisateur non trouvé.");
}

// Traitement de la soumission du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire en méthode POST
    $nom = htmlentities(trim($_POST['nom']));
    $prenom = htmlentities(trim($_POST['prenom']));
    $email = htmlentities(trim($_POST['email']));
    $telephone = htmlentities(trim($_POST['telephone']));
    $type_utilisateur_id = intval($_POST['type_utilisateur_id']);

    // Préparer et exécuter la requête de mise à jour
    $stmt = $pdo->prepare("UPDATE waz_utilisateurs SET utilisateur_pseudo = :nom, utilisateur_email = :email, utilisateur_telephone = :telephone, type_utilisateur_id = :type_utilisateur_id WHERE utilisateur_id = :id");
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telephone', $telephone);
    $stmt->bindParam(':type_utilisateur_id', $type_utilisateur_id);
    $stmt->bindParam(':id', $utilisateur_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Utilisateur modifié avec succès.";
        echo '<meta http-equiv="refresh" content="0;url=admin.php">'; // Redirection vers la page d'administration
        exit();
    } else {
        $_SESSION['message'] = "Une erreur est survenue lors de la modification de l'utilisateur. Veuillez réessayer plus tard.";
    }
}
?>

<main>
    <div class="container mt-4">
        <h1>Modifier l'utilisateur</h1>

        <?php
        if (!empty($_SESSION['message'])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
            $_SESSION['message'] = "";
        }
        ?>

        <form method="post">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($utilisateur['utilisateur_pseudo']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($utilisateur['utilisateur_prenom']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($utilisateur['utilisateur_email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="tel" class="form-control" id="telephone" name="telephone" value="<?php echo htmlspecialchars($utilisateur['utilisateur_telephone']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="type_utilisateur_id" class="form-label">Type d'utilisateur</label>
                <select class="form-control" id="type_utilisateur_id" name="type_utilisateur_id" required>
                    <?php
                    // Récupération des types d'utilisateurs
                    $stmt = $pdo->prepare("SELECT * FROM waz_types_utilisateurs");
                    $stmt->execute();
                    $types_utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($types_utilisateurs as $type) {
                        $selected = $type['type_utilisateur_id'] == $utilisateur['type_utilisateur_id'] ? 'selected' : '';
                        echo '<option value="' . $type['type_utilisateur_id'] . '" ' . $selected . '>' . $type['type_utilisateur_libelle'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>
</main>

<?php include 'includes/footer.php'; ?>