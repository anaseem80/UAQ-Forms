<?php 
include './config/db.php';
$sql = 'SELECT * FROM settings WHERE id = 1';
$result = mysqli_query($conn, $sql);
$settings = mysqli_fetch_assoc($result);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="shortcut icon" href="../assets/uploads/<?php echo $settings['logo'] ?>" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>UAQ Forms - <?php echo $title; ?></title>
</head>
<body>
    <div class="fixed-bottom whatsapp-icon"><a href="https://wa.me/<?php echo $settings['whatsapp'] ?>" target="_blank"><img src="../images/whatsapp.svg" width="60" height="60" alt="whatsapp"></a></div>
    <div class="progress-wrap">
		<svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
			<path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
		</svg>
	</div>
    <nav class="navbar navbar-expand-xl navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/"><img src="../assets/uploads/<?php echo $settings['logo'] ?>" alt="logo" width="68" height="49"></a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav m-auto mb-2 mb-lg-0 mt-lg-0 mt-3">
                <li class="nav-item"><a class="nav-link" aria-current="page" href="index.php">Home</a> </li>
                <li class="nav-item"><a class="nav-link" aria-current="page" href="expertises.php">Expertise</a> </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" aria-current="page" href="javascript:void(0)" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">Solutions</a> 
                    <ul class="dropdown-menu animate slideIn border-0 shadow-sm rounded-0 p-0" aria-labelledby="dropdownMenuButton1">
                        <li><a href="consultation.php" class="dropdown-item py-3 px-5 text-center">Consultation</a></li>
                        <li><a href="collaboration.php" class="dropdown-item py-3 px-5 text-center">Collaboration</a></li>
                        <li><a href="quality.php" class="dropdown-item py-3 px-5 text-center">Quality Assurance</a></li>
                        <li><a href="sustainability.php" class="dropdown-item py-3 px-5 text-center">Sustainability</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" aria-current="page" href="gallery.php">Gallery</a> </li>
                <li class="nav-item"><a class="nav-link" aria-current="page" href="quote.php">Get Quote</a> </li>
                <li class="nav-item"><a class="nav-link" aria-current="page" href="contact-us.php">Contact us</a> </li>
            </ul>
            </div>
        </div>
    </nav>