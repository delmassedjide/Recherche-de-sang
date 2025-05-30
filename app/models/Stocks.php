<?php

class Stocks {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getByCentre($num_centre) {
    $stmt = $this->db->prepare("
        SELECT s.*, c.nom_centre 
        FROM stocks s 
        JOIN centres c ON s.num_centre = c.num_centre 
        WHERE s.num_centre = ?
    ");
    $stmt->execute([$num_centre]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM stocks WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function store($data) {
        $stmt = $this->db->prepare("
            INSERT INTO stocks (num_centre, ref_sang, nbr_poche)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([
            $data['num_centre'],
            $data['ref_sang'],
            $data['nbr_poche']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE stocks SET nbr_poche = ? WHERE id = ?
        ");
        $stmt->execute([
            $data['nbr_poche'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM stocks WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function getGroupes() {
        $stmt = $this->db->query("SELECT * FROM groupes_sanguins");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCentres() {
        return $this->db->query("SELECT * FROM centres")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countCentres() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM centres");
        return $stmt->fetchColumn();
    }

    public function rechercherCentresDisponibles($groupe) {
    $stmt = $this->db->prepare("
        SELECT c.nom, c.adresse, c.latitude, c.longitude, c.num_centre, s.nbr_poche, s.ref_sang
        FROM stocks s
        JOIN centres c ON TRIM(c.num_centre) = TRIM(s.num_centre)
        WHERE s.ref_sang = ? AND s.nbr_poche > 0
    ");
    $stmt->execute([$groupe]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // public function countByGroupPrefix($prefix) {
    //     $stmt = $this->db->prepare("SELECT SUM(nbr_poche) FROM stocks WHERE ref_sang LIKE ?");
    //     $stmt->execute(["$prefix%"]);
    //     return $stmt->fetchColumn() ?: 0;
    // }

    // public function countTotal() {
    //     $stmt = $this->db->query("SELECT SUM(nbr_poche) FROM stocks");
    //     return $stmt->fetchColumn() ?: 0;
    // }

    public function countByGroupPrefixForCentre($prefix, $num_centre) {
    $stmt = $this->db->prepare("SELECT SUM(nbr_poche) FROM stocks WHERE ref_sang LIKE ? AND num_centre = ?");
    $stmt->execute(["$prefix%", $num_centre]);
    return $stmt->fetchColumn() ?: 0;
    }

    public function countTotalByCentre($num_centre) {
    $stmt = $this->db->prepare("SELECT SUM(nbr_poche) FROM stocks WHERE num_centre = ?");
    $stmt->execute([$num_centre]);
    return $stmt->fetchColumn() ?: 0;
    }

}