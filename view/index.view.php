<?php  
//session_start();

if (!isset($_SESSION['id'])) {
    header('Location: /login'); 
    exit();
}

include 'theme/head.php';
include 'theme/sidebar.php';
//include 'session.php';




?>
<div class="w3-main" style="margin-left:300px;margin-top:43px;">
  <header class="w3-container" style="padding-top:22px;">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>

  <?php include 'inc/data.php'; ?>
  
  <!-- Notification Icon (Top Right) -->
  <div class="notification-container">
    <button id="notificationBtn" class="w3-button w3-circle w3-red">
        <i class="fa fa-bell"></i>
    </button>
    <div id="notification" class="w3-container w3-card-4 w3-hide">
        <p><strong>Warning!</strong> The environment is exceeding normal temperature or humidity levels.</p>
        <p id="notification-content">No issues detected.</p>
    </div>
  </div>

  <div class="w3-container" style="padding-top:22px;">
    <div class="w3-row">
      <h2>Recent Pigs</h2>
      <div class="table-responsive">
        <table class="table table-hover" id="table">
          <thead>
            <tr>
              <th>Pig No.</th>
              <th>Breed</th>
              <th>Weight</th>
              <th>Gender</th>
              <th>Date</th>
              <th>Desc.</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $admin_id = $_SESSION['admin_id'];

            $recent_pigs = $db->prepare("
                SELECT p.*, b.name AS breed_name 
                FROM pigs p
                LEFT JOIN breed b ON p.breed_id = b.id
                WHERE p.admin_id = ? AND p.is_deleted = 0
                ORDER BY p.date DESC, p.pigno DESC
                LIMIT 5
            ");
            $recent_pigs->execute([$admin_id]);
            $pigs = $recent_pigs->fetchAll(PDO::FETCH_OBJ);
            
            if ($pigs) {
                foreach ($pigs as $pig) {
                    echo "<tr>
                        <td>{$pig->pigno}</td>
                        <td>{$pig->breed_name}</td>
                        <td>{$pig->weight}</td>
                        <td>{$pig->gender}</td>
                        <td>{$pig->date}</td>
                        <td>{$pig->remark}</td>
                        <td>Active</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No recent records found.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>

      <!-- Print Button -->
      <div class="print-container">
        <button onclick="printTable()" class="w3-button w3-blue">Print</button>
      </div>
    </div>
  </div>
</div>

<!-- Notification Pop-up Modal -->
<div id="notificationModal" class="w3-modal">
  <div class="w3-modal-content">
    <span onclick="document.getElementById('notificationModal').style.display='none'" class="w3-button w3-display-topright">&times;</span>
    <h3>Environmental Warning</h3>
    <p id="modal-content">No critical warnings.</p>
  </div>
</div>

<script>
    // Function to check if temperature or humidity exceeds normal levels
    function checkEnvironment() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'data.php', true);  // This is the updated data source
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    var temperature = data.temperature;
                    var humidity = data.humidity;
                    var normalTemperatureRange = { min: 20, max: 30 };
                    var normalHumidityRange = { min: 30, max: 70 };

                    if (temperature < normalTemperatureRange.min || temperature > normalTemperatureRange.max || 
                        humidity < normalHumidityRange.min || humidity > normalHumidityRange.max) {
                        document.getElementById('notification').classList.remove('w3-hide');
                        document.getElementById('notification-content').innerHTML = `Temperature: ${temperature}°C, Humidity: ${humidity}%`;
                    }
                } catch (e) {
                    console.error("Error parsing response: ", e);
                }
            }
        };
        xhr.send();
    }

    // Click event for the notification icon
    document.getElementById('notificationBtn').onclick = function() {
        var modalContent = document.getElementById('notification-content').innerHTML;
        document.getElementById('modal-content').innerHTML = modalContent;
        document.getElementById('notificationModal').style.display = 'block';
    }

    // Close the modal when clicked
    window.onclick = function(event) {
        if (event.target == document.getElementById('notificationModal')) {
            document.getElementById('notificationModal').style.display = 'none';
        }
    }

    // Fetch the data and check for environmental conditions every 5 seconds
    setInterval(checkEnvironment, 5000);

    // Function to print the table
    function printTable() {
        
        var printWindow = window.open('', '', 'height=600,width=800');
        var tableContent = document.querySelector('#table').outerHTML;

        printWindow.document.write('<html><head><title>Print</title>');
        printWindow.document.write('<style>table {width: 100%; border-collapse: collapse;} th, td {border: 1px solid black; padding: 8px; text-align: center;} th {background-color: #f2f2f2;} </style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(tableContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>

<style>
    /* Notification Icon and Pop-up Styling */
    .notification-container {
        position: fixed;
        top: 60px;
        right: 20px;
        z-index: 100;
    }

    .notification-container button {
        font-size: 24px;
    }

    #notification {
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border-radius: 5px;
        display: none;
        position: absolute;
        top: 30px;
        right: 0;
        z-index: 10;
    }
</style>

<?php include 'theme/foot.php'; ?>
