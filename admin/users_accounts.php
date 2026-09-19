<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_user->execute([$delete_id]);
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_orders->execute([$delete_id]);
   $delete_messages = $conn->prepare("DELETE FROM `messages` WHERE user_id = ?");
   $delete_messages->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:users_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css?v=<?php echo time(); ?>">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<div class="container-admin">
   <?php include '../components/left-menu.php'; ?>

   <section class="accounts">

      <h1 class="heading"><i class="fas fa-users"></i> Registered Patients & Users</h1>

      <div class="box-container">

      <?php
         $select_accounts = $conn->prepare("SELECT * FROM `users` ORDER BY id DESC");
         $select_accounts->execute();
         if($select_accounts->rowCount() > 0){
            while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
      ?>
      <div class="box">
         <div style="display: flex; align-items: center; gap: 1.2rem; margin-bottom: 1.5rem;">
            <div class="avatar-chip" style="width: 4.4rem; height: 4.4rem; font-size: 1.8rem; background: linear-gradient(135deg, var(--secondary), #0D9488);">
               <i class="fas fa-hospital-user"></i>
            </div>
            <div>
               <h4 style="font-size: 1.7rem; font-weight: 800; color: var(--text-main);"><?= htmlspecialchars($fetch_accounts['name']); ?></h4>
               <span style="font-size: 1.2rem; color: var(--secondary); font-weight: 700;">Patient ID #<?= $fetch_accounts['id']; ?></span>
            </div>
         </div>
         <p><i class="fas fa-envelope"></i> Email : <span><?= htmlspecialchars($fetch_accounts['email']); ?></span></p>
         <div style="margin-top: 1.5rem;">
            <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('Delete this patient account? Associated cart, wishlist, and orders will also be deleted!')" class="delete-btn"><i class="fas fa-trash-can"></i> Delete Patient Account</a>
         </div>
      </div>
      <?php
            }
         }else{
            echo '<p class="empty"><i class="fas fa-users-slash"></i> No patient accounts registered yet!</p>';
         }
      ?>

      </div>

   </section>

</div>

<script src="../js/admin_script.js?v=<?php echo time(); ?>"></script>












<script src="../js/admin_script.js"></script>
   
</body>
</html>