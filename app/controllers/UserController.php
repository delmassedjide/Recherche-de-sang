<?php

require_once '../app/models/User.php';

class UserController extends Controller {

    public function register() {
        // Affiche le formulaire d'inscription
        require_once '../app/views/users/register.php';
    }

    public function login() {
        // Affiche le formulaire de connexion
        require_once '../app/views/users/login.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User();
            $user->store([
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'telephone' => $_POST['telephone'],
                'adresse_ville' => $_POST['adresse_ville'],
                'adresse_rue' => $_POST['adresse_rue']
            ]);
        
        // Ajout dans demandeurs si role = demandeur
        if ($_POST['role'] === 'demandeur') {
            $id = $user->getLastInsertedId(); // méthode à créer si elle n'existe pas

            $stmt = Database::getConnection()->prepare("INSERT INTO demandeurs (id) VALUES (?)");
            $stmt->execute([$id]);
        }

        // Redirection après inscription
            header('Location: /sang/public/user/login');
            exit;
    }
    }
    

    public function auth() {
        // Authentifie l'utilisateur
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = new User();
            $auth = $user->auth([
                'email' => $email,
                'password' => $password
            ]);

            if ($auth) {
                session_start();
                $_SESSION['user'] = $auth;
                header('Location: /sang/public/home');
                exit;
            } else {
                echo "Email ou mot de passe incorrect.";
            }
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /sang/public/user/login');
        exit;
    }

    public function profil() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['user'])) {
            header('Location: /sang/public/user/login');
            exit;
        }
    
        require_once '../app/views/users/profil.php';
    }
    

    public function updateProfil() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        $userModel = new User();
        $userModel->updateProfil($_SESSION['user']['id'], $_POST);
    
        foreach ($_POST as $key => $val) {
            if (isset($_SESSION['user'][$key])) {
                $_SESSION['user'][$key] = $val;
            }
        }
    
        header('Location: /sang/public/profil');
        exit;
    }
    
    
}