<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

// Indian locations array
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

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   
   // Email validation
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $message[] = 'Invalid email format!';
   } else {
      // Get domain from email
      $domain = substr(strrchr($email, "@"), 1);
      // Check if domain has valid MX record
      if (!checkdnsrr($domain, 'MX')) {
         $message[] = 'Invalid email domain!';
      } else {
         $method = $_POST['method'];
         $method = filter_var($method, FILTER_SANITIZE_STRING);
         $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
         $address = filter_var($address, FILTER_SANITIZE_STRING);
         $total_products = $_POST['total_products'];
         $total_price = $_POST['total_price'];

         $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $check_cart->execute([$user_id]);

         if($check_cart->rowCount() > 0){
            $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
            $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart->execute([$user_id]);

            $message[] = 'order placed successfully!';
         }else{
            $message[] = 'your cart is empty';
         }
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>Your Orders</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
         <p> <?= $fetch_cart['name']; ?> <span>(<?= '₹'.$fetch_cart['price'].'/- x '. $fetch_cart['quantity']; ?>)</span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <div class="grand-total">Grand Total : <span>₹<?= $grand_total; ?>/-</span></div>
      </div>

      <h3>place your orders</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Name</span>
            <input type="text" name="name" placeholder="enter your name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>Your Number :</span>
            <input type="number" name="number" placeholder="enter your number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
         </div>
         <div class="inputBox">
            <span>Your Email :</span>
            <input type="email" name="email" placeholder="enter your email" class="box" maxlength="50" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address">
         </div>
         <div class="inputBox">
            <span>Mode of Payment :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">Cash On Delivery</option>
               <option value="credit card">credit card</option>
               <option value="paytm">UPI</option>
               <option value="paypal">Wallet</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Address line 01 :</span>
            <input type="text" name="flat" placeholder="e.g. Flat number" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Address line 02 :</span>
            <input type="text" name="street" placeholder="Street name" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>State :</span>
            <select name="state" id="state" class="box" required>
               <option value="">Select State</option>
               <?php
                  foreach($indianLocations as $state => $cities) {
                     echo "<option value='$state'>$state</option>";
                  }
               ?>
            </select>
         </div>
         <div class="inputBox">
            <span>City :</span>
            <select name="city" id="city" class="box" required>
               <option value="">Select City</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Country :</span>
            <input type="text" name="country" value="India" class="box" readonly required>
         </div>
         <div class="inputBox">
            <span>PIN CODE :</span>
            <input type="number" name="pin_code" placeholder="e.g. 302017" class="box" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="place order">

   </form>

</section>

<?php include 'components/footer.php'; ?>

<script>
// Get the dropdown elements
const stateSelect = document.getElementById('state');
const citySelect = document.getElementById('city');

// Indian locations object
const locations = <?php echo json_encode($indianLocations); ?>;

// Update cities when state changes
stateSelect.addEventListener('change', function() {
    const selectedState = this.value;
    citySelect.innerHTML = '<option value="">Select City</option>';
    
    if (selectedState && locations[selectedState]) {
        Object.keys(locations[selectedState]).forEach(city => {
            citySelect.innerHTML += `<option value="${city}">${city}</option>`;
        });
    }
});
</script>

<script src="js/script.js"></script>

</body>
</html>