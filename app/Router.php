<?php

namespace App;

class Router
{
    private $getRoutes = [];
    private $postRoutes = [];

    public function pushGet(string $action, array $controller, $middleware = null)
    {
        $this->getRoutes[$action] = ['controller' => $controller, 'middleware' => $middleware];
    }

    public function run()
    {
        $url_action = Request::get('action');
        $route_found = false;
        $server_method = Request::method();
        if ($server_method == 'GET') {
            $routes = $this->getRoutes;
        } elseif ($server_method == 'POST') {
            $routes = $this->postRoutes;
        }
        foreach ($routes as $action => $datas) {
            if ($action === $url_action) {
                $route_found = true;
                if ($datas['middleware'] != null) {
                    $middleware = new $datas['middleware']();
                }
                $controller = new $datas['controller'][0]();
                if (method_exists($controller, $datas['controller'][1])) {
                    $method = $datas['controller'][1];
                }
                if (isset($datas['controller'][2])) { // si [2] existe
                    $params = $datas['controller'][2]; // on récupère le tableau [0] => postId [1] => userId
                    $method_params = [];
                    foreach ($params as $param) {
                        $url_param = Request::get($param);
                        $method_params[] = $url_param;
                    }
                    call_user_func_array([$controller, $method], $method_params);
                } else { // sinon on execute methode sans paramètre
                    $controller->$method();
                }
            }
        }
        if (!$route_found) {
            echo '404';
        }
    }
}
