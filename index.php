<?php

declare(strict_types=1);

use app\Utils\Router;
use app\Exception\RouteNotFoundException;

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';

try {
    $router = new Router();

    $router->get(route: '/e-shop/', action: [app\Controller\HomeController::class, 'index'])
        ->get(route: '/e-shop/users', action: [app\Controller\UserController::class, 'index'])
        ->post(route: '/e-shop/users/login', action: [app\Controller\UserController::class, 'login'])
        ->get(route: '/e-shop/users/logout', action: [app\Controller\UserController::class, 'logout'])
        ->post(route: '/e-shop/users/register', action: [app\Controller\UserController::class, 'register'])
        ->get(route: '/e-shop/cart', action: [app\Controller\CartController::class, 'index'])
        ->post(route: '/e-shop/cart/createOrder', action: [app\Controller\CartController::class, 'createOrder'])
        ->post(route: '/e-shop/cart/deleteCartItem', action: [app\Controller\CartController::class, 'deleteCartItem'])
        ->post(route: '/e-shop/cart/updateCartItem', action: [app\Controller\CartController::class, 'updateCartItem'])
        ->get(route: '/e-shop/books', action: [app\Controller\BookController::class, 'index'])
        ->post(route: '/e-shop/books/addToCart', action: [app\Controller\BookController::class, 'addToCart'])
        ->get(route: '/e-shop/books/create', action: [app\Controller\BookController::class, 'create'])
        ->post(route: '/e-shop/books/store', action: [app\Controller\BookController::class, 'store'])
        ->get(route: '/e-shop/books/edit', action: [app\Controller\BookController::class, 'edit'])
        ->post(route: '/e-shop/books/update', action: [app\Controller\BookController::class, 'update'])
        ->post(route: '/e-shop/books/userAction', action: [app\Controller\BookController::class, 'userAction'])
        ->post(route: '/e-shop/books/search', action: [app\Controller\BookController::class, 'search']);

    $result = $router->resolve();
    echo $result;
} catch (RouteNotFoundException $e) {
    header("HTTP/1.0 404 Not Found");
    echo "404 - Page Not Found";
}
