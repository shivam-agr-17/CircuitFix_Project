<?php
define('TITLE', 'All Requests');
define('PAGE', 'AllRequests');
include('includes/header.php');
include('../dbConnection.php');

if($_SESSION['is_login']){
 $rEmail = $_SESSION['rEmail'];
} else {
 echo "<script> location.href='RequesterLogin.php'</script>";
}

// Fetch all requests for the logged-in user with status from assignwork_tb
$sql = "SELECT sr.*, aw.status, aw.completion_date 
        FROM submitrequest_tb sr 
        LEFT JOIN assignwork_tb aw ON sr.request_id = aw.request_id 
        WHERE sr.requester_email = '$rEmail' 
        ORDER BY sr.request_date DESC";
$result = $conn->query($sql);
?>

<div class="col-sm-9 col-md-10 mt-1 ml-auto mr-3">
  <h2 class="text-center mb-4 display-9 ">My Service Requests</h2>
  <?php if($result->num_rows > 0) { ?>
    <div class="row">
      <?php while($row = $result->fetch_assoc()) { ?>
        <div class="col-sm-6 col-lg-4 mb-4">
          <div class="card">
            <div class="card-header">
              <strong>Request ID: <?php echo $row['request_id']; ?></strong>
              <div class="float-right">
                <?php 
                if(isset($row['status']) && $row['status'] == 'completed') {
                  echo '<span class="badge badge-success">Completed</span>';
                } else if(isset($row['status']) && $row['status'] == 'pending') {
                  echo '<span class="badge badge-warning">Pending</span>';
                } else {
                  echo '<span class="badge badge-secondary">Not Assigned</span>';
                }
                ?>
              </div>
            </div>
            <div class="card-body">
              <h6 class="card-subtitle mb-2 text-muted">Device Type</h6>
              <p class="card-text"><?php echo $row['request_info']; ?></p>
              
              <h6 class="card-subtitle mb-2 text-muted">Description</h6>
              <p class="card-text"><?php echo $row['request_desc']; ?></p>
              
              <h6 class="card-subtitle mb-2 text-muted">Request Date</h6>
              <p class="card-text"><?php echo date('d M Y', strtotime($row['request_date'])); ?></p>
              
              <?php if(isset($row['status']) && $row['status'] == 'completed' && isset($row['completion_date'])) { ?>
                <h6 class="card-subtitle mb-2 text-muted">Completed On</h6>
                <p class="card-text"><?php echo date('d M Y', strtotime($row['completion_date'])); ?></p>
              <?php } ?>
              
              <form action="submitrequestsuccess.php" method="POST" class="mt-3">
                <input type="hidden" name="id" value="<?php echo $row['request_id']; ?>">
                <input type="hidden" name="status" value="<?php echo isset($row['status']) ? $row['status'] : ''; ?>">
                <input type="hidden" name="completion_date" value="<?php echo isset($row['completion_date']) ? $row['completion_date'] : ''; ?>">
                <button type="submit" class="btn btn-info btn-sm btn-block" name="view">
                  <i class="fas fa-eye"></i> View Details
                </button>
              </form>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  <?php } else { ?>
    <div class="alert alert-info">
      <p class="text-center">No service requests found.</p>
    </div>
  <?php } ?>
</div>

<?php 
include('includes/footer.php');
?>
</div> <!-- Close main-content div from header -->
</body>
</html> 