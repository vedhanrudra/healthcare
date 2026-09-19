<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
   exit();
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
   $update_profile->execute([$name, $email, $user_id]);

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $prev_pass = $_POST['prev_pass'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   if($old_pass == $empty_pass){
      $message[] = 'please enter old password!';
   }elseif($old_pass != $prev_pass){
      $message[] = 'old password not matched!';
   }elseif($new_pass != $cpass){
      $message[] = 'confirm password not matched!';
   }else{
      if($new_pass != $empty_pass){
         $update_admin_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
         $update_admin_pass->execute([$cpass, $user_id]);
         $message[] = 'password updated successfully!';
      }else{
         $message[] = 'please enter a new password!';
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
   <title>Update Profile - HealthCare Rx</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="auth-section">

   <div class="auth-wrapper profile-update-wrapper">
      
      <div class="auth-form-card profile-card">
         <div class="form-header">
            <div class="form-pill"><i class="fas fa-user-shield"></i> Security & Profile</div>
            <h3>Account Settings</h3>
            <p>Update your personal information and change your password</p>
         </div>

         <form action="" method="post" class="modern-auth-form">
            <input type="hidden" name="prev_pass" value="<?= isset($fetch_profile["password"]) ? $fetch_profile["password"] : ''; ?>">

            <div class="form-section-title">
               <i class="fas fa-id-card"></i> Personal Information
            </div>

            <div class="input-group">
               <label for="update-name">Username</label>
               <div class="input-field-wrapper">
                  <i class="fas fa-user input-icon"></i>
                  <input type="text" id="update-name" name="name" required placeholder="enter your username" maxlength="20" class="box" value="<?= isset($fetch_profile["name"]) ? $fetch_profile["name"] : ''; ?>">
               </div>
            </div>

            <div class="input-group">
               <label for="update-email">Email Address</label>
               <div class="input-field-wrapper">
                  <i class="fas fa-envelope input-icon"></i>
                  <input type="email" id="update-email" name="email" required placeholder="enter your email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= isset($fetch_profile["email"]) ? $fetch_profile["email"] : ''; ?>">
               </div>
            </div>

            <div class="form-section-title" style="margin-top: 2rem;">
               <i class="fas fa-lock"></i> Change Password
            </div>

            <div class="input-group">
               <label for="update-old-pass">Current Password</label>
               <div class="input-field-wrapper">
                  <i class="fas fa-key input-icon"></i>
                  <input type="password" id="update-old-pass" name="old_pass" placeholder="enter your old password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               </div>
            </div>

            <div class="input-group">
               <label for="update-new-pass">New Password</label>
               <div class="input-field-wrapper">
                  <i class="fas fa-lock input-icon"></i>
                  <input type="password" id="update-new-pass" name="new_pass" placeholder="enter your new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               </div>
            </div>

            <div class="input-group">
               <label for="update-cpass">Confirm New Password</label>
               <div class="input-field-wrapper">
                  <i class="fas fa-check-double input-icon"></i>
                  <input type="password" id="update-cpass" name="cpass" placeholder="confirm your new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               </div>
            </div>

            <button type="submit" class="btn auth-submit-btn" name="submit">
               <span>Save Profile Changes</span>
               <i class="fas fa-check"></i>
            </button>
         </form>
      </div>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>