<?php
include('connection.php');
session_start();
if (isset($_SESSION['cust_id'])) {
    $cust_id = $_SESSION['cust_id'];

    // Fetch product details from the database using $prod_id
    $sql = "SELECT p.*, c.name as cat_name,w.*
            FROM product p
            INNER JOIN category c ON p.category_id = c.category_id 
            INNER JOIN wishlist w ON w.product_id=p.product_id
            WHERE w.customer_id = '$cust_id'";

    $result = mysqli_query($conn, $sql);
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

    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <link rel="stylesheet" href="mainstyle/css/vendor/vendor.min.css">
    <link rel="stylesheet" href="mainstyle/css/plugins/plugins.min.css">
    <link rel="stylesheet" href="mainstyle/css/style.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
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
                        <h3 class="breadcrumb-title">Wishlist</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li>Home</li>
                                    <li>Shop</li>
                                    <li class="active" aria-current="page">Wishlist</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- ...:::: End Breadcrumb Section:::... -->

    <!-- ...:::: Start Wishlist Section:::... -->
    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="wishlist-section">
            <!-- Start Cart Table -->
            <div class="wishlish-table-wrapper" data-aos="fade-up" data-aos-delay="0">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="table_desc">
                                <div class="table_page table-responsive">
                                    <table>
                                        <!-- Start Wishlist Table Head -->
                                        <thead>
                                            <tr>
                                                <th class="product_remove">Delete</th>
                                                <th class="product_thumb">Image</th>
                                                <th class="product_name">Product</th>
                                                <th class="product-price">Price</th>
                                                <th class="product_stock">Stock Status</th>
                                                <th class="product_addcart">Add To Cart</th>
                                            </tr>
                                        </thead> <!-- End Cart Table Head -->
                                        <tbody>
                                            <!-- Start Wishlist Single Item-->
                                            <?php

                                            while ($row = mysqli_fetch_array($result)) {
                                                $cust_id = $_SESSION['cust_id'] ?? '';
                                                $product_id = $row['product_id'];
                                                $in_wishlist = false;

                                                if ($cust_id) {
                                                    $check_query = "SELECT * FROM wishlist WHERE product_id = ? AND customer_id = ?";
                                                    $wishlistStmt = $conn->prepare($check_query);
                                                    $wishlistStmt->bind_param('ii', $product_id, $cust_id);
                                                    $wishlistStmt->execute();
                                                    $ans = $wishlistStmt->get_result();

                                                    $in_wishlist = $ans->num_rows > 0; // true if product is in wishlist
                                                }

                                                $color_class = $in_wishlist ? 'text-danger' : 'text-muted'; // red if in wishlist, gray if not
                                            ?>
                                                <tr>
                                                    <td class="product_remove">
                                                        <a href="#" onclick="deleteWishlistItem(<?php echo $row['product_id']; ?>, this)">
                                                            <i class="fa fa-trash-o"></i>
                                                        </a>
                                                    </td>

                                                    <td class="product_thumb"><a href="product-details-default.html"><img
                                                                src="./uploads/<?php echo $row['image']; ?>"
                                                                alt=""></a></td>
                                                    <td class="product_name"><a href="product-details-default.html"><?php echo $row['product_name']; ?></a></td>
                                                    <td class="product-price">₹<?php echo $row['price']; ?>/-</td>
                                                    <td class="product_stock">
                                                        <?php if ($row['stock'] > 0 && $row['stock'] < 10) { ?>
                                                            <a> Only <?php echo $row['stock']; ?> items left!!</a>
                                                        <?php } elseif ($row['stock'] >= 10) { ?>
                                                            <a> In Stock</a>
                                                        <?php } elseif ($row['stock'] <= 0) { ?>
                                                            <a style="color: red;"> Out of Stock</a>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="product_addcart"><a href="#" onclick="handleAddToCart(<?php echo $product_id; ?>)" class="btn btn-md btn-golden">Add To
                                                            Cart</a></td>
                                                </tr> <!-- End Wishlist Single Item-->
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- End Cart Table -->
        </div>
    <?php else: ?>
        <div class="empty-cart-section section-fluid">
            <div class="emptycart-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-10 offset-md-1 col-xl-6 offset-xl-3">
                            <div class="emptycart-content text-center">
                                <div class="image">
                                    <!-- <img class="img-fluid" src="mainstyle/images/emprt-cart/empty-cart.png" alt=""> -->
                                </div>
                                <h4 class="title">Your Wishlist is Empty</h4>
                                <h6 class="sub-title">Sorry Mate... No item Found inside your wishlist!</h6>
                                <a href="cust_viewproduct.php" class="btn btn-lg btn-golden">Continue Shopping</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ...:::: End Wishlist Section:::... -->

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        function deleteWishlistItem(productId, element) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_wishlist_item.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    const response = JSON.parse(xhr.responseText);

                    if (response.success) {
                        // Remove the item row from the DOM
                        element.closest("tr").remove();

                        // Show a toastr message
                        toastr.success("Item removed from wishlist!");
                        // Update the wishlist count
                        $('.wishlist-count').text(response.totalWishlistItems);
                        // Check if the wishlist is empty and display the empty message if true
                        if (response.wishlist_empty) {
                            document.querySelector(".wishlist-section").innerHTML = `
                        <div class="empty-cart-section section-fluid">
                            <div class="emptycart-wrapper">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12 col-md-10 offset-md-1 col-xl-6 offset-xl-3">
                                            <div class="emptycart-content text-center">
                                                <h4 class="title">Your Wishlist is Empty</h4>
                                                <h6 class="sub-title">Sorry Mate... No item Found inside your wishlist!</h6>
                                                <a href="cust_viewproduct.php" class="btn btn-lg btn-golden">Continue Shopping</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        }
                    } else {
                        toastr.error("Failed to delete item. Please try again.");
                    }
                }
            };

            xhr.send("product_id=" + productId);
        }

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

</body>
</html>