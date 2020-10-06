<?php

namespace Controller;

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
}
