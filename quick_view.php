<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

$pid = isset($_GET['pid']) ? $_GET['pid'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Product Details - HealthCareRx</title>

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
         <a href="shop.php">Pharmacy</a>
         <i class="fas fa-chevron-right separator"></i>
         <span>Product Details</span>
      </div>
   </div>
</div>

<section class="product-details-section">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?"); 
      $select_products->execute([$pid]);
      if($select_products->rowCount() > 0){
         while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
            $original_price = round($fetch_product['price'] * 1.25);
   ?>
   <form action="" method="post" class="product-details-card">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">

      <div class="details-grid">
         
         <!-- Left Column: Gallery -->
         <div class="details-gallery">
            <div class="gallery-main-view">
               <span class="gallery-badge"><i class="fas fa-shield-check"></i> Authentic Rx</span>
               <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="<?= htmlspecialchars($fetch_product['name']); ?>" class="main-display-img" id="main-product-image">
            </div>
            
            <div class="gallery-thumbnails">
               <?php if(!empty($fetch_product['image_01'])): ?>
                  <div class="thumb-box active" onclick="switchImage('uploaded_img/<?= $fetch_product['image_01']; ?>', this)">
                     <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="Thumbnail 1">
                  </div>
               <?php endif; ?>
               <?php if(!empty($fetch_product['image_02'])): ?>
                  <div class="thumb-box" onclick="switchImage('uploaded_img/<?= $fetch_product['image_02']; ?>', this)">
                     <img src="uploaded_img/<?= $fetch_product['image_02']; ?>" alt="Thumbnail 2">
                  </div>
               <?php endif; ?>
               <?php if(!empty($fetch_product['image_03'])): ?>
                  <div class="thumb-box" onclick="switchImage('uploaded_img/<?= $fetch_product['image_03']; ?>', this)">
                     <img src="uploaded_img/<?= $fetch_product['image_03']; ?>" alt="Thumbnail 3">
                  </div>
               <?php endif; ?>
            </div>
         </div>

         <!-- Right Column: Meta & Actions -->
         <div class="details-info-pane">
            
            <div class="details-meta-top">
               <span class="stock-status-chip in-stock"><i class="fas fa-circle-check"></i> In Stock & Ready to Ship</span>
               <span class="cert-code">ID: #HRX-<?= $fetch_product['id']; ?></span>
            </div>

            <h1 class="details-title"><?= htmlspecialchars($fetch_product['name']); ?></h1>

            <div class="details-rating-bar">
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-stroke"></i>
               </div>
               <span class="rating-number">4.8</span>
               <span class="rating-reviews">(142 verified patient reviews)</span>
            </div>

            <div class="details-price-box">
               <div class="price-figures">
                  <span class="current-price">₹<?= $fetch_product['price']; ?></span>
                  <span class="original-price">₹<?= $original_price; ?></span>
                  <span class="savings-chip">Save 20% (₹<?= $original_price - $fetch_product['price']; ?>)</span>
               </div>
               <p class="tax-note">Inclusive of all pharmaceutical taxes. Free delivery above ₹499.</p>
            </div>

            <!-- Quick Purchase Controls -->
            <div class="purchase-controls">
               <div class="qty-control-box">
                  <label for="detail-qty" class="qty-label">Select Quantity:</label>
                  <div class="stepper-wrap">
                     <button type="button" class="stepper-btn" onclick="decrementQty()"><i class="fas fa-minus"></i></button>
                     <input type="number" id="detail-qty" name="qty" class="qty-input" min="1" max="99" value="1">
                     <button type="button" class="stepper-btn" onclick="incrementQty()"><i class="fas fa-plus"></i></button>
                  </div>
               </div>

               <div class="action-buttons-wrap">
                  <button type="submit" name="add_to_cart" class="btn btn-primary btn-lg">
                     <i class="fas fa-cart-plus"></i> Add to Shopping Cart
                  </button>
                  <button type="submit" name="add_to_wishlist" class="btn btn-secondary-white btn-lg">
                     <i class="fas fa-heart"></i> Save to Wishlist
                  </button>
               </div>
            </div>

            <!-- Assurance Highlights -->
            <div class="assurance-list">
               <div class="assurance-item">
                  <i class="fas fa-truck-fast"></i>
                  <div>
                     <strong>Fast Doorstep Delivery</strong>
                     <span>Available for emergency healthcare dispatch</span>
                  </div>
               </div>
               <div class="assurance-item">
                  <i class="fas fa-shield-check"></i>
                  <div>
                     <strong>100% Genuine Medicine</strong>
                     <span>Certified batch & pharmaceutical safety checked</span>
                  </div>
               </div>
               <div class="assurance-item">
                  <i class="fas fa-rotate-left"></i>
                  <div>
                     <strong>Hassle-Free Returns</strong>
                     <span>Easy return policy on eligible unopened products</span>
                  </div>
               </div>
            </div>

         </div>

      </div>

      <!-- Information Tabs / Sections -->
      <div class="product-info-tabs">
         
         <div class="tab-card">
            <h3 class="tab-title"><i class="fas fa-file-lines"></i> Product Description & Details</h3>
            <div class="tab-content">
               <p><?= nl2br(htmlspecialchars($fetch_product['details'])); ?></p>
            </div>
         </div>

         <div class="tab-card">
            <h3 class="tab-title"><i class="fas fa-clipboard-check"></i> Directions & Dosage Instructions</h3>
            <div class="tab-content">
               <p>Use strictly according to your registered medical practitioner's prescription or the package dosage instructions. Swallow whole with water. Do not exceed the prescribed daily dose.</p>
            </div>
         </div>

         <div class="tab-card">
            <h3 class="tab-title"><i class="fas fa-triangle-exclamation"></i> Safety Information & Storage</h3>
            <div class="tab-content">
               <ul class="safety-list">
                  <li>Store in a cool, dry place away from direct sunlight (below 25°C).</li>
                  <li>Keep strictly out of reach of children.</li>
                  <li>Do not consume if the tamper-evident protective seal is damaged or missing.</li>
                  <li>Consult a licensed physician or pharmacist if pregnant, nursing, or undergoing concurrent treatment.</li>
               </ul>
            </div>
         </div>

      </div>

   </form>
   <?php
         }
      }else{
         echo '<div class="empty-state"><i class="fas fa-prescription-bottle"></i><p>Product not found. It may have been relocated or removed.</p><a href="shop.php" class="btn btn-primary" style="width:auto;margin-top:1.5rem;">Return to Catalog</a></div>';
      }
   ?>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js?v=<?php echo time(); ?>"></script>

<script>
function switchImage(src, thumbElement) {
   document.getElementById('main-product-image').src = src;
   var thumbs = document.querySelectorAll('.thumb-box');
   thumbs.forEach(function(el) { el.classList.remove('active'); });
   thumbElement.classList.add('active');
}

function incrementQty() {
   var input = document.getElementById('detail-qty');
   var val = parseInt(input.value) || 1;
   if(val < 99) input.value = val + 1;
}

function decrementQty() {
   var input = document.getElementById('detail-qty');
   var val = parseInt(input.value) || 1;
   if(val > 1) input.value = val - 1;
}
</script>

</body>
</html>