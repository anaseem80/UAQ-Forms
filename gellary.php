<?php include 'includes/header.php' ?>
<?php 
// Number of items per page
$itemsPerPage = 4;

// Get the current page number from the URL, default to 1
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Calculate the offset for the query based on the current page
$offset = ($current_page - 1) * $itemsPerPage;

// Fetch a specific range of records based on the current page
$sql = "SELECT * FROM gallery LIMIT $offset, $itemsPerPage";
$result = mysqli_query($conn, $sql);
$gallery = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Query to get the total count of all records
$countSql = "SELECT COUNT(*) as total FROM gallery";
$countResult = mysqli_query($conn, $countSql);
$countData = mysqli_fetch_assoc($countResult);
$totalRecords = $countData['total'];

// Calculate the total number of pages
$totalPages = ceil($totalRecords / $itemsPerPage);
?>
    <div class="breadcrumb header-top text-center justify-content-center flex-column position-relative" style="background: var(--Gradient-Colors-G_09, linear-gradient(90deg, #3D4E81 0%, #5753C9 48%, #6E7FF3 100%));">
        <h1 class="text-light" data-aos="fade-up">INSPIRATION <span>GALLERY</span></h1>
        <div class="box bg-white p-5 d-inline-block m-auto position-absolute" data-aos="fade-right">
            <h1>Gallery</h1>
            <h5>Home / Gallery</h5>
        </div>
    </div>
    <main class="gallery-page main-content-page p-main mt-5">
        <div class="container">
        <div class="row">
            <?php if (!empty($gallery)): ?>
                <?php foreach($gallery as $index => $item): ?>
                    <div class="col-lg-3 mb-4" data-aos="fade-down">
                        <a data-fslightbox="gallery" href="assets/uploads/<?php echo $item['image']?>">
                            <img src="assets/uploads/<?php echo $item['image']?>" class="w-100 object-cover" width="280" height="280" alt="gallery image">
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-lg-12 text-center">
                    <h4>No items found on this page.</h4>
                </div>
            <?php endif; ?>
        </div>
        <?php if (!empty($gallery)): ?>
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.0.9/index.js" integrity="sha512-2VqLVM3WCyaqUgQb2hpoWHSus021RIN0Jq0wfrLqqLh+anm1kW/H4Yw7HVu3D5W4nbdUQmAA2mqQv2JEoy+kPA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php include 'includes/footer.php' ?>