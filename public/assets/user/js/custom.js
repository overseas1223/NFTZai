(function ($) {
  "use strict"; // Start of use strict

// Preloader Start
    $(window).on('load',function () {
        $('#status').fadeOut();
        $('#preloader')
            .delay(350)
            .fadeOut('slow');
        $('body')
            .delay(350)
    });
// Preloader End

/// MAIN MENU SCRIPT START

  // Smooth scrolling using jQuery easing
  $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: (target.offset().top - 48)
        }, 1000, "easeInOutExpo");
        return false;
      }
    }
  });

  // Activate scrollspy to add active class to navbar items on scroll
  $('body').scrollspy({
    target: '#mainNav',
    offset: 54
  });

// Search Bar Open on click script start
  var submitIcon = $(".searchbox-icon");
  var inputBox = $(".searchbox-input");
  var searchBox = $(".searchbox");
  var isOpen = false;
  submitIcon.click(function (e) {
    e.preventDefault()
    if (isOpen == false) {
      searchBox.addClass("searchbox-open");
      inputBox.focus();
      isOpen = true;
    } else {
      searchBox.removeClass("searchbox-open");
      inputBox.focusout();
      isOpen = false;
    }
  });
  submitIcon.mouseup(function () {
    return false;
  });
  searchBox.mouseup(function () {
    return false;
  });
  $(document).mouseup(function () {
    if (isOpen == true) {
      $(".searchbox-icon").css("display", "flex");
      submitIcon.click();
    }
  });
// Search Bar Open on click script end

  // Hero Mouse Move Effect start
  $(document).mousemove(function(event){
    var xPos = (event.clientX/$(window).width())-0.5,
        yPos = (event.clientY/$(window).height())-0.5,
        box = $('.box'),
        coord = $('.coordinates');
   
   TweenLite.to(box, 0.6, {
     rotationY: 5 * xPos, 
     rotationX: 5 * yPos,
     ease: Power1.easeOut,
     transformPerspective: 500,
     transformOrigin: 'center'
   });
 });
  // Hero Mouse Move Effect end

  // MAIN MENU SCRIPT END

  // Jquery counterUp Start

  $('.counter').counterUp({
    delay: 10,
    time: 2000
  });

  // Jquery counterUp End

    
    // Main Item Slider Owl Carousel Start
    $('.main-items').owlCarousel({
      loop: true,
      dots: false,
      autoplayHoverPause: true,
      autoplay: false,
      smartSpeed: 1000,
      margin: 30,
      nav: true,
      navText: [
          "<i class='fas fa-arrow-left'></i>",
          "<i class='fas fa-arrow-right'></i>"
      ],
      responsive: {
          0: {
            items: 1,
          },
          480: {
              items:1,
          },
          576: {
              items:1,
          },
          768: {
              items:1,
          },
          1200: {
              items:1,
          }
      },
    });

    // Main Item Slider Owl Carousel End

    // Home Know Us More Owl Carousel Start
    $('.latest-collection-items').owlCarousel({
      // stagePadding: 200,
      loop: true,
      dots: false,
      autoplayHoverPause: true,
      autoplay: false,
      smartSpeed: 1000,
      margin: 30,
      nav: true,
      navText: [
          "<i class='fas fa-arrow-left'></i>",
          "<i class='fas fa-arrow-right'></i>"
      ],
      responsive: {
          0: {
            items: 1,
          },
          480: {
              items:1,
          },
          576: {
              items:1,
          },
          768: {
              items:2,
          },
          1200: {
              items:3,
          }
      },
    });
    // Home Know Us More Owl Carousel End

    // Trending Now Owl Carousel Start
    $('.trending-now-items').owlCarousel({
      loop: true,
      dots: false,
      autoplayHoverPause: true,
      autoplay: false,
      smartSpeed: 1000,
      margin: 30,
      nav: true,
      navText: [
          "<i class='fas fa-arrow-left'></i>",
          "<i class='fas fa-arrow-right'></i>"
      ],
      responsive: {
          0: {
            items: 1,
          },
          480: {
              items:1,
          },
          576: {
              items:2,
          },
          768: {
              items:3,
          },
          1200: {
              items:4,
          }
      },
    });
    // Trending Now Owl Carousel End

    // All Artist Page Slider Owl Carousel Start
    $('.all-artist-page-items').owlCarousel({
      loop: true,
      dots: false,
      autoplayHoverPause: true,
      autoplay: false,
      smartSpeed: 1000,
      margin: 30,
      nav: true,
      navText: [
          "<i class='fas fa-arrow-left'></i>",
          "<i class='fas fa-arrow-right'></i>"
      ],
      responsive: {
          0: {
            items: 1,
          },
          480: {
              items:1,
          },
          576: {
              items:1,
          },
          768: {
              items:3,
          },
          1200: {
              items:4,
          }
      },
    });
    // All Artist Page Slider Owl Carousel End

  // Toggle Password Script Start
  $(".toggle").on("click", function () {

    if ($(".password").attr("type") == "password")
    {
        //Change type attribute
        $(".password").attr("type", "text");
        $(this).removeClass("fa-eye");
        $(this).addClass("fa-eye-slash");
    } else
    {
        //Change type attribute
        $(".password").attr("type", "password");
        $(this).addClass("fa-eye");
        $(this).removeClass("fa-eye-slash");
    }
});
  // Toggle Password Script End

// Multiple Modal, Modals in Modal Start
  $("#myModal2").on('show.bs.modal', function (e) {
    $("#myModal1").modal("hide");
  });

    $("#signInModal").on('show.bs.modal', function (e) {
      $("#signUpModal").modal("hide");
  });

    $("#signUpModal").on('show.bs.modal', function (e) {
      $("#signInModal").modal("hide");
  });

    $("#forgetPasswordModal").on('show.bs.modal', function (e) {
      $("#signInModal").modal("hide");
  });

    $("#signInModal").on('show.bs.modal', function (e) {
      $("#forgetPasswordModal").modal("hide");
  });

    $("#purchase2Modal").on('show.bs.modal', function (e) {
      $("#purchase1Modal").modal("hide");
  });
    $("#purchase3Modal").on('show.bs.modal', function (e) {
      $("#purchase2Modal").modal("hide");
  });
    $("#placeBid2Modal").on('show.bs.modal', function (e) {
      $("#placeBidModal").modal("hide");
  });
    $("#putOnSale2Modal").on('show.bs.modal', function (e) {
      $("#putOnSaleModal").modal("hide");
  });
    $("#putOnSale3Modal").on('show.bs.modal', function (e) {
      $("#putOnSale2Modal").modal("hide");
  });
    $("#acceptBid2Modal").on('show.bs.modal', function (e) {
      $("#acceptBidModal").modal("hide");
  });

// Multiple Modal, Modals in Modal End

// Select Wallet Name Script Start

  $(".connect-wallet-name").on("click", function(e) {
    // remove classname 'active' from all li who already has classname 'active'
    $(".connect-wallet-name.active").removeClass("active"); 
    // adding classname 'active' to current click li 
    $(this).toggleClass("active");
  });

// Select Wallet Name Script End

  // Jquery Custom Select / nice select Start
  $('select').niceSelect();
  // Jquery Custom Select / nice select End

// Add Active class to Love btn Start
  $( ".favourite-btn" ).on( "click", function() {
    $( ".favourite-btn" ).toggleClass( "active" );
  });

// Add Active class to Love btn end

  // Image Size Resize JS
  var boxBgSetting = $(".box-bg-image");
  boxBgSetting.each(function(indx){
      if ($(this).attr("data-background")){
          $(this).css("background-image", "url(" + $(this).data("background") + ")");
      }
  });
  // Image Size Resize JS

  // Initialize WOW JS
  new WOW().init();

})(jQuery); // End of use strict