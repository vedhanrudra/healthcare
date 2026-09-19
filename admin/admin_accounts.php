<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admins = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
   $delete_admins->execute([$delete_id]);
   header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css?v=<?php echo time(); ?>">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<div class="container-admin">
   <?php include '../components/left-menu.php'; ?>

   <section class="accounts">

      <h1 class="heading"><i class="fas fa-user-shield"></i> Authorized Administrators</h1>

      <div class="box-container">

      <div class="box" style="text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center;">
         <div class="metric-icon-wrap icon-blue" style="margin: 0 auto 1.5rem auto;">
            <i class="fas fa-user-plus"></i>
         </div>
         <h4 style="font-size: 1.8rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.6rem;">Register New Staff</h4>
         <p style="font-size: 1.35rem; color: var(--text-muted); margin-bottom: 1.5rem;">Create a new administrator account</p>
         <a href="register_admin.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Admin Staff</a>
      </div>

      <?php
         $select_accounts = $conn->prepare("SELECT * FROM `admins`");
         $select_accounts->execute();
         if($select_accounts->rowCount() > 0){
            while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
      ?>
      <div class="box">
         <div style="display: flex; align-items: center; gap: 1.2rem; margin-bottom: 1.5rem;">
            <div class="avatar-chip" style="width: 4.4rem; height: 4.4rem; font-size: 1.8rem;">
               <i class="fas fa-user-shield"></i>
            </div>
            <div>
               <h4 style="font-size: 1.7rem; font-weight: 800; color: var(--text-main);"><?= htmlspecialchars($fetch_accounts['name']); ?></h4>
               <span style="font-size: 1.2rem; color: var(--primary); font-weight: 700;">Admin ID #<?= $fetch_accounts['id']; ?></span>
            </div>
         </div>
         <p><i class="fas fa-id-badge"></i> Role: <span>Dispensary Staff</span></p>
         <div class="flex-btn" style="margin-top: 1.5rem;">
            <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('Delete this admin account?');" class="delete-btn"><i class="fas fa-trash-can"></i> Delete</a>
            <?php
               if($fetch_accounts['id'] == $admin_id){
                  echo '<a href="update_profile.php" class="option-btn"><i class="fas fa-pen-to-square"></i> Update</a>';
               }
            ?>
         </div>
      </div>
      <?php
            }
         }else{
            echo '<p class="empty"><i class="fas fa-user-xmark"></i> No admin accounts available!</p>';
         }
      ?>

      </div>

   </section>

</div>

<script src="../js/admin_script.js?v=<?php echo time(); ?>"></script>











<script src="../js/admin_script.js"></script>
   
</body>
</html>