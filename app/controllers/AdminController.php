<?php
require_once '../app/models/User.php';
require_once '../app/models/Stocks.php';


class AdminController extends Controller {

    public function utilisateurs() {
    session_start();
    $this->authorize(['admin']);

    $role = $_GET['role'] ?? null;
    $userModel = new User();
    $stockModel = new Stocks();
    $utilisateurs = $userModel->getAll($role);
    $centres = $stockModel->getCentres(); // <-- récupération ici

    require_once '../app/views/admin/utilisateurs.php';
    }


    public function modifierRole($id) {
    $this->authorize(['admin']);
    
    $role = $_POST['role'];
    $num_centre = $_POST['num_centre'] ?? null;
    $latitude = $_POST['latitude'] ?? null;
    $longitude = $_POST['longitude'] ?? null;

    $userModel = new User();

    // Mise à jour du rôle et du centre
    $userModel->updateRole($id, $role, $num_centre);

    // Si GBS, on enregistre aussi la latitude et la longitude
    if ($role === 'gbs' && $latitude && $longitude) {
        $userModel->updateCoordonnees($id, $latitude, $longitude);
    }

    // Rechargement de la session utilisateur si c'est l'utilisateur actuel
    if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $id) {
        $_SESSION['user']['role'] = $role;
        $_SESSION['user']['num_centre'] = $num_centre;
    }

    // Rechargement de la session utilisateur si c’est lui-même
    if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $id) {
        $_SESSION['user']['role'] = $role;
        $_SESSION['user']['num_centre'] = $num_centre;
        $_SESSION['user']['latitude'] = $latitude;
        $_SESSION['user']['longitude'] = $longitude;
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