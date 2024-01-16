<footer class="bg-light p-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="row">
                        <div class="col-12 m-lg-0 mb-3 order-lg-1 order-2">
                            <p class="mb-5">At Computer forms one way to showcase the company’s success to our team members, partners and customers is by following to our core values<p>
                        </div>
                        <div class="col-12 m-lg-0 mb-3 order-lg-2 order-1">
                            <img src="../assets/uploads/<?php echo $settings['logo'] ?>" class="mt-2" alt="logo" width="127" height="92">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 links">
                    <div class="row">
                        <div class="col-lg-6 m-lg-0 mb-3">
                            <p class="head">Company</p>
                            <ul class="list-unstyled">
                                <li><a class="custom-link" href="/">Home</a></li>
                                <li><a class="custom-link" href="expertises.php">Expertise</a></li>
                                <li><a class="custom-link" href="gellary.php">Gallery</a></li>
                                <li><a class="custom-link" href="quote.php">Get Quote</a></li>
                                <li><a class="custom-link" href="contact-us.php">Contact Us</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-6 m-lg-0 mb-3">
                            <div class="links">
                                <p class="head">Solutions</p>
                                <ul class="list-unstyled">
                                    <li><a class="custom-link" href="consultation.php">Consultation</a></li>
                                    <li><a class="custom-link" href="collaboration.php">Collaboration</a></li>
                                    <li><a class="custom-link" href="quality.php">Quality Assurance</a></li>
                                    <li><a class="custom-link" href="sustainability.php">Sustainability</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-md-12 links">
                    <div class="row">
                        <div class="col-lg-6 m-lg-0 mb-3">
                            <p class="head">OFFICE</p>
                            <address>
                                P.O Box: 505, <br>
                                Umm Al Quwain, <br>
                                United Arab Emirates.
                            </address>
                        </div>
                        <div class="col-lg-6 m-lg-0 mb-3">
                            <p class="head">Contact</p>
                            <p class="d-flex align-items-center"><img src="images/mail.svg" alt="mail" width="24" height="24"> <a href="mailto:support@computerformsuaq.com" class="ms-2 text-decoration-none text-wrap custom-link">support@computerformsuaq.com</a></p>
                            <p class="printed">Printed with ❤️️️ at our facility in UAE</p>
                        </div>
                        <div class="links col-lg-12">
                            <p>Call Us:</p>
                            <div class="d-flex justify-content-between flex-wrap">
                                <p class="d-flex align-items-center"><img src="images/call.svg" width="16" height="16" alt="phone"> <a class="ms-1 custom-link" href="tel:+971 6 766 6727">+971 6 766 6727</a></p>
                                <p class="d-flex align-items-center"><img src="images/call.svg" width="16" height="16" alt="phone"> <a class="ms-1 custom-link" href="tel:+971 50 796 9292">+971 50 796 9292</a></p>
                                <p class="d-flex align-items-center"><img src="images/call.svg" width="16" height="16" alt="phone"> <a class="ms-1 custom-link" href="tel:+971 52 911 8822">+971 52 911 8822</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="assets/js/vendors/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a1a75d5546.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
      </script>
    <script>
        var swiper = new Swiper(".header", {
            spaceBetween: 30,
            effect: "fade",
            loop:true,
            autoplay: true,
        });
        var swiper = new Swiper(".solutions", {
            slidesPerView: 4,
            spaceBetween: 30,
            autoplay: true,
            breakpoints: {
                1024: {
                    slidesPerView: 4,
                },
                468: {
                    slidesPerView: 3,
                },
                0: {
                    slidesPerView: 1,
                },
            },
            pagination: {
                el: ".swiper-pagination-solutions",
                clickable: true,
            },
        });

        var swiper = new Swiper(".clients", {
            slidesPerView: 6,
            spaceBetween: 30,
            autoplay: true,
            breakpoints: {
                1024: {
                    slidesPerView: 6,
                },
                468: {
                    slidesPerView: 3,
                },
                0: {
                    slidesPerView: 1,
                },
            },
            navigation: {
                nextEl: ".swiper-next-clients",
                prevEl: ".swiper-prev-clients",
            },
        });
    </script>
    <script src="js/main.js"></script>
    <script async src="https://cdnjs.cloudflare.com/ajax/libs/smoothscroll/1.4.9/SmoothScroll.js"></script>
    <script>
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
		}
	</script>
</body>
</html>