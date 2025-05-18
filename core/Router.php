<?php

class Router {
    private $url;

    public function __construct($url) {
        $this->url = trim($url, '/');
    }

    public function dispatch() {
        $segments = explode('/', $this->url);

        $controllerName = ucfirst($segments[0] ?? 'home') . 'Controller';
        $method = $segments[1] ?? 'index';
        $params = array_slice($segments, 2);

        $path = '../app/controllers/' . $controllerName . '.php';
        if (file_exists($path)) {
            require_once $path;
            $controller = new $controllerName();

            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
            } else {
                echo "Méthode \"$method\" introuvable dans $controllerName.";
            }
        } else {
            echo "Contrôleur \"$controllerName\" introuvable.";
        }
    }
}