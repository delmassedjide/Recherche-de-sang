<?php
// Fichier : /app/views/recherche/kkiapay.php


$pageTitle = "Paiement via Kkiapay";
header("Content-Security-Policy: 
    default-src 'self'; 
    script-src 'self' https://cdn.kkiapay.me 'unsafe-eval'; 
    connect-src https://api.kkiapay.me; 
    frame-src https://widget-v3.kkiapay.me; 
    style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; 
    font-src 'self' https://fonts.gstatic.com;"
);


// Récupération des données du formulaire
$ref_sang = $_POST['ref_sang'];
$num_centre = $_POST['num_centre'];
$qte = $_POST['qte'];
$montant = $qte * 8000;

// Redirection après paiement
$callback = "http://localhost/sang/public/recherche/confirmer?ref_sang=" . urlencode($ref_sang) .
            "&num_centre=" . urlencode($num_centre) .
            "&qte=" . urlencode($qte) .
            "&montant=" . urlencode($montant);

// Politique de sécurité mise à jour (autorisation CSS, JS et frame Kkiapay)

?>


<h2 class="mb-4">💳 Paiement via Kkiapay</h2>
<p>Montant total à payer : <strong><?= $montant ?> FCFA</strong></p>

<!-- Conteneur utile pour le widget -->
<div id="kkiapay-widget-container" class="mt-4"></div>

<!-- Bouton déclencheur -->
<button id="payNowBtn" class="btn btn-success">Procéder au paiement</button>

<!-- Script SDK Kkiapay -->
<script src="https://cdn.kkiapay.me/k.js"></script>
<script>
    document.getElementById("payNowBtn").addEventListener("click", function () {
        new KkiapayWidget({
            amount: <?= $montant ?>,
            api_key: "pk_a0661bb7b4e85807b5faf92aa27667ffe44a6dfc7f6d4fb55f78ad359e5ac913",
            sandbox: true,
            callback: function (response) {
                window.location.href = "<?= $callback ?>&transaction_id=" + response.transactionId;
            },
            position: "center",
            theme: "light"
        }).open();
    });
</script>
