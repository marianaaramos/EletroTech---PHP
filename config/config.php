<?php

defined('ROOT_PATH') or define('ROOT_PATH', dirname(__DIR__));

define('APP_NAME', 'EletroTech');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost/eletrotech');
define('APP_ENV', 'development');

define('DB_HOST', 'localhost');
define('DB_NAME', 'eletrotech');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

define('SESSION_NAME', 'eletrotech_session');
define('SESSION_LIFETIME', 3600);

define('COOKIE_NAME', 'eletrotech_remember');
define('COOKIE_LIFETIME', 604800);

define('UPLOAD_DIR', ROOT_PATH . '/assets/uploads/');
define('UPLOAD_MAX_SIZE', 5242880);
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

define('ITEMS_PER_PAGE', 12);

if (APP_ENV === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

date_default_timezone_set('America/Sao_Paulo');

spl_autoload_register(function (string $className): void {
    $paths = [
        ROOT_PATH . '/models/' . $className . '.php',
        ROOT_PATH . '/controllers/' . $className . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});
