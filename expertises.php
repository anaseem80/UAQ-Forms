<?php 
$title = "Expertises";
include 'includes/header.php';
?>

<?php 
    $itemsPerPage = 6;

    $current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

    $offset = ($current_page - 1) * $itemsPerPage;

    $sql = "SELECT * FROM categories LIMIT $offset, $itemsPerPage";
    $result = mysqli_query($conn, $sql);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $countSql = "SELECT COUNT(*) as total FROM categories";
    $countResult = mysqli_query($conn, $countSql);
    $countData = mysqli_fetch_assoc($countResult);
    $totalRecords = $countData['total'];

    $totalPages = ceil($totalRecords / $itemsPerPage);

?>
    <div class="breadcrumb header-top text-center justify-content-center flex-column position-relative" style="background-image: var(--Gradient-Colors-G_14, linear-gradient(90deg, #48C6EF 0%, #6F86D6 100%))">
        <h1 class="text-light" data-aos="fade-up">Print <span>Expertise</span></h1>
        <div class="box bg-white p-5 d-inline-block m-auto" data-aos="fade-right">
            <h1>Expertise</h1>
            <h5>Home / Expertise</h5>
        </div>
    </div>

    <main class="solutions-page main-content-page p-main mt-5">
        <div class="container">
            <div class="text-center" data-aos="fade-down">
                <h2 class="text-color-black"> Meet your custom packaging experts</h2>
                <p class="col-lg-10 col-12 m-auto mt-4">
                    Our production capabilities range from the simplest letterhead or business card through continuous stationery for computer systems, Brochures and marketing material to security documents with holograms and unbreakable design codes.
                </p>
            </div>
            <div class="expertises">
            <?php if(empty($categories)): ?>
                <?php elseif(!empty($categories)): ?>
                <?php foreach($categories as $index => $item): ?>
                    <div class="expertise">
                    <a href="expertise.php?id=<?php echo $item['id']?>"> <img src="../assets/uploads/<?php echo $item['image']?>" class="img-fluid w-100" alt="expertise"></a>
                    <div class="d-flex justify-content-between mt-4 align-items-center">
                        <div>
                            <a href="expertise.php?id=<?php echo $item['id']?>" class="text-decoration-none"><h3><?php echo $item['name']?></h3></a>
                            <a href="expertise.php?id=<?php echo $item['id']?>" class="text-decoration-none position-relative custom-link d-block">See More</a>
                        </div>
                        <div><a href="expertise.php?id=<?php echo $item['id']?>" class="arrow"><img src="images/expertise/arrow.svg" width="70" height="70" alt="arrow"></a></div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php if (!empty($categories)): ?>
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
    </main>

<?php include 'includes/footer.php' ?>