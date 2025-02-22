<?php
session_start();
include('connection.php'); ?>


<!DOCTYPE html>
<html lang="zxx">


<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CookVerse</title>
    <!-- ::::::::::::::Favicon icon::::::::::::::-->
    <link rel="shortcut icon" href="mainstyle/images/favicon.ico" type="image/png">
    <!-- Main CSS -->
    <!-- <link rel="stylesheet" href="mainstyle/sass/style.css"> -->
    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <link rel="stylesheet" href="mainstyle/css/vendor/vendor.min.css">
    <link rel="stylesheet" href="mainstyle/css/plugins/plugins.min.css">
    <link rel="stylesheet" href="mainstyle/css/style.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Include Bootstrap JS (if using Bootstrap modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <style>
        .sidebar-content .filter-type-price div {
            margin-bottom: 8px;
            /* Adds space between each option */
        }

        /* Add this CSS to your stylesheet */
        #searchInput {
            border: 1px solid #ccc;
            /* Gray border */
            border-radius: 4px;
            /* Rounded corners */
            padding: 10px;
            /* Padding inside the input */
            width: 100%;
            /* Full width */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Optional shadow for a subtle effect */
            transition: border-color 0.3s;
            /* Transition for border color */
        }

        #searchInput:focus {
            border-color: #007bff;
            /* Change border color on focus */
            outline: none;
            /* Remove default outline */
        }

        .wishlist-active i.icon-heart {
            color: red;
            /* Change this to the color you want for active wishlist items */
        }
    </style>
</head>

<body>
    <?php
    if (isset($_SESSION['cust_id'])) {
        // User is logged in, include the logged-in header
        include('headers/cust_header.php');
    } else {
        // User is not logged in, include the default header
        include('headers/MainHeader.php');
    }

    ?>
    <!-- ...:::: Start Breadcrumb Section:::... -->
    <div class="breadcrumb-section breadcrumb-bg-color--golden">
        <div class="breadcrumb-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="breadcrumb-title">About Us</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li>Home</a></li>
                                    <li>About Us</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- ...:::: End Breadcrumb Section:::... -->

    <!-- ...:::: Start Shop Section:::... -->
    <div class="shop-section">
        <div class="container">
            <div class="row flex-column-reverse flex-lg-row">

            </div>
        </div>
    </div> <!-- ...:::: End Shop Section:::... -->
    <!-- Start About Top -->
    <div class="about-top">
        <div class="container">
            <div class="row d-flex align-items-center justify-content-between d-sm-column">
                <div class="col-md-6">
                    <div class="about-img" data-aos="fade-up" data-aos-delay="0">
                        <div class="img-responsive">
                            <img src="mainstyle/images/about/aboutus.jpeg" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="content" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="title">ABOUT OUR STORE</h3>
                        <h5 class="semi-title">We believe that great cooking starts with the right tools, and every kitchen deserves the best.</h5>
                        <p>At CookVerse, we carefully select each piece of cookware for its quality, performance, and durability. Our goal is to elevate your cooking experience by providing cookware that inspires creativity and precision. From renowned brands to emerging innovators, we offer a range of products that reflect our commitment to excellence and passion for cooking.</p>
                        <p>Our team is dedicated to helping you find the perfect tools for your culinary needs, whether you're a professional chef or a home cook. We take pride in the details, ensuring each product meets our high standards for quality and design. We believe that every meal is an opportunity to connect, create, and celebrate, and we're honored to be part of your kitchen journey.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End About Top -->


    <!--  Start  Team Section    -->
    <div class="team-section section-top-gap-100 secton-fluid section-inner-bg">
        <!-- Start Section Content Text Area -->
        <div class="section-title-wrapper" data-aos="fade-up" data-aos-delay="0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-content-gap">
                            <div class="secton-content text-center">
                                <h3 class="section-title">Meet Our Team</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Section Content Text Area -->
        <div class="team-wrapper">
            <div class="container">
                <div class="row mb-n6">
                    <div class="col-xl-3 mb-5">
                        <div class="team-single" data-aos="fade-up" data-aos-delay="0">
                            <div class="team-img">
                                <img class="img-fluid" src="mainstyle/images/team/team1.jpg" alt="" style="width:200px; height:200px;">
                            </div>
                            <div class="team-content">
                                <h6 class="team-name font--bold mt-5">Ben Yohanan</h6>
                                <span class="team-title">Web Designer</span>
                                <ul class="team-social pos-absolute">
                                    <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                    <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                    <li><a href="#"><i class="ion-social-instagram"></i></a></li>
                                    <li><a href="#"><i class="ion-social-linkedin"></i></a></li>
                                    <li><a href="#"><i class="ion-social-rss"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 mb-5">
                        <div class="team-single" data-aos="fade-up" data-aos-delay="200">
                            <div class="team-img">
                                <img class="img-fluid" src="mainstyle/images/team/team2.jpg" alt="" style="width:200px; height:200px;">
                            </div>
                            <div class="team-content">
                                <h6 class="team-name font--bold mt-5">Anas Raju</h6>
                                <span class="team-title">CEO Founder</span>
                                <ul class="team-social pos-absolute">
                                    <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                    <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                    <li><a href="#"><i class="ion-social-instagram"></i></a></li>
                                    <li><a href="#"><i class="ion-social-linkedin"></i></a></li>
                                    <li><a href="#"><i class="ion-social-rss"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 mb-5">
                        <div class="team-single" data-aos="fade-up" data-aos-delay="400">
                            <div class="team-img">
                                <img class="img-fluid" src="mainstyle/images/team/team3.jpg" alt="" style="width:200px; height:200px;">
                            </div>
                            <div class="team-content">
                                <h6 class="team-name font--bold mt-5">Adithya P Ganesh</h6>
                                <span class="team-title">Chief Officer</span>
                                <ul class="team-social pos-absolute">
                                    <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                    <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                    <li><a href="#"><i class="ion-social-instagram"></i></a></li>
                                    <li><a href="#"><i class="ion-social-linkedin"></i></a></li>
                                    <li><a href="#"><i class="ion-social-rss"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 mb-5">
                        <div class="team-single" data-aos="fade-up" data-aos-delay="600">
                            <div class="team-img">
                                <img class="img-fluid" src="mainstyle/images/team/team4.jpg" alt="" style="width:200px; height:200px;">
                            </div>
                            <div class="team-content">
                                <h6 class="team-name font--bold mt-5">Sooraj Anil</h6>
                                <span class="team-title">CTO</span>
                                <ul class="team-social pos-absolute">
                                    <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                    <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                    <li><a href="#"><i class="ion-social-instagram"></i></a></li>
                                    <li><a href="#"><i class="ion-social-linkedin"></i></a></li>
                                    <li><a href="#"><i class="ion-social-rss"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--   End  Team Section   -->



    <?php include('footers/footer.php')  ?>

    <!-- material-scrolltop button -->
    <button class="material-scrolltop" type="button"></button>

    <!-- Start Modal Add cart -->
    <div class="modal fade" id="modalAddcart" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col text-right">
                                <button type="button" class="close modal-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"> <i class="fa fa-times"></i></span>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="modal-add-cart-product-img">
                                            <img class="img-fluid" src="mainstyle/images/product/default/home-1/default-1.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="modal-add-cart-info"><i class="fa fa-check-square"></i> Added to cart successfully!</div>
                                        <div class="modal-add-cart-product-cart-buttons">
                                            <a href="cust_viewcart.php">View Cart</a>
                                            <a href="checkout.html">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 modal-border">
                                <ul class="modal-add-cart-product-shipping-info">
                                    <li> <strong><i class="icon-shopping-cart"></i> There Are <span class="totalitem"></span> Items In Your Cart.</strong></li>
                                    <li> <strong>TOTAL PRICE: </strong> <span class="total_amount"></span></li>
                                    <li class="modal-continue-button"><a href="#" data-bs-dismiss="modal">CONTINUE SHOPPING</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Modal Add cart -->


    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <script src="mainstyle/js/vendor/vendor.min.js"></script>
    <script src="mainstyle/js/plugins/plugins.min.js"></script>
    <!-- Main JS -->
    <script src="mainstyle/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>

</html>