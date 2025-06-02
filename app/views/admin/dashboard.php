<?php
$pageTitle = "Dashboard Admin";
include '../app/views/partials/header.php';
require_once '../app/models/Stocks.php';

$stocksModel = new Stocks();

// Statistiques dynamiques
$nb_centres = count($stocksModel->getCentres());
$groupes = [
    'A' => $stocksModel->sumPochesByGroupPrefix('A'),
    'B' => $stocksModel->sumPochesByGroupPrefix('B'),
    'O' => $stocksModel->sumPochesByGroupPrefix('O'),
    'AB' => $stocksModel->sumPochesByGroupPrefix('AB'),
];
$total_poches = $stocksModel->countTotal();
?>

<style>
    .sidebar {
        width: 250px;
        background-color: #fff;
        min-height: 100vh;
        border-right: 1px solid #ddd;
        padding-top: 30px;
    }
    .sidebar .nav-link.active {
        background-color: #e9f1ff;
        font-weight: bold;
        color: #007bff;
    }
    .profile-img {
        width: 80px;
        border-radius: 50%;
    }
    .stat-card {
        border-radius: 8px;
        padding: 30px 20px;
        color: white;
        text-align: center;
        font-size: 20px;
    }
    .bg-green { background-color: #28a745; }
    .bg-orange { background-color: #ffc107; color: #333 !important; }
    .bg-darkblue { background-color: #007bff; }
    .bg-red { background-color: #dc3545; }
    .bg-purple { background-color: #6f42c1; }
    .bg-cyan { background-color: #17a2b8; }
</style>

<div class="d-flex" style="display:flex">
    <!-- Sidebar admin stylisé -->
<div class="d-flex flex-column align-items-center bg-white shadow-sm p-4" style="width: 400px; min-height: 75vh; border-right: 1px solid #eee; margin-left:-140px; border-radius: 8px;">
    <div class="text-center mb-4">
        <img src="/sang/public/img/3.jpg" class="rounded-circle shadow" width="100" alt="Admin">
        <h5 class="mt-2 fw-bold">Admin</h5>
    </div>
    <div class="list-group w-100">
        <a href="/sang/public/home" class="list-group-item list-group-item-action py-3 <?= $current === '/sang/public/home' ? 'active bg-success text-white' : '' ?>">
            <i class="fas fa-chart-line me-2"></i> Dashboard
        </a>
        <a href="/sang/public/user/profil" class="list-group-item list-group-item-action py-3">
            <i class="fas fa-id-badge me-2"></i> Mon profil
        </a>
        <a href="/sang/public/admin/utilisateurs" class="list-group-item list-group-item-action py-3">
            <i class="fas fa-hospital me-2"></i> Liste des centres
        </a>
        <!-- <a href="/sang/public/user/changerMotDePasse" class="list-group-item list-group-item-action py-3">
            <i class="fas fa-lock me-2"></i> Changer le mot de passe
        </a> -->
        <a href="/sang/public/user/logout" class="list-group-item list-group-item-action py-3 text-danger">
            <i class="fas fa-power-off me-2"></i> Déconnexion
        </a>
    </div>
</div>
    <div class="container-fluid mt-5 px-4 bg-white shadow-sm p-4" style="border-right: 1px solid #eee; margin-left: 50px;border-radius: 8px;">
        <h2 class="mb-4">Statistiques</h2>
        <div class="row g-4">
            <div class="col-md-4"><div class="stat-card bg-green"><div><?= $nb_centres ?></div><div>Centres</div></div></div>
            <div class="col-md-4"><div class="stat-card bg-orange"><div><?= $groupes['A'] ?></div><div>Poches de Groupe A

            </div>
            </div>
            </div>
            <div class="col-md-4"><div class="stat-card bg-darkblue"><div><?= $groupes['B'] ?></div><div>Poches de Groupe B</div></div></div>
            <div class="col-md-4"><div class="stat-card bg-red"><div><?= $total_poches ?></div><div>Total poches disponibles</div></div></div>
            <div class="col-md-4"><div class="stat-card bg-purple"><div><?= $groupes['O'] ?></div><div>Poches de Groupe O</div></div></div>
            <div class="col-md-4"><div class="stat-card bg-cyan"><div><?= $groupes['AB'] ?></div><div>Poches de Groupe AB</div></div></div>
        </div>
    </div>
</div>

<?php include '../app/views/partials/footer.php'; ?>