<?php 
include 'db.php';

// System Settings
define('NAME_', 'PIG FARM');
define('NAME_X', 'Pig Farming');

// Start output buffering
ob_start();

// Check if a session is already active before starting it
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function dd($value){

    echo '<pre>';
    var_dump($value);
    echo '</pre>';

    die;
}

function base_path($path){

    return BASE_PATH.$path;

}

