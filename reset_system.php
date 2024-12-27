<?php
session_start();
include 'setting/system.php';

// Check if the logged-in user is an admin
if (isset($_SESSION['id']) && $_SESSION['id'] == 1) { // Assuming admin has id = 1
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $db->query("DELETE FROM admin WHERE id != 1");
        $db->query("DELETE FROM breed WHERE user_id != 1");
        $db->query("DELETE FROM quarantine WHERE user_id != 1");
        $db->query("DELETE FROM weekly_data WHERE user_id != 1");
        echo "System reset successful.";
    }
} else {
    echo "You must be logged in as the admin to reset the system.";
}
?>

<form method="post">
    <button type="submit" class="btn btn-danger">Reset System</button>
</form>
