<?php
include '../../config/db.php';
if ($_SERVER['REQUEST_METHOD']) {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $subtitle = $_POST['subtitle'];

    if (isset($_FILES['image']) && is_array($_FILES['image']['name'])) {
        $cleanTitle = preg_replace('/[^a-zA-Z0-9]/', '_', $title);
        $uploadDir = "../../assets/uploads/" . $cleanTitle . "/";

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true); 
        }

        $insertSubcategoryQuery = "INSERT INTO sub_categories (category_id, title, description, subtitle) VALUES (?, ?, ?, ?)";
        $stmtSubcategory = mysqli_prepare($conn, $insertSubcategoryQuery);
        mysqli_stmt_bind_param($stmtSubcategory, 'isss', $category_id, $title, $description, $subtitle);

        if (mysqli_stmt_execute($stmtSubcategory)) {
            $subcategory_id = mysqli_insert_id($conn);

            $insertImageQuery = "INSERT INTO images (subcategory_id, image_path) VALUES (?, ?)";
            $stmtImage = mysqli_prepare($conn, $insertImageQuery);
            mysqli_stmt_bind_param($stmtImage, 'is', $subcategory_id, $image_path);

            for ($i = 0; $i < count($_FILES['image']['name']); $i++) {
                $uploadFile = $uploadDir . basename($_FILES['image']['name'][$i]);

                if (move_uploaded_file($_FILES['image']['tmp_name'][$i], $uploadFile)) {
                    $image_path = $uploadFile;

                    if (!mysqli_stmt_execute($stmtImage)) {
                        echo json_encode(['success' => false, 'error_message' => 'Error: ' . mysqli_stmt_error($stmtImage)]);
                        exit;
                    }
                } else {
                    echo json_encode(['success' => false, 'error_message' => 'Failed to upload one or more images.']);
                    exit;
                }
            }

            mysqli_stmt_close($stmtImage);

            echo json_encode(['success' => true]);
            exit;
        } else {
            echo json_encode(['success' => false, 'error_message' => 'Error: ' . mysqli_stmt_error($stmtSubcategory)]);
            exit;
        }

        mysqli_stmt_close($stmtSubcategory);
    } else {
        echo json_encode(['success' => false, 'error_message' => 'Please select at least one image.']);
        exit;
    }
} else {
    // Provide a default response if the 'submit' parameter is not set
    echo json_encode(['success' => false, 'error_message' => 'Invalid request.']);
    exit;
}
?>
