<?php 
include 'theme/head.php';
include 'theme/sidebar.php';

?>    


<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
  </header>

  <div class="w3-container" style="padding-top:22px">
     <h2>Week 1 Data</h2>

     <div class="table-responsive">
        <table class="table table-hover table-striped" id="table" style="background-color: white; border: 1px solid black;">
          <thead>
            <tr>
                <th>Date</th>
                <th>Total Pigs Added</th>
                <th>Pigs Quarantined</th>
                <th>Pigs Vaccinated</th>
            </tr>
          </thead>
          <tbody>
            <?php
              // Fetch the admin_id of the logged-in admin from the session
              $admin_id = $_SESSION['admin_id'];

              // Set the date range for the first week of the current month
              $start_date = date('Y-m-01'); // Start of the current month
              $end_date = date('Y-m-07'); // End of the first week of the current month

              // Get the count of total pigs added each day within the week
              $pig_query = $db->prepare("SELECT date, COUNT(*) as total_pigs FROM pigs 
                                         WHERE date BETWEEN :start_date AND :end_date 
                                         AND admin_id = :admin_id
                                         GROUP BY date");
              $pig_query->execute([':start_date' => $start_date, ':end_date' => $end_date, ':admin_id' => $admin_id]);
              $pig_result = $pig_query->fetchAll(PDO::FETCH_OBJ);

              // Get the count of pigs quarantined each day within the week
              $quarantine_query = $db->prepare("SELECT date, COUNT(*) as pigs_quarantined FROM quarantine 
                                                WHERE date BETWEEN :start_date AND :end_date 
                                                AND admin_id = :admin_id
                                                GROUP BY date");
              $quarantine_query->execute([':start_date' => $start_date, ':end_date' => $end_date, ':admin_id' => $admin_id]);
              $quarantine_result = $quarantine_query->fetchAll(PDO::FETCH_OBJ);

              // Get the count of pigs vaccinated each day within the week
              $vaccine_query = $db->prepare("SELECT date, COUNT(*) as pigs_vaccinated FROM quarantine 
                                             WHERE vaccine IS NOT NULL 
                                             AND date BETWEEN :start_date AND :end_date 
                                             AND admin_id = :admin_id
                                             GROUP BY date");
              $vaccine_query->execute([':start_date' => $start_date, ':end_date' => $end_date, ':admin_id' => $admin_id]);
              $vaccine_result = $vaccine_query->fetchAll(PDO::FETCH_OBJ);

              // Merge data by date
              $merged_data = [];
              
              foreach ($pig_result as $pig_data) {
                  $merged_data[$pig_data->date] = [
                      'total_pigs' => $pig_data->total_pigs,
                      'pigs_quarantined' => 0,
                      'pigs_vaccinated' => 0
                  ];
              }

              foreach ($quarantine_result as $quarantine_data) {
                  if (!isset($merged_data[$quarantine_data->date])) {
                      $merged_data[$quarantine_data->date] = [
                          'total_pigs' => 0,
                          'pigs_quarantined' => $quarantine_data->pigs_quarantined,
                          'pigs_vaccinated' => 0
                      ];
                  } else {
                      $merged_data[$quarantine_data->date]['pigs_quarantined'] = $quarantine_data->pigs_quarantined;
                  }
              }

              foreach ($vaccine_result as $vaccine_data) {
                  if (!isset($merged_data[$vaccine_data->date])) {
                      $merged_data[$vaccine_data->date] = [
                          'total_pigs' => 0,
                          'pigs_quarantined' => 0,
                          'pigs_vaccinated' => $vaccine_data->pigs_vaccinated
                      ];
                  } else {
                      $merged_data[$vaccine_data->date]['pigs_vaccinated'] = $vaccine_data->pigs_vaccinated;
                  }
              }

              // Display merged data in the table
              foreach ($merged_data as $date => $data) {
                  echo "<tr>";
                  echo "<td>" . $date . "</td>";
                  echo "<td>" . $data['total_pigs'] . "</td>";
                  echo "<td>" . $data['pigs_quarantined'] . "</td>";
                  echo "<td>" . $data['pigs_vaccinated'] . "</td>";
                  echo "</tr>";
              }
            ?>
          </tbody>
        </table>

        <!-- Print Button -->
        <div style="text-align: right; margin-top: 20px;">
            <button onclick="printTableData()" class="btn btn-primary">Print Table</button>
        </div>

        <script>
        function printTableData() {
            var printContent = document.querySelector('#table').outerHTML;
            var printStyles = `
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                    background-color: white;
                    color: black;
                }
                th, td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: center;
                }
                th {
                    background-color: #f2f2f2;
                }
                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
            </style>
            `;

            var newWindow = window.open('', '', 'width=800, height=600');
            newWindow.document.write('<html><head><title>Print Table</title>');
            newWindow.document.write(printStyles);  // Include the table styles
            newWindow.document.write('</head><body>');
            newWindow.document.write('<h2>Weekly Data</h2>'); // Optional title for printed page
            newWindow.document.write(printContent);  // Include the table content
            newWindow.document.write('</body></html>');
            newWindow.document.close();
            newWindow.print();
            newWindow.close();
        }
        </script>
     </div>
  </div>

<?php include 'theme/foot.php'; ?>
