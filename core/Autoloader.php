<?php

class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            $class = str_replace('\\', '/', $class);

            $file = __DIR__ . '/../controllers/' . $class . '.php';

            if (file_exists($file)) {
                require_once $file;
            }
        });
    }
}
