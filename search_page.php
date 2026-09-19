<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

$search_query = '';
if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
   $search_query = $_POST['search_box'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search Medicines - HealthCareRx</title>

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

<!-- Search Hero Banner -->
<div class="page-banner search-banner">
   <div class="banner-inner">
      <div class="breadcrumb">
         <a href="home.php"><i class="fas fa-house"></i> Home</a>
         <i class="fas fa-chevron-right separator"></i>
         <span>Search Pharmacy</span>
      </div>
      <h1 class="page-title">Find Medicines & Healthcare Products</h1>
      <p class="page-desc">Search across thousands of certified pharmaceuticals, health monitors, and wellness supplements.</p>

      <!-- Dedicated Big Search Bar -->
      <form action="" method="post" class="dedicated-search-form">
         <div class="dedicated-search-wrap">
            <i class="fas fa-magnifying-glass dedicated-icon"></i>
            <input type="text" name="search_box" placeholder="Type medicine name, active ingredient, brand or illness..." value="<?= htmlspecialchars($search_query); ?>" maxlength="100" class="dedicated-input" required>
            <button type="submit" name="search_btn" class="btn btn-primary dedicated-btn">
               <i class="fas fa-search"></i> <span>Search</span>
            </button>
         </div>
      </form>
   </div>
</div>

<!-- Search Results Section -->
<section class="products-section">
   
   <?php
      if(!empty($search_query)){
         $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE '%{$search_query}%'"); 
         $select_products->execute();
         $result_count = $select_products->rowCount();
   ?>
   <div class="section-header">
      <div>
         <span class="section-tag"><i class="fas fa-list-check"></i> Results</span>
         <h2 class="section-title">Showing results for "<?= htmlspecialchars($search_query); ?>"</h2>
         <p class="section-subtitle"><?= $result_count; ?> products matched your search inquiry</p>
      </div>
      <a href="shop.php" class="section-link">View Full Catalog <i class="fas fa-arrow-right"></i></a>
   </div>

   <div class="products-grid">
   <?php
      if($result_count > 0){
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

      <!-- Action Triggers -->
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
         echo '<div class="empty-state"><i class="fas fa-magnifying-glass"></i><p>No products found matching "'.htmlspecialchars($search_query).'".</p><p style="font-size:1.4rem;color:#94a3b8;margin-top:0.5rem;">Try checking the spelling or searching by broad terms like medicine or care.</p><a href="shop.php" class="btn btn-primary" style="width:auto;margin-top:2rem;">Explore All Medicines</a></div>';
      }
   ?>
   </div>
   <?php
      }else{
         echo '<div class="empty-state"><i class="fas fa-pills"></i><p>Please enter a medicine or health product name in the search box above to begin.</p></div>';
      }
   ?>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js?v=<?php echo time(); ?>"></script>

</body>
</html>