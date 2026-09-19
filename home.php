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
   <title>HealthCareRx - Modern Online Pharmacy & Healthcare Store</title>

   <!-- Google Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

   <!-- Swiper CSS -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- Font Awesome 6 -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   <!-- Custom Modern CSS -->
   <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<!-- 1. Hero Section (Clean Light-Blue/White Carousel) -->
<section class="hero-section">
   <div class="swiper hero-slider">
      <div class="swiper-wrapper">

         <!-- Slide 1 -->
         <div class="swiper-slide hero-slide">
            <div class="hero-slide-grid">
               <div class="hero-content">
                  <div class="hero-badge">
                     <i class="fas fa-certificate"></i> Verified Healthcare Partner
                  </div>
                  <h1 class="hero-title">Healthcare Delivered To Your Door</h1>
                  <p class="hero-description">
                     Order genuine medicines, vitamins, and prescription healthcare products delivered safely and hygienically to your doorstep.
                  </p>
                  <div class="hero-actions">
                     <a href="shop.php" class="btn btn-primary"><i class="fas fa-prescription-bottle-medical"></i> Shop Medicines</a>
                     <a href="category.php?category=care" class="btn btn-outline-primary"><i class="fas fa-heart-pulse"></i> Explore Wellness</a>
                  </div>
                  <div class="hero-perks">
                     <span><i class="fas fa-check-circle"></i> 100% Genuine</span>
                     <span><i class="fas fa-check-circle"></i> Fast Delivery</span>
                     <span><i class="fas fa-check-circle"></i> Licensed Rx</span>
                  </div>
               </div>
               <div class="hero-image-wrap">
                  <img src="images/hero_slide_1.jpg" alt="Licensed Pharmacist at HealthCareRx" class="hero-img">
               </div>
            </div>
         </div>

         <!-- Slide 2 -->
         <div class="swiper-slide hero-slide">
            <div class="hero-slide-grid">
               <div class="hero-content">
                  <div class="hero-badge">
                     <i class="fas fa-shield-check"></i> Quality Guaranteed
                  </div>
                  <h2 class="hero-title">Trusted Medicines From Verified Makers</h2>
                  <p class="hero-description">
                     Access certified pharmaceuticals, vitamins, and healthcare essentials sourced directly from licensed global manufacturers.
                  </p>
                  <div class="hero-actions">
                     <a href="category.php?category=medicine" class="btn btn-primary"><i class="fas fa-capsules"></i> Browse Medicines</a>
                     <a href="contact.php" class="btn btn-outline-primary"><i class="fas fa-user-doctor"></i> Talk to Pharmacist</a>
                  </div>
                  <div class="hero-perks">
                     <span><i class="fas fa-check-circle"></i> Temperature Controlled</span>
                     <span><i class="fas fa-check-circle"></i> Batch Verified</span>
                  </div>
               </div>
               <div class="hero-image-wrap">
                  <img src="images/hero_slide_2.jpg" alt="Supplements & Healthcare Products" class="hero-img">
               </div>
            </div>
         </div>

         <!-- Slide 3 -->
         <div class="swiper-slide hero-slide">
            <div class="hero-slide-grid">
               <div class="hero-content">
                  <div class="hero-badge">
                     <i class="fas fa-truck-fast"></i> Express Home Delivery
                  </div>
                  <h2 class="hero-title">Stay Healthy, Stay Prepared Everyday</h2>
                  <p class="hero-description">
                     Get essential first-aid supplies, health devices, baby care, and daily nutrition with contactless doorstep delivery.
                  </p>
                  <div class="hero-actions">
                     <a href="shop.php" class="btn btn-primary"><i class="fas fa-bag-shopping"></i> Order Now</a>
                     <a href="shop.php" class="btn btn-outline-primary"><i class="fas fa-list-check"></i> View All Items</a>
                  </div>
                  <div class="hero-perks">
                     <span><i class="fas fa-check-circle"></i> Safe Packaging</span>
                     <span><i class="fas fa-check-circle"></i> Live Order Tracking</span>
                  </div>
               </div>
               <div class="hero-image-wrap">
                  <img src="images/hero_slide_3.jpg" alt="Fast Medicine Doorstep Delivery" class="hero-img">
               </div>
            </div>
         </div>

      </div>

      <!-- Carousel Pagination & Navigation Arrows -->
      <div class="swiper-pagination hero-pagination"></div>
      <div class="swiper-button-prev hero-arrow hero-arrow-prev"><i class="fas fa-chevron-left"></i></div>
      <div class="swiper-button-next hero-arrow hero-arrow-next"><i class="fas fa-chevron-right"></i></div>
   </div>
</section>

<!-- 2. Trust / Service Features Strip -->
<section class="trust-features-section">
   <div class="features-grid">
      <div class="feature-card">
         <div class="feature-icon-box"><i class="fas fa-shield-heart"></i></div>
         <div class="feature-card-content">
            <h3>Genuine Medicines</h3>
            <p>Products sourced strictly from verified licensed manufacturers</p>
         </div>
      </div>
      <div class="feature-card">
         <div class="feature-icon-box"><i class="fas fa-truck-ramp-box"></i></div>
         <div class="feature-card-content">
            <h3>Fast Delivery</h3>
            <p>Safe, prompt and hygienic doorstep delivery in hours</p>
         </div>
      </div>
      <div class="feature-card">
         <div class="feature-icon-box"><i class="fas fa-user-doctor"></i></div>
         <div class="feature-card-content">
            <h3>Pharmacist Support</h3>
            <p>Free professional guidance on prescriptions & dosages</p>
         </div>
      </div>
      <div class="feature-card">
         <div class="feature-icon-box"><i class="fas fa-lock"></i></div>
         <div class="feature-card-content">
            <h3>Secure Payments</h3>
            <p>Safe 256-Bit SSL encrypted transactions & Cash on Delivery</p>
         </div>
      </div>
   </div>
</section>

<!-- 3. Shop by Category Section -->
<section class="categories-section">
   <div class="section-header">
      <div>
         <span class="section-tag"><i class="fas fa-layer-group"></i> Catalog</span>
         <h2 class="section-title">Shop by Category</h2>
         <p class="section-subtitle">Explore our wide selection of certified medicines and daily wellness essentials</p>
      </div>
      <a href="shop.php" class="section-link">View All Categories <i class="fas fa-arrow-right"></i></a>
   </div>

   <div class="categories-grid">
      
      <a href="category.php?category=medicine" class="category-card">
         <div class="cat-icon-wrap cat-blue"><i class="fas fa-capsules"></i></div>
         <h4>Medicines</h4>
         <p>Prescription & OTC drugs</p>
         <span class="cat-arrow"><i class="fas fa-arrow-right"></i></span>
      </a>

      <a href="category.php?category=care" class="category-card">
         <div class="cat-icon-wrap cat-teal"><i class="fas fa-heart-pulse"></i></div>
         <h4>Health & Wellness</h4>
         <p>Vitamins & daily immunity</p>
         <span class="cat-arrow"><i class="fas fa-arrow-right"></i></span>
      </a>

      <a href="category.php?category=care" class="category-card">
         <div class="cat-icon-wrap cat-indigo"><i class="fas fa-pump-medical"></i></div>
         <h4>Personal Care</h4>
         <p>Skincare & personal hygiene</p>
         <span class="cat-arrow"><i class="fas fa-arrow-right"></i></span>
      </a>

      <a href="category.php?category=care" class="category-card">
         <div class="cat-icon-wrap cat-rose"><i class="fas fa-baby"></i></div>
         <h4>Baby Care</h4>
         <p>Gentle nutrition & infant care</p>
         <span class="cat-arrow"><i class="fas fa-arrow-right"></i></span>
      </a>

      <a href="category.php?category=care" class="category-card">
         <div class="cat-icon-wrap cat-emerald"><i class="fas fa-stethoscope"></i></div>
         <h4>Health Devices</h4>
         <p>Monitors & digital devices</p>
         <span class="cat-arrow"><i class="fas fa-arrow-right"></i></span>
      </a>

      <a href="category.php?category=care" class="category-card">
         <div class="cat-icon-wrap cat-amber"><i class="fas fa-mortar-pestle"></i></div>
         <h4>Ayurvedic Care</h4>
         <p>Natural remedies & herbal</p>
         <span class="cat-arrow"><i class="fas fa-arrow-right"></i></span>
      </a>

   </div>
</section>

<!-- 4. Featured Products Section (Connected to Database) -->
<section class="products-section">
   <div class="section-header">
      <div>
         <span class="section-tag"><i class="fas fa-star"></i> Featured Products</span>
         <h2 class="section-title">Verified Medicines & Products</h2>
         <p class="section-subtitle">Top-rated health solutions with certified batch quality</p>
      </div>
      <a href="shop.php" class="section-link">Explore Full Pharmacy <i class="fas fa-arrow-right"></i></a>
   </div>

   <div class="products-grid">
   <?php
      $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6"); 
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
            $original_price = round($fetch_product['price'] * 1.25);
   ?>
   <form action="" method="post" class="product-card">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">

      <!-- Product Badges -->
      <div class="card-badges">
         <span class="discount-pill">20% OFF</span>
         <span class="rx-pill"><i class="fas fa-shield-check"></i> Genuine</span>
      </div>

      <!-- Quick Action Buttons -->
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
               <label for="qty-<?= $fetch_product['id']; ?>" class="sr-only">Quantity</label>
               <input type="number" id="qty-<?= $fetch_product['id']; ?>" name="qty" class="qty-input" min="1" max="99" value="1" title="Quantity">
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
         echo '<div class="empty-state"><i class="fas fa-prescription-bottle"></i><p>No products available right now. Please check back shortly!</p></div>';
      }
   ?>
   </div>
</section>

<!-- 5. Promotional Healthcare Banner -->
<section class="promo-banner-section">
   <div class="promo-banner-card">
      <div class="promo-content">
         <span class="promo-tag"><i class="fas fa-sparkles"></i> Seasonal Health Special</span>
         <h2 class="promo-title">Up to 30% Off on Daily Health & Wellness Essentials</h2>
         <p class="promo-text">
            Stock up on immunity boosters, daily multivitamins, family first-aid supplies, and certified health monitors at discounted prices.
         </p>
         <div class="promo-buttons">
            <a href="category.php?category=care" class="btn btn-primary"><i class="fas fa-bag-shopping"></i> Shop Wellness Sale</a>
            <a href="shop.php" class="btn btn-secondary-white">Explore All Offers</a>
         </div>
      </div>
      <div class="promo-highlights">
         <div class="promo-stat">
            <span class="stat-num">100%</span>
            <span class="stat-label">Certified Authentic</span>
         </div>
         <div class="promo-stat">
            <span class="stat-num">2-Hour</span>
            <span class="stat-label">Express Delivery</span>
         </div>
         <div class="promo-stat">
            <span class="stat-num">50k+</span>
            <span class="stat-label">Satisfied Patients</span>
         </div>
      </div>
   </div>
</section>

<!-- 6. Why Choose HealthCareRx Section -->
<section class="why-us-section">
   <div class="section-header center">
      <span class="section-tag"><i class="fas fa-circle-check"></i> The HealthCareRx Advantage</span>
      <h2 class="section-title">Why Choose HealthCareRx?</h2>
      <p class="section-subtitle">We are committed to providing safe, reliable, and authentic healthcare for you and your family.</p>
   </div>

   <div class="why-us-grid">
      <div class="why-card">
         <div class="why-icon"><i class="fas fa-certificate"></i></div>
         <h4>Genuine Medicines</h4>
         <p>Every product is 100% genuine, directly sourced from licensed and audited pharmaceutical distributors.</p>
      </div>
      <div class="why-card">
         <div class="why-icon"><i class="fas fa-truck-medical"></i></div>
         <h4>Fast & Safe Delivery</h4>
         <p>Sealed temperature-controlled packaging ensures medicines maintain maximum clinical efficacy.</p>
      </div>
      <div class="why-card">
         <div class="why-icon"><i class="fas fa-user-doctor"></i></div>
         <h4>Licensed Pharmacists</h4>
         <p>Qualified pharmacists review and dispense your orders with accurate dosage and prescription guidance.</p>
      </div>
      <div class="why-card">
         <div class="why-icon"><i class="fas fa-shield-halved"></i></div>
         <h4>Secure Payments</h4>
         <p>Multiple safe payment options including UPI, credit/debit cards, net banking, and Cash on Delivery.</p>
      </div>
      <div class="why-card">
         <div class="why-icon"><i class="fas fa-clock-rotate-left"></i></div>
         <h4>Easy Repeat Refills</h4>
         <p>Reorder your chronic maintenance medicines effortlessly in a single click through your patient dashboard.</p>
      </div>
      <div class="why-card">
         <div class="why-icon"><i class="fas fa-rotate-left"></i></div>
         <h4>Hassle-Free Returns</h4>
         <p>Transparent return and refund policies designed to give you complete peace of mind.</p>
      </div>
   </div>
</section>

<?php include 'components/footer.php'; ?>

<!-- Swiper Bundle JS -->
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- Custom JS -->
<script src="js/script.js?v=<?php echo time(); ?>"></script>

<script>
// Initialize Modern Hero Swiper
var heroSwiper = new Swiper(".hero-slider", {
   loop: true,
   speed: 800,
   autoplay: {
      delay: 5000,
      disableOnInteraction: false,
   },
   pagination: {
      el: ".hero-pagination",
      clickable: true,
   },
   navigation: {
      nextEl: ".hero-arrow-next",
      prevEl: ".hero-arrow-prev",
   },
});
</script>

</body>
</html>