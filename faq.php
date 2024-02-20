<?php 
$title = "Sustainability";
include 'includes/header.php';
?>
<?php 
    $sql = 'SELECT * FROM faq';
    $result = mysqli_query($conn, $sql);
    $faq = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<style>
    .faq h3{
        font-weight: 600;
        font-size: 24px;
        color: #101828;
    }
    .faq h2{
        font-size: 22px;
    }
    .faq p, ol li{
        font-size: 20px;
        color: #414141;
    }
    .faq ol li:not(:last-child){
        margin-bottom: 12px;
    }
    .faq{
        border-bottom: 1px solid #EAECF0;
        padding-bottom: 15px;
    }
    .collapse-container img{
        cursor: pointer;
        pointer-events: unset !important;
    }
    .faq-content{
        max-height: 52px;
        transition: max-height 0.15s ease-out;
        overflow: hidden;
        margin-bottom: 15px;
    }
    .solutions-page .container > div{
        margin-bottom: 20px;
    }
    @media(max-width:992px){
        .faq-content{
           max-height: 75px;
           margin-bottom: unset;
           gap: 10px;
        }
        .faq .faq-content:not(:last-child){
            margin-bottom: 25px;
        }
        .faq h2{
            font-size: 20px;
        }
        .faq h3{
            font-size: 18px;
        }
        .faq p, ol li{
            font-size: 16px;
        }
    }
</style>
    <div class="breadcrumb header-top text-center justify-content-center flex-column position-relative">
        <h2 class="text-light" data-aos-duration="100" data-aos="fade-up">Our <span>Solutions</span></h1>
        <div class="box bg-white p-5 d-inline-block m-auto" data-aos-duration="100" data-aos="fade-right">
            <h1>FAQ</h1>
            <h5>Home / FAQ</h5>
        </div>
    </div>

    <main class="solutions-page main-content-page p-main mt-5">
        <div class="container">
            <div class="text-center" data-aos-duration="100" data-aos="fade-down" style="
    margin-bottom: 100px;
">
                <h2 class="text-color-black">Frequently asked questions</h2>
                <p class="col-lg-8 col-12 m-auto mt-4 text-center">Everything you need to know about the INDUSTRIES WE SERVE.</p>
            </div>
        </div>
        <div class="bg-light p-main">
            <div class="container">
            <?php 
            $currentTitle = null;
            foreach($faq as $index => $item):
                if ($item["title"] !== $currentTitle):
            ?>
        <?php if ($currentTitle !== null): ?>
            </div> <!-- Close the previous .faq container -->
        <?php endif; ?>
        <div class="faq">
            <h2 class="text-uppercase fw-bold mb-4"><?php echo $item["title"]?></h2>
            <?php
                    $currentTitle = $item["title"];
                endif;
            ?>
            <div class="faq-content d-flex justify-content-between">
                <div>
                    <h3><?php echo $item["question_title"]?></h3>
                    <p class="text-start"><?php echo $item["sub_title"]?></p>
                    <?php 
                        if (!empty($item["description"])) {
                            if (strpos($item["description"], ',') !== false) {
                                $descriptions = explode(', ', $item["description"]);
                                // Description contains ","
                                echo "<ol class=''>";
                                foreach ($descriptions as $description) {
                                    echo '<li>' . $description . '</li>';
                                }
                                echo "</ol>";
                            } else {
                                echo $item["description"];
                            }
                        }
                    ?>
                </div>
                <div class="collapse-container">
                    <img src="images/Icon wrap.png" class="wrap" alt="">
                    <img src="images/Icon unwrap.png" class="unwrap" style="display: none;" alt="">
                </div>
            </div>
            <?php endforeach; ?>

            <?php if (!empty($faq)): ?>
                </div> <!-- Close the last .faq container if there are FAQs -->
            <?php endif; ?>

            </div>
        </div>
    </main>

<?php include 'includes/footer.php' ?>.
<script>
    var x = window.matchMedia("(max-width: 992px)")
    
    if (x.matches) { // If media query matches
        $('.wrap').each(function(){
        $(this).click(function(){
            $(this).next().css('display','block')
            $(this).css('display','none')
            $(this).parent().parent().css('max-height','500px')
            })
        })
        $('.unwrap').each(function(){
            $(this).click(function(){
                $(this).prev().css('display','block')
                $(this).css('display','none')
                $(this).parent().parent().css('max-height','75px')
            })
        })
    } else {
        $('.wrap').each(function(){
        $(this).click(function(){
            $(this).next().css('display','block')
            $(this).css('display','none')
            $(this).parent().parent().css('max-height','500px')
        })
        })
        $('.unwrap').each(function(){
            $(this).click(function(){
                $(this).prev().css('display','block')
                $(this).css('display','none')
                $(this).parent().parent().css('max-height','53px')
            })
        })
    }


</script>