<?php
define('TITLE', 'Requests');
define('PAGE', 'request');
include('includes/header.php');
include('../dbConnection.php');
session_start();
if(isset($_SESSION['is_adminlogin'])){
   $aEmail = $_SESSION['aEmail'];
} else {
   echo "<script> location.href='login.php'</script>";
}

// Check if admin_visible column exists, if not create it
$check_column = "SHOW COLUMNS FROM submitrequest_tb LIKE 'admin_visible'";
$result = $conn->query($check_column);
if($result->num_rows == 0) {
    $add_column = "ALTER TABLE submitrequest_tb ADD COLUMN admin_visible BOOLEAN DEFAULT TRUE";
    $conn->query($add_column);
}

// Handle close button
if(isset($_REQUEST['close'])){
   $request_id = $_REQUEST['id'];
   $sql = "UPDATE submitrequest_tb SET admin_visible = FALSE WHERE request_id = '$request_id'";
   if($conn->query($sql) === TRUE){
      echo "<script> location.href='request.php'</script>";
   } else {
      echo "Error updating record: " . $conn->error;
   }
}
?>
<!-- Start 2nd Column -->
<div class="col-sm-4 mb-5">
 <?php 
  $sql = "SELECT sr.*, aw.status 
          FROM submitrequest_tb sr 
          LEFT JOIN assignwork_tb aw ON sr.request_id = aw.request_id 
          WHERE sr.admin_visible = TRUE
          ORDER BY sr.request_date DESC";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
   while($row = $result->fetch_assoc()){
    echo '<div class="card mt-5 mx-5">';
     echo '<div class="card-header">';
      echo 'Request ID:'. $row['request_id'];
      if(isset($row['status']) && $row['status'] == 'completed') {
        echo ' <span class="badge badge-success">Completed</span>';
      } else if(isset($row['status']) && $row['status'] == 'pending') {
        echo ' <span class="badge badge-warning">Pending</span>';
      } else {
        echo ' <span class="badge badge-secondary">Not Assigned</span>';
      }
     echo '</div>';
     echo '<div class="card-body">';
      echo '<h5 class="card-title">Request Info: '.$row['request_info'];
      echo '</h5>';
      echo '<p class="card-text">'.$row['request_desc'];
      echo '</p>';
      echo '<p class="card-text">Request Date: '.$row['request_date'];
      echo '</p>';
      echo '<div class="float-right">';
       echo '<form action="" method="POST">';
        echo '<input type="hidden" name="id" value='.$row["request_id"].'>';
        echo '<input type="submit" class="btn btn-danger mr-3" value="View" name="view">';
        if(isset($row['status']) && $row['status'] == 'completed') {
          echo '<input type="submit" class="btn btn-secondary" value="Close" name="close">';
        }
       echo '</form>';
      echo '</div>';
     echo '</div>';
    echo '</div>';
   }
  }
 ?>
</div> <!-- End 2nd Column -->

<?php 
include('assignworkform.php');
include('includes/footer.php');

?>