<?php include 'setting/system.php'; ?> 
<?php include 'theme/head.php'; ?> 
<?php include 'theme/sidebar.php'; ?> 
<?php include 'session.php'; ?>

<div class="w3-main" style="margin-left:300px;margin-top:43px;">
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Pig Management > Add</b></h5>
  </header>

  <?php include 'inc/data.php'; ?>

  <div class="w3-container" style="padding-top:22px">
    <div class="w3-row">
      
      <div class="col-md-6">
        <!-- Box styling -->
        <div class="box" style="border: 1px solid #ddd; padding: 20px; border-radius: 5px; background-color: #f9f9f9;">
          <h2 style="text-align: center;">Add New Pig</h2>

          <?php
          if (isset($_POST['submit'])) {
              if (isset($_FILES['pigphoto']['tmp_name'])) {
                  $n_pigno = $_POST['pigno'];
                  $n_weight = $_POST['weight'];
                  $n_date = $_POST['date'];
                  $n_breed = $_POST['breed'];
                  $n_remark = $_POST['remark'];
                  $n_status = $_POST['status'];
                  $n_gender = $_POST['gender'];

                  // Get the logged-in admin ID
                  $admin_id = $_SESSION['id'];

                  $res1_name = basename($_FILES['pigphoto']['name']);
                  $tmp_name = $_FILES['pigphoto']['tmp_name'];
                  $max_size = 2097152; // 2MB limit

                  if (isset($res1_name)) {
                      $location = 'uploadfolder/';
                      $move = move_uploaded_file($tmp_name, $location . $res1_name);
                      $path1 = $location . $res1_name;
                      if (!$move) {
                          $fileerror = $_FILES['pigphoto']['error'];
                          $message = $upload_errors[$fileerror];
                      }
                  }
              }

              // Insert the pig into the database including the admin_id
              $insert = $db->query("INSERT INTO pigs(pigno, weight, date, breed_id, remark, health_status, img, gender, admin_id) 
                                    VALUES('$n_pigno', '$n_weight', '$n_date', '$n_breed', '$n_remark', '$n_status', '$path1', '$n_gender', '$admin_id')");

              if ($insert) { 
                  // Redirect to manage-pig.php after successful addition
                  header("Location: manage-pig.php");
                  exit;
              } else { ?>
                  <div class="alert alert-danger alert-dismissable">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Error creating pig data. Please try again <i class="fa fa-times"></i></strong>
                  </div>
              <?php }
          }
          ?>

          <!-- Form for adding a new pig -->
          <form method="post" autocomplete="off" enctype="multipart/form-data">
            
            <div class="form-group">
              <label class="control-label">Pig Number</label>
              <input type="text" name="pigno" class="form-control" required placeholder="Enter Pig No.">
            </div>

            <div class="form-group">
              <label class="control-label">Pig Weight</label>
              <input type="text" name="weight" class="form-control" required placeholder="Pig Weight">
            </div>

            <div class="form-group date" data-provide="datepicker">
              <label class="control-label">Arrival Date</label>
              <input type="text" name="date" class="form-control" required placeholder="Date">
            </div>

            <div class="form-group">
              <label class="control-label">Gender</label>
              <select name="gender" class="form-control" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </div>

            <div class="form-group">
              <label class="control-label">Health Status</label>
              <select name="status" class="form-control" required>
                <option value="" disabled selected>Select Health Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="on treatment">On Treatment</option>
                <option value="sick">Sick</option>
              </select>
            </div>

            <div class="form-group">
              <label class="control-label">Breed</label>
              <select name="breed" class="form-control" required>
                <option value="" disabled selected>Select Breed</option>
                <?php
                $getBreed = $db->query("SELECT * FROM breed");
                $res = $getBreed->fetchAll(PDO::FETCH_OBJ);
                foreach ($res as $r) { ?>
                  <option value="<?php echo $r->id; ?>"><?php echo $r->name; ?></option>
                <?php } ?>
              </select>
            </div>

            <div class="form-group">
              <label class="control-label">Description</label>
              <textarea class="form-control" name="remark" required placeholder="Description"></textarea>
            </div>

            <div class="form-group">
              <label class="control-label">Pig Photo</label>
              <input type="file" name="pigphoto" class="form-control" required>
            </div>

            <button name="submit" type="submit" class="btn btn-sn" style="background-color: #007bff; color: white;">Add Pig</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'theme/foot.php'; ?>
