<?php
define('TITLE', 'Request Details');
define('PAGE', 'AllRequests');
include('includes/header.php');
include('../dbConnection.php');

if($_SESSION['is_login']){
 $rEmail = $_SESSION['rEmail'];
} else {
 echo "<script> location.href='RequesterLogin.php'</script>";
}

// Get request ID from POST or SESSION
$request_id = isset($_POST['id']) ? $_POST['id'] : (isset($_SESSION['myid']) ? $_SESSION['myid'] : null);

if($request_id) {
  // Modified query to join with assignwork_tb
  $sql = "SELECT sr.*, aw.status, aw.completion_date, aw.assign_tech, aw.assign_date 
          FROM submitrequest_tb sr 
          LEFT JOIN assignwork_tb aw ON sr.request_id = aw.request_id 
          WHERE sr.request_id = $request_id AND sr.requester_email = '$rEmail'";
  $result = $conn->query($sql);
  
  if($result->num_rows == 1){
    $row = $result->fetch_assoc();
    ?>
    <div class="col-sm-9 col-md-10 mt-5">
      <div class="card">
        <div class="card-header">
          <h3 class="text-center">Request Details</h3>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th>Request ID</th>
                <td><?php echo $row['request_id']; ?></td>
              </tr>
              <tr>
                <th>Name</th>
                <td><?php echo $row['requester_name']; ?></td>
              </tr>
              <tr>
                <th>Email ID</th>
                <td><?php echo $row['requester_email']; ?></td>
              </tr>
              <tr>
                <th>Device Type</th>
                <td><?php echo $row['request_info']; ?></td>
              </tr>
              <tr>
                <th>Request Description</th>
                <td><?php echo $row['request_desc']; ?></td>
              </tr>
              <tr>
                <th>Address</th>
                <td>
                  <?php echo $row['requester_add1']; ?><br>
                  <?php echo $row['requester_add2']; ?><br>
                  <?php echo $row['requester_city']; ?>, <?php echo $row['requester_state']; ?> - <?php echo $row['requester_zip']; ?>
                </td>
              </tr>
              <tr>
                <th>Mobile</th>
                <td><?php echo $row['requester_mobile']; ?></td>
              </tr>
              <tr>
                <th>Request Date</th>
                <td><?php echo date('d M Y', strtotime($row['request_date'])); ?></td>
              </tr>
              <tr>
                <th>Status</th>
                <td>
                  <?php 
                  if(isset($row['status']) && $row['status'] == 'completed') {
                    echo '<span class="badge badge-success">Completed</span>';
                    if(isset($row['completion_date'])) {
                      echo '<br><small class="text-muted">Completed on: ' . date('d M Y', strtotime($row['completion_date'])) . '</small>';
                    }
                  } else if(isset($row['status']) && $row['status'] == 'pending') {
                    echo '<span class="badge badge-warning">Pending</span>';
                  } else {
                    echo '<span class="badge badge-secondary">Not Assigned</span>';
                  }
                  ?>
                </td>
              </tr>
              <?php if(isset($row['assign_tech'])) { ?>
              <tr>
                <th>Assigned Technician</th>
                <td><?php echo $row['assign_tech']; ?></td>
              </tr>
              <?php } ?>
              <?php if(isset($row['assign_date'])) { ?>
              <tr>
                <th>Assigned Date</th>
                <td><?php echo date('d M Y', strtotime($row['assign_date'])); ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          <div class="text-center">
            <form class="d-print-none">
              <input class="btn btn-danger" type="submit" value="Print" onClick="window.print()">
              <a href="AllRequests.php" class="btn btn-secondary">Back to All Requests</a>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php
  } else {
    echo "<div class='alert alert-danger col-sm-6 ml-5 mt-2'>Invalid Request ID</div>";
  }
} else {
  echo "<div class='alert alert-danger col-sm-6 ml-5 mt-2'>No Request ID Provided</div>";
}

include('includes/footer.php');
?>