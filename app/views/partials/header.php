<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$user = $_SESSION['user'] ?? null;
$current = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?? 'Plateforme de sang' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- font-awesome CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .nav-link.active {
            font-weight: bold;
            color: #0d6efd !important;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
    <a class="navbar-brand fw-bold" href="/sang/public/home">🩸 Plateforme</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            <?php if ($user): ?>
                <?php if ($user['role'] === 'demandeur'): ?>
                    <li class="nav-item"><a class="nav-link <?= str_contains($current, '/demande/create') ? 'active' : '' ?>" href="/sang/public/demande/create">Nouvelle demande</a></li>
                    <li class="nav-item"><a class="nav-link <?= str_contains($current, '/demande/mesDemandes') ? 'active' : '' ?>" href="/sang/public/demande/mesDemandes">Mes demandes</a></li>
                <?php elseif ($user['role'] === 'gbs'): ?>
                    <!-- <li class="nav-item"><a class="nav-link <?= str_contains($current, '/stock/gerer') ? 'active' : '' ?>" href="/sang/public/stock/gerer">Gestion des stocks</a></li>
                    <li class="nav-item"><a class="nav-link <?= str_contains($current, '/stock/demandesProches') ? 'active' : '' ?>" href="/sang/public/stock/demandesProches">Demandes proches</a></li>
                    <li class="nav-item"><a class="nav-link <?= str_contains($current, '/stock/historique') ? 'active' : '' ?>" href="/sang/public/stock/historique">Historique</a></li> -->
                <?php elseif ($user['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= str_contains($current, '/admin/dashboard') ? 'active' : '' ?>" href="/sang/public/home">Dashboard</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link <?= str_contains($current, '/admin/utilisateurs') ? 'active' : '' ?>" href="/sang/public/admin/utilisateurs">Utilisateurs</a>
                        </li> -->
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link <?= str_contains($current, '/profil') ? 'active' : '' ?>" href="/sang/public/user/profil">Mon profil</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="/sang/public/user/logout">Se déconnecter</a></li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="/sang/public/user/login">Connexion</a></li>
                <li class="nav-item"><a class="nav-link" href="/sang/public/user/register">Inscription</a></li>
            <?php endif; ?>

        </ul>

        <?php if ($user): ?>
            <span class="navbar-text">
                Bonjour, <strong><?= htmlspecialchars($user['prenom']) ?></strong> (<?=htmlspecialchars( $user['role']) ?>)
            </span>
        <?php endif; ?>
    </div>
</nav>

<div class="container mt-4">