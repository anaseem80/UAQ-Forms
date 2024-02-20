<?php 
$title = "Gallery";
include 'includes/header.php';
?>
<?php 
$itemsPerPage = 36;

$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

$offset = ($current_page - 1) * $itemsPerPage;

$sql = "SELECT * FROM gallery ORDER BY `order` ASC LIMIT $offset, $itemsPerPage";
$result = mysqli_query($conn, $sql);
$gallery = mysqli_fetch_all($result, MYSQLI_ASSOC);

$countSql = "SELECT COUNT(*) as total FROM gallery";
$countResult = mysqli_query($conn, $countSql);
$countData = mysqli_fetch_assoc($countResult);
$totalRecords = $countData['total'];

$totalPages = ceil($totalRecords / $itemsPerPage);
?>
<style>
    img{
        pointer-events: unset !important;
    }
</style>
    <div class="breadcrumb header-top text-center justify-content-center flex-column position-relative">
        <h1 class="text-light" data-aos-duration="100" data-aos="fade-up">INSPIRATION <span>GALLERY</span></h1>
        <div class="box bg-white p-5 d-inline-block m-auto" data-aos-duration="100" data-aos="fade-right">
            <h1>Gallery</h1>
            <h5>Home / Gallery</h5>
        </div>
    </div>
    <main class="gallery-page main-content-page p-main mt-5">
        <div class="container">
        <div class="row">
            <?php if (!empty($gallery)): ?>
                <?php foreach($gallery as $index => $item): ?>
                    <div class="col-lg-3 mb-4" data-aos-duration="100" data-aos="fade-down">
                        <a href="quote.php#quote">
                            <img src="assets/uploads/gallery/<?php echo $item['image']?>" class="w-100 object-cover" width="280" height="280" alt="gallery image">
                        </a>
                        <!-- <a data-fslightbox="gallery" href="assets/uploads/gallery/<?php echo $item['image']?>">
                            <img src="assets/uploads/gallery/<?php echo $item['image']?>" class="w-100 object-cover" width="280" height="280" alt="gallery image">
                        </a> -->
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