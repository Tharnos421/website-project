<?php

require_once 'connect.php';


$success_message = "";
$error_message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    $name = $_POST["name"] ?? '';
    $email = $_POST["email"] ?? '';
    $message = $_POST["message"] ?? '';

   
    if (empty($name) || empty($email) || empty($message)) {
        $error_message = "Please fill in all required fields.";
    } else {
      
        $sql = "INSERT INTO contact_us (name, email, message) VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);

            
            if (mysqli_stmt_execute($stmt)) {
                $success_message = "Thank you for your message! We will get back to you shortly.";
                
            } else {
                
                error_log("Database Error saving contact message: " . mysqli_stmt_error($stmt));
                $error_message = "Error sending your message. Please try again."; 
            }

            
            mysqli_stmt_close($stmt);
        } else {
            
            error_log("Database Error preparing contact statement: " . mysqli_error($con));
            $error_message = "Error preparing statement. Please try again."; 
        }
    }
}


if (isset($con) && $con) {
    mysqli_close($con);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Contacts-Wildpath</title>
 <link rel="stylesheet" href="contacts.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="navigation-bar">
    <div id="head">
      <img id="icon" src="icon.jpeg" alt="Company Icon">
    </div>
    <div class="introduction">
      <div>
        <p class="Company-name">WILDPATH EXPEDITIONS</p>
      </div>
      <div id="services">
        <a href="home.html" class="service">HOME</a>
        <a href="activities.html" class="service">SERVICES</a>
        <a href="destinations.html" class="service">DESTINATIONS</a>
        <a href="contacts.php" class="service">CONTACT US</a>
                <a href="bookings.php" class="service">BOOKINGS</a>
            </div> </div></div> <div class="container">
                <video autoplay muted loop><source src="images/contact-video.mp4" type="video/mp4"></video>
     <div class="text">
      <p style="margin-bottom: 0; color: rgb(244, 188, 7);">Wildpath Expeditions</p>
      <p style="margin: 40px; text-align: center; ">Contact Us</p>
     </div>
  </div>
   <div>
     <p class="preamble2">
      We have branches in all parts of Uganda that enable us deliver efficient services to our customers.you can contact us on the following addresses below
     </p>
    </div><br><br>
   <div class="contact-section">
    <div class="form">
     <h1>We're Ready, lets talk</h1><br><br>

      <?php

// Display success or error messages after form submission
if ($success_message) {
echo '<p style="color: green; text-align: center;">' . htmlspecialchars($success_message) . '</p>';
}
if ($error_message) {
echo '<p style="color: red; text-align: center;">' . htmlspecialchars($error_message) . '</p>';
}
?>

    <form method="post">
    <input type="text" placeholder="Your Name" name="name" required><br><br>
    <input type="email" placeholder="Email Address" name="email" required><br><br>
    <textarea class="typing" placeholder="Message" name="message" required></textarea><br><br>
    <button class="message" type="submit">Send Message</button>
     </form>
    </div>
    <div class="contacts">
     <h1>Contact Info</h1>
     <h3>Address</h3>
     <p>Kampala Uganda Mabirizi Complex Shop L39</p>
     <h3>Email us</h3>
      <p>wildpathexpeditions2@gmail.com</p>
     <h3>Call us</h3>
     <p>+256-301-567123</p>
     <h3>Follow us</h3>
     <button class="follow">f</button>
     <button class="follow">in</button>
     <button class="follow">X</button>
    </div>
   </div>
    <div id="footer">
     <div class="left">
      <p class="footer-intro">More Information</p>
      <ul>
       <li class="info">About Us</li>
       <li class="info"> About Uganda</li>
       <li class="info">Special Places</li>
       <li class="info"> Travel Tips</li>
      </ul>
     </div>
     <div class="middle">
      <p class="footer-intro">Partners</p>
      <a href="https://www.iata.org/">
       <img class="partner" src="images/partner01.png" alt="IATA Partner">
      </a>
     <a href="https://www.tugata.com/">
      <img class="partner" src="images/partner02.png" alt="TUGATA Partner">
     </a>
     </div>
     <div class="right">
      <p class="footer-intro">Contacts</p>
       <p>Located In Kampala Uganda Mabirizi Complex Shop L39</p>
       <p>P.O.Box 139 Kampala Uganda</p>
       <p>Tel: +256 301 567 123</p>
       <p>Email: wildpathexpeditions2@gmail.com</p>
     </div>
    </div>
   </footer>
   <p style="text-align: center; ">Copyright &copy; 2025, Wildpath Expeditions . All Rights Reserved. Designed by: Group 8</p>
 </body>
</html>
