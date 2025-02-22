<?php
session_start();
include('connection.php');
$customer_id = $_SESSION['cust_id'];
$sql = "SELECT p.*, c.* FROM cart c                                                            
JOIN product p ON c.product_id = p.product_id
WHERE c.customer_id='$customer_id'";
$result = mysqli_query($conn, $sql);
$total = 0;

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

</head>

<body>
    <?php include('headers/cust_header.php')  ?>

    <!-- ...:::: Start Breadcrumb Section:::... -->
    <div class="breadcrumb-section breadcrumb-bg-color--golden">
        <div class="breadcrumb-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="breadcrumb-title">Cart</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li>Home</li>
                                    <li>Shop</li>
                                    <li class="active" aria-current="page">Cart</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- ...:::: End Breadcrumb Section:::... -->

    <!-- ...:::: Start Cart Section:::... -->
    <?php
    if (mysqli_num_rows($result) > 0) {
        $subtotal = 0;
    ?>
        <div class="cart-section">
            <div class="cart-table-wrapper" data-aos="fade-up" data-aos-delay="0">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="table_desc">
                                <div class="table_page table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="product_remove">Delete</th>
                                                <th class="product_thumb">Image</th>
                                                <th class="product_name">Product</th>
                                                <th class="product-price">Price</th>
                                                <th class="product_quantity">Quantity</th>
                                                <th class="product_total">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_array($result)) {
                                                $product_total = $row['price'] * $row['qty'];
                                                $subtotal += $product_total;
                                            ?>

                                                <tr>
                                                    <td class="product_remove">
                                                        <button type="button" onclick="deleteCartItem(<?php echo $row['product_id']; ?>, this)"><i class="fa fa-trash-o"></i></button>
                                                    </td>

                                                    <td class="product_thumb"><a href="product-details-default.html"><img src="./uploads/<?php echo $row['image']; ?>" alt=""></a></td>
                                                    <td class="product_name"><a href="product-details-default.html"><?php echo $row['product_name']; ?></a></td>
                                                    <td class="product-price">₹<?php echo $row['price']; ?></td>
                                                    <td class="product_quantity">
                                                        <input min="1" max="100" value="<?php echo $row['qty']; ?>" type="number" onchange="updateCart(<?php echo $row['product_id']; ?>, this.value)">
                                                    </td>
                                                    <td class="product_total" id="item-total-<?php echo $row['product_id']; ?>">₹<?php echo number_format($product_total, 2); ?></td>
                                                </tr>
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
            </div>

            <div class="coupon_area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">

                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="coupon_code right" data-aos="fade-up" data-aos-delay="400">
                                <h3>Cart Totals</h3>
                                <div class="coupon_inner">
                                    <div class="cart_subtotal">
                                        <p>Subtotal</p>
                                        <p class="cart_amount" id="cart-subtotal">₹<?php echo number_format($subtotal, 2); ?></p>
                                    </div>
                                    <div class="cart_subtotal">
                                        <p>Shipping</p>
                                        <p class="cart_amount"><span>Flat Rate:</span> ₹<?php echo number_format(40, 2); ?></p>
                                    </div>
                                    <div class="cart_subtotal">
                                        <p>Total</p>
                                        <p class="cart_amount" id="cart-total">₹<?php echo number_format($subtotal + 40, 2); ?></p>
                                    </div>
                                    <div class="checkout_btn">
                                        <a href="cust_checkout.php" class="btn btn-md btn-golden">Proceed to Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="empty-cart-section section-fluid">
            <div class="emptycart-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-10 offset-md-1 col-xl-6 offset-xl-3">
                            <div class="emptycart-content text-center">
                                <div class="image">
                                    <img class="img-fluid" src="mainstyle/images/emprt-cart/empty-cart.png" alt="">
                                </div>
                                <h4 class="title">Your Cart is Empty</h4>
                                <h6 class="sub-title">Sorry Mate... No item Found inside your cart!</h6>
                                <a href="cust_viewproduct.php" class="btn btn-lg btn-golden">Continue Shopping</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- ...::::End  About Us Center Section:::... -->
    <?php
    } ?>
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
    <script>
        function updateCart(productId, qty) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update_cart.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {

                            const formatter = new Intl.NumberFormat('en-IN', {
                                style: 'currency',
                                currency: 'INR'
                            });


                            // Update the item total in the cart row
                            document.getElementById('item-total-' + productId).innerText = formatter.format(response.item_total);

                            // Update the subtotal and total in the "Cart Totals" section
                            document.getElementById('cart-subtotal').innerText = formatter.format(response.cart_total);
                            document.getElementById('cart-total').innerText = formatter.format(response.cart_total + 40);

                            document.querySelector('.cart-item-count').textContent = response.cart_item_total;

                        } else {
                            console.error(response.error || "Unknown error occurred.");
                            alert("Failed to update cart. Please try again.");
                        }
                    } catch (e) {
                        console.error("Failed to parse JSON response: ", xhr.responseText);
                    }
                }
            };

            xhr.send("product_id=" + productId + "&qty=" + qty);
        }
    </script>
    <script>
        function deleteCartItem(productId, element) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_cart_item.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            // Remove the item from the DOM
                            element.closest("tr").remove();

                            // Update the cart count in the DOM
                            if (response.cart_count !== undefined) {
                                document.querySelector('.cart-item-count').innerText = response.cart_count;
                            }

                            // Update the subtotal and total in the "Cart Totals" section
                            const formatter = new Intl.NumberFormat('en-IN', {
                                style: 'currency',
                                currency: 'INR'
                            });

                            const cartSubtotal = parseFloat(response.cart_total.replace(/,/g, ''));
                            const shippingCost = 40;
                            const cartTotal = cartSubtotal + shippingCost;

                            document.getElementById('cart-subtotal').innerText = formatter.format(cartSubtotal);
                            document.getElementById('cart-total').innerText = formatter.format(cartTotal);


                            // Check if the cart is now empty
                            const cartTableBody = document.querySelector(".table_desc tbody");
                            if (!cartTableBody || cartTableBody.rows.length === 0) {
                                // Replace cart section with the empty cart message
                                document.querySelector(".cart-section").innerHTML = `
                            <div class="empty-cart-section section-fluid">
                                <div class="emptycart-wrapper">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12 col-md-10 offset-md-1 col-xl-6 offset-xl-3">
                                                <div class="emptycart-content text-center">
                                                    <div class="image">
                                                        <img class="img-fluid" src="mainstyle/images/emprt-cart/empty-cart.png" alt="">
                                                    </div>
                                                    <h4 class="title">Your Cart is Empty</h4>
                                                    <h6 class="sub-title">Sorry Mate... No item Found inside your cart!</h6>
                                                    <a href="cust_viewproduct.php" class="btn btn-lg btn-golden">Continue Shopping</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                            }

                        } else {
                            alert(response.message || "Failed to delete item. Please try again.");
                        }
                    } catch (e) {
                        console.error("Failed to parse JSON response: ", xhr.responseText);
                    }
                }
            };

            xhr.send("delete=" + productId);
        }
    </script>

</body>


</html>