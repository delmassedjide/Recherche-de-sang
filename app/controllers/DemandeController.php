<?php

require_once '../app/models/Demande.php';

class DemandeController extends Controller {

    public function create() {
        $this->authorize(['demandeur']);
    
        require_once '../app/models/Stocks.php';
        $stocksModel = new Stocks();
        $groupes = $stocksModel->getGroupes();
    
        require_once '../app/views/demande/create.php';
    }    

    public function store() {
        $this->authorize(['demandeur']);
    
        // Récupération des données
        $libelle = $_POST['libelle'];
        $ref_sang = $_POST['ref_sang'];
        $qte = $_POST['qte'];
        $id_demandeur = $_SESSION['user']['id'];
    
        $db = Database::getConnection();
        // Vérifie si le demandeur existe déjà dans la table demandeurs
        $stmt = $db->prepare("SELECT id FROM demandeurs WHERE id = ?");
        $stmt->execute([$id_demandeur]);

        if (!$stmt->fetch()) {
            // Insérer le demandeur
            $stmt = $db->prepare("INSERT INTO demandeurs (id) VALUES (?)");
            $stmt->execute([$id_demandeur]);
        }
    
        // 1. Créer une nouvelle demande
        $stmt = $db->prepare("INSERT INTO demandes (libelle, id_demandeur, date_demande) VALUES (?, ?, CURDATE())");
        $stmt->execute([$libelle, $id_demandeur]);
    
        $id_demande = $db->lastInsertId();
    
        // 2. Associer le groupe sanguin demandé
        $stmt = $db->prepare("INSERT INTO demander (id_demande, ref_sang, qte) VALUES (?, ?, ?)");
        $stmt->execute([$id_demande, $ref_sang, $qte]);
    
        header("Location: /sang/public/demande/mesDemandes");
        exit;
    }

    public function mesDemandes() {
        session_start();
    
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'demandeur') {
            header('Location: /home');
            exit;
        }
    
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;
    
        $demandeModel = new Demande();
        $demandes = $demandeModel->getDemandesByUser($_SESSION['user']['id'], $limit, $offset);
        $total = $demandeModel->countDemandesByUser($_SESSION['user']['id']);
        $pages = ceil($total / $limit);
    
        require_once '../app/views/demande/mes_demandes.php';
    }
    

    public function annuler($id) {
        session_start();
    
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'demandeur') {
            header('Location: /home');
            exit;
        }
    
        $demandeModel = new Demande();
    
        // Vérifie si la demande appartient bien à l'utilisateur connecté
        if ($demandeModel->verifierAppartenance($id, $_SESSION['user']['id'])) {
            $demandeModel->supprimerDemande($id);
        }
    
        header('Location: /sang/public/demande/mesDemandes');
    }

    public function valider($id_demande) {
        $this->authorize(['gbs']);
        $num_centre = $_SESSION['user']['num_centre'];
    
        $db = Database::getConnection();
    
        // Récupérer la demande
        $stmt = $db->prepare("SELECT ref_sang, qte FROM demander WHERE id_demande = ? AND num_centre = ?");
        $stmt->execute([$id_demande, $num_centre]);
        $donnee = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($donnee) {
            // Met à jour le stock (décrémenter)
            $stmtStock = $db->prepare("UPDATE stocks SET nbr_poche = nbr_poche - ? 
                                       WHERE num_centre = ? AND ref_sang = ? AND nbr_poche >= ?");
            $stmtStock->execute([$donnee['qte'], $num_centre, $donnee['ref_sang'], $donnee['qte']]);
    
            if ($stmtStock->rowCount() > 0) {
                // Statut validé
                $stmt = $db->prepare("UPDATE demandes SET statut = 'validée', date_validation = CURDATE() 
                                      WHERE id_demande = ?");
                $stmt->execute([$id_demande]);
            }
        }
    
        header("Location: /sang/public/stock/demandesProches");
        exit;
    }
}