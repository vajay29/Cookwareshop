<?php
include("connection.php");
session_start();

if (isset($_POST["Login"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Protect against SQL injection
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Verify the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM login WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_array($result);
        // Simple equality check for the password
        if ($row['password'] === $password) { // Case-sensitive comparison
            if ($row["usertype"] == "admin") {
                $_SESSION['username'] = $email;
                $_SESSION['name'] = 'Admin';
                echo '<script>window.location.href="AdminHome.php";</script>';
                exit();
            } elseif ($row["usertype"] == "customer") {

                $_SESSION['username'] = $email;
                $sql = "SELECT * FROM customer WHERE Email='$email'";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $row = mysqli_fetch_array($result);
                    $_SESSION['CustomerName'] = $row["name"];
                    $_SESSION['cust_id'] = $row["customer_id"];
                }
                echo '<script>window.location.href="cust_home.php";</script>';
                exit();
            } else {
                $_SESSION['loginMessage'] = "Invalid username or password";
                echo '<script>alert("Invalid username or password"); window.location.href="login.php";</script>';
                exit();
            }
        } else {
            $_SESSION['loginMessage'] = "Invalid username or password";
            echo '<script>alert("Invalid username or password"); window.location.href="login.php";</script>';
            exit();
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
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



    <style>
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
            /* Dark overlay */
            animation: fadeIn 0.3s;
            /* Fade in effect */
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 400px;
            /* Responsive max width */
            transition: transform 0.3s ease;
            /* Animation effect */
            transform: translateY(-50px);
            /* Start slightly above */
        }

        .modal-content.show {
            transform: translateY(0);
            /* Slide down into view */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        h1 {
            margin: 0 0 10px;
            font-size: 24px;
        }

        p {
            margin: 0 0 15px;
            font-size: 16px;
        }

        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;

        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>


</head>

<body>
    <?php include('headers/MainHeader.php')  ?>

    <!-- ...:::: Start Breadcrumb Section:::... -->
    <div class="breadcrumb-section breadcrumb-bg-color--golden">
        <div class="breadcrumb-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="breadcrumb-title">Login</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li>Home</li>
                                    <li>Shop</li>
                                    <li class="active" aria-current="page">Login</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- ...:::: End Breadcrumb Section:::... -->

    <!-- ...:::: Start Customer Login Section :::... -->
    <div class="customer-login">
        <div class="container" style="margin-left:450px;">
            <div class="row">
                <!--login area start-->
                <div class="col-lg-6 col-md-6">
                    <div class="account_form" data-aos="fade-up" data-aos-delay="0">
                        <h3 style="margin-left:200px;">Login</h3>
                        <form id="sign-in-form" class="sign-in-form" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                            <div class="default-form-box">
                                <label>Email</label>
                                <input type="text" id="email" name="email" required>
                                <span id="emailError" class="error"></span>
                            </div>
                            <div class="default-form-box">
                                <label>Password</label>
                                <input type="password" id="password" name="password" required>
                                <a href="#" class="forgot-password-link" id="forgotPasswordLink">Lost your password?</a>
                            </div>
                            <div class="login_submit" style="margin-left:200px;">
                                <button class="btn btn-md btn-black-default-hover mb-4" name="Login" id="submit">login</button>
                                <label class="checkbox-default mb-4" for="offer" style="margin-left:-90px;">
                                    <span><u><a href="cust_registration.php">No account? Create one here</a></u></span>
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
                <!--login area start-->

            </div>
        </div>
    </div> <!-- ...:::: End Customer Login Section :::... -->


    <!-- Start forgot password -->
    <div id="forgotPasswordModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h1>Find your password</h1>
            <p>Step 1: Enter your email address:</p>
            <form id="emailForm">
                <input type="email" name="email1" placeholder="Enter your email" required>
                <input type="hidden" name="usertype" value="user"> <!-- Adjust this value based on your needs -->
                <input type="submit" value="Next" class="btn btn-md btn-black-default-hover mb-4" id="sendOtpButton">
            </form>
        </div>
    </div>

    <div id="otpModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeOtpModal">&times;</span>
            <h1>Find your password</h1>
            <p>Step 2: Enter OTP:</p>
            <form id="otpForm">
                <input type="text" name="otp" placeholder="Enter the OTP" required>
                <input type="submit" class="btn btn-md btn-black-default-hover mb-4" value="Verify OTP">
            </form>
        </div>
    </div>

    <div id="changePasswordModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeChangePasswordModal">&times;</span>
            <h1>Find your password</h1>
            <p>Step 3: New Credentials</p>
            <form id="changePasswordForm" method="POST" action="set_password.php">
                <label for="newpwd">New Password:</label>
                <input type="password" name="newpwd" required>
                <label for="confirmpwd">Confirm Password:</label>
                <input type="password" name="confirmpwd" required>
                <input type="submit" class="btn btn-md btn-black-default-hover mb-4" name="save" value="Change Password">
            </form>
        </div>
    </div>

    <!--  End forgot password -->

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
        document.getElementById('forgotPasswordLink').onclick = function() {
            document.getElementById('forgotPasswordModal').style.display = 'block';
        }

        document.getElementById('closeModal').onclick = function() {
            document.getElementById('forgotPasswordModal').style.display = 'none';
        }

        document.getElementById('closeOtpModal').onclick = function() {
            document.getElementById('otpModal').style.display = 'none';
        }

        // Handle sending the OTP
        document.getElementById('sendOtpButton').onclick = function(event) {
            // Prevent the default form submission behavior
            event.preventDefault();

            const emailInput = document.querySelector('input[name="email1"]');
            const usertypeInput = document.querySelector('input[name="usertype"]');
            const email = emailInput.value.trim(); // Trim to remove extra spaces
            const usertype = usertypeInput.value;

            // Check if the email field is empty
            if (!email) {
                // Display an error message if email is blank
                alert('Please enter your email address.');
                emailInput.focus(); // Focus on the email input field
                return; // Stop further execution
            }
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            // Check if the email format is valid
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address.');
                emailInput.focus(); // Focus on the email input field
                return; // Stop further execution
            }


            // Proceed with the AJAX request to send the OTP
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'send_otp.php', true); // Adjust this to your PHP script
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = xhr.responseText;
                    if (response.includes('Message has been sent.')) {
                        // Close email modal and open OTP modal
                        document.getElementById('forgotPasswordModal').style.display = 'none';
                        document.getElementById('otpModal').style.display = 'block';
                        document.getElementById('otpEmail').value = email; // Pass the email to OTP modal
                    } else {
                        alert(response); // Display error message
                    }
                }
            };
            xhr.send('email=' + encodeURIComponent(email) + '&usertype=' + encodeURIComponent(usertype));
        };


        document.getElementById('otpForm').onsubmit = function(event) {
            event.preventDefault();
            const otp = document.querySelector('input[name="otp"]').value;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'verifyotp.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    // Close OTP modal and open Change Password modal
                    document.getElementById('otpModal').style.display = 'none';
                    document.getElementById('changePasswordModal').style.display = 'block';
                } else {
                    alert(response.message); // Show error message
                }
            };
            xhr.send('otp=' + encodeURIComponent(otp));
        }
    </script>

</body>
</html>