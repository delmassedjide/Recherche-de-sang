<?php
require_once '../app/models/User.php';

class AdminController extends Controller {

    public function utilisateurs() {
        session_start();
        $this->authorize(['admin']);

        $role = $_GET['role'] ?? null;
        $userModel = new User();
        $utilisateurs = $userModel->getAll($role);

        require_once '../app/views/admin/utilisateurs.php';
    }

    public function modifierRole($id) {
        $this->authorize(['admin']);
    
        $role = $_POST['role'];
        $num_centre = $_POST['num_centre'] ?? null;
    
        $userModel = new User();
        
        // ✅ Mise à jour du rôle et éventuellement du centre si GBS
        if ($role === 'gbs' && $num_centre) {
            $userModel->updateRole($id, $role, $num_centre);
        } else {
            $userModel->updateRole($id, $role, null);
        }
    
        header('Location: /sang/public/admin/utilisateurs');
        exit;
    }

    public function supprimer($id) {
        $this->authorize(['admin']);
        $userModel = new User();
        $userModel->delete($id);
        header('Location: /sang/public/admin/utilisateurs');
        exit;
    }

    public function modifierCentre($id) {
        $this->authorize(['admin']);
        $num_centre = $_POST['num_centre'];
        $userModel = new User();
        $userModel->updateCentre($id, $num_centre);

        header('Location: /sang/public/admin/utilisateurs');
        exit;
    }

    public function dashboard() {
        $stockModel = new Stocks();
        $nombreCentres = $stockModel->countCentres(); // ✔ récupération du nombre total de centres
    
        $content = '../app/views/admin/dashboard.php';
        require '../app/views/layouts/default.php';
    }
}