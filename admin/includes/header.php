<?php include '../config/db.php'?>
<?php 
session_start();
$sql = 'SELECT * FROM settings WHERE id = 1';
$result = mysqli_query($conn, $sql);
$settings = mysqli_fetch_assoc($result);

if(!isset($_SESSION['email'])){
	header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Ekka - Admin Dashboard eCommerce HTML Template.">

	<title>Uaq Forms - Admin</title>

	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet"> 

	<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />

	<!-- PLUGINS CSS STYLE -->
	<link href="assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet">
	<link href="assets/plugins/simplebar/simplebar.css" rel="stylesheet" />

	<!-- Ekka CSS -->
	<link id="ekka-css" href="assets/css/ekka.css" rel="stylesheet" />

	<!-- FAVICON -->
	<link href="../assets/uploads/<?php echo $settings['logo'] ?>"  rel="shortcut icon" />
    <script src="https://kit.fontawesome.com/5488d9796f.js" crossorigin="anonymous"></script>
</head>

<body class="ec-header-fixed ec-sidebar-fixed ec-sidebar-dark ec-header-light" id="body">
<div class="wrapper">
	
	<?php include 'includes/sidebar.php' ?>
    <!--  PAGE WRAPPER -->
	<div class="ec-page-wrapper">

        <?php include 'includes/topbar.php' ?>