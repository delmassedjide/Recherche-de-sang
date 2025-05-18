<?php
require_once '../app/models/Stocks.php';

class RechercheController extends Controller {

    public function index() {
        $this->authorize(['demandeur']);
        require_once '../app/views/recherche/index.php';
    }

    public function profil() {
        require_once '../app/views/users/profil.php';
    }

    public function resultats() {
        $this->authorize(['demandeur']);
    
        // ✅ récupérer depuis $_POST et non $_GET
        $groupe = $_POST['ref_sang'] ?? '';
    
        $stockModel = new Stocks();
        $centres = $stockModel->rechercherCentresDisponibles($groupe);
    
        // ✅ On transmet $groupe à la vue
        $_POST['ref_sang'] = $groupe;
    
        require_once '../app/views/recherche/resultats.php';
    }

    public function paiement() {
        $this->authorize(['demandeur']);
        require_once '../app/views/recherche/paiement.php';
    }

    public function payer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // On extrait les données
            $ref_sang = $_POST['ref_sang'] ?? '';
            $centre = $_POST['centre'] ?? '';
            $quantite = $_POST['quantite'] ?? 0;
    
            // Tu peux ici stocker la demande dans la base de données
            // ou simplement appeler l'API de paiement (ex: FedaPay côté JS)
    
            // Pour le moment on redirige vers une page de confirmation ou test
            header('Location: /sang/public/recherche/success');
            exit;
        } else {
            echo "Méthode non autorisée.";
        }
    }

    public function valider() {
        $this->authorize(['demandeur']);
        $ref_sang = $_POST['ref_sang'];
        $num_centre = $_POST['num_centre'];
        $qte = $_POST['qte'];
        $user = $_SESSION['user'];
        $montant_unitaire = 8000;
        $total = $qte * $montant_unitaire;
        require_once '../app/views/recherche/kkiapay.php';
    }

    public function confirmer() {
    $this->authorize(['demandeur']);

    // Vérification des paramètres GET
    $ref_sang = $_GET['ref_sang'] ?? null;
    $num_centre = $_GET['num_centre'] ?? null;
    $qte = $_GET['qte'] ?? null;
    $montant = $_GET['montant'] ?? null;
    $transaction_id = $_GET['transaction_id'] ?? null;

    if (!$ref_sang || !$num_centre || !$qte || !$montant || !$transaction_id) {
        die("Paramètres manquants pour valider la demande.");
    }

    $id_demandeur = $_SESSION['user']['id'];
    $db = Database::getConnection();

    // Enregistrement de la demande principale
    $stmt = $db->prepare("INSERT INTO demandes (libelle, id_demandeur, date_demande, statut) VALUES (?, ?, CURDATE(), 'en attente')");
    $stmt->execute(["Demande FedaPay #$transaction_id", $id_demandeur]);

    $id_demande = $db->lastInsertId();

    // Enregistrement des détails de la demande
    $stmt = $db->prepare("INSERT INTO demander (id_demande, ref_sang, qte, num_centre, montant) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$id_demande, $ref_sang, $qte, $num_centre, $montant]);

    // Redirection vers les demandes du demandeur
    header("Location: /sang/public/demande/mesDemandes");
    exit;
}
}