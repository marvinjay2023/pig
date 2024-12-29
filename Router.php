<?php 

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [
    '/' => 'view/index.view.php',
    '/login' => 'view/login.view.php',
    '/signin' => 'view/signin.view.php',

    '/manage-pig' => 'view/manage/pig.php',
    '/manage-quarantine' => 'view/manage/quarantine.php',
    '/manage-breed' => 'view/manage/breed.php',
];

if(array_key_exists($uri, $routes)){
    require $routes[$uri];
}