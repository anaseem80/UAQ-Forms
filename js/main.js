// document.addEventListener('DOMContentLoaded', function() {
//     const navbar = document.querySelector(".navbar");
//     let prevScrollPos = window.pageYOffset;
//     function toggleNavbar() {
//         const currentScrollPos = window.pageYOffset;
//         if (prevScrollPos > currentScrollPos) {
//               navbar.classList.add('visible-nav');
//               navbar.classList.remove('hidden-nav');
//         } else {
//             navbar.classList.add('hidden-nav');
//             navbar.classList.remove('visible-nav');
//         }
        
//         prevScrollPos = currentScrollPos;
//     }
  
//     // Initial call to toggleNavbar
//     // toggleNavbar();
  
//     // Listen for scroll events
//     window.addEventListener('scroll', toggleNavbar);
//   });


//   $(window).on("scroll", function () {
//     var scroll = $(window).scrollTop();
//     if (scroll < 2) {
//     $(".navbar").removeClass("shadow-sm");

//     } else {
//     $(".navbar").addClass("shadow-sm");
//     }
// });


(function($) { "use strict";

	//Switch dark/light
		
	$(document).ready(function(){"use strict";
	
		//Scroll back to top
		
		var progressPath = document.querySelector('.progress-wrap path');
		var pathLength = progressPath.getTotalLength();
		progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
		progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
		progressPath.style.strokeDashoffset = pathLength;
		progressPath.getBoundingClientRect();
		progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';		
		var updateProgress = function () {
			var scroll = $(window).scrollTop();
			var height = $(document).height() - $(window).height();
			var progress = pathLength - (scroll * pathLength / height);
			progressPath.style.strokeDashoffset = progress;
		}
		updateProgress();
		$(window).scroll(updateProgress);	
		var offset = 50;
		// var duration = 550;
		jQuery(window).on('scroll', function() {
			if (jQuery(this).scrollTop() > offset) {
				jQuery('.progress-wrap').addClass('active-progress');
			} else {
				jQuery('.progress-wrap').removeClass('active-progress');
			}
		});				
		jQuery('.progress-wrap').on('click', function(event) {
			event.preventDefault();
			jQuery('html, body').animate({scrollTop: 0}, 0);
			return false;
		})
		
		
	});
	
})(jQuery); 


window.SmoothScrollOptions = {
	// Scrolling Core
	animationTime: 400, // [ms]
	stepSize: 150, // [px]

	// Acceleration
	accelerationDelta: 50, // 50
	accelerationMax: 3, // 3

	// Keyboard Settings
	keyboardSupport: true, // option
	arrowScroll: 50, // [px]

	// Pulse (less tweakable)
	// ratio of "tail" to "acceleration"
	pulseAlgorithm: true,
	pulseScale: 4,
	pulseNormalize: 1,

	// Other
	touchpadSupport: false, // ignore touchpad by default
	fixedBackground: true,
	excluded          : ''  
}

$("#quote").submit(function(e){
	e.preventDefault()
	var data = $('#quote').serializeArray().reduce(function(obj, item) {
		obj[item.name] = item.value;
		return obj;
	}, {});
	$(".loader-quote").css("display","grid")
	$("#submit-quote").attr("disabled","true")
	$.post('../php/quote.php',data , function(data) {
		$(".loader-quote").fadeOut()
		$("#submit-quote").removeAttr("disabled")
		if(data == 1){
			toastr.success('Thanks for reaching out with us, We will be in touch with you soon! 😍');
		}else{
			toastr.error('Something went wrong, please try again later');
		}
		
		
	})
})

// document.addEventListener('contextmenu', function (e) {
//     e.preventDefault();
// });