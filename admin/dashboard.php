<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard — HealthCareRx Admin</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css?v=<?php echo time(); ?>">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<div class="container-admin">
   <?php include '../components/left-menu.php'; ?>

   <section class="dashboard">

      <div class="dashboard-header-banner">
         <div>
            <span class="badge-role"><i class="fas fa-shield-halved"></i> Dispensary Overview</span>
            <h1 class="page-main-heading">Dispensary Dashboard</h1>
            <p class="page-subtitle">Real-time summary of store performance, orders, patient accounts, and product inventory.</p>
         </div>
         <div class="header-action-links hide-mobile">
            <a href="products.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Medicine</a>
         </div>
      </div>

      <div class="box-container">

         <!-- Welcome Card -->
         <div class="box metric-card welcome-card">
            <div class="metric-icon-wrap icon-blue">
               <i class="fas fa-user-shield"></i>
            </div>
            <div class="metric-info">
               <span class="metric-label">Logged In Administrator</span>
               <h3 class="welcome-title"><?= htmlspecialchars($fetch_profile['name']); ?></h3>
            </div>
            <p class="metric-desc">Manage orders, stock, and patient inquiries</p>
            <a href="update_profile.php" class="btn btn-secondary-admin">
               <i class="fas fa-user-gear"></i> Update Profile
            </a>
         </div>

         <!-- Pending Orders Total -->
         <div class="box metric-card">
            <?php
               $total_pendings = 0;
               $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
               $select_pendings->execute(['pending']);
               if($select_pendings->rowCount() > 0){
                  while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                     $total_pendings += $fetch_pendings['total_price'];
                  }
               }
            ?>
            <div class="metric-icon-wrap icon-amber">
               <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="metric-info">
               <span class="metric-label">Total Pending Payments</span>
               <h3>₹<?= number_format($total_pendings); ?>/-</h3>
            </div>
            <p class="metric-desc">Awaiting processing or verification</p>
            <a href="placed_orders.php" class="btn btn-secondary-admin">
               <i class="fas fa-clipboard-list"></i> Review Orders
            </a>
         </div>

         <!-- Completed Orders Total -->
         <div class="box metric-card">
            <?php
               $total_completes = 0;
               $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
               $select_completes->execute(['completed']);
               if($select_completes->rowCount() > 0){
                  while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                     $total_completes += $fetch_completes['total_price'];
                  }
               }
            ?>
            <div class="metric-icon-wrap icon-emerald">
               <i class="fas fa-circle-check"></i>
            </div>
            <div class="metric-info">
               <span class="metric-label">Completed Revenue</span>
               <h3 class="text-emerald">₹<?= number_format($total_completes); ?>/-</h3>
            </div>
            <p class="metric-desc">Successfully processed dispensary orders</p>
            <a href="placed_orders.php" class="btn btn-secondary-admin">
               <i class="fas fa-receipt"></i> Completed Orders
            </a>
         </div>

         <!-- Orders Placed Count -->
         <div class="box metric-card">
            <?php
               $select_orders = $conn->prepare("SELECT * FROM `orders`");
               $select_orders->execute();
               $number_of_orders = $select_orders->rowCount();
            ?>
            <div class="metric-icon-wrap icon-indigo">
               <i class="fas fa-truck-ramp-box"></i>
            </div>
            <div class="metric-info">
               <span class="metric-label">Total Orders Placed</span>
               <h3><?= $number_of_orders; ?></h3>
            </div>
            <p class="metric-desc">All-time customer order placements</p>
            <a href="placed_orders.php" class="btn btn-secondary-admin">
               <i class="fas fa-list-check"></i> Manage All Orders
            </a>
         </div>

         <!-- Products In Stock -->
         <div class="box metric-card">
            <?php
               $select_products = $conn->prepare("SELECT * FROM `products`");
               $select_products->execute();
               $number_of_products = $select_products->rowCount();
            ?>
            <div class="metric-icon-wrap icon-teal">
               <i class="fas fa-pills"></i>
            </div>
            <div class="metric-info">
               <span class="metric-label">Medicines In Catalog</span>
               <h3><?= $number_of_products; ?></h3>
            </div>
            <p class="metric-desc">Active products available to customers</p>
            <a href="products.php" class="btn btn-secondary-admin">
               <i class="fas fa-boxes-stacked"></i> View Inventory
            </a>
         </div>

         <!-- Registered Users -->
         <div class="box metric-card">
            <?php
               $select_users = $conn->prepare("SELECT * FROM `users`");
               $select_users->execute();
               $number_of_users = $select_users->rowCount();
            ?>
            <div class="metric-icon-wrap icon-purple">
               <i class="fas fa-hospital-user"></i>
            </div>
            <div class="metric-info">
               <span class="metric-label">Registered Patients</span>
               <h3><?= $number_of_users; ?></h3>
            </div>
            <p class="metric-desc">Customer accounts on HealthCareRx</p>
            <a href="users_accounts.php" class="btn btn-secondary-admin">
               <i class="fas fa-users"></i> View Patients
            </a>
         </div>

         <!-- Admin Staff -->
         <div class="box metric-card">
            <?php
               $select_admins = $conn->prepare("SELECT * FROM `admins`");
               $select_admins->execute();
               $number_of_admins = $select_admins->rowCount();
            ?>
            <div class="metric-icon-wrap icon-slate">
               <i class="fas fa-user-shield"></i>
            </div>
            <div class="metric-info">
               <span class="metric-label">Authorized Admins</span>
               <h3><?= $number_of_admins; ?></h3>
            </div>
            <p class="metric-desc">Dispensary managers & staff accounts</p>
            <a href="admin_accounts.php" class="btn btn-secondary-admin">
               <i class="fas fa-id-card-clip"></i> Staff Directory
            </a>
         </div>

         <!-- New Inquiries -->
         <div class="box metric-card">
            <?php
               $select_messages = $conn->prepare("SELECT * FROM `messages`");
               $select_messages->execute();
               $number_of_messages = $select_messages->rowCount();
            ?>
            <div class="metric-icon-wrap icon-rose">
               <i class="fas fa-envelope-open-text"></i>
            </div>
            <div class="metric-info">
               <span class="metric-label">Customer Messages</span>
               <h3><?= $number_of_messages; ?></h3>
            </div>
            <p class="metric-desc">Support inquiries from Contact Us form</p>
            <a href="messages.php" class="btn btn-secondary-admin">
               <i class="fas fa-inbox"></i> Read Inquiries
            </a>
         </div>

      </div>

   </section>
</div>

<script src="../js/admin_script.js?v=<?php echo time(); ?>"></script>
   
</body>
</html>
