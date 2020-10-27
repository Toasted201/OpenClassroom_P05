<?php

namespace Controller;

use App\Session;
use Model\Entity\User;

abstract class BaseController
{
    private $twig = null;

    protected function render(string $masque, array $parametres): string
    {
        if ($this->twig === null) {
            $loader = new \Twig\Loader\FileSystemLoader('../View');
            $this->twig = new \Twig\Environment($loader, [
                'cache' => '../View/Cache',
                'auto_reload' => true,
            ]);
        }
        $firstName = null;
        $connectedUser = Session::auth();
        if (!empty($connectedUser)) {
            $firstName = $connectedUser->firstName();
        }
        $parametres['firstName'] = $firstName;
        $userRole = null;
        $connectedUser = Session::auth();
        if (!empty($connectedUser)) {
            $userRole = $connectedUser->userRole();
        }
        $parametres['userRole'] = $userRole;
        return $this->twig->render($masque, $parametres);
    }
}
