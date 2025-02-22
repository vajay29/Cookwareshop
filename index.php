<?php
include('connection.php');
?>

<!DOCTYPE html>
<html lang="zxx">


<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>CookVerse</title>

    <!-- ::::::::::::::Favicon icon::::::::::::::-->
    <link rel="shortcut icon" href="mainstyle/images/favicon.ico" type="image/png">

    <!-- ::::::::::::::All CSS Files here :::::::::::::: -->
    <!-- Vendor CSS -->
    <!-- <link rel="stylesheet" href="mainstyle/css/vendor/font-awesome.min.css">
    <link rel="stylesheet" href="mainstyle/css/vendor/ionicons.css">
    <link rel="stylesheet" href="mainstyle/css/vendor/simple-line-icons.css">
    <link rel="stylesheet" href="mainstyle/css/vendor/jquery-ui.min.css"> -->

    <!-- Plugin CSS -->
    <!-- <link rel="stylesheet" href="mainstyle/css/plugins/swiper-bundle.min.css">
    <link rel="stylesheet" href="mainstyle/css/plugins/animate.min.css">
    <link rel="stylesheet" href="mainstyle/css/plugins/nice-select.css">
    <link rel="stylesheet" href="mainstyle/css/plugins/venobox.min.css">
    <link rel="stylesheet" href="mainstyle/css/plugins/jquery.lineProgressbar.css">
    <link rel="stylesheet" href="mainstyle/css/plugins/aos.min.css"> -->

    <!-- Main CSS -->
    <!-- <link rel="stylesheet" href="mainstyle/sass/style.css"> -->

    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <link rel="stylesheet" href="mainstyle/css/vendor/vendor.min.css">
    <link rel="stylesheet" href="mainstyle/css/plugins/plugins.min.css">
    <link rel="stylesheet" href="mainstyle/css/style.min.css">

</head>

<body>
    <?php include('headers/MainHeader.php')  ?>


    <!-- Start Hero Slider Section-->
    <div class="hero-slider-section">
        <!-- Slider main container -->
        <div class="hero-slider-active swiper-container">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Start Hero Single Slider Item -->
                <div class="hero-single-slider-item swiper-slide">
                    <!-- Hero Slider Image -->
                    <div class="hero-slider-bg">
                        <img src="mainstyle/images/hero-slider/home-1/index1.webp" alt="">
                    </div>
                    <!-- Hero Slider Content -->
                    <div class="hero-slider-wrapper">
                        <div class="container">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="hero-slider-content">
                                        <h4 class="subtitle" style="color:#fef5ef;">New collection</h4>
                                        <h2 class="title" style="color:#fef5ef;">Best Of Cookware <br> Products </h2>
                                        <a href="cust_viewproduct.php"
                                            class="btn btn-lg btn-outline-golden" style="color:#fef5ef; border-color:#fef5ef;">shop now </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End Hero Single Slider Item -->
                <!-- Start Hero Single Slider Item -->
                <div class="hero-single-slider-item swiper-slide">
                    <!-- Hero Slider Image -->
                    <div class="hero-slider-bg">
                        <img src="mainstyle/images/hero-slider/home-1/index2.webp" alt="">
                    </div>
                    <!-- Hero Slider Content -->
                    <div class="hero-slider-wrapper">
                        <div class="container">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="hero-slider-content">
                                        <h4 class="subtitle" style="color: white;">New collection</h4>
                                        <h2 class="title" style="color: white;">Best Of Cookware<br> Products</h2>
                                        <a href="cust_viewproduct.php"
                                            class="btn btn-lg btn-outline-golden" style="color: white; border-color:white;">shop now </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End Hero Single Slider Item -->
            </div>

            <!-- If we need pagination -->
            <div class="swiper-pagination active-color-golden"></div>

            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev d-none d-lg-block"></div>
            <div class="swiper-button-next d-none d-lg-block"></div>
        </div>
    </div>
    <!-- End Hero Slider Section-->

    

    <!-- Start Service Section -->
    <div class="service-promo-section section-top-gap-100">
        <div class="service-wrapper">
            <div class="container">
                <div class="row">
                    <!-- Start Service Promo Single Item -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="service-promo-single-item" data-aos="fade-up" data-aos-delay="0">
                            <div class="image">
                                <img src="mainstyle/images/icons/service-promo-1.png" alt="">
                            </div>
                            <div class="content">
                                <h6 class="title">FREE SHIPPING</h6>
                                <p>Get 10% cash back, free shipping, free returns, and more at 1000+ top retailers!</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Service Promo Single Item -->
                    <!-- Start Service Promo Single Item -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="service-promo-single-item" data-aos="fade-up" data-aos-delay="200">
                            <div class="image">
                                <img src="mainstyle/images/icons/service-promo-2.png" alt="">
                            </div>
                            <div class="content">
                                <h6 class="title">30 DAYS MONEY BACK</h6>
                                <p>100% satisfaction guaranteed, or get your money back within 30 days!</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Service Promo Single Item -->
                    <!-- Start Service Promo Single Item -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="service-promo-single-item" data-aos="fade-up" data-aos-delay="400">
                            <div class="image">
                                <img src="mainstyle/images/icons/service-promo-3.png" alt="">
                            </div>
                            <div class="content">
                                <h6 class="title">SAFE PAYMENT</h6>
                                <p>Pay with the world’s most popular and secure payment methods.</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Service Promo Single Item -->
                    <!-- Start Service Promo Single Item -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="service-promo-single-item" data-aos="fade-up" data-aos-delay="600">
                            <div class="image">
                                <img src="mainstyle/images/icons/service-promo-4.png" alt="">
                            </div>
                            <div class="content">
                                <h6 class="title">LOYALTY CUSTOMER</h6>
                                <p>Card for the other 30% of their purchases at a rate of 1% cash back.</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Service Promo Single Item -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Service Section -->



    <!-- Start Product Default Slider Section -->
    <div class="product-default-slider-section section-top-gap-100 section-fluid">
        <!-- Start Section Content Text Area -->
        <div class="section-title-wrapper" data-aos="fade-up" data-aos-delay="0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-content-gap">
                            <div class="secton-content">
                                <h3 class="section-title">THE NEW ARRIVALS</h3>
                                <p>Preorder now to receive exclusive deals & gifts</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Section Content Text Area -->
        <div class="product-wrapper" data-aos="fade-up" data-aos-delay="200">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="product-slider-default-2rows default-slider-nav-arrow">
                            <!-- Slider main container -->
                            <div class="swiper-container product-default-slider-4grid-2row">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <?php
                                    $sql = "SELECT * FROM product ORDER BY product_id DESC LIMIT 8";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <!-- Start Product Default Single Item -->
                                        <div class="product-default-single-item product-color--golden swiper-slide">
                                            <div class="image-box">
                                                <a href="cust_singleproduct.php?id=<?php echo $row['product_id']; ?>" class="image-link">
                                                    <img src="./uploads/<?php echo $row['image']; ?>" alt="" style="width: 300px; height: 300px;">
                                                    <!-- <img src="mainstyle/images/product/default/home-1/default-2.jpg" alt=""> -->
                                                </a>
                                                <div class="tag">
                                                    <span>sale</span>
                                                </div>
                                                <div class="action-link">
                                                    <div class="action-link-left">
                                                        <a href="login.php">
                                                            Add to Cart</a>
                                                    </div>
                                                    <div class="action-link-right">
                                                        <a href="cust_singleproduct.php?id=<?php echo $row['product_id']; ?>"><i
                                                                class="icon-eye"></i></a>
                                                        <a href="login.php"><i class="icon-heart"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <div class="content-left">

                                                    <h6 class="title"><?php echo $row['product_name']; ?></h6>
                                                    <ul class="review-star">
                                                        <?php
                                                        // Assume $product_id is defined based on the current product
                                                        $sql_avg_rating = "SELECT AVG(ratingcount) as avg_rating FROM rating WHERE product_id = ?";
                                                        $stmt_avg_rating = $conn->prepare($sql_avg_rating);
                                                        $stmt_avg_rating->bind_param('i', $row['product_id']);
                                                        $stmt_avg_rating->execute();
                                                        $result_avg_rating = $stmt_avg_rating->get_result();

                                                        // Initialize avg_rating to 0 if no ratings are found
                                                        $avg_rating = 0;
                                                        if ($result_avg_rating->num_rows > 0) {
                                                            $rating_row = $result_avg_rating->fetch_assoc();
                                                            $avg_rating = round($rating_row['avg_rating']); // Round to the nearest whole number
                                                        }
                                                        $stmt_avg_rating->close();

                                                        // Loop to display filled stars up to the average rating
                                                        for ($i = 1; $i <= 5; $i++) {
                                                            if ($i <= $avg_rating) {
                                                                echo '<li class="fill"><i class="ion-android-star"></i></li>';
                                                            } else {
                                                                echo '<li class="empty"><i class="ion-android-star"></i></li>';
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                                <div class="content-right">
                                                    <span class="price">Rs.<?php echo $row['price']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <a href="cust_viewproduct.php"
                                    class="btn btn-lg btn-outline-golden icon-space-left" style="margin-top: 20px;"><span
                                        class="d-flex align-items-center">View More <i
                                            class="ion-ios-arrow-thin-right"></i></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Product Default Slider Section -->

    <!-- Start Banner Section -->
    <div class="banner-section section-top-gap-100">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 offset-xl-2">
                    <!-- Start Banner Single Item -->
                    <div class="banner-single-item banner-style-3 banner-animation img-responsive" data-aos="fade-up"
                        data-aos-delay="0">
                        <div class="image">
                            <img class="img-fluid" src="mainstyle/images/banner/ind.jpeg" alt="">
                        </div>
                        <div class="content">
                            <h3 class="title">Modern Cookware
                                Basic Collection</h3>
                            <h5 class="sub-title">We design your kitchen more beautiful</h5>
                            <a href="cust_viewproduct.php"
                                class="btn btn-lg btn-outline-golden icon-space-left"><span
                                    class="d-flex align-items-center">discover now <i
                                        class="ion-ios-arrow-thin-right"></i></span></a>
                        </div>
                    </div>
                    <!-- End Banner Single Item -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Banner Section -->


    <?php include('footers/footer.php')  ?>

    <!-- material-scrolltop button -->
    <button class="material-scrolltop" type="button"></button>


    <!-- ::::::::::::::All JS Files here :::::::::::::: -->
    <!-- Global Vendor, plugins JS -->
    <!-- <script src="mainstyle/js/vendor/modernizr-3.11.2.min.js"></script>
    <script src="mainstyle/js/vendor/jquery-3.5.1.min.js"></script>
    <script src="mainstyle/js/vendor/jquery-migrate-3.3.0.min.js"></script>
    <script src="mainstyle/js/vendor/popper.min.js"></script>
    <script src="mainstyle/js/vendor/bootstrap.min.js"></script>
    <script src="mainstyle/js/vendor/jquery-ui.min.js"></script>  -->

    <!--Plugins JS-->
    <!-- <script src="mainstyle/js/plugins/swiper-bundle.min.js"></script>
    <script src="mainstyle/js/plugins/material-scrolltop.js"></script>
    <script src="mainstyle/js/plugins/jquery.nice-select.min.js"></script>
    <script src="mainstyle/js/plugins/jquery.zoom.min.js"></script>
    <script src="mainstyle/js/plugins/venobox.min.js"></script>
    <script src="mainstyle/js/plugins/jquery.waypoints.js"></script>
    <script src="mainstyle/js/plugins/jquery.lineProgressbar.js"></script>
    <script src="mainstyle/js/plugins/aos.min.js"></script>
    <script src="mainstyle/js/plugins/jquery.instagramFeed.js"></script>
    <script src="mainstyle/js/plugins/ajax-mail.js"></script> -->

    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <script src="mainstyle/js/vendor/vendor.min.js"></script>
    <script src="mainstyle/js/plugins/plugins.min.js"></script>

    <!-- Main JS -->
    <script src="mainstyle/js/main.js"></script>

</body>
</html>