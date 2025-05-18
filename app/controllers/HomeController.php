<?php

class HomeController extends Controller {
    public function index() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /sang/public/user/login');
            exit;
        }

        $role = $_SESSION['user']['role'];

        if ($role === 'admin') {
            require_once '../app/views/admin/dashboard.php';
        } elseif ($role === 'gbs') {
            require_once '../app/views/gbs/dashboard.php';
        } elseif ($role === 'demandeur') {
            header('Location: /sang/public/recherche');
            exit;
        }
    }
}