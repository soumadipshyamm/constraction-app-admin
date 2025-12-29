//stellarnav
if ($('.stellarnav').length) {
  jQuery(document).ready(function ($) {
    jQuery('.stellarnav').stellarNav({
      theme: 'dark',
      breakpoint: 960,
      position: 'right',
    });
  })
}


(function ($) {
  "use strict";

  $(".banner-slider-area").owlCarousel({
    autoplayHoverPause: true,
    autoplaySpeed: 1500,
    autoplay: true,
    loop: true,
    dots: true,
    margin: 30,
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 1,
      },
      992: {
        items: 1,
      },
    },
  });


  // Go to Top
  $(function () {
    // Scroll Event
    $(window).on("scroll", function () {
      var scrolled = $(window).scrollTop();
      if (scrolled > 600) $(".go-top").addClass("active");
      if (scrolled < 600) $(".go-top").removeClass("active");
    });
    // Click Event
    $(".go-top").on("click", function () {
      $("html, body").animate({ scrollTop: "0" }, 500);
    });
  });


  // WOW Animation JS
  if ($(".wow").length) {
    var wow = new WOW({
      mobile: false,
    });
    wow.init();
  }

})(jQuery);


// document.getElementById("uploadBtn").onchange = function () {
// 	document.getElementById("uploadFile").value = this.value.replace(
// 		"C:\\fakepath\\",
// 		""
// 	);
// };


document.addEventListener("DOMContentLoaded", function () {
  const uploadBtn = document.getElementById("uploadBtn");
  if (uploadBtn) {
    uploadBtn.onchange = function () {
      document.getElementById("uploadFile").value = this.value.replace(
        "C:\\fakepath\\",
        ""
      );
    };
  } else {
    console.error("Element with ID 'uploadBtn' not found.");
  }
});
// testimonial-slides

$('.testimonial-slide').owlCarousel({
  loop: true,
  margin: 50,
  autoplay: true,
  smartSpeed: 1000,
  autoplayTimeout: 3000,
  nav: false,
  dots: false,
  responsive: {
    0: {
      items: 1,

    },
    600: {
      items: 1,

    },
    1000: {
      items: 2,

    }
  }
});





// blog-slides
$('.blogs-slide').owlCarousel({
  loop: true,
  margin: 50,
  autoplay: true,
  smartSpeed: 1000,
  autoplayTimeout: 3000,
  dots: false,
  nav: true,
  navText: ["<img src='./images/left-arrow.svg'>", "<img src='./images/right-arro.svg'>"],
  responsive: {
    0: {
      items: 1,
      nav: false,

    },
    600: {
      items: 2,
    },
    1000: {
      items: 3,

    }
  }
});



