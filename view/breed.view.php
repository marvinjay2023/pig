<?php 
include 'theme/head.php';
include 'theme/sidebar.php';

if (!isset($_SESSION['id'])) {
  header('Location: /login'); 
  exit();
}
?>

<?php 
if (isset($_POST['submit'])) {
    $name = $_POST['breed'];
    $admin_id = $_SESSION['admin_id']; // Use the correct session key for admin's ID

    // Insert the breed with the admin_id
    $query = $db->query("INSERT INTO breed (name, admin_id) VALUES ('$name', '$admin_id')");
    if ($query) { ?>
        <script>alert('Breed Added. Click OK to close dialogue.')</script>
        <?php 
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
        <h2>Pig Breeds</h2>
        <div class="col-md-6">
            <a title="Check to delete from list" data-toggle="modal" data-target="#_removed" id="delete" class="btn btn-danger"><i class="fa fa-trash"></i></a>
            <form method="post" action="/delete-breed">
            <table class="table table-hover table-bordered" id="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $admin_id = $_SESSION['admin_id']; // Use the correct session key for admin's ID
                    $get = $db->query("SELECT * FROM breed WHERE admin_id = '$admin_id'"); // Only show breeds belonging to this admin
                    $res = $get->fetchAll(PDO::FETCH_OBJ);
                    $counter = 1; // Initialize a counter for numbering
                    foreach ($res as $n) { ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="selector[]" value="<?php echo $n->id ?>">
                            </td>
                            <td><?php echo $counter; ?></td> <!-- Display the counter instead of ID -->
                            <td><?php echo $n->name; ?></td>
                        </tr> 
                        <?php $counter++; // Increment the counter for the next row
                    }
                    ?>
                </tbody>
            </table>
                <div id="_removed" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                <h3 class="modal-title">Remove From Breed List ?</h3>
                                </div>

                            <div class="modal-body">
                                <div class="alert alert-danger">
                                    <p>Are you sure you want to remove this Breed from the list?.</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> Close</button>
                                <button name="removed" class="btn btn-danger"><i class="fa fa-check"></i> Yes</button>
                            </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>

        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Add New Breed</div>
                <div class="panel-body">
                    <form method="post">
                        <div class="form-group">
                            <label class="control-label">Breed Name</label>
                            <input type="text" name="breed" class="form-control" placeholder="Enter breed name">
                        </div>
                        <button class="btn btn-sm btn-default" type="submit" name="submit">Add</button>
                    </form>
                </div>
            </div>
        </div>
     </div>
</div>

<?php include base_path('/view/theme/foot.php'); ?>

<style>
/* General table styling */
table {
    width: 100%;
    border-collapse: collapse;
    background-color: white; /* Set table background to white */
    color: black; /* Set table text color to black */
    text-align: center; /* Center the text */
}

th, td {
    border: 1px solid black; /* Set cell borders to black */
    padding: 8px;
    text-align: center; /* Center text in table cells */
}

th {
    background-color: #f2f2f2; /* Light gray header background for contrast */
    color: black; /* Set header text color to black */
}

/* Style for the input checkbox in the table */
input[type="checkbox"] {
    margin: 0;
}

/* Modal Delete Button Styling */
#delete {
    margin-bottom: 10px;
}

/* Form and button styling */
.panel-primary {
    border-color: #337ab7;
}

.panel-heading {
    background-color: #337ab7;
    color: white;
}

.panel-body {
    background-color: white;
}

.form-control {
    width: 100%;
}

button[type="submit"] {
    background-color: #337ab7;
    color: white;
    border: none;
}

button[type="submit"]:hover {
    background-color: #286090;
}

/* Style the modal delete link */
#delete {
    font-size: 16px;
}
</style>
