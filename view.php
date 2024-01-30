<?php 
$title = "Expertise";

include 'includes/header.php';
?>

<?php 
if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];
    $sql = "SELECT * FROM sub_categories WHERE id = '$categoryId'";
    $result = mysqli_query($conn, $sql);
    $sub_category = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(empty($sub_category)){
        header("Location: expertise.php");
    }
}else {
    header("Location: expertise.php");
}
  
?>
<?php 
if (isset($_GET['id'])) {
    $catId = $sub_category[0]['category_id'];
    $sql = "SELECT * FROM categories WHERE id = '$catId'";
    $result = mysqli_query($conn, $sql);
    $category = mysqli_fetch_all($result, MYSQLI_ASSOC);
}else {
    header("Location: expertise.php");
}
  


?>

<?php
$imagesPerPage = 6;

if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];

    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

    $offset = ($current_page - 1) * $imagesPerPage;

    $getImagesQuery = "SELECT * FROM images WHERE subcategory_id = $categoryId LIMIT $offset, $imagesPerPage";
    $result = mysqli_query($conn, $getImagesQuery);
    $images = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $totalImagesQuery = "SELECT COUNT(*) as total FROM images WHERE subcategory_id = $categoryId";
    $totalImagesResult = mysqli_query($conn, $totalImagesQuery);
    $totalImages = mysqli_fetch_assoc($totalImagesResult)['total'];

    $totalPages = ceil($totalImages / $imagesPerPage);
}
?>

    <div class="breadcrumb header-top text-center justify-content-center flex-column position-relative" style="background-image: var(--Gradient-Colors-G_14, linear-gradient(90deg, #48C6EF 0%, #6F86D6 100%))">
        <h1 class="text-light" data-aos="fade-up">Print <span>Expertise</span></h1>
        <div class="box bg-white p-5 d-inline-block m-auto" data-aos="fade-right">
            <h1><?php echo $sub_category[0]['title']?></h1>
            <h5>Home / Expertise / <?php echo $category[0]['name']?> / <?php echo $sub_category[0]['title']?></h5>
        </div>
    </div>

    <main class="solutions-page main-content-page p-main mt-5">
        <div class="container">
            <div class="text-center" data-aos="fade-down">
                <h2 class="text-color-black"><?php echo $sub_category[0]['subtitle']?></h2>
                <p class="col-lg-10 col-12 m-auto mt-4">
                <?php echo $sub_category[0]['description']?>
                </p>
            </div>
            <div class="row">
            <?php if(empty($images)): ?>
                <?php elseif(!empty($images)): ?>
                <?php foreach($images as $index => $item): ?>
                    <div class="col-lg-6 my-4">
                        <a data-fslightbox="gallery" href="<?php echo $item['image_path']?>"><img src="<?php echo $item['image_path']?>" class="w-100 object-cover" width="550" height="550" alt="gallery image"></a>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>

            </div>
            <?php if (!empty($images)): ?>
            <div class="pagination d-flex justify-content-center mt-5 flex-wrap">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?id=<?php echo $categoryId; ?>&page=<?php echo $i; ?>" class="page-item border-primary-main rounded-circle text-center text-decoration-none <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($current_page < $totalPages): ?>
                    <a href="?id=<?php echo $categoryId; ?>&page=<?php echo $current_page + 1; ?>" class="page-item border-primary-main rounded-circle text-center text-decoration-none">
                        <i class="fa fa-arrow-right"></i>
                    </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </main>

<?php include 'includes/footer.php' ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.0.9/index.js" integrity="sha512-2VqLVM3WCyaqUgQb2hpoWHSus021RIN0Jq0wfrLqqLh+anm1kW/H4Yw7HVu3D5W4nbdUQmAA2mqQv2JEoy+kPA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
