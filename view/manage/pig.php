<?php 
include base_path('/view/theme/head.php'); ?>
<?php include base_path('/view/theme/sidebar.php'); ?>
<?php include base_path('/view/theme/sidebar.php');?>

<?php 
if (!isset($_SESSION['id'])) {
  header('Location: /login'); 
  exit();
}


?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;"> 

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Pig Management</b></h5>
  </header>

 <?php include 'inc/data.php'; ?>

 <div class="alert alert-danger alert-fade">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error updating pig data. Please try again <i class="fa fa-times"></i></strong>
</div>
 <div class="w3-container" style="padding-top:22px">
   <div class="w3-row">
     <h2>Manage Pigs</h2>
     <a href="/add-pig" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Add New Pig</a><br><br>
     <div class="table-responsive">
       <table class="table table-hover table-striped" id="table">
         <thead>
           <tr>
             <th>Photo</th>
             <th>Pig No.</th>
             <th>Breed</th>
             <th>Weight</th>
             <th>Gender</th>
             <th>Health Status</th>
             <th>Date</th>
             <th>Desc.</th>
             <th></th>
           </tr>
         </thead>
         <tbody>
           <?php
           $admin_id = $_SESSION['admin_id'];

           $all_pig = $db->prepare("SELECT * FROM pigs WHERE is_deleted = 0 AND admin_id = ? ORDER BY pigno ASC");
           $all_pig->execute([$admin_id]);
           $fetch = $all_pig->fetchAll(PDO::FETCH_OBJ);

           if(count($fetch) == 0){
               echo '<tr><td colspan="9">No pigs found for this admin.</td></tr>';
           } else {
               foreach ($fetch as $data) {
                 $get_breed = $db->prepare("SELECT * FROM breed WHERE id = ?");
                 $get_breed->execute([$data->breed_id]);
                 $breed_result = $get_breed->fetchAll(PDO::FETCH_OBJ);

                 foreach ($breed_result as $breed) {
           ?>
               <tr>
                 <td>
                   <img width="70" height="70" src="<?php echo $data->img; ?>" class="img img-responsive thumbnail">
                 </td>
                 <td><?php echo $data->pigno; ?></td>
                 <td><?php echo $breed->name ?></td>
                 <td><?php echo $data->weight ?></td>
                 <td><?php echo $data->gender ?></td>
                 <td><?php echo $data->health_status ?></td>
                 <td><?php echo $data->date ?></td>
                 <td><?php echo wordwrap($data->remark, 300, '<br>'); ?></td>
                 <td>
                   <div class="dropdown">
                     <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-cog"></i> Option<span class="caret"></span></button>
                     <ul class="dropdown-menu">
                       <li><a href="/edit-pig?pigno=<?php echo $data->pigno ?>"><i class="fa fa-edit"></i> Edit</a></li>
                       <li><a onclick="return confirm('Continue delete pig ?')" href="/delete-pig?pigno=<?php echo $data->pigno ?>"><i class="fa fa-trash"></i> Delete</a></li>
                       <li><a onclick="return confirm('Continue quarantine pig ?')" href="/quarantine?pigno=<?php echo $data->pigno; ?>"><i class="fa fa-paper-plane"></i> Quarantine Pig</a></li>
                       <li><a onclick="return confirm('Mark this pig as sold?')" href="sold.php?pigno=<?php echo $data->pigno; ?>">
                       <i class="fa fa-dollar-sign" style="color: white;"></i> Sold</a></li>
                     </ul>
                   </div> 
                 </td>
               </tr>    
           <?php 
                 }
               }
           }
           ?>
         </tbody>
       </table>
     </div>
   </div>
 </div>

<?php include base_path('/view/theme/foot.php'); ?>
