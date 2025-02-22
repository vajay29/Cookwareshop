<?php
session_start();
include('connection.php');
if (isset($_GET['ordermaster_id'])) {
    $ordermaster_id = $_GET['ordermaster_id'];
    $_SESSION['master_id'] = $ordermaster_id;
    $sql = "SELECT o.*,d.*,p.payment_method,p.payment_date,p.payment_status FROM ordermaster o JOIN delivery_address d on o.deliveryaddress_id=d.deliveryaddress_id
	JOIN payment p ON o.ordermaster_id=p.ordermaster_id WHERE o.ordermaster_id='$ordermaster_id'";
    $order = mysqli_fetch_array(mysqli_query($conn, $sql));
    $order_status = $order['status'];
}

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <?php include('headers/cust_header.php')  ?>


    <!-- ...:::: Start Breadcrumb Section:::... -->
    <div class="breadcrumb-section breadcrumb-bg-color--golden">
        <div class="breadcrumb-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="breadcrumb-title">My Account</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="shop-grid-sidebar-left.html">Shop</a></li>
                                    <li class="active" aria-current="page">My Account</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- ...:::: End Breadcrumb Section:::... -->


    <!-- Products and Payment Section -->
    <div class="col-lg-12">
        <div class="cart-table-wrapper" data-aos="fade-up" data-aos-delay="0">
            <div class="container">

                <div class="row">
                    <div class="col-12">
                        <div class="table_desc">
                            <div class="table_page table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product_remove">Sl No</th>
                                            <th class="product_thumb">Image</th>
                                            <th class="product_name">Product Name</th>
                                            <th class="product-price">Price</th>
                                            <th class="product_quantity">Quantity</th>
                                            <th class="product_total">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT p.*, om.*,od.*
                                                        FROM product p
                                                        JOIN orders od ON p.product_id = od.product_id
                                                        JOIN ordermaster om ON od.ordermaster_id = om.ordermaster_id
                                                        WHERE om.ordermaster_id = '$ordermaster_id'";

                                        $result = mysqli_query($conn, $sql);
                                        if ($result) {
                                            $cartsubtotal = 0;
                                            $count = 0;
                                            while ($product = mysqli_fetch_array($result)) {
                                                $total = $product['price'] * $product['quantity'];
                                                $cartsubtotal += $total;
                                                $count++;
                                        ?>

                                                <tr>
                                                    <td class="product_remove"> <?php echo $count; ?> </td>
                                                    <td class="product_thumb"><a href="product-details-default.html"><img src="./uploads/<?php echo $product['image']; ?>" alt=""></a></td>
                                                    <td class="product_name"><a href="product-details-default.html"><?php echo $product['product_name']; ?></a></td>
                                                    <td class="product-price">₹<?php echo number_format($product['price'], 2); ?></td>
                                                    <td class="product_quantity"><?php echo $product['quantity']; ?> </td>
                                                    <td class="product_total" id="item-total-<?php echo $r['product_id']; ?>">₹<?php echo number_format($total, 2); ?></td>
                                                </tr>

                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-right"><strong>Subtotal:</strong></td>
                                            <td>₹<?php echo number_format($cartsubtotal, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right"><strong>Shipping:</strong></td>
                                            <td>₹50.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right"><strong>Order Total:</strong></td>
                                            <td>₹<?php echo number_format(($cartsubtotal + 50), 2); ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="coupon_area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="coupon_code left" data-aos="fade-up" data-aos-delay="200">
                            <h3>Shipping Address</h3>
                            <div class="coupon_inner">
                                <p>
                                    <strong>Name:</strong> <?php echo $order['name']; ?><br>
                                    <strong>Place:</strong> <?php echo $order['address']; ?><br>
                                    <strong>Landmark:</strong> <?php echo $order['location']; ?><br>
                                    <strong>City/Town</strong> <?php echo $order['city']; ?><br>
                                    <strong>Landmark:</strong> <?php echo $order['landmark']; ?><br>
                                    <strong>Pincode:</strong> <?php echo $order['pincode']; ?><br>
                                    <strong>Contact No.:</strong> <?php echo $order['mobile']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="coupon_code right" data-aos="fade-up" data-aos-delay="400">
                            <h3>Payment Method</h3>
                            <div class="coupon_inner">

                                <p>
                                    <strong>Payment Method:</strong> <?php echo $order['payment_method']; ?><br>
                                    <strong>Status: </strong><?php echo $order['status']; ?><br>
                                </p>

                            </div>
                        </div>
                    </div>
                    <!-- Invoice details -->
                    <div class="col-lg-6 col-md-6">
                        <div class="coupon_code left" data-aos="fade-up" data-aos-delay="200">
                            <h3>Download Invoice</h3>
                            <strong>Click here to download:</strong>
                            <a href="cust_invoice.php" class="btn" title="Download Invoice">
                                <i class="fas fa-file-pdf" style="color: red; font-size: 24px;"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Shipping status -->
                    <div class="col-lg-6 col-md-6">
                        <div class="coupon_code right" data-aos="fade-up" data-aos-delay="400">
                            <h3>Shipping Status</h3>
                            <strong>Status:</strong>
                            <?php echo $order_status; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($order['status'] !== 'delivered' && $order['status'] !== 'cancelled'): ?>
                <form action="cancel_order.php" method="post" class="d-inline text-center mt-4">
                    <input type="hidden" name="order_id" value="<?php echo $order['ordermaster_id']; ?>">
                    <button type="submit" name="cancel_order" class="btn btn-danger" title="Cancel Order">
                        Cancel Order
                    </button>
                </form>
            <?php endif; ?>
        </div>



        <?php include('footers/footer.php')  ?>

        <!-- material-scrolltop button -->
        <button class="material-scrolltop" type="button"></button>

        <!-- Start Modal Add cart -->
        <div class="modal fade" id="modalAddcart" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col text-right">
                                    <button type="button" class="close modal-close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true"> <i class="fa fa-times"></i></span>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="modal-add-cart-product-img">
                                                <img class="img-fluid"
                                                    src="mainstyle/images/product/default/home-1/default-1.jpg" alt="">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="modal-add-cart-info"><i class="fa fa-check-square"></i>Added to cart
                                                successfully!</div>
                                            <div class="modal-add-cart-product-cart-buttons">
                                                <a href="cart.html">View Cart</a>
                                                <a href="checkout.html">Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 modal-border">
                                    <ul class="modal-add-cart-product-shipping-info">
                                        <li> <strong><i class="icon-shopping-cart"></i> There Are 5 Items In Your
                                                Cart.</strong></li>
                                        <li> <strong>TOTAL PRICE: </strong> <span>$187.00</span></li>
                                        <li class="modal-continue-button"><a href="#" data-bs-dismiss="modal">CONTINUE
                                                SHOPPING</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Modal Add cart -->

        <!-- Start Modal Quickview cart -->
        <div class="modal fade" id="modalQuickview" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col text-right">
                                    <button type="button" class="close modal-close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true"> <i class="fa fa-times"></i></span>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="product-details-gallery-area mb-7">
                                        <!-- Start Large Image -->
                                        <div class="product-large-image modal-product-image-large swiper-container">
                                            <div class="swiper-wrapper">
                                                <div class="product-image-large-image swiper-slide img-responsive">
                                                    <img src="mainstyle/images/product/default/home-1/default-1.jpg" alt="">
                                                </div>
                                                <div class="product-image-large-image swiper-slide img-responsive">
                                                    <img src="mainstyle/images/product/default/home-1/default-2.jpg" alt="">
                                                </div>
                                                <div class="product-image-large-image swiper-slide img-responsive">
                                                    <img src="mainstyle/images/product/default/home-1/default-3.jpg" alt="">
                                                </div>
                                                <div class="product-image-large-image swiper-slide img-responsive">
                                                    <img src="mainstyle/images/product/default/home-1/default-4.jpg" alt="">
                                                </div>
                                                <div class="product-image-large-image swiper-slide img-responsive">
                                                    <img src="mainstyle/images/product/default/home-1/default-5.jpg" alt="">
                                                </div>
                                                <div class="product-image-large-image swiper-slide img-responsive">
                                                    <img src="mainstyle/images/product/default/home-1/default-6.jpg" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Large Image -->
                                        <!-- Start Thumbnail Image -->
                                        <div
                                            class="product-image-thumb modal-product-image-thumb swiper-container pos-relative mt-5">
                                            <div class="swiper-wrapper">
                                                <div class="product-image-thumb-single swiper-slide">
                                                    <img class="img-fluid"
                                                        src="mainstyle/images/product/default/home-1/default-1.jpg" alt="">
                                                </div>
                                                <div class="product-image-thumb-single swiper-slide">
                                                    <img class="img-fluid"
                                                        src="mainstyle/images/product/default/home-1/default-2.jpg" alt="">
                                                </div>
                                                <div class="product-image-thumb-single swiper-slide">
                                                    <img class="img-fluid"
                                                        src="mainstyle/images/product/default/home-1/default-3.jpg" alt="">
                                                </div>
                                                <div class="product-image-thumb-single swiper-slide">
                                                    <img class="img-fluid"
                                                        src="mainstyle/images/product/default/home-1/default-4.jpg" alt="">
                                                </div>
                                                <div class="product-image-thumb-single swiper-slide">
                                                    <img class="img-fluid"
                                                        src="mainstyle/images/product/default/home-1/default-5.jpg" alt="">
                                                </div>
                                                <div class="product-image-thumb-single swiper-slide">
                                                    <img class="img-fluid"
                                                        src="mainstyle/images/product/default/home-1/default-6.jpg" alt="">
                                                </div>
                                            </div>
                                            <!-- Add Arrows -->
                                            <div class="gallery-thumb-arrow swiper-button-next"></div>
                                            <div class="gallery-thumb-arrow swiper-button-prev"></div>
                                        </div>
                                        <!-- End Thumbnail Image -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modal-product-details-content-area">
                                        <!-- Start  Product Details Text Area-->
                                        <div class="product-details-text">
                                            <h4 class="title">Nonstick Dishwasher PFOA</h4>
                                            <div class="price"><del>$70.00</del>$80.00</div>
                                        </div> <!-- End  Product Details Text Area-->
                                        <!-- Start Product Variable Area -->
                                        <div class="product-details-variable">
                                            <!-- Product Variable Single Item -->
                                            <div class="variable-single-item">
                                                <span>Color</span>
                                                <div class="product-variable-color">
                                                    <label for="modal-product-color-red">
                                                        <input name="modal-product-color" id="modal-product-color-red"
                                                            class="color-select" type="radio" checked>
                                                        <span class="product-color-red"></span>
                                                    </label>
                                                    <label for="modal-product-color-tomato">
                                                        <input name="modal-product-color" id="modal-product-color-tomato"
                                                            class="color-select" type="radio">
                                                        <span class="product-color-tomato"></span>
                                                    </label>
                                                    <label for="modal-product-color-green">
                                                        <input name="modal-product-color" id="modal-product-color-green"
                                                            class="color-select" type="radio">
                                                        <span class="product-color-green"></span>
                                                    </label>
                                                    <label for="modal-product-color-light-green">
                                                        <input name="modal-product-color"
                                                            id="modal-product-color-light-green" class="color-select"
                                                            type="radio">
                                                        <span class="product-color-light-green"></span>
                                                    </label>
                                                    <label for="modal-product-color-blue">
                                                        <input name="modal-product-color" id="modal-product-color-blue"
                                                            class="color-select" type="radio">
                                                        <span class="product-color-blue"></span>
                                                    </label>
                                                    <label for="modal-product-color-light-blue">
                                                        <input name="modal-product-color"
                                                            id="modal-product-color-light-blue" class="color-select"
                                                            type="radio">
                                                        <span class="product-color-light-blue"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- Product Variable Single Item -->
                                            <div class="d-flex align-items-center flex-wrap">
                                                <div class="variable-single-item ">
                                                    <span>Quantity</span>
                                                    <div class="product-variable-quantity">
                                                        <input min="1" max="100" value="1" type="number">
                                                    </div>
                                                </div>

                                                <div class="product-add-to-cart-btn">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalAddcart">Add To
                                                        Cart</a>
                                                </div>
                                            </div>
                                        </div> <!-- End Product Variable Area -->
                                        <div class="modal-product-about-text">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste
                                                laborum ad impedit pariatur esse optio tempora sint ullam autem deleniti nam
                                                in quos qui nemo ipsum numquam, reiciendis maiores quidem aperiam, rerum vel
                                                recusandae</p>
                                        </div>
                                        <!-- Start  Product Details Social Area-->
                                        <div class="modal-product-details-social">
                                            <span class="title">SHARE THIS PRODUCT</span>
                                            <ul>
                                                <li><a href="#" class="facebook"><i class="fa fa-facebook"></i></a></li>
                                                <li><a href="#" class="twitter"><i class="fa fa-twitter"></i></a></li>
                                                <li><a href="#" class="pinterest"><i class="fa fa-pinterest"></i></a></li>
                                                <li><a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
                                                </li>
                                                <li><a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
                                            </ul>

                                        </div> <!-- End  Product Details Social Area-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Modal Quickview cart -->

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
        <!-- Main JS -->
        <script src="mainstyle/js/main.js"></script>

</body>


</html>