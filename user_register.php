<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email,]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $message[] = 'email already exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?,?,?)");
         $insert_user->execute([$name, $email, $cpass]);
         $message[] = 'registered successfully, login now please!';
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
   <title>Create Account - HealthCare Rx</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="auth-section">

   <div class="auth-wrapper">
      
      <!-- Brand & Benefits Side Banner -->
      <div class="auth-side-banner">
         <div class="banner-badge">
            <i class="fas fa-sparkles"></i> Patient Membership
         </div>
         <h2>Join HealthCare Rx for Seamless Healthcare</h2>
         <p>Create your patient profile to get personalized health reminders, instant prescription refills, and exclusive discounts.</p>
         
         <div class="auth-features">
            <div class="feature-item">
               <div class="feature-icon"><i class="fas fa-percentage"></i></div>
               <div>
                  <h4>Up to 25% Off Prescriptions</h4>
                  <p>Save more on verified chronic care and wellness products.</p>
               </div>
            </div>
            <div class="feature-item">
               <div class="feature-icon"><i class="fas fa-clock-rotate-left"></i></div>
               <div>
                  <h4>1-Click Quick Reorder</h4>
                  <p>Easily repeat past medicine orders in seconds.</p>
               </div>
            </div>
            <div class="feature-item">
               <div class="feature-icon"><i class="fas fa-file-waveform"></i></div>
               <div>
                  <h4>Digital Health History</h4>
                  <p>Keep a clear record of your purchases and prescriptions.</p>
               </div>
            </div>
         </div>

         <div class="banner-footer">
            <span><i class="fas fa-shield-halved"></i> HIPAA-Compliant Data Security</span>
         </div>
      </div>

      <!-- Registration Form Card -->
      <div class="auth-form-card">
         <div class="form-header">
            <div class="form-pill"><i class="fas fa-user-plus"></i> New Patient</div>
            <h3>Create an Account</h3>
            <p>Fill out the details below to complete your registration</p>
         </div>

         <form action="" method="post" class="modern-auth-form">
            
            <div class="input-group">
               <label for="reg-name">Full Username</label>
               <div class="input-field-wrapper">
                  <i class="fas fa-user input-icon"></i>
                  <input type="text" id="reg-name" name="name" required placeholder="e.g. John Doe" maxlength="20" class="box">
               </div>
            </div>

            <div class="input-group">
               <label for="reg-email">Email Address</label>
               <div class="input-field-wrapper">
                  <i class="fas fa-envelope input-icon"></i>
                  <input type="email" id="reg-email" name="email" required placeholder="name@example.com" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               </div>
            </div>

            <div class="input-group">
               <label for="reg-pass">Create Password</label>
               <div class="input-field-wrapper">
                  <i class="fas fa-lock input-icon"></i>
                  <input type="password" id="reg-pass" name="pass" required placeholder="At least 6 characters" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               </div>
            </div>

            <div class="input-group">
               <label for="reg-cpass">Confirm Password</label>
               <div class="input-field-wrapper">
                  <i class="fas fa-check-double input-icon"></i>
                  <input type="password" id="reg-cpass" name="cpass" required placeholder="Re-enter password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               </div>
            </div>

            <button type="submit" class="btn auth-submit-btn" name="submit">
               <span>Complete Registration</span>
               <i class="fas fa-arrow-right"></i>
            </button>

            <div class="form-divider">
               <span>Already have an account?</span>
            </div>

            <a href="user_login.php" class="option-btn register-link-btn">
               <i class="fas fa-arrow-right-to-bracket"></i> Sign In to Existing Account
            </a>
         </form>
      </div>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>