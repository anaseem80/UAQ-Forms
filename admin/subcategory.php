<?php include 'includes/header.php' ?>



<?php
$success = '';
if (isset($_POST['deleteCategory'])) {
    $CategoryToDelete = $_POST['CategoryId'];


    $getImagesQuery = "SELECT image_path FROM images WHERE subcategory_id = '$CategoryToDelete'";
    $imageResult = mysqli_query($conn, $getImagesQuery);

    while ($imageRow = mysqli_fetch_assoc($imageResult)) {
        $imagePath = $imageRow['image_path'];
        if (file_exists("../assets/uploads/$imagePath")) {
            unlink("../assets/uploads/$imagePath");
        }
    }

    $deleteSubcategorySql = "DELETE FROM sub_categories WHERE id = '$CategoryToDelete'";
    $deleteImagesSql = "DELETE FROM images WHERE subcategory_id = '$CategoryToDelete'";

    if (mysqli_query($conn, $deleteSubcategorySql) && mysqli_query($conn, $deleteImagesSql)) {
        $success = 'Category and associated images have been deleted successfully';
    } else {
        echo "Error deleting category: " . mysqli_error($conn);
    }
}
if (isset($_POST["updateSubCategory"])) {
    $editSubCategoryId = $_POST["editSubCategoryId"];
    $title = $_POST["title"];
    $subtitle = $_POST["subtitle"];
    
    $category_id = isset($_POST["category_id"]) ? $_POST["category_id"] : null;
    
    $description = $_POST["description"];

    if (isset($_POST['deleteImages'])) {
        foreach ($_POST['deleteImages'] as $imageToDelete) {
            unlink($imageToDelete);

            $deleteImageQuery = "DELETE FROM images WHERE image_path = ?";
            $stmtDeleteImage = mysqli_prepare($conn, $deleteImageQuery);
            mysqli_stmt_bind_param($stmtDeleteImage, 's', $imageToDelete);

            if (!mysqli_stmt_execute($stmtDeleteImage)) {
                echo 'Error deleting image: ' . mysqli_stmt_error($stmtDeleteImage);
            }

            mysqli_stmt_close($stmtDeleteImage);
        }
    }

    if (isset($_FILES['image']) && is_array($_FILES['image']['name'])) {
        $cleanTitle = preg_replace('/[^a-zA-Z0-9]/', '_', $title);
        $uploadDir = "../assets/uploads/" . $cleanTitle . "/";

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true); 
        }

        $insertImageQuery = "INSERT INTO images (subcategory_id, image_path) VALUES (?, ?)";
        $stmtImage = mysqli_prepare($conn, $insertImageQuery);
        mysqli_stmt_bind_param($stmtImage, 'is', $editSubCategoryId, $image_path);

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
    }

    $updateSubcategoryQuery = "UPDATE sub_categories SET title=?, subtitle=?, category_id=?, description=? WHERE id=?";
    $stmtSubcategory = mysqli_prepare($conn, $updateSubcategoryQuery);
    mysqli_stmt_bind_param($stmtSubcategory, 'ssisi', $title, $subtitle, $category_id, $description, $editSubCategoryId);

    if (mysqli_stmt_execute($stmtSubcategory)) {

        $success = 'Sub category has been updated successfully';
    } else {
        $error_message = 'Error updating subcategory: ' . mysqli_stmt_error($stmtSubcategory);
    }

    mysqli_stmt_close($stmtSubcategory);
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
                     <p class="breadcrumbs"><span><a href="index.php">Home</a></span>
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
                                            <th>Category</th>
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
                                                    <td>
                                                        <?php foreach($categories as $index => $itemm): ?>
                                                            <?php echo $item['category_id'] == $itemm["id"] ? $itemm["name"] : ''?>
                                                        <?php endforeach; ?>
                                                    </td>
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
                                                    <td>
                                                        <div class="text-center d-flex justify-content-center">
                                                            <form method="post" action="">
                                                                <input type="hidden" name="CategoryId" value="<?php echo $item['id']; ?>">
                                                                <button type="submit" name="deleteCategory" class="btn-delete"><i class="fas fa-trash-alt text-danger"></i></button>
                                                            </form>
                                                            <button type="button" class="btn-edit ml-3" data-bs-toggle="modal" data-bs-target="#EditModal<?php echo $item['id']; ?>"><i class="fas fa-edit text-dark"></i></button>
                                                        </div>
                                                        <!-- Edit Modal for each row -->
                                                        <div class="modal fade" id="EditModal<?php echo $item['id']; ?>" tabindex="-1" aria-labelledby="EditSubCategoryLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form class="modal-content" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="EditSubCategoryLabel">Edit Sub Category</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row ec-vendor-uploads">
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label for="title">Title</label>
                                                                                    <input type="text" name="title" value="<?php echo $item['title']; ?>" class="form-control" placeholder="Enter title here" id="title">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="subtitle">Sub title</label>
                                                                                    <input type="text" name="subtitle" class="form-control" value="<?php echo $item['subtitle']; ?>" placeholder="Enter Sub title here" id="subtitle">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="category">Category</label>
                                                                                    <!-- Replace the options with actual categories retrieved from your database -->
                                                                                    <select name="category_id" class="form-control" id="category">
                                                                                        <option selected disabled>Please add category first</option>
                                                                                        <?php foreach($categories as $index => $itemm): ?>
                                                                                            <option value="<?php echo $itemm['id'];?>" <?php echo $item['category_id'] == $itemm["id"] ? 'selected' : ''?> ><?php echo $itemm['name'];?></option>
                                                                                        <?php endforeach; ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="description">Description</label>
                                                                                    <textarea name="description" class="form-control" placeholder="Enter description here"><?php echo $item['description']?></textarea>
                                                                                </div>
                                                                                <div class="ec-vendor-img-upload">
                                                                                    <div class="ec-vendor-main-img">
                                                                                        <div class="avatar-upload">
                                                                                            <label for="imageUpload">Image</label>
                                                                                            <div class="avatar-edit">
                                                                                                <input type='file' id='imageUpload' name='image[]' class='ec-image-upload' multiple accept='.png, .jpg, .jpeg'/>
                                                                                                <label for="imageUpload">
                                                                                                    <img src="assets/img/icons/edit.svg" class="svg_img header_svg" alt="edit" />
                                                                                                </label>
                                                                                            </div>
                                                                                            <div class="avatar-preview ec-preview">
                                                                                                <div class="imagePreview ec-div-preview flex-column">
                                                                                                    <?php
                                                                                                    // Existing images retrieved from the database
                                                                                                    $subcategory_id = $item['id'];
                                                                                                    $getImagesQuery = "SELECT image_path FROM images WHERE subcategory_id = $subcategory_id";
                                                                                                    $result = mysqli_query($conn, $getImagesQuery);

                                                                                                    if ($result && mysqli_num_rows($result) > 0) {
                                                                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                                                                            echo '<div class="existing-image">
                                                                                                                    <img class="ec-image-preview" src="' . $row['image_path'] . '" alt="existing" />
                                                                                                                    <input type="checkbox" class="mt-3" name="deleteImages[]" value="' . $row['image_path'] . '"> Delete
                                                                                                                </div>';
                                                                                                        }
                                                                                                    }
                                                                                                    ?>
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
                                                                        <input type="hidden" name="editSubCategoryId" id="editSubCategoryId" value="<?php echo $item['id'];?>">
                                                                        <button type="submit" name="updateSubCategory" class="btn btn-primary">Save changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
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
        <form class="modal-content" id="imageUploadForm" enctype="multipart/form-data">
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
                            <input type="text" name="subtitle" class="form-control" placeholder="Enter Sub title here" id="subtitle">
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
                <button type="submit" name="submit" class="btn btn-primary">Save changes <i class="fa fa-spinner fa-spin d-none"></i></button>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('imageUploadForm').addEventListener('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        $(".fa-spin").removeClass("d-none")
        fetch('php/subcategory.php', {
            method: 'POST',
            body: formData
        }).then(response => {
            return response.json();
        }).then(data => {

            if (data.success) {
                $(".fa-spin").addClass("d-none")
                setTimeout(() => {
                    window.location.reload()
                }, 500);
                alert('Sub category and images have been added successfully');
            } else {
        console.log(formData)

                // Check for the 'error_message' property in the response
                var errorMessage = data.error_message || 'An error occurred.';
                alert('Error: ' + errorMessage);
            }
        }).catch(error => {
            console.error('Error:', error);
        });
    });
});

</script>
<?php include 'includes/footer.php' ?>
<script src='assets/plugins/data-tables/jquery.datatables.min.js'></script>
<script src='assets/plugins/data-tables/datatables.bootstrap5.min.js'></script>
<script src='assets/plugins/data-tables/datatables.responsive.min.js'></script>
