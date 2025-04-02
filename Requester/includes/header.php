<?php
session_start();
if(!isset($_SESSION['is_login'])){
  echo "<script> location.href='RequesterLogin.php'</script>";
} else {
  $rEmail = $_SESSION['rEmail'];
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

 <link rel="stylesheet" href="../css/custom.css">

 <style>
 .sidebar {
   background-color: #f8f9fa;
   border-right: 1px solid #dee2e6;
   height: 100vh;
   position: fixed;
   width: 250px;
 }

 .main-content {
   margin-left: 250px;
   padding: 20px;
 }

 .nav-link {
   color: #333;
   padding: 12px 20px;
   margin-bottom: 5px;
   transition: all 0.3s;
 }

 .nav-link:hover {
   background-color: #e9ecef;
   color:rgb(187, 21, 21);
   text-decoration: none;
 }

 .nav-link.active {
   background-color: #dc3545;
   color: white;
 }

 .nav-link i {
   margin-right: 10px;
   width: 20px;
   text-align: center;
 }
 </style>

 <title><?php echo TITLE ?></title>
</head>
<body>
 <!-- Top Navbar -->
 <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
  <div class="container-fluid px-4">
    <a class="navbar-brand" href="../index.php">CircuitFix</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link btn ml-4 px-4 font-weight-bold" href="RequesterLogout.php" style="background-color: #8B0000; color: white !important;">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Sidebar -->
<div class="sidebar">
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link <?php if(PAGE == 'RequesterProfile') { echo 'active'; } ?>" href="RequesterProfile.php">
        <i class="fas fa-user-circle"></i> My Profile
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php if(PAGE == 'SubmitRequest') { echo 'active'; } ?>" href="SubmitRequest.php">
        <i class="fas fa-hand-paper"></i> Submit Request
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php if(PAGE == 'ServiceStatus') { echo 'active'; } ?>" href="CheckStatus.php">
        <i class="fas fa-tasks"></i> Service Status
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php if(PAGE == 'AllRequests') { echo 'active'; } ?>" href="AllRequests.php">
        <i class="fas fa-history"></i> All Requests
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php if(PAGE == 'RequesterChangePass') { echo 'active'; } ?>" href="Requesterchangepass.php">
        <i class="fas fa-key"></i> Change Password
      </a>
    </li>
  </ul>
</div>

<!-- Main Content -->
<div class="main-content">
  <!-- Content will be inserted here -->
</div>

<!-- Bootstrap JS -->
<script src="../js/jquery.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/all.min.js"></script>
</body>
</html>
