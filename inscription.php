<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs sont définis
    if (isset($_POST['pseudo'], $_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['telephone'], $_POST['mot_de_passe'])) {
        // Récupérer et sécuriser les données du formulaire
        $pseudo = htmlentities($_POST['pseudo']);
        $nom = htmlentities($_POST['nom']);
        $prenom = htmlentities($_POST['prenom']);
        $email = htmlentities($_POST['email']);
        $telephone = htmlentities($_POST['telephone']);
        $mot_de_passe = $_POST['mot_de_passe'];

        // Hashage du mot de passe
        $password_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Préparer et exécuter la requête d'insertion
        $stmt = $pdo->prepare("INSERT INTO waz_utilisateurs (utilisateur_pseudo, utilisateur_nom, utilisateur_prenom, utilisateur_email, utilisateur_mdp, type_utilisateur_id) VALUES (:pseudo, :nom, :prenom, :email, :mot_de_passe, 2)");
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mot_de_passe', $password_hash);

        if ($stmt->execute()) {
            echo "Inscription réussie.";
            $_SESSION['message'] = "Votre compte a bien été créé ! Vous pouvez maintenant vous connecter.";
            echo '<meta http-equiv="refresh" content="0;url=connexion.php">'; // Redirection vers la page d'accueil
            exit();;
        } else {
            echo "Une erreur est survenue lors de l'inscription. Veuillez réessayer plus tard.";
        }
    } else {
        echo "Veuillez remplir tous les champs du formulaire.";
    }
} else {
    echo "Méthode de requête non valide.";
}
?>
<main>
    <div class="container mt-4">
        <h1>Inscription</h1>
        <form id="inscriptionForm" method="post" action="inscription.php" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" required>
            </div>
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
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>
</main>
<?php include 'includes/footer.php'; ?>