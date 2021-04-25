let controller = new ScrollMagic.Controller();
let tl = new TimelineMax();

tl.to(".header-intro", 3, { y: -300 });

let scene = new ScrollMagic.Scene({
  triggerElement: ".header-intro",
  duration: "300%",
  triggerHook: 0,
})
  .setTween(tl)
  .addTo(controller);

$(function () {
  // smooth scroll
  $(".logo").click(function () {
    $("html, body").animate(
      {
        scrollTop: 0,
      },
      500
    );
  });

  $(".page-link").click(function () {
    let id = $(this).attr("href");
    let position = $(id).offset().top;
    $("html, body").animate(
      {
        scrollTop: position,
      },
      500
    );
    return false;
  });
});
