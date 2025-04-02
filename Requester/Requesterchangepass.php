<?php 
define('TITLE', 'Change Password');
define('PAGE', 'Requesterchangepass');
include('includes/header.php');
include('../dbConnection.php');

if($_SESSION['is_login']){
 $rEmail = $_SESSION['rEmail'];
} else {
 echo "<script> location.href='RequesterLogin.php'</script>";
}

$rEmail = $_SESSION['rEmail'];
if(isset($_REQUEST['passupdate'])){
 if($_REQUEST['rPassword'] == ""){
  $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Fill All Fields</div>';
 } else {
  $rPass = $_REQUEST['rPassword'];
  $sql = "UPDATE requesterlogin_tb SET r_password = '$rPass' WHERE r_email = '$rEmail'";
  if($conn->query($sql) == TRUE){
   $passmsg = '<div class="alert alert-success col-sm-6 ml-5 mt-2">Updated Successfully</div>';
  } else {
   $passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2">Unable to Update</div>';
  }
 }
}

?>

<div class="container-fluid">
  <h3 class="text-center mb-4">Change Password</h3>
  <div class="row justify-content-center">
    <div class="col-sm-6">
      <form action="" method="POST">
        <div class="form-group">
          <label for="inputEmail">Email</label>
          <input type="email" class="form-control" id="inputEmail" value="<?php echo $rEmail; ?>" readonly>
        </div>
        <div class="form-group">
          <label for="inputnewpassword">New Password</label>
          <input type="password" class="form-control" id="inputnewpassword" placeholder="New Password" name="rPassword">
        </div>
        <button type="submit" class="btn btn-danger mr-4" name="passupdate">Update</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
        <?php if(isset($passmsg)){echo $passmsg;} ?>
      </form>
    </div>
  </div>
</div>

<?php 
include('includes/footer.php');
?>
</div> <!-- Close main-content div from header -->
</body>
</html>