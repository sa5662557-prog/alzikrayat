<?php

require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/PhotoController.php';
require_once __DIR__ . '/../controllers/CommentController.php';

$router = new Router();
$router->add(
    'GET',
    '/',
    ['HomeController', 'index']
);
$router->add(
    'GET',
    '/auth',
    ['AuthController', 'showAuth']
);
$router->add(
    'GET',
    '/auth/register',
    ['AuthController', 'showRegister']
);
$router->add(
    'POST',
    '/auth/register',
    ['AuthController', 'register']
);

$router->add(
    'POST',
    '/auth/login',
    ['AuthController', 'login']
);

$router->add(
    'GET',
    '/auth/logout',
    ['AuthController', 'logout']
);
$router->add(
    'GET',
    '/photos',
    ['PhotoController', 'index']
);
$router->add(
    'GET',
    '/photos/create',
    ['PhotoController', 'create']
);
$router->add(
    'POST',
    '/photos/store',
    ['PhotoController', 'store']
);
$router->add(
    'GET',
    '/photos/{id}',
    ['PhotoController', 'show']
);
$router->add(
    'GET',
    '/photos/{id}/edit',
    ['PhotoController', 'edit']
);

$router->add(
    'POST',
    '/photos/{id}/update',
    ['PhotoController', 'update']
);
$router->add(
    'POST',
    '/photos/{id}/delete',
    ['PhotoController', 'delete']
);
$router->add(
    'POST',
    '/photos/{id}/comments',
    ['CommentController', 'store']
);
$requestMethod = $_SERVER['REQUEST_METHOD'];

$requestPath = parse_url(
    $_SERVER['REQUEST_URI'],
    PHP_URL_PATH
);

$basePath = '/alzikrayat/public';

if (strpos($requestPath, $basePath) === 0) {
    $requestPath = substr(
        $requestPath,
        strlen($basePath)
    );
}

if ($requestPath === '') {
    $requestPath = '/';
}

$router->dispatch(
    $requestMethod,
    $requestPath
);