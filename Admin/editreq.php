<?php    
define('TITLE', 'Update Requester');
define('PAGE', 'requesters');
include('includes/header.php'); 
include('../dbConnection.php');
session_start();
 if(isset($_SESSION['is_adminlogin'])){
  $aEmail = $_SESSION['aEmail'];
 } else {
  echo "<script> location.href='login.php'; </script>";
 }
 ?>
 <!-- Start 2nd COlumn -->
 <div class="col-sm-6 mt-5 mx-3 jumbotron">
  <h3 class="text-center">Update Requester Details</h3>
  <?php 
   if(isset($_REQUEST['edit'])){
   $sql = "SELECT * FROM requesterlogin_tb WHERE r_login_id = {$_REQUEST['id']}";
   $result = $conn->query($sql);
   $row = $result->fetch_assoc();
   }
   if(isset($_REQUEST['requpdate'])){
    if(($_REQUEST['r_login_id'] == "") || ($_REQUEST['r_name'] == "") || ($_REQUEST['r_email'] == "")){
     $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">Fill All Fields</div>';
    } else {
     $rid = $_REQUEST['r_login_id'];
     $rname = $_REQUEST['r_name'];
     $remail = $_REQUEST['r_email'];

     // Validate email format
     if(!filter_var($remail, FILTER_VALIDATE_EMAIL)) {
       $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">Invalid email format</div>';
     }
     // Validate email domain DNS
     else if(!checkdnsrr(explode('@', $remail)[1], 'MX')) {
       $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">Invalid email domain</div>';
     }
     else {
       $sql = "UPDATE requesterlogin_tb SET r_login_id = '$rid', r_name = '$rname', r_email = '$remail' WHERE r_login_id = '$rid'";
       if($conn->query($sql) ==  TRUE){
        $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert">Updated Successfully</div>';
       } else {
        $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert">Unable to Update</div>';
       }
     }
    }
   }
  ?>
  <form action="" method="POST" onsubmit="return validateForm()">
   <div class="form-group">
    <label for="r_login_id">Requester ID</label>
    <input type="text" class="form-control" name="r_login_id" id="r_login_id" Value="<?php if(isset($row['r_login_id'])) { echo $row['r_login_id']; } ?>" readonly>
   </div>
   <div class="form-group">
    <label for="r_name">Name</label>
    <input type="text" class="form-control" name="r_name" id="r_name" Value="<?php if(isset($row['r_name'])) { echo $row['r_name']; } ?>" required>
   </div>
   <div class="form-group">
    <label for="r_email">Email</label>
    <input type="email" class="form-control" name="r_email" id="r_email" Value="<?php if(isset($row['r_email'])) { echo $row['r_email']; } ?>" required>
    <small class="form-text text-muted">Enter a valid email address with a valid domain</small>
   </div>
   <div class="text-center">
    <button type="submit" class="btn btn-danger" id="requpdate" name="requpdate">Update</button>
    <a href="requester.php" class="btn btn-secondary">Close</a>
   </div>
   <?php if(isset($msg)) {echo $msg; } ?>
  </form>
 </div> <!-- End 2nd COlumn -->

<script>
  // Form validation
  function validateForm() {
    var email = document.getElementById('r_email').value;
    
    // Basic email validation
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if(!emailPattern.test(email)) {
      alert('Please enter a valid email address');
      return false;
    }

    // Check email domain
    var domain = email.split('@')[1];
    if(!domain || domain.indexOf('.') === -1) {
      alert('Please enter a valid email domain');
      return false;
    }

    return true;
  }
</script>

<?php include('includes/footer.php'); ?>