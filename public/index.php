<?php

require_once '../core/Router.php';
require_once '../core/Controller.php';
require_once '../core/Database.php';
require_once '../config/config.php';

$url = isset($_GET['url']) ? $_GET['url'] : '';
$router = new Router($url);
$router->dispatch();