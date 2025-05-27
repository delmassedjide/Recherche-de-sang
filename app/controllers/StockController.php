<?php

require_once '../app/models/Stocks.php';
require_once '../app/models/Demande.php';

class StockController extends Controller {

    public function gerer() {
        $this->authorize(['gbs']);
    
        $user = $_SESSION['user'];
        $num_centre = $user['num_centre'];
    
        $stocksModel = new Stocks();
        $stocks = $stocksModel->getByCentre($num_centre);  // filtration ici
        $groupes = $stocksModel->getGroupes();
        $centres = $stocksModel->getCentres();
    
        require_once '../app/views/stock/gerer.php';
    }    

    public function store() {
        $this->authorize(['gbs']);

        $stocksModel = new Stocks();
        $stocksModel->store($_POST);

        header('Location: /sang/public/stock/gerer');
        exit;
    }

    public function edit($id) {
        $this->authorize(['gbs']);

        $stocksModel = new Stocks();
        $stocks = $stocksModel->getById($id);
        $groupes = $stocksModel->getGroupes();
        $centres = $stocksModel->getCentres();

        require_once '../app/views/stock/edit.php';
    }

    public function update($id) {
        $this->authorize(['gbs']);

        $stocksModel = new Stocks();
        $stocksModel->update($id, $_POST);

        header('Location: /sang/public/stock/gerer');
        exit;
    }

    public function delete($id) {
        $this->authorize(['gbs']);

        $stocksModel = new Stocks();
        $stocksModel->delete($id);

        header('Location: /sang/public/stock/gerer');
        exit;
    }
   
    public function valider($id_demande) {
        $this->authorize(['gbs']);
        $demandeModel = new Demande();
        $num_centre = $_SESSION['user']['num_centre'];
    
        // Récupération des infos de la demande
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT dm.ref_sang, dm.qte 
                              FROM demander dm 
                              WHERE dm.id_demande = ?");
        $stmt->execute([$id_demande]);
        $info = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$info) {
            $_SESSION['error'] = "Demande introuvable.";
            header("Location: /sang/public/stock/demandesRecues");
            exit;
        }
    
        // Vérifier la disponibilité dans les stocks
        $stmt = $db->prepare("SELECT nbr_poche FROM stocks 
                              WHERE ref_sang = ? AND num_centre = ?");
        $stmt->execute([$info['ref_sang'], $num_centre]);
        $stock = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$stock || $stock['nbr_poche'] < $info['qte']) {
            $_SESSION['error'] = "Stock insuffisant pour valider la demande.";
            header("Location: /sang/public/stock/demandesRecues");
            exit;
        }
    
        // Mise à jour du stock (décrémentation)
        $stmt = $db->prepare("UPDATE stocks SET nbr_poche = nbr_poche - ? 
                              WHERE ref_sang = ? AND num_centre = ?");
        $stmt->execute([$info['qte'], $info['ref_sang'], $num_centre]);
    
        // Mise à jour du statut de la demande
        $stmt = $db->prepare("UPDATE demandes 
                              SET statut = 'validée', date_validation = NOW() 
                              WHERE id_demande = ?");
        $stmt->execute([$id_demande]);
    
        $_SESSION['success'] = "Demande validée avec succès.";
        header("Location: /sang/public/stock/demandesRecues");
        exit;
    }
    
    public function historique() {
    $this->authorize(['gbs']);

    require_once '../app/models/Demande.php';
    $model = new Demande();

    $num_centre = $_SESSION['user']['num_centre'];
    $periode = $_GET['periode'] ?? 'all';

    $demandes = $model->getHistoriqueGbs($num_centre, $periode);

    require_once '../app/views/stock/historique.php';
    }

    public function demandesRecues() {
    $this->authorize(['gbs']);

    require_once '../app/models/Demande.php';
    $demandeModel = new Demande();

    $num_centre = $_SESSION['user']['num_centre'];
    $demandes = $demandeModel->getDemandesRecues($num_centre); // méthode à implémenter si ce n’est pas encore fait

    require_once '../app/views/stock/demandesRecues.php';
}
    
}