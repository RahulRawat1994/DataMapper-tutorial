<?php
class Autoloader
{
    public static function register()
    {
        /**
         * Autoload All files
         */
        spl_autoload_register(function ($class_name) {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $class_name).'.php';
            if (!file_exists($file)) {
                throw new \Exception("Unable to load $file file");
            }
            require_once $file;
        });

    }
}
