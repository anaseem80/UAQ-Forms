<?php include 'includes/header.php' ?>

<?php
$imageError = '';
$success = '';

// Form submit
if (isset($_POST['submit'])) {
    if (empty($_FILES['image']['name'])) {
        $imageError = 'Image is required';
    } else {
        $image = $_FILES['image']['name'];
        $name = $_POST['name'];
        $title = $_POST['title'];

        $targetDir = "../assets/uploads/";
        $targetFilePath = $targetDir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);

        $sql = "INSERT INTO categories (image, name, title) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $image, $name, $title);

        if (mysqli_stmt_execute($stmt)) {
            $success = 'Category has been added successfully';
        } else {
            $error_message = 'Error: ' . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    }
}

if (isset($_POST["updateCategory"])) {
    $editCategoryId = $_POST["editCategoryId"];
    $title = $_POST["title"];
    $name = $_POST["name"];
    
    // Check if a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        
        $uploadDir = "../assets/uploads/";
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        
        // Move the new image to the upload directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            // Update category information, including the new image
            $updateCategoryQuery = "UPDATE categories SET title=?, name=?, image=? WHERE id=?";
            $stmtCategory = mysqli_prepare($conn, $updateCategoryQuery);
            mysqli_stmt_bind_param($stmtCategory, 'sssi', $title, $name, $image, $editCategoryId);
            
            if (mysqli_stmt_execute($stmtCategory)) {
                $success = 'Category has been updated successfully';
            } else {
                $error_message = 'Error updating category: ' . mysqli_stmt_error($stmtCategory);
            }
            
            mysqli_stmt_close($stmtCategory);
        } else {
            $error_message = "Failed to upload the new image.";
        }
    } else {
        // Update category information without changing the image
        $updateCategoryQuery = "UPDATE categories SET title=?, name=? WHERE id=?";
        $stmtCategory = mysqli_prepare($conn, $updateCategoryQuery);
        mysqli_stmt_bind_param($stmtCategory, 'ssi', $title, $name, $editCategoryId);

        if (mysqli_stmt_execute($stmtCategory)) {
            $success = 'Category has been updated successfully';
        } else {
            $error_message = 'Error updating category: ' . mysqli_stmt_error($stmtCategory);
        }

        mysqli_stmt_close($stmtCategory);
    }
}
?>
<?php
if (isset($_POST['deleteCategory'])) {
    $CategoryToDelete = $_POST['CategoryId'];
    $success = '';
    $deleteSql = "DELETE FROM categories WHERE id = '$CategoryToDelete'";
    if (mysqli_query($conn, $deleteSql)) {
        $success = 'Category has been deleted successfully';
    } else {
        echo "Error deleting image: " . mysqli_error($conn);
    }
}
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
                    <h1>Categories</h1>
                    <p class="breadcrumbs"><span><a href="index.php">Home</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span>Categories</p>
                </div>
                <div>
                    <a href="javascripit:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddImage">Add Category</a>
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
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php if(empty($categories)): ?>
                                            <?php elseif(!empty($categories)): ?>
                                                <?php foreach($categories as $index => $item): ?>
                                                <tr>
                                                    <td><?php echo $index +1 ?></td>
                                                    <td><?php echo $item['name']?></td>
                                                    <td><?php echo $item['title']?></td>
                                                    <td><img class="tbl-thumb" src="../assets/uploads/<?php echo $item['image']?>" alt="Product Image" /></td>
                                                    <td>
                                                        <div class="text-center d-flex justify-content-center">
                                                            <form method="post" action="">
                                                                <input type="hidden" name="CategoryId" value="<?php echo $item['id']; ?>">
                                                                <button type="submit" name="deleteCategory" class="btn-delete"><i class="fas fa-trash-alt text-danger"></i></button>
                                                            </form>
                                                            <button type="button" class="btn-edit ml-3" data-bs-toggle="modal" data-bs-target="#EditModal<?php echo $item['id']; ?>"><i class="fas fa-edit text-dark"></i></button>
                                                        </div>
                                                        <div class="modal fade" id="EditModal<?php echo $item['id']; ?>" tabindex="-1" aria-labelledby="EditCategoryLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form class="modal-content" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="EditCategoryLabel">Edit Category</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row ec-vendor-uploads">
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label for="name">Title</label>
                                                                                    <input type="text" name="name" value="<?php echo $item['name']; ?>" class="form-control" placeholder="Enter title here" id="title">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="title">Description</label>
                                                                                    <textarea name="title" class="form-control" placeholder="Enter description here"><?php echo $item['title']?></textarea>
                                                                                </div>
                                                                                <div class="ec-vendor-img-upload">
                                                                                    <div class="ec-vendor-main-img">
                                                                                        <div class="avatar-upload">
                                                                                            <label for="imageUpload">Image</label>
                                                                                            <div class="avatar-edit">
                                                                                                <input type='file' id='imageUpload' name='image' class='ec-image-upload' accept='.png, .jpg, .jpeg'/>
                                                                                                <label for="imageUpload">
                                                                                                    <img src="assets/img/icons/edit.svg" class="svg_img header_svg" alt="edit" />
                                                                                                </label>
                                                                                            </div>
                                                                                            <div class="avatar-preview ec-preview">
                                                                                                <div class="imagePreview ec-div-preview flex-column">
                                                                                                    <div class="existing-image">
                                                                                                        <img class="ec-image-preview" src="../assets/uploads/<?php echo $item['image']?>" alt="existing" />
                                                                                                    </div>
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
                                                                        <input type="hidden" name="editCategoryId" id="editCategoryId" value="<?php echo $item['id'];?>">
                                                                        <button type="submit" name="updateCategory" class="btn btn-primary">Save changes</button>
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
        <form class="modal-content" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
        <div class="modal-header">
            <h5 class="modal-title" id="AddImageLabel">Add Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row ec-vendor-uploads">
                <div class="col-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter title here" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Description</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter title here" id="title" required>
                    </div>
                    <div class="ec-vendor-img-upload">
                        <div class="ec-vendor-main-img">
                            <div class="avatar-upload">
                            <label for="imageUpload">Image</label>
                                <div class="avatar-edit">
                                    <input type='file' id="imageUpload" name="image" class="ec-image-upload"
                                        accept=".png, .jpg, .jpeg" required/>
                                    <label for="imageUpload"><img
                                            src="assets/img/icons/edit.svg"
                                            class="svg_img header_svg" alt="edit" /></label>
                                </div>
                                <div class="avatar-preview ec-preview">
                                    <div class="imagePreview ec-div-preview">
                                        <img class="ec-image-preview"
                                            src="assets/img/products/vender-upload-preview.jpg"
                                            alt="edit" />
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
