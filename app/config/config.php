<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__, 2));
define('APP_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'app');
define('VIEW_PATH', APP_PATH . DIRECTORY_SEPARATOR . 'views');

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'gestion_voyages_etudes');
define('DB_USER', 'root');
define('DB_PASS', '');

define('APP_NAME', 'Voyages Etudes');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

spl_autoload_register(function (string $class): void {
    $directories = [
        APP_PATH . DIRECTORY_SEPARATOR . 'core',
        APP_PATH . DIRECTORY_SEPARATOR . 'models',
        APP_PATH . DIRECTORY_SEPARATOR . 'controllers',
    ];

    foreach ($directories as $directory) {
        $file = $directory . DIRECTORY_SEPARATOR . $class . '.php';
        if (is_file($file)) {
            require_once $file;
            return;
        }
    }
});

require_once APP_PATH . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'helpers.php';
