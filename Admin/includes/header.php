<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <title><?php echo TITLE ?></title>
 <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="../css/bootstrap.min.css">

 <!-- Font Awesome CSS -->
 <link rel="stylesheet" href="../css/all.min.css">

 <!-- Custom CSS -->
 <link rel="stylesheet" href="../css/custom.css"> 
</head>
<body>
  <!-- Top Navbar -->
  <nav class="navbar navbar-dark fixed-top bg-danger flex-md-nowrap p-0 shadow"><a class="navbar-brand col-sm-3 col-md-2 mr-0" href="dashboard.php">CircuitFix</a></nav>

  <!-- Start Container -->
 <div class="container-fluid" style="margin-top:40px;">
  <div class="row"> <!-- Start Row -->
   <nav class="col-sm-2 bg-light sidebar py-5 d-print-none"> <!-- Start Side Bar 1st Column -->
    <div class="sidebar-sticky">
     <ul class="nav flex-column">
      <li class="nav-item"><a class="nav-link <?php if(PAGE == 'dashboard'){echo 'active';} ?>" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
      <li class="nav-item"><a class="nav-link <?php if(PAGE == 'work'){echo 'active';} ?>" href="work.php"><i class="fab fa-accessible-icon"></i> Work Order</a></li>
      <li class="nav-item"><a class="nav-link <?php if(PAGE == 'completedwork'){echo 'active';} ?>" href="completedwork.php"><i class="fas fa-check-circle"></i> Completed Work</a></li>
      <li class="nav-item"><a class="nav-link <?php if(PAGE == 'request'){echo 'active';} ?>" href="request.php"><i class="fas fa-align-center"></i> Requests</a></li>
      <li class="nav-item"><a class="nav-link <?php if(PAGE == 'assets'){echo 'active';} ?>" href="assets.php"><i class="fas fa-database"></i> spare parts</a></li>
      <li class="nav-item"><a class="nav-link <?php if(PAGE == 'technician'){echo 'active';} ?>" href="technician.php"><i class="fab fa-teamspeak"></i> Technician</a></li>
      <li class="nav-item"><a class="nav-link <?php if(PAGE == 'requesters'){echo 'active';} ?>" href="requester.php"><i class="fas fa-users"></i> Requester</a></li>
      <li class="nav-item"><a class="nav-link <?php if(PAGE == 'sellreport'){echo 'active';} ?>" href="soldproductreport.php"><i class="fas fa-table"></i> Sell Report</a></li>
      <li class="nav-item"><a class="nav-link <?php if(PAGE == 'contact'){echo 'active';} ?>" href="contact-submissions.php"><i class="fas fa-envelope"></i> Contact Messages</a></li>
      <li class="nav-item"><a class="nav-link <?php if(PAGE == 'changepass'){echo 'active';} ?>" href="changepass.php"><i class="fas fa-key"></i> Change Password</a></li>
      <li class="nav-item"><a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
     </ul>
    </div>
   </nav> <!-- End Side Bar 1st Column -->