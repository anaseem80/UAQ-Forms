<?php include 'includes/header.php' ?>

<?php
// Assuming you have a database connection established ($conn)
$success = '';
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle the form submission

    // Check if a file is selected
    if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] == 0) {
        $logoFileName = $_FILES["logo"]["name"];
        $logoTmpName = $_FILES["logo"]["tmp_name"];
        
        // Move the uploaded file to the desired directory
        $uploadDirectory = "../assets/uploads/";
        move_uploaded_file($logoTmpName, $uploadDirectory . $logoFileName);

        // Update the database with the new logo filename
        $newLogoFileName = mysqli_real_escape_string($conn, $logoFileName);
        $updateSql = "UPDATE settings SET logo = '$newLogoFileName' WHERE id = 1";
        $updateResult = mysqli_query($conn, $updateSql);

        if ($updateResult) {
            $success = "Logo updated successfully!";
        } else {
            $error = "Error updating logo: " . mysqli_error($conn);
        }
    }

    // Check if 'about' content is submitted
    if (isset($_POST['about'])) {
        // Sanitize and escape the input to prevent SQL injection
        $newAbout = mysqli_real_escape_string($conn, $_POST['about']);

        // Update the database with the new 'about' content
        $updateSql = "UPDATE settings SET about = '$newAbout' WHERE id = 1";
        $updateResult = mysqli_query($conn, $updateSql);

        if ($updateResult) {
            $success = "About information updated successfully!";
        } else {
            $error = "Error updating about information: " . mysqli_error($conn);
        }
    }
}
// Fetch the current settings for initial display
$sql = 'SELECT * FROM settings WHERE id = 1';
$result = mysqli_query($conn, $sql);
$settings = mysqli_fetch_assoc($result);

// Close the database connection
mysqli_close($conn);
?>
    <link href='assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
	<link href='assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet'>

    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
                <div>
                    <h1>Settings</h1>
                    <p class="breadcrumbs"><span><a href="index.html">Home</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span>settings</p>
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
                            <?php if(!empty($error)): ?>
                                <div class="alert alert-error" role="alert">
                                <?php echo $error?>
                                </div>
                            <?php endif; ?>
                            <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about" type="button" role="tab" aria-controls="nav-about" aria-selected="true">About</button>
                                <button class="nav-link" id="nav-logo-tab" data-bs-toggle="tab" data-bs-target="#nav-logo" type="button" role="tab" aria-controls="nav-logo" aria-selected="true">Logo</button>
                            </div>
                            <div class="tab-content p-3 border bg-light" id="nav-tabContent">
                                <div class="tab-pane fade active show" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <textarea name="about" class="form-control" rows="20" placeholder="About..." required><?php echo $settings['about']?></textarea>
                                        <button type="submit" class="btn btn-primary d-block rounded-0 mt-3 ms-auto">Save changes</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="nav-logo" role="tabpanel" aria-labelledby="nav-logo-tab">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <input type="file" name="logo" class="form-control" required>
                                        <img src="../assets/uploads/<?php echo $settings['logo'] ?>" width="127" height="92" alt="logo" class="mt-3">
                                        <button type="submit" class="btn btn-primary d-block rounded-0 mt-3 ms-auto">Save changes</button>
                                    </form>
                                </div>
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
