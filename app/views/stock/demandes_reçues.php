
<body class="container py-5">

<div class="container py-5">
    <h2 class="mb-4">📥 Demandes de sang en attente</h2>

    <?php if (empty($demandes)): ?>
        <div class="alert alert-info">Aucune demande en attente pour votre centre.</div>
    <?php else: ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Demandeur</th>
                    <th>Groupe sanguin</th>
                    <th>Quantité</th>
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
                        <td>
                            <a href="/sang/public/stock/validerDemande/<?= $demande['id_demande'] ?>" class="btn btn-success btn-sm" onclick="return confirm('Valider cette demande ?')">
                                ✅ Valider
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>