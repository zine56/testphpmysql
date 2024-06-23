<?php

namespace App\Helpers;

class View
{
    private static $twig;

    public static function init()
    {
        // Asegurarse de que la sesión esté iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../Views');
        self::$twig = new \Twig\Environment($loader, [
            'cache' => __DIR__ . '/../../cache',
            'debug' => true,
        ]);

        // Añadir la sesión a Twig
        self::$twig->addGlobal('session', $_SESSION);
    }

    public static function render($template, $data = [])
    {
        if (!self::$twig) {
            self::init();
        }

        echo self::$twig->render($template, $data);
    }
}
