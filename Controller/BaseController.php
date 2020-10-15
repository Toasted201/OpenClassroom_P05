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
        return $this->twig->render($masque, $parametres);
    }

    protected function getConnectedUser(): ?User
    {

        if (empty(Session::get('connectedUser'))) {
            $connectedUser = null;
        } else {
            $connectedUser = unserialize(Session::get('connectedUser'));
        }
        return $connectedUser;
    }
}
