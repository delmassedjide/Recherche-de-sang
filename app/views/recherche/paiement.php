<?php
// Sécurité et préparation des données
if (session_status() === PHP_SESSION_NONE) session_start();
$pageTitle = "Paiement via FedaPay";

//  Données transmises
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

    <style>
    body {
        background-color: #f4f8fb;
        font-family: 'Segoe UI', sans-serif;
        padding-top: 60px;
    }

    .container {
        max-width: 500px;
        margin: auto;
        background: #fff;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    h2 {
        color: #e60023;
        font-weight: bold;
        margin-bottom: 2rem;
        text-align: center;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border-radius: 0.5rem;
        padding: 0.75rem;
        font-size: 16px;
    }

    .btn {
        font-weight: 600;
        font-size: 16px;
        border-radius: 0.5rem;
        padding: 10px 20px;
        width: 100%;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
        margin-top: 0.5rem;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }
</style>
</head>
<body class="container mt-5">
    <h2 class="mb-4 text-danger">Réserver du sang</h2>
        <div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" id="email" required>
            </div>
            
            <div class="form-group">
                <label>Prix unitaire (FCFA)</label>
                <input type="text" class="form-control" value="8000" readonly>
            </div>

            <div class="form-group">
                <label>Montant total (FCFA)</label>
                <input type="text" class="form-control" value="<?= $montant ?>" readonly>
            </div>

            <input type="hidden" name="ref_sang" value="<?= htmlspecialchars($ref_sang) ?>">
            <input type="hidden" name="num_centre" value="<?= htmlspecialchars($num_centre) ?>">
            <input type="hidden" name="qte" value="<?= htmlspecialchars($qte) ?>">

            <button type="submit" class="btn btn-success mt-3" id="pay-btn">Procéder au paiement</button>

            <a href="/sang/public/recherche" class="btn btn-secondary mt-3">Retour</a>
        </div>
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