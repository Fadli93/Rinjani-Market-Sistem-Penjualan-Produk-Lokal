<?php

class App {
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseURL();

        // Controller
        if (isset($url[0]) && file_exists('../app/controllers/' . ucfirst($url[0]) . '.php')) {
            $this->controller = ucfirst($url[0]);
            unset($url[0]);
        }

        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Method
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // Params
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        // Jalankan Controller & Method, serta kirimkan Params jika ada
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        
        // Fallback for PHP Built-in Server or when .htaccess is not working as expected
        $request_uri = $_SERVER['REQUEST_URI'];
        
        // Remove query string
        if (strpos($request_uri, '?') !== false) {
            $request_uri = substr($request_uri, 0, strpos($request_uri, '?'));
        }
        
        // Remove leading slash
        $url = ltrim($request_uri, '/');
        
        if (!empty($url)) {
             $url = rtrim($url, '/');
             $url = filter_var($url, FILTER_SANITIZE_URL);
             return explode('/', $url);
        }

        return ['Home'];
    }
}
