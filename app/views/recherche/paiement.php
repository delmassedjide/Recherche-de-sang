<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réserver du sang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.fedapay.com/checkout.js?v=1.1.7"></script>
</head>
<body class="container mt-5">
    <h2 class="mb-4 text-danger">🩸 Réserver du sang</h2>

    <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" id="email" required>
    </div>

    <div class="form-group">
        <label>Nombre de poches</label>
        <input type="number" class="form-control" id="quantite" required min="1">
    </div>

    <button class="btn btn-success mt-3" id="pay-btn">💳 Procéder au paiement</button>

    <a href="/sang/public/recherche" class="btn btn-secondary mt-3">⬅ Retour</a>

    <script type="text/javascript">
        document.getElementById("pay-btn").addEventListener("click", function () {
            const email = document.getElementById("email").value;
            const quantite = parseInt(document.getElementById("quantite").value);

            if (!email || !quantite) {
                alert("Veuillez remplir tous les champs.");
                return;
            }

            FedaPay.init("#pay-btn", {
                public_key: "pk_sandbox_lZuEIOrTtckmYWKEtck0T0kJ",
                transaction: {
                    amount: quantite * 1000,
                    description: "Réservation de sang"
                },
                customer: {
                    email: email,
                    firstname: "Client",
                    lastname: "GBS"
                },
                onComplete: function (response) {
                    if (response.transaction && response.transaction.status === "approved") {
                        alert("✅ Paiement effectué avec succès !");
                        window.location.href = "/sang/public/recherche/success";
                    } else {
                        alert("❌ Le paiement a échoué ou a été annulé.");
                    }
                }
            });
        });
    </script>
</body>
</html>