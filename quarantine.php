<?php include 'setting/system.php'; ?>  
<?php include 'theme/head.php'; ?>
<?php include 'theme/sidebar.php'; ?>
<?php include 'session.php'; ?>

<?php 
if(!$_GET['pigno'] OR empty($_GET['pigno']) OR $_GET['pigno'] == '') {
 	header('location: manage-pig.php');
} else {
 	$pigno = $bname = $b_id = $health = "";
 	$pigno = (int)$_GET['pigno'];
 	$query = $db->query("SELECT * FROM pigs WHERE pigno = '$pigno' ");
 	$fetchObj = $query->fetchAll(PDO::FETCH_OBJ);

 	foreach($fetchObj as $obj) {
       $pigno = $obj->pigno;
	   $b_id = $obj->breed_id;
	   $health = $obj->health_status;

	     $k = $db->query("SELECT * FROM breed WHERE id = '$b_id' ");
       	 $ks = $k->fetchAll(PDO::FETCH_OBJ);
       	 foreach ($ks as $r) {
       	 	$bname = $r->name;
       	 }
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
            <div class="col-md-6">
                <table class="table table-hover" id="table">
                    <thead>
                        <tr>
                            <th>Pig No</th>
                            <th>Date quarantined</th>
                            <th>Breed</th>
                            <th>Vaccine</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $get = $db->query("SELECT * FROM quarantine");
                        $res = $get->fetchAll(PDO::FETCH_OBJ);
                        foreach($res as $n) { ?>
                            <tr>
                                <td> <?php echo $n->pigno; ?> </td>
                                <td> <?php echo $n->date; ?> </td>
                                <td> <?php echo $n->breed; ?> </td>
                                <td> <?php echo $n->vaccine; ?> </td>
                                <td> <?php echo $n->reason; ?> </td>
                            </tr> 
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <?php
                if(isset($_POST['submit'])) {
                    $n_pigno = $_POST['pigno'];
                    $n_breed = $_POST['breed'];
                    $n_vaccine = $_POST['vaccine'];
                    $n_remark = $_POST['reason'];
                    $now = date('Y-m-d');
                    $n_id = $_GET['pigno'];

                    $insert_query = $db->query("INSERT INTO quarantine(pigno, breed, vaccine, reason, date) VALUES('$n_pigno', '$n_breed', '$n_vaccine', '$n_remark', '$now')");

                    if($insert_query) { ?>
                    <div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                         <strong>Pig successfully quarantined <i class="fa fa-check"></i></strong>
                    </div>
                    <?php
                    header('refresh: .5');
                    } else { ?>
                    <div class="alert alert-danger alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                         <strong>Error inserting pig data. Please try again <i class="fa fa-times"></i></strong>
                    </div>
                    <?php
                }
                }
                ?>

                <!-- Box for form content -->
                <div class="box" style="border: 1px solid #ddd; padding: 20px; border-radius: 5px; background-color: #f9f9f9;">
                    <form role='form' method="post">
                        <div class="form-group">
                            <label class="control-label">Pig No</label>
                            <input type="text" name="pigno" readonly="on" class="form-control" value="<?php echo $pigno; ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Breed</label>
                            <input type="text" name="breed" readonly="on" class="form-control" value="<?php echo $bname; ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Vaccine</label>
                            <textarea name="vaccine" placeholder="Enter vaccine details" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Reason</label>
                            <textarea name="reason" placeholder="Enter reason for quarantine" class="form-control"></textarea>
                        </div>

                        <button name="submit" type="submit" class="btn btn-primary">Add to list</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'theme/foot.php'; ?>