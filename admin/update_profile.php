<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   $update_profile_name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
   $update_profile_name->execute([$name, $admin_id]);

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $prev_pass = $_POST['prev_pass'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = sha1($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if($old_pass == $empty_pass){
      $message[] = 'please enter old password!';
   }elseif($old_pass != $prev_pass){
      $message[] = 'old password not matched!';
   }elseif($new_pass != $confirm_pass){
      $message[] = 'confirm password not matched!';
   }else{
      if($new_pass != $empty_pass){
         $update_admin_pass = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
         $update_admin_pass->execute([$confirm_pass, $admin_id]);
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
   <title>update profile</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css?v=<?php echo time(); ?>">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<div class="container-admin">
   <?php include '../components/left-menu.php'; ?>
   <section class="form-container" style="min-height: calc(100vh - 8rem);">

      <div class="admin-login-wrapper">
         <form action="" method="post" class="admin-auth-card">
            <div class="metric-icon-wrap icon-blue" style="margin: 0 auto 1.5rem auto;">
               <i class="fas fa-user-gear"></i>
            </div>
            <h3>Update Admin Profile</h3>
            <p style="text-align: center; color: var(--text-muted); font-size: 1.35rem; margin-bottom: 2rem;">Modify username or change access password</p>

            <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">

            <div class="input-field-group">
               <label for="prof-name">Username</label>
               <div class="input-with-icon">
                  <i class="fas fa-user"></i>
                  <input type="text" id="prof-name" name="name" value="<?= htmlspecialchars($fetch_profile['name']); ?>" required placeholder="Enter username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               </div>
            </div>

            <div class="input-field-group">
               <label for="prof-oldpass">Current Password</label>
               <div class="input-with-icon">
                  <i class="fas fa-key"></i>
                  <input type="password" id="prof-oldpass" name="old_pass" placeholder="Enter current password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               </div>
            </div>

            <div class="input-field-group">
               <label for="prof-newpass">New Password</label>
               <div class="input-with-icon">
                  <i class="fas fa-lock"></i>
                  <input type="password" id="prof-newpass" name="new_pass" placeholder="Enter new password (optional)" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               </div>
            </div>

            <div class="input-field-group">
               <label for="prof-cpass">Confirm New Password</label>
               <div class="input-with-icon">
                  <i class="fas fa-shield-check"></i>
                  <input type="password" id="prof-cpass" name="confirm_pass" placeholder="Confirm new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               </div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary btn-block">
               <i class="fas fa-check"></i> Save Changes
            </button>
         </form>
      </div>

   </section>

</div>

<script src="../js/admin_script.js?v=<?php echo time(); ?>"></script>
   
</body>
</html>