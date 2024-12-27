<?php include 'setting/system.php'; ?> 
<?php include 'theme/head.php'; ?>
<?php include 'theme/sidebar.php'; ?>
<?php include 'session.php'; ?>

<?php 
if (!isset($_GET['pigno']) || empty($_GET['pigno'])) {
    header('location: manage-pig.php');
    exit;
} else {
    $pigno = $weight = $gender = $remark = $arr = $bname = $b_id = $health = $img = "";
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Safely get id
    $pigno = $_GET['pigno']; // Ensure pigno is set

    // Ensure only pigs from the logged-in admin are fetched
    $admin_id = $_SESSION['id']; // Get the logged-in admin ID

    $query = $db->query("SELECT * FROM pigs WHERE pigno = '$pigno' AND admin_id = '$admin_id'");
    $fetchObj = $query->fetchAll(PDO::FETCH_OBJ);

    if (count($fetchObj) > 0) {
        foreach ($fetchObj as $obj) {
            $pigno = $obj->pigno;
            $weight = $obj->weight;
            $gender = $obj->gender;
            $remark = $obj->remark;
            $date = $obj->date;
            $b_id = $obj->breed_id; // Ensure breed_id is used correctly
            $health = $obj->health_status;
            $img = $obj->img;

            // Fetch breed by ID
            $k = $db->query("SELECT * FROM breed WHERE id = '$b_id'"); 
            $ks = $k->fetchAll(PDO::FETCH_OBJ);
            foreach ($ks as $r) {
                $bname = $r->name;
            }
        }
    } else {
        // Redirect if the pig is not found or belongs to another admin
        header('Location: manage-pig.php');
        exit;
    }
}
?>

<div class="w3-main" style="margin-left:300px;margin-top:43px;">
    <header class="w3-container" style="padding-top:22px">
        <h5><b><i class="fa fa-dashboard"></i> Pig Management > Edit Pig</b></h5>
    </header>

    <?php include 'inc/data.php'; ?>

    <div class="w3-container" style="padding-top:22px">
        <div class="w3-row">
            <div class="col-md-6">
                <!-- Box styling -->
                <div class="box" style="border: 1px solid #ddd; padding: 20px; border-radius: 5px; background-color: #f9f9f9;">
                    <h2 style="text-align: center;">Edit Pig</h2>

                    <?php
                    if (isset($_POST['submit'])) {
                        $n_pigno = $_POST['pigno'];
                        $n_weight = $_POST['weight'];
                        $n_date = $_POST['date'];
                        $n_breed = $_POST['breed'];
                        $n_remark = $_POST['remark'];
                        $n_status = $_POST['status'];

                        // Ensure the update is only performed by the admin who owns the pig
                        $update_query = $db->query("UPDATE pigs SET pigno = '$n_pigno', weight = '$n_weight', date = '$n_date', breed_id = '$n_breed', remark = '$n_remark', health_status = '$n_status' WHERE pigno = '$n_pigno' AND admin_id = '$admin_id'");

                        if ($update_query) {
                            echo '<div class="alert alert-success alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Pig details successfully updated <i class="fa fa-check"></i></strong>
                                  </div>';
                        } else {
                            echo '<div class="alert alert-danger alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error updating pig data. Please try again <i class="fa fa-times"></i></strong>
                                  </div>';
                        }
                    }
                    ?>

                    <!-- Form for editing pig details -->
                    <form method="post">
                        <div class="form-group">
                            <label class="control-label">Pig No.</label>
                            <input type="text" name="pigno" class="form-control" value="<?php echo htmlspecialchars($pigno); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Pig Weight</label>
                            <input type="text" name="weight" class="form-control" value="<?php echo htmlspecialchars($weight); ?>" placeholder="80.00">
                        </div>

                        <div class="form-group date" data-provide="datepicker">
                            <label class="control-label">Arrival Date</label>
                            <input type="text" name="date" class="form-control" value="<?php echo htmlspecialchars($arr); ?>" placeholder="Arrival date">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Health Status</label>
                            <input type="text" name="status" class="form-control" value="<?php echo htmlspecialchars($health); ?>" placeholder="active">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Breed</label>
                            <select name="breed" class="form-control">
                                <option value="<?php echo htmlspecialchars($b_id); ?>" selected><?php echo htmlspecialchars($bname); ?></option>
                                <?php
                                $getBreed = $db->query("SELECT * FROM breed");
                                $res = $getBreed->fetchAll(PDO::FETCH_OBJ);
                                foreach ($res as $r) { ?>
                                    <option value="<?php echo htmlspecialchars($r->id); ?>"><?php echo htmlspecialchars($r->name); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Description</label>
                            <textarea class="form-control" name="remark" placeholder="Description"><?php echo htmlspecialchars($remark); ?></textarea>
                        </div>

                        <button name="submit" type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>

            <div class="col-md-4 col-md-offset-2">
                <h2>Pig Photo</h2>
                <img src="<?php echo htmlspecialchars($img); ?>" width="130" height="120" class="thumbnail img img-responsive">
                <p class="text-justify text-center">
                    <?php echo htmlspecialchars($remark); ?>
                </p>
                <a class="btn btn-danger btn-md" onclick="return confirm('Continue delete pig ?')" href="delete.php?id=<?php echo htmlspecialchars($pigno) ?>"><i class="fa fa-trash"></i> Delete Pig</a>
            </div>
        </div>
    </div>
</div>

<?php include 'theme/foot.php'; ?>
