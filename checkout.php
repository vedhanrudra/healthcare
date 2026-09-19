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

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'Order placed successfully! Track it in your Orders dashboard.';
      header('location:orders.php');
      exit();
   }else{
      $message[] = 'Your shopping cart is currently empty.';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Secure Checkout - HealthCareRx</title>

   <!-- Google Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
   
   <!-- Font Awesome 6 -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<!-- Breadcrumb & Step Tracker -->
<div class="page-banner compact">
   <div class="banner-inner">
      <div class="breadcrumb">
         <a href="home.php"><i class="fas fa-house"></i> Home</a>
         <i class="fas fa-chevron-right separator"></i>
         <a href="cart.php">Cart</a>
         <i class="fas fa-chevron-right separator"></i>
         <span>Checkout</span>
      </div>
      <h1 class="page-title">Safe & Encrypted Checkout</h1>
   </div>
</div>

<!-- Checkout Steps Progress Bar -->
<div class="checkout-progress-bar">
   <div class="progress-steps-container">
      <div class="progress-step completed">
         <div class="step-circle"><i class="fas fa-check"></i></div>
         <span class="step-label">1. Cart Review</span>
      </div>
      <div class="step-connector active"></div>
      <div class="progress-step active">
         <div class="step-circle">2</div>
         <span class="step-label">2. Delivery Details</span>
      </div>
      <div class="step-connector"></div>
      <div class="progress-step">
         <div class="step-circle">3</div>
         <span class="step-label">3. Payment & Confirmation</span>
      </div>
   </div>
</div>

<section class="checkout-page-section">

   <?php
      $grand_total = 0;
      $cart_items = [];
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
            $cart_items[] = $fetch_cart['name'].' (₹'.$fetch_cart['price'].' x '. $fetch_cart['quantity'].')';
            $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
         }
      }
      $total_products = implode(', ', $cart_items);
   ?>

   <form action="" method="post" class="checkout-main-form">

      <input type="hidden" name="total_products" value="<?= htmlspecialchars($total_products); ?>">
      <input type="hidden" name="total_price" value="<?= $grand_total; ?>">

      <div class="checkout-grid">
         
         <!-- Left Column: Form Fields -->
         <div class="checkout-forms-pane">

            <!-- Section 1: Patient Details -->
            <div class="checkout-card">
               <div class="card-step-header">
                  <span class="step-num">1</span>
                  <div>
                     <h3>Patient Contact Information</h3>
                     <p>We will send order confirmation and dispatch updates here.</p>
                  </div>
               </div>

               <div class="form-row-2">
                  <div class="input-group">
                     <label for="co-name">Full Patient Name</label>
                     <div class="input-field-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="co-name" name="name" placeholder="e.g. John Doe" class="box" maxlength="20" required>
                     </div>
                  </div>

                  <div class="input-group">
                     <label for="co-phone">Mobile Phone Number</label>
                     <div class="input-field-wrapper">
                        <i class="fas fa-phone input-icon"></i>
                        <input type="number" id="co-phone" name="number" placeholder="10-digit mobile number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
                     </div>
                  </div>
               </div>

               <div class="input-group">
                  <label for="co-email">Email Address</label>
                  <div class="input-field-wrapper">
                     <i class="fas fa-envelope input-icon"></i>
                     <input type="email" id="co-email" name="email" placeholder="patient@example.com" class="box" maxlength="50" required>
                  </div>
               </div>
            </div>

            <!-- Section 2: Delivery Address -->
            <div class="checkout-card">
               <div class="card-step-header">
                  <span class="step-num">2</span>
                  <div>
                     <h3>Delivery Address</h3>
                     <p>Exact doorstep address where medicines will be delivered.</p>
                  </div>
               </div>

               <div class="form-row-2">
                  <div class="input-group">
                     <label for="co-flat">Flat / House / Floor No.</label>
                     <input type="text" id="co-flat" name="flat" placeholder="e.g. Flat 402, Sunshine Apts" class="box" maxlength="50" required>
                  </div>

                  <div class="input-group">
                     <label for="co-street">Street / Locality / Road</label>
                     <input type="text" id="co-street" name="street" placeholder="e.g. MG Road, Near City Hospital" class="box" maxlength="50" required>
                  </div>
               </div>

               <div class="form-row-3">
                  <div class="input-group">
                     <label for="co-city">City</label>
                     <input type="text" id="co-city" name="city" placeholder="e.g. Surat" class="box" maxlength="50" required>
                  </div>

                  <div class="input-group">
                     <label for="co-state">State</label>
                     <input type="text" id="co-state" name="state" placeholder="e.g. Gujarat" class="box" maxlength="50" required>
                  </div>

                  <div class="input-group">
                     <label for="co-pincode">Pin Code</label>
                     <input type="number" id="co-pincode" name="pin_code" placeholder="6 digits" class="box" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" required>
                  </div>
               </div>

               <div class="input-group">
                  <label for="co-country">Country</label>
                  <input type="text" id="co-country" name="country" placeholder="e.g. India" value="India" class="box" maxlength="50" required>
               </div>
            </div>

            <!-- Section 3: Payment Method -->
            <div class="checkout-card">
               <div class="card-step-header">
                  <span class="step-num">3</span>
                  <div>
                     <h3>Select Payment Method</h3>
                     <p>Choose your preferred payment mode for this order.</p>
                  </div>
               </div>

               <div class="payment-method-selector">
                  <label class="payment-option-pill">
                     <input type="radio" name="method" value="cash on delivery" checked>
                     <div class="option-card-inner">
                        <i class="fas fa-money-bill-wave"></i>
                        <div>
                           <strong>Cash on Delivery (COD)</strong>
                           <span>Pay comfortably at your doorstep</span>
                        </div>
                     </div>
                  </label>

                  <label class="payment-option-pill">
                     <input type="radio" name="method" value="credit card">
                     <div class="option-card-inner">
                        <i class="fas fa-credit-card"></i>
                        <div>
                           <strong>Credit / Debit Card</strong>
                           <span>Visa, Mastercard & RuPay supported</span>
                        </div>
                     </div>
                  </label>

                  <label class="payment-option-pill">
                     <input type="radio" name="method" value="paytm">
                     <div class="option-card-inner">
                        <i class="fas fa-mobile-screen"></i>
                        <div>
                           <strong>UPI & Digital Wallets</strong>
                           <span>Instant payment via GooglePay, PhonePe, Paytm</span>
                        </div>
                     </div>
                  </label>
               </div>
            </div>

         </div>

         <!-- Right Column: Order Review Sidebar -->
         <aside class="checkout-sidebar">
            <div class="summary-card checkout-summary">
               <h3 class="summary-title"><i class="fas fa-clipboard-check"></i> Order Review</h3>

               <div class="checkout-item-preview">
                  <span class="preview-label">Items in Order:</span>
                  <div class="items-chip-list">
                     <?php if(!empty($cart_items)): ?>
                        <?php foreach($cart_items as $item): ?>
                           <span class="order-item-badge"><i class="fas fa-pills"></i> <?= htmlspecialchars($item); ?></span>
                        <?php endforeach; ?>
                     <?php else: ?>
                        <p class="empty-note">Your cart has no items.</p>
                     <?php endif; ?>
                  </div>
               </div>

               <div class="summary-divider"></div>

               <div class="summary-row">
                  <span>Medicines Subtotal</span>
                  <strong>₹<?= $grand_total; ?></strong>
               </div>

               <div class="summary-row">
                  <span>Express Delivery</span>
                  <span class="free-tag"><?= ($grand_total >= 499) ? 'FREE' : '₹50'; ?></span>
               </div>

               <div class="summary-row">
                  <span>Pharmacist Packaging</span>
                  <span class="free-tag">FREE</span>
               </div>

               <div class="summary-divider"></div>

               <div class="summary-row total-row">
                  <span>Total Payable</span>
                  <strong class="total-figure">₹<?= ($grand_total >= 499) ? $grand_total : ($grand_total + 50); ?></strong>
               </div>

               <button type="submit" name="order" class="btn btn-primary btn-block btn-lg checkout-cta-btn <?= ($grand_total > 0) ? '' : 'disabled'; ?>">
                  <i class="fas fa-lock"></i> Place Order Securely
               </button>

               <div class="security-guarantee-box">
                  <i class="fas fa-shield-check"></i>
                  <span>100% Genuine Medicine & Secure Data Guarantee</span>
               </div>
            </div>
         </aside>

      </div>

   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>