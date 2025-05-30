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
    <style>
    .centres-container {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      margin-bottom: 2rem;
    }
    .centre-card {
      flex: 1 1 calc(50% - 30px);
      background: #f8f9fa;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.08);
    }
    .map-container {
      height: 250px;
      border-radius: 10px;
      overflow: hidden;
      margin-bottom: 15px;
    }
  </style>

  <div class="centres-container">
    <?php foreach ($centres as $index => $c): ?>
      <div class="centre-card">
        <div id="map-<?= $index ?>" class="map-container"></div>

        <h5><?= htmlspecialchars($c['nom']) ?></h5>
        <p><?= htmlspecialchars($c['adresse']) ?></p>
        <p><strong>Quantité disponible : <?= (int)$c['nbr_poche'] ?></strong></p>

        <a href="https://www.openstreetmap.org/directions?from=&to=<?= htmlspecialchars($c['latitude']) ?>,<?= htmlspecialchars($c['longitude']) ?>" 
          class="btn btn-sm btn-outline-primary mb-2" target="_blank">
          Itinéraire
        </a>

        <form action="/sang/public/recherche/paiement" method="get" class="d-flex gap-2">
          <input type="hidden" name="ref_sang" value="<?= htmlspecialchars($c['ref_sang']) ?>">
          <input type="hidden" name="num_centre" value="<?= htmlspecialchars($c['num_centre']) ?>">
          <input type="number" name="qte" value="1" min="1" max="<?= $c['nbr_poche'] ?>" class="form-control form-control-sm w-25" required>
          <button type="submit" class="btn btn-sm btn-success">Réserver</button>
        </form>
      </div>
    <?php endforeach; ?>
  </div>


    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script>
    const centres = <?= json_encode($centres) ?>;

    centres.forEach((centre, index) => {
      const map = L.map('map-' + index).setView([centre.latitude, centre.longitude], 13);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
      }).addTo(map);

      const marker = L.marker([centre.latitude, centre.longitude]).addTo(map);
      marker.bindPopup(`<strong>${centre.nom}</strong><br>${centre.adresse}`).openPopup();
    });
  </script>


  <?php endif; ?>

  <a href="/sang/public/recherche" class="btn btn-secondary mt-3">⬅ Retour</a>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>