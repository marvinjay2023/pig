<?php 

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [
    '/' => 'view/index.view.php',
    '/login' => 'view/login.view.php',
    '/signin' => 'view/signin.view.php',

    '/manage-pig' => 'view/manage/pig.php',
    '/manage-quarantine' => 'view/manage/quarantine.php',
    '/manage-breed' => 'view/breed.view.php',
    '/delete-breed' => 'view/manage/delete-breed.php',

    '/add-pig' => 'view/manage/add.php',
    '/edit-pig' => 'view/manage/edit.php',
    '/delete-pig' => 'view/manage/delete.php',
    '/delete-pig' => 'view/manage/delete.php',
    
    '/quarantine' => 'view/quarantine.view.php',
    '/remove-quarantine' => 'view/manage/remove-quarantine.php',

    '/monitor' => 'view/monitor.view.php',

    '/sold' => 'view/sold.view.php',

    '/data' => 'view/data.view.php',

    '/report' => 'view/report.view.php',
    '/week1' => 'view/week1.view.php',
    '/week2' => 'view/week2.view.php',
    '/week3' => 'view/week3.view.php',
    '/week4' => 'view/week4.view.php',
];

if(array_key_exists($uri, $routes)){
    require $routes[$uri];
}