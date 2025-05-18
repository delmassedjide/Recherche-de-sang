<?php

class Controller {
    protected function authorize($roles = []) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], $roles)) {
            header('Location: /sang/public/home');
            exit;
        }
    }
}