<?php
session_start();
// Assuming you have a database connection in $conn
include('connection.php');
// Get the product ID from the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    // Fetch the product from the database
    $sql = "SELECT product.product_name as product_name, product.description, product.price,product.stock, product.image, category.name as category_name,brand.name as brand_name,material.name as material_name
        FROM product 
        JOIN category ON product.category_id = category.category_id 
        JOIN brand ON product.brand_id=brand.brand_id
        JOIN material ON product.material_id=material.material_id
        WHERE product.product_id = $product_id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_array($result);

    $sql = "SELECT r.*,c.name as customer_name FROM review r JOIN customer c ON r.customer_id=c.customer_id
    WHERE r.product_id='$product_id'";
    $rev_result = mysqli_query($conn, $sql);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <style>
        .wishlist-btn {

            /* Space between elements */
            text-decoration: none;
            /* Remove underline from link */
            color: #ff6b6b;
            /* Default color for the heart */
            font-size: 24px;
        }

        .wishlist-btn:hover {
            color: #ff3b3b;
            /* Change color on hover */
        }

        .text-danger {
            color: red;
        }

        .text-muted {
            color: #ff6b6b;
        }

        .big-star-empty {
            font-size: 24px;
            color: #e1e1e1;
        }

        .big-star-fill {
            font-size: 24px;
            color: #b19361;
        }
    </style>
    <style>
        ul.comment {
            list-style: none;
            /* Remove default bullet points */
            padding: 0;
            margin: 0;
        }

        ul.comment .comment-list {
            border-bottom: 1px solid #ddd;
            /* Separate each review visually */
            padding: 15px 0;
        }

        ul.comment .comment-wrapper {
            display: flex;
            flex-direction: column;
        }

        .comment-content {
            margin-top: 10px;
        }

        .review-star {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .review-star li {
            margin-right: 3px;
            font-size: 14px;
        }


        .para-content p {
            margin: 0;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
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
                        <h3 class="breadcrumb-title">Product Details</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li>Home</li>
                                    <li>Shop</li>
                                    <li class="active" aria-current="page">Product Details</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- ...:::: End Breadcrumb Section:::... -->

    <!-- Start Product Details Section -->
    <div class="product-details-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6">
                    <div class="product-details-gallery-area" data-aos="fade-up" data-aos-delay="0">
                        <!-- Start Large Image -->
                        <div class="product-large-image product-large-image-horaizontal swiper-container">
                            <div class="swiper-wrapper">
                                <div class="product-image-large-image swiper-slide zoom-image-hover img-responsive">
                                    <img src="./uploads/<?php echo $product['image']; ?>" alt="">
                                </div>

                            </div>
                        </div>
                        <!-- End Large Image -->
                        <!-- Start Thumbnail Image -->
                        <div
                            class="product-image-thumb product-image-thumb-horizontal swiper-container pos-relative mt-5">

                            <!-- Add Arrows -->
                            <div class="gallery-thumb-arrow swiper-button-next"></div>
                            <div class="gallery-thumb-arrow swiper-button-prev"></div>
                        </div>
                        <!-- End Thumbnail Image -->
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6">
                    <div class="product-details-content-area product-details--golden" data-aos="fade-up"
                        data-aos-delay="200">
                        <!-- Start  Product Details Text Area-->
                        <div class="product-details-text">
                            <h4 class="title"><?php echo $product['product_name']; ?></h4>
                            <div class="d-flex align-items-center">
                                <ul class="review-star">
                                    <?php
                                    // Assume $product_id is defined based on the current product
                                    $sql_avg_rating = "SELECT AVG(ratingcount) as avg_rating FROM rating WHERE product_id = ?";
                                    $stmt_avg_rating = $conn->prepare($sql_avg_rating);
                                    $stmt_avg_rating->bind_param('i', $product_id);
                                    $stmt_avg_rating->execute();
                                    $result_avg_rating = $stmt_avg_rating->get_result();

                                    // Initialize avg_rating to 0 if no ratings are found
                                    $avg_rating = 0;
                                    if ($result_avg_rating->num_rows > 0) {
                                        $row = $result_avg_rating->fetch_assoc();
                                        $avg_rating = round($row['avg_rating']); // Round to the nearest whole number
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

                                <a href="#" class="customer-review ml-2">(customer review )</a>
                            </div>
                            <div class="price">₹<?php echo $product['price']; ?>/-</div>
                            <!-- Product Variable Single Item -->
                            <div class="variable-single-item">
                                <div class="product-stock"> <span class="product-stock-in"><i
                                            class="ion-checkmark-circled"></i></span>
                                    <?php if ($product['stock'] > 0 && $product['stock'] < 10) { ?>
                                        <span>Availability : </span><a style="color: red;"> Only <?php echo $product['stock']; ?> items left!!</a>
                                    <?php } elseif ($product['stock'] >= 10) { ?>
                                        <span>Availability : </span><a style="color: green;"> In Stock</a>
                                    <?php } elseif ($product['stock'] <= 0) { ?>
                                        <span>Availability : </span><a style="color: red;"> Out of Stock</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div> <!-- End  Product Details Text Area-->
                        <!-- Start Product Variable Area -->
                        <div class="product-details-variable">

                            <!-- Product Variable Single Item -->
                            <div class="d-flex align-items-center ">
                                <div class="variable-single-item ">
                                    <span>Quantity</span>
                                    <div class="product-variable-quantity">
                                        <input min="1" max="<?php echo $product['stock']; ?>" value="1" type="number" class="product-quantity"> <!-- Ensure this class is set -->
                                    </div>
                                </div>

                                <div class="product-add-to-cart-btn">
                                    <a href="#" class="btn btn-block btn-lg btn-black-default-hover add-to-cart" data-id="<?php echo $product_id; ?>">+ Add To Cart</a>
                                </div>
                                <div class="product-add-to-cart-btn" style="padding-left:20px;">
                                    <a href="#" class="btn btn-block btn-lg btn-black-default-hover buy-now" data-id="<?php echo $product_id; ?>">Buy Now</a>
                                </div>
                            </div>
                            <!-- Start  Product Details Meta Area-->
                            <div class="product-details-meta mb-20">
                                <?php
                                $cust_id = $_SESSION['cust_id'] ?? '';
                                $in_wishlist = false;

                                if ($cust_id) {
                                    $check_query = "SELECT * FROM wishlist WHERE product_id = ? AND customer_id = ?";
                                    $stmt = $conn->prepare($check_query);
                                    $stmt->bind_param('ii', $product_id, $cust_id);
                                    $stmt->execute();
                                    $ans = $stmt->get_result();

                                    $in_wishlist = $ans->num_rows > 0; // true if product is in wishlist
                                }


                                $color_class = $in_wishlist ? 'text-danger' : 'text-muted'; // red if in wishlist, gray if not
                                ?>
                                <a href="#" class="icon-space-right wishlist-btn " data-product-id="<?php echo $product_id; ?>"><i class="icon-heart <?php echo $color_class; ?>"></i>Add to wishlist
                                </a>

                            </div> <!-- End  Product Details Meta Area-->
                        </div> <!-- End Product Variable Area -->
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Product Details Section -->

    <!-- Start Product Content Tab Section -->
    <div class="product-details-content-tab-section section-top-gap-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product-details-content-tab-wrapper" data-aos="fade-up" data-aos-delay="0">

                        <!-- Start Product Details Tab Button -->
                        <ul class="nav tablist product-details-content-tab-btn d-flex justify-content-center">
                            <li><a class="nav-link active" data-bs-toggle="tab" href="#description">
                                    Description
                                </a></li>
                            <li><a class="nav-link" data-bs-toggle="tab" href="#specification">
                                    Specification
                                </a></li>
                            <li><a class="nav-link" data-bs-toggle="tab" href="#review">
                                    Reviews (<?php echo mysqli_num_rows($rev_result); ?>)
                                </a></li>
                        </ul> <!-- End Product Details Tab Button -->

                        <!-- Start Product Details Tab Content -->
                        <div class="product-details-content-tab">
                            <div class="tab-content">
                                <!-- Start Product Details Tab Content Singel -->
                                <div class="tab-pane active show" id="description">
                                    <div class="single-tab-content-item">
                                        <p><?php echo $product['description']; ?></p>
                                    </div>
                                </div> <!-- End Product Details Tab Content Singel -->
                                <!-- Start Product Details Tab Content Singel -->
                                <div class="tab-pane" id="specification">
                                    <div class="single-tab-content-item">
                                        <table class="table table-bordered mb-20">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Material</th>
                                                    <td><?php echo $product['material_name']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Category</th>
                                                    <td><?php echo $product['category_name']; ?></td>
                                                <tr>
                                                    <th scope="row">Brand</th>
                                                    <td><?php echo $product['brand_name']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div> <!-- End Product Details Tab Content Singel -->
                                <!-- Start Product Details Tab Content Singel -->

                                <div class="tab-pane" id="review">
                                    <div class="single-tab-content-item">
                                        <ul class="comment">
                                            <!-- Start - Review Comment list-->
                                            <li class="comment-list">
                                                <div class="comment-wrapper">
                                                    <?php
                                                    // Check if there are any reviews
                                                    if (mysqli_num_rows($rev_result) > 0) {
                                                        while ($row = mysqli_fetch_array($rev_result)) {
                                                    ?>
                                                            <div class="comment-content">
                                                                <div class="comment-content-top">
                                                                    <div class="comment-content-left">
                                                                        <h6 class="comment-name"><?php echo htmlspecialchars($row['customer_name']); ?></h6>
                                                                        <ul class="review-star">
                                                                            <?php
                                                                            // Assume $product_id and $customer_id are defined based on the current product and logged-in customer
                                                                            $sql_rating = "SELECT ratingcount FROM rating WHERE product_id = ? AND customer_id = ?";
                                                                            $stmt_rating = $conn->prepare($sql_rating);
                                                                            $stmt_rating->bind_param('ii', $product_id, $row['customer_id']);
                                                                            $stmt_rating->execute();
                                                                            $result_rating = $stmt_rating->get_result();

                                                                            // Initialize rating count to 0 if no rating is found
                                                                            $ratingcount = 0;
                                                                            if ($result_rating->num_rows > 0) {
                                                                                $rate_row = $result_rating->fetch_assoc();
                                                                                $ratingcount = $rate_row['ratingcount'];
                                                                            }
                                                                            $stmt_rating->close();
                                                                            // Loop to display filled stars up to the rating count
                                                                            for ($i = 1; $i <= 5; $i++) {
                                                                                if ($i <= $ratingcount) {
                                                                                    echo '<li class="fill"><i class="ion-android-star"></i></li>';
                                                                                } else {
                                                                                    echo '<li class="empty"><i class="ion-android-star"></i></li>';
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </ul>
                                                                    </div>
                                                                </div>

                                                                <div class="para-content">
                                                                    <p><?php echo htmlspecialchars($row['review']); ?></p>
                                                                </div>
                                                            </div>
                                                    <?php
                                                        }
                                                    } else {
                                                        echo "<p>No reviews yet. Be the first to write a review!</p>";
                                                    }
                                                    ?>
                                                </div>
                                            </li>
                                            <!-- End - Review Comment list-->
                                        </ul>

                                        <?php
                                        if (isset($_SESSION['cust_id'])) {
                                            $customer_id = $_SESSION['cust_id'];
                                            // Assuming you have $customer_id from the session and $prod_id is already set
                                            $query = "SELECT p.product_id 
                    FROM orders o
                    INNER JOIN ordermaster om ON o.ordermaster_id = om.ordermaster_id
                    INNER JOIN product p ON o.product_id = p.product_id
                    WHERE om.customer_id = '$customer_id' AND p.product_id = '$product_id' AND om.status = 'delivered'"; // Ensure that the order is completed

                                            $result = mysqli_query($conn, $query);

                                            // Check if the customer has purchased the product
                                            if (mysqli_num_rows($result) > 0) {
                                                // Customer has purchased the product, show the review form
                                        ?>
                                                <div class="review-form">
                                                    <div class="review-form-text-top">
                                                        <h5>ADD A REVIEW</h5>
                                                    </div>
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <input type="hidden" id="rating-input" name="rating" value="">
                                                                <input type="hidden" name="pro_id" id="pro_id-input" value="<?php echo $product_id; ?>">

                                                                <div class="list d-flex">
                                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                        <a href="#" class="starr" data-value="<?php echo $i; ?>">
                                                                            <i class="ion-android-star big-star-empty"></i>
                                                                        </a>
                                                                    <?php endfor; ?>
                                                                </div>
                                                                <p id="rating-label"></p>
                                                                <div class="default-form-box">
                                                                    <label for="comment-review-text">Your review <span>*</span></label>
                                                                    <textarea id="comment-review-text" placeholder="Write a review" required></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <button class="btn btn-md btn-black-default-hover" id="submit-review" type="button">Submit</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                        <?php }
                                        } ?>
                                    </div>
                                </div> <!-- End Product Details Tab Content Single -->
                                <!-- End Product Details Tab Content Singel -->
                            </div>
                        </div> <!-- End Product Details Tab Content -->
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Product Content Tab Section -->



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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.add-to-cart').click(function(e) {
                e.preventDefault(); // Prevent the default behavior of the button

                var productId = $(this).data('id'); // Get the product ID frvariable-single-item om the data attribute

                // Correctly select the quantity input within the same container as the button
                var quantity = $(this).closest('.d-flex').find('.product-quantity').val();

                // Check if quantity is a valid number and at least 1
                if (quantity < 1 || isNaN(quantity)) {
                    toastr.warning('Please enter a valid quantity (1 or more).');
                    return; // Exit if quantity is invalid
                }

                console.log('Product ID:', productId); // Log the product ID
                console.log('Quantity:', quantity); // Log the quantity

                $.ajax({
                    url: 'add-to-cart.php',
                    type: 'POST', // Use POST to send data
                    data: {
                        product_id: productId, // Send product ID as 'id'
                        qty: quantity // Send the quantity
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Use toastr to display messages
                        if (response.success) {
                            toastr.success(response.message); // Show success message
                            // Update cart item count

                            $('.cart-item-count').text(response.totalCartItems); // Assuming response.cartCount returns the updated cart count
                        } else {
                            if (response.message === 'Item already added to your cart!') {
                                toastr.warning(`${response.message} <a href="cust_viewcart.php" style="color: #fff; text-decoration: underline;">Go to cart</a>`, {
                                    allowHtml: true
                                });
                            }
                        }

                        // Redirect if necessary
                        if (response.redirect) {
                            window.location.href = 'login.php'; // Change to your login URL
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred: " + error);
                        toastr.error('An error occurred while processing your request.'); // Show error message
                    }
                });
            });
        });
    </script>

    <script>
        var isLoggedIn = <?php echo isset($_SESSION['cust_id']) ? 'true' : 'false'; ?>;
        $(document).ready(function() {
            $('.wishlist-btn').on('click', function(e) {
                e.preventDefault();
                if (!isLoggedIn) {
                    // Redirect to the login page if not logged in
                    window.location.href = 'login.php'; // Change 'login.php' to your actual login page
                    return;
                }
                var button = $(this);
                var productId = button.data('product-id');
                var heartIcon = button.find('i');

                $.ajax({
                    url: 'wishlist.php',
                    type: 'POST',
                    data: {
                        product_id: productId
                    },
                    success: function(response) {
                        console.log("Raw response:", response); // Log the raw response

                        if (typeof response === 'string') {
                            try {
                                response = JSON.parse(response); // Ensure response is parsed as JSON
                            } catch (e) {
                                console.error("Failed to parse JSON:", e);
                                toastr.error('An unexpected error occurred while processing the response.');
                                return;
                            }
                        }

                        if (response.status === 'success') {
                            if (response.action === 'added') {
                                heartIcon.removeClass('text-muted').addClass('text-danger');
                                toastr.success(response.message);
                            } else if (response.action === 'removed') {
                                heartIcon.removeClass('text-danger').addClass('text-muted');
                                toastr.success(response.message);
                            }

                            // Update the wishlist count
                            $('.wishlist-count').text(response.wishlistCount);
                        } else if (response.status === 'error') {
                            toastr.error(response.message); // Show error message
                        }
                    },
                    error: function() {
                        toastr.error('An unexpected error occurred.');
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.querySelector('.product-quantity');
            const maxStock = parseInt(quantityInput.getAttribute('max'), 10); // Get the max stock from the max attribute

            // Listen for changes in the input
            quantityInput.addEventListener('input', function() {
                // If quantity exceeds the available stock, set it to max stock
                if (parseInt(quantityInput.value, 10) > maxStock) {
                    quantityInput.value = maxStock;
                    alert('Maximum available stock reached.');
                }
            });

            // Prevent manual increase beyond max using arrow keys
            quantityInput.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowUp' && parseInt(quantityInput.value, 10) >= maxStock) {
                    e.preventDefault();
                    alert('Maximum available stock reached.');
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select the Buy Now button
            const buyNowButton = document.querySelector('.buy-now');

            buyNowButton.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default link behavior

                // Get the product ID and quantity
                const productId = this.getAttribute('data-id');
                const quantity = document.querySelector('.product-quantity').value;

                // Redirect to the buy now page with product ID and quantity as query parameters
                const url = `cust_buynow.php?product_id=${productId}&quantity=${quantity}`;
                window.location.href = url;
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            let ratingValue = 0; // Variable to hold the selected rating

            $('.starr').on('click', function(e) {
                e.preventDefault(); // Prevent default anchor behavior

                ratingValue = $(this).data('value'); // Set the selected rating
                $('#rating-input').val(ratingValue); // Set hidden input value

                // Clear previous stars by setting all to empty
                $('.starr i').removeClass('big-star-fill').addClass('big-star-empty');

                // Fill stars up to the clicked one
                $('.starr').each(function(index) {
                    if (index < ratingValue) {
                        $(this).find('i').removeClass('big-star-empty').addClass('big-star-fill');
                    }
                });

                // Update the label text
                let labelText;
                switch (ratingValue) {
                    case 1:
                        labelText = "Poor";
                        break;
                    case 2:
                        labelText = "Fair";
                        break;
                    case 3:
                        labelText = "Good";
                        break;
                    case 4:
                        labelText = "Very Good";
                        break;
                    case 5:
                        labelText = "Outstanding";
                        break;
                    default:
                        labelText = "No Rating";
                        break;
                }
                $('#rating-label').text(labelText);
            });

            $('#submit-review').on('click', function(e) {
                e.preventDefault(); // Prevent form submission

                const reviewText = $('#comment-review-text').val().trim();
                const productId = $('#pro_id-input').val();

                if (reviewText === '' || ratingValue === 0) {
                    toastr.error("Please provide a review and a rating before submitting.");
                    return;
                }

                // Prepare data for submission
                const data = {
                    product_id: productId,
                    message: reviewText,
                    rating: ratingValue
                };

                // Submit the data using AJAX
                $.post('submit_review.php', data, function(response) {
                    if (response.success) {
                        toastr.success("Thank you for your review!");
                        // Optionally, refresh or dynamically update the review section
                        location.reload();
                    } else {
                        toastr.error('Error submitting review: ' + response.message);
                    }
                }, 'json');
            });
        });
    </script>


</body>


</html>