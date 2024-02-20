<?php include 'includes/header.php' ?>

<?php
$imageError = '';
$success = '';

// Form submit
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $question_title = $_POST['question_title'];
    $sub_title = $_POST['sub_title'];
    $description = $_POST['description'];


    $sql = "INSERT INTO faq (title, question_title, sub_title, description) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssss', $title, $question_title, $sub_title, $description);

    if (mysqli_stmt_execute($stmt)) {
        $success = 'FAQ has been added successfully';
    } else {
        $error_message = 'Error: ' . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}

if (isset($_POST["updateFAQ"])) {
    $editFAQId = $_POST["editFAQId"];
    $title = $_POST["title"];
    $question_title = $_POST["question_title"];
    $sub_title = $_POST['sub_title'];
    $description = $_POST["description"];
    
    $updateFAQQuery = "UPDATE faq SET title=?, question_title=?, description=?, sub_title=? WHERE id=?";
    $stmtCategory = mysqli_prepare($conn, $updateFAQQuery);
    mysqli_stmt_bind_param($stmtCategory, 'ssssi', $title, $question_title, $description, $sub_title, $editFAQId);
    
    if (mysqli_stmt_execute($stmtCategory)) {
        $success = 'FAQ has been updated successfully';
    } else {
        $error_message = 'Error updating category: ' . mysqli_stmt_error($stmtCategory);
    }
    
    mysqli_stmt_close($stmtCategory);
        
    
}
?>
<?php
if (isset($_POST['deleteFAQ'])) {
    $faqToDelete = $_POST['faqId'];
    $success = '';
    $deleteSql = "DELETE FROM faq WHERE id = '$faqToDelete'";
    if (mysqli_query($conn, $deleteSql)) {
        $success = 'faq has been deleted successfully';
    } else {
        echo "Error deleting image: " . mysqli_error($conn);
    }
}
?>

<?php 
    $sql = 'SELECT * FROM faq';
    $result = mysqli_query($conn, $sql);
    $faq = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

    <link href='assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
	<link href='assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet'>

    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
                <div>
                    <h1>FAQ</h1>
                    <p class="breadcrumbs"><span><a href="index.php">Home</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span>FAQ</p>
                </div>
                <div>
                    <a href="javascripit:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddImage">Add FAQ</a>
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
                                            <th>Question Title</th>
                                            <th>Sub title</th>
                                            <th>Description</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php if(empty($faq)): ?>
                                            <?php elseif(!empty($faq)): ?>
                                                <?php foreach($faq as $index => $item): ?>
                                                <tr>
                                                    <td><?php echo $index +1 ?></td>
                                                    <td><?php echo $item['title']?></td>
                                                    <td><?php echo $item['question_title']?></td>
                                                    <td><?php echo $item['sub_title']?></td>
                                                    <td><?php echo $item['description']?></td>
                                                    <td>
                                                        <div class="text-center d-flex justify-content-center">
                                                            <form method="post" action="">
                                                                <input type="hidden" name="faqId" value="<?php echo $item['id']; ?>">
                                                                <button type="submit" name="deleteFAQ" class="btn-delete"><i class="fas fa-trash-alt text-danger"></i></button>
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
                                                                                <input type="text" name="title" class="form-control" value="<?php echo $item['title']; ?>" placeholder="Enter title here" id="title" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="question_title">Question Title</label>
                                                                                <input type="text" name="question_title" class="form-control" value="<?php echo $item['question_title']; ?>" placeholder="Enter Question title here" id="question_title" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="question_title">Sub title</label>
                                                                                <input type="text" name="sub_title" class="form-control" value="<?php echo $item['sub_title']; ?>" placeholder="Enter Question title here" id="sub_title" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="description">Description</label>
                                                                                <input type="text" name="description" class="form-control" value="<?php echo $item['description']; ?>" placeholder="Enter description here" id="description">
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <input type="hidden" name="editFAQId" id="editFAQId" value="<?php echo $item['id'];?>">
                                                                        <button type="submit" name="updateFAQ" class="btn btn-primary">Save changes</button>
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
            <h5 class="modal-title" id="AddImageLabel">Add FAQ</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row ec-vendor-uploads">
                <div class="col-12">
                    <div class="form-group">
                        <label for="name">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter title here" id="title" required>
                    </div>
                    <div class="form-group">
                        <label for="question_title">Question Title</label>
                        <input type="text" name="question_title" class="form-control" placeholder="Enter Question title here" id="question_title" required>
                    </div>
                    <div class="form-group">
                        <label for="question_title">Sub title</label>
                        <input type="text" name="sub_title" class="form-control" placeholder="Enter Question title here" id="sub_title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" name="description" class="form-control" placeholder="Enter description here" id="description">
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
