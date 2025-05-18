
    <?php $pageTitle = "Dashboard GBS"; include __DIR__. '/../partials/header.php'; ?>
    <h2>📋 Mes demandes de sang</h2>

    <?php if (count($demandes) > 0): ?>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Libellé</th>
                    <th>Groupe sanguin</th>
                    <th>Quantité</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demandes as $d): ?>
                    <tr>
                        <td><?= htmlspecialchars($d['date_demande']) ?></td>
                        <td><?= htmlspecialchars($d['libelle']) ?></td>
                        <td><?= htmlspecialchars($d['ref_sang']) ?></td>
                        <td><?= htmlspecialchars($d['qte']) ?></td>
                        <td>
                            <a href="/sang/public/demande/annuler/<?= $d['id_demande'] ?>" 
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Confirmer l\'annulation ?')">Annuler</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>
        <p class="text-muted mt-4">Aucune demande effectuée pour l’instant.</p>
    <?php endif; ?>


    <?php if ($pages > 1): ?>
    <nav>
        <ul class="pagination mt-4">
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


    <a href="/sang/public/home" class="btn btn-secondary mt-3">Retour au tableau de bord</a>
    <?php include __DIR__. '/../partials/footer.php'; ?>
