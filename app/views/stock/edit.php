<?php include '../app/views/partials/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier un stock</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

  <h2 class="mb-4">Modifier un stock</h2>

  <?php if (isset($stocks) && $stocks): ?>
    <form method="POST" action="/sang/public/stock/update/<?= $stocks['id'] ?>" class="row g-4">
      <div class="col-md-6">
        <label class="form-label">Centre</label>
        <select class="form-select" disabled>
          <?php foreach ($centres as $c): ?>
            <option value="<?= $c['num_centre'] ?>" <?= $c['num_centre'] == $stocks['num_centre'] ? 'selected' : '' ?>>
              <?= $c['nom_centre'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Groupe sanguin</label>
        <select class="form-select" disabled>
          <?php foreach ($groupes as $g): ?>
            <option value="<?= $g['ref_sang'] ?>" <?= $g['ref_sang'] == $stocks['ref_sang'] ? 'selected' : '' ?>>
              <?= $g['ref_sang'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Quantité de poches</label>
        <input type="number" name="nbr_poche" value="<?= $stocks['nbr_poche'] ?>" class="form-control" min="0" required>
      </div>

      <div class="col-12">
        <button class="btn btn-success">Enregistrer</button>
        <a href="/sang/public/stock/gerer" class="btn btn-secondary">Retour</a>
      </div>
    </form>
  <?php else: ?>
    <div class="alert alert-danger">Erreur : stock introuvable.</div>
    <a href="/sang/public/stock/gerer" class="btn btn-secondary">⬅ Retour</a>
  <?php endif; ?>

</body>
</html>
<?php include '../app/views/partials/footer.php'; ?>
