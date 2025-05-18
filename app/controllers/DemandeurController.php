<?php
require_once '../app/models/User.php';

class DemandeurController extends Controller {
    public function dashboard() {
        require_once '../app/views/demandeur/dashboard.php';
    }
}