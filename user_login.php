<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
      header('location:home.php');
   }else{
      $message[] = 'incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Patient & Customer Login - HealthCare Rx</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="auth-section">

   <div class="auth-wrapper">
      
      <!-- Brand & Trust Side Banner -->
      <div class="auth-side-banner">
         <div class="banner-badge">
            <i class="fas fa-heart-pulse"></i> Trusted Healthcare
         </div>
         <h2>Your Trusted Online Pharmacy & Health Partner</h2>
         <p>Access your digital prescriptions, reorder medications seamlessly, and track home deliveries with medical-grade security.</p>
         
         <div class="auth-features">
            <div class="feature-item">
               <div class="feature-icon"><i class="fas fa-truck-medical"></i></div>
               <div>
                  <h4>Fast 2-Hour Delivery</h4>
                  <p>Express doorstep delivery for emergency supplies.</p>
               </div>
            </div>
            <div class="feature-item">
               <div class="feature-icon"><i class="fas fa-shield-check"></i></div>
               <div>
                  <h4>100% Genuine Meds</h4>
                  <p>Certified direct from licensed pharmaceutical makers.</p>
               </div>
            </div>
            <div class="feature-item">
               <div class="feature-icon"><i class="fas fa-user-doctor"></i></div>
               <div>
                  <h4>Expert Pharmacist Support</h4>
                  <p>Free consultation for dosage & medication guidance.</p>
               </div>
            </div>
         </div>

         <div class="banner-footer">
            <span><i class="fas fa-lock"></i> 256-Bit SSL Encrypted Health Vault</span>
         </div>
      </div>

      <!-- Login Form Card -->
      <div class="auth-form-card">
         <div class="form-header">
            <div class="form-pill"><i class="fas fa-key"></i> Account Access</div>
            <h3>Welcome Back</h3>
            <p>Please enter your registered email and password</p>
         </div>

         <form action="" method="post" class="modern-auth-form">
            
            <div class="input-group">
               <label for="login-email">Email Address</label>
               <div class="input-field-wrapper">
                  <i class="fas fa-envelope input-icon"></i>
                  <input type="email" id="login-email" name="email" required placeholder="patient@example.com" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               </div>
            </div>

            <div class="input-group">
               <label for="login-pass">Password</label>
               <div class="input-field-wrapper">
                  <i class="fas fa-lock input-icon"></i>
                  <input type="password" id="login-pass" name="pass" required placeholder="••••••••••••" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               </div>
            </div>

            <button type="submit" class="btn auth-submit-btn" name="submit">
               <span>Sign In to Account</span>
               <i class="fas fa-arrow-right"></i>
            </button>

            <div class="form-divider">
               <span>Don't have an account yet?</span>
            </div>

            <a href="user_register.php" class="option-btn register-link-btn">
               <i class="fas fa-user-plus"></i> Create New Patient Account
            </a>
         </form>
      </div>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js?v=<?php echo time(); ?>"></script>

</body>
</html>