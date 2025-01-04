<?php

// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Replace with the actual admin ID from the session
// Ensure the admin logs in and their ID is stored in the session during login
$adminId = $_SESSION['admin_id'];

// Check if admin ID is available
if (!isset($adminId)) {
    die("Access Denied. Admin not logged in.");
}

// Database connection setup (ensure proper credentials)
try {
    $db = new PDO('mysql:host=localhost;dbname=pig', 'root', 'admin123'); // Update credentials accordingly
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Query counts filtered by admin ID
$pCount = $uCount = $bCount = $qCount = $sCount = '';

$query = $db->prepare("SELECT * FROM pigs WHERE admin_id = ?");
$query->execute([$adminId]);
$pCount = $query->rowCount();

$quer = $db->prepare("SELECT * FROM breed WHERE admin_id = ?");
$quer->execute([$adminId]);
$bCount = $quer->rowCount();

$que = $db->prepare("SELECT * FROM quarantine WHERE admin_id = ?");
$que->execute([$adminId]);
$qCount = $que->rowCount();

$qu = $db->prepare("SELECT * FROM admin WHERE admin_id = ?");
$qu->execute([$adminId]);
$uCount = $qu->rowCount();

// Count sold pigs
$soldQuery = $db->prepare("SELECT * FROM sold_pigs WHERE admin_id = ?");
$soldQuery->execute([$adminId]);
$sCount = $soldQuery->rowCount();
?>

<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-padding-16" style="background-color: black; color: white; border-radius: 15px;">
        <div class="w3-left"><i class="fa fa-list w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $pCount; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Pig No.</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-padding-16" style="background-color: black; color: white; border-radius: 15px;">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $qCount; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Quarantine No.</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-padding-16" style="background-color: black; color: white; border-radius: 15px;">
        <div class="w3-left"><i class="fa fa-list w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $bCount; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Breeds No.</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-padding-16" style="background-color: black; color: white; border-radius: 15px;">
        <div class="w3-left"><i class="fa fa-list w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $sCount; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Sold No.</h4>
      </div>
    </div>
</div>
