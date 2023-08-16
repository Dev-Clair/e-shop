<?php

declare(strict_types=1);

use app\Router;
use app\Exception\RouteNotFoundException;

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';

try {
    $router = new Router();

    $router->get(route: '/e-shop/', action: [app\Controller\HomeController::class, 'index'])
        ->get(route: '/e-shop/book/', action: [app\Controller\BookController::class, 'index'])
        ->get(route: '/e-shop/cart/', action: [app\Controller\CartController::class, 'index'])
        ->post(route: '/e-shop/books/addToCart', action: [app\Controller\BookController::class, 'addToCart'])
        ->post(route: '/e-shop/cart/createOrder', action: [app\Controller\CartController::class, 'createOrder'])
        ->get(route: '/e-shop/book/create', action: [app\Controller\BookController::class, 'create'])
        ->post(route: '/e-shop/book/store', action: [app\Controller\BookController::class, 'store'])
        ->get(route: '/e-shop/book/edit', action: [app\Controller\BookController::class, 'edit'])
        ->post(route: '/e-shop/book/update', action: [app\Controller\BookController::class, 'update'])
        ->post(route: '/e-shop/book/userAction', action: [app\Controller\BookController::class, 'userAction'])
        ->post(route: '/e-shop/book/search', action: [app\Controller\BookController::class, 'search']);

    $result = $router->resolve();
    echo $result;
} catch (RouteNotFoundException $e) {
    header("HTTP/1.0 404 Not Found");
    echo "404 - Page Not Found";
}
