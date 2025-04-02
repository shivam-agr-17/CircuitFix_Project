<?php 
include('dbConnection.php');

// Function to validate email domain with DNS
function validateEmailDomain($email) {
    // Get domain from email
    $domain = substr(strrchr($email, "@"), 1);
    
    // Check if domain has valid MX records
    if(checkdnsrr($domain, 'MX')) {
        return true;
    }
    
    // If no MX records, check for A record
    if(checkdnsrr($domain, 'A')) {
        return true;
    }
    
    return false;
}

if(isset($_POST['rSignup'])){
  // Validate email address using PHP
  $rEmail = $_POST['rEmail'];
  
  // Validate email format
  if(!filter_var($rEmail, FILTER_VALIDATE_EMAIL)) {
    $regmsg = '<div class="alert alert-warning mt-2" role="alert">Invalid email format!</div>';
  }
  // Validate email domain
  elseif(!validateEmailDomain($rEmail)) {
    $regmsg = '<div class="alert alert-warning mt-2" role="alert">Invalid email domain! Please use a valid email address.</div>';
  }
  else {
    // Checking for Empty Fields
    $rName = $_POST['rName'];
    $rPassword = $_POST['rPassword'];
    if(empty($rName) || empty($rEmail) || empty($rPassword)){
      $regmsg = '<div class="alert alert-warning mt-2" role="alert">All Fields are Required</div>';
    } else {
      // Email Already Registered
      $sql = "SELECT r_email FROM requesterlogin_tb WHERE r_email ='".$_POST['rEmail']."'";
      $result = $conn->query($sql);
      if($result->num_rows==1){
        $regmsg = '<div class="alert alert-warning mt-2" role="alert">Email ID Already Registered</div>';
      } else {
          // Assigning User's Values to Variables
          $sql = "INSERT INTO requesterlogin_tb(r_name, r_email, r_password) VALUES('$rName', '$rEmail', '$rPassword')";
          if($conn->query($sql) == TRUE){
            $regmsg = '<div class="alert alert-success mt-2" role="alert">Account Successfully Created</div>';
          } else {
            $regmsg = '<div class="alert alert-danger mt-2" role="alert">Unable to Create Account</div>';
          }
        }
    }
  }
}
?>

<div class="container pt-5" id="registration" style=" background-color: rgba(0, 0, 0, 0.9);color: white;">
  <h2 class="text-center">Create an Account</h2>
  <div class="row mt-4 mb-4" >
   <div class="col-md-6 offset-md-3">
    <form action="" class="shadow-lg p-4" method="POST" >
     <div class="form-group">
      <i class="fas fa-user"></i> 
      <label for="name" class="font-weight-bold pl-2">Name</label>
      <input type="text" class="form-control" placeholder="Name" name="rName" required>
     </div>
     <div class="form-group">
      <i class="fas fa-user"></i> 
      <label for="email" class="font-weight-bold pl-2">Email</label>
      <input type="email" class="form-control" placeholder="Email" name="rEmail" required>
      <small class="form-text">Please enter a valid email address.</small>
     </div>
     <div class="form-group">
      <i class="fas fa-key"></i> 
      <label for="pass" class="font-weight-bold pl-2">New Password</label>
      <input type="password" pattern="^[a-zA-Z0-9]{6,}$" class="form-control" placeholder="Password" name="rPassword" required>
      <small class="form-text">Minimum 8 Characters, including Uppercase, Lowercase and Number.</small>
     </div>
     <button type="submit" class="btn btn-danger mt-5 btn-block shadow-sm font-weight-bold" name="rSignup">Sign Up</button>
     <em style="font-size:10px;"></em>
     <?php if(isset($regmsg)) {echo $regmsg;} ?>
    </form>
   </div>
  </div>
 </div>