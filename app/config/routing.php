<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Controller\UserController;
use Controller\ProductController;
use Controller\OrderController;
use Controller\MessageController;
use Controller\MainController;

$routes = new RouteCollection();

$routes->add(
    'index',
    new Route('/', ['_controller' => [MainController::class, 'indexAction']])
);

$routes->add(
    'product_list',
    new Route('/product/list', ['_controller' => [ProductController::class, 'listAction']])
);
$routes->add(
    'product_info',
    new Route('/product/info/{id}', ['_controller' => [ProductController::class, 'infoAction']])
);

$routes->add(
    'order_info',
    new Route('/order/info', ['_controller' => [OrderController::class, 'infoAction']])
);
$routes->add(
    'order_checkout',
    new Route('/order/checkout', ['_controller' => [OrderController::class, 'checkoutAction']])
);

$routes->add(
    'user_authentication',
    new Route('/user/authentication', ['_controller' => [UserController::class, 'authenticationAction']])
);

$routes->add(
    'logout',
    new Route('/user/logout', ['_controller' => [UserController::class, 'logoutAction']])
);

$routes->add(
    'message',
    new Route('/message/index', ['_controller' => [MessageController::class, 'indexAction']])
);

return $routes;
