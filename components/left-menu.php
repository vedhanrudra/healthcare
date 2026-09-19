<?php
   $current_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="left-menu">
   <div class="sidebar-brand-badge hide-desktop">
      <i class="fas fa-plus"></i> HealthCareRx
   </div>
   
   <div class="sidebar-section-title">Main Navigation</div>
   
   <a href="../admin/dashboard.php" class="sidebar-link <?= ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
      <i class="fas fa-chart-line"></i>
      <span>Dashboard</span>
   </a>
   
   <a href="../admin/products.php" class="sidebar-link <?= ($current_page == 'products.php' || $current_page == 'update_product.php') ? 'active' : ''; ?>">
      <i class="fas fa-pills"></i>
      <span>Products & Stock</span>
   </a>
   
   <a href="../admin/placed_orders.php" class="sidebar-link <?= ($current_page == 'placed_orders.php') ? 'active' : ''; ?>">
      <i class="fas fa-clipboard-list"></i>
      <span>Patient Orders</span>
   </a>
   
   <a href="../admin/users_accounts.php" class="sidebar-link <?= ($current_page == 'users_accounts.php') ? 'active' : ''; ?>">
      <i class="fas fa-users"></i>
      <span>Registered Patients</span>
   </a>
   
   <a href="../admin/messages.php" class="sidebar-link <?= ($current_page == 'messages.php') ? 'active' : ''; ?>">
      <i class="fas fa-envelope"></i>
      <span>Customer Messages</span>
   </a>

   <div class="sidebar-divider"></div>
   <div class="sidebar-section-title">Administration</div>

   <a href="../admin/admin_accounts.php" class="sidebar-link <?= ($current_page == 'admin_accounts.php' || $current_page == 'register_admin.php') ? 'active' : ''; ?>">
      <i class="fas fa-user-shield"></i>
      <span>Staff Accounts</span>
   </a>

   <a href="../admin/update_profile.php" class="sidebar-link <?= ($current_page == 'update_profile.php') ? 'active' : ''; ?>">
      <i class="fas fa-user-gear"></i>
      <span>Admin Settings</span>
   </a>

   <div class="sidebar-divider"></div>
   <div class="sidebar-section-title">Quick Actions</div>

   <a href="../home.php" target="_blank" class="sidebar-link store-link">
      <i class="fas fa-arrow-up-right-from-square"></i>
      <span>View Pharmacy Store</span>
   </a>

   <a href="../components/admin_logout.php" class="sidebar-link logout-link" onclick="return confirm('Do you want to log out from Admin Panel?');">
      <i class="fas fa-arrow-right-from-bracket"></i>
      <span>Log Out</span>
   </a>
</aside>
