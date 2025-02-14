<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'includes/header.php'; ?>
<?php

// Vérification si l'utilisateur est un administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'Admin') {
    echo '<meta http-equiv="refresh" content="0;url=index.php">'; // Redirection vers la page d'accueil si l'utilisateur n'est pas un administrateur
    exit();
}

// Traitement de la soumission du formulaire d'ajout d'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire en méthode POST
    $nom = htmlentities(trim($_POST['nom']));
    $prenom = htmlentities(trim($_POST['prenom']));
    $email = htmlentities(trim($_POST['email']));
    $telephone = htmlentities(trim($_POST['telephone']));
    $mot_de_passe = password_hash(trim($_POST['mot_de_passe']), PASSWORD_DEFAULT);
    $type_utilisateur_id = intval($_POST['type_utilisateur_id']);

    // Préparer et exécuter la requête d'insertion
    $stmt = $pdo->prepare("INSERT INTO waz_utilisateurs (utilisateur_pseudo, utilisateur_email, utilisateur_mdp, type_utilisateur_id) VALUES (:nom, :email, :mot_de_passe, :type_utilisateur_id)");
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mot_de_passe', $mot_de_passe);
    $stmt->bindParam(':type_utilisateur_id', $type_utilisateur_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Utilisateur ajouté avec succès.";
        echo '<meta http-equiv="refresh" content="0;url=admin.php">'; // Redirection vers la page d'accueil
    } else {
        $_SESSION['message'] = "Une erreur est survenue lors de l'ajout de l'utilisateur. Veuillez réessayer plus tard.";
    }
}

// Récupération des utilisateurs existants
$stmt = $pdo->prepare("SELECT u.*, t.type_utilisateur_libelle FROM waz_utilisateurs u JOIN waz_types_utilisateurs t ON u.type_utilisateur_id = t.type_utilisateur_id");
$stmt->execute();
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <div class="container mt-4">
        <h1>Gestion des utilisateurs</h1>

        <?php
        if (!empty($_SESSION['message'])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
            $_SESSION['message'] = "";
        }
        ?>

        <h2>Ajouter un utilisateur</h2>
        <form method="post">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="tel" class="form-control" id="telephone" name="telephone" required>
            </div>
            <div class="mb-3">
                <label for="mot_de_passe" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
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
                        echo '<option value="' . $type['type_utilisateur_id'] . '">' . $type['type_utilisateur_libelle'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>

        <h2 class="mt-4">Liste des utilisateurs</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Type d'utilisateur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($utilisateurs as $utilisateur) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($utilisateur['utilisateur_id']); ?></td>
                        <td><?php echo htmlspecialchars($utilisateur['utilisateur_pseudo']); ?></td>
                        <td><?php echo htmlspecialchars($utilisateur['utilisateur_email']); ?></td>
                        <td><?php echo htmlspecialchars($utilisateur['utilisateur_telephone']); ?></td>
                        <td><?php echo htmlspecialchars($utilisateur['type_utilisateur_libelle']); ?></td>
                        <td>
                            <a href="modifier_utilisateur.php?id=<?php echo $utilisateur['utilisateur_id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="supprimer_utilisateur.php?id=<?php echo $utilisateur['utilisateur_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include 'includes/footer.php'; ?>