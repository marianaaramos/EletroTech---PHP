<?php

define('ROOT_PATH', __DIR__);

require ROOT_PATH . '/config/config.php';
require ROOT_PATH . '/config/database.php';

require ROOT_PATH . '/models/Model.php';
require ROOT_PATH . '/controllers/BaseController.php';

session_name(SESSION_NAME);
session_start();

if (!isset($_SESSION['usuario_id']) && isset($_COOKIE[COOKIE_NAME])) {
    require ROOT_PATH . '/models/User.php';
    $userModel = new User();
    $usuario   = $userModel->findByToken($_COOKIE[COOKIE_NAME]);

    if ($usuario) {
        session_regenerate_id(true);
        $_SESSION['usuario_id']    = $usuario['id'];
        $_SESSION['usuario_nome']  = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_role']  = $usuario['role'];
    } else {
        setcookie(COOKIE_NAME, '', time() - 3600, '/');
    }
}

require ROOT_PATH . '/models/User.php';
require ROOT_PATH . '/models/Category.php';
require ROOT_PATH . '/models/Product.php';
require ROOT_PATH . '/models/Order.php';
require ROOT_PATH . '/models/Cart.php';

require ROOT_PATH . '/controllers/AuthController.php';
require ROOT_PATH . '/controllers/HomeController.php';
require ROOT_PATH . '/controllers/ProductController.php';
require ROOT_PATH . '/controllers/CategoryController.php';
require ROOT_PATH . '/controllers/UserController.php';
require ROOT_PATH . '/controllers/CartController.php';
require ROOT_PATH . '/controllers/OrderController.php';
require ROOT_PATH . '/controllers/AdminController.php';

require ROOT_PATH . '/routes/web.php';
dispatch();
