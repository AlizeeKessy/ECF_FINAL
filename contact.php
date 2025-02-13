<?php include 'includes/header.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs sont définis
    if (isset($_POST['name'], $_POST['prenom'], $_POST['email'], $_POST['telephone'], $_POST['message'])) {
        // Récupérer et sécuriser les données du formulaire
        $name = htmlentities($_POST['name']);
        $prenom = htmlentities($_POST['prenom']);
        $email = htmlentities($_POST['email']);
        $telephone = htmlentities($_POST['telephone']);
        $message = htmlentities($_POST['message']);

        // Préparer et exécuter la requête d'insertion
        $stmt = $pdo->prepare("INSERT INTO contacts (name, prenom, email, telephone, message) VALUES (:name, :prenom, :email, :telephone, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':message', $message);

        if ($stmt->execute()) {
            echo "Votre message a été envoyé avec succès.";
        } else {
            echo "Une erreur est survenue lors de l'envoi de votre message. Veuillez réessayer plus tard.";
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
        <h1>Contactez-nous</h1>
        <form action="contact.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" required>
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
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div> 
</main>
<?php include 'includes/footer.php'; ?>