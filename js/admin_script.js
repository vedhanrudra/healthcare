let profile = document.querySelector('.header .flex .profile');
let menuBtn = document.querySelector('#menu-btn');
let userBtn = document.querySelector('#user-btn');
let leftMenu = document.querySelector('.left-menu');

if(menuBtn){
   menuBtn.onclick = (e) =>{
      e.stopPropagation();
      if(leftMenu) leftMenu.classList.toggle('active');
      if(profile) profile.classList.remove('active');
   }
}

if(userBtn){
   userBtn.onclick = (e) =>{
      e.stopPropagation();
      if(profile) profile.classList.toggle('active');
      if(leftMenu) leftMenu.classList.remove('active');
   }
}

document.addEventListener('click', (e) =>{
   if(profile && !profile.contains(e.target) && userBtn && !userBtn.contains(e.target)){
      profile.classList.remove('active');
   }
   if(window.innerWidth <= 991 && leftMenu && !leftMenu.contains(e.target) && menuBtn && !menuBtn.contains(e.target)){
      leftMenu.classList.remove('active');
   }
});

window.onscroll = () =>{
   if(profile) profile.classList.remove('active');
}

// Product thumbnail switcher for update_product.php
let mainImage = document.querySelector('.update-product .image-container .main-image img');
let subImages = document.querySelectorAll('.update-product .image-container .sub-image img');

if(mainImage && subImages.length > 0){
   subImages.forEach(image =>{
      image.onclick = () =>{
         let src = image.getAttribute('src');
         mainImage.src = src;
      }
   });
}