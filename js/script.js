// HealthCareRx Modern Frontend Interactivity

document.addEventListener('DOMContentLoaded', () => {
   
   const profileBtn = document.querySelector('#user-btn');
   const profileDropdown = document.querySelector('.profile-dropdown') || document.querySelector('.header .flex .profile');
   
   const menuBtn = document.querySelector('#menu-btn');
   const mobileDrawer = document.querySelector('#mobile-drawer');
   const drawerOverlay = document.querySelector('#mobile-drawer-overlay');
   const drawerCloseBtn = document.querySelector('#drawer-close-btn');

   // Toggle Profile Dropdown
   if (profileBtn && profileDropdown) {
      profileBtn.addEventListener('click', (e) => {
         e.stopPropagation();
         profileDropdown.classList.toggle('active');
         if (mobileDrawer) {
            mobileDrawer.classList.remove('active');
            if (drawerOverlay) drawerOverlay.classList.remove('active');
         }
      });
   }

   // Open Mobile Drawer
   if (menuBtn && mobileDrawer) {
      menuBtn.addEventListener('click', (e) => {
         e.stopPropagation();
         mobileDrawer.classList.add('active');
         if (drawerOverlay) drawerOverlay.classList.add('active');
         if (profileDropdown) profileDropdown.classList.remove('active');
      });
   }

   // Close Mobile Drawer
   const closeDrawer = () => {
      if (mobileDrawer) mobileDrawer.classList.remove('active');
      if (drawerOverlay) drawerOverlay.classList.remove('active');
   };

   if (drawerCloseBtn) drawerCloseBtn.addEventListener('click', closeDrawer);
   if (drawerOverlay) drawerOverlay.addEventListener('click', closeDrawer);

   // Close popups when clicking outside or scrolling
   document.addEventListener('click', (e) => {
      if (profileDropdown && !profileDropdown.contains(e.target) && profileBtn && !profileBtn.contains(e.target)) {
         profileDropdown.classList.remove('active');
      }
   });

   window.addEventListener('scroll', () => {
      if (profileDropdown) profileDropdown.classList.remove('active');
   });

   // Quick View gallery switcher (backward compatibility)
   const mainImage = document.querySelector('#main-product-image');
   const thumbBoxes = document.querySelectorAll('.thumb-box img');
   
   if (mainImage && thumbBoxes.length > 0) {
      thumbBoxes.forEach(thumb => {
         thumb.addEventListener('click', () => {
            mainImage.src = thumb.getAttribute('src');
            document.querySelectorAll('.thumb-box').forEach(b => b.classList.remove('active'));
            thumb.parentElement.classList.add('active');
         });
      });
   }

});