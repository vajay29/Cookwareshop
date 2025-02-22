<?php
session_start();
include('connection.php');

$filterConditions = [];

// Filter by categories
if (!empty($_GET['category_id'])) {
    $categoryIds = implode(',', array_map('intval', $_GET['category_id']));
    $filterConditions[] = "category_id IN ($categoryIds)";
}

// Filter by price ranges
if (!empty($_GET['price_range'])) {
    $priceConditions = [];
    foreach ($_GET['price_range'] as $range) {
        switch ($range) {
            case 'below500':
                $priceConditions[] = "price < 500";
                break;
            case '500-1000':
                $priceConditions[] = "price BETWEEN 500 AND 1000";
                break;
            case '1000-1500':
                $priceConditions[] = "price BETWEEN 1000 AND 1500";
                break;
            case '1500-2000':
                $priceConditions[] = "price BETWEEN 1500 AND 2000";
                break;
            case 'above2000':
                $priceConditions[] = "price > 2000";
                break;
        }
    }
    $filterConditions[] = '(' . implode(' OR ', $priceConditions) . ')';
}

// Filter by brands
if (!empty($_GET['brand_id'])) {
    $brandIds = implode(',', array_map('intval', $_GET['brand_id']));
    $filterConditions[] = "brand_id IN ($brandIds)";
}

// Build the final SQL query
$sql = "SELECT * FROM product";
if (!empty($filterConditions)) {
    $sql .= " WHERE " . implode(' AND ', $filterConditions);
}
$sql .= " ORDER BY product_id DESC";

// Execute the query
$result = mysqli_query($conn, $sql);

// Display products
while ($row = mysqli_fetch_assoc($result)) {
    // Your product display code here
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

    <!-- Toastr JS -->


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
                        <h3 class="breadcrumb-title">Shop</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li><a>Home</a></li>
                                    <li>Shop</li>

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
                <div class="col-lg-3">
                    <!-- Start Sidebar Area -->
                    <div class="siderbar-section" data-aos="fade-up" data-aos-delay="0">

                        <form action="cust_viewproduct.php" method="GET" id="filterForm">
                            <!-- FILTER BY CATEGORIES -->
                            <div class="sidebar-single-widget">
                                <h6 class="sidebar-title">CATEGORIES</h6>
                                <div class="sidebar-content">
                                    <ul>
                                        <?php
                                        $categoryQuery = "SELECT * FROM category";
                                        $categoryResult = mysqli_query($conn, $categoryQuery);
                                        $selectedCategories = isset($_GET['category_id']) ? $_GET['category_id'] : [];

                                        while ($category = mysqli_fetch_array($categoryResult)) {
                                            $categoryId = $category['category_id'];
                                            $categoryName = htmlspecialchars($category['name']);
                                            $isChecked = in_array($categoryId, $selectedCategories) ? 'checked' : '';
                                            echo '<li>
                        <label class="checkbox-default" for="category_' . $categoryId . '">
                            <input type="checkbox" name="category_id[]" id="category_' . $categoryId . '" value="' . $categoryId . '" ' . $isChecked . ' onchange="document.getElementById(\'filterForm\').submit();">
                            <span>' . $categoryName . '</span>
                        </label>
                    </li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- FILTER BY PRICE -->
                            <div class="sidebar-single-widget">
                                <h6 class="sidebar-title">FILTER BY PRICE</h6>
                                <div class="sidebar-content">
                                    <ul>
                                        <?php
                                        $priceRanges = [
                                            'below500' => 'Below ₹500',
                                            '500-1000' => '₹500 - ₹1000',
                                            '1000-1500' => '₹1000 - ₹1500',
                                            '1500-2000' => '₹1500 - ₹2000',
                                            'above2000' => 'Above ₹2000',
                                        ];
                                        $selectedPrices = isset($_GET['price_range']) ? $_GET['price_range'] : [];

                                        foreach ($priceRanges as $key => $label) {
                                            $isChecked = in_array($key, $selectedPrices) ? 'checked' : '';
                                            echo '<li>
                        <label class="checkbox-default" for="' . $key . '">
                            <input type="checkbox" id="' . $key . '" name="price_range[]" value="' . $key . '" ' . $isChecked . ' onchange="document.getElementById(\'filterForm\').submit();">
                            <span>' . $label . '</span>
                        </label>
                    </li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- FILTER BY BRAND -->
                            <div class="sidebar-single-widget">
                                <h6 class="sidebar-title">BRAND</h6>
                                <div class="sidebar-content">
                                    <ul>
                                        <?php
                                        $brandQuery = "SELECT * FROM brand";
                                        $brandResult = mysqli_query($conn, $brandQuery);
                                        $selectedBrands = isset($_GET['brand_id']) ? $_GET['brand_id'] : [];

                                        while ($brand = mysqli_fetch_array($brandResult)) {
                                            $brandId = $brand['brand_id'];
                                            $brandName = htmlspecialchars($brand['name']);
                                            $isChecked = in_array($brandId, $selectedBrands) ? 'checked' : '';
                                            echo '<li>
                        <label class="checkbox-default" for="brand_' . $brandId . '">
                            <input type="checkbox" name="brand_id[]" id="brand_' . $brandId . '" value="' . $brandId . '" ' . $isChecked . ' onchange="document.getElementById(\'filterForm\').submit();">
                            <span>' . $brandName . '</span>
                        </label>
                    </li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </form>


                    </div> <!-- End Sidebar Area -->
                </div>
                <div class="col-lg-9">
                    <!-- Start Shop Product Sorting Section -->
                    <div class="shop-sort-section">
                        <div class="container">
                            <div class="row">
                                <div class="sort-box d-flex justify-content-between align-items-md-center align-items-start flex-md-row flex-column">
                                    <div class="search-box">
                                        <input type="text" class="form-control" id="searchInput" placeholder="Search products...">
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

                    <!-- Start Tab Wrapper -->
                    <div class="sort-product-tab-wrapper">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="tab-content tab-animate-zoom">
                                        <!-- Start Grid View Product -->
                                        <div class="tab-pane active show sort-layout-single" id="layout-3-grid">
                                            <div class="row" id="product-listing">
                                                <?php
                                                // Get filters from the URL
                                                $categoryFilters = isset($_GET['category_id']) ? $_GET['category_id'] : [];
                                                $priceFilters = isset($_GET['price_range']) ? $_GET['price_range'] : [];
                                                $selectedBrands = isset($_GET['brand_id']) ? $_GET['brand_id'] : [];

                                                // Start with the base query
                                                $productQuery = "SELECT * FROM product";

                                                // Array to store conditions
                                                $conditions = [];

                                                // Add category conditions if selected
                                                if (!empty($categoryFilters)) {
                                                    $categoryIds = implode(",", array_map('intval', $categoryFilters)); // Sanitize category IDs
                                                    $conditions[] = "category_id IN ($categoryIds)";
                                                }

                                                // Add price conditions based on selected checkboxes
                                                $priceConditions = [];
                                                foreach ($priceFilters as $range) {
                                                    switch ($range) {
                                                        case 'below500':
                                                            $priceConditions[] = "price < 500";
                                                            break;
                                                        case '500-1000':
                                                            $priceConditions[] = "price >= 500 AND price <= 1000";
                                                            break;
                                                        case '1000-1500':
                                                            $priceConditions[] = "price >= 1000 AND price <= 1500";
                                                            break;
                                                        case '1500-2000':
                                                            $priceConditions[] = "price >= 1500 AND price <= 2000";
                                                            break;
                                                        case 'above2000':
                                                            $priceConditions[] = "price > 2000";
                                                            break;
                                                    }
                                                }

                                                // Combine price conditions with OR if they exist and add to conditions array
                                                if (!empty($priceConditions)) {
                                                    $conditions[] = "(" . implode(" OR ", $priceConditions) . ")";
                                                }

                                                // Add brand conditions if selected
                                                if (!empty($selectedBrands)) {
                                                    $brandIds = implode(",", array_map('intval', $selectedBrands)); // Sanitize brand IDs
                                                    $conditions[] = "brand_id IN ($brandIds)";
                                                }

                                                // Append conditions to the query
                                                if (!empty($conditions)) {
                                                    $productQuery .= " WHERE " . implode(" AND ", $conditions);
                                                }

                                                // Execute the query
                                                $result = mysqli_query($conn, $productQuery);

                                                while ($row = mysqli_fetch_array($result)) {
                                                    if (isset($wishlistItems)) {
                                                        $isInWishlist = in_array($row['product_id'], $wishlistItems);
                                                    }


                                                ?>
                                                    <div class="col-xl-4 col-sm-6 col-12">
                                                        <!-- Start Product Default Single Item -->
                                                        <div class="product-default-single-item product-color--golden"
                                                            data-aos="fade-up" data-aos-delay="0">
                                                            <div class="image-box">
                                                                <a href="cust_singleproduct.php?id=<?php echo $row['product_id']; ?>" class="image-link">

                                                                    <img src="./uploads/<?php echo $row['image']; ?>"
                                                                        alt="" style=" height: 250px;">
                                                                    <!-- <img src="mainstyle/images/product/default/home-1/default-9.jpg"
                                                                    alt=""> -->
                                                                    <!-- <img src="mainstyle/images/product/default/home-1/default-10.jpg"
                                                                    alt=""> -->
                                                                </a>
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
                                                                    <span class="price">₹<?php echo $row['price']; ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Product Default Single Item -->
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div> <!-- End Grid View Product -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End Tab Wrapper -->
                </div>
            </div>
        </div>
    </div> <!-- ...:::: End Shop Section:::... -->

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
    <script>
        $(document).ready(function() {
            $('#searchInput').on('input', function() {
                const query = $(this).val();

                $.ajax({
                    url: 'fetch_products.php',
                    type: 'GET',
                    data: {
                        search_query: query
                    },
                    success: function(response) {
                        // Update the product listing area with the response
                        $('#product-listing').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching products:", error);
                    }
                });
            });
        });
    </script>

</body>
</html>