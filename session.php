<?php 

// Check if the user is logged in and if the required session variables are set
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['user'])) {
    header('location: /login'); // Redirect to login page if session variables are missing
    die;
}

// Now you can safely use $_SESSION['admin_id'], $_SESSION['user'], and $_SESSION['group_id']
// For example, use $_SESSION['group_id'] to filter data based on the admin's group
?>