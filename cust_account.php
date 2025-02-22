<?php
include('connection.php');
session_start();
$customer_id = $_SESSION['cust_id'];
$sql = "SELECT * FROM customer WHERE customer_id = '$customer_id'";
$customer = mysqli_fetch_assoc(mysqli_query($conn, $sql));

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .modal-dialog {
            max-width: 1200px !important;
        }

        .cancel-btn {
            outline: 0;
            color: #fff;
            text-transform: uppercase;
            font-size: 14px;
            font-weight: 700;
            outline: 0;
            border-radius: 4px;
            background-color: red;
        }

        .hidden {
            display: none;
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
                        <h3 class="breadcrumb-title">My Account</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li>Home</li>
                                    <li>Shop</li>
                                    <li class="active" aria-current="page">My Account</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- ...:::: End Breadcrumb Section:::... -->

    <!-- ...:::: Start Account Dashboard Section:::... -->
    <div class="account-dashboard">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-2 col-lg-2">
                    <!-- Nav tabs -->
                    <div class="dashboard_tab_button" data-aos="fade-up" data-aos-delay="0">
                        <ul role="tablist" class="nav flex-column dashboard-list">


                            <li><a href="#Profile" data-bs-toggle="tab"
                                    class="nav-link btn btn-block btn-md btn-black-default-hover active">Profile</a></li>
                            <li> <a href="#orders" data-bs-toggle="tab"
                                    class="nav-link btn btn-block btn-md btn-black-default-hover">My Orders</a></li>
                            <li><a href="#password" data-bs-toggle="tab"
                                    class="nav-link btn btn-block btn-md btn-black-default-hover">Password</a></li>
                            <li><a href="sign_out.php"
                                    class="nav-link btn btn-block btn-md btn-black-default-hover">logout</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-12 col-md-10 col-lg-10">
                    <!-- Tab panes -->
                    <div class="tab-content dashboard_content" data-aos="fade-up" data-aos-delay="200">
                        <div class="tab-pane fade show active" id="Profile">
                            <h4>Edit Profile</h4>
                            <div class="table_page table-responsive">
                                <form id="profileForm">
                                    <div class="default-form-box mb-20">
                                        <label>Full Name</label>
                                        <input type="text" id="name" name="name" value="<?php echo $customer['name']; ?>" required>
                                    </div>
                                    <div class="default-form-box mb-20">
                                        <label>Phone Number</label>
                                        <input type="number" id="phone" name="phno" value="<?php echo $customer['phone']; ?>" required>
                                    </div>
                                    <div class="save_button mt-3">
                                        <button class="btn btn-md btn-black-default-hover" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="password">
                            <h4>Change Password</h4>
                            <form id="changePasswordForm">
                                <div class="default-form-box mb-20">
                                    <label>Current Password</label>
                                    <input type="password" id="currentPassword" name="current-password" required>
                                </div>
                                <div class="default-form-box mb-20">
                                    <label>New Password</label>
                                    <input type="password" id="newPassword" name="new-password" required>
                                </div>
                                <div class="default-form-box mb-20">
                                    <label>Confirm Password</label>
                                    <input type="password" id="confirmPassword" name="confirm-password" required>
                                </div>
                                <div class="save_button mt-3">
                                    <button class="btn btn-md btn-black-default-hover" type="submit">Save</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="orders">
                            <h4>Orders</h4>
                            <div class="table_page table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Order Id</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $customer_id = $_SESSION['cust_id'];
                                        $sql = "SELECT o.*, c.name AS customer_name 
                                                FROM ordermaster o 
                                                JOIN customer c ON o.customer_id = c.customer_id 
                                                WHERE c.customer_id = '$customer_id'";
                                        $count = 0;
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $count++;
                                        ?>
                                                <tr data-ordermaster-id="<?php echo $row['ordermaster_id']; ?>">
                                                    <td><?php echo $count; ?></td>
                                                    <td><?php echo $row['ordermaster_id']; ?></td>
                                                    <td><?php echo $row['date']; ?></td>
                                                    <td><span class="success">₹<?php echo $row['total_amount']; ?></span></td>
                                                    <td class="status"><?php echo $row['status']; ?></td>
                                                    <td><a class="view-details" href="#" data-ordermaster-id="<?php echo $row['ordermaster_id']; ?>" data-bs-toggle="modal" data-bs-target="#modalQuickview">View Details</a></td>
                                                </tr>
                                            <?php }
                                        } else { ?>
                                            <tr>
                                                <td colspan="6">
                                                    <h4>You have no orders.</h4>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- ...:::: End Account Dashboard Section:::... -->

    <?php include('footers/footer.php')  ?>

    <!-- material-scrolltop button -->
    <button class="material-scrolltop" type="button"></button>
    <div class="modal fade" id="modalQuickview" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <!-- Close button -->
                        <div class="row">
                            <div class="col text-right">
                                <button type="button" class="close modal-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                                </button>
                            </div>
                        </div>

                        <!-- Order Summary Table -->
                        <div class="table_desc">
                            <div class="table_page table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-right"><strong>Subtotal:</strong></td>
                                            <td><span class="total_amount"></span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right"><strong>Shipping:</strong></td>
                                            <td>₹50.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right"><strong>Order Total:</strong></td>
                                            <td><span class="total_amount"></span></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Shipping and Payment Details -->
                        <div class="row">
                            <div class="col-md-6 shipping-details">
                                <h3>Shipping Address</h3>
                            </div>
                            <div class="col-md-6 payment-details">
                                <h3>Payment Method</h3>
                            </div>
                        </div>

                        <!-- Invoice Download and Shipping Status -->
                        <div class="row">
                            <div class="col-md-6">
                                <h3>Download Invoice</h3>
                                <a href="#" class="invoice-download btn hidden" title="Download Invoice">
                                    <i class="fas fa-file-pdf" style="color: red; font-size: 24px;"></i>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <h3>Shipping Status</h3>
                                <p class="shipping-status"></p>
                            </div>
                            <div class="cancel-order text-center mt-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <script src="mainstyle/js/vendor/vendor.min.js"></script>
    <script src="mainstyle/js/plugins/plugins.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Main JS -->
    <script src="mainstyle/js/main.js"></script>
    <script>
        $(document).ready(function() {
            $('#modalQuickview').on('show.bs.modal', function(e) {
                const ordermasterId = $(e.relatedTarget).data('ordermaster-id'); // Get the ordermaster_id from the button or link that opened the modal

                $.ajax({
                    url: 'get_order_details.php', // Replace with the path to your PHP file
                    type: 'POST',
                    data: {
                        ordermaster_id: ordermasterId
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Populate order items table
                        let itemsHtml = '';
                        response.items.forEach((item, index) => {
                            itemsHtml += `
                        <tr>
                            <td>${index + 1}</td>
                            <td><img src="uploads/${item.image}" alt="${item.product_name}" style="width:50px; height:auto;"></td>
                            <td>${item.product_name}</td>
                            <td>₹${item.price}</td>
                            <td>${item.quantity}</td>
                            <td>₹${item.total}</td>`;

                            // Add "Review" button if the order status is "delivered"
                            if (response.shipping.order_status === 'delivered') {
                                itemsHtml += `
                            <td>
                                <a href="cust_singleproduct.php?id=${item.product_id}" class="btn btn-block btn-md btn-black-default-hover" title="Review Product">
                                    Review
                                </a>
                            </td>`;
                            } else {
                                itemsHtml += `<td></td>`; // Empty cell if not delivered
                            }

                            itemsHtml += `</tr>`;
                        });
                        $('#modalQuickview tbody').html(itemsHtml); // Insert items HTML into table body
                        $('.total_amount').text(`₹${response.total_price}`); // Display total amount

                        // Populate shipping details
                        $('.shipping-details').html(`
                    <p><strong>Name:</strong> ${response.shipping.name}<br>
                    <strong>Place:</strong> ${response.shipping.place}<br>
                    <strong>City:</strong> ${response.shipping.city}<br>
                    <strong>Pincode:</strong> ${response.shipping.pincode}<br>
                    <strong>Contact No.:</strong> ${response.shipping.mobile}</p>
                `);

                        // Populate payment details
                        $('.payment-details').html(`
                    <p><strong>Payment Method:</strong> ${response.payment_method}<br>
                    <strong>Status:</strong> ${response.status}</p>
                `);

                        // Set invoice download link
                        if (response.shipping.order_status !== 'cancelled') {
                            $('.invoice-download')
                                .attr('href', `cust_invoice.php?order_id=${ordermasterId}`)
                                .removeClass('hidden'); // Show the download button
                        } else {
                            $('.invoice-download').addClass('hidden'); // Hide the download button
                        }
                        // Display shipping status
                        $('.shipping-status').text(response.shipping.order_status);

                        // Show "Cancel Order" button only if order status is not 'delivered' or 'cancelled'
                        if (response.shipping.order_status !== 'delivered' && response.shipping.order_status !== 'cancelled') {
                            $('.cancel-order').html(`
                       <button type="submit" name="cancel_order" class="cancel-btn btn-danger" data-ordermaster-id="${ordermasterId}" title="Cancel Order">
                           Cancel Order
                       </button>
                    `);
                        } else {
                            $('.cancel-order').html(''); // Clear the cancel button if order cannot be cancelled
                        }
                    },
                    error: function() {
                        console.error("Failed to fetch order details.");
                    }
                });
            });
        });
    </script>
    <script>
        $(document).on('click', '.cancel-btn', function(e) {
            e.preventDefault();
            const ordermasterId = $(this).data('ordermaster-id');
            console.log('Cancel button clicked for order ID:', ordermasterId);

            $.ajax({
                url: 'cancel_order.php',
                type: 'POST',
                data: {
                    order_id: ordermasterId
                },
                success: function(response) {
                    console.log(response);
                    const result = JSON.parse(response);

                    if (result.status === 'success') {
                        // Close the modal
                        $('#modalQuickview').modal('hide');

                        // Show success message
                        toastr.success(result.message, 'Success', {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 3000
                        });

                        // Update the table row status without reloading
                        const row = $(`tr[data-ordermaster-id="${ordermasterId}"]`);
                        row.find('td.status').text('Cancelled');

                        // Send email after cancellation if payment method is COD, UPI, or Card
                        const emailData = {
                            ordermaster_id: ordermasterId,
                            payment_method: result.payment_method
                        };
                        if (result.payment_method === "COD" || result.payment_method === "UPI" || result.payment_method === "Card") {
                            $.ajax({
                                url: 'send_email.php',
                                type: 'POST',
                                data: emailData,
                                success: function(emailResponse) {
                                    emailResponse = JSON.parse(emailResponse);
                                    if (!emailResponse.success) {
                                        console.error("Email Error:", emailResponse.error);
                                    } else {
                                        console.log("Email sent successfully.");
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error("Email sending failed:", error);
                                }
                            });
                        }
                    } else {
                        toastr.error(result.message, 'Error', {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 3000
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    toastr.error('An error occurred. Please try again.', 'Error', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 3000
                    });
                }
            });
        });
    </script>


    <script>
        $(document).on('shown.bs.tab', 'a[href="#Profile"]', function() {
            $.ajax({
                url: 'fetch_profile.php', // PHP file to fetch user data
                type: 'GET',
                success: function(response) {
                    const result = JSON.parse(response);
                    $('#name').val(result.name);
                    $('#phone').val(result.phone);
                },
                error: function() {
                    toastr.error('Failed to fetch profile data.', 'Error', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 3000
                    });
                }
            });
        });
        $('#profileForm').on('submit', function(e) {
            e.preventDefault();
            const name = $('#name').val();
            const phone = $('#phone').val();

            $.ajax({
                url: 'update_profile.php', // PHP file to handle update
                type: 'POST',
                data: {
                    name: name,
                    phone: phone
                },
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.status === 'success') {
                        toastr.success(result.message, 'Success', {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 3000
                        });
                    } else {
                        toastr.error(result.message, 'Error', {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 3000
                        });
                    }
                },
                error: function() {
                    toastr.error('An error occurred. Please try again.', 'Error', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 3000
                    });
                }
            });
        });

        $('#changePasswordForm').on('submit', function(e) {
            e.preventDefault();

            const currentPassword = $('#currentPassword').val();
            const newPassword = $('#newPassword').val();
            const confirmPassword = $('#confirmPassword').val();

            $.ajax({
                url: 'change_password.php',
                type: 'POST',
                data: {
                    'current-password': currentPassword,
                    'new-password': newPassword,
                    'confirm-password': confirmPassword
                },
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.status === 'success') {
                        toastr.success(result.message, 'Success', {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 3000
                        });
                        setTimeout(function() {
                            window.location.href = 'login.php'; // Redirect to login after a brief delay
                        }, 3000);
                    } else {
                        toastr.error(result.message, 'Error', {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 3000
                        });
                    }
                },
                error: function() {
                    toastr.error('An error occurred. Please try again.', 'Error', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 3000
                    });
                }
            });
        });
    </script>

</body>

</html>