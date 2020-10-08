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

    public function pushPost(string $action, array $controller, $middleware = null)
    {
        $this->postRoutes[$action] = ['controller' => $controller, 'middleware' => $middleware];
    }

    public function run()
    {
        $url_action = Request::get('action'); //on récupère l'action dans l'url
        $route_found = false; //nouvelle variable de vérification
        $server_method = Request::method(); // on récupere la method d'envoi des données
        if ($server_method == 'GET') { // on associe une variable [contenant infos] en fonction du résultat à $routes
            $routes = $this->getRoutes;
        } elseif ($server_method == 'POST') {
            $routes = $this->postRoutes;
        }
        foreach ($routes as $action => $datas) { //parcours du tableau routes
            if ($action === $url_action) { // si l'action de route = l'action demandé par l'url
                $route_found = true;
                if ($datas['middleware'] != null) {
                    $middleware = new $datas['middleware']();
                }
                $controller = new $datas['controller'][0]();
                if (method_exists($controller, $datas['controller'][1])) { // si methode avec le nom de l'action
                    $method = $datas['controller'][1];
                }
                if (isset($datas['controller'][2])) { // s'il y a des paramètres'
                    $params = $datas['controller'][2];
                    $method_params = [];
                    foreach ($params as $param) {
                        $url_param = null;
                        $url_param = Request::get($param);
                        if (isset($url_param)) {
                            $method_params[] = $url_param;
                        } else {
                            echo 'url_param n\'existe pas';
                        }
                    }
                    call_user_func_array([$controller, $method], $method_params); // appel de la methode avec paramètres
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
