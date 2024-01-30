<?php 
$title = "Home";
include 'includes/header.php';
?>
    <?php 
        $sql = 'SELECT * FROM sliders';
        $result = mysqli_query($conn, $sql);
        $sliders = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>


    <header class="header-top">
        <div class="swiper header">
            <div class="swiper-wrapper">
                <?php foreach($sliders as $index => $item): ?>
                    <div class="swiper-slide" style="background-color: <?php echo $item['color']?>;">
                        <div class="container h-100">
                            <div class="row align-items-center h-100 text-lg-start text-center align-content-center">
                                <div class="col-lg-6 h-auto" data-aos="fade-left"><h1><span class="d-block"><?php echo $item['title']?></span> <span class="d-block"><?php echo $item['title2']?></span></h1></div>
                                <div class="col-lg-6 h-auto" data-aos="fade-right">
                                    <div class="image-slider">
                                        <img src="../assets/uploads/sliders/<?php echo $item['image']?>" class="d-block h-100 w-100 img-fluid object-contain" alt="slider image">
                                    </div>
                                </div>    
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </header>
    <section class="row about-us m-0 p-0 align-items-center">
        <div class="col-xl-6 h-100 p-0 left-side"><img src="images/about.jpg" class="w-100 img-fluid" alt="about"></div>
        <div class="col-xl-6 h-100 right-side">
            <div class="col-lg-9 col-11 m-auto" data-aos="fade-right">
                <h1>ABOUT US</h1>
                <p>
                    <?php echo $settings['about'] ?>
                </p>
                <a href="story.php" class="btn bg-primary-main text-light rounded-pill d-inline-block main-button">read more <i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </section>
    <section class="computer-forms bg-light p-main" id="computer-forms">
        <div class="container">
            <h3 class="text-center fs-main text-primary-main">Computer forms. What Makes Them Unique</h3>
            <div class="row groups">
                <div class="col-lg-4 group text-center" data-aos="fade-down">
                    <img src="images/groups/1.svg" width="60" height="70.077" class="img-fluid" alt="icon">
                    <p class="mb-0 mt-3">40,000+</p>
                    <p class="mb-0">Customer</p>
                </div>
                <div class="col-lg-4 group text-center" data-aos="fade-down">
                    <img src="images/groups/2.svg" width="60" height="70.077" class="img-fluid" alt="icon">
                    <p class="mb-0 mt-3">400+</p>
                    <p class="mb-0">Products</p>
                </div>
                <div class="col-lg-4 group text-center" data-aos="fade-down">
                    <img src="images/groups/3.svg" width="60" height="70.077" class="img-fluid" alt="icon">
                    <p class="mb-0 mt-3">30+</p>
                    <p class="mb-0">Nationalities</p>
                </div>
                <div class="col-lg-4 group text-center" data-aos="fade-down">
                    <img src="images/groups/4.svg" width="60" height="70.077" class="img-fluid" alt="icon">
                    <p class="mb-0 mt-3">innovation
                        <br> & creativity</p>
                </div>
                <div class="col-lg-4 group text-center" data-aos="fade-down">
                    <img src="images/groups/5.svg" width="60" height="70.077" class="img-fluid" alt="icon">
                    <p class="mb-0 mt-3">Customized
                        <br> Packaging</p>
                </div>
                <div class="col-lg-4 group text-center" data-aos="fade-down">
                    <img src="images/groups/6.svg" width="60" height="70.077" class="img-fluid" alt="icon">
                    <p class="mb-0 mt-3">Professional
                        <br> printing</p>
                </div>
            </div>
        </div>
    </section>
    <section class="services p-main">
        <h3 class="text-center fs-main">Services. Meet your custom packaging experts</h3>
        <div class="container">
            <div class="row cards mt-5">
                <?php 
                    $sql = 'SELECT * FROM services';
                    $result = mysqli_query($conn, $sql);
                    $services = mysqli_fetch_all($result, MYSQLI_ASSOC);
                ?>
                <?php if(empty($services)): ?>
                <?php elseif(!empty($services)): ?>
                <?php foreach($services as $index => $item): ?>
                    <div class="col-lg-4 service card border-0" data-aos="fade-right">
                        <div class="card-img-top rounded-0"><img src="../assets/uploads/services/<?php echo $item['image']?>" class="w-100 h-100" alt="card image"></div>
                        <div class="card-body p-0 pt-4">
                            <h5 class="card-title"><?php echo $item['title']?></h5>
                            <a href="quote.php#quote" class="d-flex justify-content-between text-primary-main align-items-center text-decoration-none">
                                <p class="mb-0 text-uppercase">contact us</p>
                                <i class="fa fa-arrow-right text-primary-main"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <section class="solutions-container p-main bg-primary-main">
        <div class="container">
            <h3 class="text-center fs-main text-white">ENDLESS SOLUTIONS FOR INDUSTRIES WE SERVE </h3>
            <div class="swiper solutions">
                <div class="swiper-wrapper mt-5">
                    <div class="swiper-slide solution text-center" data-aos="fade-down">
                        <img src="images/solutions/1.svg" alt="solution" width="80" height="80">
                        <p class="text-white fw-bold mt-3">Heathy Care</p>
                    </div>
                    <div class="swiper-slide solution text-center" data-aos="fade-down">
                        <img src="images/solutions/2.svg" alt="solution" width="80" height="80">
                        <p class="text-white fw-bold mt-3">Super Market</p>
                    </div>
                    <div class="swiper-slide solution text-center" data-aos="fade-down">
                        <img src="images/solutions/3.svg" alt="solution" width="80" height="80">
                        <p class="text-white fw-bold mt-3">Cosmetics Packaging</p>
                    </div>
                    <div class="swiper-slide solution text-center" data-aos="fade-down">
                        <img src="images/solutions/4.svg" alt="solution" width="80" height="80">
                        <p class="text-white fw-bold mt-3">Bakeries</p>
                    </div>
                    <div class="swiper-slide solution text-center" data-aos="fade-down">
                        <img src="images/solutions/5.svg" alt="solution" width="80" height="80">
                        <p class="text-white fw-bold mt-3">Catering Companies </p>
                    </div>
                    <div class="swiper-slide solution text-center" data-aos="fade-down">
                        <img src="images/solutions/6.svg" alt="solution" width="80" height="80">
                        <p class="text-white fw-bold mt-3">Bank</p>
                    </div>
                    <div class="swiper-slide solution text-center" data-aos="fade-down">
                        <img src="images/solutions/7.svg" alt="solution" width="80" height="80">
                        <p class="text-white fw-bold mt-3">Hotels</p>
                    </div>
                    <div class="swiper-slide solution text-center" data-aos="fade-down">
                        <img src="images/solutions/8.svg" alt="solution" width="80" height="80">
                        <p class="text-white fw-bold mt-3">Restaurants</p>
                    </div>
                    <div class="swiper-slide solution text-center" data-aos="fade-down">
                        <img src="images/solutions/9.svg" alt="solution" width="80" height="80">
                        <p class="text-white fw-bold mt-3">Travels</p>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination-solutions mt-5 text-center"></div>
        </div>
    </section>
    <section class="clients-section p-main">
        <div class="container">
            <h3 class="text-center fs-main">Our clients trust us.</h3>
            <div class="position-relative mt-5">
                <div class="swiper clients">
                    <div class="swiper-wrapper mt-5">
                        <?php 
                            $sql = 'SELECT * FROM clients';
                            $result = mysqli_query($conn, $sql);
                            $clients = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        ?>
                        <?php if(empty($clients)): ?>
                        <?php elseif(!empty($clients)): ?>
                        <?php foreach($clients as $index => $item): ?>
                            <div class="swiper-slide solution text-center" style="height: 100px;" data-aos="fade-down">
                                <img src="../assets/uploads/clients/<?php echo $item['image']?>" class="w-100 h-100 object-contain" alt="solution">
                            </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="swiper-button-next next-prev swiper-next-clients"></div>
                <div class="swiper-button-prev next-prev swiper-prev-clients"></div>
            </div>
            <!-- <div class="mt-5 text-center"><a href="clients.php" class="btn text-primary-main fw-bold border-primary-main rounded-pill d-inline-block main-button">see more <i class="fa fa-arrow-right"></i></a></div> -->
        </div>
    </section>
  
<?php include 'includes/footer.php' ?>