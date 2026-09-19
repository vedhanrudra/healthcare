<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <div class="msg-text">
               <i class="fas fa-info-circle"></i>
               <span>'.$message.'</span>
            </div>
            <i class="fas fa-times" onclick="this.parentElement.remove();" title="Dismiss"></i>
         </div>
         ';
      }
   }
?>

<header class="header">

   <section class="flex">

      <div class="header-left">
         <button id="menu-btn" class="header-icon-btn mobile-toggle" aria-label="Toggle Sidebar Menu">
            <i class="fas fa-bars"></i>
         </button>
         <a href="../admin/dashboard.php" class="logo">
            <span class="logo-mark"><i class="fas fa-plus"></i></span>
            <span class="logo-text">HealthCare<span class="logo-accent">Rx</span></span>
            <span class="admin-badge">Admin Panel</span>
         </a>
      </div>

      <div class="header-actions">
         <a href="../home.php" target="_blank" class="live-site-btn hide-mobile" title="Preview Live Pharmacy Store">
            <i class="fas fa-arrow-up-right-from-square"></i>
            <span>View Live Store</span>
         </a>

         <div class="admin-profile-trigger" id="user-btn" title="Admin Account">
            <div class="avatar-chip">
               <i class="fas fa-user-shield"></i>
            </div>
            <?php
               $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
               $select_profile->execute([$admin_id]);
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <span class="admin-name-preview hide-mobile"><?= htmlspecialchars($fetch_profile['name'] ?? 'Admin'); ?></span>
            <i class="fas fa-chevron-down caret-icon hide-mobile"></i>
         </div>
      </div>

      <div class="profile">
         <div class="profile-header-card">
            <div class="admin-avatar-lg">
               <i class="fas fa-user-shield"></i>
            </div>
            <h4 class="admin-display-name"><?= htmlspecialchars($fetch_profile['name'] ?? 'Admin'); ?></h4>
            <span class="admin-badge-pill"><i class="fas fa-circle-check"></i> System Administrator</span>
         </div>
         
         <div class="profile-nav-links">
            <a href="../admin/update_profile.php" class="btn option-btn"><i class="fas fa-user-gear"></i> Update Profile</a>
            <a href="../admin/register_admin.php" class="btn option-btn"><i class="fas fa-user-plus"></i> Add Admin Staff</a>
         </div>

         <div class="profile-footer-card">
            <a href="../components/admin_logout.php" class="delete-btn" onclick="return confirm('Do you want to log out from Admin Panel?');">
               <i class="fas fa-arrow-right-from-bracket"></i> Log Out
            </a> 
         </div>
      </div>

   </section>

</header>