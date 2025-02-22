<?php
session_start();
include('Connection.php');
$customer_id = $_SESSION['cust_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch and sanitize the POST data
    $customername = mysqli_real_escape_string($conn, $_POST['name']); // Ensure the customer name is sanitized

    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $landmark = mysqli_real_escape_string($conn, $_POST['lmark']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
    $payment_method = $_POST['payment_method']; // Assuming this is sent from the form
    if ($payment_method == 'COD') {
        $payment_status = "Pending";
    } else {
        $payment_status = "Completed";
    }
    // This can be dynamic based on the actual payment flow
    if (isset($_POST['address_id']) && !empty($_POST['address_id'])) {
        $lastAddressId = $_POST['address_id'];
    } else {
        // Insert Delivery Address
        $insertAddressQuery = "INSERT INTO delivery_address (name, address, location, city, landmark, pincode, mobile,customer_id ) 
                           VALUES ('$customername', '$address', '$location', '$city', '$landmark', '$pincode','$mobile','$customer_id')";
        if (!mysqli_query($conn, $insertAddressQuery)) {
            die("Error inserting delivery address: " . mysqli_error($conn));
        }

        $lastAddressId = mysqli_insert_id($conn); // Get the last inserted address ID
    }
    $_SESSION['name'] = $customername;
    // Calculate total amount from the cart
    $cartItemsQuery = "SELECT SUM(product.price * cart.qty) as totalAmount 
                       FROM cart 
                       JOIN product ON cart.product_id = product.product_id 
                       WHERE cart.customer_id = '$customer_id'";
    $cartItemsResult = mysqli_query($conn, $cartItemsQuery);
    if (!$cartItemsResult) {
        die("Error fetching cart items: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($cartItemsResult);
    $totalAmount = $row['totalAmount'] + 40; // Add shipping charge of ₹60
    // Insert into Order Master
    $insertOrderMasterQuery = "INSERT INTO ordermaster (customer_id, date, total_amount, status, deliveryaddress_id) 
                               VALUES ('$customer_id', NOW(), '$totalAmount', 'Pending', '$lastAddressId')";
    if (!mysqli_query($conn, $insertOrderMasterQuery)) {
        die("Error inserting order master: " . mysqli_error($conn));
    }

    $lastOrderMasterId = mysqli_insert_id($conn); // Get the last inserted order master ID
    $_SESSION['master_id'] = $lastOrderMasterId;
    // Fetch cart items again for orders insertion
    $cartItemsQuery = "SELECT c.*, p.price FROM cart c 
                       JOIN product p ON c.product_id = p.product_id 
                       WHERE c.customer_id = '$customer_id'";
    $cartItemsResult = mysqli_query($conn, $cartItemsQuery);
    if (!$cartItemsResult) {
        die("Error fetching cart items: " . mysqli_error($conn));
    }
    while ($row = mysqli_fetch_assoc($cartItemsResult)) {
        $productId = $row['product_id'];
        $quantity = $row['qty'];
        $price = $row['price'];
        $totalPrice = $quantity * $price;

        // Debugging output
        //echo "Debug - Product ID: $productId, Quantity: $quantity, Price: $price, Total Price: $totalPrice<br>";

        $insertOrderQuery = "INSERT INTO orders (ordermaster_id, product_id, quantity, total_price) 
                             VALUES ('$lastOrderMasterId', '$productId', '$quantity', '$totalPrice')";
        if (!mysqli_query($conn, $insertOrderQuery)) {
            die("Error inserting order: " . mysqli_error($conn));
        }

        $stk_sql = "UPDATE product SET stock = stock - '$quantity' WHERE product_id = '$productId'";
        mysqli_query($conn, $stk_sql);
    }
    // Delete Cart Items
    $deleteCartItemsQuery = "DELETE FROM cart WHERE customer_id = '$customer_id'";
    if (!mysqli_query($conn, $deleteCartItemsQuery)) {
        die("Error deleting cart items: " . mysqli_error($conn));
    }

    // Insert payment details
    $insertPaymentQuery = "INSERT INTO payment (ordermaster_id, payment_method, payment_date, payment_status) 
    VALUES ('$lastOrderMasterId', '$payment_method', NOW(), '$payment_status')";
    if (!mysqli_query($conn, $insertPaymentQuery)) {
        die("Error inserting payment details: " . mysqli_error($conn));
    }

?>

    <script type="text/javascript" src="swal/jquery.min.js"></script>
    <script type="text/javascript" src="swal/bootstrap.min.js"></script>
    <script type="text/javascript" src="swal/sweetalert2@11.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SweetAlert initialization code goes here
            Swal.fire({
                icon: 'success',
                text: 'Your order has been placed successfully.',
                didClose: () => {
                    window.location.replace('cust_invoice.php');
                }
            });
        });
    </script>

<?php
}

?>

<!DOCTYPE html>
<html lang="zxx">


<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>HONO - Multi Purpose HTML Template</title>

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
    <style>
        .address-cards-container {
            display: flex;
            flex-wrap: wrap;
            /* Allows cards to wrap to the next row if there's not enough space */
            gap: 1rem;
            /* Adds spacing between the cards */
            justify-content: start;
            /* Aligns cards to the start of the row */
        }
    </style>
</head>

<body>
    <?php include('headers/cust_header.php')  ?>

    <!-- ...:::: Start Breadcrumb Section:::... -->
    <div class="breadcrumb-section breadcrumb-bg-color--golden">
        <div class="breadcrumb-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="breadcrumb-title">Checkout</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="shop-grid-sidebar-left.html">Shop</a></li>
                                    <li class="active" aria-current="page">Checkout</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- ...:::: End Breadcrumb Section:::... -->

    <!-- ...:::: Start Checkout Section:::... -->
    <div class="checkout-section">
        <div class="container">
            <div class="row">
                <!-- User Quick Action Form -->
                <div class="col-12">
                    <div class="user-actions accordion" data-aos="fade-up" data-aos-delay="0">
                        <h3>
                            <i class="fa fa-file-o" aria-hidden="true"></i>
                            Shipping to a saved address?
                            <a class="Returning" href="#" data-bs-toggle="collapse" data-bs-target="#checkout_login" aria-expanded="true">
                                Click here
                            </a>
                        </h3>
                        <div id="checkout_login" class="collapse" data-parent="#checkout_login">
                            <div class="checkout_info">
                                <div id="addressCardsContainer" class="address-cards-container">
                                    <!-- Address cards will be dynamically loaded here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User Quick Action Form -->
            </div>
            <!-- Start User Details Checkout Form -->
            <div class="checkout_form" data-aos="fade-up" data-aos-delay="400">
                <form action="" method="POST" class="contact-form" id="checkoutForm">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">

                            <h3>Billing Details</h3>
                            <input type="hidden" name="address_id">
                            <div class="row">
                                <input type="hidden" id="address_id" name="address_id"> <!-- Hidden field for selected address ID -->

                                <div class="col-lg-12">
                                    <div class="default-form-box">
                                        <label>Full Name</label>
                                        <input type="text" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="default-form-box">
                                        <label>Address</label>
                                        <input placeholder="House number, House name" type="text" id="address" name="address" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="default-form-box">
                                        <label>Road Name/Area</label>
                                        <input type="text" placeholder="Road name, Area, Colony" id="location" name="location" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="default-form-box">
                                        <label>Town / City</label>
                                        <input type="text" id="city" name="city" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="default-form-box">
                                        <label>Landmark</label>
                                        <input type="text" id="lmark" name="lmark" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="default-form-box">
                                        <label>Pincode</label>
                                        <input type="text" id="pincode" name="pincode" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="default-form-box">
                                        <label>Phone</label>
                                        <input type="text" id="mobile" name="mobile" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <?php
                            $sql = "SELECT c.*,p.*,cust.customer_id  FROM cart c 
                            JOIN product p ON c.product_id = p.product_id 
                            JOIN customer cust ON c.customer_id = cust.customer_id 
                            WHERE cust.customer_id = '$customer_id'";
                            $result = mysqli_query($conn, $sql);
                            $total = 0;
                            ?>

                            <h3>Your order</h3>
                            <div class="order_table table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        while ($product = mysqli_fetch_array($result)) {
                                        ?>
                                            <tr>
                                                <td> <strong><?php echo $product['product_name']; ?> × <?php echo $product['qty']; ?></strong></td>
                                                <td><strong> <?php echo '₹ ' . number_format(($product['price'] * $product['qty']), 2); ?></strong></td>
                                                <?php $total = $total + $product['price'] * $product['qty']; ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Cart Subtotal</th>
                                            <td><strong>₹ <?php echo number_format($total, 2); ?></strong></td>
                                        </tr>
                                        <tr>
                                            <th>Shipping</th>
                                            <td><strong>Flat rate: ₹ 40.00</strong></td>
                                        </tr>
                                        <tr class="order_total">
                                            <th>Order Total</th>
                                            <td><strong>₹ <?php echo number_format(($total + 40), 2); ?></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="payment_method">
                                <div class="panel-default">
                                    <label class="checkbox-default" for="currencyCod" data-bs-toggle="collapse"
                                        data-bs-target="#methodCod">
                                        <input type="radio" name="payment_method" id="currencyCod" value="COD">
                                        <span>Cash on Delivery</span>
                                    </label>

                                    <div id="methodCod" class="collapse" data-parent="#methodCod">
                                        <div class="card-body1">
                                            <p>Please make sure to check your address and phone number for timely delivery.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-default">
                                    <label class="checkbox-default" for="currencyPaypal" data-bs-toggle="collapse"
                                        data-bs-target="#methodPaypal">
                                        <input type="radio" name="payment_method" id="currencyPaypal" value="UPI">
                                        <span>UPI</span>
                                    </label>
                                    <div id="methodPaypal" class="collapse " data-parent="#methodPaypal">
                                        <div class="card-body1">
                                            <p>Scan the QR code to pay via UPI:</p>
                                            <?php $amountqr = "₹" . number_format($total + 40, 2);
                                            $qrcodeURL = "https://api.qrserver.com/v1/create-qr-code/?size=150X150&data=" . urlencode($amountqr); ?>
                                            <img src="<?php echo $qrcodeURL; ?>" alt="UPI QR Code" />

                                        </div>
                                    </div>
                                </div>
                                <div class="panel-default">
                                    <label class="checkbox-default" for="currencyCard" data-bs-toggle="collapse"
                                        data-bs-target="#methodCard">
                                        <input type="radio" name="payment_method" value="Card" id="currencyCard">
                                        <span>Card Payment</span>
                                    </label>
                                    <div id="methodCard" class="collapse " data-parent="#methodCard">
                                        <div class="card-details">
                                            <p>Enter your card details:</p>
                                            <div class="default-form-box">
                                                <label for="cardNumber">Card Number:</label>
                                                <input type="text" id="cardNumber" name="cardNumber" class="input-field" />
                                            </div>
                                            <div class="default-form-box">
                                                <label for="expiryDate">Expiry Date:</label>
                                                <input type="text" id="expiryDate" name="expiryDate" class="input-field" />
                                            </div>
                                            <div class="default-form-box">
                                                <label for="cvv">CVV:</label>
                                                <input type="text" id="cvv" name="cvv" class="input-field" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="order_button pt-3">
                                    <button class="btn btn-md btn-black-default-hover" type="submit" value="SUBMIT">Pay & Proceed</button>
                                </div>
                            </div>
                </form>
            </div>
        </div>
        </form>
    </div> <!-- Start User Details Checkout Form -->
    </div>
    </div><!-- ...:::: End Checkout Section:::... -->
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
        $(document).ready(function() {
            // Trigger loading addresses on clicking the link
            $('.Returning').on('click', function(e) {
                e.preventDefault();
                console.log('Fetching saved addresses...');

                // AJAX call to fetch saved addresses
                $.ajax({
                    url: 'fetch_addresses.php', // Backend script to fetch addresses
                    method: 'GET',
                    success: function(data) {
                        var addresses = JSON.parse(data); // Parse JSON response
                        var container = $('#addressCardsContainer');
                        container.empty(); // Clear existing cards

                        // Populate address cards
                        if (addresses.length > 0) {
                            addresses.forEach(function(address) {
                                var cardHtml = `
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">${address.name}</h5>
                                        <p class="card-text">
                                            ${address.address}, ${address.location},<br>
                                            ${address.city}, ${address.landmark},<br>
                                            Pincode: ${address.pincode}<br>
                                            Mobile: ${address.mobile}
                                        </p>
                                        <button type="button" class="btn btn-primary select-address-btn" 
                                            data-id="${address.deliveryaddress_id}"
                                            data-name="${address.name}" 
                                            data-address="${address.address}" 
                                            data-location="${address.location}" 
                                            data-city="${address.city}" 
                                            data-landmark="${address.landmark}" 
                                            data-pincode="${address.pincode}" 
                                            data-mobile="${address.mobile}"
                                            style="background-color: black; border-color: black; color: white;">
                                            Select
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                                container.append(cardHtml);
                            });
                        } else {
                            container.html('<p>No saved addresses found.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching addresses:', error);
                    }
                });
            });

            // Populate form fields when an address is selected
            $(document).on('click', '.select-address-btn', function() {
                var addressData = $(this).data();

                // Populate the form fields
                $('input[name=address_id]').val(addressData.id);
                $('input[name="name"]').val(addressData.name);
                $('input[name="address"]').val(addressData.address);
                $('input[name="location"]').val(addressData.location);
                $('input[name="city"]').val(addressData.city);
                $('input[name="lmark"]').val(addressData.landmark);
                $('input[name="pincode"]').val(addressData.pincode);
                $('input[name="mobile"]').val(addressData.mobile);

                // Close the accordion (optional)
                $('#checkout_login').collapse('hide');
            });
        });
    </script>
    <script>
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            // Get form inputs
            const name = document.getElementById('name').value.trim();
            const phone = document.getElementById('mobile').value.trim();
            const pincode = document.getElementById('pincode').value.trim();
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');

            // Regular Expressions for validation
            const nameRegex = /^[a-zA-Z\s]+$/;
            const phoneRegex = /^\d{10}$/;
            const pincodeRegex = /^\d{6}$/;

            let valid = true;
            let errorMessage = "";

            // Validate name
            if (!nameRegex.test(name)) {
                valid = false;
                errorMessage += "Name must contain only letters and spaces.\n";
            }

            // Validate phone
            if (!phoneRegex.test(phone)) {
                valid = false;
                errorMessage += "Phone number must be exactly 10 digits.\n";
            }

            // Validate pincode
            if (!pincodeRegex.test(pincode)) {
                valid = false;
                errorMessage += "Pincode must be exactly 6 digits.\n";
            }

            // Validate payment method
            const paymentSelected = Array.from(paymentMethods).some((method) => method.checked);
            if (!paymentSelected) {
                valid = false;
                errorMessage += "Please select a payment method.\n";
            }

            // If validation fails, prevent form submission and show an alert
            if (!valid) {
                e.preventDefault(); // Prevent form submission
                alert(errorMessage); // Show error message
            }
        });
    </script>
</body>


</html>