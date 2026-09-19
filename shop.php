<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>All Medicines & Products - HealthCareRx</title>

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

<!-- Breadcrumb & Page Banner -->
<div class="page-banner">
   <div class="banner-inner">
      <div class="breadcrumb">
         <a href="home.php"><i class="fas fa-house"></i> Home</a>
         <i class="fas fa-chevron-right separator"></i>
         <span>Pharmacy Catalog</span>
      </div>
      <h1 class="page-title">Medicines & Healthcare Catalog</h1>
      <p class="page-desc">Browse certified genuine pharmaceuticals, wellness supplements, and medical devices.</p>
   </div>
</div>

<!-- 2-Column Shop Layout -->
<section class="shop-layout-section">
   <div class="shop-grid-container">

      <!-- Left Filter Sidebar -->
      <aside class="shop-sidebar">
         
         <!-- Category Filter Card -->
         <div class="filter-card">
            <h3 class="filter-title"><i class="fas fa-layer-group"></i> Browse Categories</h3>
            <ul class="filter-category-list">
               <li>
                  <a href="shop.php" class="active">
                     <span><i class="fas fa-table-cells-large"></i> All Medicines</span>
                     <i class="fas fa-check"></i>
                  </a>
               </li>
               <li>
                  <a href="category.php?category=medicine">
                     <span><i class="fas fa-capsules"></i> Prescription Drugs</span>
                     <i class="fas fa-chevron-right"></i>
                  </a>
               </li>
               <li>
                  <a href="category.php?category=care">
                     <span><i class="fas fa-heart-pulse"></i> Health & Wellness</span>
                     <i class="fas fa-chevron-right"></i>
                  </a>
               </li>
               <li>
                  <a href="category.php?category=care">
                     <span><i class="fas fa-pump-medical"></i> Personal Care</span>
                     <i class="fas fa-chevron-right"></i>
                  </a>
               </li>
               <li>
                  <a href="category.php?category=care">
                     <span><i class="fas fa-stethoscope"></i> Health Devices</span>
                     <i class="fas fa-chevron-right"></i>
                  </a>
               </li>
               <li>
                  <a href="category.php?category=ayurvedic">
                     <span><i class="fas fa-mortar-pestle"></i> Ayurvedic & Herbal</span>
                     <i class="fas fa-chevron-right"></i>
                  </a>
               </li>
            </ul>
         </div>

         <!-- Trust Card -->
         <div class="filter-card trust-promo-card">
            <div class="promo-badge"><i class="fas fa-shield-check"></i> 100% Genuine</div>
            <h4>Certified Quality</h4>
            <p>All items in this catalog are sourced directly from verified and licensed manufacturers.</p>
            <div class="phone-support">
               <i class="fas fa-phone-volume"></i>
               <div>
                  <span>Prescription Help</span>
                  <strong>+91 9313945584</strong>
               </div>
            </div>
         </div>

      </aside>

      <!-- Right Products Grid -->
      <main class="shop-main-content">
         
         <?php
            $select_products = $conn->prepare("SELECT * FROM `products`"); 
            $select_products->execute();
            $total_prods = $select_products->rowCount();
         ?>

         <div class="catalog-toolbar">
            <div class="catalog-meta">
               <h3>All Products</h3>
               <span class="product-count-chip">Showing <?= $total_prods; ?> items</span>
            </div>
            <div class="toolbar-badges">
               <span class="badge-chip"><i class="fas fa-truck-fast"></i> 2-Hour Delivery</span>
               <span class="badge-chip"><i class="fas fa-shield-halved"></i> Genuine Meds</span>
            </div>
         </div>

         <div class="products-grid">
         <?php
            if($total_prods > 0){
               while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
                  $original_price = round($fetch_product['price'] * 1.25);
         ?>
         <form action="" method="post" class="product-card">
            <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
            <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
            <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
            <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">

            <!-- Badges -->
            <div class="card-badges">
               <span class="discount-pill">20% OFF</span>
               <span class="rx-pill"><i class="fas fa-shield-check"></i> Genuine</span>
            </div>

            <!-- Action Buttons -->
            <div class="card-action-triggers">
               <button type="submit" name="add_to_wishlist" class="action-btn" title="Add to Wishlist">
                  <i class="fas fa-heart"></i>
               </button>
               <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="action-btn" title="Quick View">
                  <i class="fas fa-eye"></i>
               </a>
            </div>

            <!-- Product Image -->
            <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="product-img-wrap">
               <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="<?= htmlspecialchars($fetch_product['name']); ?>" loading="lazy">
            </a>

            <!-- Card Body -->
            <div class="card-body">
               <div class="product-rating">
                  <div class="stars">
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star"></i>
                     <i class="fas fa-star-half-stroke"></i>
                  </div>
                  <span class="rating-val">4.8</span>
               </div>

               <h3 class="product-name">
                  <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>"><?= htmlspecialchars($fetch_product['name']); ?></a>
               </h3>

               <div class="price-row">
                  <div class="price-wrap">
                     <span class="current-price">₹<?= $fetch_product['price']; ?></span>
                     <span class="original-price">₹<?= $original_price; ?></span>
                  </div>
                  <div class="qty-selector">
                     <input type="number" name="qty" class="qty-input" min="1" max="99" value="1" title="Quantity">
                  </div>
               </div>

               <button type="submit" name="add_to_cart" class="btn btn-add-cart">
                  <i class="fas fa-cart-plus"></i> Add to Cart
               </button>
            </div>
         </form>
         <?php
               }
            }else{
               echo '<div class="empty-state"><i class="fas fa-box-open"></i><p>No products currently available in this catalog.</p></div>';
            }
         ?>
         </div>

      </main>

   </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>