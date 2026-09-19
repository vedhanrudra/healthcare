<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <div class="msg-content">
               <i class="fas fa-info-circle"></i>
               <span>'.$message.'</span>
            </div>
            <i class="fas fa-times" onclick="this.parentElement.remove();" title="Dismiss"></i>
         </div>
         ';
      }
   }
?>

<!-- Top Utility Bar -->
<div class="top-utility-bar">
   <div class="top-bar-inner">
      <div class="top-bar-left">
         <span class="utility-item">
            <i class="fas fa-pills"></i>
            <span>Online Pharmacy & Healthcare Store</span>
         </span>
         <span class="utility-divider">|</span>
         <span class="utility-item hide-mobile">
            <i class="fas fa-shield-halved"></i>
            <span>Verified Healthcare Products</span>
         </span>
      </div>
      <div class="top-bar-right">
         <a href="contact.php" class="utility-item">
            <i class="fas fa-envelope"></i>
            <span>Customer Support & Inquiries</span>
         </a>
      </div>
   </div>
</div>

<!-- Main Sticky Header -->
<header class="header">

   <div class="header-main">
      <div class="header-main-inner">

         <!-- Mobile Menu Toggle Button -->
         <button id="menu-btn" class="header-icon-btn mobile-toggle" aria-label="Open Navigation Menu">
            <i class="fas fa-bars"></i>
         </button>

         <!-- Brand Logo -->
         <a href="home.php" class="logo">
            <span class="logo-mark">
               <i class="fas fa-plus"></i>
            </span>
            <span class="logo-text">
               HealthCare<span class="logo-accent">Rx</span>
            </span>
         </a>

         <!-- Center Search Bar (Submits directly to search_page.php) -->
         <form action="search_page.php" method="post" class="header-search">
            <div class="search-input-wrap">
               <i class="fas fa-magnifying-glass search-icon"></i>
               <input type="text" name="search_box" placeholder="Search medicines, health products, vitamins..." maxlength="100" required>
            </div>
            <button type="submit" name="search_btn" class="search-submit-btn">
               <span>Search</span>
               <i class="fas fa-arrow-right"></i>
            </button>
         </form>

         <!-- Right Action Icons: Account, Wishlist, Cart -->
         <div class="header-actions">
            
            <!-- Mobile Search Icon Toggle -->
            <a href="search_page.php" class="header-action-item mobile-search-trigger" title="Search">
               <div class="action-icon-wrap">
                  <i class="fas fa-search"></i>
               </div>
               <span class="action-label">Search</span>
            </a>

            <!-- User Account -->
            <div class="header-action-item" id="user-btn" title="Account">
               <div class="action-icon-wrap">
                  <i class="fas fa-user"></i>
               </div>
               <span class="action-label">
                  <?php if($user_id != ''): ?>
                     Account
                  <?php else: ?>
                     Login
                  <?php endif; ?>
               </span>
            </div>

            <!-- Wishlist Count -->
            <?php
               $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
               $count_wishlist_items->execute([$user_id]);
               $total_wishlist_counts = $count_wishlist_items->rowCount();

               $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
               $count_cart_items->execute([$user_id]);
               $total_cart_counts = $count_cart_items->rowCount();
            ?>
            <a href="wishlist.php" class="header-action-item" title="Wishlist">
               <div class="action-icon-wrap">
                  <i class="fas fa-heart"></i>
                  <?php if($total_wishlist_counts > 0): ?>
                     <span class="action-badge badge-teal"><?= $total_wishlist_counts; ?></span>
                  <?php endif; ?>
               </div>
               <span class="action-label">Wishlist</span>
            </a>

            <!-- Cart Count -->
            <a href="cart.php" class="header-action-item cart-action" title="Shopping Cart">
               <div class="action-icon-wrap">
                  <i class="fas fa-shopping-bag"></i>
                  <?php if($total_cart_counts > 0): ?>
                     <span class="action-badge badge-blue"><?= $total_cart_counts; ?></span>
                  <?php endif; ?>
               </div>
               <div class="cart-info hide-mobile">
                  <span class="cart-title">My Cart</span>
                  <span class="cart-qty"><?= $total_cart_counts; ?> items</span>
               </div>
            </a>

         </div>

         <!-- Account Popup Menu -->
         <div class="profile-dropdown">
            <?php          
               $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
               $select_profile->execute([$user_id]);
               if($select_profile->rowCount() > 0){
                  $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                  $user_initial = strtoupper(substr($fetch_profile["name"], 0, 1));
            ?>
            <div class="profile-card-header">
               <div class="avatar-circle"><?= $user_initial; ?></div>
               <div class="profile-details">
                  <h4 class="user-fullname"><?= htmlspecialchars($fetch_profile["name"]); ?></h4>
                  <span class="user-email"><?= htmlspecialchars($fetch_profile["email"]); ?></span>
                  <span class="patient-status"><i class="fas fa-circle-check"></i> Verified Patient</span>
               </div>
            </div>
            <div class="profile-menu-links">
               <a href="orders.php" class="menu-link"><i class="fas fa-clipboard-list"></i> My Orders</a>
               <a href="wishlist.php" class="menu-link"><i class="fas fa-heart"></i> Saved Medicines</a>
               <a href="update_user.php" class="menu-link"><i class="fas fa-user-gear"></i> Account Settings</a>
            </div>
            <div class="profile-card-footer">
               <a href="components/user_logout.php" class="btn-logout" onclick="return confirm('Do you want to log out from HealthCareRx?');">
                  <i class="fas fa-arrow-right-from-bracket"></i> Log Out
               </a>
            </div>
            <?php
               }else{
            ?>
            <div class="profile-card-header guest-state">
               <div class="avatar-circle guest-circle"><i class="fas fa-user-shield"></i></div>
               <div class="profile-details">
                  <h4 class="user-fullname">Welcome to HealthCareRx</h4>
                  <p class="guest-desc">Log in to view orders, refill prescriptions & track delivery</p>
               </div>
            </div>
            <div class="profile-auth-actions">
               <a href="user_login.php" class="btn btn-primary btn-block"><i class="fas fa-arrow-right-to-bracket"></i> Sign In</a>
               <a href="user_register.php" class="btn btn-secondary btn-block"><i class="fas fa-user-plus"></i> Create Account</a>
            </div>
            <?php
               }
            ?>      
         </div>

      </div>
   </div>

   <!-- Desktop Navigation Bar -->
   <nav class="header-nav">
      <div class="header-nav-inner">
         <ul class="nav-links">
            <li><a href="home.php" class="nav-item"><i class="fas fa-house"></i> Home</a></li>
            <li><a href="category.php?category=medicine" class="nav-item"><i class="fas fa-prescription-bottle-medical"></i> Medicines</a></li>
            <li><a href="category.php?category=care" class="nav-item"><i class="fas fa-heart-pulse"></i> Health & Wellness</a></li>
            <li><a href="shop.php" class="nav-item"><i class="fas fa-table-cells-large"></i> All Categories</a></li>
            <li><a href="orders.php" class="nav-item"><i class="fas fa-receipt"></i> Orders</a></li>
            <li><a href="contact.php" class="nav-item"><i class="fas fa-headset"></i> Contact</a></li>
         </ul>
      </div>
   </nav>

</header>

<!-- Mobile Navigation Drawer Overlay & Content -->
<div class="mobile-drawer-overlay" id="mobile-drawer-overlay"></div>
<aside class="mobile-drawer" id="mobile-drawer">
   <div class="drawer-header">
      <div class="logo">
         <span class="logo-mark"><i class="fas fa-plus"></i></span>
         <span class="logo-text">HealthCare<span class="logo-accent">Rx</span></span>
      </div>
      <button class="drawer-close-btn" id="drawer-close-btn" aria-label="Close Menu">
         <i class="fas fa-times"></i>
      </button>
   </div>
   <div class="drawer-body">
      <ul class="drawer-links">
         <li><a href="home.php"><i class="fas fa-house"></i> Home</a></li>
         <li><a href="category.php?category=medicine"><i class="fas fa-prescription-bottle-medical"></i> Medicines</a></li>
         <li><a href="category.php?category=care"><i class="fas fa-heart-pulse"></i> Health & Wellness</a></li>
         <li><a href="shop.php"><i class="fas fa-table-cells-large"></i> All Categories</a></li>
         <li><a href="orders.php"><i class="fas fa-clipboard-list"></i> My Orders</a></li>
         <li><a href="wishlist.php"><i class="fas fa-heart"></i> Saved Wishlist</a></li>
         <li><a href="cart.php"><i class="fas fa-shopping-bag"></i> Cart (<?= $total_cart_counts; ?>)</a></li>
         <li><a href="contact.php"><i class="fas fa-envelope"></i> Contact Support</a></li>
      </ul>
      <div class="drawer-account-box">
         <?php if($user_id != ''): ?>
            <a href="update_user.php" class="btn btn-secondary btn-block"><i class="fas fa-user-gear"></i> Account Settings</a>
            <a href="components/user_logout.php" class="btn btn-outline-danger btn-block" onclick="return confirm('Log out?');"><i class="fas fa-arrow-right-from-bracket"></i> Log Out</a>
         <?php else: ?>
            <a href="user_login.php" class="btn btn-primary btn-block"><i class="fas fa-arrow-right-to-bracket"></i> Sign In</a>
            <a href="user_register.php" class="btn btn-secondary btn-block"><i class="fas fa-user-plus"></i> Register</a>
         <?php endif; ?>
      </div>
   </div>
</aside>