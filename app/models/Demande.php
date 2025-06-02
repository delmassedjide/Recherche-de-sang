<?php
// Fichier : /app/models/Demande.php

require_once '../core/Database.php';

class Demande {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getGroupesSanguins() {
        $stmt = $this->db->query("SELECT * FROM groupes_sanguins");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function store($data, $idUser) {
        $this->db->beginTransaction();

        $stmt1 = $this->db->prepare("INSERT INTO demandes (libelle, date_demande, id_demandeur) VALUES (?, ?, ?)");
        $stmt1->execute([
            $data['libelle'],
            date('Y-m-d'),
            $idUser
        ]);

        $idDemande = $this->db->lastInsertId();

        $stmt2 = $this->db->prepare("INSERT INTO demander (id_demande, ref_sang, qte) VALUES (?, ?, ?)");
        $stmt2->execute([
            $idDemande,
            $data['ref_sang'],
            $data['qte']
        ]);

        $this->db->commit();
    }

    public function getDemandesByUser($id_demandeur, $limit = 5, $offset = 0) {
    $db = Database::getConnection();

    // Sécurisation manuelle des entiers
    $limit = (int) $limit;
    $offset = (int) $offset;

    // Intégration directe des entiers dans la requête SQL
    $sql = "
        SELECT d.id_demande, d.date_demande, d.libelle, d.statut, 
               dm.ref_sang, dm.qte, c.nom AS centre
        FROM demandes d
        JOIN demander dm ON d.id_demande = dm.id_demande
        JOIN centres c ON c.num_centre = dm.num_centre
        WHERE d.id_demandeur = ?
        ORDER BY d.date_demande DESC
        LIMIT $limit OFFSET $offset
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute([$id_demandeur]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countDemandesByUser($idUser) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM demandes WHERE id_demandeur = ?");
        $stmt->execute([$idUser]);
        return $stmt->fetchColumn();
    }

    public function verifierAppartenance($idDemande, $idUser) {
        $stmt = $this->db->prepare("SELECT id_demande FROM demandes WHERE id_demande = ? AND id_demandeur = ?");
        $stmt->execute([$idDemande, $idUser]);
        return $stmt->fetch() ? true : false;
    }

    public function supprimerDemande($idDemande) {
        $this->db->beginTransaction();
        $this->db->prepare("DELETE FROM demander WHERE id_demande = ?")->execute([$idDemande]);
        $this->db->prepare("DELETE FROM demandes WHERE id_demande = ?")->execute([$idDemande]);
        $this->db->commit();
    }

    public function getDemandesRecues($num_centre) {
    $db = Database::getConnection();

    $stmt = $db->prepare("
        SELECT d.id_demande, d.date_demande, d.libelle, dm.qte, dm.ref_sang, d.statut,
               u.nom, u.prenom
        FROM demandes d
        JOIN demander dm ON d.id_demande = dm.id_demande
        JOIN users u ON d.id_demandeur = u.id
        WHERE dm.num_centre = ? AND d.statut = 'en attente'
        ORDER BY d.date_demande DESC
    ");
    $stmt->execute([$num_centre]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function validerDemande($id_demande) {
        $stmt = $this->db->prepare("UPDATE demandes SET statut = 'validée', date_validation = NOW() WHERE id_demande = ?");
        $stmt->execute([$id_demande]);
    }

    public function getHistoriqueGbs($num_centre, $periode = 'all') {
    $sql = "
        SELECT d.id_demande, d.libelle, d.date_demande, d.date_validation, 
               u.nom, u.prenom, dm.qte, gs.ref_sang
        FROM demandes d
        JOIN users u ON d.id_demandeur = u.id
        JOIN demander dm ON dm.id_demande = d.id_demande
        JOIN groupes_sanguins gs ON gs.ref_sang = dm.ref_sang
        WHERE d.statut = 'validée'
        AND dm.ref_sang IN (
            SELECT ref_sang FROM stocks WHERE num_centre = :num_centre
        )
    ";

    // Ajouter condition selon la période
    if ($periode === 'today') {
        $sql .= " AND DATE(d.date_validation) = CURDATE()";
    } elseif ($periode === '7days') {
        $sql .= " AND d.date_validation >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
    } elseif ($periode === '30days') {
        $sql .= " AND d.date_validation >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
    }

    $sql .= " ORDER BY d.date_validation DESC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['num_centre' => $num_centre]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDemandesParCentre($num_centre) {
        $stmt = $this->db->prepare("SELECT d.id_demande, d.date_demande, d.statut, u.nom, u.prenom, dm.ref_sang, dm.qte
            FROM demandes d
            JOIN demander dm ON d.id_demande = dm.id_demande
            JOIN users u ON d.id_demandeur = u.id
            WHERE dm.num_centre = ?
            ORDER BY d.date_demande DESC");
        $stmt->execute([$num_centre]);
        return $stmt->fetchAll();
    }

    public function getDemandesEnAttenteParCentre($num_centre) {
        $sql = "SELECT d.id_demande, d.date_demande, u.nom, u.prenom, dm.ref_sang, dm.qte
                FROM demandes d
                JOIN demander dm ON d.id_demande = dm.id_demande
                JOIN users u ON d.id_demandeur = u.id
                WHERE dm.num_centre = ? AND d.statut = 'en attente'
                ORDER BY d.date_demande DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$num_centre]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countDemandesEnAttente($num_centre) {
    $stmt = $this->db->prepare("SELECT COUNT(*) FROM demandes d
        JOIN demander dm ON d.id_demande = dm.id_demande
        WHERE d.statut = 'en attente' AND dm.num_centre = ?");
    $stmt->execute([$num_centre]);
    return $stmt->fetchColumn();
    }

    public function countDemandesValideesRecentes($num_centre) {
    $stmt = $this->db->prepare("
        SELECT COUNT(*) FROM demandes d
        JOIN demander dm ON d.id_demande = dm.id_demande
        WHERE dm.num_centre = ? 
        AND d.statut = 'validée' 
        AND d.date_validation >= DATE_SUB(NOW(), INTERVAL 1 DAY)
    ");
    $stmt->execute([$num_centre]);
    return $stmt->fetchColumn();
    }
}