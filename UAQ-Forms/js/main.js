document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector(".navbar");
    let prevScrollPos = window.pageYOffset;
    function toggleNavbar() {
        const currentScrollPos = window.pageYOffset;
        if (prevScrollPos > currentScrollPos) {
              navbar.classList.add('visible-nav');
              navbar.classList.remove('hidden-nav');
        } else {
            navbar.classList.add('hidden-nav');
            navbar.classList.remove('visible-nav');
        }
        
        prevScrollPos = currentScrollPos;
    }
  
    // Initial call to toggleNavbar
    // toggleNavbar();
  
    // Listen for scroll events
    window.addEventListener('scroll', toggleNavbar);
  });


  $(window).on("scroll", function () {
    var scroll = $(window).scrollTop();
    if (scroll < 2) {
    $(".navbar").removeClass("shadow-sm");

    } else {
    $(".navbar").addClass("shadow-sm");
    }
});