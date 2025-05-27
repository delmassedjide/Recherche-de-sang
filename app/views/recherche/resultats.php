<?php
$groupe = $_GET['ref_sang'] ?? $_POST['ref_sang'] ?? '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Résultats - Groupe <?= htmlspecialchars($groupe) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>
<body class="container py-5">

    <h2 class="mb-4">Centres disponibles pour le groupe <?= htmlspecialchars($_POST['ref_sang']) ?></h2>

  <?php if (empty($centres)): ?>
    <div class="alert alert-warning">Aucun centre trouvé pour ce groupe sanguin.</div>
  <?php else: ?>

    <!-- Carte -->
    <div id="map" style="height: 400px;" class="mb-4 rounded shadow-sm border"></div>

    <ul class="list-group mb-4">
  <?php foreach ($centres as $c): ?>
    <li class="list-group-item">
      <strong><?= htmlspecialchars($c['nom']) ?></strong><br>
      <?= htmlspecialchars($c['adresse']) ?><br>
      Quantité disponible : <?= (int)$c['nbr_poche'] ?><br>
      <a 
        href="https://www.openstreetmap.org/directions?from=&to=<?= htmlspecialchars($c['latitude']) ?>,<?= htmlspecialchars($c['longitude']) ?>" 
        class="btn btn-sm btn-outline-primary mt-2" 
        target="_blank">
        Itinéraire
      </a>
      
      <form action="/sang/public/recherche/paiement" method="get" class="d-flex gap-2 mt-2">
        <input type="hidden" name="ref_sang" value="<?= htmlspecialchars($c['ref_sang']) ?>">
        <input type="hidden" name="num_centre" value="<?= htmlspecialchars($c['num_centre']) ?>">

        <input type="number" name="qte" value="1" min="1" max="<?= $c['nbr_poche'] ?>" class="form-control form-control-sm w-25" required>
        <button type="submit" class="btn btn-sm btn-success">Réserver</button>
      </form>

    </li>
  <?php endforeach; ?>
</ul>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
      const map = L.map('map').setView([<?= $centres[0]['latitude'] ?>, <?= $centres[0]['longitude'] ?>], 13);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
      }).addTo(map);

      const centres = <?= json_encode($centres) ?>;
      centres.forEach(c => {
        const marker = L.marker([c.latitude, c.longitude]).addTo(map);
        marker.bindPopup(
        "<strong>" + c.nom + "</strong><br>" +
        c.adresse + "<br>" +
        "<a href='https://www.openstreetmap.org/directions?from=&to=" + c.latitude + "," + c.longitude + "' target='_blank'>Itinéraire</a>"
);
      });
    </script>

  <?php endif; ?>

  <a href="/sang/public/recherche" class="btn btn-secondary mt-3">⬅ Retour</a>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>