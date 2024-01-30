<?php 
    include '../../config/db.php';
    
    session_start();

    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $enteredPassword = $_POST['password'];
        
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
    
        if ($row) {
            if (password_verify($enteredPassword, $row['password'])) {
                $_SESSION['email'] = $email;
                header("Location: ../index.php");
                exit();
            } else {
                echo "Invalid username or password";
            }
        } else {
            echo "Invalid username or password";
        }
    }
?>