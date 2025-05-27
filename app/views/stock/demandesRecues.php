<?php
$pageTitle = 'Demandes reçues';
include '../app/views/partials/header.php';
?>

<style>
    :root {
        --red-blood: #ef233c;
        --red-blood-dark: #d90429;
        --blue-text: #011627;
        --gray-bg: #ecf6ff;
        --radius-lg: 1.5rem;
    }

    body {
        background: var(--gray-bg);
        color: var(--blue-text);
        font-family: 'Inter', sans-serif;
    }

    .card-demandes {
        background: #fff;
        border-radius: var(--radius-lg);
        padding: 2.5rem;
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        margin: 3rem auto;
    }

    h2.section-title {
        font-family: 'Raleway', sans-serif;
        font-weight: bold;
        margin-bottom: 2rem;
        color: var(--blue-text);
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .demande-table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .demande-table thead th {
        background: var(--red-blood);
        color: #fff;
        padding: 1rem;
        text-align: center;
    }

    .demande-table thead th:first-child {
    border-top-left-radius: 1rem;
    }
    .demande-table thead th:last-child {
    border-top-right-radius: 1rem;
    }
    .demande-table tbody td {
        background: #fff;
        padding: 1rem;
        text-align: center;
        border-bottom: 1px solid #e3edf9;
        font-weight: 500;
    }

    .demande-table tbody tr:nth-child(even) {
        background: #f9fbff;
    }

    .btn-valider {
        background: var(--red-blood);
        color: #fff;
        border: none;
        padding: 0.5rem 1.2rem;
        border-radius: 0.5rem;
        font-weight: 600;
    }

    .btn-valider:hover {
        background: var(--red-blood-dark);
    }

    .btn-return {
        display: inline-block;
        margin-top: 2rem;
        background: #7b8a99;
        color: #fff;
        padding: 0.75rem 2.5rem;
        border-radius: 0.75rem;
        text-decoration: none;
        font-weight: 600;
    }

    .btn-return:hover {
        background: #6b7987;
    }

    .alert {
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-radius: 0.75rem;
        font-weight: 500;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>

<div class="container">
    <div class="card-demandes">
        <h2 class="section-title text-center">Demandes de sang en attente</h2>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (empty($demandes)): ?>
            <div class="alert alert-info text-center">Aucune demande en attente pour votre centre.</div>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="demande-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Demandeur</th>
                            <th>Groupe sanguin</th>
                            <th>Quantité</th>
                            <th>Libellé</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($demandes as $i => $demande): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($demande['date_demande']) ?></td>
                                <td><?= htmlspecialchars($demande['prenom']) . ' ' . htmlspecialchars($demande['nom']) ?></td>
                                <td><?= htmlspecialchars($demande['ref_sang']) ?></td>
                                <td><?= htmlspecialchars($demande['qte']) ?></td>
                                <td><?= htmlspecialchars($demande['libelle']) ?></td>
                                <td>
                                    <a href="/sang/public/stock/valider/<?= $demande['id_demande'] ?>"
                                       class="btn-valider"
                                       onclick="return confirm('Confirmer le retrait et valider cette demande ?')">
                                        Valider
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        <div class="text-center">
            <a href="/sang/public/home" class="btn-return">Retour</a>
        </div>
    </div>
</div>

<?php include '../app/views/partials/footer.php'; ?>