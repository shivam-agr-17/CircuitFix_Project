<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['add_to_cart'])){
   if($user_id == ''){
      $message[] = 'please login first!';
   }else{
      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $price = $_POST['price'];
      $price = filter_var($price, FILTER_SANITIZE_STRING);
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      $qty = isset($_POST['qty']) ? $_POST['qty'] : 1;
      $qty = filter_var($qty, FILTER_SANITIZE_STRING);

      // First check if product exists in cart
      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE pid = ? AND user_id = ?");
      $check_cart_numbers->execute([$pid, $user_id]);

      if($check_cart_numbers->rowCount() > 0){
         $cart_item = $check_cart_numbers->fetch(PDO::FETCH_ASSOC);
         if($cart_item['quantity'] >= 2){
            $message[] = 'maximum quantity reached!';
         }else{
            // Update quantity if less than 2
            $new_qty = $cart_item['quantity'] + $qty;
            if($new_qty > 2) $new_qty = 2;
            $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE pid = ? AND user_id = ?");
            $update_qty->execute([$new_qty, $pid, $user_id]);
            $message[] = 'cart quantity updated!';
         }
      }else{
         // If not in cart, add it
         $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
         $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
         $message[] = 'added to cart!';
      }
   }
}

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Quick view</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="quick-view">

   <h1 class="heading">Quick view</h1>

   <?php
     $pid = $_GET['pid'];
     $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?"); 
     $select_products->execute([$pid]);
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <div class="row">
         <div class="image-container">
            <div class="main-image">
               <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
            </div>
            <div class="sub-image">
               <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
               <img src="uploaded_img/<?= $fetch_product['image_02']; ?>" alt="">
               <img src="uploaded_img/<?= $fetch_product['image_03']; ?>" alt="">
            </div>
         </div>
         <div class="content">
            <div class="name"><?= $fetch_product['name']; ?></div>
            <div class="flex">
               <div class="price"><span>₹</span><?= $fetch_product['price']; ?><span>/-</span></div>
               <?php
                  $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE pid = ? AND user_id = ?");
                  $check_cart->execute([$fetch_product['id'], $user_id]);
                  if($check_cart->rowCount() > 0){
                     $cart_item = $check_cart->fetch(PDO::FETCH_ASSOC);
                     if($cart_item['quantity'] >= 2){
                        echo '<p class="stock">maximum quantity reached!</p>';
                     }else{
                        echo '<input type="number" name="qty" class="qty" min="1" max="2" value="1">';
                     }
                  }else{
                     echo '<input type="number" name="qty" class="qty" min="1" max="2" value="1">';
                  }
               ?>
            </div>
            <div class="details"><?= $fetch_product['details']; ?></div>
            <div class="flex-btn">
               <?php if($check_cart->rowCount() == 0 || ($check_cart->rowCount() > 0 && $cart_item['quantity'] < 2)){ ?>
                  <input type="submit" value="add to cart" class="btn" name="add_to_cart">
               <?php } ?>
               <input class="option-btn" type="submit" name="add_to_wishlist" value="add to wishlist">
            </div>
         </div>
      </div>
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>