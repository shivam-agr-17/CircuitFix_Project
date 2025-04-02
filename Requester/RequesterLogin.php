<?php 
 include('../dbConnection.php');
 session_start();
 if(!isset($_SESSION['is_login'])){
  if(isset($_REQUEST['rEmail'])){
   $rEmail = mysqli_real_escape_string($conn, trim($_REQUEST['rEmail']));
   $rPassword = mysqli_real_escape_string($conn, trim($_REQUEST['rPassword']));
   $sql = "SELECT r_email, r_password FROM requesterlogin_tb WHERE r_email = '".$rEmail."' AND r_password = '".$rPassword."' limit 1";
   $result = $conn->query($sql);
   if($result->num_rows == 1){
    $_SESSION['is_login'] = true;
    $_SESSION['rEmail'] = $rEmail;
    echo "<script> location.href='RequesterProfile.php';</script>";
    exit;
   } else {
    $msg = '<div class="alert alert-warning mt-2">Enter Valid Email and Password</div>';
   }
  }
 } else {
  echo "<script> location.href='RequesterProfile.php';</script>";
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="../css/bootstrap.min.css">

 <!-- Font Awesome CSS -->
 <link rel="stylesheet" href="../css/all.min.css">

 <style>
  .custom-margin {
   margin-top: 8vh;
  }
 </style>

 <title>Login</title>
</head>
<body>
 <div class="mb-3 mt-5 text-center" style="font-size: 30px;">
<i class="fas fa-mobile-alt"></i>
  <span>🛠 CircuitFix</span>
 </div>
 <p class="text-center" style="font-size:20px;"><i class="fas fa-user-secret text-danger"></i> Login as Customer </p>
 <div class="container-fluid">
  <div class="row justify-content-center custom-margin">
   <div class="col-sm-6 col-md-4">
    <form action="" class="shadow-lg p-4" method="POST">
     <div class="form-group">
      <i class="fas fa-user"></i><label for="email"  class="font-weight-bold pl-2">Email</label><input type="email" pattern="^[a-zA-Z0-9._%+-]+@(?:skit\.ac\.in|gmail\.com)$" class="form-control" placeholder="Email" name="rEmail">
      <small class="form-text"></small>
     </div>
     <div class="form-group">
      <i class="fas fa-key"></i><label for="pass"  class="font-weight-bold pl-2">Password</label><input type="password" pattern="^[a-zA-Z0-9]{6,}$" class="form-control" placeholder="Password" name="rPassword">
      <small class="form-text">Minimum 8 characters</small>

    </div>

     <button type="submit" class="btn btn-outline-danger mt-3 font-weight-bold btn-block shadow-sm">Login</button>
     <?php if(isset($msg)) {echo $msg;} ?>
    </form>
    <div class="text-center"><a href="../index.php" class="btn btn-info mt-3 font-weight-bold shadow-sm">Back to Home</a></div>
   </div>
  </div>
 </div>

 <!-- JavaScript Files -->
 <script src="../js/jquery.min.js"></script>
 <script src="../js/popper.min.js"></script>
 <script src="../js/bootstrap.min.js"></script>
 <script src="../js/all.min.js"></script>
</body>
</html>