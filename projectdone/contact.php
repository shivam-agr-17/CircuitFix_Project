<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

// Function to validate email DNS
function validateEmailDNS($email) {
    $domain = substr(strrchr($email, "@"), 1);
    return checkdnsrr($domain, 'MX');
}

if(isset($_POST['send'])){
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   // Server-side validation
   $errors = [];
   
   if(empty($name)) {
      $errors[] = 'Name is required';
   }
   
   if(empty($email)) {
      $errors[] = 'Email is required';
   } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = 'Invalid email format';
   } elseif(!validateEmailDNS($email)) {
      $errors[] = 'Invalid email domain';
   }
   
   if(empty($number)) {
      $errors[] = 'Phone number is required';
   } elseif(strlen($number) !== 10) {
      $errors[] = 'Phone number must be 10 digits';
   }
   
   if(empty($msg)) {
      $errors[] = 'Message is required';
   }

   if(empty($errors)) {
      $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
      $select_message->execute([$name, $email, $number, $msg]);

      if($select_message->rowCount() > 0){
         $message[] = 'already sent message!';
      }else{
         $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
         $insert_message->execute([$user_id, $name, $email, $number, $msg]);
         $message[] = 'sent message successfully!';
      }
   } else {
      foreach($errors as $error) {
         $message[] = $error;
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
   <title>Contact</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css?v=1.0.1">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="contact">
   <form action="" method="post" id="contactForm" onsubmit="return validateForm()">
      <h3>Get in touch.</h3>
      <input type="text" name="name" id="name" placeholder="enter your name" required maxlength="20" class="box">
      <div class="error-message" id="nameError"></div>
      
      <input type="email" name="email" id="email" placeholder="enter your email" required maxlength="50" class="box">
      <div class="error-message" id="emailError"></div>
      
      <input type="tel" name="number" id="number" pattern="[0-9]{10}" placeholder="enter your number" required maxlength="10" class="box">
      <div class="error-message" id="numberError"></div>
      
      <textarea name="msg" id="msg" class="box" placeholder="enter your message" cols="30" rows="10" required></textarea>
      <div class="error-message" id="msgError"></div>
      
      <input type="submit" value="send message" name="send" class="btn">
   </form>
</section>

<?php include 'components/footer.php'; ?>

<script>
function validateForm() {
    let isValid = true;
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const number = document.getElementById('number').value;
    const msg = document.getElementById('msg').value;

    // Reset error messages
    document.querySelectorAll('.error-message').forEach(elem => elem.textContent = '');

    // Name validation
    if (!name.trim()) {
        document.getElementById('nameError').textContent = 'Name is required';
        isValid = false;
    }

    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.trim()) {
        document.getElementById('emailError').textContent = 'Email is required';
        isValid = false;
    } else if (!emailRegex.test(email)) {
        document.getElementById('emailError').textContent = 'Please enter a valid email address';
        isValid = false;
    }

    // Phone number validation
    if (!number.trim()) {
        document.getElementById('numberError').textContent = 'Phone number is required';
        isValid = false;
    } else if (!/^[0-9]{10}$/.test(number)) {
        document.getElementById('numberError').textContent = 'Phone number must be 10 digits';
        isValid = false;
    }

    // Message validation
    if (!msg.trim()) {
        document.getElementById('msgError').textContent = 'Message is required';
        isValid = false;
    }

    return isValid;
}

// Real-time validation
document.getElementById('name').addEventListener('input', function() {
    if (!this.value.trim()) {
        document.getElementById('nameError').textContent = 'Name is required';
    } else {
        document.getElementById('nameError').textContent = '';
    }
});

document.getElementById('email').addEventListener('input', function() {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!this.value.trim()) {
        document.getElementById('emailError').textContent = 'Email is required';
    } else if (!emailRegex.test(this.value)) {
        document.getElementById('emailError').textContent = 'Please enter a valid email address';
    } else {
        document.getElementById('emailError').textContent = '';
    }
});

document.getElementById('number').addEventListener('input', function() {
    if (!this.value.trim()) {
        document.getElementById('numberError').textContent = 'Phone number is required';
    } else if (!/^[0-9]{10}$/.test(this.value)) {
        document.getElementById('numberError').textContent = 'Phone number must be 10 digits';
    } else {
        document.getElementById('numberError').textContent = '';
    }
});

document.getElementById('msg').addEventListener('input', function() {
    if (!this.value.trim()) {
        document.getElementById('msgError').textContent = 'Message is required';
    } else {
        document.getElementById('msgError').textContent = '';
    }
});
</script>

<style>
.error-message {
    color: #e74c3c;
    font-size: 1.4rem;
    margin-top: 0.5rem;
    margin-bottom: 1rem;
    display: none;
}

.error-message:not(:empty) {
    display: block;
}

.contact form .box {
    margin-bottom: 0.5rem;
}
</style>

<script src="js/script.js"></script>

</body>
</html>