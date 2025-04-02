<?php
// The contact Us Form wont work with Local Host but it will work on Live Server
include 'dbConnection.php';

if(isset($_REQUEST['submit'])) {
    // Initialize error array
    $errors = array();
    
    // Validate name
    $name = trim($_REQUEST['name']);
    if(empty($name)) {
        $errors[] = "Name is required";
    }
    
    // Validate email
    $email = trim($_REQUEST['email']);
    if(empty($email)) {
        $errors[] = "Email is required";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
 } else {
        // Get domain from email
        $domain = substr(strrchr($email, "@"), 1);
        // Check if domain has valid MX record
        if(!checkdnsrr($domain, 'MX')) {
            $errors[] = "Invalid email domain";
        }
    }
    
    // Validate subject
    $subject = trim($_REQUEST['subject']);
    if(empty($subject)) {
        $errors[] = "Subject is required";
    }
    
    // Validate message
    $message = trim($_REQUEST['message']);
    if(empty($message)) {
        $errors[] = "Message is required";
    }
    
    // If no errors, proceed with submission
    if(empty($errors)) {
        $date = date('Y-m-d H:i:s');

        // Insert into database
        $sql = "INSERT INTO contact_submissions (name, email, subject, message, submission_date) 
                VALUES (?, ?, ?, ?, ?)";
                
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $subject, $message, $date);
        
        if(mysqli_stmt_execute($stmt)) {
            echo "<script>
                    alert('Thank you for your message. We will get back to you soon!');
                    window.location.href = 'index.php#Contact';
                  </script>";
        } else {
            echo "<script>
                    alert('Sorry, there was an error sending your message. Please try again.');
                    window.location.href = 'index.php#Contact';
                  </script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        // Display errors
        echo "<script>alert('Please fix the following errors:\\n- " . implode("\\n- ", $errors) . "');</script>";
    }
}
?>

<div class="container-fluid px-4" style="background-color: rgba(0, 0, 0, 0.9); color: white; padding: 50px 0;">
    <div class="row justify-content-center">
        <div class="col-12 text-center mb-5">
            <h1 class="text-white display-4">Contact Us</h1>
            <div class="red-divider"></div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <p class="mb-4">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
            
            <div class="contact-info">
                <div class="mb-4">
                    <h3 class="text-white mb-3">Address</h3>
                    <p class="mb-0">123 Circuit Street, Electronics City, 560100</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-white mb-3">Phone</h3>
                    <p class="mb-0">+91 98765 43210</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-white mb-3">Email</h3>
                    <p class="mb-0">support@circuitfix.com</p>
                </div>

                <div class="headquarter-info mt-4">
                    <h3 class="text-white mb-3">Headquarter:</h3>
                    <p class="mb-2">CircuitFix pvt Ltd,</p>
                    <p class="mb-2">Jagatpura, Jaipur</p>
                    <p class="mb-2">Rajasthan - 302017</p>
                    <p class="mb-2">Phone: +919785914423</p>
                    <p class="mb-0">www.CircuitFix.com</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-5">
            <form action="contactform.php" method="POST" class="contact-form bg-transparent" id="contactForm" onsubmit="return validateForm()">
                <div class="mb-4">
                    <input type="text" class="form-control bg-white" name="name" id="name" placeholder="Your Name" required>
                    <div class="invalid-feedback">Please enter your name.</div>
                </div>
                <div class="mb-4">
                    <input type="email" class="form-control bg-white" name="email" id="email" placeholder="Your Email" required>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>
                <div class="mb-4">
                    <input type="text" class="form-control bg-white" name="subject" id="subject" placeholder="Subject" required>
                    <div class="invalid-feedback">Please enter a subject.</div>
                </div>
                <div class="mb-4">
                    <textarea class="form-control bg-white" name="message" id="message" rows="6" placeholder="Your Message" required></textarea>
                    <div class="invalid-feedback">Please enter your message.</div>
                </div>
                <button type="submit" name="submit" class="btn btn-danger px-4 py-2">Send Message</button>
  </form>
        </div>
    </div>
</div>

<style>
.red-divider {
    height: 3px;
    width: 80px;
    background-color: #dc3545;
    margin: 20px auto;
}

.form-control {
    border: none;
    border-radius: 0;
    padding: 12px;
}

.form-control:focus {
    box-shadow: none;
    border: 1px solid #dc3545;
}

.contact-form .btn-danger {
    border-radius: 0;
    font-weight: 500;
}

.contact-info h3 {
    font-size: 1.2rem;
    font-weight: 500;
}

.contact-info p {
    color: #ccc;
}

.invalid-feedback {
    display: none;
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.form-control.is-invalid {
    border-color: #dc3545;
}

.form-control.is-invalid + .invalid-feedback {
    display: block;
}
</style>

<script>
function validateForm() {
    let isValid = true;
    const form = document.getElementById('contactForm');
    
    // Reset previous validation
    const inputs = form.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.classList.remove('is-invalid');
    });
    
    // Validate name
    const name = document.getElementById('name');
    if (!name.value.trim()) {
        name.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validate email
    const email = document.getElementById('email');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.value.trim() || !emailRegex.test(email.value.trim())) {
        email.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validate subject
    const subject = document.getElementById('subject');
    if (!subject.value.trim()) {
        subject.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validate message
    const message = document.getElementById('message');
    if (!message.value.trim()) {
        message.classList.add('is-invalid');
        isValid = false;
    }
    
    return isValid;
}
</script>