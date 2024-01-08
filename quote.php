<?php include 'includes/header.php' ?>
<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Collect form data
    $name = $_POST['name'];
    $company = $_POST['company'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $category = $_POST['category'];
    $message = $_POST['message'];

    // Insert data into the 'quote' table
    $insertSql = "INSERT INTO quote (name, company, email, phone, category, message) VALUES ('$name', '$company', '$email', '$phone', '$category', '$message')";

    if (mysqli_query($conn, $insertSql)) {
        // Insertion successful
        // header("Location: quote.php#quote");
        $successMessage = 'Thanks for reaching out with us, We will be in touch with you soon!';
    } else {
        // Error in insertion
        $errorMessage = "Error submitting form: " . mysqli_error($conn);
    }
}
?>
<?php 
    $sql = 'SELECT * FROM categories';
    $result = mysqli_query($conn, $sql);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
    <div class="breadcrumb header-top text-center justify-content-center flex-column position-relative">
        <h1 class="text-light" data-aos="fade-up">Online <span>Quote</span></h1>
        <div class="box bg-white p-5 d-inline-block m-auto position-absolute" data-aos="fade-right">
            <h1>Quote</h1>
            <h5>Home / Quote</h5>
        </div>
    </div>

    <main class="solutions-page main-content-page p-main pb-0 mt-5">
        <div class="container">
            <div class="text-center" data-aos="fade-down">
                <h2 class="text-color-black">Get a Quote for Your requirements</h2>
                <p class="col-lg-8 col-12 m-auto mt-4">Tell us about your requirements and we’ll get back to you with a quote.</p>
            </div>
        </div>
        <div class="cta p-xl-0 p-4">
            <div class="container">
                <div class="row mb-0">
                    <div class="col-xl-6 col-md-12 text-light rhs" data-aos="fade-down">
                        <h1>Get a Quote for Your requirements</h1>
                        <p class="text-light">Tell us about your requirements and we’ll get back
                            to you with a quote.</p>
                        <button class="btn btn-light rounded-0 py-2 px-3">GET STARTED</button>
                    </div>
                    <div class="col-xl-6 col-md-12 d-xl-block d-none"><img src="images/cta.png" class="img-fluid h-100 object-cover" alt="cta"></div>
                </div>
            </div>
        </div>

        <form action="" method="POST" id="quote" class="form p-main">
            <div class="container">
                <div class="row quote">
                    <div class="col-lg-12 mb-3">
                    <?php if (isset($successMessage)): ?>
                        <div class="alert border-0 alert-success" role="alert">
                            <?php echo $successMessage; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($errorMessage)): ?>
                        <div class="alert border-0 alert-danger" role="alert">
                            <?php echo $errorMessage; ?>
                        </div>
                    <?php endif; ?>
                    </div>
                    <div class="col-lg-6 mt-lg-0 mt-5 form-group">
                        <input type="text" class="border-bottom border-0 pb-2 w-100 outline-none" name="name" placeholder="Name" required>
                    </div>
                    <div class="col-lg-6 mt-lg-0 mt-5 form-group">
                        <input type="text" class="border-bottom border-0 pb-2 w-100 outline-none" name="company" placeholder="Company">
                    </div>
                    <div class="col-lg-6 mt-5 form-group">
                        <input type="email" class="border-bottom border-0 pb-2 w-100 outline-none" name="email" placeholder="Email" required>
                    </div>
                    <div class="col-lg-6 mt-5 form-group">
                        <input type="tel" class="border-bottom border-0 pb-2 w-100 outline-none" name="phone" placeholder="Phone Number" required>
                    </div>
                    <div class="col-lg-12 mt-5 form-group">
                        <select name="category" class="border-bottom border-0 pb-2 w-100 outline-none" id="category" required>
                        <option selected disabled>Select Category</option>
                            <?php if(empty($categories)): ?>
                                <?php elseif(!empty($categories)): ?>
                                <?php foreach($categories as $index => $item): ?>
                                        <option value="<?php echo $item['id']?>"><?php echo $item['name']?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-lg-12 mt-5 form-group">
                        <textarea type="tel" class="border-bottom border-0 pb-2 w-100 outline-none" rows="7" name="message" placeholder="Message" required></textarea>
                    </div>
                    <div class="col-lg-12 mt-0 form-group">
                        <button href="#" name="submit" type="submit" class="btn bg-primary-main text-light w-100 d-inline-block main-button">Send Now <i class="fa fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </main>

<?php include 'includes/footer.php' ?>