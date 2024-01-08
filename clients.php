<?php include 'includes/header.php' ?>


    <div class="breadcrumb header-top text-center justify-content-center flex-column position-relative">
        <h1 class="text-light" data-aos="fade-up">list of <span>the clients</span></h1>
        <div class="box bg-white p-5 d-inline-block m-auto position-absolute" data-aos="fade-right">
            <h1>Quote</h1>
            <h5>Home / Our Clients</h5>
        </div>
    </div>

    <main class="solutions-page main-content-page p-main pb-0 mt-5">
        <div class="container">
            <div class="text-center" data-aos="fade-down">
                <h2 class="text-color-black">List of the clinents </h2>
                <p class="col-lg-8 col-12 m-auto mt-4">Here is a list of the clients we work with every day. They are the wind beneath our wings, 
and the reason we strive for excellence every single day.</p>
            </div>
            <div class="row">
                <div class="clients">
                    <?php 
                            $sql = 'SELECT * FROM gallery';
                            $result = mysqli_query($conn, $sql);
                            $gallery = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        ?>
                        <?php if(empty($gallery)): ?>
                        <?php elseif(!empty($gallery)): ?>
                        <?php foreach($gallery as $index => $item): ?>
                            <div class="client text-center">
                                <img src="../assets/uploads/<?php echo $item['image']?>" alt="client" width="152" height="36" class="img-fluid">
                            </div>
                        <?php endforeach; ?>
                        <?php endif; ?>

                </div>
            </div>
        </div>
    </main>

<?php include 'includes/footer.php' ?>