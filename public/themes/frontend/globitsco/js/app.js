$(document).ready(function () {
    AOS.init({
      duration: 1200,
    });
  
    $(".partner").on("init", function (event, slick) {
      AOS.refresh();
    });
  
    // menu mobi:
    $(".menu-toggle").click(function () {
      $(".auto-menu").toggleClass("open-menu");
      $(this).toggleClass("is-active");
      $("body").toggleClass("block-page");
    });
  
    //-----------//
  
    $(window).on("scroll", function () {
      var scrollPos = $(window).scrollTop();
      var element = $(".navbar");
      var elementPro = $(".all-nav-products");
      var elementPos = element.offset().top;
  
      if ((scrollPos = elementPos)) {
        element.addClass("bg-nav");
      } else {
        element.removeClass("bg-nav");
      }
    });
  
    //--------hover picture----------
  
    const items = document.querySelectorAll(".item");
    items.forEach((el) => {
      const image = el.querySelector("img");
      el.addEventListener("mouseenter", (e) => {
        gsap.to(image, { autoAlpha: 1 });
      });
      el.addEventListener("mouseleave", (e) => {
        gsap.to(image, { autoAlpha: 0 });
      });
      el.addEventListener("mousemove", (e) => {
        gsap.set(image, { x: e.offsetX - 200 });
      });
    });
  
    //-------------------------
    // Mở mục đầu tiên mặc định
    // $(".list-quetion").first().addClass("open").find(".text-anser").slideDown();
    // $(".list-quetion.active i").removeClass("icon-plus").addClass("icon-x");
  
    // Hiệu ứng accordion khi nhấn vào tiêu đề
    $(".list-quetion").click(function () {
      // Nếu mục hiện tại đang mở, đóng lại
      if ($(this).hasClass("open")) {
        $(this).removeClass("open").find(".text-anser").slideUp();
        $(this).find("i").removeClass("icon-x").addClass("icon-plus");
      } else {
        // Đóng tất cả các mục khác
        $(".list-quetion").removeClass("open").find(".text-anser").slideUp();
        $(".list-quetion i").removeClass("icon-x").addClass("icon-plus");
  
        // Mở mục hiện tại
        $(this).addClass("open").find(".text-anser").slideDown();
        $(this).find("i").removeClass("icon-plus").addClass("icon-x");
      }
    });
  
    $(".partner").slick({
      infinite: true,
      dots: true,
      slidesToShow: 5,
      slidesToScroll: 2,
      arrows: false,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            arrows: false,
          },
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            arrows: false,
            dots: true,
          },
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            arrows: false,
            dots: true,
          },
        },
      ],
    });
    //--------- faq landing----------//
    $(".accordion-header").click(function () {
      // Đóng các accordion khác trừ accordion hiện tại
      $(".accordion-content").not($(this).next()).slideUp();
      $(".accordion-header").not(this).removeClass("active");
      // Mở accordion hiện tại và xoay icon
      $(this).toggleClass("active");
      $(this).next().slideToggle();
    });
  
    // click languages
    $(".language-selector").on("click", function (e) {
      e.stopPropagation();
      $(".sub-language").toggleClass("open");
      $(".sub-language li a").on("click", function () {
        //select lang and apply changes
        $lang = $(this).text();
        $(".bt-language span").text($lang);
      });
    });
  });
  
  //=============
  
  const cursor = document.querySelector(".cursor");
  const follower = document.querySelector(".cursor-follower");
  const card = document.querySelectorAll(".box-picture");
  
  let posX = 0,
    posY = 0,
    mouseX = 0,
    mouseY = 0;
  
  TweenMax.to({}, 0.02, {
    repeat: -1,
    onRepeat: function () {
      posX += (mouseX - posX) / 9;
      posY += (mouseY - posY) / 9;
  
      TweenMax.set(follower, {
        css: {
          left: posX - 16,
          top: posY - 16,
        },
      });
  
      TweenMax.set(cursor, {
        css: {
          left: mouseX,
          top: mouseY,
        },
      });
    },
  });
  
  document.addEventListener("mousemove", (e) => {
    mouseX = e.pageX;
    mouseY = e.pageY;
  });
  
  card.forEach((el) => {
    el.addEventListener("mouseenter", () => {
      cursor.classList.add("active");
      follower.classList.add("active");
    });
  
    el.addEventListener("mouseleave", () => {
      cursor.classList.remove("active");
      follower.classList.remove("active");
    });
  });
  // ------------- the end -----------------
  
  // ------------ the end gsap--------
  