<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'You have already sent this message!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'Message sent successfully! Our pharmacist team will respond shortly.';

   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact & Pharmacist Support - HealthCareRx</title>

   <!-- Google Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
   
   <!-- Font Awesome 6 -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<!-- Breadcrumb & Header Banner -->
<div class="page-banner">
   <div class="banner-inner">
      <div class="breadcrumb">
         <a href="home.php"><i class="fas fa-house"></i> Home</a>
         <i class="fas fa-chevron-right separator"></i>
         <span>Contact Pharmacist Support</span>
      </div>
      <h1 class="page-title">We're Here For Your Health</h1>
      <p class="page-desc">Reach out to our licensed pharmacists for medication guidance, prescription questions, or delivery assistance.</p>
   </div>
</div>

<section class="contact-page-section">

   <div class="contact-grid">
      
      <!-- Left Column: Contact Information Cards -->
      <div class="contact-info-column">
         
         <div class="contact-info-card">
            <span class="info-card-badge"><i class="fas fa-clock"></i> 24/7 Available</span>
            <h2>Get in Touch Directly</h2>
            <p class="card-lead">Our clinical care and customer support team is on standby to assist you around the clock.</p>

            <div class="contact-channels">
               
               <div class="channel-item">
                  <div class="channel-icon"><i class="fas fa-phone-volume"></i></div>
                  <div class="channel-details">
                     <span>Pharmacist Helpline (Toll-Free)</span>
                     <strong><a href="tel:+919313945584">+91 9313945584</a></strong>
                     <small>Available 24 hours / 7 days a week</small>
                  </div>
               </div>

               <div class="channel-item">
                  <div class="channel-icon"><i class="fab fa-whatsapp"></i></div>
                  <div class="channel-details">
                     <span>WhatsApp Prescription Support</span>
                     <strong><a href="https://api.whatsapp.com/send?phone=919265781915" target="_blank">+91 9265781915</a></strong>
                     <small>Instant prescription verification</small>
                  </div>
               </div>

               <div class="channel-item">
                  <div class="channel-icon"><i class="fas fa-envelope-open-text"></i></div>
                  <div class="channel-details">
                     <span>Official Email</span>
                     <strong><a href="mailto:support@healthcarerx.com">support@healthcarerx.com</a></strong>
                     <small>Response within 2 hours</small>
                  </div>
               </div>

               <div class="channel-item">
                  <div class="channel-icon"><i class="fas fa-location-dot"></i></div>
                  <div class="channel-details">
                     <span>Pharmacy Dispensary Store</span>
                     <strong>HealthCareRx Central Pharmacy</strong>
                     <small>Ring Road, Surat, Gujarat - 395002</small>
                  </div>
               </div>

            </div>

            <!-- Emergency Note -->
            <div class="emergency-alert-box">
               <i class="fas fa-triangle-exclamation"></i>
               <span>For critical life-threatening medical emergencies, please dial your local emergency services (108 / 112) immediately.</span>
            </div>
         </div>

      </div>

      <!-- Right Column: Contact & Prescription Inquiry Form -->
      <div class="contact-form-column">
         
         <div class="contact-form-card">
            <div class="form-header">
               <span class="form-pill"><i class="fas fa-paper-plane"></i> Send Message</span>
               <h3>Send Us an Inquiry</h3>
               <p>Have a question regarding your order, medicines, or prescription? Leave us a message below.</p>
            </div>

            <form action="" method="post" class="modern-contact-form">
               
               <div class="input-group">
                  <label for="contact-name">Your Full Name</label>
                  <div class="input-field-wrapper">
                     <i class="fas fa-user input-icon"></i>
                     <input type="text" id="contact-name" name="name" required placeholder="e.g. Rahul Sharma" maxlength="50" class="box">
                  </div>
               </div>

               <div class="form-row-2">
                  <div class="input-group">
                     <label for="contact-email">Email Address</label>
                     <div class="input-field-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="contact-email" name="email" required placeholder="rahul@example.com" maxlength="50" class="box">
                     </div>
                  </div>

                  <div class="input-group">
                     <label for="contact-phone">Phone Number</label>
                     <div class="input-field-wrapper">
                        <i class="fas fa-phone input-icon"></i>
                        <input type="number" id="contact-phone" name="number" min="0" max="9999999999" class="box" required placeholder="10-digit number" onkeypress="if(this.value.length == 10) return false;">
                     </div>
                  </div>
               </div>

               <div class="input-group">
                  <label for="contact-msg">Message or Prescription Question</label>
                  <div class="input-field-wrapper">
                     <textarea id="contact-msg" name="msg" class="box textarea-field" required placeholder="Please describe your medicine question, prescription details, or order query..." cols="30" rows="6"></textarea>
                  </div>
               </div>

               <button type="submit" name="send" class="btn btn-primary btn-block btn-lg">
                  <i class="fas fa-paper-plane"></i> Submit Inquiry
               </button>

               <div class="privacy-note">
                  <i class="fas fa-lock"></i>
                  <span>Your medical details and contact information are strictly confidential and protected by healthcare privacy standards.</span>
               </div>
            </form>
         </div>

      </div>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>