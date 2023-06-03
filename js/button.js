$(document).ready(function() {
  var button = $(".button-toggle-slide");

  button.on("click", function() {
    var parent = $(this).closest('.content_dashboard');
    var dataTargetToggleSlide = $("#" + $(this).data("scroll-id"));

    parent.find(button).not(this).removeClass("active").each(function() {
      var target = $("#" + $(this).data("scroll-id"));
      target.slideUp();
    });

    $(this).addClass("active");

    if ($(this).hasClass("active")) {
      dataTargetToggleSlide.slideDown();
    } else {
      dataTargetToggleSlide.slideUp();
    }
  });
});
