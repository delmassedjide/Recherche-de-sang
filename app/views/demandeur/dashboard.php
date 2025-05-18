<?php
$pageTitle = "Dashboard Demandeur";
include '../app/views/partials/header.php';
?>
<section class="content-header">
    <div class="container-fluid mb-4">
        <h2>Bienvenue <?= htmlspecialchars($_SESSION['user']['prenom']) ?> (Demandeur)</h2>
    </div>
</section>

<section class="content">
    <div class="container">
        <div class="row">

            <!-- Carte recherche -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card text-white bg-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title">🔍 Recherche de sang</h5>
                        <p class="card-text">Lancer une nouvelle recherche de sang.</p>
                        <a href="/sang/public/recherche" class="btn btn-light">Rechercher</a>
                    </div>
                </div>
            </div>

            <!-- Carte mes demandes -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card text-white bg-success h-100">
                    <div class="card-body">
                        <h5 class="card-title">📋 Mes demandes</h5>
                        <p class="card-text">Consulter l'historique de vos demandes.</p>
                        <a href="/sang/public/demande/mesDemandes" class="btn btn-light">Voir mes demandes</a>
                    </div>
                </div>
            </div>

            <!-- Carte profil -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card text-white bg-secondary h-100">
                    <div class="card-body">
                        <h5 class="card-title">👤 Mon profil</h5>
                        <p class="card-text">Modifier vos informations personnelles.</p>
                        <a href="/sang/public/user/profil" class="btn btn-light">Voir mon profil</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<?php include '../app/views/partials/footer.php'; ?>