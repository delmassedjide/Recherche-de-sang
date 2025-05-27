
<body class="container py-5">

    <h2>Modifier un stock</h2>

    <form method="POST" action="/sang/public/stock/update/<?= $stock['id'] ?>" class="row g-3 mt-4">
        <div class="col-md-6">
            <label>Centre</label>
            <select class="form-select" disabled>
                <?php foreach ($centres as $c): ?>
                    <option value="<?= $c['num_centre'] ?>" <?= ($c['num_centre'] == $stock['num_centre']) ? 'selected' : '' ?>>
                        <?= $c['nom_centre'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label>Groupe sanguin</label>
            <select class="form-select" disabled>
                <?php foreach ($groupes as $g): ?>
                    <option value="<?= $g['ref_sang'] ?>" <?= ($g['ref_sang'] == $stock['ref_sang']) ? 'selected' : '' ?>>
                        <?= $g['ref_sang'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label>Quantité de poches</label>
            <input type="number" name="nbr_poche" value="<?= $stock['nbr_poche'] ?>" class="form-control" min="0" required>
        </div>

        <div class="col-12">
            <button class="btn btn-success">Enregistrer</button>
            <a href="/sang/public/stock/gerer" class="btn btn-secondary">Retour</a>
        </div>
    </form>
</body>