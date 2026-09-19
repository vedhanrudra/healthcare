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

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Orders & Prescriptions - HealthCareRx</title>

   <!-- Google Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
   
   <!-- Font Awesome 6 -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<!-- Breadcrumb -->
<div class="page-banner compact">
   <div class="banner-inner">
      <div class="breadcrumb">
         <a href="home.php"><i class="fas fa-house"></i> Home</a>
         <i class="fas fa-chevron-right separator"></i>
         <span>Order History</span>
      </div>
      <h1 class="page-title">My Orders & Prescriptions</h1>
      <p class="page-desc">Track real-time shipment status, review medicine orders, and reorder easily.</p>
   </div>
</div>

<section class="orders-page-section">

   <div class="orders-container">

   <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY id DESC");
      $select_orders->execute([$user_id]);
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
            $is_completed = (strtolower($fetch_orders['payment_status']) == 'completed');
   ?>
   <div class="order-detail-card">
      
      <!-- Order Card Top Bar -->
      <div class="order-card-header">
         <div class="order-id-meta">
            <span class="order-tag">Order #HRX-<?= $fetch_orders['id']; ?></span>
            <span class="order-date"><i class="fas fa-calendar-days"></i> Placed on: <?= htmlspecialchars($fetch_orders['placed_on']); ?></span>
         </div>
         <div class="order-status-badge <?= $is_completed ? 'status-completed' : 'status-pending'; ?>">
            <i class="fas <?= $is_completed ? 'fa-check-circle' : 'fa-clock'; ?>"></i>
            Payment: <?= htmlspecialchars(ucfirst($fetch_orders['payment_status'])); ?>
         </div>
      </div>

      <!-- Authentic Status Summary Bar -->
      <div class="order-status-strip <?= $is_completed ? 'status-strip-completed' : 'status-strip-pending'; ?>">
         <div class="status-strip-icon">
            <i class="fas <?= $is_completed ? 'fa-circle-check' : 'fa-hourglass-half'; ?>"></i>
         </div>
         <div class="status-strip-text">
            <strong>Order Status: <?= $is_completed ? 'Completed & Confirmed' : 'Pending Verification'; ?></strong>
            <span><?= $is_completed ? 'Your payment and order have been processed successfully by the dispensary.' : 'Your order has been received and is awaiting dispensary verification.'; ?></span>
         </div>
      </div>

      <!-- Order Details Grid -->
      <div class="order-info-grid">
         
         <!-- Items Ordered -->
         <div class="order-info-col">
            <h4><i class="fas fa-prescription-bottle-medical"></i> Medicines Ordered</h4>
            <div class="order-items-box">
               <p><?= htmlspecialchars($fetch_orders['total_products']); ?></p>
            </div>
         </div>

         <!-- Delivery Address & Recipient -->
         <div class="order-info-col">
            <h4><i class="fas fa-location-dot"></i> Delivery Address</h4>
            <div class="order-address-box">
               <strong><?= htmlspecialchars($fetch_orders['name']); ?></strong>
               <p><i class="fas fa-phone"></i> <?= htmlspecialchars($fetch_orders['number']); ?></p>
               <p><i class="fas fa-envelope"></i> <?= htmlspecialchars($fetch_orders['email']); ?></p>
               <p><i class="fas fa-map-pin"></i> <?= htmlspecialchars($fetch_orders['address']); ?></p>
            </div>
         </div>

         <!-- Payment & Total Price -->
         <div class="order-info-col price-col">
            <h4><i class="fas fa-receipt"></i> Payment Summary</h4>
            <div class="order-price-summary">
               <div class="summary-line">
                  <span>Payment Mode:</span>
                  <strong><?= htmlspecialchars(strtoupper($fetch_orders['method'])); ?></strong>
               </div>
               <div class="summary-line">
                  <span>Total Amount:</span>
                  <strong class="order-grand-price">₹<?= $fetch_orders['total_price']; ?>/-</strong>
               </div>
               <div class="support-shortcut">
                  <a href="contact.php" class="btn btn-secondary btn-sm"><i class="fas fa-headset"></i> Need Help with this Order?</a>
               </div>
            </div>
         </div>

      </div>

   </div>
   <?php
         }
      }else{
         echo '<div class="empty-state"><div class="empty-icon-wrap"><i class="fas fa-clipboard-question"></i></div><h2>No Orders Placed Yet</h2><p>You have not placed any orders with HealthCareRx yet.</p><a href="shop.php" class="btn btn-primary" style="width:auto;margin-top:2rem;"><i class="fas fa-prescription-bottle"></i> Browse Medicines & Products</a></div>';
      }
   ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js?v=<?php echo time(); ?>"></script>

</body>
</html>