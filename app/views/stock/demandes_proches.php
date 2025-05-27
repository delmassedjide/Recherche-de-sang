
<body class="container py-5">
   
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <h2>Demandes proches de ce centre</h2>

    <?php if (count($demandes) > 0): ?>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Libellé</th>
                    <th>Demandeur</th>
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
                        <td><?= htmlspecialchars($d['nom']) . ' ' . htmlspecialchars($d['prenom']) ?></td>
                        <td><?= htmlspecialchars($d['ref_sang']) ?></td>
                        <td><?= htmlspecialchars($d['qte']) ?></td>
                        <td>
                            <?php if (isset($d['statut']) && $d['statut'] === 'en attente'): ?>
                                <a href="/sang/public/demande/valider/<?= $d['id_demande'] ?>" 
                                   class="btn btn-sm btn-success"
                                   onclick="return confirm('Confirmer le retrait ?')">Valider</a>
                            <?php else: ?>
                                <span class="badge bg-success">Validée</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-muted mt-4">Aucune demande pertinente trouvée pour votre centre.</p>
    <?php endif; ?>

    <a href="/sang/public/stock/gerer" class="btn btn-secondary mt-4">Retour</a>
</body>