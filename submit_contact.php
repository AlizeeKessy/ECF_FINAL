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

        // Valider les données (vous pouvez ajouter plus de validations si nécessaire)
        if (!empty($name) && !empty($prenom) && !empty($email) && !empty($telephone) && !empty($message)) {
            // Configuration de la base de données
            $host = '127.0.0.1';
            $dbname = 'afpa_wazaa_immo';
            $username = 'root';
            $password = '';

            try {
                // Connexion à la base de données
                $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Préparer et exécuter la requête d'insertion
                $stmt = $pdo->prepare("INSERT INTO contacts (name, prenom, email, telephone, message) VALUES (:name, :prenom, :email, :telephone, :message)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':prenom', $prenom);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':telephone', $telephone);
                $stmt->bindParam(':message', $message);

                if ($stmt->execute()) {
                    echo "Merci de nous avoir contactés, $prenom. Nous vous répondrons sous peu.";
                } else {
                    throw new Exception("Une erreur est survenue lors de l'enregistrement de votre message. Veuillez réessayer plus tard.");
                }
            } catch (PDOException $e) {
                echo "Erreur de connexion : " . $e->getMessage();
            } catch (Exception $e) {
                echo "Erreur : " . $e->getMessage();
            }
        } else {
            echo "Veuillez remplir tous les champs du formulaire.";
        }
    } else {
        echo "Tous les champs ne sont pas définis.";
    }
} else {
    echo "Méthode de requête non valide.";
}
?>