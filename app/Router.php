<?php
namespace App;

class Router
{
    private $getRoutes = [];
    private $postRoutes = [];
    private $action;

    public function __construct($action)
    {
        $this->action = $action;
    }

    public function get(string $action, array $controller, $middleware = null)
    {
        $this->getRoutes[$action] = ['controller'=>$controller, 'middleware'=>$middleware];
    }

    public function run()
    {
        $route_found = false;
        $server_method = Request::method();
        $server_method = strtolower($server_method).'Routes';
        $routes = $this->$server_method;
        foreach($routes as $action=>$datas) {
            if($action === $this->action) {
                $route_found = true;
                if($datas['middleware'] != null)
                    $middleware = new $datas['middleware'];

                $controller = new $datas['controller'][0];
                if(method_exists($controller, $datas['controller'][1])) {
                    $controller->$datas['controller'][1];
                }
            }

        }

        if(!$route_found) {
            echo '404';
        }
    }
}