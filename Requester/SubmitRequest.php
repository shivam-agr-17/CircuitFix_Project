<?php 
define('TITLE', 'Submit Request');
define('PAGE', 'SubmitRequest');
include('includes/header.php');
include('../dbConnection.php');

if($_SESSION['is_login']){
 $rEmail = $_SESSION['rEmail'];
} else {
 echo "<script> location.href='RequesterLogin.php'</script>";
}

// Indian States and their cities with PIN codes
$indianLocations = [
    'Andhra Pradesh' => [
        'Visakhapatnam' => ['530000', '530001', '530002', '530003', '530004'],
        'Vijayawada' => ['520001', '520002', '520003', '520004'],
        'Guntur' => ['522001', '522002', '522003']
    ],
    'Delhi' => [
        'New Delhi' => ['110001', '110002', '110003', '110004'],
        'North Delhi' => ['110006', '110007', '110008'],
        'South Delhi' => ['110016', '110017', '110018']
    ],
    'Gujarat' => [
        'Ahmedabad' => ['380001', '380002', '380003', '380004'],
        'Surat' => ['395001', '395002', '395003'],
        'Vadodara' => ['390001', '390002', '390003']
    ],
    'Karnataka' => [
        'Bangalore' => ['560001', '560002', '560003', '560004'],
        'Mysore' => ['570001', '570002', '570003'],
        'Hubli' => ['580001', '580002', '580003']
    ],
    'Maharashtra' => [
        'Mumbai' => ['400001', '400002', '400003', '400004'],
        'Pune' => ['411001', '411002', '411003'],
        'Nagpur' => ['440001', '440002', '440003']
    ],
    'Rajasthan' => [
        'Jaipur' => ['302001', '302002', '302003', '302004', '302005'],
        'Jodhpur' => ['342001', '342002', '342003'],
        'Udaipur' => ['313001', '313002', '313003'],
        'Kota' => ['324001', '324002', '324003']
    ],
    'Tamil Nadu' => [
        'Chennai' => ['600001', '600002', '600003', '600004'],
        'Coimbatore' => ['641001', '641002', '641003'],
        'Madurai' => ['625001', '625002', '625003']
    ],
    'Uttar Pradesh' => [
        'Lucknow' => ['226001', '226002', '226003'],
        'Kanpur' => ['208001', '208002', '208003'],
        'Agra' => ['282001', '282002', '282003']
    ]
];

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

// Function to validate Indian city and state
function validateIndianLocation($city, $state, $locations) {
    // Check if state exists
    if (!isset($locations[$state])) {
        return ['valid' => false, 'message' => 'Invalid state! Please select a valid Indian state.'];
    }
    
    // Check if city exists in the state
    if (!isset($locations[$state][$city])) {
        return ['valid' => false, 'message' => 'Invalid city! Please select a valid city in ' . $state];
    }
    
    return ['valid' => true, 'message' => ''];
}

// Function to validate Indian PIN code format
function validateIndianPinCode($pin) {
    // Indian PIN code format: 6 digits
    return preg_match('/^[1-9][0-9]{5}$/', $pin);
}

$deviceTypes = ["Mobile", "Tablet", "SmartWatch", "Laptop", "Desktop", "Television"];

if(isset($_REQUEST['submitrequest'])){
 // Checking for empty fields 
 if(($_REQUEST['requestinfo'] == "") || ($_REQUEST['requestdesc'] == "") || ($_REQUEST['requestername'] == "") || ($_REQUEST['requesteradd1'] == "") || ($_REQUEST['requesteradd2'] == "") || ($_REQUEST['requestercity'] == "") || ($_REQUEST['requesterstate'] == "") || ($_REQUEST['requesterzip'] == "") || ($_REQUEST['requesteremail'] == "") || ($_REQUEST['requestermobile'] == "") || ($_REQUEST['requestdate'] == "")){
  $msg = "<div class='alert alert-warning col-sm-6 ml-5 mt-2'>Fill All Fields</div>";
 } else {
  // Validate date is not in past
  $requestDate = strtotime($_REQUEST['requestdate']);
  $today = strtotime(date('Y-m-d'));
  
  if($requestDate < $today) {
    $msg = "<div class='alert alert-warning col-sm-6 ml-5 mt-2'>Please select today or a future date</div>";
  } else {
    $rinfo = $_REQUEST['requestinfo'];
    $rdesc = $_REQUEST['requestdesc'];
    $rname = $_REQUEST['requestername'];
    $radd1 = $_REQUEST['requesteradd1'];
    $radd2 = $_REQUEST['requesteradd2'];
    $rcity = $_REQUEST['requestercity'];
    $rstate = $_REQUEST['requesterstate'];
    $rzip = $_REQUEST['requesterzip'];
    $remail = $_REQUEST['requesteremail'];
    $rmobile = $_REQUEST['requestermobile'];
    $rdate = $_REQUEST['requestdate'];

    // Validate email format and domain
    if(!filter_var($remail, FILTER_VALIDATE_EMAIL)) {
      $msg = "<div class='alert alert-warning col-sm-6 ml-5 mt-2'>Invalid email format!</div>";
    }
    elseif(!validateEmailDomain($remail)) {
      $msg = "<div class='alert alert-warning col-sm-6 ml-5 mt-2'>Invalid email domain! Please use a valid email address.</div>";
    }
    // Validate Indian PIN code format
    elseif(!validateIndianPinCode($rzip)) {
      $msg = "<div class='alert alert-warning col-sm-6 ml-5 mt-2'>Invalid PIN code format! Please enter a valid 6-digit PIN code.</div>";
    }
    // Validate Indian location
    else {
      $locationValidation = validateIndianLocation($rcity, $rstate, $indianLocations);
      if (!$locationValidation['valid']) {
        $msg = "<div class='alert alert-warning col-sm-6 ml-5 mt-2'>" . $locationValidation['message'] . "</div>";
      }
      else {
        $sql = "INSERT INTO submitrequest_tb(request_info, request_desc, requester_name, requester_add1, requester_add2, requester_city, requester_state, requester_zip, requester_email, requester_mobile, request_date)VALUES('$rinfo', '$rdesc', '$rname', '$radd1', '$radd2', '$rcity', '$rstate', '$rzip', '$remail', '$rmobile', '$rdate')";
        if($conn->query($sql) == TRUE){
          $genid = mysqli_insert_id($conn);
          $msg = "<div class='alert alert-success col-sm-6 ml-5 mt-2'>Request Submitted Sucessfully</div>";
          $_SESSION['myid'] = $genid;
          echo "<script> location.href='submitrequestsuccess.php'</script>";
        } else {
          $msg = "<div class='alert alert-danger col-sm-6 ml-5 mt-2'>Unable to Submit Your Request</div>";
        }
      }
    }
  }
 }
}
?>

<div class="container-fluid px-5">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <h3 class="text-center mb-4">Submit Service Request</h3>
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <form action="" method="POST">
            <div class="form-group">
              <label for="inputRequestInfo">Select Device Type</label>
              <select name="requestinfo" class="form-control" id="inputRequestInfo" required>
                <option value="">-- Select Device --</option>
                <?php foreach ($deviceTypes as $device) { echo "<option value='$device'>$device</option>"; } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="inputRequestDescription">Description</label>
              <input type="text" class="form-control" id="inputRequestDescription" placeholder="Write Description specify Device Model, what you want to get repaired" name="requestdesc" required>
            </div>
            <div class="form-group">
              <label for="inputName">Name</label>
              <input type="text" class="form-control" id="inputName" placeholder="" name="requestername" required>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputAddress">Address Line 1</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="" name="requesteradd1" required>
              </div>
              <div class="form-group col-md-6">
                <label for="inputAddress2">Address Line 2</label>
                <input type="text" class="form-control" id="inputAddress2" placeholder="" name="requesteradd2" required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputState">State</label>
                <select class="form-control" id="inputState" name="requesterstate" required>
                  <option value="">-- Select State --</option>
                  <?php foreach ($indianLocations as $state => $cities) { echo "<option value='$state'>$state</option>"; } ?>
                </select>
                <small class="form-text text-muted">Select your state</small>
              </div>
              <div class="form-group col-md-6">
                <label for="inputCity">City</label>
                <select class="form-control" id="inputCity" name="requestercity" required>
                  <option value="">-- Select City --</option>
                </select>
                <small class="form-text text-muted">Select your city</small>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inputZip">PIN Code</label>
                <input type="text" class="form-control" id="inputZip" name="requesterzip" pattern="[1-9][0-9]{5}" title="Enter a valid 6-digit Indian PIN code" onkeypress="isInputNumber(event)" maxlength="6" required>
                <small class="form-text text-muted">Enter 6-digit PIN code</small>
              </div>
              <div class="form-group col-md-4">
                <label for="inputEmail">Email</label>
                <input type="email" class="form-control" id="inputEmail" name="requesteremail" required>
                <small class="form-text text-muted">Enter a valid email address</small>
              </div>
              <div class="form-group col-md-4">
                <label for="inputMobile">Mobile</label>
                <input type="text" class="form-control" id="inputMobile" name="requestermobile" onkeypress="isInputNumber(event)" maxlength="10" required>
                <small class="form-text text-muted">Enter 10-digit mobile number</small>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inputDate">Date</label>
                <input type="date" class="form-control" id="inputDate" name="requestdate" 
                       min="<?php echo date('Y-m-d'); ?>" 
                       value="<?php echo date('Y-m-d'); ?>"
                       required>
                
              </div>
            </div>
            <div class="text-center mt-4">
              <button type="submit" class="btn btn-danger px-4 mr-3" name="submitrequest">Submit</button>
              <button type="reset" class="btn btn-secondary px-4">Reset</button>
            </div>
          </form>
          <?php if(isset($msg)){echo $msg;} ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Dynamic City Selection and Validation -->
<script>
const indianLocations = <?php echo json_encode($indianLocations); ?>;

document.getElementById('inputState').addEventListener('change', function() {
    const state = this.value;
    const citySelect = document.getElementById('inputCity');
    citySelect.innerHTML = '<option value="">-- Select City --</option>';
    
    if (state) {
        const cities = indianLocations[state];
        for (const city in cities) {
            const option = document.createElement('option');
            option.value = city;
            option.textContent = city;
            citySelect.appendChild(option);
        }
    }
});

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

