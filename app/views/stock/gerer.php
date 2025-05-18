<?php
// ============================================================================
//  Gestion des Stocks de Sang – UI v4 (hero fidelity)
//  Projet : Plateforme de recherche de banques de sang au Bénin
//  ============================================================================
$pageTitle = 'Gestion des Stocks';
include '../app/views/partials/header.php';
?>

<style>
    /* =====================================================================================
       PALETTE & VARIABLES
    ==================================================================================== */
    :root {
        --red-blood: #ef233c;
        --red-blood-dark: #d90429;
        --blue-text: #011627;
        --gray-bg: #ecf6ff; /* bleu très très clair */
        --teal-btn: #2ec4b6;
        --teal-btn-dark: #22b0a3;
        --radius-lg: 1.5rem;
    }

    /* =====================================================================================
       STRUCTURE GÉNÉRALE
    ==================================================================================== */
    body.page-stocks {
        background: var(--gray-bg);
        color: var(--blue-text);
        font-family: 'Inter', sans-serif;
    }

    h1, h2, h3, h4 {
        font-family: 'Raleway', sans-serif;
        font-weight: 700;
        color: var(--blue-text);
    }

    /* =====================================================================================
       HERO SECTION
    ==================================================================================== */
    .hero-stocks {
        position: relative;
        padding: 5rem 1rem 10rem; /* augmente la hauteur pour coller à la maquette */
        overflow: hidden;
        isolation: isolate;       /* pour gérer les pseudo‑éléments */
    }

    /* Réseau de lignes & points en fond */
    .hero-stocks::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400" viewBox="0 0 400 400" fill="none" stroke="%23c9e3ff" stroke-width="1"><path d="M0 50L400 50 M0 150L400 150 M0 250L400 250 M0 350L400 350 M50 0L50 400 M150 0L150 400 M250 0L250 400 M350 0L350 400" stroke-dasharray="4 8" stroke-linecap="round"/><circle cx="75" cy="75" r="2"/><circle cx="300" cy="120" r="2"/><circle cx="200" cy="320" r="2"/><circle cx="360" cy="260" r="2"/><circle cx="120" cy="280" r="2"/></svg>');
        background-repeat: repeat;
        opacity: 0.25;
        z-index: -3; /* derrière tout */
    }

    /* Disque rouge semi‑transparent */
    .hero-stocks::after {
        content: '';
        position: absolute;
        top: -180px;
        right: -220px;
        width: 760px;
        height: 760px;
        background: radial-gradient(circle at 60% 40%, rgba(255, 255, 255, 0.06) 0%, var(--red-blood) 100%);
        border-radius: 50%;
        z-index: -2;
    }

    /* Tube + goutte */
    .tube-wrapper {
        position: absolute;
        top: 120px;
        right: 180px;
        width: 160px;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .tube-wrapper svg { width: 100%; height: auto; }

    .droplet {
        position: absolute;
        top: 240px;
        right: 90px;
        width: 36px;
        height: 46px;
        background: var(--red-blood-dark);
        border-radius: 50% 50% 50% 0;
        transform: rotate(45deg);
    }

    /* =====================================================================================
       CARD "AJOUTER UN STOCK"
    ==================================================================================== */
    .card-add {
        background: #fff;
        border: none;
        border-radius: var(--radius-lg);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08);
        padding: 3rem 2rem 2.5rem;
        margin-top: -7.5rem; /* chevauche le hero */
    }

    .card-add .form-select,
    .card-add .form-control {
        border-radius: 0.75rem;
        border: 1px solid #d0dff1;
        height: 54px;
    }

    .card-add .btn-brand {
        height: 54px;
        font-weight: 600;
    }

    /* =====================================================================================
       TABLEAU STOCKS
    ==================================================================================== */
    .table-wrapper {
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.05);
    }

    table.stock-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .stock-table thead th {
        background: var(--red-blood);
        color: #fff;
        padding: 1rem 1.25rem;
        font-weight: 600;
        text-align: center;
    }

    .stock-table tbody td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        text-align: center;
        font-weight: 500;
        border-bottom: 1px solid #e3edf9;
    }

    .stock-table tbody tr:nth-child(even) { background: #ffffff; }
    .stock-table tbody tr:nth-child(odd)  { background: #f9fbff; }
    .stock-table tbody tr:last-child td { border-bottom: none; }

    .stock-table tbody td:first-child { text-align: left; font-weight: 600; }

    /* =====================================================================================
       BOUTONS
    ==================================================================================== */
    .btn-brand {
        background: var(--red-blood);
        border-color: var(--red-blood);
        color: #fff;
    }
    .btn-brand:hover { background: var(--red-blood-dark); border-color: var(--red-blood-dark); }

    .btn-teal { background: var(--teal-btn); border-color: var(--teal-btn); color: #fff; }
    .btn-teal:hover { background: var(--teal-btn-dark); border-color: var(--teal-btn-dark); }

    .btn-return {
        background: #7b8a99;
        border: none;
        color: #fff;
        padding: 0.75rem 2.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
    }
    .btn-return:hover { background: #6b7987; }
</style>

<!-- =======================================================================================
     HERO
======================================================================================= -->
<section class="hero-stocks container">
    <h2 class="display-5 mb-0">Gestion des<br>Stocks de Sang</h2>

    <!-- Tube à essai + goutte -->
    <div class="tube-wrapper">
        <svg viewBox="0 0 100 250" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="28" y="0" width="44" height="12" rx="3" fill="#293241"/>
            <rect x="28" y="12" width="44" height="200" rx="6" fill="#d9e6f2"/>
            <rect x="28" y="85" width="44" height="127" fill="var(--red-blood)"/>
            <circle cx="50" cy="48" r="4" fill="#afd8ff"/>
            <circle cx="50" cy="62" r="2" fill="#afd8ff"/>
            <circle cx="60" cy="110" r="3" fill="#ffd1d4"/>
        </svg>
    </div>
    <span class="droplet"></span>
</section>

<!-- =======================================================================================
     CARD "AJOUTER UN STOCK"
======================================================================================= -->
<div class="container">
    <div class="card-add">
        <h4 class="mb-4">Ajouter un Stock</h4>
        <form method="POST" action="/sang/public/stock/store" class="row g-3 align-items-end">
            <input type="hidden" name="num_centre" value="<?= $_SESSION['user']['num_centre'] ?>">

            <!-- Centre affiché en clair -->
            <div class="col-12">
                <p class="mb-0"><strong>Centre :</strong> <?= htmlspecialchars($_SESSION['user']['num_centre']) ?></p>
            </div>

            <!-- Groupe sanguin -->
            <div class="col-md-4">
                <select name="ref_sang" class="form-select" required>
                    <option value="">Groupe sanguin</option>
                    <?php foreach ($groupes as $g): ?>
                        <option value="<?= $g['ref_sang'] ?>"><?= $g['ref_sang'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Quantité -->
            <div class="col-md-4">
                <input type="number" name="nbr_poche" min="1" class="form-control" placeholder="Quantité" required>
            </div>

            <!-- Bouton ajouter -->
            <div class="col-md-4 d-grid">
                <button class="btn btn-brand">Ajouter</button>
            </div>
        </form>
    </div>

    <!-- ===================================================================================
         TABLEAU LISTE DES STOCKS
    =================================================================================== -->
    <h4 class="mt-5 mb-3">Liste des Stocks</h4>
    <div class="table-wrapper">
        <table class="stock-table">
            <thead>
                <tr>
                    <th>Centre</th>
                    <th>Groupe sanguin</th>
                    <th>Quantité</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stocks as $s): ?>
                    <tr>
                        <td style="text-align:left;white-space:normal;"><?= htmlspecialchars($s['nom_centre']) ?></td>
                        <td><?= htmlspecialchars($s['ref_sang']) ?></td>
                        <td><?= htmlspecialchars($s['nbr_poche']) ?></td>
                        <td>
                            <a href="/sang/public/stock/edit/<?= $s['id'] ?>" class="btn btn-sm btn-teal me-2">Modifier</a>
                            <a href="/sang/public/stock/delete/<?= $s['id'] ?>" class="btn btn-sm btn-brand" onclick="return confirm('Supprimer ce stock ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div><br>

    <!-- ===================================================================================
         BOUTON RETOUR
    =================================================================================== -->
    <div class="text-center mb-5">
        <a href="/sang/public/home" class="btn btn-return">Retour</a>
    </div>
</div>

<?php include '../app/views/partials/footer.php'; ?>