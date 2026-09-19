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

include 'components/wishlist_cart.php';

if(isset($_POST['delete'])){
   $wishlist_id = $_POST['wishlist_id'];
   $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
   $delete_wishlist_item->execute([$wishlist_id]);
}

if(isset($_GET['delete_all'])){
   $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
   $delete_wishlist_item->execute([$user_id]);
   header('location:wishlist.php');
   exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Saved Wishlist - HealthCareRx</title>

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

<!-- Breadcrumb & Banner -->
<div class="page-banner compact">
   <div class="banner-inner">
      <div class="breadcrumb">
         <a href="home.php"><i class="fas fa-house"></i> Home</a>
         <i class="fas fa-chevron-right separator"></i>
         <span>Saved Wishlist</span>
      </div>
      <h1 class="page-title">Your Saved Medicines & Items</h1>
   </div>
</div>

<section class="products-section">

   <?php
      $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
      $select_wishlist->execute([$user_id]);
      $wishlist_count = $select_wishlist->rowCount();
   ?>

   <div class="catalog-toolbar">
      <div class="catalog-meta">
         <h2>Wishlist Items</h2>
         <span class="product-count-chip"><?= $wishlist_count; ?> medicines saved</span>
      </div>
      <?php if($wishlist_count > 0): ?>
         <a href="wishlist.php?delete_all" class="btn-clear-all" onclick="return confirm('Remove all saved medicines from wishlist?');">
            <i class="fas fa-trash-can"></i> Clear All Items
         </a>
      <?php endif; ?>
   </div>

   <div class="products-grid">
   <?php
      if($wishlist_count > 0){
         while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){
            $original_price = round($fetch_wishlist['price'] * 1.25);
   ?>
   <form action="" method="post" class="product-card">
      <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
      <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">

      <div class="card-badges">
         <span class="discount-pill">20% OFF</span>
         <span class="rx-pill"><i class="fas fa-heart"></i> Saved</span>
      </div>

      <!-- Quick Action Buttons -->
      <div class="card-action-triggers">
         <button type="submit" name="delete" class="action-btn delete-action" onclick="return confirm('Remove this medicine from wishlist?');" title="Remove from Wishlist">
            <i class="fas fa-trash-can"></i>
         </button>
         <a href="quick_view.php?pid=<?= $fetch_wishlist['pid']; ?>" class="action-btn" title="Quick View">
            <i class="fas fa-eye"></i>
         </a>
      </div>

      <!-- Product Image -->
      <a href="quick_view.php?pid=<?= $fetch_wishlist['pid']; ?>" class="product-img-wrap">
         <img src="uploaded_img/<?= $fetch_wishlist['image']; ?>" alt="<?= htmlspecialchars($fetch_wishlist['name']); ?>" loading="lazy">
      </a>

      <!-- Card Body -->
      <div class="card-body">
         <h3 class="product-name">
            <a href="quick_view.php?pid=<?= $fetch_wishlist['pid']; ?>"><?= htmlspecialchars($fetch_wishlist['name']); ?></a>
         </h3>

         <div class="price-row">
            <div class="price-wrap">
               <span class="current-price">₹<?= $fetch_wishlist['price']; ?></span>
               <span class="original-price">₹<?= $original_price; ?></span>
            </div>
            <div class="qty-selector">
               <input type="number" name="qty" class="qty-input" min="1" max="99" value="1" title="Quantity">
            </div>
         </div>

         <button type="submit" name="add_to_cart" class="btn btn-add-cart">
            <i class="fas fa-cart-plus"></i> Move to Cart
         </button>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<div class="empty-state"><div class="empty-icon-wrap"><i class="fas fa-heart-crack"></i></div><h2>Your Wishlist is Empty</h2><p>You haven\'t saved any medicines or products yet.</p><a href="shop.php" class="btn btn-primary" style="width:auto;margin-top:2rem;"><i class="fas fa-prescription-bottle-medical"></i> Browse Pharmacy Catalog</a></div>';
      }
   ?>
   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>