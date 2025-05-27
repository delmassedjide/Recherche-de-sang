<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../app/views/partials/header.php';
require_once '../app/models/Stocks.php';
require_once '../app/models/Demande.php';
$demandesModel = new Demande();
$nbAttente = $demandesModel->countDemandesEnAttente($_SESSION['user']['num_centre']);


$stocksModel = new Stocks();
$groupes = [
    'A+' => $stocksModel->countByGroupPrefix('A+'),
    'A-' => $stocksModel->countByGroupPrefix('A-'),
    'B+' => $stocksModel->countByGroupPrefix('B+'),
    'B-' => $stocksModel->countByGroupPrefix('B-'),
    'O+' => $stocksModel->countByGroupPrefix('O+'),
    'O-' => $stocksModel->countByGroupPrefix('O-'),
    'AB+' => $stocksModel->countByGroupPrefix('AB+'),
    'AB-' => $stocksModel->countByGroupPrefix('AB-'),
];
$total = $stocksModel->countTotal();
$user = $_SESSION['user'] ?? null;
$current = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard GBS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            width: 100;
            border-radius: 50%;
        }
        .stat-card {
        border-radius: 10px;
        color: white;
        padding: 25px 20px;
        text-align: center;
        font-weight: bold;
        font-size: 18px;
        }
        .bg-a-plus { background-color: #28a745; }
        .bg-a-moins { background-color: #dc3545; }
        .bg-b-plus { background-color: #ffc107; color: #000; } /* Corrigé */
        .bg-b-moins { background-color: #007bff; }
        .bg-o-plus { background-color: #343a40; }
        .bg-o-moins { background-color: #5cd65c; }
        .bg-ab-plus { background-color: #6c5ce7; }
        .bg-ab-moins { background-color: #9b59b6; }
        .bg-total { background-color: #e74c3c; }
    </style>
</head>
<body>
<div class="d-flex">
    <div class="d-flex flex-column align-items-center bg-white shadow-sm p-4" style="width: 400px; min-height: 75vh; border-right: 1px solid #eee; margin-left:-140px; border-radius: 8px;">
        <div class="text-center mb-4">
            <img src="/sang/public/img/4.jpg" class="rounded-circle shadow" width="100" alt="GBS">
            <h5 class="mt-2 fw-bold">Gestionnaire</h5>
        </div>
        <div class="list-group w-100">
            <a href="/sang/public/home" class="list-group-item list-group-item-action py-3 <?= $current === '/sang/public/home' ? 'active bg-success text-white' : '' ?>">
                <i class="fas fa-chart-line me-2"></i> Dashboard
            </a>
            <a href="/sang/public/user/profil" class="list-group-item list-group-item-action py-3">
                <i class="fas fa-id-badge me-2"></i> Profil du centre
            </a>
            <a href="/sang/public/stock/demandesRecues" class="list-group-item list-group-item-action py-3 d-flex       justify-content-between align-items-center">
                <span><i class="fas fa-id-badge me-2"></i> Demandes reçues</span>
                <?php if ($nbAttente > 0): ?>
                    <span class="badge bg-danger rounded-pill"><?= $nbAttente ?></span>
                <?php endif; ?>
            </a>
            <a href="/sang/public/stock/historique" class="list-group-item list-group-item-action py-3">
                <i class="fas fa-id-badge me-2"></i> Historique
            </a>
            <a href="/sang/public/stock/gerer" class="list-group-item list-group-item-action py-3">
                <i class="fas fa-vial me-2"></i> Mise à jour du stock
            </a>
            <!-- <a href="/sang/public/user/changerMotDePasse" class="list-group-item list-group-item-action py-3">
                <i class="fas fa-lock me-2"></i> Changer le mot de passe
            </a> -->
            <a href="/sang/public/user/logout" class="list-group-item list-group-item-action py-3 text-danger">
                <i class="fas fa-power-off me-2"></i> Déconnexion
            </a>
        </div>
    </div>

    <div class="container-fluid mt-5 px-4 bg-white shadow-sm p-3" style="border-right: 1px solid #eee; margin-left: 50px;border-radius: 8px;">
      <h2 class="mb-4">Informations De Base</h2>
      <?php
        $nbValidations = $demandesModel->countDemandesValideesRecentes($_SESSION['user']['num_centre']);
        ?>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="alert alert-danger d-flex align-items-center justify-content-between">
                    <span><i class="fas fa-envelope-open-text me-2"></i><strong>Demandes en attente :</strong></span>
                    <span class="badge bg-danger rounded-pill fs-5"><?= $nbAttente ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert alert-success d-flex align-items-center justify-content-between">
                    <span><i class="fas fa-check-circle me-2"></i><strong>Demandes validées (24h) :</strong></span>
                    <span class="badge bg-success rounded-pill fs-5"><?= $nbValidations ?></span>
                </div>
            </div>
        </div>
      <div class="row g-4">
          <div class="col-md-3"><div class="stat-card bg-a-plus"><?= $groupes['A+'] ?><br>Poche du Groupe A+</div></div>
          <div class="col-md-3"><div class="stat-card bg-a-moins"><?= $groupes['A-'] ?><br>Poche du Groupe A-</div></div>
          <div class="col-md-3"><div class="stat-card bg-b-plus"><?= $groupes['B+'] ?><br>Poche du Groupe B+</div></div>
          <div class="col-md-3"><div class="stat-card bg-b-moins"><?= $groupes['B-'] ?><br>Poche du Groupe B-</div></div>

          <div class="col-md-3"><div class="stat-card bg-o-plus"><?= $groupes['O+'] ?><br>Poche du Groupe O+</div></div>
          <div class="col-md-3"><div class="stat-card bg-o-moins"><?= $groupes['O-'] ?><br>Poche du Groupe O-</div></div>
          <div class="col-md-3"><div class="stat-card bg-ab-plus"><?= $groupes['AB+'] ?><br>Poche du Groupe AB+</div></div>
          <div class="col-md-3"><div class="stat-card bg-ab-moins"><?= $groupes['AB-'] ?><br>Poche du Groupe AB-</div></div>

          <div class="col-md-12"><div class="stat-card bg-total"><?= $total ?><br>Total Poche de sang disponible</div></div>
      </div>
    </div>
    </div>
</div>
</body>
</html>
<?php include '../app/views/partials/footer.php'; ?>