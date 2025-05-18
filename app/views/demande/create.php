
    <?php $pageTitle = "Dashboard GBS"; include __DIR__. '/../partials/header.php'; ?>
    <h2>Faire une demande de sang</h2>

    <form method="POST" action="/sang/public/demande/store" class="mt-4">

        <div class="mb-3">
            <label>Libellé</label>
            <input type="text" name="libelle" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Groupe sanguin</label>
            <!-- DEBUG TEMP -->
            <!-- <pre><?php print_r($groupes); ?></pre> -->
             <select name="ref_sang" class="form-select" required>
                <option value="">Sélectionnez un groupe</option>
                <?php foreach ($groupes as $g): ?>
                    <option value="<?= $g['ref_sang'] ?>"><?= $g['ref_sang'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Quantité (poches)</label>
            <input type="number" name="qte" class="form-control" min="1" required>
        </div>

        <button class="btn btn-primary">Soumettre la demande</button>
        <a href="/sang/public/home" class="btn btn-secondary">Annuler</a>
    </form>
    <?php include __DIR__. '/../partials/footer.php'; ?>
