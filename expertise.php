<?php 
$title = "Expertise";
include 'includes/header.php';

?>

<?php 


if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];

    $itemsPerPage = 8;

    $current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

    $offset = ($current_page - 1) * $itemsPerPage;

    $sql = "SELECT * FROM sub_categories WHERE category_id = '$categoryId' LIMIT $offset, $itemsPerPage";
    $result = mysqli_query($conn, $sql);
    $sub_categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $countSql = "SELECT COUNT(*) as total FROM categories";
    $countResult = mysqli_query($conn, $countSql);
    $countData = mysqli_fetch_assoc($countResult);
    $totalRecords = $countData['total'];

    $totalPages = ceil($totalRecords / $itemsPerPage);

    if(empty($sub_categories)){
        header("Location: expertises.php");
    }


}else {
    header("Location: expertises.php");
}
  
?>
<?php 
if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];
    $sql = "SELECT * FROM categories WHERE id = '$categoryId'";
    $result = mysqli_query($conn, $sql);
    $category = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(empty($sub_categories)){
        header("Location: expertises.php");
    }
}else {
    header("Location: expertises.php");
}

?>
<style>
    p{
        text-align: center !important;
    }
</style>
    <div class="breadcrumb header-top text-center justify-content-center flex-column position-relative">
        <h1 class="text-light" data-aos-duration="100" data-aos="fade-up">Print <span>Expertise</span></h1>
        <div class="box bg-white p-5 d-inline-block m-auto" data-aos-duration="100" data-aos="fade-right">
            <h1><?php echo $category[0]['name']?></h1>
            <h5>Home / Expertise / <?php echo $category[0]['name']?></h5>
        </div>
    </div>

    <main class="solutions-page main-content-page p-main mt-5">
        <div class="container">
            <div class="text-center mb-5" data-aos-duration="100" data-aos="fade-down">
                <h2 class="text-color-black"><?php echo $category[0]['title']?></h2>
            </div>
            <div class="expertises mt-5">
            <?php if(empty($sub_categories)): ?>
                
                <?php elseif(!empty($sub_categories)): ?>
                <?php foreach($sub_categories as $index => $item): ?>
                <a href="view.php?id=<?php echo $item['id']?>" class="expertise text-decoration-none">
                    <?php
                        $subcategory_id = $item['id'];
                        $getImagesQuery = "SELECT image_path FROM images WHERE subcategory_id = $subcategory_id";
                        $result = mysqli_query($conn, $getImagesQuery);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            echo '<img class="img-fluid w-100" src="' . $row['image_path'] . '" alt="Product Image"/>';
                        }
                    ?>
                    <div class="d-flex justify-content-between mt-4 align-items-center">
                        <div>
                            <h3><?php echo $item['title']?></h3>
                            <p class="text-decoration-none my-2 position-relative custom-link d-block text-start">See More</p>
                        </div>
                        <div><p class="arrow"><img src="images/expertise/arrow.svg" width="70" height="70" alt="arrow"></p></div>
                    </div>
                    </a>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php if (!empty($sub_categories)): ?>
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