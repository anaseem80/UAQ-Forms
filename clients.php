<?php 
$title = "Clients";
include 'includes/header.php';
?>


    <div class="breadcrumb header-top text-center justify-content-center flex-column position-relative">
        <h1 class="text-light" data-aos="fade-up">list of <span>the clients</span></h1>
        <div class="box bg-white p-5 d-inline-block m-auto" data-aos="fade-right">
            <h1>Clients</h1>
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
                            $itemsPerPage = 15;

                            $current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

                            $offset = ($current_page - 1) * $itemsPerPage;
                            $sql = "SELECT * FROM clients LIMIT $offset, $itemsPerPage";
                            $result = mysqli_query($conn, $sql);
                            $clients = mysqli_fetch_all($result, MYSQLI_ASSOC);

                            $countSql = "SELECT COUNT(*) as total FROM clients";
                            $countResult = mysqli_query($conn, $countSql);
                            $countData = mysqli_fetch_assoc($countResult);
                            $totalRecords = $countData['total'];

                            // Calculate the total number of pages
                            $totalPages = ceil($totalRecords / $itemsPerPage);
                        ?>
                        <?php if(empty($clients)): ?>
                        <?php elseif(!empty($clients)): ?>
                        <?php foreach($clients as $index => $item): ?>
                            <div class="client text-center">
                                <img src="../assets/uploads/clients/<?php echo $item['image']?>" alt="client" width="152" height="36" class="img-fluid">
                            </div>
                        <?php endforeach; ?>
                        <?php endif; ?>

                </div>
                <?php if (!empty($clients)): ?>
                    <div class="pagination d-flex justify-content-center mt-5 flex-wrap">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>" class="page-item border-primary-main rounded-circle text-center text-decoration-none <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($current_page < $totalPages): ?>
                            <a href="?page=<?php echo $current_page + 1; ?>" class="page-item border-primary-main rounded-circle text-center text-decoration-none">
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

<?php include 'includes/footer.php' ?>