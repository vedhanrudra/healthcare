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

if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
}

if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php');
   exit();
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'Cart quantity updated successfully';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shopping Cart - HealthCareRx</title>

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

<!-- Breadcrumb Banner -->
<div class="page-banner compact">
   <div class="banner-inner">
      <div class="breadcrumb">
         <a href="home.php"><i class="fas fa-house"></i> Home</a>
         <i class="fas fa-chevron-right separator"></i>
         <span>Shopping Cart</span>
      </div>
      <h1 class="page-title">Your Pharmacy Cart</h1>
   </div>
</div>

<section class="cart-page-section">

   <?php
      $grand_total = 0;
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);
      $cart_items_count = $select_cart->rowCount();
   ?>

   <?php if($cart_items_count > 0): ?>

   <div class="cart-layout-grid">
      
      <!-- Left Column: Items List -->
      <div class="cart-items-column">
         
         <div class="cart-header-row">
            <h2>Cart Items (<?= $cart_items_count; ?>)</h2>
            <a href="cart.php?delete_all" class="btn-clear-all" onclick="return confirm('Clear all items from your cart?');">
               <i class="fas fa-trash-can"></i> Clear All Items
            </a>
         </div>

         <div class="cart-items-list">
            <?php
               while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                  $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']);
                  $grand_total += $sub_total;
            ?>
            <div class="cart-item-card">
               
               <!-- Item Thumbnail -->
               <div class="item-thumb-box">
                  <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="<?= htmlspecialchars($fetch_cart['name']); ?>">
               </div>

               <!-- Item Info -->
               <div class="item-info-box">
                  <span class="item-badge"><i class="fas fa-shield-check"></i> Genuine Rx</span>
                  <h3 class="item-name"><?= htmlspecialchars($fetch_cart['name']); ?></h3>
                  <div class="item-unit-price">Unit Price: <strong>₹<?= $fetch_cart['price']; ?></strong></div>
                  
                  <!-- Quantity Stepper Form -->
                  <form action="" method="post" class="item-qty-form">
                     <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                     <div class="qty-stepper-box">
                        <label for="qty-<?= $fetch_cart['id']; ?>">Qty:</label>
                        <input type="number" id="qty-<?= $fetch_cart['id']; ?>" name="qty" class="qty-field" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>">
                        <button type="submit" name="update_qty" class="btn-update-qty" title="Update Quantity">
                           <i class="fas fa-arrows-rotate"></i> Update
                        </button>
                     </div>
                  </form>
               </div>

               <!-- Subtotal & Actions -->
               <div class="item-meta-box">
                  <div class="item-subtotal">
                     <span class="subtotal-label">Subtotal:</span>
                     <span class="subtotal-value">₹<?= $sub_total; ?></span>
                  </div>

                  <form action="" method="post">
                     <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                     <button type="submit" name="delete" class="btn-remove-item" onclick="return confirm('Remove this medicine from cart?');" title="Remove">
                        <i class="fas fa-trash-can"></i> <span>Remove</span>
                     </button>
                  </form>
               </div>

            </div>
            <?php } ?>
         </div>

         <div class="cart-perks-strip">
            <div class="perk-item"><i class="fas fa-shield-halved"></i> 100% Genuine Medicine Guarantee</div>
            <div class="perk-item"><i class="fas fa-box-check"></i> Tamper-Evident Safety Packaging</div>
            <div class="perk-item"><i class="fas fa-truck-fast"></i> Contactless Doorstep Delivery</div>
         </div>

      </div>

      <!-- Right Column: Order Summary Sidebar -->
      <aside class="cart-summary-sidebar">
         
         <div class="summary-card">
            <h3 class="summary-title"><i class="fas fa-receipt"></i> Order Summary</h3>
            
            <div class="summary-row">
               <span>Cart Subtotal</span>
               <strong>₹<?= $grand_total; ?></strong>
            </div>

            <div class="summary-row">
               <span>Estimated Delivery</span>
               <span class="free-tag"><?= ($grand_total >= 499) ? 'FREE' : '₹50'; ?></span>
            </div>

            <div class="summary-row">
               <span>Packaging & Handling</span>
               <span class="free-tag">FREE</span>
            </div>

            <div class="summary-divider"></div>

            <div class="summary-row total-row">
               <span>Estimated Total</span>
               <strong class="total-figure">₹<?= ($grand_total >= 499) ? $grand_total : ($grand_total + 50); ?></strong>
            </div>
            <p class="summary-tax-note">Includes all clinical & pharmaceutical goods taxes.</p>

            <a href="checkout.php" class="btn btn-primary btn-block btn-lg checkout-cta-btn">
               <span>Proceed to Checkout</span>
               <i class="fas fa-arrow-right"></i>
            </a>

            <a href="shop.php" class="btn btn-secondary-white btn-block continue-shopping-btn">
               <i class="fas fa-plus"></i> Add More Medicines
            </a>

            <div class="security-guarantee-box">
               <i class="fas fa-lock"></i>
               <span>256-Bit SSL Encrypted Healthcare Checkout</span>
            </div>
         </div>

      </aside>

   </div>

   <?php else: ?>

   <div class="empty-cart-state">
      <div class="empty-icon-wrap">
         <i class="fas fa-bag-shopping"></i>
      </div>
      <h2>Your Cart is Currently Empty</h2>
      <p>You have not added any medicines or healthcare items to your shopping cart yet.</p>
      <a href="shop.php" class="btn btn-primary" style="width:auto;margin-top:2rem;">
         <i class="fas fa-prescription-bottle-medical"></i> Explore Medicines & Products
      </a>
   </div>

   <?php endif; ?>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js?v=<?php echo time(); ?>"></script>

</body>
</html>