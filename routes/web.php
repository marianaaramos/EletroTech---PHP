<?php

function getRoutes(): array
{
    return [
        'home' => [
            'index'       => ['HomeController', 'index'],
            'about'       => ['HomeController', 'about'],
            'contact'     => ['HomeController', 'contact'],
            'contactPost' => ['HomeController', 'contactPost'],
            'phpDemo'     => ['HomeController', 'phpDemo'],
        ],
        'auth' => [
            'login'       => ['AuthController', 'login'],
            'loginPost'   => ['AuthController', 'loginPost'],
            'logout'      => ['AuthController', 'logout'],
            'register'    => ['AuthController', 'register'],
            'registerPost'=> ['AuthController', 'registerPost'],
            'recover'     => ['AuthController', 'recover'],
            'recoverPost' => ['AuthController', 'recoverPost'],
        ],
        'products' => [
            'index'   => ['ProductController', 'index'],
            'show'    => ['ProductController', 'show'],
            'create'  => ['ProductController', 'create'],
            'store'   => ['ProductController', 'store'],
            'edit'    => ['ProductController', 'edit'],
            'update'  => ['ProductController', 'update'],
            'destroy' => ['ProductController', 'destroy'],
        ],
        'categories' => [
            'index'   => ['CategoryController', 'index'],
            'create'  => ['CategoryController', 'create'],
            'store'   => ['CategoryController', 'store'],
            'edit'    => ['CategoryController', 'edit'],
            'update'  => ['CategoryController', 'update'],
            'destroy' => ['CategoryController', 'destroy'],
        ],
        'users' => [
            'index'         => ['UserController', 'index'],
            'create'        => ['UserController', 'create'],
            'store'         => ['UserController', 'store'],
            'edit'          => ['UserController', 'edit'],
            'update'        => ['UserController', 'update'],
            'destroy'       => ['UserController', 'destroy'],
            'profile'       => ['UserController', 'profile'],
            'profileUpdate' => ['UserController', 'profileUpdate'],
        ],
        'cart' => [
            'index'          => ['CartController', 'index'],
            'add'            => ['CartController', 'add'],
            'update'         => ['CartController', 'update'],
            'remove'         => ['CartController', 'remove'],
            'checkout'       => ['CartController', 'checkout'],
            'processCheckout'=> ['CartController', 'processCheckout'],
            'clear'          => ['CartController', 'clear'],
        ],
        'orders' => [
            'index'        => ['OrderController', 'index'],
            'show'         => ['OrderController', 'show'],
            'adminIndex'   => ['OrderController', 'adminIndex'],
            'updateStatus' => ['OrderController', 'updateStatus'],
        ],
        'admin' => [
            'dashboard' => ['AdminController', 'dashboard'],
            'products'  => ['AdminController', 'products'],
        ],
    ];
}


function dispatch(): void
{
    $controller = $_GET['controller'] ?? 'home';
    $action     = $_GET['action']     ?? 'index';

    $controller = preg_replace('/[^a-zA-Z]/', '', $controller);
    $action     = preg_replace('/[^a-zA-Z]/', '', $action);

    $routes = getRoutes();

    if (!isset($routes[$controller][$action])) {
        if (isset($routes[$controller]['index'])) {
            $action = 'index';
        } else {
            http_response_code(404);
            $ctrl = new BaseController();
            require ROOT_PATH . '/views/layouts/header.php';
            require ROOT_PATH . '/views/errors/404.php';
            require ROOT_PATH . '/views/layouts/footer.php';
            return;
        }
    }

    [$controllerClass, $method] = $routes[$controller][$action];

    if (!class_exists($controllerClass)) {
        http_response_code(500);
        die('Controller não encontrado: ' . htmlspecialchars($controllerClass));
    }

    $controllerInstance = new $controllerClass();

    if (!method_exists($controllerInstance, $method)) {
        http_response_code(500);
        die('Método não encontrado: ' . htmlspecialchars($method));
    }

    $controllerInstance->$method();
}
