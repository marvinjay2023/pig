<?php 

if (!isset($_SESSION['admin_id'])) {
    header('Location: /login'); 
    exit();
}

include 'theme/head.php';
include 'theme/sidebar.php';
?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>

  <?php include 'inc/data.php'; ?>

  <div class="w3-container" style="padding-top:22px">
    <div class="w3-row">

      <div class="content-wrapper">
        <!-- Weeks Container (Now Displayed Automatically) -->
        <div id="weeksContainer" class="weeks-container">
          <div class="box" style="border: 1px solid #ddd; padding: 20px; border-radius: 50px; background-color: #f9f9f9;">
            <?php
            // Get the current month name
            $currentMonth = date('F');
            echo "<h3>Reports for the month of $currentMonth</h3>";
            ?>
            <h4>Select a week:</h4>
            <div class="weeks-column">
                <?php
                // Generate clickable weeks for the current month in a column layout
                $weeks = ['Week 1', 'Week 2', 'Week 3', 'Week 4', ];
                foreach ($weeks as $index => $week) {
                    echo '<div class="week-item"><button class="week-btn" data-week="' . ($index + 1) . '">' . $week . '</button></div>';
                }
                ?>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>

<?php include 'theme/foot.php'; ?>

<script>
    // Redirect to week-specific page based on the selected week number
    var weekButtons = document.querySelectorAll('.week-btn');
    weekButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var weekNumber = this.getAttribute('data-week');
            if (weekNumber === '1') {
                window.location.href = '/week1';
            } else if (weekNumber === '2') {
                window.location.href = '/week2';
            } else if (weekNumber === '3') {
                window.location.href = '/week3';
             } else if (weekNumber === '4') {
                window.location.href = '/week4';
            } else {
                // For other weeks, redirect to weeky.php with the selected week number
                window.location.href = 'weeky.php?week=' + weekNumber;
            }
        });
    });
</script>

<!-- CSS for styling -->
<style>
    .content-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start; /* Changed to flex-start to align items at the top */
        height: 100vh;
        width: 100%;
        padding-top: 20px; /* Add some padding to the top */
    }

    .weeks-container {
        margin-top: 20px;
        text-align: center;
        width: 100%;
    }

    .weeks-column {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px; /* Space between buttons */
        width: 50%; /* Adjust the width of the container */
        margin: 0 auto;
    }

    .week-item {
        width: 100%; /* Ensure buttons take full width of the column */
    }

    .week-btn {
        width: 100%; /* Make the buttons fill the container */
        padding: 10px;
        background-color: #28a745;
        color: white;
        border: none;
        cursor: pointer;
        text-align: center;
    }

    .week-btn:hover {
        background-color: #218838;
    }

    .box {
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 50px; /* Fully rounded corners */
        background-color: #f9f9f9;
        margin: 0 auto;
        width: 80%; /* Adjust the width of the box */
        max-width: 600px;
    }
</style>

<?php include 'theme/foot.php'; ?>