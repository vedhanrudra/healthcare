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
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
   $select_admin->execute([$name]);

   if($select_admin->rowCount() > 0){
      $message[] = 'username already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `admins`(name, password) VALUES(?,?)");
         $insert_admin->execute([$name, $cpass]);
         $message[] = 'new admin registered successfully!';
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
   <title>register admin</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css?v=<?php echo time(); ?>">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="form-container" style="min-height: calc(100vh - 8rem);">

   <div class="admin-login-wrapper">
      <form action="" method="post" class="admin-auth-card">
         <div class="metric-icon-wrap icon-blue" style="margin: 0 auto 1.5rem auto;">
            <i class="fas fa-user-plus"></i>
         </div>
         <h3>Register New Administrator</h3>
         <p style="text-align: center; color: var(--text-muted); font-size: 1.35rem; margin-bottom: 2rem;">Add an authorized dispensary staff member</p>
         
         <div class="input-field-group">
            <label for="admin-name">Username</label>
            <div class="input-with-icon">
               <i class="fas fa-user"></i>
               <input type="text" id="admin-name" name="name" required placeholder="Enter new username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            </div>
         </div>

         <div class="input-field-group">
            <label for="admin-pass">Password</label>
            <div class="input-with-icon">
               <i class="fas fa-lock"></i>
               <input type="password" id="admin-pass" name="pass" required placeholder="Enter password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            </div>
         </div>

         <div class="input-field-group">
            <label for="admin-cpass">Confirm Password</label>
            <div class="input-with-icon">
               <i class="fas fa-shield-check"></i>
               <input type="password" id="admin-cpass" name="cpass" required placeholder="Confirm password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            </div>
         </div>

         <button type="submit" name="submit" class="btn btn-primary btn-block">
            <i class="fas fa-user-check"></i> Register Admin Staff
         </button>

         <div style="text-align: center; margin-top: 1.5rem;">
            <a href="admin_accounts.php" style="font-size: 1.35rem; color: var(--text-muted);"><i class="fas fa-arrow-left"></i> Back to Staff Directory</a>
         </div>
      </form>
   </div>

</section>

<script src="../js/admin_script.js?v=<?php echo time(); ?>"></script>
   
</body>
</html>