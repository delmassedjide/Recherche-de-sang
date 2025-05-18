<?php
$pageTitle = "Dashboard GBS";
include '../app/views/partials/header.php';
?>
<h2>Bienvenue <?= htmlspecialchars($_SESSION['user']['prenom']) ?> (Gestionnaire Banque de Sang)</h2>

<!-- <div class="d-grid gap-2 col-6 mx-auto">
    <a href="/sang/public/user/profil" class="btn btn-outline-info">⚙ Mon profil</a>
    <a href="/sang/public/stock/gerer" class="btn btn-warning">🧪 Gérer les stocks</a>
    <a href="/sang/public/stock/demandesProches" class="btn btn-outline-primary">📬 Demandes proches</a>
    <a href="/sang/public/stock/historique" class="btn btn-outline-info">📦 Historique des transferts</a>
</div>

<div class="mt-4">
    <a href="/sang/public/user/logout" class="btn btn-danger">🚪 Se déconnecter</a>
</div> -->
<?php include '../app/views/partials/footer.php';?>