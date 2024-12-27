<?php  
include 'setting/system.php';
include 'theme/head.php';
include 'theme/sidebar.php';
include 'session.php'; // session_start() should already be handled here

// Connect to the database "pig"
try {
    $db = new PDO('mysql:host=localhost;dbname=pig;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get the logged-in admin's group_id and admin_id from the session
$admin_id = $_SESSION['admin_id'];

// Process the "sold" action if a pigno is provided
if (isset($_GET['pigno'])) {
    $pigno = $_GET['pigno'];

    // Check for duplicate entry in sold_pigs table
    $checkDuplicate = $db->prepare("SELECT COUNT(*) FROM sold_pigs WHERE pigno = ?");
    $checkDuplicate->execute([$pigno]);

    if ($checkDuplicate->fetchColumn() > 0) {
        die("Error: Pig with this number is already sold!");
    }

    // Fetch the pig's data
    $pig = $db->query("SELECT * FROM pigs WHERE pigno = '$pigno' AND is_deleted = 0")->fetch(PDO::FETCH_OBJ);

    if ($pig) {
        // Move data to 'sold_pigs' table, including group_id
        $insertSold = $db->prepare("INSERT INTO sold_pigs (pigno, breed_id, weight, gender, health_status, date, remark, img, admin_id) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insertSold->execute([
            $pig->pigno,
            $pig->breed_id,
            $pig->weight,
            $pig->gender,
            $pig->health_status,
            $pig->date,
            $pig->remark,
            $pig->img,
            $admin_id // Add admin_id when inserting
        ]);

        if ($insertSold) {
            // Remove the pig from the 'pigs' table
            $db->query("DELETE FROM pigs WHERE pigno = '$pigno'");
        }
    }
}

// Fetch all sold pigs for the logged-in admin (filtered by admin_id)
$sold_pigs = $db->query("SELECT * FROM sold_pigs WHERE admin_id = '$admin_id' ORDER BY pigno ASC")->fetchAll(PDO::FETCH_OBJ);
?>

<div class="w3-main" style="margin-left:300px;margin-top:43px;">
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Sold Pigs</b></h5>
  </header>

  <div class="w3-container" style="padding-top:22px">
    <h2>Sold Pigs</h2>
    <div class="table-responsive">
      <table class="table table-hover table-striped" id="table">
        <thead>
          <tr>
            <th>Pig No.</th>
            <th>Breed</th>
            <th>Weight</th>
            <th>Gender</th>
            <th>Health Status</th>
            <th>Date</th>
            <th>Desc.</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($sold_pigs as $data) { 
              $get_breed = $db->query("SELECT * FROM breed WHERE id = '$data->breed_id'");
              $breed_result = $get_breed->fetch(PDO::FETCH_OBJ);
          ?>
            <tr>
              <td><?php echo $data->pigno; ?></td>
              <td><?php echo $breed_result->name; ?></td>
              <td><?php echo $data->weight; ?></td>
              <td><?php echo $data->gender; ?></td>
              <td><?php echo $data->health_status; ?></td>
              <td><?php echo $data->date; ?></td>
              <td><?php echo wordwrap($data->remark, 300, '<br>'); ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <button id="printButton" style="margin-top: 10px;" onclick="printTable()">Print Table</button>
    </div>
  </div>
</div>

<script>
function printTable() {
    var printContents = document.getElementById('table').outerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = '<html><head><title>Print</title></head><body>' + printContents + '</body></html>';
    window.print();
    document.body.innerHTML = originalContents;
}
</script>

<?php include 'theme/foot.php'; ?>

<style>
/* Table and image styling */
table {
    width: 100%;
    border-collapse: collapse;
    color: black;
    text-align: center;
}

th, td {
    border: 1px solid black;
    padding: 8px;
    text-align: center;
}

th {
    background-color: #f2f2f2;
    color: black;
}

button#printButton {
    display: block;
    margin: 0 auto;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

button#printButton:hover {
    background-color: #45a049;
}
</style>
