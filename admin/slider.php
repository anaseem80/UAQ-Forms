<?php include 'includes/header.php' ?>

<?php
// Set vars to empty values
$imageError = '';
$success = '';

if (isset($_POST['submit'])) {
    if (empty($_FILES['image']['name'])) {
        $imageError = 'Image is required';
    } else {
        $image = $_FILES['image']['name'];
        $title = $_POST['title'];
        $title2 = $_POST['title2'];
        $color = $_POST['color'];

        $targetDir = "../assets/uploads/sliders/";
        $targetFilePath = $targetDir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);
    }

    if (empty($imageError)) {
        $sql = "INSERT INTO sliders (image, title, title2, color) VALUES ('$image', '$title', '$title2', '$color')";
        if (mysqli_query($conn, $sql)) {
            $success = 'Slider has been addedd successfully';
        } else {
          echo 'Error: ' . mysqli_error($conn);
        }
    }
}


if (isset($_POST["updateSlider"])) {
    $editSliderId = $_POST["editSliderId"];
    $title = $_POST['title'];
    $title2 = $_POST['title2'];
    $color = $_POST['color'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        
        $uploadDir = "../assets/uploads/sliders/";
        $uploadFile = $uploadDir . basename($image);
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $updateSliderQuery = "UPDATE sliders SET title=?, title2=?, color=?, image=? WHERE id=?";
            $stmtSlider = mysqli_prepare($conn, $updateSliderQuery);
            
            mysqli_stmt_bind_param($stmtSlider, 'ssssi', $title, $title2, $color, $image, $editSliderId);
            
            if (mysqli_stmt_execute($stmtSlider)) {
                $success = 'Slider has been updated successfully';
            } else {
                $error_message = 'Error updating Slider: ' . mysqli_stmt_error($stmtSlider);
            }
            
            mysqli_stmt_close($stmtSlider);
        } else {
            $error_message = "Failed to upload the new image.";
        }
    } else {
        $updateSliderQuery = "UPDATE sliders SET title=?, title2=?, color=? WHERE id=?";
        $stmtSlider = mysqli_prepare($conn, $updateSliderQuery);
        mysqli_stmt_bind_param($stmtSlider, 'sssi', $title, $title2, $color, $editSliderId);

        if (mysqli_stmt_execute($stmtSlider)) {
            $success = 'Slider has been updated successfully';
        } else {
            $error_message = 'Error updating Slider: ' . mysqli_stmt_error($stmtSlider);
        }

        mysqli_stmt_close($stmtSlider);
    }
}

?>

<?php
if (isset($_POST['deletSlider'])) {
    $sliderToDelete = $_POST['sliderId'];
    $success = '';
    $deleteSql = "DELETE FROM sliders WHERE id = '$sliderToDelete'";
    if (mysqli_query($conn, $deleteSql)) {
        $success = 'Slider has been deleted successfully';
    } else {
        echo "Error deleting slider: " . mysqli_error($conn);
    }
}
?>

<?php 
    $sql = 'SELECT * FROM sliders';
    $result = mysqli_query($conn, $sql);
    $sliders = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

    <link href='assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
	<link href='assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet'>

    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
                <div>
                    <h1>Sliders</h1>
                     <p class="breadcrumbs"><span><a href="index.php">Home</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span>Sliders</p>
                </div>
                <div>
                    <a href="javascripit:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddImage"> Add Slider</a>
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
                                            <th>Color</th>
                                            <th>Image</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php if(empty($sliders)): ?>#8DD8D4
                                            <?php elseif(!empty($sliders)): ?>
                                                <?php foreach($sliders as $index => $item): ?>
                                                <tr>
                                                    <td><?php echo $index +1 ?></td>
                                                    <td><?php echo $item['title']?></td>
                                                    <td><?php echo $item['title2']?></td>
                                                    <td>
                                                        <span style="background-color:<?php echo $item['color']?>; height:30px; width:30px" class="rounded-circle d-block"></span>
                                                    </td>
                                                    <td><img class="tbl-thumb" src="../assets/uploads/sliders/<?php echo $item['image']?>" alt="Product Image" /></td>
                                                    <td>
                                                        <div class="text-center d-flex justify-content-center">
                                                            <form method="post" action="" onsubmit="deletSlider()">
                                                                <input type="hidden" name="sliderId" value="<?php echo $item['id']; ?>">
                                                                <button type="submit" name="deletSlider" class="btn-delete"><i class="fas fa-trash-alt text-danger"></i></button>
                                                            </form>
                                                            <button type="button" class="btn-edit ml-3" data-bs-toggle="modal" data-bs-target="#EditSlider-<?php echo $item['id']; ?>"><i class="fas fa-edit text-dark"></i></button>
                                                        </div>
                                                        <div class="modal fade" id="EditSlider-<?php echo $item['id']?>" tabindex="-1" aria-labelledby="EditSliderLabel-<?php echo $item['id']?>" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form class="modal-content" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="AddImageLabel">Add Image</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row ec-vendor-uploads">
                                                                        <div class="form-group">
                                                                            <label for="title">Title</label>
                                                                            <input type="text" name="title" class="form-control" value="<?php echo $item['title']?>" placeholder="Enter title here" id="title" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="title2">Title 2</label>
                                                                            <input type="text" name="title2" class="form-control" value="<?php echo $item['title2']?>" placeholder="Enter title here" id="title2" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="color">Color</label>
                                                                            <input type="color" name="color" class="form-control" value="<?php echo $item['color']?>" placeholder="Enter title here" id="color" required>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="ec-vendor-img-upload">
                                                                                <div class="ec-vendor-main-img">
                                                                                    <div class="avatar-upload">
                                                                                        <div class="avatar-edit">
                                                                                            <input type='file' id="imageUpload" name="image" class="ec-image-upload"
                                                                                                accept=".png, .jpg, .jpeg"/>
                                                                                            <label for="imageUpload"><img
                                                                                                    src="assets/img/icons/edit.svg"
                                                                                                    class="svg_img header_svg" alt="edit" /></label>
                                                                                        </div>
                                                                                        <div class="avatar-preview ec-preview">
                                                                                            <div class="imagePreview ec-div-preview">
                                                                                                <img class="ec-image-preview"
                                                                                                    src="../assets/uploads/sliders/<?php echo $item['image']?>"
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
                                                                    <input type="hidden" name="editSliderId" id="editSliderId" value="<?php echo $item['id'];?>">
                                                                    <button type="submit" name="updateSlider" class="btn btn-primary">Save changes</button>
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
            <h5 class="modal-title" id="AddImageLabel">Add Image</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row ec-vendor-uploads">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter title here" id="title" required>
                </div>
                <div class="form-group">
                    <label for="title2">Title 2</label>
                    <input type="text" name="title2" class="form-control" placeholder="Enter title here" id="title2" required>
                </div>
                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="color" name="color" class="form-control" placeholder="Enter title here" id="color" required>
                </div>
                <div class="col-12">
                    <div class="ec-vendor-img-upload">
                        <div class="ec-vendor-main-img">
                            <div class="avatar-upload">
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
<script>
    function deleteImage(){
        event.preventDefault();
        console.log("deleted")
    }
</script>
<script src='assets/plugins/data-tables/jquery.datatables.min.js'></script>
<script src='assets/plugins/data-tables/datatables.bootstrap5.min.js'></script>
<script src='assets/plugins/data-tables/datatables.responsive.min.js'></script>
