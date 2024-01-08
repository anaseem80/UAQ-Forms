<?php include 'includes/header.php' ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Retrieve form data
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $subtitle = $_POST['subtitle'];

    // Handle image upload
    if (isset($_FILES['image']) && is_array($_FILES['image']['name'])) {
        $uploadDir = "../assets/uploads/";

        // Use a prepared statement for the main query
        $insertSubcategoryQuery = "INSERT INTO sub_categories (category_id, title, description, subtitle) VALUES (?, ?, ?, ?)";
        $stmtSubcategory = mysqli_prepare($conn, $insertSubcategoryQuery);
        mysqli_stmt_bind_param($stmtSubcategory, 'isss', $category_id, $title, $description, $subtitle);

        if (mysqli_stmt_execute($stmtSubcategory)) {
            $subcategory_id = mysqli_insert_id($conn);

            // Use a prepared statement for the image query
            $insertImageQuery = "INSERT INTO images (subcategory_id, image_path) VALUES (?, ?)";
            $stmtImage = mysqli_prepare($conn, $insertImageQuery);
            mysqli_stmt_bind_param($stmtImage, 'is', $subcategory_id, $image_path);

            for ($i = 0; $i < count($_FILES['image']['name']); $i++) {
                $uploadFile = $uploadDir . basename($_FILES['image']['name'][$i]);

                if (move_uploaded_file($_FILES['image']['tmp_name'][$i], $uploadFile)) {
                    $image_path = $uploadFile;

                    // Execute the image query
                    if (!mysqli_stmt_execute($stmtImage)) {
                        echo 'Error: ' . mysqli_stmt_error($stmtImage);
                    }
                } else {
                    $error_message = "Failed to upload one or more images.";
                }
            }

            mysqli_stmt_close($stmtImage);

            $success = 'Sub category and images have been added successfully';
        } else {
            echo 'Error: ' . mysqli_stmt_error($stmtSubcategory);
        }

        mysqli_stmt_close($stmtSubcategory);
    } else {
        $error_message = "Please select at least one image.";
    }
}
?>

<?php
if (isset($_POST['deleteCategory'])) {
    $CategoryToDelete = $_POST['CategoryId'];
    $success = '';

    // Fetch image paths associated with the subcategory
    $getImagesQuery = "SELECT image_path FROM images WHERE subcategory_id = '$CategoryToDelete'";
    $imageResult = mysqli_query($conn, $getImagesQuery);

    // Delete images from the file system and the database
    while ($imageRow = mysqli_fetch_assoc($imageResult)) {
        $imagePath = $imageRow['image_path'];
        // Remove the image file from the file system
        if (file_exists("../assets/uploads/$imagePath")) {
            unlink("../assets/uploads/$imagePath");
        }
    }

    // Delete the subcategory and associated images from the database
    $deleteSubcategorySql = "DELETE FROM sub_categories WHERE id = '$CategoryToDelete'";
    $deleteImagesSql = "DELETE FROM images WHERE subcategory_id = '$CategoryToDelete'";

    if (mysqli_query($conn, $deleteSubcategorySql) && mysqli_query($conn, $deleteImagesSql)) {
        $success = 'Category and associated images have been deleted successfully';
    } else {
        echo "Error deleting category: " . mysqli_error($conn);
    }
}
?>

<?php 
    $sql = 'SELECT * FROM sub_categories';
    $result = mysqli_query($conn, $sql);
    $sub_categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<?php 
    $sql = 'SELECT * FROM categories';
    $result = mysqli_query($conn, $sql);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

    <link href='assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
	<link href='assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet'>

    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
                <div>
                    <h1>Sub Categories</h1>
                    <p class="breadcrumbs"><span><a href="index.html">Home</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span>Sub Categories</p>
                </div>
                <div>
                    <a href="javascripit:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddImage">Add Sub Category</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-body">
                            <?php if(!empty($success)): ?>
                                <div class="alert alert-success" role="alert">
                                <?php echo $success?>
                                </div>
                            <?php endif; ?>
                            <div class="table-responsive">
                                <table id="responsive-data-table" class="table"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Sub Title</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php if(empty($sub_categories)): ?>
                                            <?php elseif(!empty($sub_categories)): ?>
                                                <?php foreach($sub_categories as $index => $item): ?>
                                                <tr>
                                                    <td><?php echo $index +1 ?></td>
                                                    <td><?php echo $item['title']?></td>
                                                    <td><?php echo $item['subtitle']?></td>
                                                    <td><?php echo $item['description']?></td>
                                                    <td>
                                                        <?php
                                                        $subcategory_id = $item['id'];
                                                        $getImagesQuery = "SELECT image_path FROM images WHERE subcategory_id = $subcategory_id";
                                                        $result = mysqli_query($conn, $getImagesQuery);

                                                        if ($result && mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                echo '<img class="tbl-thumb" src="' . $row['image_path'] . '" alt="Product Image" />';
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <form method="post" action="">
                                                            <input type="hidden" name="CategoryId" value="<?php echo $item['id']; ?>">
                                                            <button type="submit" name="deleteCategory" class="btn-delete"><i class="fas fa-trash-alt text-danger"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Content -->
    </div> <!-- End Content Wrapper -->

    <div class="modal fade" id="AddImage" tabindex="-1" aria-labelledby="AddImageLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="AddImageLabel">Add Sub Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row ec-vendor-uploads">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter title here" id="title" required>
                        </div>
                        <div class="form-group">
                            <label for="subtitle">Sub title</label>
                            <input type="text" name="subtitle" class="form-control" placeholder="Enter Sub title here" id="subtitle" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <!-- Replace the options with actual categories retrieved from your database -->
                            <select name="category_id" class="form-control" id="category" required>
                                <?php if(empty($categories)): ?>
                                    <option selected disabled>Please add category first</option>
                                    <?php elseif(!empty($categories)): ?>
                                    <?php foreach($categories as $index => $item): ?>
                                            <option value="<?php echo $item['id']?>"><?php echo $item['name']?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" placeholder="Enter description here"></textarea>
                        </div>
                        <div class="ec-vendor-img-upload">
                            <div class="ec-vendor-main-img">
                                <div class="avatar-upload">
                                    <label for="imageUpload">Image</label>
                                    <div class="avatar-edit">
                                        <input type='file' id='imageUpload' name='image[]' class='ec-image-upload' multiple accept='.png, .jpg, .jpeg' required/>
                                        <label for="imageUpload">
                                            <img src="assets/img/icons/edit.svg" class="svg_img header_svg" alt="edit" />
                                        </label>
                                    </div>
                                    <div class="avatar-preview ec-preview">
                                        <div class="imagePreview ec-div-preview">
                                            <img class="ec-image-preview" src="assets/img/products/vender-upload-preview.jpg" alt="edit" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php' ?>
<script src='assets/plugins/data-tables/jquery.datatables.min.js'></script>
<script src='assets/plugins/data-tables/datatables.bootstrap5.min.js'></script>
<script src='assets/plugins/data-tables/datatables.responsive.min.js'></script>
