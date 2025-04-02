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
 if(isset($_REQUEST['reqsubmit'])){
  if(($_REQUEST['r_name'] == "") || ($_REQUEST['r_email'] == "") || ($_REQUEST['r_password'] == "")){
   $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fields </div>';
  } else {
    $rname = $_REQUEST['r_name'];
    $rEmail = $_REQUEST['r_email'];
    $rPassword = $_REQUEST['r_password'];

    // Validate email
    if(!filter_var($rEmail, FILTER_VALIDATE_EMAIL)) {
      $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">Invalid email format</div>';
    }
    else if(!checkdnsrr(explode('@', $rEmail)[1], 'MX')) {
      $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">Invalid email domain</div>';
    }
    else {
      $sql = "INSERT INTO requesterlogin_tb (r_name, r_email, r_password) VALUES ('$rname', '$rEmail', '$rPassword')";
      if($conn->query($sql) == TRUE){
       $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Added Successfully </div>';
      } else {
       $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Add </div>';
      }
    }
  }
}
?>
<!-- Start 2nd Column -->
<div class="col-sm-6 mt-5  mx-3 jumbotron">
  <h3 class="text-center">Add New Requester</h3>
  <form action="" method="POST" onsubmit="return validateForm()">
    <div class="form-group">
      <label for="r_name">Name</label>
      <input type="text" class="form-control" id="r_name" name="r_name">
    </div>
    <div class="form-group">
      <label for="r_email">Email</label>
      <input type="email" class="form-control" id="r_email" name="r_email">
      <small class="form-text text-muted">Enter a valid email address</small>
    </div>
    <div class="form-group">
      <label for="r_password">Password</label>
      <input type="password" class="form-control" id="r_password" name="r_password">
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-danger" id="reqsubmit" name="reqsubmit">Submit</button>
      <a href="requester.php" class="btn btn-secondary">Close</a>
    </div>
    <?php if(isset($msg)) {echo $msg; } ?>
  </form>
</div>

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

    return true;
  }
</script>
<?php include('includes/footer.php'); ?>
