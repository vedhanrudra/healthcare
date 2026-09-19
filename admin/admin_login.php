<?php

include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if($select_admin->rowCount() > 0){
      $_SESSION['admin_id'] = $row['id'];
      header('location:dashboard.php');
      exit;
   }else{
      $message[] = 'Incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>HealthCareRx — Administrator Portal Login</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css?v=<?php echo time(); ?>">

</head>
<body class="auth-body">

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <div class="msg-text">
               <i class="fas fa-triangle-exclamation"></i>
               <span>'.$message.'</span>
            </div>
            <i class="fas fa-times" onclick="this.parentElement.remove();" title="Dismiss"></i>
         </div>
         ';
      }
   }
?>

<section class="form-container">

   <div class="admin-login-wrapper">
      <div class="login-brand-header">
         <div class="logo-mark"><i class="fas fa-plus"></i></div>
         <h2>HealthCare<span class="logo-accent">Rx</span></h2>
         <span class="portal-badge"><i class="fas fa-shield-halved"></i> Dispensary Management Portal</span>
         <p class="portal-subtitle">Secure administrative access for pharmacy staff</p>
      </div>

      <form action="" method="post" class="admin-auth-card">
         <h3>Staff Sign In</h3>
         
         <div class="input-field-group">
            <label for="admin-name">Username</label>
            <div class="input-with-icon">
               <i class="fas fa-user-shield"></i>
               <input type="text" id="admin-name" name="name" required placeholder="Enter admin username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            </div>
         </div>

         <div class="input-field-group">
            <label for="admin-pass">Password</label>
            <div class="input-with-icon">
               <i class="fas fa-lock"></i>
               <input type="password" id="admin-pass" name="pass" required placeholder="Enter password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            </div>
         </div>

         <button type="submit" name="submit" class="btn btn-primary btn-block">
            <i class="fas fa-arrow-right-to-bracket"></i> Sign In to Dashboard
         </button>

         <div class="login-helper-note">
            <i class="fas fa-circle-info"></i> Default System Credentials: <strong>admin</strong> / <strong>111</strong>
         </div>

         <div class="storefront-link-box">
            <a href="../home.php"><i class="fas fa-arrow-left"></i> Return to Customer Storefront</a>
         </div>
      </form>
   </div>

</section>
   
</body>
</html>