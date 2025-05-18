<?php
$pageTitle = "Dashboard GBS";
include '../app/views/partials/header.php';
?>
    <h1 class="mb-4">Bienvenue, <?= htmlspecialchars($user['prenom']) ?> 👋</h1>
    
    <div class="alert alert-info">
        Vous êtes connecté en tant que <strong><?= htmlspecialchars($user['role']) ?></strong>
    </div>

    <div class="d-flex flex-column gap-2 mb-3">
        <a href="/demande/create" class="btn btn-primary">Faire une demande de sang</a>
        <a href="/demande/liste" class="btn btn-outline-secondary">Voir mes demandes</a>
        <!-- Tu pourras adapter les boutons selon le rôle ici -->
    </div>

    <a href="/user/logout" class="btn btn-danger">Se déconnecter</a>
<?php include '../app/views/partials/footer.php';?>