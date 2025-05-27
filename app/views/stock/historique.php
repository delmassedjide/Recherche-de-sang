<?php
$pageTitle = 'Historique des demandes';
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

    .card-historique {
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
        text-align: center;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .historique-table {
        width: 100%;
        border-collapse: collapse;
    }

    .historique-table thead th {
        background: var(--red-blood);
        color: #fff;
        padding: 1rem;
        text-align: center;
    }

    .historique-table thead th:first-child {
    border-top-left-radius: 1rem;
    }
    .historique-table thead th:last-child {
    border-top-right-radius: 1rem;
    }

    .historique-table tbody td {
        background: #fff;
        padding: 1rem;
        text-align: center;
        border-bottom: 1px solid #e3edf9;
        font-weight: 500;
    }

    .historique-table tbody tr:nth-child(even) {
        background: #f9fbff;
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

    .alert-info {
        background: #dbeeff;
        color: #004a70;
        padding: 1rem;
        text-align: center;
        border-radius: 0.75rem;
        font-weight: 500;
    }
</style>

<div class="container">

    <form method="GET" class="mb-4 d-flex justify-content-end align-items-center gap-3">
    <label for="periode" class="form-label mb-0"><strong>Filtrer par période :</strong></label>
    <select name="periode" id="periode" class="form-select w-auto">
        <option value="all" <?= (!isset($_GET['periode']) || $_GET['periode'] === 'all') ? 'selected' : '' ?>>Toutes</option>
        <option value="today" <?= ($_GET['periode'] ?? '') === 'today' ? 'selected' : '' ?>>Aujourd’hui</option>
        <option value="7days" <?= ($_GET['periode'] ?? '') === '7days' ? 'selected' : '' ?>>7 derniers jours</option>
        <option value="30days" <?= ($_GET['periode'] ?? '') === '30days' ? 'selected' : '' ?>>30 derniers jours</option>
    </select>
    <button type="submit" class="btn btn-sm btn-valider">Appliquer</button>
    </form>
    
    <div class="card-historique">
        <h2 class="section-title">Historique des demandes validées</h2>

        <?php if (count($demandes) > 0): ?>
            <div class="table-wrapper">
                <table class="historique-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Demandeur</th>
                            <th>Groupe sanguin</th>
                            <th>Quantité</th>
                            <th>Libellé</th>
                            <th>Date de validation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($demandes as $d): ?>
                            <tr>
                                <td><?= htmlspecialchars($d['date_demande']) ?></td>
                                <td><?= htmlspecialchars($d['nom'] . ' ' . $d['prenom']) ?></td>
                                <td><?= htmlspecialchars($d['ref_sang']) ?></td>
                                <td><?= htmlspecialchars($d['qte']) ?></td>
                                <td><?= htmlspecialchars($d['libelle']) ?></td>
                                <td><?= htmlspecialchars($d['date_validation']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert-info">Aucune demande validée par ce centre pour le moment.</div>
        <?php endif; ?>

        <div class="text-center">
            <a href="/sang/public/home" class="btn-return">Retour</a>
        </div>
    </div>
</div>

<?php include '../app/views/partials/footer.php'; ?>