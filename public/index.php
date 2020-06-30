<?php

require_once '../vendor/autoload.php';

session_start();

$router = new AltoRouter();

if($_SESSION){
    echo 'Bonjour ' . $_SESSION['connectedUser']->getFirstname();
}

if (array_key_exists('BASE_URI', $_SERVER)) {

    $router->setBasePath($_SERVER['BASE_URI']);

}
else {
    $_SERVER['BASE_URI'] = '/';
}

$router->map(
    'GET',
    '/login',
    [
        'method' => 'login',
        'controller' => '\App\Controllers\UserController'
    ],
    'login'
);

$router->map(
    'POST',
    '/login',
    [
        'method' => 'loginPost',
        'controller' => '\App\Controllers\UserController'
    ],
    'login-post'
);

$router->map(
    'GET',
    '/logout',
    [
        'method' => 'logout',
        'controller' => '\App\Controllers\UserController'
    ],
    'logout'
);

$router->map(
    'GET',
    '/users/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\UserController'
    ],
    'users-list'
);

$router->map(
    'GET',
    '/users/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-add'
);

$router->map(
    'POST',
    '/users/add',
    [
        'method' => 'addPost',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-add-post'
);

$router->map(
    'GET',
    '/users/update[i:userId]',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-update'
);


$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => '\App\Controllers\MainController'
    ],
    'main-home'
);

$router->map(
    'GET',
    '/category/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'categories-list'
);

$router->map(
    'GET',
    '/category/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\CategoryController',
    ],
    'category-add'
);

$router->map(
    'POST',
    '/category/add',
    [
        'method' => 'addPost',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-add-post'
);

$router->map(
    'GET',
    '/category/update/[i:categoryId]',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-update'
);

$router->map(
    'POST',
    '/category/update/[i:categoryId]',
    [
        'method' => 'updatePost',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-update-post'
);


$router->map(
    'GET',
    '/category/delete/[i:categoryId]',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-delete'
);

$router->map(
    'GET',
    '/product/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-list'
);

$router->map(
    'GET',
    '/product/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-add'
);

$router->map(
    'POST',
    '/product/add',
    [
        'method' => 'addPost',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-add-post'
);

$router->map(
    'GET',
    '/product/update/[i:productId]',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-update'
);

$router->map(
    'POST',
    '/product/update/[i:productId]',
    [
        'method' => 'updatePost',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-update-post'
);

$match = $router->match();

//Dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');
// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();