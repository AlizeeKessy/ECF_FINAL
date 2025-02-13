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
    // Vérifier si les champs sont définis
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['telephone'], $_POST['mot_de_passe'], $_POST['type_utilisateur_id'])) {
        // Récupérer et sécuriser les données du formulaire
        $nom = htmlentities($_POST['nom']);
        $prenom = htmlentities($_POST['prenom']);
        $email = htmlentities($_POST['email']);
        $telephone = htmlentities($_POST['telephone']);
        $mot_de_passe = $_POST['mot_de_passe'];
        $type_utilisateur_id = htmlentities($_POST['type_utilisateur_id']);

        // Hashage du mot de passe
        $password_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Préparer et exécuter la requête d'insertion
        $stmt = $pdo->prepare("INSERT INTO waz_utilisateurs (nom, prenom, email, telephone, mot_de_passe, type_utilisateur_id) VALUES (:nom, :prenom, :email, :telephone, :mot_de_passe, :type_utilisateur_id)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':mot_de_passe', $password_hash);
        $stmt->bindParam(':type_utilisateur_id', $type_utilisateur_id);

        if ($stmt->execute()) {
            echo "Inscription réussie.";
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