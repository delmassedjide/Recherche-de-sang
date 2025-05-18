<?php

class Database {
    private static $instance = null;

    public static function getConnection() {
        if (self::$instance === null) {
            $config = require '../config/config.php';
            try {
                self::$instance = new PDO(
                    'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'],
                    $config['user'],
                    $config['password']
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Erreur DB : ' . $e->getMessage());
            }
        }

        return self::$instance;
    }
}