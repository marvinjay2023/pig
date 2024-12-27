<?php 
include 'setting/system.php';
include 'theme/head.php';
include 'theme/sidebar.php';
include 'session.php';

// Ensure the user is logged in
if (!isset($_SESSION['admin_id'])) {
    die('Access Denied. Please log in.');
}

$admin_id = $_SESSION['admin_id']; // Get the logged-in admin's ID

// Handle form submission for adding quarantine data
if (isset($_POST['submit'])) {
    $name = $_POST['quarantine_name'];
    $description = $_POST['description'];

    // Insert quarantine data with admin_id
    $query = $db->prepare("INSERT INTO quarantine(name, description, admin_id) VALUES (:name, :description, :admin_id)");
    $query->execute([
        ':name' => $name,
        ':description' => $description,
        ':admin_id' => $admin_id
    ]);

    if ($query) {
        echo "<script>alert('Quarantine Added!')</script>";
        header('refresh: 1.5');
    }
}
?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">
    <!-- Header -->
    <header class="w3-container" style="padding-top:22px">
        <h5><b><i class="fa fa-dashboard"></i> Pig Management</b></h5>
    </header>

    <?php include 'inc/data.php'; ?>

    <div class="w3-container" style="padding-top:22px">
        <div class="w3-row">
            <h2>Quarantine List</h2>
            <div class="col-md-12">
                <a title="Check to delete from list" data-toggle="modal" data-target="#_remove" id="delete" class="btn btn-danger">
                    <i class="fa fa-trash"></i>
                </a>
                <form method="post" action="remove_quarantine.php">
                    <table class="table table-hover" id="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Pig No</th>
                                <th>Date quarantined</th>
                                <th>Breed</th>
                                <th>Vaccine</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch quarantine data for the logged-in admin only
                            $get = $db->prepare("SELECT * FROM quarantine WHERE admin_id = :admin_id");
                            $get->execute([':admin_id' => $admin_id]);
                            $res = $get->fetchAll(PDO::FETCH_OBJ);

                            foreach ($res as $n) { ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="selector[]" value="<?php echo $n->id ?>">
                                    </td>
                                    <td><?php echo $n->pigno; ?></td>
                                    <td><?php echo $n->date; ?></td>
                                    <td><?php echo $n->breed; ?></td>
                                    <td><?php echo $n->vaccine; ?></td>
                                    <td><?php echo $n->reason; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <?php include('inc/modal-delete.php'); ?>
                </form>
            </div>
        </div>
    </div>

    <!-- Print Button (aligned right) -->
    <div style="text-align: right; margin-top: 20px;">
        <button onclick="printTableData()" class="btn btn-primary">Print</button>
    </div>
</div>

<?php include 'theme/foot.php'; ?>

<!-- Add custom styles -->
<style>
table {
    width: 100%;
    border-collapse: collapse;
    background-color: white; /* Set table background to white */
}

th, td {
    border: 1px solid black; /* Black borders */
    padding: 8px;
    text-align: center; /* Center text in table cells */
    color: black; /* Set text color to black */
}

th {
    background-color: #f2f2f2; /* Header background */
}

tr:nth-child(even) {
    background-color: #f9f9f9; /* Light background for even rows */
}

/* Hide table controls */
.dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_length {
    display: none;
}
</style>

<!-- Print Table Script -->
<script>
function printTableData() {
    var printContent = document.querySelector('#table').outerHTML;

    var printStyles = `
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
            color: black;
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
    newWindow.document.write('<h2>Quarantine List</h2>'); // Optional title for printed page
    newWindow.document.write(printContent);  // Include the table content
    newWindow.document.write('</body></html>');
    newWindow.document.close();
    newWindow.print();
}
</script>
