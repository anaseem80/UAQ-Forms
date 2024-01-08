<?php include 'includes/header.php' ?>
<?php 
if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];
    $sql = "SELECT * FROM sub_categories WHERE category_id = '$categoryId'";
    $result = mysqli_query($conn, $sql);
    $sub_categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
}else {

}
  
?>
<?php 
if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];
    $sql = "SELECT * FROM categories WHERE id = '$categoryId'";
    $result = mysqli_query($conn, $sql);
    $category = mysqli_fetch_all($result, MYSQLI_ASSOC);
}else {

}
  
?>
    <div class="breadcrumb header-top text-center justify-content-center flex-column position-relative" style="background-image: var(--Gradient-Colors-G_14, linear-gradient(90deg, #48C6EF 0%, #6F86D6 100%))">
        <h1 class="text-light" data-aos="fade-up">Print <span>Expertise</span></h1>
        <div class="box bg-white p-5 d-inline-block m-auto position-absolute" data-aos="fade-right">
            <h1><?php echo $category[0]['name']?></h1>
            <h5>Home / Expertise / <?php echo $category[0]['name']?></h5>
        </div>
    </div>

    <main class="solutions-page main-content-page p-main mt-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-down">
                <h2 class="text-color-black"><?php echo $category[0]['title']?></h2>
            </div>
            <div class="expertises mt-5">
            <?php if(empty($sub_categories)): ?>
                <?php elseif(!empty($sub_categories)): ?>
                <?php foreach($sub_categories as $index => $item): ?>
                    <div class="expertise">
                    <?php
                        $subcategory_id = $item['id'];
                        $getImagesQuery = "SELECT image_path FROM images WHERE subcategory_id = $subcategory_id";
                        $result = mysqli_query($conn, $getImagesQuery);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            echo '<a href="view.php?id=' . $item['id'] . '"><img class="img-fluid w-100" src="' . $row['image_path'] . '" alt="Product Image"/></a>';
                        }
                    ?>
                    <!-- <a href="view.php?id=<?php echo $item['id']?>"> <img src="<?php echo $item['image']?>" class="img-fluid w-100" alt="expertise"></a> -->
                    <div class="d-flex justify-content-between mt-4 align-items-center">
                        <div>
                            <a href="view.php?id=<?php echo $item['id']?>" class="text-decoration-none"><h3><?php echo $item['title']?></h3></a>
                            <a href="view.php?id=<?php echo $item['id']?>" class="text-decoration-none position-relative custom-link d-block">See More</a>
                        </div>
                        <div><a href="view.php?id=<?php echo $item['id']?>" class="arrow"><img src="images/expertise/arrow.svg" width="70" height="70" alt="arrow"></a></div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

<?php include 'includes/footer.php' ?>