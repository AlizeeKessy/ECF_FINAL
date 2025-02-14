<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'includes/header.php'
?>
<main>
     <div class="container mt-4">
        <h1>Bienvenue sur notre site d'agence immobilière</h1>
        <p>Découvrez notre sélection de biens à vendre.</p>
        <div class="row">
            <!-- Exemple de carte de bien immobilier -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Image du bien">
                    <div class="card-body">
                        <h5 class="card-title">Titre du bien</h5>
                        <p class="card-text">Description courte du bien immobilier.</p>
                        <a href="announce.php?ann_id=55" class="btn btn-primary">Voir plus</a>
                    </div>
                </div>
            </div>
            <!-- Répétez les cartes pour chaque bien immobilier -->
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>