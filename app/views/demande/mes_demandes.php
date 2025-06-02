
<?php
$pageTitle = 'Mes demandes';
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
        text-align: center;
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

    .badge-success {
        background-color: #28a745;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
    }

    .badge-warning {
        background-color: #ffc107;
        color: #333;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
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

    .pagination .page-link {
        border-radius: 0.5rem;
        color: var(--blue-text);
    }
    .pagination .page-item.active .page-link {
        background-color: var(--red-blood);
        color: #fff;
        border-color: var(--red-blood);
    }

</style>

<div class="container">
    <div class="card-demandes">
        <h2 class="section-title">Mes demandes de sang</h2>

        <?php if (count($demandes) > 0): ?>
            <div class="table-wrapper">
                <table class="demande-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Libellé</th>
                            <th>Groupe sanguin</th>
                            <th>Centre</th>
                            <th>Quantité</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($demandes as $d): ?>
                            <tr>
                                <td><?= htmlspecialchars($d['date_demande']) ?></td>
                                <td><?= htmlspecialchars($d['libelle']) ?></td>
                                <td><?= htmlspecialchars($d['ref_sang']) ?></td>
                                <td><?= htmlspecialchars($d['centre']) ?></td>
                                <td><?= htmlspecialchars($d['qte']) ?></td>
                                <td>
                                    <?php
                                        $etat = $d['statut'] ?? 'en attente';
                                        $badgeClass = $etat === 'validée' ? 'badge-success' : 'badge-warning';
                                        $label = $etat === 'validée' ? 'Validée' : 'En attente';
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= $label ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert-info">Aucune demande effectuée pour l'instant.</div>
        <?php endif; ?>

        <?php if ($pages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page - 1 ?>">« Précédent</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page + 1 ?>">Suivant »</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>

        <div class="text-center">
            <a href="/sang/public/home" class="btn-return">Retour</a>
        </div>
    </div>
</div>

<?php include '../app/views/partials/footer.php'; ?>
