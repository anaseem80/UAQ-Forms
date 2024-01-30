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

        $targetDir = "../assets/uploads/services/";
        $targetFilePath = $targetDir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);
    }

    if (empty($imageError)) {
        $sql = "INSERT INTO services (image, title) VALUES ('$image', '$title')";
        if (mysqli_query($conn, $sql)) {
            $success = 'Service has been addedd successfully';
        } else {
          echo 'Error: ' . mysqli_error($conn);
        }
    }
}


if (isset($_POST["updateservice"])) {
    $editserviceId = $_POST["editserviceId"];
    $title = $_POST['title'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        
        $uploadDir = "../assets/uploads/services/";
        $uploadFile = $uploadDir . basename($image);
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $updateserviceQuery = "UPDATE services SET title=?, image=? WHERE id=?";
            $stmtservice = mysqli_prepare($conn, $updateserviceQuery);
            
            mysqli_stmt_bind_param($stmtservice, 'ssi', $title, $image, $editserviceId);
            
            if (mysqli_stmt_execute($stmtservice)) {
                $success = 'service has been updated successfully';
            } else {
                $error_message = 'Error updating service: ' . mysqli_stmt_error($stmtservice);
            }
            
            mysqli_stmt_close($stmtservice);
        } else {
            $error_message = "Failed to upload the new image.";
        }
    } else {
        $updateserviceQuery = "UPDATE services SET title=? WHERE id=?";
        $stmtservice = mysqli_prepare($conn, $updateserviceQuery);
        mysqli_stmt_bind_param($stmtservice, 'si', $title, $editserviceId);

        if (mysqli_stmt_execute($stmtservice)) {
            $success = 'service has been updated successfully';
        } else {
            $error_message = 'Error updating service: ' . mysqli_stmt_error($stmtservice);
        }

        mysqli_stmt_close($stmtservice);
    }
}

?>

<?php
if (isset($_POST['deletService'])) {
    $serviceToDelete = $_POST['serviceId'];
    $success = '';
    $deleteSql = "DELETE FROM services WHERE id = '$serviceToDelete'";
    if (mysqli_query($conn, $deleteSql)) {
        $success = 'service has been deleted successfully';
    } else {
        echo "Error deleting service: " . mysqli_error($conn);
    }
}
?>

<?php 
    $sql = 'SELECT * FROM services';
    $result = mysqli_query($conn, $sql);
    $services = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

    <link href='assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
	<link href='assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet'>

    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
                <div>
                    <h1>Services</h1>
                     <p class="breadcrumbs"><span><a href="index.php">Home</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span>Services</p>
                </div>
                <div>
                    <a href="javascripit:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddImage"> Add service</a>
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
                                            <th>Image</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php if(empty($services)): ?>
                                            <?php elseif(!empty($services)): ?>
                                                <?php foreach($services as $index => $item): ?>
                                                <tr>
                                                    <td><?php echo $index +1 ?></td>
                                                    <td><?php echo $item['title']?></td>
                                                    <td><img class="tbl-thumb" src="../assets/uploads/services/<?php echo $item['image']?>" alt="Product Image" /></td>
                                                    <td>
                                                        <div class="text-center d-flex justify-content-center">
                                                            <form method="post" action="" onsubmit="deletService()">
                                                                <input type="hidden" name="serviceId" value="<?php echo $item['id']; ?>">
                                                                <button type="submit" name="deletService" class="btn-delete"><i class="fas fa-trash-alt text-danger"></i></button>
                                                            </form>
                                                            <button type="button" class="btn-edit ml-3" data-bs-toggle="modal" data-bs-target="#Editservice-<?php echo $item['id']; ?>"><i class="fas fa-edit text-dark"></i></button>
                                                        </div>
                                                        <div class="modal fade" id="Editservice-<?php echo $item['id']?>" tabindex="-1" aria-labelledby="EditserviceLabel-<?php echo $item['id']?>" aria-hidden="true">
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
                                                                                                    src="../assets/uploads/services/<?php echo $item['image']?>"
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
                                                                    <input type="hidden" name="editserviceId" id="editserviceId" value="<?php echo $item['id'];?>">
                                                                    <button type="submit" name="updateservice" class="btn btn-primary">Save changes</button>
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
