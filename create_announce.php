<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <title>Créer une annonce</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">Mon Agence Immobilière</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="create_announce.php">Créer une annonce</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Rechercher" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Rechercher</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Créer une annonce</h1>
        <form id="announceForm" action="submit_announce.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="ann_offre" class="form-label">Offre</label>
                <input type="text" class="form-control" id="ann_offre" name="ann_offre" required>
            </div>
            <div class="mb-3">
                <label for="ann_type" class="form-label">Type</label>
                <input type="text" class="form-control" id="ann_type" name="ann_type" required>
            </div>
            <div class="mb-3">
                <label for="ann_piece" class="form-label">Nombre de pièces</label>
                <input type="number" class="form-control" id="ann_piece" name="ann_piece" required>
            </div>
            <div class="mb-3">
                <label for="ann_ref" class="form-label">Référence</label>
                <input type="text" class="form-control" id="ann_ref" name="ann_ref" required>
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
                <input type="text" class="form-control" id="ann_diag_energie" name="ann_diag_energie" required>
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
                <label for="type_offre_id" class="form-label">ID Type d'offre</label>
                <input type="number" class="form-control" id="type_offre_id" name="type_offre_id" required>
            </div>
            <div class="mb-3">
                <label for="type_bien_id" class="form-label">ID Type de bien</label>
                <input type="number" class="form-control" id="type_bien_id" name="type_bien_id" required>
            </div>
            <div class="mb-3">
                <label for="utilisateur_id" class="form-label">ID Utilisateur</label>
                <input type="number" class="form-control" id="utilisateur_id" name="utilisateur_id" required>
            </div>
            <div class="mb-3">
                <label for="photos" class="form-label">Photos</label>
                <input type="file" class="form-control" id="photos" name="photos[]" multiple required>
            </div>
            <button type="submit" class="btn btn-primary">Créer l'annonce</button>
        </form>
    </div>



    <script src="script/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></script>
</body>
</html>