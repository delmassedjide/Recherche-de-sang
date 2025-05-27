<?php
// Sécurité et préparation des données
if (session_status() === PHP_SESSION_NONE) session_start();
$pageTitle = "Paiement via FedaPay";

// 🔁 Données transmises
$ref_sang = $_GET['ref_sang'] ?? null;
$num_centre = $_GET['num_centre'] ?? null;
$qte = $_GET['qte'] ?? null;

if (!$ref_sang || !$num_centre || !$qte) {
    echo "<div class='alert alert-danger'>Erreur : Données manquantes dans l'URL.</div>";
    exit;
}
$montant = $qte * 8000;

// URL de callback après paiement
$callback = "http://localhost/sang/public/recherche/confirmer?ref_sang=" . urlencode($ref_sang) .
            "&num_centre=" . urlencode($num_centre) .
            "&qte=" . urlencode($qte) .
            "&montant=" . urlencode($montant);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.fedapay.com/checkout.js?v=1.1.7"></script>
</head>
<body class="container mt-5">
    <h2 class="mb-4 text-danger">🩸 Réserver du sang</h2>

        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" id="email" required>
        </div>

        <input type="hidden" name="ref_sang" value="<?= htmlspecialchars($ref_sang) ?>">
        <input type="hidden" name="num_centre" value="<?= htmlspecialchars($num_centre) ?>">
        <input type="hidden" name="qte" value="<?= htmlspecialchars($qte) ?>">

        <button type="submit" class="btn btn-success mt-3" id="pay-btn">Procéder au paiement</button>

        <a href="/sang/public/recherche" class="btn btn-secondary mt-3">⬅ Retour</a>

    <script>
        document.getElementById("pay-btn").addEventListener("click", function () {
            const email = document.getElementById("email").value;

            if (!email) {
                alert("Veuillez saisir un email.");
                return;
            }

            FedaPay.init("#pay-btn", {
                public_key: "pk_sandbox_lZuEIOrTtckmYWKEtck0T0kJ", // clé sandbox
                transaction: {
                    amount: <?= $montant ?>,
                    description: "Réservation de sang"
                },
                customer: {
                    email: email
                },
                onComplete: function (response) {
                    if (response.transaction && response.transaction.status === "approved") {
                        // Redirection avec transaction ID
                        window.location.href = "<?= $callback ?>&transaction_id=" + response.transaction.id;
                    } else {
                        alert(" Paiement annulé ou échoué.");
                    }
                }
            });
        });
    </script>
</body>
</html>