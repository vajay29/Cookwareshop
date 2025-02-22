<!-- Start Header Area -->
<header class="header-section d-none d-xl-block">
    <div class="header-wrapper">
        <div class="header-bottom header-bottom-color--golden section-fluid sticky-header sticky-color--golden">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 d-flex align-items-center justify-content-between">
                        <!-- Start Header Logo -->
                        <div class="header-logo">
                            <div class="logo">
                                <a href="about.php"><img src="mainstyle/images/logo/CookVerse.png" alt=""></a>
                            </div>
                        </div>
                        <!-- End Header Logo -->

                        <!-- Start Header Main Menu -->
                        <div class="main-menu menu-color--black menu-hover-color--golden">
                            <nav>
                                <ul>
                                    <li>
                                        <a class="active main-menu-link" href="cust_home.php">Home <i></i></a>
                                    </li>
                                    
                                    <li>
                                        <a href="cust_viewproduct.php">Shop <i></i></a>
                                    </li>
                                    <li>
                                        <a href="about.php">About Us</a>
                                    </li>
                                    <li>
                                        <a href="cust_contact.php">Contact Us</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!-- End Header Main Menu Start -->


                        <!-- Start Header Action Link -->
                        <ul class="header-action-link  action-color--black action-hover-color--golden">
                            <?php
                            $customerID = $_SESSION['cust_id'];
                            include('connection.php');

                            // Get total wishlist items
                            $sql = "SELECT COUNT(*) AS totalItems FROM wishlist WHERE customer_id = '$customerID'";
                            $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
                            $totalWishlistItems = $row['totalItems'] ? $row['totalItems'] : 0; // Default to 0 if no items

                            // Get total cart items
                            $sql = "SELECT SUM(qty) AS totalItems FROM cart WHERE customer_id ='$customerID'";
                            $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
                            $totalCartItems = $row['totalItems'] ? $row['totalItems'] : 0; // Default to 0 if no items
                            ?>
                            <li>
                                <a href="cust_account.php">
                                    <i class="icon-user"></i>
                                </a>
                            </li>
                            <li>
                                <a href="cust_wishlist.php">
                                    <i class="icon-heart"></i>

                                    <span class="wishlist-count"><?php echo $totalWishlistItems;  ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="cust_viewcart.php" >
                                    <i class="icon-bag"></i>

                                    <span class="cart-item-count"><?php echo $totalCartItems; ?></span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="#offcanvas-about" class="offacnvas offside-about offcanvas-toggle">
                                    <i class="icon-menu"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- End Header Action Link -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Start Header Area -->

<!-- Start Offcanvas Addcart Section -->
<div id="offcanvas-add-cart" class="offcanvas offcanvas-rightside offcanvas-add-cart-section">
    <!-- Start Offcanvas Header -->
    <div class="offcanvas-header text-right">
        <button class="offcanvas-close"><i class="ion-android-close"></i></button>
    </div> <!-- End Offcanvas Header -->

    <!-- Start  Offcanvas Addcart Wrapper -->
    <div class="offcanvas-add-cart-wrapper">
        <h4 class="offcanvas-title">Shopping Cart</h4>
        <ul class="offcanvas-cart">
            <?php
            $customer_id = $_SESSION['cust_id'];
            $sql_count = "SELECT p.*,c.* FROM cart c JOIN product p ON c.product_id = p.product_id WHERE customer_id='$customer_id'";
            $result_count = mysqli_query($conn, $sql_count);
            $total = 0;

            // Check if there are any items in the cart
            if (mysqli_num_rows($result_count) > 0) {
                // Loop through items if there are any in the cart
                while ($row = mysqli_fetch_array($result_count)) {
                    $total += ($row['qty'] * $row['price']);
            ?>
                    <li class="offcanvas-cart-item-single">
                        <div class="offcanvas-cart-item-block">
                            <a href="#" class="offcanvas-cart-item-image-link">
                                <img src="./uploads/<?php echo $row['image']; ?>" alt="" class="offcanvas-cart-image">
                            </a>
                            <div class="offcanvas-cart-item-content">
                                <a href="#" class="offcanvas-cart-item-link"><?php echo $row['product_name']; ?></a>
                                <div class="offcanvas-cart-item-details">
                                    <span class="offcanvas-cart-item-details-quantity"><?php echo $row['qty']; ?> x </span>
                                    <span class="offcanvas-cart-item-details-price">₹<?php echo $row['price']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="offcanvas-cart-item-delete text-right">
                            <a href="#" class="offcanvas-cart-item-delete"><i class="fa fa-trash-o"></i></a>
                        </div>
                    </li>
                <?php
                }
            } else {
                ?>
                <!-- Message when cart is empty -->
                <li style="text-align:center;">

                    <img src="mainstyle/images/emprt-cart/emptycart.png" alt="Empty Cart" style=" margin-bottom:10px;">
                    <p style="margin-bottom:10px; padding:10px; font-size:20px; color:#666; padding-left:15px; ">Your cart is currently empty.</p>

                </li>
                <li><a href="cust_viewproduct.php" class="btn btn-block btn-golden">Continue Shopping</a></li>
            <?php
            }
            ?>
        </ul>

        <?php if (mysqli_num_rows($result_count) > 0) { ?>
            <div class="offcanvas-cart-total-price">
                <span class="offcanvas-cart-total-price-text">Subtotal:</span>
                <span class="offcanvas-cart-total-price-value">₹<?php echo $total; ?></span>
            </div>
            <ul class="offcanvas-cart-action-button">
                <li><a href="cust_viewcart.php" class="btn btn-block btn-golden">View Cart</a></li>
                <li><a href="cust_checkout.php" class="btn btn-block btn-golden mt-5">Checkout</a></li>
            </ul>
        <?php } ?>
    </div>
    <!-- End  Offcanvas Addcart Wrapper -->

</div>
<!-- End  Offcanvas Addcart Section -->
 <!-- Start Offcanvas Mobile Menu Section -->
 <div id="offcanvas-about" class="offcanvas offcanvas-rightside offcanvas-mobile-about-section">
        <!-- Start Offcanvas Header -->
        <div class="offcanvas-header text-right">
            <button class="offcanvas-close"><i class="ion-android-close"></i></button>
        </div> <!-- End Offcanvas Header -->
        <!-- Start Offcanvas Mobile Menu Wrapper -->
        <!-- Start Mobile contact Info -->
        <div class="mobile-contact-info">
            <div class="logo">
                <a href="index.html"><img src="assets/images/logo/logo_white.png" alt=""></a>
            </div>

            <address class="address">
                <span>Address: Your address goes here.</span>
                <span>Call Us: 0123456789, 0123456789</span>
                <span>Email: demo@example.com</span>
            </address>

            <ul class="social-link">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
            </ul>

            <ul class="user-link">
                <li><a href="cust_wishlist.php">Wishlist</a></li>
                <li><a href="cust_viewcart.php">Cart</a></li>
                <!-- <li><a href="cust_checkout.php">Checkout</a></li> -->
            </ul>
        </div>
        <!-- End Mobile contact Info -->
    </div> <!-- ...:::: End Offcanvas Mobile Menu Section:::... --