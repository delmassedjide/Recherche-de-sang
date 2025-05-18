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

    public function getDemandesByUser($idUser, $limit = 5, $offset = 0) {
        $stmt = $this->db->prepare("SELECT d.id_demande, d.libelle, d.date_demande, ds.qte, gs.ref_sang
            FROM demandes d
            JOIN demander ds ON ds.id_demande = d.id_demande
            JOIN groupes_sanguins gs ON gs.ref_sang = ds.ref_sang
            WHERE d.id_demandeur = ?
            ORDER BY d.date_demande DESC
            LIMIT ? OFFSET ?");
        $stmt->bindValue(1, $idUser, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        $stmt->execute();
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

    public function getDemandesProches($num_centre) {
        $stmt = $this->db->prepare("SELECT d.id_demande, d.libelle, d.date_demande, dem.nom, dem.prenom, ds.qte, gs.ref_sang
            FROM demandes d
            JOIN users dem ON d.id_demandeur = dem.id
            JOIN demander ds ON ds.id_demande = d.id_demande
            JOIN groupes_sanguins gs ON gs.ref_sang = ds.ref_sang
            WHERE ds.ref_sang IN (
                SELECT ref_sang FROM stocks WHERE num_centre = ?
            ) AND d.statut = 'en attente'
            ORDER BY d.date_demande DESC");
        $stmt->execute([$num_centre]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function validerDemande($id_demande) {
        $stmt = $this->db->prepare("UPDATE demandes SET statut = 'validée', date_validation = NOW() WHERE id_demande = ?");
        $stmt->execute([$id_demande]);
    }

    public function getHistoriqueGbs($num_centre) {
        $stmt = $this->db->prepare("SELECT d.id_demande, d.libelle, d.date_demande, d.date_validation, u.nom, u.prenom, ds.qte, gs.ref_sang
            FROM demandes d
            JOIN users u ON d.id_demandeur = u.id
            JOIN demander ds ON ds.id_demande = d.id_demande
            JOIN groupes_sanguins gs ON gs.ref_sang = ds.ref_sang
            WHERE d.statut = 'validée'
            AND ds.ref_sang IN (
                SELECT ref_sang FROM stocks WHERE num_centre = ?
            )
            ORDER BY d.date_demande DESC");
        $stmt->execute([$num_centre]);
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
}