<?php
session_start();
include('connection.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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


    <!-- Main CSS -->
    <!-- <link rel="stylesheet" href="mainstyle/sass/style.css"> -->

    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <link rel="stylesheet" href="mainstyle/css/vendor/vendor.min.css">
    <link rel="stylesheet" href="mainstyle/css/plugins/plugins.min.css">
    <link rel="stylesheet" href="mainstyle/css/style.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <style>
        .wishlist-active i.icon-heart {
            color: red;
            /* Change this to the color you want for active wishlist items */
        }
    </style>
</head>

<body>
    <?php include('headers/cust_header.php')  ?>

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

        <?php
        // Assuming a session is already started and user ID is available
        if (isset($_SESSION['cust_id'])) {
            $user_id = $_SESSION['cust_id'];

            // Get wishlist items for the user
            $wishlistQuery = "SELECT product_id FROM wishlist WHERE customer_id	 = $user_id";
            $wishlistResult = mysqli_query($conn, $wishlistQuery);

            $wishlistItems = [];
            while ($wishlistRow = mysqli_fetch_assoc($wishlistResult)) {
                $wishlistItems[] = $wishlistRow['product_id'];
            }
        }
        ?>

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
                                        if (isset($wishlistItems)) {
                                            $isInWishlist = in_array($row['product_id'], $wishlistItems);
                                        }

                                        $product_id = $row['product_id'];
                                        $ratingQuery = "SELECT AVG(ratingcount) as avg_rating FROM rating WHERE product_id = $product_id";
                                        $ratingResult = mysqli_query($conn, $ratingQuery);
                                        $ratingRow = mysqli_fetch_assoc($ratingResult);

                                        // Check if avg_rating is not null
                                        if ($ratingRow['avg_rating'] !== null) {
                                            $averageRating = round($ratingRow['avg_rating'], 1); // Round to one decimal
                                            $filledStars = floor($averageRating); // Number of full stars
                                            $halfStar = ($averageRating - $filledStars) >= 0.5; // Half-star condition
                                            $emptyStars = 5 - $filledStars - ($halfStar ? 1 : 0);
                                        } else {
                                            // Default behavior if no rating is available (e.g., all empty stars)
                                            $filledStars = 0;
                                            $halfStar = false;
                                            $emptyStars = 5;
                                        }

                                    ?>
                                        <!-- Start Product Default Single Item -->
                                        <div class="product-default-single-item product-color--golden swiper-slide">
                                            <div class="image-box">
                                                <a href="cust_singleproduct.php?id=<?php echo $row['product_id']; ?>" class="image-link">
                                                    <img src="./uploads/<?php echo $row['image']; ?>" alt="" style=" height: 250px;">
                                                    <!-- <img src="mainstyle/images/product/default/home-1/default-2.jpg" alt=""> -->
                                                </a>
                                                <div class="tag">
                                                    <span>sale</span>
                                                </div>
                                                <div class="action-link">
                                                    <div class="action-link-left">
                                                        <a href="#" onclick="handleAddToCart(<?php echo $row['product_id']; ?>)">Add to Cart</a>
                                                    </div>
                                                    <div class="action-link-right">
                                                        <a href="cust_singleproduct.php?id=<?php echo $row['product_id']; ?>"><i
                                                                class="icon-eye"></i></a>
                                                        <a href="#" class="add-to-wishlist <?php echo $isInWishlist ? 'wishlist-active' : ''; ?>"
                                                            data-product-id="<?php echo $row['product_id']; ?>"
                                                            onclick="handleAddToWishlist(event, this)">
                                                            <i class="icon-heart"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <div class="content-left">
                                                    <h6 class="title"><?php echo $row['product_name']; ?></h6>
                                                    <ul class="review-star">
                                                        <?php
                                                        // Render filled stars
                                                        for ($i = 0; $i < $filledStars; $i++) {
                                                            echo '<li class="fill"><i class="ion-android-star"></i></li>';
                                                        }
                                                        // Render half star if applicable
                                                        if ($halfStar) {
                                                            echo '<li class="half-fill"><i class="ion-android-star-half"></i></li>';
                                                        }
                                                        // Render empty stars
                                                        for ($i = 0; $i < $emptyStars; $i++) {
                                                            echo '<li class="empty"><i class="ion-android-star"></i></li>';
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
                                            <img class="img-fluid" src="mainstyle/images/product/default/home-1/default-1.jpg" alt="Product Image">
                                        </div>

                                    </div>
                                    <div class="col-md-8">
                                        <div class="modal-add-cart-info"><i class="fa fa-check-square"></i> Added to cart successfully!</div>
                                        <div class="modal-add-cart-product-cart-buttons">
                                            <a href="cust_viewcart.php">View Cart</a>
                                            <a href="cust_checkout.php">Checkout</a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Main JS -->
    <script src="mainstyle/js/main.js"></script>
    <script>
        function handleAddToCart(productId) {
            fetch('add-to-cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'product_id': productId
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    toastr.clear();

                    if (data.redirect) {
                        window.location.href = 'login.php';
                        return null;
                    }

                    if (data.success) {
                        const modalImageElement = document.querySelector('#modalAddcart .modal-add-cart-product-img img');
                        if (modalImageElement && data.image_url) {
                            modalImageElement.src = "uploads/" + data.image_url;
                        }

                        // Update cart count in DOM
                        document.querySelector('.cart-item-count').textContent = data.totalCartItems;

                        return fetch('get-cart-details.php');
                    }

                    if (data.message === 'Item already added to your cart!') {
                        toastr.warning(`${data.message} <a href="cust_viewcart.php" style="color: #fff; text-decoration: underline;">Go to cart</a>`, {
                            allowHtml: true
                        });
                    } else {
                        toastr.warning(data.message || '');
                    }

                    return null;
                })
                .then(response => {
                    if (!response) return;

                    return response.json();
                })
                .then(data => {
                    if (!data || !data.success) {
                        return;
                    }

                    let totalAmount = parseFloat(data.total_amount) || 0;

                    document.querySelector('#modalAddcart .totalitem').textContent = data.totalitem;
                    document.querySelector('#modalAddcart .total_amount').textContent = `₹ ${totalAmount.toFixed(2)}`;

                    const myModal = new bootstrap.Modal(document.getElementById('modalAddcart'));
                    myModal.show();
                })
                .catch(error => {
                    toastr.clear();
                    toastr.error(error.message || 'An unexpected error occurred. Please try again.');
                });
        }
    </script>
    <script>
        function handleAddToWishlist(event, element) {
            event.preventDefault(); // Prevent the default anchor action

            const productId = element.getAttribute('data-product-id');

            fetch('wishlist.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'product_id': productId
                    }),
                })
                .then(response => {
                    if (response.redirected) {
                        // Redirect to login if required
                        window.location.href = response.url;
                        return null; // Exit if redirected
                    } else {
                        return response.json();
                    }
                })
                .then(data => {
                    if (data && data.status === 'success') {
                        // Display the action message
                        const actionMessage = data.action === 'added' ?
                            'Item added to your wishlist!' :
                            'Item removed from your wishlist!';

                        toastr.success(actionMessage); // Show success message

                        // Update the wishlist count in the UI
                        if (data.wishlistCount !== undefined) {
                            updateWishlistCount(data.wishlistCount);
                        }

                        // Toggle the active class on the heart icon based on action
                        if (data.action === 'added') {
                            element.classList.add('wishlist-active'); // Add active style
                        } else {
                            element.classList.remove('wishlist-active'); // Remove active style
                        }
                    } else if (data) {
                        toastr.warning(data.message); // Show any error message from server
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred. Please try again.');
                });
        }

        // Function to update wishlist count in the DOM
        function updateWishlistCount(count) {
            const wishlistCountElement = document.querySelector('.wishlist-count');
            if (wishlistCountElement) {
                wishlistCountElement.textContent = count;
            } else {
                console.warn("Wishlist count element not found.");
            }
        }
    </script>
</body>

</html>