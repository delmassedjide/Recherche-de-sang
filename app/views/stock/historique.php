
<body class="container py-5">

    <h2>📦 Historique des demandes validées</h2>

    <?php if (count($demandes) > 0): ?>
        <table class="table table-bordered mt-4">
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
    <?php else: ?>
        <p class="text-muted">Aucune demande validée par ce centre pour le moment.</p>
    <?php endif; ?>

    <a href="/sang/public/stock/gerer" class="btn btn-secondary mt-3">Retour</a>

</body>