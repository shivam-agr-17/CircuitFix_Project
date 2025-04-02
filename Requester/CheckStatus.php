<?php 
define('TITLE', 'Service Status');
define('PAGE', 'ServiceStatus');
include('includes/header.php');
include('../dbConnection.php');

if($_SESSION['is_login']){
 $rEmail = $_SESSION['rEmail'];
} else {
 echo "<script> location.href='RequesterLogin.php'; </script>";
}
?>

<div class="container-fluid">
  <h3 class="text-center mb-4">Check Service Status</h3>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <form action="" method="post" class="mb-4">
        <div class="form-row align-items-center justify-content-center">
          <div class="col-auto">
            <label for="checkid">Enter Request ID: </label>
          </div>
          <div class="col-auto">
            <input type="text" class="form-control" name="checkid" id="checkid" onkeypress="isInputNumber(event)">
          </div>
          <div class="col-auto">
            <button type="submit" class="btn btn-danger">Search</button>
          </div>
        </div>
      </form>

      <?php 
      if(isset($_REQUEST['checkid'])){
        if($_REQUEST['checkid'] == ""){
          $msg = '<div class="alert alert-warning" role="alert">Fill All Fields</div>';
        } else {
          $sql = "SELECT * FROM assignwork_tb WHERE request_id = {$_REQUEST['checkid']}";
          $result = $conn->query($sql);
          $row = $result->fetch_assoc();
          if((isset($row['request_id']) == isset($_REQUEST['checkid']))){ ?>
            <h4 class="text-center mb-4">Assigned Work Details</h4>
            <div class="table-responsive">
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <td>Request ID</td>
                    <td><?php if(isset($row['request_id'])){echo $row['request_id'];} ?></td>
                  </tr>
                  <tr>
                    <td>Request Info</td>
                    <td><?php if(isset($row['request_info'])){echo $row['request_info'];} ?></td>
                  </tr>
                  <tr>
                    <td>Request Description</td>
                    <td><?php if(isset($row['request_desc'])){echo $row['request_desc'];} ?></td>
                  </tr>
                  <tr>
                    <td>Name</td>
                    <td><?php if(isset($row['requester_name'])) {echo $row['requester_name']; } ?></td>
                  </tr>
                  <tr>
                    <td>Address Line 1</td>
                    <td><?php if(isset($row['requester_add1'])) {echo $row['requester_add1']; } ?></td>
                  </tr>
                  <tr>
                    <td>Address Line 2</td>
                    <td><?php if(isset($row['requester_add2'])) {echo $row['requester_add2']; } ?></td>
                  </tr>
                  <tr>
                    <td>City</td>
                    <td><?php if(isset($row['requester_city'])) {echo $row['requester_city']; } ?></td>
                  </tr>
                  <tr>
                    <td>State</td>
                    <td><?php if(isset($row['requester_state'])) {echo $row['requester_state']; } ?></td>
                  </tr>
                  <tr>
                    <td>Pin Code</td>
                    <td><?php if(isset($row['requester_zip'])) {echo $row['requester_zip']; } ?></td>
                  </tr>
                  <tr>
                    <td>Email</td>
                    <td><?php if(isset($row['requester_email'])) {echo $row['requester_email']; } ?></td>
                  </tr>
                  <tr>
                    <td>Mobile</td>
                    <td><?php if(isset($row['requester_mobile'])) {echo $row['requester_mobile']; } ?></td>
                  </tr>
                  <tr>
                    <td>Assigned Date</td>
                    <td><?php if(isset($row['assign_date'])) {echo $row['assign_date']; } ?></td>
                  </tr>
                  <tr>
                    <td>Technician Name</td>
                    <td><?php if(isset($row['assign_tech'])) {echo $row['assign_tech']; } ?></td>
                  </tr>
                  <tr>
                    <td>Customer Sign</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>Technician Sign</td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="text-center mb-4">
              <form class="d-print-none">
                <input class="btn btn-danger" type="submit" value="Print" onClick="window.print()">
                <input class="btn btn-secondary" type="submit" value="Close">
              </form>
            </div>
          <?php } else {
            echo '<div class="alert alert-info">Your Request is Still Pending</div>';
          }
        }
      }
      if(isset($msg)){echo $msg;} 
      ?>
    </div>
  </div>
</div>

<!-- Only Number for input fields -->
<script>
  function isInputNumber(evt) {
    var ch = String.fromCharCode(evt.which);
    if (!(/[0-9]/.test(ch))) {
      evt.preventDefault();
    }
  }
</script>

<?php 
include('includes/footer.php');
?>
</div> <!-- Close main-content div from header -->
</body>
</html>