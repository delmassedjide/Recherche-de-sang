<?php
require_once '../app/models/User.php';

class GbsController extends Controller {
    public function dashboard() {
        require_once '../app/views/gbs/dashboard.php';
    }
}