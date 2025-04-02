<?php
define('TITLE', 'Contact Submissions');
define('PAGE', 'contact');
include('includes/header.php');
include('../dbConnection.php');
session_start();
if(isset($_SESSION['is_adminlogin'])){
 $aEmail = $_SESSION['aEmail'];
} else {
 echo "<script> location.href='login.php'; </script>";
}

// Delete Submission
if(isset($_POST['delete'])) {
  $id = $_POST['id'];
  $sql = "DELETE FROM contact_submissions WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  if($stmt->execute()) {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var alert = document.createElement('div');
                alert.className = 'alert-toast';
                alert.innerHTML = 'Submission Deleted Successfully';
                document.body.appendChild(alert);
                setTimeout(function() {
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }, 3000);
            });
          </script>";
  } else {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var alert = document.createElement('div');
                alert.className = 'alert-toast error';
                alert.innerHTML = 'Unable to Delete Submission';
                document.body.appendChild(alert);
                setTimeout(function() {
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }, 3000);
            });
          </script>";
  }
}
?>

<div class="col-sm-9 col-md-10 mt-5 text-center">
  <p class="bg-dark text-white p-2">Contact Form Submissions</p>
  <?php
    $sql = "SELECT * FROM contact_submissions ORDER BY submission_date DESC";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
     echo '<table class="table">
      <thead>
       <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Subject</th>
        <th scope="col">Message</th>
        <th scope="col">Date</th>
        <th scope="col">Action</th>
       </tr>
      </thead>
      <tbody>';
      while($row = $result->fetch_assoc()){
        echo '<tr>
        <td>'.$row["id"].'</td>
        <td>'.$row["name"].'</td>
        <td>'.$row["email"].'</td>
        <td>'.$row["subject"].'</td>
        <td>'.substr($row["message"], 0, 100).'...</td>
        <td>'.$row["submission_date"].'</td>
        <td>
          <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#msg'.$row["id"].'">
            View
          </button>
          <form method="POST" class="d-inline">
            <input type="hidden" name="id" value="'.$row["id"].'">
            <button type="submit" class="btn btn-danger" name="delete" onclick="return confirm(\'Are you sure you want to delete this submission?\')">
              Delete
            </button>
          </form>
        </td>
        </tr>';
        
        // Modal for each message
        echo '<div class="modal fade" id="msg'.$row["id"].'" tabindex="-1" role="dialog" aria-labelledby="msgLabel'.$row["id"].'" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="msgLabel'.$row["id"].'">Message from '.$row["name"].'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body text-left">
                <p><strong>Subject:</strong> '.$row["subject"].'</p>
                <p><strong>From:</strong> '.$row["name"].' ('.$row["email"].')</p>
                <p><strong>Date:</strong> '.$row["submission_date"].'</p>
                <hr>
                <p><strong>Message:</strong></p>
                <p>'.nl2br($row["message"]).'</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>';
      }
      echo '</tbody>
     </table>';
    } else {
      echo '<div class="alert alert-info mt-3">No Contact Submissions Found</div>';
    }
  ?>
</div>

<style>
.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}
.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

.alert-toast {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 25px;
    background-color: #28a745;
    color: white;
    border-radius: 4px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    z-index: 9999;
    opacity: 1;
    transition: opacity 0.5s ease-in-out;
    font-size: 14px;
}

.alert-toast.error {
    background-color: #dc3545;
}
</style>

<!-- Make sure Bootstrap JS and jQuery are included -->
<script src="../js/jquery.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<?php
include('includes/footer.php');
?> 