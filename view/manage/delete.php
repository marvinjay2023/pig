
<?php

if(!isset($_GET['pigno']) || empty($_GET['pigno'])) {
    
    header('location: /manage-pig');
} else {
    $pigno = (int)$_GET['pigno'];
    
    // Update the pig record to mark it as deleted instead of permanently deleting it
    $query = $db->prepare("UPDATE pigs SET is_deleted = 1 WHERE pigno = :pigno");
    $query->bindParam(':pigno', $pigno, PDO::PARAM_INT);

    if($query->execute()) {
        header('location: /manage-pig?message=deleted'); // Redirect with success message
    } else {
        header('location: /manage-pig?message=error'); // Handle error case
    }
}
?>
