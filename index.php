<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="css/all.min.css">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
  <!-- Custom CSS (Project 1) -->
  <link rel="stylesheet" href="css/custom.css">
  <!-- Chatbot CSS -->
  <link rel="stylesheet" href="CHATBOT/style.css">
  <title>CircuitFix</title>
</head>

<body>
  <!-- Start Navigation -->
  <nav class="navbar navbar-expand-sm navbar-dark bg-danger fixed-top">
    <a href="index.php" class="navbar-brand">CircuitFix</a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#myMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="myMenu">
      <ul class="navbar-nav ml-auto custom-nav">
        <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="Admin/login.php" class="nav-link">Admin Login</a></li>
        <li class="nav-item"><a href="#Services" class="nav-link">Services</a></li>
        <li class="nav-item"><a href="#Contact" class="nav-link">Contact</a></li>
        <li class="nav-item"><a href="projectdone/home.php" class="nav-link">Shop</a></li>
      </ul>
    </div>
  </nav>
  <!-- End Navigation -->

  <!-- Start Header Jumbotron -->
  <header class="hero">
    <div class="hero-content">
      <h1>Welcome to CircuitFix</h1>
      <p>Customer's Happiness is our Aim</p>
      <div class="hero-buttons">
        <a href="Requester/RequesterLogin.php" class="btn login">Login</a>
        <a href="#registration" class="btn signup">Sign Up</a>
      </div>
    </div>
  </header>
  <!-- End Header Jumbotron -->

  <!-- Start Introduction Section -->
  <div class="container"
    style="color: black; font-size: 18px; padding: 15px 10px 10px 5px; background-color: rgba(255, 255, 255, 0.9);">
    <div class="jumbotron">
      <h3 class="text-center">About Us</h3>
      <p>
        CircuitFix Services is India's leading chain of multi-brand Electronics and Electrical service workshops
        offering a wide array of services. We focus on enhancing your usage experience by offering world-class
        Electronic Appliances maintenance services. Our sole mission is "To provide Electronic Appliances care services
        to keep the devices fit and healthy and customers happy and smiling".
        
        With well-equipped service centres and fully trained mechanics, we provide quality services with excellent
        packages designed to offer you great savings.
        
        Our state-of-art workshops are conveniently located in many cities across the country. Now you can book your
        service online by registering.
      </p>
    </div>
  </div>
  <!-- End Introduction Section -->

  <!-- Start Services Section -->
  <div class="container text-center border-bottom" id="Services"
    style="background-color: rgba(245, 241, 241, 0.9); color: black;">
    <h2>Our Services</h2>
    <div class="row mt-4">
      <div class="col-sm-4 mb-4">
        <a href="#"><i class="fas fa-tv fa-8x text-success"></i></a>
        <h4 class="mt-4">Electronic Appliances</h4>
      </div>
      <div class="col-sm-4 mb-4">
        <a href="#"><i class="fas fa-sliders-h fa-8x text-primary"></i></a>
        <h4 class="mt-4">Preventive Maintenance</h4>
      </div>
      <div class="col-sm-4 mb-4">
        <a href="#"><i class="fas fa-cogs fa-8x text-info"></i></a>
        <h4 class="mt-4">Fault Repair</h4>
      </div>
    </div>
  </div>
  <!-- End Services Section -->

  <!-- Start Registration Form -->
  <?php include('UserRegistration.php'); ?>
  <!-- End Registration Form -->

  <!-- Start Happy Customer -->
  <div class="jumbotron bg-danger">
    <div class="container">
      <h2 class="text-center text-white">Customer Reviews</h2>
      <div class="row mt-5">
        <div class="col-lg-3 col-sm-6">
          <div class="card shadow-lg mb-2">
            <div class="card-body text-center">
              <img src="images/avtar1.jpeg" class="img-fluid" style="border-radius:100px;" alt="avt1">
              <h4 class="card-title">Rahul Kumar</h4>
              <p class="card-text">"I had an issue with my laptop, and CircuitFix repaired it within a day! The staff
                was friendly, and the service was top-notch. Highly recommended!"</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card shadow-lg mb-2">
            <div class="card-body text-center">
              <img src="images/avtar2.jpeg" class="img-fluid" style="border-radius:100px;" alt="avt2">
              <h4 class="card-title">Sonam Sharma</h4>
              <p class="card-text">"My smartwatch stopped working, and I was worried about losing all my data.
                CircuitFix handled it professionally and returned it working like new!"</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card shadow-lg mb-2">
            <div class="card-body text-center">
              <img src="images/avtar3.jpeg" class="img-fluid" style="border-radius:100px;" alt="avt3">
              <h4 class="card-title">Sumit Vyas</h4>
              <p class="card-text">"Got my gaming console fixed here. The pricing was fair, and the service was quick.
                Only reason for 4 stars is that they took an extra day than promised."</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="card shadow-lg mb-2">
            <div class="card-body text-center">
              <img src="images/avtar4.jpeg" class="img-fluid" style="border-radius:100px;" alt="avt4">
              <h4 class="card-title">Jyoti Sinha</h4>
              <p class="card-text">"I had issues with my PC, and their support team guided me over the phone before even
                asking me to bring it in. Really appreciate their honesty and professionalism!"</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Happy Customer -->

  <!-- Integrated Chatbot Code () -->


  <!-- Start Contact US -->
  <div id="Contact">
    <?php include('contactform.php'); ?>
  </div>
  <!-- End Contact US -->

  <!-- Start Footer -->
  <footer class="container-fluid bg-dark mt-5 text-white">
    <div class="container">
      <div class="row py-3">
        <div class="col-md-6">
          <span class="pr-2">Follow Us: </span>
          <a href="https://www.facebook.com/login/" target="_blank" class="pr-2 fi-color"><i
              class="fab fa-facebook-f"></i></a>
          <a href="https://x.com/i/flow/login" target="_blank" class="pr-2 fi-color"><i class="fab fa-twitter"></i></a>
          <a href="https://www.youtube.com/" target="_blank" class="pr-2 fi-color"><i class="fab fa-youtube"></i></a>
          <a href="https://www.google.com/" target="_blank" class="pr-2 fi-color"><i
              class="fab fa-google-plus-g"></i></a>
        </div>
        <div class="col-md-6 text-right">
          <small>Designed by CircuitFix &copy; 2025</small>
        </div>
      </div>
    </div>
  </footer>
  <!-- End Footer -->

  <!-- JavaScript Files -->
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/all.min.js"></script>
  <!-- Chatbot JavaScript -->
  <script src="CHATBOT/script.js"></script>

  <!-- Chatbot HTML -->
  <div id="chatbot-icon">💬</div>
  <div id="chatbot-container" class="hidden">
    <div id="chatbot-header">
      <span>CircuitFix AI</span>
      <button id="close-btn">&times;</button>
    </div>
    <div id="chatbot-body">
      <div id="chatbot-messages"></div>
    </div>
    <div id="chatbot-input-container">
      <input type="text" id="chatbot-input" placeholder="Type a message" />
      <button id="send-btn">Send</button>
    </div>
  </div>
</body>

</html>