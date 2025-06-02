<?php

class User {

    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function store($data) {
        $stmt = $this->db->prepare("
            INSERT INTO users (nom, prenom, email, password, telephone, adresse_ville, adresse_rue, role)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
    
        $stmt->execute([
            $data['nom'],
            $data['prenom'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['telephone'],
            $data['adresse_ville'],
            $data['adresse_rue'],
            'demandeur' // rôle défini en dur
        ]);
    }
    

    public function auth($data) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$data['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($data['password'], $user['password'])) {
            return $user;
        }

        return false;
    }

    public function getAll($role = null) {
    if ($role && in_array($role, ['admin', 'gbs', 'demandeur'])) {
        $stmt = $this->db->prepare("
            SELECT id, nom, prenom, email, role, telephone, num_centre, latitude, longitude
            FROM users
            WHERE role = ?
            ORDER BY nom ASC
        ");
        $stmt->execute([$role]);
    } else {
        $stmt = $this->db->query("
            SELECT id, nom, prenom, email, role, telephone, num_centre, latitude, longitude
            FROM users
            ORDER BY role ASC, nom ASC
        ");
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLastInsertedId() {
    return $this->db->lastInsertId();
    }

    public function updateRole($id, $role, $num_centre = null) {
        $db = Database::getConnection();
    
        if ($role === 'gbs' && $num_centre !== null) {
            $stmt = $db->prepare("UPDATE users SET role = ?, num_centre = ? WHERE id = ?");
            $stmt->execute([$role, $num_centre, $id]);
        } else {
            $stmt = $db->prepare("UPDATE users SET role = ?, num_centre = NULL WHERE id = ?");
            $stmt->execute([$role, $id]);
        }
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }
    
    public function updateProfil($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE users
            SET nom = ?, prenom = ?, email = ?, telephone = ?, adresse_ville = ?, adresse_rue = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['telephone'],
            $data['adresse_ville'],
            $data['adresse_rue'],
            $id
        ]);
    }    
    
    public function updateCentre($id, $num_centre) {
        $stmt = $this->db->prepare("UPDATE users SET num_centre = ? WHERE id = ?");
        $stmt->execute([$num_centre, $id]);
    }

    public function updateRoleAndCentre($id, $role, $num_centre = null, $latitude = null, $longitude = null) {
    $sql = "UPDATE users SET role = :role, num_centre = :num_centre, latitude = :latitude, longitude = :longitude WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        'role' => $role,
        'num_centre' => $num_centre,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'id' => $id
    ]);
    }

    public function updateCoordonnees($id, $latitude, $longitude) {
    $stmt = $this->db->prepare("UPDATE users SET latitude = ?, longitude = ? WHERE id = ?");
    $stmt->execute([$latitude, $longitude, $id]);
    }

}
