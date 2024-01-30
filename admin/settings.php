<?php include 'includes/header.php' ?>

<?php
$success = '';
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] == 0) {
        $logoFileName = $_FILES["logo"]["name"];
        $logoTmpName = $_FILES["logo"]["tmp_name"];
        $uploadDirectory = "../assets/uploads/";
        move_uploaded_file($logoTmpName, $uploadDirectory . $logoFileName);

        $newLogoFileName = mysqli_real_escape_string($conn, $logoFileName);
        $updateSql = "UPDATE settings SET logo = '$newLogoFileName' WHERE id = 1";
        $updateResult = mysqli_query($conn, $updateSql);

        if ($updateResult) {
            $success = "Logo updated successfully!";
        } else {
            $error = "Error updating logo: " . mysqli_error($conn);
        }
    }

    if (isset($_POST['about'])) {
        $newAbout = mysqli_real_escape_string($conn, $_POST['about']);

        $updateSql = "UPDATE settings SET about = '$newAbout' WHERE id = 1";
        $updateResult = mysqli_query($conn, $updateSql);

        if ($updateResult) {
            $success = "About information updated successfully!";
        } else {
            $error = "Error updating about information: " . mysqli_error($conn);
        }
    }
    
    if (isset($_POST['footer_about'])) {
        $newfooter_about = mysqli_real_escape_string($conn, $_POST['footer_about']);

        $updateSql = "UPDATE settings SET footer_about = '$newfooter_about' WHERE id = 1";
        $updateResult = mysqli_query($conn, $updateSql);

        if ($updateResult) {
            $success = "footer_about information updated successfully!";
        } else {
            $error = "Error updating footer_about information: " . mysqli_error($conn);
        }
    }

    if (isset($_POST['whatsapp'])) {
        $whatsapp = mysqli_real_escape_string($conn, $_POST['whatsapp']);

        $updateSql = "UPDATE settings SET whatsapp = '$whatsapp' WHERE id = 1";
        $updateResult = mysqli_query($conn, $updateSql);

        if ($updateResult) {
            $success = "Social links information updated successfully!";
        } else {
            $error = "Error updating social links information: " . mysqli_error($conn);
        }
    }
    if (isset($_POST['facebook'])) {
        $facebook = mysqli_real_escape_string($conn, $_POST['facebook']);

        $updateSql = "UPDATE settings SET facebook = '$facebook' WHERE id = 1";
        $updateResult = mysqli_query($conn, $updateSql);

        if ($updateResult) {
            $success = "Social links information updated successfully!";
        } else {
            $error = "Error updating social links information: " . mysqli_error($conn);
        }
    }
    if (isset($_POST['instagram'])) {
        $instagram = mysqli_real_escape_string($conn, $_POST['instagram']);

        $updateSql = "UPDATE settings SET instagram = '$instagram' WHERE id = 1";
        $updateResult = mysqli_query($conn, $updateSql);

        if ($updateResult) {
            $success = "Social links information updated successfully!";
        } else {
            $error = "Error updating social links information: " . mysqli_error($conn);
        }
    }
    if (isset($_POST['threads'])) {
        $threads = mysqli_real_escape_string($conn, $_POST['threads']);

        $updateSql = "UPDATE settings SET threads = '$threads' WHERE id = 1";
        $updateResult = mysqli_query($conn, $updateSql);

        if ($updateResult) {
            $success = "Social links information updated successfully!";
        } else {
            $error = "Error updating social links information: " . mysqli_error($conn);
        }
    }
}
$sql = 'SELECT * FROM settings WHERE id = 1';
$result = mysqli_query($conn, $sql);
$settings = mysqli_fetch_assoc($result);

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
                     <p class="breadcrumbs"><span><a href="index.php">Home</a></span>
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
                                <button class="nav-link" id="nav-social-tab" data-bs-toggle="tab" data-bs-target="#nav-social" type="button" role="tab" aria-controls="nav-social" aria-selected="true">Social Links</button>
                            </div>
                            <div class="tab-content p-3 border bg-light" id="nav-tabContent">
                                <div class="tab-pane fade active show" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="about">About</label>
                                            <textarea name="about" id="about" class="form-control" rows="20" placeholder="About..." required><?php echo $settings['about']?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="footer_about">Footer about</label>
                                            <textarea name="footer_about" id="footer_about" class="form-control" rows="20" placeholder="Footer about..." required><?php echo $settings['footer_about']?></textarea>
                                        </div>
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
                                <div class="tab-pane fade" id="nav-social" role="tabpanel" aria-labelledby="nav-social-tab">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <label for="whatsapp">Whatsapp</label>
                                                <input type="text" class="form-control border" name="whatsapp" id="whatsapp" value="<?php echo $settings['whatsapp'] ?>" required/>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label for="facebook">Facebook</label>
                                                <input type="url" class="form-control border" name="facebook" id="facebook" value="<?php echo $settings['facebook'] ?>"/>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label for="instagram">Instagram</label>
                                                <input type="url" class="form-control border" name="instagram" id="instagram" value="<?php echo $settings['instagram'] ?>"/>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label for="threads">Threads</label>
                                                <input type="url" class="form-control border" name="threads" id="threads" value="<?php echo $settings['threads'] ?>"/>
                                            </div>
                                        </div>
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
