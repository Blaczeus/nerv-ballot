
if ($(".thumbs-slider").length > 0) {
    var direction = $(".tf-product-media-thumbs").data("direction");
    var thumbs = new Swiper(".tf-product-media-thumbs", {
      spaceBetween: 10,
      slidesPerView: "auto",
      freeMode: true,
      direction: "vertical",
      watchSlidesProgress: true,
      observer: true,
      observeParents: true,
      breakpoints: {
        0: {
          direction: "horizontal",
        },
        1200: {
          direction: "vertical",
          direction: direction,
        },
      },
      450: {
        direction: "vertical",
      },
    });
    var main = new Swiper(".tf-product-media-main", {
      spaceBetween: 0,
      observer: true,
      observeParents: true,
      navigation: {
        nextEl: ".thumbs-next",
        prevEl: ".thumbs-prev",
      },
      thumbs: {
        swiper: thumbs,
      },
    });

    // color
    function updateActiveColorButton(activeIndex) {
        $(".color-btn").removeClass("active");
    
        var currentSlide = $(".tf-product-media-main .swiper-slide").eq(activeIndex);
        var currentColor = currentSlide.data("color");
        if (currentColor) {
          $(".color-btn[data-color='" + currentColor + "']").addClass("active");
          $('.value-currentColor').text(currentColor);
          $(".select-currentColor").text(currentColor);
        }
    }
    main.on('slideChange', function () {
        updateActiveColorButton(this.activeIndex);
    });

    // Function scroll to the correct slide and thumb
    function scrollToColor(color) {
    var matchingSlides = $(".tf-product-media-main .swiper-slide").filter(function() {
        return $(this).data("color") === color;
    });
    if (matchingSlides.length > 0) {
        var firstIndex = matchingSlides.first().index();
        main.slideTo(firstIndex,1000,false);
        thumbs.slideTo(firstIndex,1000,false);
    }
    }
    $(".color-btn").on("click", function() {
    var color = $(this).data("color");
    
    $(".color-btn").removeClass("active");
    $(this).addClass("active");

    scrollToColor(color);
    });
    updateActiveColorButton(main.activeIndex);

    // material
    function updateActiveOtherVariantBtn(activeIndex) {
        $(".other-variant-btn").removeClass("active");
    
        var currentSlide = $(".tf-product-media-main .swiper-slide").eq(activeIndex);
        var currentOtherVariant = currentSlide.data("other-variant");
        if (currentOtherVariant) {
          $(".other-variant-btn[data-other-variant='" + currentOtherVariant + "']").addClass("active");
          $('.value-currentVariant').text(currentOtherVariant);
          $(".select-currentVariant").text(currentOtherVariant);
        }
    }
    main.on('slideChange', function () {
        updateActiveOtherVariantBtn(this.activeIndex);
    });

    // Function scroll to the correct slide and thumb
    function scrollToOtherVariant(otherVariant) {
    var matchingSlides = $(".tf-product-media-main .swiper-slide").filter(function() {
        return $(this).data("other-variant") === otherVariant;
    });
    if (matchingSlides.length > 0) {
        var firstIndex = matchingSlides.first().index();
        main.slideTo(firstIndex,1000,false);
        thumbs.slideTo(firstIndex,1000,false);
        }
    }
    $(".other-variant-btn").on("click", function() {
    var otherVariant = $(this).data("other-variant");
    
    $(".other-variant-btn").removeClass("active");
    $(this).addClass("active");
    scrollToOtherVariant(otherVariant);
    });
    updateActiveOtherVariantBtn(main.activeIndex);

}

(function ($) {
    "use strict";

    // PhotoSwipe/zoom integrations are intentionally disabled in this SPA build.

    var model_viewer = function () {

        if ($(".tf-model-viewer").length) {
   
            $(".tf-model-viewer-ui-button").on("click", function (e) {
                $(this).closest(".tf-model-viewer").find("model-viewer").removeClass("disabled");
                $(this).closest(".tf-model-viewer").toggleClass("active");
            });
            $(".tf-model-viewer-ui").on("dblclick", function (e) {
                $(this).closest(".tf-model-viewer").find("model-viewer").addClass("disabled");
                $(this).closest(".tf-model-viewer").toggleClass("active");
            });
        }

    }

  // Dom Ready
  $(function () {
    model_viewer();
  });
})(jQuery);

