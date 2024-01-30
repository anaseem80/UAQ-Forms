<?php include 'includes/header.php' ?>

<?php
$imageError = '';
$success = '';

// $folderPath = "../assets/uploads/gallery/";

// $files = glob($folderPath . "*.png");

// foreach ($files as $order => $file) {
//     $filename = basename($file);

//     // Insert data into the 'gallery' table
//     $sql = "INSERT INTO gallery (image, `order`) VALUES ('$filename', $order)";

//     if ($conn->query($sql) === TRUE) {
//         echo "Record for $filename inserted successfully.<br>";
//     } else {
//         echo "Error inserting record: " . $conn->error . "<br>";
//     }
// }



if (isset($_POST["updateImage"])) {
    $editImageId = $_POST["editImageId"];
    $newOrder = $_POST["order"];

    if (!is_numeric($newOrder)) {
        $error_message = "Order must be a number.";
    } else {
        
        $currentOrderQuery = "SELECT `order` FROM gallery WHERE id=?";
        $stmtCurrentOrder = mysqli_prepare($conn, $currentOrderQuery);
        mysqli_stmt_bind_param($stmtCurrentOrder, 'i', $editImageId);
        mysqli_stmt_execute($stmtCurrentOrder);
        $currentOrderResult = mysqli_stmt_get_result($stmtCurrentOrder);
        $currentOrderRow = mysqli_fetch_assoc($currentOrderResult);
        $currentOrder = $currentOrderRow['order'];
        mysqli_stmt_close($stmtCurrentOrder);

        $checkOrderQuery = "SELECT id FROM gallery WHERE `order`=? AND id != ?";
        $stmtCheckOrder = mysqli_prepare($conn, $checkOrderQuery);
        mysqli_stmt_bind_param($stmtCheckOrder, 'ii', $newOrder, $editImageId);
        mysqli_stmt_execute($stmtCheckOrder);
        $checkOrderResult = mysqli_stmt_get_result($stmtCheckOrder);
        $orderExists = mysqli_fetch_assoc($checkOrderResult);
        mysqli_stmt_close($stmtCheckOrder);

        if ($orderExists) {
            $updateOrderQuery = "UPDATE gallery SET `order`=? WHERE id=?";
            $stmtUpdateOrder = mysqli_prepare($conn, $updateOrderQuery);
            mysqli_stmt_bind_param($stmtUpdateOrder, 'ii', $newOrder, $editImageId);
            mysqli_stmt_execute($stmtUpdateOrder);
            mysqli_stmt_close($stmtUpdateOrder);

            $updateOtherOrderQuery = "UPDATE gallery SET `order`=? WHERE id=?";
            $stmtUpdateOtherOrder = mysqli_prepare($conn, $updateOtherOrderQuery);
            mysqli_stmt_bind_param($stmtUpdateOtherOrder, 'ii', $currentOrder, $orderExists['id']);
            mysqli_stmt_execute($stmtUpdateOtherOrder);
            mysqli_stmt_close($stmtUpdateOtherOrder);

            $success = 'Order values have been swapped successfully';
        } else {
             $updateOrderQuery = "UPDATE gallery SET `order`=? WHERE id=?";
             $stmtUpdateOrder = mysqli_prepare($conn, $updateOrderQuery);
             mysqli_stmt_bind_param($stmtUpdateOrder, 'ii', $newOrder, $editImageId);
             mysqli_stmt_execute($stmtUpdateOrder);
             mysqli_stmt_close($stmtUpdateOrder);
 
             $success = 'Order has been updated successfully';
        }
    }
}


if (isset($_POST['submit'])) {

    if (empty($_FILES['image']['name'])) {
        $imageError = 'Image is required';
    } else {
        $image = $_FILES['image']['name'];

        $targetDir = "../assets/uploads/gallery/";
        $targetFilePath = $targetDir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);
    }

    if (empty($imageError)) {
        $sql = "INSERT INTO gallery (image) VALUES ('$image')";
        if (mysqli_query($conn, $sql)) {
            $success = 'Image has been addedd successfully';
        } else {
          echo 'Error: ' . mysqli_error($conn);
        }
    }
}
?>

<?php
if (isset($_POST['deleteImage'])) {
    $imageIdToDelete = $_POST['imageId'];
    $success = '';
    $deleteSql = "DELETE FROM gallery WHERE id = '$imageIdToDelete'";
    if (mysqli_query($conn, $deleteSql)) {
        $success = 'Image has been deleted successfully';
    } else {
        echo "Error deleting image: " . mysqli_error($conn);
    }
}
?>

<?php 
    $sql = 'SELECT * FROM gallery ORDER BY `order` ASC';
    $result = mysqli_query($conn, $sql);
    $gallery = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // foreach ($gallery as $record) {
    //     $id = $record['id'];
    //     $order = $record['order'];

    //     $updateSql = "UPDATE gallery SET `order` = $id WHERE id = $id";
    //     if (mysqli_query($conn, $updateSql)) {
    //         $success = 'Image has been deleted successfully';
    //     } else {
    //         echo "Error deleting image: " . mysqli_error($conn);
    //     }
    //     // echo "ID: $id, Order: $order<br>";
    // }
?>

    <link href='assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
	<link href='assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet'>

    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
                <div>
                    <h1>Gallery</h1>
                     <p class="breadcrumbs"><span><a href="index.php">Home</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span>Gallery</p>
                </div>
                <div>
                    <a href="javascripit:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddImage"> Add Image</a>
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
                                            <th>Image</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php if(empty($gallery)): ?>
                                            <?php elseif(!empty($gallery)): ?>
                                                <?php foreach($gallery as $index => $item): ?>
                                                <tr>
                                                    <td><?php echo $item['order']; ?></td>
                                                    <td><img class="tbl-thumb" src="../assets/uploads/gallery/<?php echo $item['image']?>" alt="Product Image" /></td>
                                                    <td>
                                                        <div class="text-center d-flex justify-content-center">
                                                            <form method="post" action="" onsubmit="deleteImage()">
                                                                <input type="hidden" name="imageId" value="<?php echo $item['id']; ?>">
                                                                <button type="submit" name="deleteImage" class="btn-delete"><i class="fas fa-trash-alt text-danger"></i></button>
                                                            </form>
                                                            <button type="button" class="btn-edit ml-3" data-bs-toggle="modal" data-bs-target="#EditModal<?php echo $item['id']; ?>"><i class="fas fa-edit text-dark"></i></button>
                                                        </div>
                                                        <div class="modal fade" id="EditModal<?php echo $item['id']; ?>" tabindex="-1" aria-labelledby="EditCategoryLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form class="modal-content" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="EditCategoryLabel">Edit Image</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row ec-vendor-uploads">
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label for="name">Order</label>
                                                                                    <input type="text" name="order" value="<?php echo $item['order']; ?>" class="form-control" placeholder="0" id="title">
                                                                                </div>
                                                                                <div class="ec-vendor-img-upload">
                                                                                    <div class="ec-vendor-main-img">
                                                                                        <div class="avatar-upload">
                                                                                            <div class="avatar-edit">
                                                                                                <input type='file' id='imageUpload' name='image' class='ec-image-upload' accept='.png, .jpg, .jpeg'/>
                                                                                                <label for="imageUpload">
                                                                                                    <img src="assets/img/icons/edit.svg" class="svg_img header_svg" alt="edit" />
                                                                                                </label>
                                                                                            </div>
                                                                                            <div class="avatar-preview ec-preview">
                                                                                                <div class="imagePreview ec-div-preview flex-column">
                                                                                                    <div class="existing-image">
                                                                                                        <img class="ec-image-preview" src="../assets/uploads/gallery/<?php echo $item['image']?>" alt="existing" />
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
                                                                        <input type="hidden" name="editImageId" id="editImageId" value="<?php echo $item['id'];?>">
                                                                        <button type="submit" name="updateImage" class="btn btn-primary">Save changes</button>
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
